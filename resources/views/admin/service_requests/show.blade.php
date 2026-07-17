@extends('layouts.admin')

@section('content')

<style>
    /* ── Priority & Status badges for show page ── */
    .show-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 16px; border-radius: 20px;
        font-size: 0.82rem; font-weight: 700;
    }
    .show-badge::before { content:''; width:8px; height:8px; border-radius:50%; display:block; }

    .sbadge-priority-low      { background:rgba(107,114,128,0.1); color:#4B5563; border:1px solid rgba(107,114,128,0.2); }
    .sbadge-priority-low::before { background:#9CA3AF; }
    .sbadge-priority-medium   { background:rgba(37,99,235,0.1);  color:#1D4ED8; border:1px solid rgba(37,99,235,0.2); }
    .sbadge-priority-medium::before { background:#3B82F6; }
    .sbadge-priority-high     { background:rgba(245,130,32,0.12); color:#D96A0B; border:1px solid rgba(245,130,32,0.3); }
    .sbadge-priority-high::before { background:#F58220; }
    .sbadge-priority-urgent   { background:rgba(220,38,38,0.1);  color:#B91C1C; border:1px solid rgba(220,38,38,0.2); }
    .sbadge-priority-urgent::before { background:#EF4444; }

    .sbadge-pending    { background:rgba(245,130,32,0.1);  color:#D96A0B; border:1px solid rgba(245,130,32,0.25); }
    .sbadge-pending::before { background:#F58220; }
    .sbadge-assigned   { background:rgba(37,99,235,0.1);  color:#1D4ED8; border:1px solid rgba(37,99,235,0.2); }
    .sbadge-assigned::before { background:#3B82F6; }
    .sbadge-inprogress { background:rgba(245,158,11,0.1); color:#B45309; border:1px solid rgba(245,158,11,0.25); }
    .sbadge-inprogress::before { background:#F59E0B; }
    .sbadge-completed  { background:rgba(34,197,94,0.1);  color:#15803D; border:1px solid rgba(34,197,94,0.2); }
    .sbadge-completed::before { background:#22C55E; }
    .sbadge-cancelled  { background:rgba(220,38,38,0.1);  color:#B91C1C; border:1px solid rgba(220,38,38,0.2); }
    .sbadge-cancelled::before { background:#EF4444; }
</style>

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-clipboard2-check"></i></span>
        Service Request Details
    </h1>
    <a href="{{ route('service-requests.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

@php
    $statusClass = match($serviceRequest->status) {
        'Pending'     => 'pending',
        'Assigned'    => 'assigned',
        'In Progress' => 'inprogress',
        'Completed'   => 'completed',
        'Cancelled'   => 'cancelled',
        default       => 'pending',
    };
    $priorityClass = strtolower($serviceRequest->priority);
@endphp

{{-- ── Hero Card ── --}}
<div class="profile-hero" style="align-items:flex-start; gap:28px;">
    {{-- Icon --}}
    <div class="hero-icon-wrap" style="flex-shrink:0;">
        <i class="bi bi-clipboard2-pulse" style="font-size:2rem;"></i>
    </div>

    {{-- Main info --}}
    <div style="flex:1; min-width:0; position:relative; z-index:1;">
        <h2 class="hero-name">
            {{ $serviceRequest->service->service_name ?? 'Service Request' }}
        </h2>
        <div class="hero-meta">
            <span class="hero-meta-chip">
                <i class="bi bi-person"></i>
                {{ $serviceRequest->customer->name ?? '—' }}
            </span>
            @if($serviceRequest->technician)
                <span class="hero-meta-chip">
                    <i class="bi bi-person-badge"></i>
                    {{ $serviceRequest->technician->name }}
                </span>
            @else
                <span class="hero-meta-chip" style="background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.5);">
                    <i class="bi bi-person-badge"></i> Unassigned
                </span>
            @endif
            @if($serviceRequest->service && $serviceRequest->service->service_code)
                <span class="hero-meta-chip">
                    <i class="bi bi-upc"></i>
                    {{ $serviceRequest->service->service_code }}
                </span>
            @endif
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="show-badge sbadge-{{ $statusClass }}">{{ $serviceRequest->status }}</span>
            <span class="show-badge sbadge-priority-{{ $priorityClass }}">{{ $serviceRequest->priority }} Priority</span>
        </div>
    </div>

    {{-- Dates on right --}}
    <div style="position:relative;z-index:1;flex-shrink:0;text-align:right;">
        <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.5);margin-bottom:3px;">Request Date</div>
        <div style="font-size:1.1rem;font-weight:700;color:#F58220;">
            {{ $serviceRequest->request_date ? $serviceRequest->request_date->format('d M Y') : '—' }}
        </div>
        @if($serviceRequest->service_date)
            <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:rgba(255,255,255,0.5);margin-top:10px;margin-bottom:3px;">Service Date</div>
            <div style="font-size:1.05rem;font-weight:600;color:#fff;">
                {{ $serviceRequest->service_date->format('d M Y') }}
            </div>
        @endif
    </div>
</div>

{{-- ── Detail Grid ── --}}
<div class="detail-grid" style="grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));">

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-person"></i></div>
        <div>
            <div class="detail-label">Customer</div>
            <div class="detail-value">{{ $serviceRequest->customer->name ?? '—' }}</div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-wrench-adjustable"></i></div>
        <div>
            <div class="detail-label">Service</div>
            <div class="detail-value">{{ $serviceRequest->service->service_name ?? '—' }}</div>
            @if($serviceRequest->service?->category)
                <div style="font-size:0.78rem;color:#9CA3AF;margin-top:2px;">{{ $serviceRequest->service->category }}</div>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-blue"><i class="bi bi-person-badge"></i></div>
        <div>
            <div class="detail-label">Assigned Technician</div>
            <div class="detail-value {{ !$serviceRequest->technician ? 'empty' : '' }}">
                {{ $serviceRequest->technician?->name ?? 'Not Assigned' }}
            </div>
            @if($serviceRequest->technician?->specialization)
                <div style="font-size:0.78rem;color:#9CA3AF;margin-top:2px;">{{ $serviceRequest->technician->specialization }}</div>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-calendar-event"></i></div>
        <div>
            <div class="detail-label">Request Date</div>
            <div class="detail-value">
                {{ $serviceRequest->request_date ? $serviceRequest->request_date->format('d M Y') : '—' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-calendar-check"></i></div>
        <div>
            <div class="detail-label">Service Date</div>
            <div class="detail-value {{ !$serviceRequest->service_date ? 'empty' : '' }}">
                {{ $serviceRequest->service_date ? $serviceRequest->service_date->format('d M Y') : 'Not Scheduled' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-flag"></i></div>
        <div>
            <div class="detail-label">Priority</div>
            <div class="detail-value">
                <span class="show-badge sbadge-priority-{{ $priorityClass }}" style="padding:3px 10px;font-size:0.75rem;">
                    {{ $serviceRequest->priority }}
                </span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-activity"></i></div>
        <div>
            <div class="detail-label">Status</div>
            <div class="detail-value">
                <span class="show-badge sbadge-{{ $statusClass }}" style="padding:3px 10px;font-size:0.75rem;">
                    {{ $serviceRequest->status }}
                </span>
            </div>
        </div>
    </div>

</div>

{{-- ── Address Card ── --}}
<div class="address-card">
    <div class="address-card-header">
        <div class="detail-card-icon icon-solar-teal" style="width:36px;height:36px;border-radius:8px;">
            <i class="bi bi-geo-alt"></i>
        </div>
        <div class="detail-label mb-0">Service Address</div>
    </div>
    @if($serviceRequest->address)
        <p class="address-text mb-0">{{ $serviceRequest->address }}</p>
    @else
        <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No address provided</p>
    @endif
</div>

{{-- ── Description & Remarks ── --}}
<div class="row g-4 mb-0" style="margin-bottom:24px !important;">
    <div class="col-12 col-md-6">
        <div class="desc-card h-100" style="margin-bottom:0;">
            <div class="desc-card-header">
                <div class="detail-card-icon icon-solar-orange" style="width:36px;height:36px;border-radius:8px;">
                    <i class="bi bi-card-text"></i>
                </div>
                <div class="detail-label mb-0">Description / Problem Details</div>
            </div>
            @if($serviceRequest->description)
                <p class="desc-text mb-0">{{ $serviceRequest->description }}</p>
            @else
                <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No description provided</p>
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
            @if($serviceRequest->remarks)
                <p class="desc-text mb-0">{{ $serviceRequest->remarks }}</p>
            @else
                <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No remarks added</p>
            @endif
        </div>
    </div>
</div>

{{-- ── Timestamps ── --}}
<div class="timestamps-row mt-4">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $serviceRequest->created_at ? $serviceRequest->created_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $serviceRequest->updated_at ? $serviceRequest->updated_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('service-requests.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <form action="{{ route('service-requests.destroy', $serviceRequest->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('service-requests.edit', $serviceRequest->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Request
    </a>
</div>

@endsection
