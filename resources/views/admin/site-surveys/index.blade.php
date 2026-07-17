@extends('layouts.admin')

@section('content')

<style>
    .badge-pending { background-color: #E5E7EB; color: #374151; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-scheduled { background-color: #E1EFFE; color: #1E429F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-completed { background-color: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-approved { background-color: #DEF7EC; color: #03543F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-rejected { background-color: #FDE8E8; color: #9B1C1C; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
</style>

<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-map me-2"></i>Site Survey Management
        </h1>
        <p class="page-hero-sub">Schedule site inspections, gather technical specs, upload site photos, evaluate solar feasibility</p>
    </div>
    <a href="{{ route('site-surveys.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Site Survey
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card mb-4">
    <form method="GET" action="{{ route('site-surveys.index') }}">
        <div class="row g-2 align-items-center">
            <!-- Search -->
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search Survey #, customer, address..."
                           value="{{ request('search') }}">
                </div>
            </div>

            <!-- Status -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Scheduled" {{ request('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>

            <!-- Surveyor -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <select name="surveyor_id" class="form-select">
                        <option value="">All Surveyors</option>
                        @foreach($surveyors as $sv)
                            <option value="{{ $sv->id }}" {{ request('surveyor_id') == $sv->id ? 'selected' : '' }}>
                                {{ $sv->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- From Date -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text">From</span>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
            </div>

            <!-- To Date -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text">To</span>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>
            </div>

            <!-- Buttons -->
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                <a href="{{ route('site-surveys.index') }}" class="btn-reset" title="Reset Filters">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 1100px;">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Survey Number</th>
                    <th>Customer Name</th>
                    <th>Survey Date</th>
                    <th>Surveyor</th>
                    <th>Site Address</th>
                    <th>Feasibility</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 240px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surveys as $key => $survey)
                    @php
                        $srNo = ($surveys instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($surveys->firstItem() + $key)
                            : ($key + 1);

                        $badge = match($survey->status) {
                            'Pending' => 'badge-pending',
                            'Scheduled' => 'badge-scheduled',
                            'Completed' => 'badge-completed',
                            'Approved' => 'badge-approved',
                            'Rejected' => 'badge-rejected',
                            default => 'badge-pending',
                        };
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td><span class="code-badge">{{ $survey->survey_number }}</span></td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $survey->customer?->name ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="fw-medium text-dark">{{ $survey->survey_date?->format('d M Y') ?? '—' }}</span>
                        </td>
                        <td>{{ $survey->surveyor?->name ?? 'Unassigned' }}</td>
                        <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $survey->site_address }}">
                            {{ $survey->site_address }}
                        </td>
                        <td>
                            @if($survey->installation_feasibility == 'Feasible')
                                <span class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Feasible</span>
                            @elseif($survey->installation_feasibility == 'Not Feasible')
                                <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill"></i> Not Feasible</span>
                            @else
                                <span class="text-warning fw-bold"><i class="bi bi-exclamation-circle-fill"></i> Conditional</span>
                            @endif
                        </td>
                        <td><span class="{{ $badge }}">{{ $survey->status }}</span></td>
                        <td>
                            <div class="action-group d-flex justify-content-end align-items-center gap-1">
                                <a href="{{ route('site-surveys.show', $survey->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('site-surveys.edit', $survey->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('site-surveys.destroy', $survey->id) }}" method="POST" class="delete-form d-inline m-0" onsubmit="return confirm('Are you sure you want to delete this survey record?');">
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
                                <div class="empty-state-icon"><i class="bi bi-map-fill"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No site surveys found</h6>
                                <p class="text-muted small mb-3">Adjust your filter options or add a new site inspection survey.</p>
                                <a href="{{ route('site-surveys.create') }}" class="btn-add-primary" style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Site Survey
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($surveys instanceof \Illuminate\Pagination\LengthAwarePaginator && $surveys->hasPages())
        <div class="card-footer-pagination border-top px-4 py-3 bg-white">
            {{ $surveys->links() }}
        </div>
    @endif
</div>

@endsection
