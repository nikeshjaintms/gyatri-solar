@extends('layouts.admin')

@section('content')

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-people me-2"></i>Customers Management
        </h1>
        <p class="page-hero-sub">Manage your solar energy clients and their contact details</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Customer
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('customers.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search customer name, email, phone, city..."
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
                <a href="{{ route('customers.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 820px;">
            <thead>
                <tr>
                    <th style="width:56px;">#</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Status</th>
                    <th class="text-end" style="width:200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $key => $customer)
                    @php
                        $srNo = ($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($customers->firstItem() + $key)
                            : ($key + 1);
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <div class="td-name">
                                <div class="td-avatar">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                                <span>{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td style="color:#6B7280;">{{ $customer->email ?? '—' }}</td>
                        <td style="color:#6B7280;">{{ $customer->phone ?? '—' }}</td>
                        <td style="color:#6B7280;">{{ $customer->city ?? '—' }}</td>
                        <td>
                            @if($customer->status == 'Active')
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="delete-form d-inline m-0">
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
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-people"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No records found</h6>
                                <p class="text-muted small mb-3">Adjust your search or add a new customer.</p>
                                <a href="{{ route('customers.create') }}" class="btn-add-primary"
                                   style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Customer
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator && $customers->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }} of {{ $customers->total() }} customers
            </span>
            {{ $customers->links() }}
        </div>
    @endif
</div>

@endsection
