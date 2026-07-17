@extends('layouts.admin')

@section('content')

<style>
    /* ── Priority badges ── */
    .badge-priority {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 20px;
        font-size: 0.73rem; font-weight: 700; white-space: nowrap;
    }
    .badge-priority::before { content:''; width:6px; height:6px; border-radius:50%; display:block; }
    .badge-priority-low      { background:rgba(107,114,128,0.1); color:#4B5563; border:1px solid rgba(107,114,128,0.2); }
    .badge-priority-low::before { background:#9CA3AF; }
    .badge-priority-medium   { background:rgba(37,99,235,0.1);  color:#1D4ED8; border:1px solid rgba(37,99,235,0.2); }
    .badge-priority-medium::before { background:#3B82F6; }
    .badge-priority-high     { background:rgba(245,130,32,0.12); color:#D96A0B; border:1px solid rgba(245,130,32,0.25); }
    .badge-priority-high::before { background:#F58220; }
    .badge-priority-urgent   { background:rgba(220,38,38,0.1);  color:#B91C1C; border:1px solid rgba(220,38,38,0.2); }
    .badge-priority-urgent::before { background:#EF4444; }

    /* ── Status badges ── */
    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 20px;
        font-size: 0.73rem; font-weight: 700; white-space: nowrap;
    }
    .badge-status::before { content:''; width:6px; height:6px; border-radius:50%; display:block; }
    .badge-status-pending    { background:rgba(245,130,32,0.1);  color:#D96A0B; border:1px solid rgba(245,130,32,0.25); }
    .badge-status-pending::before { background:#F58220; }
    .badge-status-assigned   { background:rgba(37,99,235,0.1);  color:#1D4ED8; border:1px solid rgba(37,99,235,0.2); }
    .badge-status-assigned::before { background:#3B82F6; }
    .badge-status-inprogress { background:rgba(245,158,11,0.1); color:#B45309; border:1px solid rgba(245,158,11,0.25); }
    .badge-status-inprogress::before { background:#F59E0B; }
    .badge-status-completed  { background:rgba(34,197,94,0.1);  color:#15803D; border:1px solid rgba(34,197,94,0.2); }
    .badge-status-completed::before { background:#22C55E; }
    .badge-status-cancelled  { background:rgba(220,38,38,0.1);  color:#B91C1C; border:1px solid rgba(220,38,38,0.2); }
    .badge-status-cancelled::before { background:#EF4444; }

    /* ── Relation cell ── */
    .rel-cell { display:flex; flex-direction:column; gap:1px; }
    .rel-cell .rel-primary { font-weight:600; color:#1F2937; font-size:0.875rem; }
    .rel-cell .rel-sub     { font-size:0.75rem; color:#9CA3AF; }
</style>

{{-- ── Page Hero ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-clipboard2-check me-2"></i>Service Requests
        </h1>
        <p class="page-hero-sub">Manage all solar energy service bookings and field requests</p>
    </div>
    <a href="{{ route('service-requests.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> New Request
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('service-requests.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search customer, service, technician..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['Pending','Assigned','In Progress','Completed','Cancelled'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-flag"></i></span>
                    <select name="priority" class="form-select">
                        <option value="">All Priorities</option>
                        @foreach(['Low','Medium','High','Urgent'] as $p)
                            <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('service-requests.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 1050px;">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Technician</th>
                    <th>Request Date</th>
                    <th>Service Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th class="text-end" style="width:200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($serviceRequests as $key => $sr)
                    @php
                        $srNo = $serviceRequests->firstItem() + $key;
                        $statusClass = match($sr->status) {
                            'Pending'     => 'pending',
                            'Assigned'    => 'assigned',
                            'In Progress' => 'inprogress',
                            'Completed'   => 'completed',
                            'Cancelled'   => 'cancelled',
                            default       => 'pending',
                        };
                        $priorityClass = strtolower($sr->priority);
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <div class="rel-cell">
                                <span class="rel-primary">{{ $sr->customer->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="rel-cell">
                                <span class="rel-primary">{{ $sr->service->service_name ?? '—' }}</span>
                                @if($sr->service && $sr->service->service_code)
                                    <span class="rel-sub">{{ $sr->service->service_code }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($sr->technician)
                                <div class="rel-cell">
                                    <span class="rel-primary">{{ $sr->technician->name }}</span>
                                    <span class="rel-sub">{{ $sr->technician->specialization ?? '' }}</span>
                                </div>
                            @else
                                <span style="color:#D1D5DB;font-style:italic;font-size:0.82rem;">Unassigned</span>
                            @endif
                        </td>
                        <td style="color:#374151;font-size:0.85rem;">
                            {{ $sr->request_date ? $sr->request_date->format('d M Y') : '—' }}
                        </td>
                        <td style="font-size:0.85rem;">
                            @if($sr->service_date)
                                <span style="color:#D96A0B;font-weight:600;">{{ $sr->service_date->format('d M Y') }}</span>
                            @else
                                <span style="color:#D1D5DB;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-priority badge-priority-{{ $priorityClass }}">{{ $sr->priority }}</span>
                        </td>
                        <td>
                            <span class="badge-status badge-status-{{ $statusClass }}">{{ $sr->status }}</span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('service-requests.show', $sr->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('service-requests.edit', $sr->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('service-requests.destroy', $sr->id) }}" method="POST" class="delete-form d-inline m-0">
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
                                <div class="empty-state-icon"><i class="bi bi-clipboard2-x"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No records found</h6>
                                <p class="text-muted small mb-3">Adjust your filters or create a new service request.</p>
                                <a href="{{ route('service-requests.create') }}" class="btn-add-primary"
                                   style="border-radius:20px;padding:8px 20px;font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> New Request
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($serviceRequests->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $serviceRequests->firstItem() }}–{{ $serviceRequests->lastItem() }}
                of {{ $serviceRequests->total() }} requests
            </span>
            {{ $serviceRequests->links() }}
        </div>
    @endif
</div>

@endsection
