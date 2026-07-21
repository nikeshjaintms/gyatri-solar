@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-person-circle"></i></span>
        Employee Profile Details
    </h1>
    <a href="{{ route('employees.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Profile Hero ── --}}
<div class="profile-hero">
    @if($employee->user && $employee->user->profile_photo)
        <img src="{{ asset('storage/' . $employee->user->profile_photo) }}" 
             alt="{{ $employee->user->name }}" 
             class="rounded" 
             style="width: 72px; height: 72px; object-fit: cover; border: 3px solid rgba(255,255,255,0.2);">
    @else
        <div class="hero-avatar">{{ strtoupper(substr($employee->user->name ?? 'E', 0, 1)) }}</div>
    @endif
    <div class="hero-info">
        <h2 class="hero-name">{{ $employee->user->name ?? '—' }}</h2>
        <p class="hero-spec">
            <span class="me-2" style="display: inline-block; background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 6px; color: #212529; font-weight: 600; font-size: 14px; padding: 4px 10px;">
                {{ $employee->employee_id }}
            </span>
            <i class="bi bi-building me-1"></i>
            {{ $employee->department }}
        </p>
        @if($employee->user && $employee->user->status == 'Active')
            <span class="hero-status-active"><span class="dot"></span> Active</span>
        @else
            <span class="hero-status-inactive"><span class="dot"></span> Inactive</span>
        @endif
    </div>
</div>

{{-- ── Detail Grid ── --}}
<div class="detail-grid">

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-envelope"></i></div>
        <div>
            <div class="detail-label">Email Address</div>
            <div class="detail-value {{ !$employee->user || !$employee->user->email ? 'empty' : '' }}">
                {{ $employee->user->email ?? 'Not provided' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-telephone"></i></div>
        <div>
            <div class="detail-label">Mobile Number</div>
            <div class="detail-value {{ !$employee->user || !$employee->user->mobile_number ? 'empty' : '' }}">
                {{ $employee->user->mobile_number ?? 'Not provided' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-blue"><i class="bi bi-card-heading"></i></div>
        <div>
            <div class="detail-label">Aadhaar Number</div>
            <div class="detail-value {{ !$employee->aadhaar_number ? 'empty' : '' }}">
                {{ $employee->aadhaar_number ?? 'Not provided' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-receipt"></i></div>
        <div>
            <div class="detail-label">UTR Number</div>
            <div class="detail-value {{ !$employee->utr_number ? 'empty' : '' }}">
                {{ $employee->utr_number ?? 'Not provided' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-teal"><i class="bi bi-briefcase"></i></div>
        <div>
            <div class="detail-label">Designation</div>
            <div class="detail-value">
                {{ $employee->designation }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-calendar-check"></i></div>
        <div>
            <div class="detail-label">Joining Date</div>
            <div class="detail-value">
                {{ $employee->joining_date ? $employee->joining_date->format('M d, Y') : 'Not set' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-cash-stack"></i></div>
        <div>
            <div class="detail-label">Monthly Salary</div>
            <div class="detail-value">
                {{ $employee->salary ? '₹' . number_format($employee->salary, 2) : 'Not specified' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-shield-lock"></i></div>
        <div>
            <div class="detail-label">Role</div>
            <div class="detail-value">
                {{ $employee->user->role ?? 'Employee' }}
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
        <div class="detail-label mb-0">Residential Address</div>
    </div>
    @if($employee->user && $employee->user->address)
        <p class="address-text mb-0">{{ $employee->user->address }}</p>
    @else
        <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No address provided</p>
    @endif
</div>

{{-- ── Timestamps ── --}}
<div class="timestamps-row">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $employee->created_at ? $employee->created_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $employee->updated_at ? $employee->updated_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('employees.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('employees.edit', $employee->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Employee
    </a>
</div>

@endsection
