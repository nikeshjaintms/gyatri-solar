@extends('layouts.admin')

@section('content')

<style>
    /* ── Status badges ── */
    .trkbdg { display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;font-size:0.72rem;font-weight:700;white-space:nowrap; }
    .trkbdg::before { content:'';width:6px;height:6px;border-radius:50%;display:block; }

    .tbd-assigned   { background:rgba(37,99,235,0.1);color:#1D4ED8;border:1px solid rgba(37,99,235,0.2); }
    .tbd-assigned::before   { background:#3B82F6; }
    .tbd-accepted   { background:rgba(124,58,237,0.1);color:#6D28D9;border:1px solid rgba(124,58,237,0.2); }
    .tbd-accepted::before   { background:#8B5CF6; }
    .tbd-ontheway   { background:rgba(6,182,212,0.1);color:#0E7490;border:1px solid rgba(6,182,212,0.2); }
    .tbd-ontheway::before   { background:#06B6D4; }
    .tbd-inprogress { background:rgba(245,130,32,0.12);color:#D96A0B;border:1px solid rgba(245,130,32,0.25); }
    .tbd-inprogress::before { background:#F58220; }
    .tbd-hold       { background:rgba(31,41,55,0.08);color:#374151;border:1px solid rgba(31,41,55,0.18); }
    .tbd-hold::before       { background:#6B7280; }
    .tbd-completed  { background:rgba(34,197,94,0.1);color:#15803D;border:1px solid rgba(34,197,94,0.2); }
    .tbd-completed::before  { background:#22C55E; }
    .tbd-cancelled  { background:rgba(220,38,38,0.1);color:#B91C1C;border:1px solid rgba(220,38,38,0.2); }
    .tbd-cancelled::before  { background:#EF4444; }

    .cell-stack { display:flex;flex-direction:column;gap:2px; }
    .cell-stack .cp { font-weight:600;color:#1F2937;font-size:0.875rem; }
    .cell-stack .cs { font-size:0.75rem;color:#9CA3AF; }
    .progress-cell { max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:0.82rem;color:#6B7280; }
</style>

{{-- ── Page Hero ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-geo-alt me-2"></i>Job Status Tracking
        </h1>
        <p class="page-hero-sub">Live status updates and progress logs for all field job assignments</p>
    </div>
    <a href="{{ route('job-status-tracking.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Status Update
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('job-status-tracking.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search customer, service, technician, status..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['Assigned','Accepted','On The Way','In Progress','Hold','Completed','Cancelled'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('job-status-tracking.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width:1050px;">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Technician</th>
                    <th>Current Status</th>
                    <th>Status Date</th>
                    <th>Time</th>
                    <th>Work Progress</th>
                    <th class="text-end" style="width:200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trackings as $key => $track)
                    @php
                        $srNo = $trackings->firstItem() + $key;
                        $sc   = match($track->status) {
                            'Assigned'    => 'assigned',
                            'Accepted'    => 'accepted',
                            'On The Way'  => 'ontheway',
                            'In Progress' => 'inprogress',
                            'Hold'        => 'hold',
                            'Completed'   => 'completed',
                            'Cancelled'   => 'cancelled',
                            default       => 'assigned',
                        };
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <div class="cell-stack">
                                <span class="cp">{{ $track->jobAssignment?->serviceRequest?->customer?->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="cell-stack">
                                <span class="cp">{{ $track->jobAssignment?->serviceRequest?->service?->service_name ?? '—' }}</span>
                                @php $code = $track->jobAssignment?->serviceRequest?->service?->service_code; @endphp
                                @if($code)<span class="cs">{{ $code }}</span>@endif
                            </div>
                        </td>
                        <td>
                            <div class="cell-stack">
                                <span class="cp">{{ $track->jobAssignment?->technician?->name ?? '—' }}</span>
                                @php $spec = $track->jobAssignment?->technician?->specialization; @endphp
                                @if($spec)<span class="cs">{{ $spec }}</span>@endif
                            </div>
                        </td>
                        <td>
                            <span class="trkbdg tbd-{{ $sc }}">{{ $track->status }}</span>
                        </td>
                        <td style="font-size:0.85rem;color:#374151;">
                            {{ $track->status_date?->format('d M Y') ?? '—' }}
                        </td>
                        <td style="font-size:0.85rem;">
                            @if($track->status_time)
                                <span style="color:#D96A0B;font-weight:600;">
                                    {{ \Carbon\Carbon::createFromTimeString($track->status_time)->format('h:i A') }}
                                </span>
                            @else
                                <span style="color:#D1D5DB;">—</span>
                            @endif
                        </td>
                        <td>
                            @if($track->work_progress)
                                <span class="progress-cell" title="{{ $track->work_progress }}">
                                    {{ $track->work_progress }}
                                </span>
                            @else
                                <span style="color:#D1D5DB;font-size:0.82rem;">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('job-status-tracking.show', $track->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('job-status-tracking.edit', $track->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('job-status-tracking.destroy', $track->id) }}" method="POST" class="delete-form d-inline m-0">
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
                                <div class="empty-state-icon"><i class="bi bi-geo-alt"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No records found</h6>
                                <p class="text-muted small mb-3">Adjust your filters or add a new status update.</p>
                                <a href="{{ route('job-status-tracking.create') }}" class="btn-add-primary"
                                   style="border-radius:20px;padding:8px 20px;font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Status Update
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($trackings->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $trackings->firstItem() }}–{{ $trackings->lastItem() }}
                of {{ $trackings->total() }} records
            </span>
            {{ $trackings->links() }}
        </div>
    @endif
</div>

@endsection
