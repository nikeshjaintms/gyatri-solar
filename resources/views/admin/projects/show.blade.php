@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-sun"></i></span>
        Solar Project Details
    </h1>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('projects.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to Projects
        </a>
        <a href="{{ route('projects.edit', $project) }}" class="btn-edit-primary">
            <i class="bi bi-pencil"></i> Edit Project
        </a>
    </div>
</div>

{{-- ── Profile Hero ── --}}
<div class="profile-hero">
    <div class="hero-icon-wrap" style="background: linear-gradient(135deg, #F97316, #EA580C);">
        <i class="bi bi-sun-fill text-white"></i>
    </div>
    <div class="hero-info">
        <h2 class="hero-name">{{ $project->project_name }}</h2>
        <div class="hero-meta">
            <span class="hero-meta-chip">
                <i class="bi bi-person"></i>
                <a href="{{ route('customers.show', $project->customer) }}" class="text-white text-decoration-none">
                    {{ $project->customer->name }}
                </a>
            </span>
            <span class="hero-meta-chip">
                <i class="bi bi-tag"></i> {{ $project->customer_type ?? 'Residential' }}
            </span>
            <span class="hero-meta-chip">
                <i class="bi bi-lightning-charge-fill text-warning"></i> {{ number_format((float) $project->solar_capacity, 2) }} kW
            </span>
        </div>
        @if($project->status === 'Completed')
            <span class="hero-status-active"><span class="dot"></span> Completed</span>
        @elseif($project->status === 'In Progress')
            <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 px-2.5 py-1 rounded-pill small"><i class="bi bi-arrow-repeat me-1"></i> In Progress</span>
        @elseif($project->status === 'Cancelled')
            <span class="hero-status-inactive"><span class="dot"></span> Cancelled</span>
        @else
            <span class="badge bg-info bg-opacity-25 text-info border border-info border-opacity-50 px-2.5 py-1 rounded-pill small"><i class="bi bi-circle-fill me-1" style="font-size:0.4rem;"></i> New</span>
        @endif
    </div>
    <div class="hero-price">
        <div class="hero-price-label">Solar Capacity</div>
        <div class="hero-price-value">{{ number_format((float) $project->solar_capacity, 2) }} <span style="font-size:1rem; font-weight:600;">kW</span></div>
    </div>
</div>

{{-- ── Detail Grid ── --}}
<div class="detail-grid">
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-person"></i></div>
        <div>
            <div class="detail-label">Customer</div>
            <div class="detail-value">
                <a href="{{ route('customers.show', $project->customer) }}" class="text-dark fw-semibold text-decoration-none">
                    {{ $project->customer->name }}
                </a>
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-tag"></i></div>
        <div>
            <div class="detail-label">Property Type</div>
            <div class="detail-value">
                <span class="badge rounded-pill fw-medium px-2.5 py-1 text-xs" style="
                    @if($project->customer_type === 'Residential') background: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE;
                    @elseif($project->customer_type === 'Commercial') background: #F5F3FF; color: #6D28D9; border: 1px solid #DDD6FE;
                    @else background: #F3F4F6; color: #4B5563; border: 1px solid #E5E7EB; @endif
                ">
                    {{ $project->customer_type ?? 'Residential' }}
                </span>
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-calendar3"></i></div>
        <div>
            <div class="detail-label">Timeline / Schedule</div>
            <div class="detail-value">
                {{ $project->start_date?->format('d M Y') ?? 'Not started' }}
                @if($project->completion_date)
                    – {{ $project->completion_date->format('d M Y') }}
                @endif
            </div>
        </div>
    </div>
    <div class="detail-card">
        <div class="detail-card-icon icon-solar-teal"><i class="bi bi-activity"></i></div>
        <div>
            <div class="detail-label">Status</div>
            <div class="detail-value">
                {{ $project->status }}
            </div>
        </div>
    </div>
</div>

{{-- ── Installation Address & Notes ── --}}
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
        <div class="desc-card h-100">
            <div class="desc-card-header">
                <div class="detail-card-icon icon-solar-orange" style="width:36px;height:36px;border-radius:8px;">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div class="detail-label mb-0">Installation Address</div>
            </div>
            <p class="desc-text mb-0">{{ $project->installation_address }}</p>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="desc-card h-100">
            <div class="desc-card-header">
                <div class="detail-card-icon icon-solar-teal" style="width:36px;height:36px;border-radius:8px;">
                    <i class="bi bi-card-text"></i>
                </div>
                <div class="detail-label mb-0">Notes & Specifications</div>
            </div>
            @if($project->notes)
                <p class="desc-text mb-0">{{ $project->notes }}</p>
            @else
                <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No extra notes recorded.</p>
            @endif
        </div>
    </div>
</div>

{{-- ── Linked Records Stats ── --}}
<div class="row g-3">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
            <div class="d-flex align-items-center gap-3">
                <div class="detail-card-icon icon-solar-orange"><i class="bi bi-file-earmark-text"></i></div>
                <div>
                    <div class="text-muted small">Quotations</div>
                    <div class="fs-4 fw-bold text-dark">{{ $project->quotations->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
            <div class="d-flex align-items-center gap-3">
                <div class="detail-card-icon icon-solar-green"><i class="bi bi-currency-dollar"></i></div>
                <div>
                    <div class="text-muted small">Payments</div>
                    <div class="fs-4 fw-bold text-dark">{{ $project->payments->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
            <div class="d-flex align-items-center gap-3">
                <div class="detail-card-icon icon-solar-teal"><i class="bi bi-tools"></i></div>
                <div>
                    <div class="text-muted small">Service Requests</div>
                    <div class="fs-4 fw-bold text-dark">{{ $project->serviceRequests->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-3" style="background:#fff; border:1px solid #E5E7EB;">
            <div class="d-flex align-items-center gap-3">
                <div class="detail-card-icon icon-solar-purple"><i class="bi bi-receipt"></i></div>
                <div>
                    <div class="text-muted small">Invoices</div>
                    <div class="fs-4 fw-bold text-dark">{{ $project->invoices->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection