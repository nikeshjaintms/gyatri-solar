@extends('layouts.admin')

@section('content')

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-sun me-2"></i>Solar Projects
        </h1>
        <p class="page-hero-sub">Track customer installations, solar capacity, and project progress</p>
    </div>
    <a href="{{ route('projects.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Project
    </a>
</div>

{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('projects.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search project name, customer, address..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-activity"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['New', 'In Progress', 'Completed', 'Cancelled'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-tags"></i></span>
                    <select name="customer_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(\App\Models\Customer::TYPES as $type)
                            <option value="{{ $type }}" @selected(request('customer_type') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('projects.index') }}" class="btn-reset" title="Reset Filter">
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
                    <th style="width: 56px;">#</th>
                    <th>Project Name</th>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $key => $project)
                    @php
                        $srNo = ($projects instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($projects->firstItem() + $key)
                            : ($key + 1);
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <div class="td-name">
                                <div class="td-avatar">
                                    {{ strtoupper(substr($project->project_name, 0, 2)) }}
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-nowrap">{{ $project->project_name }}</span>
                                    @if($project->installation_address)
                                        <small class="text-muted text-nowrap" style="font-size: 0.75rem; font-weight: 400;">
                                            <i class="bi bi-geo-alt me-1 text-warning"></i>{{ Str::limit($project->installation_address, 28) }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('customers.show', $project->customer) }}" class="fw-semibold text-dark text-decoration-none d-inline-flex align-items-center gap-1.5">
                                <i class="bi bi-person-circle text-muted"></i>
                                <span>{{ $project->customer->name }}</span>
                            </a>
                        </td>
                        <td class="text-nowrap">
                            <span class="badge rounded-pill fw-medium px-2.5 py-1 text-xs" style="
                                @if($project->customer_type === 'Residential') background: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE;
                                @elseif($project->customer_type === 'Commercial') background: #F5F3FF; color: #6D28D9; border: 1px solid #DDD6FE;
                                @else background: #F3F4F6; color: #4B5563; border: 1px solid #E5E7EB; @endif
                            ">
                                <i class="bi bi-tag-fill me-1"></i>{{ $project->customer_type ?? 'Residential' }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <span class="badge bg-light text-dark border px-2.5 py-1 font-monospace fw-semibold">
                                <i class="bi bi-lightning-charge-fill text-warning me-1"></i>{{ number_format((float) $project->solar_capacity, 2) }} kW
                            </span>
                        </td>
                        <td class="text-nowrap">
                            @if($project->status === 'Completed')
                                <span class="badge rounded-pill px-2.5 py-1 fw-medium text-xs text-nowrap" style="background:#ECFDF5; color:#047857; border:1px solid #A7F3D0;">
                                    <i class="bi bi-check-circle-fill me-1"></i>Completed
                                </span>
                            @elseif($project->status === 'In Progress')
                                <span class="badge rounded-pill px-2.5 py-1 fw-medium text-xs text-nowrap" style="background:#FFFBEB; color:#B45309; border:1px solid #FDE68A;">
                                    <i class="bi bi-arrow-repeat me-1"></i>In Progress
                                </span>
                            @elseif($project->status === 'Cancelled')
                                <span class="badge rounded-pill px-2.5 py-1 fw-medium text-xs text-nowrap" style="background:#F3F4F6; color:#6B7280; border:1px solid #E5E7EB;">
                                    <i class="bi bi-x-circle me-1"></i>Cancelled
                                </span>
                            @else
                                <span class="badge rounded-pill px-2.5 py-1 fw-medium text-xs text-nowrap" style="background:#EFF6FF; color:#1D4ED8; border:1px solid #BFDBFE;">
                                    <i class="bi bi-circle-fill me-1" style="font-size:0.4rem;"></i>New
                                </span>
                            @endif
                        </td>
                        <td class="text-nowrap" style="color:#6B7280;">
                            <i class="bi bi-calendar3 me-1 text-muted"></i>{{ $project->start_date?->format('d M Y') ?? '—' }}
                        </td>
                        <td class="text-end text-nowrap">
                            <div class="action-group">
                                <a href="{{ route('projects.show', $project) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('projects.edit', $project) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="delete-form d-inline m-0" onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
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
                                <div class="empty-state-icon"><i class="bi bi-sun"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No solar projects found</h6>
                                <p class="text-muted small mb-3">Adjust your filter criteria or register a new solar project.</p>
                                <a href="{{ route('projects.create') }}" class="btn-add-primary">
                                    <i class="bi bi-plus-lg"></i> Add Project
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($projects instanceof \Illuminate\Pagination\LengthAwarePaginator && $projects->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $projects->firstItem() }}–{{ $projects->lastItem() }} of {{ $projects->total() }} projects
            </span>
            {{ $projects->links() }}
        </div>
    @endif
</div>

@endsection