@extends('layouts.admin')

@section('content')

<style>
    .badge-present {
        background-color: #DEF7EC;
        color: #03543F;
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-absent {
        background-color: #FDE8E8;
        color: #9B1C1C;
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-halfday {
        background-color: #FEF3C7;
        color: #92400E;
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-leave {
        background-color: #E1EFFE;
        color: #1E429F;
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .time-display {
        font-size: 0.9rem;
        font-weight: 600;
        color: #D96A0B;
    }
    .detail-row {
        padding: 16px 20px;
        border-bottom: 1px solid #E8ECF0;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-size: 0.85rem;
        color: #6B7280;
        font-weight: 500;
    }
    .detail-value {
        font-size: 0.9rem;
        color: #111827;
        font-weight: 600;
    }
</style>

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-calendar-event"></i></span>
        Attendance Details
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('employee-attendances.edit', $attendance->id) }}" class="btn-add-primary" style="background-color: #3B82F6;">
            <i class="bi bi-pencil"></i> Edit Record
        </a>
        <a href="{{ route('employee-attendances.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Detailed Record Information</h6>
    </div>

    <div class="form-card-body p-0">
        <!-- Employee Name -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Employee Name</div>
            <div class="col-12 col-md-9 detail-value">
                <div class="td-name">
                    <div class="td-avatar">{{ strtoupper(substr($attendance->employee?->name ?? 'E', 0, 2)) }}</div>
                    <span>{{ $attendance->employee?->name ?? '—' }}</span>
                </div>
            </div>
        </div>

        <!-- Attendance Date -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Attendance Date</div>
            <div class="col-12 col-md-9 detail-value">
                {{ $attendance->attendance_date?->format('l, d M Y') ?? '—' }}
            </div>
        </div>

        <!-- Status -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Status</div>
            <div class="col-12 col-md-9 detail-value">
                @php
                    $badgeClass = match($attendance->status) {
                        'Present' => 'badge-present',
                        'Absent' => 'badge-absent',
                        'Half Day' => 'badge-halfday',
                        'Leave' => 'badge-leave',
                        default => 'badge-present',
                    };
                @endphp
                <span class="{{ $badgeClass }}">{{ $attendance->status }}</span>
            </div>
        </div>

        <!-- Check In Time -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Check In Time</div>
            <div class="col-12 col-md-9 detail-value">
                @if($attendance->check_in_time)
                    <span class="time-display">{{ \Carbon\Carbon::createFromTimeString($attendance->check_in_time)->format('h:i A') }}</span>
                @else
                    <span class="text-muted">—</span>
                @endif
            </div>
        </div>

        <!-- Check Out Time -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Check Out Time</div>
            <div class="col-12 col-md-9 detail-value">
                @if($attendance->check_out_time)
                    <span class="time-display">{{ \Carbon\Carbon::createFromTimeString($attendance->check_out_time)->format('h:i A') }}</span>
                @else
                    <span class="text-muted">—</span>
                @endif
            </div>
        </div>

        <!-- Work Hours -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Calculated Work Hours</div>
            <div class="col-12 col-md-9 detail-value">
                <span class="text-dark">{{ $attendance->formatted_work_hours }}</span>
            </div>
        </div>

        <!-- Remarks -->
        <div class="detail-row row">
            <div class="col-12 col-md-3 detail-label">Remarks / Notes</div>
            <div class="col-12 col-md-9 detail-value" style="font-weight: normal; color: #4B5563;">
                {{ $attendance->remarks ?? '—' }}
            </div>
        </div>

        <!-- Punch In Location -->
        <div class="detail-row row">
            <div class="col-12 col-md-3 detail-label">Punch In Location</div>
            <div class="col-12 col-md-9 detail-value" style="font-weight: normal; color: #4B5563;">
                @if($attendance->punch_in_latitude)
                    <div><strong>Address:</strong> {{ $attendance->punch_in_address }}</div>
                    <div><strong>GPS Coordinates:</strong> {{ $attendance->punch_in_latitude }}, {{ $attendance->punch_in_longitude }}</div>
                    @if($attendance->punch_in_google_map)
                        <div class="mt-2">
                            <a href="{{ $attendance->punch_in_google_map }}" target="_blank" class="btn btn-sm btn-outline-warning" style="border-color: var(--brand-orange); color: var(--brand-orange);">
                                <i class="bi bi-geo-alt"></i> View on Google Maps
                            </a>
                        </div>
                    @endif
                @else
                    <span class="text-muted">—</span>
                @endif
            </div>
        </div>

        <!-- Punch Out Location -->
        <div class="detail-row row">
            <div class="col-12 col-md-3 detail-label">Punch Out Location</div>
            <div class="col-12 col-md-9 detail-value" style="font-weight: normal; color: #4B5563;">
                @if($attendance->punch_out_latitude)
                    <div><strong>Address:</strong> {{ $attendance->punch_out_address }}</div>
                    <div><strong>GPS Coordinates:</strong> {{ $attendance->punch_out_latitude }}, {{ $attendance->punch_out_longitude }}</div>
                    @if($attendance->punch_out_google_map)
                        <div class="mt-2">
                            <a href="{{ $attendance->punch_out_google_map }}" target="_blank" class="btn btn-sm btn-outline-warning" style="border-color: var(--brand-orange); color: var(--brand-orange);">
                                <i class="bi bi-geo-alt"></i> View on Google Maps
                            </a>
                        </div>
                    @endif
                @else
                    <span class="text-muted">—</span>
                @endif
            </div>
        </div>

        <!-- Timestamps -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Recorded At</div>
            <div class="col-12 col-md-9 detail-value" style="font-size: 0.82rem; color: #6B7280; font-weight: normal;">
                {{ $attendance->created_at?->format('d M Y h:i A') ?? '—' }}
            </div>
        </div>
    </div>
</div>

@endsection
