<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('city', 'like', '%' . $search . '%')
                  ->orWhere('pincode', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('customer_type') && in_array($request->customer_type, ['Residential', 'Commercial', 'Other'])) {
            $query->where('customer_type', $request->customer_type);
        }

        if ($request->filled('status') && in_array($request->status, ['Active', 'Inactive'])) {
            $query->where('status', $request->status);
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-\(\)]+$/'],
            'email' => ['nullable', 'email', 'max:255', 'unique:customers,email'],
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/', 'unique:customers,phone'],
            'customer_type' => ['required', 'in:Residential,Commercial,Other'],
            'address' => ['nullable', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'regex:/^[0-9]{6}$/'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        $data = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $data);

        $customer = Customer::create($data);

        return redirect()->route('customers.show', $customer->id)->with('success', 'Customer added successfully. You can now manage Site Surveys, Quotations, and Job Assignments below.');
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'siteSurveys.surveyor',
            'projects',
            'payments',
            'quotations.items',
            'serviceRequests.service',
            'serviceRequests.technician',
            'serviceRequests.jobAssignments.technician',
            'serviceRequests.jobAssignments.jobStatusTrackings',
            'invoices'
        ]);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-\(\)]+$/'],
            'email' => ['nullable', 'email', 'max:255', 'unique:customers,email,' . $customer->id],
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/', 'unique:customers,phone,' . $customer->id],
            'customer_type' => ['required', 'in:Residential,Commercial,Other'],
            'address' => ['nullable', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'regex:/^[0-9]{6}$/'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        $data = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $data);

        $customer->update($data);
        $customer->projects()->update(['customer_type' => $customer->customer_type]);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->projects()->exists() || $customer->payments()->exists() || $customer->serviceRequests()->exists() || $customer->invoices()->exists() || $customer->quotations()->exists() || $customer->siteSurveys()->exists()) {
            return redirect()->route('customers.index')->with('error', 'Cannot delete customer because they have linked projects, quotations, payments, or service records.');
        }
        try {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Delete failed. Please try again.');
        }
    }
}