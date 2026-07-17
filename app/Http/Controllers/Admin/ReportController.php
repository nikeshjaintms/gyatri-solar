<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Models\Customer;
use App\Models\Technician;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\JobAssignment;
use App\Models\JobStatusTracking;
use App\Models\Invoice;

class ReportController extends Controller
{
    /* ─────────────────────────────────────────────
       Helper: safely count a model query
    ───────────────────────────────────────────── */
    private function safeCount(callable $query, int $default = 0): int
    {
        try {
            return $query();
        } catch (\Throwable $e) {
            return $default;
        }
    }

    private function safeSum(callable $query, float $default = 0): float
    {
        try {
            return (float) $query();
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /* ─────────────────────────────────────────────
       index() — Dashboard Summary
    ───────────────────────────────────────────── */
    public function index()
    {
        $stats = [
            'total_customers'     => $this->safeCount(fn() => Customer::count()),
            'total_technicians'   => $this->safeCount(fn() => Technician::count()),
            'total_services'      => $this->safeCount(fn() => Service::count()),

            'total_requests'      => $this->safeCount(fn() => ServiceRequest::count()),
            'pending_requests'    => $this->safeCount(fn() => ServiceRequest::where('status', 'Pending')->count()),
            'completed_requests'  => $this->safeCount(fn() => ServiceRequest::where('status', 'Completed')->count()),

            'total_jobs'          => $this->safeCount(fn() => JobAssignment::count()),
            'completed_jobs'      => $this->safeCount(fn() => JobAssignment::where('status', 'Completed')->count()),

            'total_invoices'      => $this->safeCount(fn() => Invoice::count()),
            'total_revenue'       => $this->safeSum(fn() => Invoice::sum('total_amount')),
            'paid_amount'         => $this->safeSum(fn() => Invoice::sum('paid_amount')),
            'pending_amount'      => $this->safeSum(fn() => Invoice::sum('balance_amount')),
        ];

        return view('admin.reports.index', compact('stats'));
    }

    /* ─────────────────────────────────────────────
       serviceRequests()
    ───────────────────────────────────────────── */
    public function serviceRequests(Request $request)
    {
        try {
            $query = ServiceRequest::with(['customer', 'service', 'technician'])
                ->orderByDesc('request_date');

            if ($request->filled('from_date')) {
                $query->whereDate('request_date', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $query->whereDate('request_date', '<=', $request->to_date);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('priority')) {
                $query->where('priority', $request->priority);
            }

            $records = $query->get();
        } catch (\Throwable $e) {
            $records = collect();
        }

        $statuses  = ['Pending', 'Assigned', 'In Progress', 'Completed', 'Cancelled'];
        $priorities = ['Low', 'Medium', 'High', 'Urgent'];

        return view('admin.reports.service_requests', compact('records', 'statuses', 'priorities'));
    }

    /* ─────────────────────────────────────────────
       jobAssignments()
    ───────────────────────────────────────────── */
    public function jobAssignments(Request $request)
    {
        try {
            $query = JobAssignment::with(['serviceRequest.customer', 'serviceRequest.service', 'technician'])
                ->orderByDesc('assigned_date');

            if ($request->filled('from_date')) {
                $query->whereDate('assigned_date', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $query->whereDate('assigned_date', '<=', $request->to_date);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('technician_id')) {
                $query->where('technician_id', $request->technician_id);
            }

            $records = $query->get();
        } catch (\Throwable $e) {
            $records = collect();
        }

        try {
            $technicians = Technician::orderBy('name')->get();
        } catch (\Throwable $e) {
            $technicians = collect();
        }

        $statuses   = ['Pending', 'In Progress', 'Completed', 'Cancelled'];
        $priorities = ['Low', 'Medium', 'High', 'Urgent'];

        return view('admin.reports.job_assignments', compact('records', 'technicians', 'statuses', 'priorities'));
    }

    /* ─────────────────────────────────────────────
       invoices()
    ───────────────────────────────────────────── */
    public function invoices(Request $request)
    {
        try {
            $query = Invoice::with(['customer', 'service'])
                ->orderByDesc('invoice_date');

            if ($request->filled('from_date')) {
                $query->whereDate('invoice_date', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $query->whereDate('invoice_date', '<=', $request->to_date);
            }
            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }
            if ($request->filled('payment_mode')) {
                $query->where('payment_mode', $request->payment_mode);
            }

            $records = $query->get();
        } catch (\Throwable $e) {
            $records = collect();
        }

        $paymentStatuses = ['Unpaid', 'Partial', 'Paid'];
        $paymentModes    = ['Cash', 'Bank Transfer', 'Cheque', 'UPI', 'Card', 'Online'];

        return view('admin.reports.invoices', compact('records', 'paymentStatuses', 'paymentModes'));
    }

    /* ─────────────────────────────────────────────
       payments()
    ───────────────────────────────────────────── */
    public function payments(Request $request)
    {
        try {
            $query = Invoice::with(['customer'])
                ->orderByDesc('invoice_date');

            if ($request->filled('from_date')) {
                $query->whereDate('invoice_date', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $query->whereDate('invoice_date', '<=', $request->to_date);
            }
            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }
            if ($request->filled('payment_mode')) {
                $query->where('payment_mode', $request->payment_mode);
            }

            $records = $query->get();

            $summary = [
                'total_invoice_amount' => $records->sum('total_amount'),
                'total_paid_amount'    => $records->sum('paid_amount'),
                'total_balance_amount' => $records->sum('balance_amount'),
                'paid_count'           => $records->where('payment_status', 'Paid')->count(),
                'unpaid_count'         => $records->where('payment_status', 'Unpaid')->count(),
            ];
        } catch (\Throwable $e) {
            $records = collect();
            $summary = [
                'total_invoice_amount' => 0,
                'total_paid_amount'    => 0,
                'total_balance_amount' => 0,
                'paid_count'           => 0,
                'unpaid_count'         => 0,
            ];
        }

        $paymentStatuses = ['Unpaid', 'Partial', 'Paid'];
        $paymentModes    = ['Cash', 'Bank Transfer', 'Cheque', 'UPI', 'Card', 'Online'];

        return view('admin.reports.payments', compact('records', 'summary', 'paymentStatuses', 'paymentModes'));
    }
}
