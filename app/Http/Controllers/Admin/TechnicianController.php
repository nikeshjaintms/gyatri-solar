<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Technician::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('specialization', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->filled('status') && in_array($request->status, ['Active', 'Inactive'])) {
            $query->where('status', $request->status);
        }

        $technicians = $query->latest()->paginate(10)->withQueryString();

        return view('admin.technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.technicians.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'email' => ['nullable', 'email', 'max:255', 'unique:technicians,email'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:technicians,phone'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        $data = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $data);

        Technician::create($data);

        return redirect()->route('technicians.index')->with('success', 'Technician created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        return view('admin.technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technician $technician)
    {
        return view('admin.technicians.edit', compact('technician'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\.\-]+$/'],
            'email' => ['nullable', 'email', 'max:255', 'unique:technicians,email,' . $technician->id],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:technicians,phone,' . $technician->id],
            'specialization' => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        $data = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $data);

        $technician->update($data);

        return redirect()->route('technicians.index')->with('success', 'Technician updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        try {
            if ($technician->jobAssignments()->exists()) {
                return redirect()->route('technicians.index')->with('error', 'Cannot delete technician because they have active job assignments.');
            }
            $technician->delete();
            return redirect()->route('technicians.index')->with('success', 'Technician deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('technicians.index')->with('error', 'Delete failed. Please try again.');
        }
    }
}