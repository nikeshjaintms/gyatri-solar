@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-person-circle"></i></span>
        Customer Details
    </h1>
    <a href="{{ route('customers.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Profile Hero ── --}}
<div class="profile-hero">
    <div class="hero-avatar">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
    <div class="hero-info">
        <h2 class="hero-name">{{ $customer->name }}</h2>
        <p class="hero-spec">
            <i class="bi bi-building me-1"></i>
            {{ $customer->city ?? 'Location not set' }}
        </p>
        @if($customer->status == 'Active')
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
            <div class="detail-value {{ !$customer->email ? 'empty' : '' }}">
                {{ $customer->email ?? 'Not provided' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-telephone"></i></div>
        <div>
            <div class="detail-label">Phone Number</div>
            <div class="detail-value {{ !$customer->phone ? 'empty' : '' }}">
                {{ $customer->phone ?? 'Not provided' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-blue"><i class="bi bi-building"></i></div>
        <div>
            <div class="detail-label">City</div>
            <div class="detail-value {{ !$customer->city ? 'empty' : '' }}">
                {{ $customer->city ?? 'Not specified' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-toggle2-on"></i></div>
        <div>
            <div class="detail-label">Account Status</div>
            <div class="detail-value">
                @if($customer->status == 'Active')
                    <span class="badge-active">Active</span>
                @else
                    <span class="badge-inactive">Inactive</span>
                @endif
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
        <div class="detail-label mb-0">Street Address</div>
    </div>
    @if($customer->address)
        <p class="address-text mb-0">{{ $customer->address }}</p>
    @else
        <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No address provided</p>
    @endif
</div>

{{-- ── Timestamps ── --}}
<div class="timestamps-row">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $customer->created_at ? $customer->created_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $customer->updated_at ? $customer->updated_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('customers.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('customers.edit', $customer->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Customer
    </a>
</div>

@endsection
