<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Technician;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\JobAssignment;
use App\Models\JobStatusTracking;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        /* ── Safe helpers ── */
        $cnt = fn(callable $q, int $d = 0): int => $this->safe($q, $d);
        $sum = fn(callable $q): float            => $this->safe($q, 0.0);

        /* ── KPI counts ── */
        $stats = [
            // People & services
            'total_customers'   => $cnt(fn() => Customer::count()),
            'total_technicians' => $cnt(fn() => Technician::count()),
            'total_services'    => $cnt(fn() => Service::count()),

            // Service requests
            'total_requests'    => $cnt(fn() => ServiceRequest::count()),
            'pending_requests'  => $cnt(fn() => ServiceRequest::where('status', 'Pending')->count()),
            'assigned_requests' => $cnt(fn() => ServiceRequest::where('status', 'Assigned')->count()),
            'inprogress_jobs'   => $cnt(fn() => ServiceRequest::where('status', 'In Progress')->count()),
            'completed_jobs'    => $cnt(fn() => ServiceRequest::where('status', 'Completed')->count()),

            // Invoices
            'total_invoices'    => $cnt(fn() => Invoice::count()),
            'total_revenue'     => $sum(fn() => Invoice::sum('total_amount')),
            'paid_amount'       => $sum(fn() => Invoice::sum('paid_amount')),
            'pending_amount'    => $sum(fn() => Invoice::sum('balance_amount')),
        ];

        /* ── Service Request breakdown ── */
        $srSummary = [
            'Pending'     => $cnt(fn() => ServiceRequest::where('status', 'Pending')->count()),
            'Assigned'    => $cnt(fn() => ServiceRequest::where('status', 'Assigned')->count()),
            'In Progress' => $cnt(fn() => ServiceRequest::where('status', 'In Progress')->count()),
            'Completed'   => $cnt(fn() => ServiceRequest::where('status', 'Completed')->count()),
            'Cancelled'   => $cnt(fn() => ServiceRequest::where('status', 'Cancelled')->count()),
        ];

        /* ── Job Assignment breakdown ── */
        $jaSummary = [
            'Assigned'    => $cnt(fn() => JobAssignment::where('status', 'Assigned')->count()),
            'Accepted'    => $cnt(fn() => JobAssignment::where('status', 'Accepted')->count()),
            'In Progress' => $cnt(fn() => JobAssignment::where('status', 'In Progress')->count()),
            'Completed'   => $cnt(fn() => JobAssignment::where('status', 'Completed')->count()),
            'Cancelled'   => $cnt(fn() => JobAssignment::where('status', 'Cancelled')->count()),
        ];

        /* ── Payment breakdown ── */
        $paySummary = [
            'total_amount'   => $sum(fn() => Invoice::sum('total_amount')),
            'total_paid'     => $sum(fn() => Invoice::sum('paid_amount')),
            'total_balance'  => $sum(fn() => Invoice::sum('balance_amount')),
            'paid_count'     => $cnt(fn() => Invoice::where('payment_status', 'Paid')->count()),
            'unpaid_count'   => $cnt(fn() => Invoice::where('payment_status', 'Unpaid')->count()),
            'partial_count'  => $cnt(fn() => Invoice::where('payment_status', 'Partial')->count()),
        ];

        /* ── Recent records ── */
        $recentRequests = $this->safe(
            fn() => ServiceRequest::with(['customer', 'service', 'technician'])
                ->latest()->limit(5)->get(),
            collect()
        );

        $recentJobs = $this->safe(
            fn() => JobAssignment::with(['serviceRequest.customer', 'serviceRequest.service', 'technician'])
                ->latest()->limit(5)->get(),
            collect()
        );

        $recentInvoices = $this->safe(
            fn() => Invoice::with(['customer'])
                ->latest()->limit(5)->get(),
            collect()
        );

        return view('admin.dashboard', compact(
            'stats',
            'srSummary',
            'jaSummary',
            'paySummary',
            'recentRequests',
            'recentJobs',
            'recentInvoices'
        ));
    }

    private function safe(callable $query, mixed $default = 0): mixed
    {
        try {
            return $query();
        } catch (\Throwable $e) {
            return $default;
        }
    }
}
