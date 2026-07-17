@extends('layouts.admin')

@section('content')

{{-- ── CSS styles for badges ── --}}
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
        font-size: 0.85rem;
        font-weight: 600;
        color: #D96A0B;
    }
</style>

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-calendar-check me-2"></i>Employee Attendance
        </h1>
        <p class="page-hero-sub">Track employee check-ins, check-outs, status, and total work hours</p>
    </div>
    <a href="{{ route('employee-attendances.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Attendance
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card mb-4">
    <form method="GET" action="{{ route('employee-attendances.index') }}">
        <div class="row g-2 align-items-center">
            <!-- Search Employee Name -->
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search employee..."
                           value="{{ request('search') }}">
                </div>
            </div>
            
            <!-- Filter Status -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Present" {{ request('status') == 'Present' ? 'selected' : '' }}>Present</option>
                        <option value="Absent" {{ request('status') == 'Absent' ? 'selected' : '' }}>Absent</option>
                        <option value="Half Day" {{ request('status') == 'Half Day' ? 'selected' : '' }}>Half Day</option>
                        <option value="Leave" {{ request('status') == 'Leave' ? 'selected' : '' }}>Leave</option>
                    </select>
                </div>
            </div>

            <!-- Specific Attendance Date -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    <input type="date" name="attendance_date" class="form-control"
                           placeholder="Specific Date"
                           value="{{ request('attendance_date') }}">
                </div>
            </div>

            <!-- From Date -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text">From</span>
                    <input type="date" name="from_date" class="form-control"
                           value="{{ request('from_date') }}">
                </div>
            </div>

            <!-- To Date -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text">To</span>
                    <input type="date" name="to_date" class="form-control"
                           value="{{ request('to_date') }}">
                </div>
            </div>

            <!-- Action buttons -->
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                <a href="{{ route('employee-attendances.index') }}" class="btn-reset" title="Reset Filters">
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
                    <th style="width: 60px;">Sr. No.</th>
                    <th>Employee Name</th>
                    <th>Attendance Date</th>
                    <th>Check In Time</th>
                    <th>Check Out Time</th>
                    <th>Status</th>
                    <th>Work Hours</th>
                    <th>Remarks</th>
                    <th class="text-end" style="width: 250px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $key => $attendance)
                    @php
                        $srNo = ($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($attendances->firstItem() + $key)
                            : ($key + 1);

                        $badgeClass = match($attendance->status) {
                            'Present' => 'badge-present',
                            'Absent' => 'badge-absent',
                            'Half Day' => 'badge-halfday',
                            'Leave' => 'badge-leave',
                            default => 'badge-present',
                        };
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <div class="td-name">
                                <div class="td-avatar">{{ strtoupper(substr($attendance->employee?->name ?? 'E', 0, 2)) }}</div>
                                <span>{{ $attendance->employee?->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="fw-medium text-dark">{{ $attendance->attendance_date?->format('d M Y') ?? '—' }}</span>
                        </td>
                        <td>
                            @if($attendance->check_in_time)
                                <span class="time-display">{{ \Carbon\Carbon::createFromTimeString($attendance->check_in_time)->format('h:i A') }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->check_out_time)
                                <span class="time-display">{{ \Carbon\Carbon::createFromTimeString($attendance->check_out_time)->format('h:i A') }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="{{ $badgeClass }}">{{ $attendance->status }}</span>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $attendance->formatted_work_hours }}</span>
                        </td>
                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $attendance->remarks }}">
                            {{ $attendance->remarks ?? '—' }}
                        </td>
                        <td>
                            <div class="action-group d-flex justify-content-end align-items-center gap-1">
                                <a href="{{ route('employee-attendances.show', $attendance->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('employee-attendances.edit', $attendance->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('employee-attendances.destroy', $attendance->id) }}" method="POST" class="delete-form d-inline m-0" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
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
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-calendar-x"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No attendance records found</h6>
                                <p class="text-muted small mb-3">Adjust your filters or record attendance for an employee.</p>
                                <a href="{{ route('employee-attendances.create') }}" class="btn-add-primary" style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Attendance
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator && $attendances->hasPages())
        <div class="card-footer-pagination border-top px-4 py-3 bg-white">
            {{ $attendances->links() }}
        </div>
    @endif
</div>

@endsection
