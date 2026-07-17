@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-wrench-adjustable"></i></span>
        Service Details
    </h1>
    <a href="{{ route('services.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Profile Hero ── --}}
<div class="profile-hero">
    <div class="hero-icon-wrap">
        <i class="bi bi-wrench-adjustable"></i>
    </div>
    <div class="hero-info">
        <h2 class="hero-name">{{ $service->service_name }}</h2>
        <div class="hero-meta">
            @if($service->service_code)
                <span class="hero-meta-chip"><i class="bi bi-upc"></i> {{ $service->service_code }}</span>
            @endif
            @if($service->category)
                <span class="hero-meta-chip"><i class="bi bi-tag"></i> {{ $service->category }}</span>
            @endif
            @if($service->duration)
                <span class="hero-meta-chip"><i class="bi bi-clock"></i> {{ $service->duration }}</span>
            @endif
        </div>
        @if($service->status == 'Active')
            <span class="hero-status-active"><span class="dot"></span> Active</span>
        @else
            <span class="hero-status-inactive"><span class="dot"></span> Inactive</span>
        @endif
    </div>
    @if($service->price !== null)
        <div class="hero-price">
            <div class="hero-price-label">Service Price</div>
            <div class="hero-price-value"><span>$</span>{{ number_format($service->price, 2) }}</div>
        </div>
    @endif
</div>

{{-- ── Detail Grid ── --}}
<div class="detail-grid">
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-upc"></i></div>
        <div>
            <div class="detail-label">Service Code</div>
            <div class="detail-value {{ !$service->service_code ? 'empty' : '' }}">
                {{ $service->service_code ?? 'Not assigned' }}
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-tag"></i></div>
        <div>
            <div class="detail-label">Category</div>
            <div class="detail-value {{ !$service->category ? 'empty' : '' }}">
                {{ $service->category ?? 'Not assigned' }}
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-currency-dollar"></i></div>
        <div>
            <div class="detail-label">Price</div>
            <div class="detail-value {{ $service->price === null ? 'empty' : 'price-val' }}">
                {{ $service->price !== null ? '$'.number_format($service->price, 2) : 'Not set' }}
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-clock"></i></div>
        <div>
            <div class="detail-label">Duration</div>
            <div class="detail-value {{ !$service->duration ? 'empty' : '' }}">
                {{ $service->duration ?? 'Not specified' }}
            </div>
        </div>
    </div>
</div>

{{-- ── Description Card ── --}}
<div class="desc-card">
    <div class="desc-card-header">
        <div class="detail-card-icon icon-solar-teal" style="width:36px;height:36px;border-radius:8px;">
            <i class="bi bi-card-text"></i>
        </div>
        <div class="detail-label mb-0">Service Description</div>
    </div>
    @if($service->description)
        <p class="desc-text mb-0">{{ $service->description }}</p>
    @else
        <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No description provided</p>
    @endif
</div>

{{-- ── Timestamps ── --}}
<div class="timestamps-row">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $service->created_at ? $service->created_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $service->updated_at ? $service->updated_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('services.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('services.edit', $service->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Service
    </a>
</div>

@endsection
