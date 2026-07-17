@extends('layouts.admin')

@section('content')

<style>
    /* ── Hero status badges ── */
    .hbdg { display:inline-flex;align-items:center;gap:6px;padding:6px 16px;border-radius:20px;font-size:0.82rem;font-weight:700; }
    .hbdg::before { content:'';width:8px;height:8px;border-radius:50%;display:block; }

    .hbdg-assigned   { background:rgba(37,99,235,0.15);color:#1D4ED8;border:1px solid rgba(37,99,235,0.25); }
    .hbdg-assigned::before   { background:#3B82F6; }
    .hbdg-accepted   { background:rgba(124,58,237,0.12);color:#6D28D9;border:1px solid rgba(124,58,237,0.2); }
    .hbdg-accepted::before   { background:#8B5CF6; }
    .hbdg-ontheway   { background:rgba(6,182,212,0.12);color:#0E7490;border:1px solid rgba(6,182,212,0.2); }
    .hbdg-ontheway::before   { background:#06B6D4; }
    .hbdg-inprogress { background:rgba(245,130,32,0.15);color:#D96A0B;border:1px solid rgba(245,130,32,0.3); }
    .hbdg-inprogress::before { background:#F58220; }
    .hbdg-hold       { background:rgba(31,41,55,0.1);color:#374151;border:1px solid rgba(31,41,55,0.2); }
    .hbdg-hold::before       { background:#6B7280; }
    .hbdg-completed  { background:rgba(34,197,94,0.12);color:#15803D;border:1px solid rgba(34,197,94,0.2); }
    .hbdg-completed::before  { background:#22C55E; }
    .hbdg-cancelled  { background:rgba(220,38,38,0.12);color:#B91C1C;border:1px solid rgba(220,38,38,0.2); }
    .hbdg-cancelled::before  { background:#EF4444; }
</style>

@php
    $sc = match($jobStatusTracking->status) {
        'Assigned'    => 'assigned',
        'Accepted'    => 'accepted',
        'On The Way'  => 'ontheway',
        'In Progress' => 'inprogress',
        'Hold'        => 'hold',
        'Completed'   => 'completed',
        'Cancelled'   => 'cancelled',
        default       => 'assigned',
    };
    $job = $jobStatusTracking->jobAssignment;
@endphp

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-geo-alt"></i></span>
        Status Update Details
    </h1>
    <a href="{{ route('job-status-tracking.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Hero Card ── --}}
<div class="profile-hero" style="align-items:flex-start;gap:24px;">
    <div class="hero-icon-wrap" style="flex-shrink:0;">
        <i class="bi bi-geo-alt" style="font-size:2rem;"></i>
    </div>
    <div style="flex:1;min-width:0;position:relative;z-index:1;">
        <h2 class="hero-name">
            {{ $job?->serviceRequest?->service?->service_name ?? 'Status Update' }}
        </h2>
        <div class="hero-meta">
            <span class="hero-meta-chip">
                <i class="bi bi-person"></i>
                {{ $job?->serviceRequest?->customer?->name ?? '—' }}
            </span>
            <span class="hero-meta-chip">
                <i class="bi bi-person-badge"></i>
                {{ $job?->technician?->name ?? '—' }}
            </span>
            @if($job?->serviceRequest?->service?->service_code)
                <span class="hero-meta-chip">
                    <i class="bi bi-upc"></i>{{ $job->serviceRequest->service->service_code }}
                </span>
            @endif
        </div>
        <span class="hbdg hbdg-{{ $sc }}">{{ $jobStatusTracking->status }}</span>
    </div>
    {{-- Date/Time on right ── --}}
    <div style="position:relative;z-index:1;flex-shrink:0;text-align:right;">
        <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.5);margin-bottom:3px;">Status Date</div>
        <div style="font-size:1.1rem;font-weight:700;color:#F58220;">
            {{ $jobStatusTracking->status_date?->format('d M Y') ?? '—' }}
        </div>
        @if($jobStatusTracking->status_time)
            <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.5);margin-top:8px;margin-bottom:3px;">Time</div>
            <div style="font-size:1rem;font-weight:600;color:#fff;">
                {{ \Carbon\Carbon::createFromTimeString($jobStatusTracking->status_time)->format('h:i A') }}
            </div>
        @endif
    </div>
</div>

{{-- ── Detail Grid ── --}}
<div class="detail-grid" style="grid-template-columns:repeat(auto-fill,minmax(230px,1fr));">

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-person"></i></div>
        <div>
            <div class="detail-label">Customer</div>
            <div class="detail-value">{{ $job?->serviceRequest?->customer?->name ?? '—' }}</div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-wrench-adjustable"></i></div>
        <div>
            <div class="detail-label">Service</div>
            <div class="detail-value">{{ $job?->serviceRequest?->service?->service_name ?? '—' }}</div>
            @if($job?->serviceRequest?->service?->category)
                <div style="font-size:0.78rem;color:#9CA3AF;margin-top:2px;">{{ $job->serviceRequest->service->category }}</div>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-blue"><i class="bi bi-person-badge"></i></div>
        <div>
            <div class="detail-label">Technician</div>
            <div class="detail-value">{{ $job?->technician?->name ?? '—' }}</div>
            @if($job?->technician?->specialization)
                <div style="font-size:0.78rem;color:#9CA3AF;margin-top:2px;">{{ $job->technician->specialization }}</div>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-activity"></i></div>
        <div>
            <div class="detail-label">Current Status</div>
            <div class="detail-value">
                <span class="hbdg hbdg-{{ $sc }}" style="padding:3px 10px;font-size:0.75rem;">
                    {{ $jobStatusTracking->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-calendar-event"></i></div>
        <div>
            <div class="detail-label">Status Date</div>
            <div class="detail-value">{{ $jobStatusTracking->status_date?->format('d M Y') ?? '—' }}</div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-teal"><i class="bi bi-clock"></i></div>
        <div>
            <div class="detail-label">Status Time</div>
            <div class="detail-value {{ !$jobStatusTracking->status_time ? 'empty' : '' }}">
                @if($jobStatusTracking->status_time)
                    {{ \Carbon\Carbon::createFromTimeString($jobStatusTracking->status_time)->format('h:i A') }}
                @else
                    Not Recorded
                @endif
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-calendar-check"></i></div>
        <div>
            <div class="detail-label">Assigned Date</div>
            <div class="detail-value {{ !$job?->assigned_date ? 'empty' : '' }}">
                {{ $job?->assigned_date?->format('d M Y') ?? '—' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-calendar2-week"></i></div>
        <div>
            <div class="detail-label">Scheduled Date</div>
            <div class="detail-value {{ !$job?->scheduled_date ? 'empty' : '' }}">
                {{ $job?->scheduled_date?->format('d M Y') ?? 'Not Scheduled' }}
            </div>
        </div>
    </div>

</div>

{{-- ── Work Progress & Notes ── --}}
<div class="row g-4 mb-0" style="margin-bottom:24px !important;">
    <div class="col-12 col-md-6">
        <div class="desc-card h-100" style="margin-bottom:0;">
            <div class="desc-card-header">
                <div class="detail-card-icon icon-solar-orange" style="width:36px;height:36px;border-radius:8px;">
                    <i class="bi bi-list-check"></i>
                </div>
                <div class="detail-label mb-0">Work Progress</div>
            </div>
            @if($jobStatusTracking->work_progress)
                <p class="desc-text mb-0">{{ $jobStatusTracking->work_progress }}</p>
            @else
                <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No work progress recorded</p>
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="desc-card h-100" style="margin-bottom:0;">
            <div class="desc-card-header">
                <div class="detail-card-icon icon-solar-slate" style="width:36px;height:36px;border-radius:8px;">
                    <i class="bi bi-chat-left-text"></i>
                </div>
                <div class="detail-label mb-0">Notes / Observations</div>
            </div>
            @if($jobStatusTracking->notes)
                <p class="desc-text mb-0">{{ $jobStatusTracking->notes }}</p>
            @else
                <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No notes added</p>
            @endif
        </div>
    </div>
</div>

{{-- ── Linked Job Assignment ── --}}
@if($job)
    <div class="desc-card" style="margin-bottom:24px;">
        <div class="desc-card-header">
            <div class="detail-card-icon icon-solar-orange" style="width:36px;height:36px;border-radius:8px;">
                <i class="bi bi-tools"></i>
            </div>
            <div>
                <div class="detail-label mb-0">Linked Job Assignment</div>
            </div>
            <a href="{{ route('job-assignments.show', $jobStatusTracking->job_assignment_id) }}"
               class="btn-action btn-action-view ms-auto" style="font-size:0.8rem;padding:5px 12px;">
                <i class="bi bi-arrow-up-right-square"></i> View Assignment
            </a>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-6 col-md-3">
                <div class="detail-label">Job Status</div>
                <div style="font-size:0.88rem;font-weight:600;color:#1F2937;">{{ $job->status }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="detail-label">Job Priority</div>
                <div style="font-size:0.88rem;font-weight:600;color:#1F2937;">{{ $job->priority }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="detail-label">Assigned Date</div>
                <div style="font-size:0.88rem;font-weight:600;color:#1F2937;">{{ $job->assigned_date?->format('d M Y') ?? '—' }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="detail-label">Scheduled Date</div>
                <div style="font-size:0.88rem;font-weight:600;color:#D96A0B;">{{ $job->scheduled_date?->format('d M Y') ?? '—' }}</div>
            </div>
        </div>
    </div>
@endif

{{-- ── Timestamps ── --}}
<div class="timestamps-row">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $jobStatusTracking->created_at?->format('M d, Y — h:i A') ?? '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $jobStatusTracking->updated_at?->format('M d, Y — h:i A') ?? '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('job-status-tracking.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <form action="{{ route('job-status-tracking.destroy', $jobStatusTracking->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('job-status-tracking.edit', $jobStatusTracking->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Status
    </a>
</div>

@endsection
