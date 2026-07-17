@extends('layouts.admin')

@section('content')

<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-person-badge"></i></span>
        Technician Details
    </h1>
    <a href="{{ route('technicians.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Profile Hero ── --}}
<div class="profile-hero">
    <div class="hero-avatar">{{ strtoupper(substr($technician->name, 0, 1)) }}</div>
    <div class="hero-info">
        <h2 class="hero-name">{{ $technician->name }}</h2>
        <p class="hero-spec">
            <i class="bi bi-tools me-1"></i>
            {{ $technician->specialization ?? 'General Technician' }}
        </p>
        @if($technician->status == 'Active')
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
            <div class="detail-value {{ !$technician->email ? 'empty' : '' }}">
                {{ $technician->email ?? 'Not provided' }}
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-telephone"></i></div>
        <div>
            <div class="detail-label">Phone Number</div>
            <div class="detail-value {{ !$technician->phone ? 'empty' : '' }}">
                {{ $technician->phone ?? 'Not provided' }}
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-tools"></i></div>
        <div>
            <div class="detail-label">Specialization</div>
            <div class="detail-value {{ !$technician->specialization ? 'empty' : '' }}">
                {{ $technician->specialization ?? 'Not provided' }}
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-award"></i></div>
        <div>
            <div class="detail-label">Experience</div>
            <div class="detail-value {{ !$technician->experience ? 'empty' : '' }}">
                {{ $technician->experience ?? 'Not provided' }}
            </div>
        </div>
    </div>
</div>

{{-- ── Address ── --}}
<div class="address-card">
    <div class="address-card-header">
        <div class="detail-card-icon icon-solar-teal" style="width:36px;height:36px;border-radius:8px;">
            <i class="bi bi-geo-alt"></i>
        </div>
        <div class="detail-label mb-0">Street Address</div>
    </div>
    @if($technician->address)
        <p class="address-text mb-0">{{ $technician->address }}</p>
    @else
        <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No address provided</p>
    @endif
</div>

{{-- ── Timestamps ── --}}
<div class="timestamps-row">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $technician->created_at ? $technician->created_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $technician->updated_at ? $technician->updated_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('technicians.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <form action="{{ route('technicians.destroy', $technician->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('technicians.edit', $technician->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Technician
    </a>
</div>

@endsection