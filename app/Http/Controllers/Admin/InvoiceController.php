<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\JobAssignment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /* ── Computed fields helper ── */
    private function computeAmounts(array $data): array
    {
        $subtotal   = (float) ($data['subtotal']    ?? 0);
        $discount   = (float) ($data['discount']    ?? 0);
        $tax        = (float) ($data['tax']         ?? 0);
        $paidAmount = (float) ($data['paid_amount'] ?? 0);

        $total   = max(0, $subtotal - $discount + $tax);
        $balance = max(0, $total - $paidAmount);

        $status = 'Unpaid';
        if ($paidAmount >= $total && $total > 0) {
            $status = 'Paid';
        } elseif ($paidAmount > 0) {
            $status = 'Partially Paid';
        }

        // Allow manual override to Cancelled
        if (isset($data['payment_status']) && $data['payment_status'] === 'Cancelled') {
            $status = 'Cancelled';
        }

        return [
            'total_amount'   => $total,
            'balance_amount' => $balance,
            'payment_status' => $status,
        ];
    }

    /* ─── index ─── */
    public function index(Request $request)
    {
        $query = Invoice::with(['customer', 'service']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('invoice_no', 'like', "%{$s}%")
                  ->orWhereHas('customer', fn($c) => $c->where('name', 'like', "%{$s}%"))
                  ->orWhereHas('service',  fn($sv) => $sv->where('service_name', 'like', "%{$s}%"));
            });
        }

        $validStatuses = ['Unpaid', 'Partially Paid', 'Paid', 'Cancelled'];
        if ($request->filled('payment_status') && in_array($request->payment_status, $validStatuses)) {
            $query->where('payment_status', $request->payment_status);
        }

        $validModes = ['Cash', 'UPI', 'Bank Transfer', 'Cheque', 'Card'];
        if ($request->filled('payment_mode') && in_array($request->payment_mode, $validModes)) {
            $query->where('payment_mode', $request->payment_mode);
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    /* ─── create ─── */
    public function create()
    {
        $customers       = Customer::orderBy('name')->get();
        $services        = Service::where('status', 'Active')->orderBy('service_name')->get();
        $serviceRequests = ServiceRequest::with(['customer', 'service'])
                            ->whereNotIn('status', ['Cancelled'])
                            ->orderBy('request_date', 'desc')->get();
        $jobAssignments  = JobAssignment::with(['serviceRequest.customer', 'serviceRequest.service', 'technician'])
                            ->orderBy('assigned_date', 'desc')->get();
        $invoiceNo       = Invoice::generateInvoiceNo();

        return view('admin.invoices.create', compact(
            'customers', 'services', 'serviceRequests', 'jobAssignments', 'invoiceNo'
        ));
    }

    /* ─── store ─── */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'        => ['required', 'exists:customers,id'],
            'service_id'         => ['nullable', 'exists:services,id'],
            'service_request_id' => ['nullable', 'exists:service_requests,id'],
            'job_assignment_id'  => ['nullable', 'exists:job_assignments,id'],
            'invoice_date'       => ['required', 'date'],
            'due_date'           => ['nullable', 'date', 'after_or_equal:invoice_date'],
            'subtotal'           => ['required', 'numeric', 'min:0'],
            'discount'           => ['nullable', 'numeric', 'min:0'],
            'tax'                => ['nullable', 'numeric', 'min:0'],
            'paid_amount'        => ['nullable', 'numeric', 'min:0'],
            'payment_mode'       => ['nullable', 'string', 'in:Cash,UPI,Bank Transfer,Cheque,Card'],
            'notes'              => ['nullable', 'string', 'max:5000'],
        ]);

        $data = $request->all();
        if (isset($data['notes'])) {
            $data['notes'] = trim(strip_tags($data['notes']));
        }
        $computed = $this->computeAmounts($data);

        Invoice::create(array_merge($data, $computed, [
            'invoice_no' => Invoice::generateInvoiceNo(),
        ]));

        return redirect()->route('invoices.index')
                         ->with('success', 'Invoice created successfully.');
    }

    /* ─── show ─── */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'service', 'serviceRequest', 'jobAssignment.technician']);
        return view('admin.invoices.show', compact('invoice'));
    }

    /* ─── edit ─── */
    public function edit(Invoice $invoice)
    {
        $customers       = Customer::orderBy('name')->get();
        $services        = Service::orderBy('service_name')->get();
        $serviceRequests = ServiceRequest::with(['customer', 'service'])
                            ->orderBy('request_date', 'desc')->get();
        $jobAssignments  = JobAssignment::with(['serviceRequest.customer', 'serviceRequest.service', 'technician'])
                            ->orderBy('assigned_date', 'desc')->get();

        return view('admin.invoices.edit', compact(
            'invoice', 'customers', 'services', 'serviceRequests', 'jobAssignments'
        ));
    }

    /* ─── update ─── */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id'        => ['required', 'exists:customers,id'],
            'service_id'         => ['nullable', 'exists:services,id'],
            'service_request_id' => ['nullable', 'exists:service_requests,id'],
            'job_assignment_id'  => ['nullable', 'exists:job_assignments,id'],
            'invoice_date'       => ['required', 'date'],
            'due_date'           => ['nullable', 'date', 'after_or_equal:invoice_date'],
            'subtotal'           => ['required', 'numeric', 'min:0'],
            'discount'           => ['nullable', 'numeric', 'min:0'],
            'tax'                => ['nullable', 'numeric', 'min:0'],
            'paid_amount'        => ['nullable', 'numeric', 'min:0'],
            'payment_mode'       => ['nullable', 'string', 'in:Cash,UPI,Bank Transfer,Cheque,Card'],
            'notes'              => ['nullable', 'string', 'max:5000'],
        ]);

        $data = $request->all();
        if (isset($data['notes'])) {
            $data['notes'] = trim(strip_tags($data['notes']));
        }
        $computed = $this->computeAmounts($data);

        $invoice->update(array_merge($data, $computed));

        return redirect()->route('invoices.index')
                         ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
            return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Delete failed. Please try again.');
        }
    }
}
