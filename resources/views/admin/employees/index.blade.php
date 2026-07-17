@extends('layouts.admin')

@section('content')

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-person-workspace me-2"></i>Employees Management
        </h1>
        <p class="page-hero-sub">Manage Gayatri Solar Energy staff records, credentials, designations, and departments</p>
    </div>
    <a href="{{ route('employees.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Employee
    </a>
</div>

{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('employees.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search Employee ID, Name, Email, Mobile..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                    <select name="department" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Active"   {{ request('status') == 'Active'   ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('employees.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 1000px;">
            <thead>
                <tr>
                    <th style="width:70px;">ID</th>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Mobile</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th class="text-end" style="width:280px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>
                            <span style="display: inline-block; background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 6px; color: #212529; font-weight: 600; font-size: 14px; padding: 4px 10px;">
                                {{ $employee->employee_id }}
                            </span>
                        </td>
                        <td>
                            @if($employee->user && $employee->user->profile_photo)
                                <img src="{{ asset('storage/' . $employee->user->profile_photo) }}" 
                                     alt="{{ $employee->user->name }}" 
                                     class="rounded-circle border" 
                                     style="width: 38px; height: 38px; object-fit: cover;">
                            @else
                                <div class="td-avatar">
                                    {{ strtoupper(substr($employee->user->name ?? 'E', 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">
                                {{ $employee->user->name ?? '—' }}
                            </div>
                        </td>
                        <td style="color:#6B7280;">{{ $employee->user->email ?? '—' }}</td>
                        <td style="color:#6B7280;">{{ $employee->user->mobile_number ?? '—' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.8rem;">
                                {{ $employee->department }}
                            </span>
                        </td>
                        <td style="color:#4B5563; font-weight: 500;">{{ $employee->designation }}</td>
                        <td>
                            @if($employee->user && $employee->user->status == 'Active')
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group justify-content-end">
                                {{-- Status Toggle Form --}}
                                <form action="{{ route('employees.toggle-status', $employee->id) }}" method="POST" class="d-inline m-0">
                                    @csrf
                                    <button type="submit" class="btn-action {{ $employee->user && $employee->user->status == 'Active' ? 'btn-outline-secondary' : 'btn-outline-success' }}" 
                                            title="Toggle Active/Inactive" style="font-size: 0.75rem; padding: 5px 10px;">
                                        @if($employee->user && $employee->user->status == 'Active')
                                            <i class="bi bi-shield-x"></i> Deactivate
                                        @else
                                            <i class="bi bi-shield-check"></i> Activate
                                        @endif
                                    </button>
                                </form>

                                <a href="{{ route('employees.show', $employee->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="delete-form d-inline m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-action-delete">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-person-workspace"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No employee records found</h6>
                                <p class="text-muted small mb-3">Adjust your search or add a new employee.</p>
                                <a href="{{ route('employees.create') }}" class="btn-add-primary"
                                   style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Employee
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($employees instanceof \Illuminate\Pagination\LengthAwarePaginator && $employees->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $employees->firstItem() }}–{{ $employees->lastItem() }} of {{ $employees->total() }} employees
            </span>
            {{ $employees->links() }}
        </div>
    @endif
</div>

@endsection
