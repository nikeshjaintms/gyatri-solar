@extends('layouts.admin')

@section('content')

<style>
    /* ── Priority badges ── */
    .badge-priority { display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;font-size:0.72rem;font-weight:700;white-space:nowrap; }
    .badge-priority::before { content:'';width:6px;height:6px;border-radius:50%;display:block; }
    .bdg-p-low    { background:rgba(107,114,128,0.1);color:#4B5563;border:1px solid rgba(107,114,128,0.2); }
    .bdg-p-low::before    { background:#9CA3AF; }
    .bdg-p-medium { background:rgba(37,99,235,0.1);color:#1D4ED8;border:1px solid rgba(37,99,235,0.2); }
    .bdg-p-medium::before { background:#3B82F6; }
    .bdg-p-high   { background:rgba(245,130,32,0.12);color:#D96A0B;border:1px solid rgba(245,130,32,0.25); }
    .bdg-p-high::before   { background:#F58220; }
    .bdg-p-urgent { background:rgba(220,38,38,0.1);color:#B91C1C;border:1px solid rgba(220,38,38,0.2); }
    .bdg-p-urgent::before { background:#EF4444; }

    /* ── Status badges ── */
    .badge-status { display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;font-size:0.72rem;font-weight:700;white-space:nowrap; }
    .badge-status::before { content:'';width:6px;height:6px;border-radius:50%;display:block; }
    .bdg-s-assigned   { background:rgba(37,99,235,0.1);color:#1D4ED8;border:1px solid rgba(37,99,235,0.2); }
    .bdg-s-assigned::before   { background:#3B82F6; }
    .bdg-s-accepted   { background:rgba(124,58,237,0.1);color:#6D28D9;border:1px solid rgba(124,58,237,0.2); }
    .bdg-s-accepted::before   { background:#8B5CF6; }
    .bdg-s-inprogress { background:rgba(245,130,32,0.12);color:#D96A0B;border:1px solid rgba(245,130,32,0.25); }
    .bdg-s-inprogress::before { background:#F58220; }
    .bdg-s-completed  { background:rgba(34,197,94,0.1);color:#15803D;border:1px solid rgba(34,197,94,0.2); }
    .bdg-s-completed::before  { background:#22C55E; }
    .bdg-s-cancelled  { background:rgba(220,38,38,0.1);color:#B91C1C;border:1px solid rgba(220,38,38,0.2); }
    .bdg-s-cancelled::before  { background:#EF4444; }

    .cell-stack { display:flex;flex-direction:column;gap:2px; }
    .cell-stack .cp { font-weight:600;color:#1F2937;font-size:0.875rem; }
    .cell-stack .cs { font-size:0.75rem;color:#9CA3AF; }
</style>

{{-- ── Page Hero ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-tools me-2"></i>Job Assignment Management
        </h1>
        <p class="page-hero-sub">Assign technicians to service requests and track job progress</p>
    </div>
    <a href="{{ route('job-assignments.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> New Assignment
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('job-assignments.index') }}">
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
                        @foreach(['Assigned','Accepted','In Progress','Completed','Cancelled'] as $s)
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
                <a href="{{ route('job-assignments.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width:1100px;">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Technician</th>
                    <th>Assigned</th>
                    <th>Scheduled</th>
                    <th>Time</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th class="text-end" style="width:200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobAssignments as $key => $job)
                    @php
                        $srNo = $jobAssignments->firstItem() + $key;
                        $sClass = match($job->status) {
                            'Assigned'    => 'assigned',
                            'Accepted'    => 'accepted',
                            'In Progress' => 'inprogress',
                            'Completed'   => 'completed',
                            'Cancelled'   => 'cancelled',
                            default       => 'assigned',
                        };
                        $pClass = strtolower($job->priority);
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <div class="cell-stack">
                                <span class="cp">{{ $job->serviceRequest?->customer?->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="cell-stack">
                                <span class="cp">{{ $job->serviceRequest?->service?->service_name ?? '—' }}</span>
                                @if($job->serviceRequest?->service?->service_code)
                                    <span class="cs">{{ $job->serviceRequest->service->service_code }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="cell-stack">
                                <span class="cp">{{ $job->technician?->name ?? '—' }}</span>
                                @if($job->technician?->specialization)
                                    <span class="cs">{{ $job->technician->specialization }}</span>
                                @endif
                            </div>
                        </td>
                        <td style="font-size:0.85rem;color:#374151;">
                            {{ $job->assigned_date?->format('d M Y') ?? '—' }}
                        </td>
                        <td style="font-size:0.85rem;">
                            @if($job->scheduled_date)
                                <span style="color:#D96A0B;font-weight:600;">{{ $job->scheduled_date->format('d M Y') }}</span>
                            @else
                                <span style="color:#D1D5DB;">—</span>
                            @endif
                        </td>
                        <td style="font-size:0.85rem;">
                            @if($job->scheduled_time)
                                <span style="color:#374151;font-weight:500;">
                                    {{ \Carbon\Carbon::createFromTimeString($job->scheduled_time)->format('h:i A') }}
                                </span>
                            @else
                                <span style="color:#D1D5DB;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-priority bdg-p-{{ $pClass }}">{{ $job->priority }}</span>
                        </td>
                        <td>
                            <span class="badge-status bdg-s-{{ $sClass }}">{{ $job->status }}</span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('job-assignments.show', $job->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('job-assignments.edit', $job->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('job-assignments.destroy', $job->id) }}" method="POST" class="delete-form d-inline m-0">
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
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-tools"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No records found</h6>
                                <p class="text-muted small mb-3">Adjust your filters or create a new job assignment.</p>
                                <a href="{{ route('job-assignments.create') }}" class="btn-add-primary"
                                   style="border-radius:20px;padding:8px 20px;font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> New Assignment
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jobAssignments->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $jobAssignments->firstItem() }}–{{ $jobAssignments->lastItem() }}
                of {{ $jobAssignments->total() }} assignments
            </span>
            {{ $jobAssignments->links() }}
        </div>
    @endif
</div>

@endsection
