<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    /**
     * Display a listing of enquiries.
     */
    public function index(Request $request)
    {
        $query = Enquiry::with(['customer', 'assignedEmployee']);

        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('enquiry_number', 'like', '%' . $search . '%')
                  ->orWhere('customer_name', 'like', '%' . $search . '%')
                  ->orWhere('mobile_number', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Assigned employee filter
        if ($request->filled('assigned_employee_id')) {
            $query->where('assigned_employee_id', $request->assigned_employee_id);
        }

        // Enquiry date filter
        if ($request->filled('enquiry_date')) {
            $query->whereDate('enquiry_date', $request->enquiry_date);
        }

        // From/To Date range
        if ($request->filled('from_date')) {
            $query->whereDate('enquiry_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('enquiry_date', '<=', $request->to_date);
        }

        $enquiries = $query->latest('id')->paginate(10)->withQueryString();
        $employees = User::orderBy('name')->get();

        return view('admin.enquiries.index', compact('enquiries', 'employees'));
    }

    /**
     * Show the form for creating a new enquiry.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $employees = User::orderBy('name')->get();
        
        // Auto-generate Enquiry Number
        $latest = Enquiry::latest('id')->first();
        $nextId = $latest ? ($latest->id + 1) : 1;
        $enquiryNumber = 'ENQ-' . date('Ym') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('admin.enquiries.create', compact('customers', 'employees', 'enquiryNumber'));
    }

    /**
     * Store a newly created enquiry.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'enquiry_number' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-\_]+$/', 'unique:enquiries,enquiry_number'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'customer_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'enquiry_date' => ['required', 'date'],
            'service_product' => ['required', 'string', 'max:255'],
            'enquiry_source' => ['nullable', 'string', 'max:100'],
            'assigned_employee_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:New,Contacted,Follow-up,Converted,Closed,Cancelled'],
            'follow_up_date' => ['nullable', 'date', 'after_or_equal:enquiry_date'],
            'remarks' => ['nullable', 'string', 'max:5000'],
        ]);

        $data = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $data);

        Enquiry::create($data);

        return redirect()->route('enquiries.index')->with('success', 'Enquiry recorded successfully.');
    }

    /**
     * Display the specified enquiry.
     */
    public function show(string $id)
    {
        $enquiry = Enquiry::with(['customer', 'assignedEmployee'])->findOrFail($id);
        return view('admin.enquiries.show', compact('enquiry'));
    }

    /**
     * Show the form for editing the specified enquiry.
     */
    public function edit(string $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $customers = Customer::orderBy('name')->get();
        $employees = User::orderBy('name')->get();

        return view('admin.enquiries.edit', compact('enquiry', 'customers', 'employees'));
    }

    /**
     * Update the specified enquiry.
     */
    public function update(Request $request, string $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        $data = $request->validate([
            'enquiry_number' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-\_]+$/', Rule::unique('enquiries', 'enquiry_number')->ignore($enquiry->id)],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'customer_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'enquiry_date' => ['required', 'date'],
            'service_product' => ['required', 'string', 'max:255'],
            'enquiry_source' => ['nullable', 'string', 'max:100'],
            'assigned_employee_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:New,Contacted,Follow-up,Converted,Closed,Cancelled'],
            'follow_up_date' => ['nullable', 'date', 'after_or_equal:enquiry_date'],
            'remarks' => ['nullable', 'string', 'max:5000'],
        ]);

        $data = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $data);

        $enquiry->update($data);

        return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully.');
    }

    /**
     * Remove the specified enquiry.
     */
    public function destroy(string $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        // Prevent delete if linked with Quotation or Site Survey
        if ($enquiry->quotation()->exists() || $enquiry->siteSurveys()->exists()) {
            return redirect()->route('enquiries.index')->with('error', 'Cannot delete enquiry because it is linked to quotations or surveys.');
        }

        $enquiry->delete();

        return redirect()->route('enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }

    /**
     * Get details of an enquiry for AJAX dropdown populate.
     */
    public function getDetails(string $id)
    {
        $enquiry = Enquiry::with('customer')->findOrFail($id);
        return response()->json([
            'customer_id' => $enquiry->customer_id,
            'customer_name' => $enquiry->customer_name,
            'mobile_number' => $enquiry->mobile_number,
            'email' => $enquiry->email,
            'address' => $enquiry->address,
            'service_product' => $enquiry->service_product,
        ]);
    }
}
