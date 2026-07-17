@extends('layouts.admin')

@section('content')

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-person-badge me-2"></i>Technicians Management
        </h1>
        <p class="page-hero-sub">Manage your field service technicians and their assignments</p>
    </div>
    <a href="{{ route('technicians.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Technician
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('technicians.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search name, email, phone, specialization..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3">
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
                <a href="{{ route('technicians.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 860px;">
            <thead>
                <tr>
                    <th style="width:56px;">#</th>
                    <th>Technician</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Specialization</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th class="text-end" style="width:200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($technicians as $key => $technician)
                    @php
                        $srNo = ($technicians instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($technicians->firstItem() + $key)
                            : ($key + 1);
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <div class="td-name">
                                <div class="td-avatar">{{ strtoupper(substr($technician->name, 0, 1)) }}</div>
                                <span>{{ $technician->name }}</span>
                            </div>
                        </td>
                        <td style="color:#6B7280;">{{ $technician->email ?? '—' }}</td>
                        <td style="color:#6B7280;">{{ $technician->phone ?? '—' }}</td>
                        <td style="color:#6B7280;">{{ $technician->specialization ?? '—' }}</td>
                        <td style="color:#6B7280;">{{ $technician->experience ?? '—' }}</td>
                        <td>
                            @if($technician->status == 'Active')
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('technicians.show', $technician->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('technicians.edit', $technician->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('technicians.destroy', $technician->id) }}" method="POST" class="delete-form d-inline m-0">
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
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-person-badge"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No records found</h6>
                                <p class="text-muted small mb-3">Adjust your search or add a new technician.</p>
                                <a href="{{ route('technicians.create') }}" class="btn-add-primary" style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Technician
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($technicians instanceof \Illuminate\Pagination\LengthAwarePaginator && $technicians->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $technicians->firstItem() }}–{{ $technicians->lastItem() }} of {{ $technicians->total() }} technicians
            </span>
            {{ $technicians->links() }}
        </div>
    @endif
</div>

@endsection
