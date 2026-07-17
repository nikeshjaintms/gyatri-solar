<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Technician;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of service requests.
     */
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['customer', 'service', 'technician']);

        // Search by customer name, service name, or technician name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', fn($c) => $c->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('service',  fn($s) => $s->where('service_name', 'like', "%{$search}%"))
                  ->orWhereHas('technician', fn($t) => $t->where('name', 'like', "%{$search}%"));
            });
        }

        // Status filter
        $validStatuses = ['Pending', 'Assigned', 'In Progress', 'Completed', 'Cancelled'];
        if ($request->filled('status') && in_array($request->status, $validStatuses)) {
            $query->where('status', $request->status);
        }

        // Priority filter
        $validPriorities = ['Low', 'Medium', 'High', 'Urgent'];
        if ($request->filled('priority') && in_array($request->priority, $validPriorities)) {
            $query->where('priority', $request->priority);
        }

        $serviceRequests = $query->latest()->paginate(10)->withQueryString();

        return view('admin.service_requests.index', compact('serviceRequests'));
    }

    /**
     * Show the form for creating a new service request.
     */
    public function create()
    {
        $customers   = Customer::where('status', 'Active')->orderBy('name')->get();
        $services    = Service::where('status', 'Active')->orderBy('service_name')->get();
        $technicians = Technician::where('status', 'Active')->orderBy('name')->get();

        return view('admin.service_requests.create', compact('customers', 'services', 'technicians'));
    }

    /**
     * Store a newly created service request in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'   => ['required', 'exists:customers,id'],
            'service_id'    => ['required', 'exists:services,id'],
            'technician_id' => ['nullable', 'exists:technicians,id'],
            'request_date'  => ['required', 'date'],
            'service_date'  => ['nullable', 'date', 'after_or_equal:request_date'],
            'priority'      => ['required', 'in:Low,Medium,High,Urgent'],
            'status'        => ['required', 'in:Pending,Assigned,In Progress,Completed,Cancelled'],
            'address'       => ['nullable', 'string', 'max:1000'],
            'description'   => ['nullable', 'string', 'max:5000'],
            'remarks'       => ['nullable', 'string', 'max:5000'],
        ]);

        $data = $request->all();
        if (isset($data['address'])) $data['address'] = trim(strip_tags($data['address']));
        if (isset($data['description'])) $data['description'] = trim(strip_tags($data['description']));
        if (isset($data['remarks'])) $data['remarks'] = trim(strip_tags($data['remarks']));

        ServiceRequest::create($data);

        return redirect()->route('service-requests.index')
                         ->with('success', 'Service request created successfully.');
    }

    /**
     * Display the specified service request.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['customer', 'service', 'technician']);

        return view('admin.service_requests.show', compact('serviceRequest'));
    }

    /**
     * Show the form for editing the specified service request.
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        $customers   = Customer::orderBy('name')->get();
        $services    = Service::orderBy('service_name')->get();
        $technicians = Technician::orderBy('name')->get();

        return view('admin.service_requests.edit', compact('serviceRequest', 'customers', 'services', 'technicians'));
    }

    /**
     * Update the specified service request in storage.
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'customer_id'   => ['required', 'exists:customers,id'],
            'service_id'    => ['required', 'exists:services,id'],
            'technician_id' => ['nullable', 'exists:technicians,id'],
            'request_date'  => ['required', 'date'],
            'service_date'  => ['nullable', 'date', 'after_or_equal:request_date'],
            'priority'      => ['required', 'in:Low,Medium,High,Urgent'],
            'status'        => ['required', 'in:Pending,Assigned,In Progress,Completed,Cancelled'],
            'address'       => ['nullable', 'string', 'max:1000'],
            'description'   => ['nullable', 'string', 'max:5000'],
            'remarks'       => ['nullable', 'string', 'max:5000'],
        ]);

        $data = $request->all();
        if (isset($data['address'])) $data['address'] = trim(strip_tags($data['address']));
        if (isset($data['description'])) $data['description'] = trim(strip_tags($data['description']));
        if (isset($data['remarks'])) $data['remarks'] = trim(strip_tags($data['remarks']));

        $serviceRequest->update($data);

        return redirect()->route('service-requests.index')
                         ->with('success', 'Service request updated successfully.');
    }

    /**
     * Remove the specified service request from storage.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        try {
            if ($serviceRequest->jobAssignment()->exists()) {
                return redirect()->route('service-requests.index')->with('error', 'Cannot delete service request because it has active job assignments.');
            }
            $serviceRequest->delete();
            return redirect()->route('service-requests.index')->with('success', 'Service request deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('service-requests.index')->with('error', 'Delete failed. Please try again.');
        }
    }
}
