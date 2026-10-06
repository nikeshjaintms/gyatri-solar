<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('customer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($builder) use ($search) {
                $builder->where('project_name', 'like', "%{$search}%")
                    ->orWhereHas('customer', fn ($customer) => $customer->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status') && in_array($request->status, ['New', 'In Progress', 'Completed', 'Cancelled'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_type') && in_array($request->customer_type, ['Residential', 'Commercial', 'Other'])) {
            $query->where('customer_type', $request->customer_type);
        }

        $projects = $query->latest()->paginate(10)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'Active')->orderBy('name')->get();
        $project = new Project();

        return view('admin.projects.create', compact('customers', 'project'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['customer_type'] = Customer::findOrFail($data['customer_id'])->customer_type;
        $project = Project::create($data);

        return redirect()->route('projects.show', $project)->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load(['customer', 'quotations', 'payments', 'serviceRequests']);

        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $customers = Customer::orderBy('name')->get();

        return view('admin.projects.edit', compact('customers', 'project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validatedData($request);
        $data['customer_type'] = Customer::findOrFail($data['customer_id'])->customer_type;
        $project->update($data);

        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->quotations()->exists() || $project->invoices()->exists() || $project->payments()->exists() || $project->serviceRequests()->exists()) {
            return redirect()->route('projects.index')->with('error', 'This project has linked records and cannot be deleted.');
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'project_name' => ['required', 'string', 'max:255'],
            'customer_id' => ['required', 'exists:customers,id'],
            'solar_capacity' => ['required', 'numeric', 'gt:0', 'max:999999.99'],
            'installation_address' => ['required', 'string', 'max:2000'],
            'status' => ['required', 'in:New,In Progress,Completed,Cancelled'],
            'start_date' => ['nullable', 'date'],
            'completion_date' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $completionDate = $value ? strtotime($value) : false;
                    $startDate = $request->filled('start_date') ? strtotime($request->input('start_date')) : false;

                    if ($completionDate !== false && $startDate !== false && $completionDate < $startDate) {
                        $fail('The completion date must be on or after the start date.');
                    }
                },
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }
}