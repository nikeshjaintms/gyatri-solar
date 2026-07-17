@extends('layouts.admin')

@section('content')

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-wrench-adjustable me-2"></i>Services Management
        </h1>
        <p class="page-hero-sub">Manage your solar energy service offerings and pricing</p>
    </div>
    <a href="{{ route('services.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Service
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('services.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search service name, code, category..."
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
                <a href="{{ route('services.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 900px;">
            <thead>
                <tr>
                    <th style="width:56px;">#</th>
                    <th>Service Name</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th class="text-end" style="width:200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $key => $service)
                    @php
                        $srNo = ($services instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($services->firstItem() + $key)
                            : ($key + 1);
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <div class="td-name">
                                <div class="td-avatar">{{ strtoupper(substr($service->service_name, 0, 2)) }}</div>
                                <span>{{ $service->service_name }}</span>
                            </div>
                        </td>
                        <td>
                            @if($service->service_code)
                                <span class="code-badge">{{ $service->service_code }}</span>
                            @else
                                <span style="color:#9CA3AF;">—</span>
                            @endif
                        </td>
                        <td style="color:#6B7280;">{{ $service->category ?? '—' }}</td>
                        <td>
                            @if($service->price !== null)
                                <span class="price-cell">${{ number_format($service->price, 2) }}</span>
                            @else
                                <span style="color:#9CA3AF;">—</span>
                            @endif
                        </td>
                        <td style="color:#6B7280;">{{ $service->duration ?? '—' }}</td>
                        <td>
                            @if($service->status == 'Active')
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('services.show', $service->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('services.edit', $service->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="delete-form d-inline m-0">
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
                                <div class="empty-state-icon"><i class="bi bi-wrench-adjustable"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No records found</h6>
                                <p class="text-muted small mb-3">Adjust your search or add a new service.</p>
                                <a href="{{ route('services.create') }}" class="btn-add-primary" style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Service
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($services instanceof \Illuminate\Pagination\LengthAwarePaginator && $services->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $services->firstItem() }}–{{ $services->lastItem() }} of {{ $services->total() }} services
            </span>
            {{ $services->links() }}
        </div>
    @endif
</div>

@endsection
