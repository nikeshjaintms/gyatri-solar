<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    private const MODES = ['Cash', 'Mobile Banking', 'RTGS', 'NEFT', 'Other'];

    public function index(Request $request)
    {
        $request->validate([
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
        ]);

        $query = Payment::with(['customer', 'project']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($builder) use ($search) {
                $builder->where('payment_number', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn ($customer) => $customer->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('project', fn ($project) => $project->where('project_name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('payment_mode') && in_array($request->payment_mode, self::MODES)) {
            $query->where('payment_mode', $request->payment_mode);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }

        $payments = $query->latest('payment_date')->paginate(10)->withQueryString();
        $totalPaid = (clone $query)->sum('amount');
        $projectsWithQuotations = Project::with(['quotations' => fn ($quotation) => $quotation->where('status', 'Accepted')->latest('id')])->get();
        $totalProjectAmount = $projectsWithQuotations->sum(fn ($project) => (float) ($project->quotations->first()?->grand_total ?? 0));
        $totalProjectPaid = Payment::whereNotNull('project_id')->sum('amount');
        $pendingProjectAmount = max(0, $totalProjectAmount - $totalProjectPaid);

        return view('admin.payments.index', compact('payments', 'totalPaid', 'totalProjectAmount', 'totalProjectPaid', 'pendingProjectAmount'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $projects = Project::with('customer')->orderBy('project_name')->get();
        $payment = new Payment();
        $paymentNumber = Payment::generateNumber();

        return view('admin.payments.create', compact('customers', 'projects', 'payment', 'paymentNumber'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['payment_number'] = Payment::generateNumber();
        $payment = Payment::create($data);

        return redirect()->route('payments.show', $payment)->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['customer', 'project']);

        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $customers = Customer::orderBy('name')->get();
        $projects = Project::with('customer')->orderBy('project_name')->get();
        $paymentNumber = $payment->payment_number;

        return view('admin.payments.edit', compact('customers', 'projects', 'payment', 'paymentNumber'));
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->update($this->validatedData($request));

        return redirect()->route('payments.show', $payment)->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'project_id' => ['nullable', Rule::exists('projects', 'id')->where('customer_id', $request->input('customer_id'))],
            'payment_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0', 'max:9999999999.99'],
            'payment_mode' => ['required', Rule::in(self::MODES)],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }
}