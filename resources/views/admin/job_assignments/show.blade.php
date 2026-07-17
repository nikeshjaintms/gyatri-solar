@extends('layouts.admin')

@section('content')

<style>
    .show-bdg { display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;font-size:0.82rem;font-weight:700; }
    .show-bdg::before { content:'';width:7px;height:7px;border-radius:50%;display:block; }

    .shdg-p-low    { background:rgba(107,114,128,0.1);color:#4B5563;border:1px solid rgba(107,114,128,0.2); }
    .shdg-p-low::before    { background:#9CA3AF; }
    .shdg-p-medium { background:rgba(37,99,235,0.1);color:#1D4ED8;border:1px solid rgba(37,99,235,0.2); }
    .shdg-p-medium::before { background:#3B82F6; }
    .shdg-p-high   { background:rgba(245,130,32,0.12);color:#D96A0B;border:1px solid rgba(245,130,32,0.25); }
    .shdg-p-high::before   { background:#F58220; }
    .shdg-p-urgent { background:rgba(220,38,38,0.1);color:#B91C1C;border:1px solid rgba(220,38,38,0.2); }
    .shdg-p-urgent::before { background:#EF4444; }

    .shdg-s-assigned   { background:rgba(37,99,235,0.1);color:#1D4ED8;border:1px solid rgba(37,99,235,0.2); }
    .shdg-s-assigned::before   { background:#3B82F6; }
    .shdg-s-accepted   { background:rgba(124,58,237,0.1);color:#6D28D9;border:1px solid rgba(124,58,237,0.2); }
    .shdg-s-accepted::before   { background:#8B5CF6; }
    .shdg-s-inprogress { background:rgba(245,130,32,0.12);color:#D96A0B;border:1px solid rgba(245,130,32,0.25); }
    .shdg-s-inprogress::before { background:#F58220; }
    .shdg-s-completed  { background:rgba(34,197,94,0.1);color:#15803D;border:1px solid rgba(34,197,94,0.2); }
    .shdg-s-completed::before  { background:#22C55E; }
    .shdg-s-cancelled  { background:rgba(220,38,38,0.1);color:#B91C1C;border:1px solid rgba(220,38,38,0.2); }
    .shdg-s-cancelled::before  { background:#EF4444; }
</style>

@php
    $sc = match($jobAssignment->status) {
        'Assigned'    => 'assigned',
        'Accepted'    => 'accepted',
        'In Progress' => 'inprogress',
        'Completed'   => 'completed',
        'Cancelled'   => 'cancelled',
        default       => 'assigned',
    };
    $pc = strtolower($jobAssignment->priority);
@endphp

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-tools"></i></span>
        Job Assignment Details
    </h1>
    <a href="{{ route('job-assignments.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Hero Card ── --}}
<div class="profile-hero" style="align-items:flex-start;gap:24px;">
    <div class="hero-icon-wrap" style="flex-shrink:0;">
        <i class="bi bi-tools" style="font-size:2rem;"></i>
    </div>
    <div style="flex:1;min-width:0;position:relative;z-index:1;">
        <h2 class="hero-name">
            {{ $jobAssignment->serviceRequest?->service?->service_name ?? 'Job Assignment' }}
        </h2>
        <div class="hero-meta">
            <span class="hero-meta-chip">
                <i class="bi bi-person"></i>
                {{ $jobAssignment->serviceRequest?->customer?->name ?? '—' }}
            </span>
            <span class="hero-meta-chip">
                <i class="bi bi-person-badge"></i>
                {{ $jobAssignment->technician?->name ?? '—' }}
            </span>
            @if($jobAssignment->serviceRequest?->service?->service_code)
                <span class="hero-meta-chip">
                    <i class="bi bi-upc"></i>
                    {{ $jobAssignment->serviceRequest->service->service_code }}
                </span>
            @endif
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="show-bdg shdg-s-{{ $sc }}">{{ $jobAssignment->status }}</span>
            <span class="show-bdg shdg-p-{{ $pc }}">{{ $jobAssignment->priority }} Priority</span>
        </div>
    </div>
    {{-- Dates right panel --}}
    <div style="position:relative;z-index:1;flex-shrink:0;text-align:right;">
        <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.5);margin-bottom:3px;">Assigned</div>
        <div style="font-size:1.05rem;font-weight:700;color:#F58220;">
            {{ $jobAssignment->assigned_date?->format('d M Y') ?? '—' }}
        </div>
        @if($jobAssignment->scheduled_date)
            <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.5);margin-top:10px;margin-bottom:3px;">Scheduled</div>
            <div style="font-size:1rem;font-weight:600;color:#fff;">
                {{ $jobAssignment->scheduled_date->format('d M Y') }}
                @if($jobAssignment->scheduled_time)
                    <br><span style="font-size:0.88rem;color:rgba(255,255,255,0.7);">
                        {{ \Carbon\Carbon::createFromTimeString($jobAssignment->scheduled_time)->format('h:i A') }}
                    </span>
                @endif
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
            <div class="detail-value">{{ $jobAssignment->serviceRequest?->customer?->name ?? '—' }}</div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-wrench-adjustable"></i></div>
        <div>
            <div class="detail-label">Service</div>
            <div class="detail-value">{{ $jobAssignment->serviceRequest?->service?->service_name ?? '—' }}</div>
            @if($jobAssignment->serviceRequest?->service?->category)
                <div style="font-size:0.78rem;color:#9CA3AF;margin-top:2px;">
                    {{ $jobAssignment->serviceRequest->service->category }}
                </div>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-blue"><i class="bi bi-person-badge"></i></div>
        <div>
            <div class="detail-label">Technician</div>
            <div class="detail-value">{{ $jobAssignment->technician?->name ?? '—' }}</div>
            @if($jobAssignment->technician?->specialization)
                <div style="font-size:0.78rem;color:#9CA3AF;margin-top:2px;">
                    {{ $jobAssignment->technician->specialization }}
                </div>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-calendar-event"></i></div>
        <div>
            <div class="detail-label">Assigned Date</div>
            <div class="detail-value">{{ $jobAssignment->assigned_date?->format('d M Y') ?? '—' }}</div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-calendar-check"></i></div>
        <div>
            <div class="detail-label">Scheduled Date</div>
            <div class="detail-value {{ !$jobAssignment->scheduled_date ? 'empty' : '' }}">
                {{ $jobAssignment->scheduled_date?->format('d M Y') ?? 'Not Scheduled' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-teal"><i class="bi bi-clock"></i></div>
        <div>
            <div class="detail-label">Scheduled Time</div>
            <div class="detail-value {{ !$jobAssignment->scheduled_time ? 'empty' : '' }}">
                @if($jobAssignment->scheduled_time)
                    {{ \Carbon\Carbon::createFromTimeString($jobAssignment->scheduled_time)->format('h:i A') }}
                @else
                    Not Set
                @endif
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-flag"></i></div>
        <div>
            <div class="detail-label">Priority</div>
            <div class="detail-value">
                <span class="show-bdg shdg-p-{{ $pc }}" style="padding:3px 10px;font-size:0.75rem;">{{ $jobAssignment->priority }}</span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-activity"></i></div>
        <div>
            <div class="detail-label">Status</div>
            <div class="detail-value">
                <span class="show-bdg shdg-s-{{ $sc }}" style="padding:3px 10px;font-size:0.75rem;">{{ $jobAssignment->status }}</span>
            </div>
        </div>
    </div>

</div>

{{-- ── Work Notes & Remarks ── --}}
<div class="row g-4 mb-0" style="margin-bottom:24px !important;">
    <div class="col-12 col-md-6">
        <div class="desc-card h-100" style="margin-bottom:0;">
            <div class="desc-card-header">
                <div class="detail-card-icon icon-solar-orange" style="width:36px;height:36px;border-radius:8px;">
                    <i class="bi bi-card-text"></i>
                </div>
                <div class="detail-label mb-0">Work Notes</div>
            </div>
            @if($jobAssignment->work_notes)
                <p class="desc-text mb-0">{{ $jobAssignment->work_notes }}</p>
            @else
                <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No work notes added</p>
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="desc-card h-100" style="margin-bottom:0;">
            <div class="desc-card-header">
                <div class="detail-card-icon icon-solar-slate" style="width:36px;height:36px;border-radius:8px;">
                    <i class="bi bi-chat-left-text"></i>
                </div>
                <div class="detail-label mb-0">Remarks / Internal Notes</div>
            </div>
            @if($jobAssignment->remarks)
                <p class="desc-text mb-0">{{ $jobAssignment->remarks }}</p>
            @else
                <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No remarks added</p>
            @endif
        </div>
    </div>
</div>

{{-- ── Service Request Link ── --}}
@if($jobAssignment->serviceRequest)
    <div class="desc-card" style="margin-bottom:24px;">
        <div class="desc-card-header">
            <div class="detail-card-icon icon-solar-orange" style="width:36px;height:36px;border-radius:8px;">
                <i class="bi bi-clipboard2-check"></i>
            </div>
            <div>
                <div class="detail-label mb-0">Linked Service Request</div>
            </div>
            <a href="{{ route('service-requests.show', $jobAssignment->service_request_id) }}"
               class="btn-action btn-action-view ms-auto" style="font-size:0.8rem;padding:5px 12px;">
                <i class="bi bi-arrow-up-right-square"></i> View Request
            </a>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-6 col-md-3">
                <div class="detail-label">Request Date</div>
                <div class="detail-value" style="font-size:0.88rem;">
                    {{ $jobAssignment->serviceRequest->request_date?->format('d M Y') ?? '—' }}
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="detail-label">SR Status</div>
                <div class="detail-value" style="font-size:0.88rem;">
                    {{ $jobAssignment->serviceRequest->status }}
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="detail-label">SR Priority</div>
                <div class="detail-value" style="font-size:0.88rem;">
                    {{ $jobAssignment->serviceRequest->priority }}
                </div>
            </div>
        </div>
    </div>
@endif

{{-- ── Timestamps ── --}}
<div class="timestamps-row">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $jobAssignment->created_at?->format('M d, Y — h:i A') ?? '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $jobAssignment->updated_at?->format('M d, Y — h:i A') ?? '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('job-assignments.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <form action="{{ route('job-assignments.destroy', $jobAssignment->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('job-assignments.edit', $jobAssignment->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Assignment
    </a>
</div>

@endsection
