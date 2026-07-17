<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(Request $request)
    {
        $query = Service::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('service_name', 'like', '%' . $search . '%')
                  ->orWhere('service_code', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->filled('status') && in_array($request->status, ['Active', 'Inactive'])) {
            $query->where('status', $request->status);
        }

        $services = $query->latest()->paginate(10)->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'service_code' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z0-9\-\_]+$/', 'unique:services,service_code'],
            'category'     => ['nullable', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'duration'     => ['nullable', 'string', 'max:100'],
            'description'  => ['nullable', 'string', 'max:5000'],
            'status'       => ['required', 'in:Active,Inactive'],
        ]);

        $data = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $data);

        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'service_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'service_code' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z0-9\-\_]+$/', 'unique:services,service_code,' . $service->id],
            'category'     => ['nullable', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'duration'     => ['nullable', 'string', 'max:100'],
            'description'  => ['nullable', 'string', 'max:5000'],
            'status'       => ['required', 'in:Active,Inactive'],
        ]);

        $data = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $data);

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        try {
            if ($service->serviceRequests()->exists()) {
                return redirect()->route('services.index')->with('error', 'Cannot delete service because it is associated with service requests.');
            }
            $service->delete();
            return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('error', 'Delete failed. Please try again.');
        }
    }
}
