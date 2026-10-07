@extends('layouts.admin')

@section('content')

<style>
    /* ─── Customer Details Specific Premium Styles ─── */
    .customer-hero {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #111827 100%);
        border: 1px solid rgba(245, 130, 32, 0.25);
        border-radius: 18px;
        padding: 24px 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.18), 0 0 24px -4px rgba(245, 130, 32, 0.1);
        margin-bottom: 24px;
    }
    .customer-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        background: radial-gradient(circle, rgba(245, 130, 32, 0.2) 0%, rgba(245, 130, 32, 0.05) 50%, transparent 70%);
        pointer-events: none;
        border-radius: 50%;
    }
    .hero-avatar-circle {
        width: 62px;
        height: 62px;
        border-radius: 16px;
        background: linear-gradient(135deg, #F58220 0%, #EA580C 100%);
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
        font-weight: 800;
        box-shadow: 0 6px 18px rgba(245, 130, 32, 0.35);
        border: 2px solid rgba(255, 255, 255, 0.15);
        flex-shrink: 0;
    }
    .hero-title {
        color: #FFFFFF;
        font-size: 1.35rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        margin: 0;
    }
    .hero-meta-row {
        color: #94A3B8;
        font-size: 0.86rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 4px;
    }
    .hero-meta-row strong {
        color: #F8FAFC;
        font-weight: 600;
    }
    .hero-meta-row .meta-dot {
        color: #64748B;
        font-size: 0.75rem;
    }

    /* ─── Hero Buttons ─── */
    .btn-hero-ghost {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.16);
        color: #F1F5F9;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.84rem;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        backdrop-filter: blur(8px);
        transition: all 0.2s ease;
    }
    .btn-hero-ghost:hover {
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.3);
        color: #FFFFFF;
        transform: translateY(-1px);
    }
    .btn-hero-primary {
        background: linear-gradient(135deg, #F58220 0%, #E06D09 100%);
        border: 1px solid #F58220;
        color: #FFFFFF;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.84rem;
        padding: 8px 18px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(245, 130, 32, 0.35);
        transition: all 0.2s ease;
    }
    .btn-hero-primary:hover {
        background: linear-gradient(135deg, #EA580C 0%, #C2410C 100%);
        border-color: #EA580C;
        color: #FFFFFF;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(245, 130, 32, 0.45);
    }
    .btn-hero-accent {
        background: rgba(245, 130, 32, 0.12);
        border: 1px solid rgba(245, 130, 32, 0.35);
        color: #FFA756;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.84rem;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        backdrop-filter: blur(8px);
        transition: all 0.2s ease;
    }
    .btn-hero-accent:hover {
        background: rgba(245, 130, 32, 0.22);
        border-color: #F58220;
        color: #FFBD7A;
        transform: translateY(-1px);
    }

    /* ─── Contact Info Chips ─── */
    .customer-meta-chips-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding-top: 16px;
        margin-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    .customer-meta-chip {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 8px 14px;
        color: #E2E8F0;
        font-size: 0.84rem;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        backdrop-filter: blur(6px);
        transition: all 0.2s ease;
    }
    .customer-meta-chip:hover {
        background: rgba(255, 255, 255, 0.09);
        border-color: rgba(245, 130, 32, 0.35);
        color: #FFFFFF;
    }
    .customer-meta-chip i {
        color: #F58220;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .customer-meta-chip a {
        color: #E2E8F0;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .customer-meta-chip a:hover {
        color: #FFA756;
    }
    .customer-meta-chip.chip-address {
        flex-grow: 1;
        min-width: 260px;
    }

    /* ─── Stepper Pipeline Tabs ─── */
    .flow-stepper-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    @media (max-width: 991.98px) {
        .flow-stepper-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 575.98px) {
        .flow-stepper-container {
            grid-template-columns: 1fr;
        }
    }
    .flow-step-card {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 14px;
        padding: 16px 18px;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        text-align: left;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }
    .flow-step-card:hover {
        transform: translateY(-2px);
        border-color: #CBD5E1;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }
    .flow-step-card.active {
        background: linear-gradient(180deg, #FFFFFF 0%, #FFFDF9 100%);
        border-color: #F58220;
        box-shadow: 0 8px 22px -3px rgba(245, 130, 32, 0.18), 0 2px 6px rgba(245, 130, 32, 0.08);
    }
    .flow-step-card.active::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3.5px;
        background: linear-gradient(90deg, #F58220, #FFA756);
        border-radius: 14px 14px 0 0;
    }
    .step-badge-num {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: #F1F5F9;
        color: #475569;
        font-weight: 700;
        font-size: 0.78rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .flow-step-card.active .step-badge-num {
        background: #F58220;
        color: #FFFFFF;
        box-shadow: 0 2px 8px rgba(245, 130, 32, 0.4);
    }
    .step-card-title {
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.4px;
        color: #1E293B;
        text-transform: uppercase;
    }
    .step-card-desc {
        font-size: 0.78rem;
        color: #64748B;
        margin-top: 3px;
    }
    .step-count-pill {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
    }
    .step-count-pill.has-items {
        background: #ECFDF5;
        color: #047857;
        border: 1px solid #A7F3D0;
    }
    .step-count-pill.empty-items {
        background: #F8FAFC;
        color: #94A3B8;
        border: 1px solid #E2E8F0;
    }

    /* ─── Step Content Panels ─── */
    .flow-panel-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .flow-panel-header {
        padding: 18px 24px;
        background: #F8FAFC;
        border-bottom: 1px solid #EEF2F6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .btn-flow-action {
        background: linear-gradient(135deg, #F58220 0%, #E06D09 100%);
        color: #FFFFFF;
        border: 1px solid #F58220;
        border-radius: 10px;
        padding: 8px 18px;
        font-weight: 600;
        font-size: 0.84rem;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(245, 130, 32, 0.25);
        transition: all 0.2s ease;
    }
    .btn-flow-action:hover {
        background: linear-gradient(135deg, #EA580C 0%, #C2410C 100%);
        border-color: #EA580C;
        color: #FFFFFF;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(245, 130, 32, 0.35);
    }
    .btn-flow-action-secondary {
        background: #FFFFFF;
        color: #334155;
        border: 1.5px solid #D1D5DB;
        border-radius: 10px;
        padding: 7px 16px;
        font-weight: 600;
        font-size: 0.84rem;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-flow-action-secondary:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
        color: #0F172A;
        transform: translateY(-1px);
    }

    .empty-step-box {
        padding: 48px 24px;
        text-align: center;
    }
    .empty-step-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #FFF7ED;
        color: #F58220;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 14px;
        box-shadow: 0 4px 12px rgba(245, 130, 32, 0.15);
    }

    .table-modern thead th {
        background: #F8FAFC;
        color: #64748B;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 20px;
        border-bottom: 1px solid #E2E8F0;
    }
    .table-modern tbody td {
        padding: 14px 20px;
        vertical-align: middle;
        font-size: 0.88rem;
        border-bottom: 1px solid #F1F5F9;
    }
    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }
</style>

{{-- ══════════════════════════════════════════════════════════════════════
     CUSTOMER PROFILE HERO (Unified Header & Profile Card)
══════════════════════════════════════════════════════════════════════ --}}
<div class="customer-hero">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="hero-avatar-circle">
                {{ strtoupper(substr($customer->name, 0, 1)) }}
            </div>
            <div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h2 class="hero-title">{{ $customer->name }}</h2>
                    <span class="badge rounded-pill fw-semibold px-2.5 py-1 text-xs" style="
                        @if(($customer->customer_type ?? 'Residential') === 'Residential') background: #DBEAFE; color: #1E40AF; border: 1px solid #93C5FD;
                        @elseif(($customer->customer_type ?? '') === 'Commercial') background: #EDE9FE; color: #5B21B6; border: 1px solid #C4B5FD;
                        @else background: #F3F4F6; color: #374151; border: 1px solid #D1D5DB; @endif
                    ">
                        <i class="bi bi-tag-fill me-1"></i>{{ $customer->customer_type ?? 'Residential' }}
                    </span>
                    @if($customer->status == 'Active')
                        <span class="badge rounded-pill px-2.5 py-1 text-xs fw-semibold" style="background: rgba(16, 185, 129, 0.18); color: #34D399; border: 1px solid rgba(16, 185, 129, 0.35);">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.45rem;"></i> Active Customer
                        </span>
                    @else
                        <span class="badge rounded-pill px-2.5 py-1 text-xs fw-semibold" style="background: rgba(148, 163, 184, 0.18); color: #CBD5E1; border: 1px solid rgba(148, 163, 184, 0.35);">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.45rem;"></i> Inactive
                        </span>
                    @endif
                </div>
                <div class="hero-meta-row">
                    <span>Customer ID: <strong>#CUST-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</strong></span>
                    <span class="meta-dot">•</span>
                    <span>Registered: <strong>{{ $customer->created_at ? $customer->created_at->format('M d, Y') : '—' }}</strong></span>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('customers.index') }}" class="btn-hero-ghost">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn-hero-primary">
                <i class="bi bi-pencil-square"></i> Edit Customer
            </a>
            <a href="{{ route('projects.create', ['customer_id' => $customer->id]) }}" class="btn-hero-accent">
                <i class="bi bi-sun"></i> Add Project
            </a>
        </div>
    </div>

    {{-- Contact Info Chips --}}
    <div class="customer-meta-chips-grid">
        <div class="customer-meta-chip">
            <i class="bi bi-telephone-fill"></i>
            @if($customer->phone)
                <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
            @else
                <span class="text-secondary">No phone</span>
            @endif
        </div>

        <div class="customer-meta-chip">
            <i class="bi bi-envelope-fill"></i>
            @if($customer->email)
                <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
            @else
                <span class="text-secondary">No email</span>
            @endif
        </div>

        <div class="customer-meta-chip">
            <i class="bi bi-building"></i>
            <span>{{ collect([$customer->city, $customer->state, $customer->pincode])->filter()->join(', ') ?: 'Address location not set' }}</span>
        </div>

        <div class="customer-meta-chip chip-address">
            <i class="bi bi-geo-alt-fill"></i>
            <span class="text-truncate" style="max-width: 520px;" title="{{ $customer->address }}">{{ $customer->address ?: 'Installation address not set' }}</span>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     STEP-BY-STEP LIFECYCLE PIPELINE TABS
══════════════════════════════════════════════════════════════════════ --}}
<div class="flow-stepper-container">
    {{-- Step 1: Site Survey --}}
    <div class="flow-step-card active" onclick="switchStep('step-surveys', this)">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <div class="d-flex align-items-center gap-2">
                <span class="step-badge-num">1</span>
                <span class="step-card-title">SITE SURVEYS</span>
            </div>
            <span class="step-count-pill {{ $customer->siteSurveys->count() > 0 ? 'has-items' : 'empty-items' }}">
                {{ $customer->siteSurveys->count() }}
            </span>
        </div>
        <div class="step-card-desc text-truncate">Roof &amp; capacity survey</div>
    </div>

    {{-- Step 2: Quotation --}}
    <div class="flow-step-card" onclick="switchStep('step-quotations', this)">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <div class="d-flex align-items-center gap-2">
                <span class="step-badge-num">2</span>
                <span class="step-card-title">QUOTATIONS</span>
            </div>
            <span class="step-count-pill {{ $customer->quotations->count() > 0 ? 'has-items' : 'empty-items' }}">
                {{ $customer->quotations->count() }}
            </span>
        </div>
        <div class="step-card-desc text-truncate">Proposals &amp; pricing</div>
    </div>

    {{-- Step 3: Service Requests & Jobs --}}
    <div class="flow-step-card" onclick="switchStep('step-jobs', this)">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <div class="d-flex align-items-center gap-2">
                <span class="step-badge-num">3</span>
                <span class="step-card-title">JOB / SERVICES</span>
            </div>
            <span class="step-count-pill {{ $customer->serviceRequests->count() > 0 ? 'has-items' : 'empty-items' }}">
                {{ $customer->serviceRequests->count() }}
            </span>
        </div>
        <div class="step-card-desc text-truncate">Technician assignment</div>
    </div>

    {{-- Step 4: Invoices --}}
    <div class="flow-step-card" onclick="switchStep('step-invoices', this)">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <div class="d-flex align-items-center gap-2">
                <span class="step-badge-num">4</span>
                <span class="step-card-title">INVOICES</span>
            </div>
            <span class="step-count-pill {{ $customer->invoices->count() > 0 ? 'has-items' : 'empty-items' }}">
                {{ $customer->invoices->count() }}
            </span>
        </div>
        <div class="step-card-desc text-truncate">Billing &amp; payments</div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     STEP 1 PANEL: SITE SURVEYS
══════════════════════════════════════════════════════════════════════ --}}
<div class="flow-panel-card step-panel" id="step-surveys">
    <div class="flow-panel-header">
        <div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-warning-subtle text-warning-emphasis p-1.5 rounded"><i class="bi bi-map fs-6"></i></span>
                <h6 class="mb-0 fw-bold text-dark">Step 1: Site Surveys</h6>
            </div>
            <p class="text-muted small mb-0 mt-0.5">Physical inspection, shadow analysis, roof structure, and technical feasibility.</p>
        </div>
        <a href="{{ route('site-surveys.create', ['customer_id' => $customer->id, 'site_address' => $customer->address]) }}" class="btn-flow-action">
            <i class="bi bi-plus-lg"></i> Add Site Survey
        </a>
    </div>

    <div class="p-0">
        @if($customer->siteSurveys->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Survey No</th>
                            <th>Survey Date</th>
                            <th>Surveyor</th>
                            <th>Capacity (kW)</th>
                            <th>Roof Type</th>
                            <th>Feasibility</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->siteSurveys as $survey)
                            <tr>
                                <td class="fw-bold text-dark">{{ $survey->survey_number }}</td>
                                <td>{{ $survey->survey_date ? $survey->survey_date->format('d M Y') : '—' }}</td>
                                <td>{{ $survey->surveyor?->name ?? '—' }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $survey->required_solar_capacity ? $survey->required_solar_capacity . ' kW' : '—' }}</span></td>
                                <td>{{ $survey->roof_type ?? '—' }}</td>
                                <td>{{ $survey->installation_feasibility ?? '—' }}</td>
                                <td>
                                    @php
                                        $sColors = [
                                            'Pending' => 'bg-warning-subtle text-warning-emphasis',
                                            'Scheduled' => 'bg-info-subtle text-info-emphasis',
                                            'Completed' => 'bg-success-subtle text-success-emphasis',
                                            'Approved' => 'bg-primary-subtle text-primary-emphasis',
                                            'Rejected' => 'bg-danger-subtle text-danger-emphasis',
                                        ];
                                    @endphp
                                    <span class="badge {{ $sColors[$survey->status] ?? 'bg-secondary' }} px-2 py-1">
                                        {{ $survey->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('site-surveys.show', $survey->id) }}" class="btn btn-sm btn-outline-secondary px-2 py-1" title="View Survey">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('site-surveys.edit', $survey->id) }}" class="btn btn-sm btn-outline-primary px-2 py-1 ms-1" title="Edit Survey">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-step-box">
                <div class="empty-step-icon"><i class="bi bi-map"></i></div>
                <h6 class="fw-bold text-dark mb-1">No Site Survey Recorded Yet</h6>
                <p class="text-muted small mb-3">Record site roof measurement, electricity load, and feasibility assessment for {{ $customer->name }}.</p>
                <a href="{{ route('site-surveys.create', ['customer_id' => $customer->id, 'site_address' => $customer->address]) }}" class="btn-flow-action">
                    <i class="bi bi-plus-lg"></i> Create First Site Survey
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     STEP 2 PANEL: QUOTATIONS
══════════════════════════════════════════════════════════════════════ --}}
<div class="flow-panel-card step-panel d-none" id="step-quotations">
    <div class="flow-panel-header">
        <div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary-subtle text-primary-emphasis p-1.5 rounded"><i class="bi bi-file-earmark-ruled fs-6"></i></span>
                <h6 class="mb-0 fw-bold text-dark">Step 2: Quotations &amp; Proposals</h6>
            </div>
            <p class="text-muted small mb-0 mt-0.5">Customized proposal, system sizing, MNRE subsidy, and formal quotation printing.</p>
        </div>
        <a href="{{ route('quotations.create', ['customer_id' => $customer->id]) }}" class="btn-flow-action">
            <i class="bi bi-plus-lg"></i> Create Quotation
        </a>
    </div>

    <div class="p-0">
        @if($customer->quotations->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Quotation No</th>
                            <th>Date</th>
                            <th>System Size</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->quotations as $quote)
                            <tr>
                                <td class="fw-bold text-dark">{{ $quote->quotation_number }}</td>
                                <td>{{ $quote->quotation_date ? $quote->quotation_date->format('d M Y') : '—' }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $quote->system_size ? $quote->system_size . ' kW' : '—' }}</span></td>
                                <td class="fw-bold text-dark">₹ {{ number_format($quote->grand_total ?? 0, 2) }}</td>
                                <td>
                                    @php
                                        $qColors = [
                                            'Draft' => 'bg-secondary-subtle text-secondary-emphasis',
                                            'Sent' => 'bg-info-subtle text-info-emphasis',
                                            'Accepted' => 'bg-success-subtle text-success-emphasis',
                                            'Rejected' => 'bg-danger-subtle text-danger-emphasis',
                                        ];
                                    @endphp
                                    <span class="badge {{ $qColors[$quote->status] ?? 'bg-secondary' }} px-2 py-1">
                                        {{ $quote->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('quotations.print', $quote->id) }}" target="_blank" class="btn btn-sm btn-warning text-white px-2 py-1" style="background:#F58220;border:none;" title="Print / PDF Quotation">
                                        <i class="bi bi-printer"></i> Print
                                    </a>
                                    <a href="{{ route('quotations.show', $quote->id) }}" class="btn btn-sm btn-outline-secondary px-2 py-1 ms-1" title="View Quotation">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('quotations.edit', $quote->id) }}" class="btn btn-sm btn-outline-primary px-2 py-1 ms-1" title="Edit Quotation">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-step-box">
                <div class="empty-step-icon"><i class="bi bi-file-earmark-ruled"></i></div>
                <h6 class="fw-bold text-dark mb-1">No Quotation Created Yet</h6>
                <p class="text-muted small mb-3">Generate a formal solar quote with panel sizing, inverter brand, subsidy &amp; bank details.</p>
                <a href="{{ route('quotations.create', ['customer_id' => $customer->id]) }}" class="btn-flow-action">
                    <i class="bi bi-plus-lg"></i> Create Quotation
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     STEP 3 PANEL: SERVICE REQUESTS & JOB ASSIGNMENTS
══════════════════════════════════════════════════════════════════════ --}}
<div class="flow-panel-card step-panel d-none" id="step-jobs">
    <div class="flow-panel-header">
        <div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success-subtle text-success-emphasis p-1.5 rounded"><i class="bi bi-tools fs-6"></i></span>
                <h6 class="mb-0 fw-bold text-dark">Step 3: Service Requests &amp; Job Assignments</h6>
            </div>
            <p class="text-muted small mb-0 mt-0.5">Execution work orders, dispatching technician teams, and live field status tracking.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('service-requests.create', ['customer_id' => $customer->id]) }}" class="btn-flow-action">
                <i class="bi bi-plus-lg"></i> New Service Request
            </a>
            <a href="{{ route('job-assignments.create') }}" class="btn-flow-action-secondary">
                <i class="bi bi-person-gear"></i> Assign Job
            </a>
        </div>
    </div>

    <div class="p-0">
        @if($customer->serviceRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Request Date</th>
                            <th>Service Type</th>
                            <th>Priority</th>
                            <th>Assigned Tech</th>
                            <th>Request Status</th>
                            <th>Job Dispatch</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->serviceRequests as $sr)
                            <tr>
                                <td>{{ $sr->request_date ? $sr->request_date->format('d M Y') : '—' }}</td>
                                <td class="fw-bold text-dark">{{ $sr->service?->service_name ?? 'Solar Installation / Service' }}</td>
                                <td>
                                    @php
                                        $pColors = [
                                            'Urgent' => 'bg-danger text-white',
                                            'High' => 'bg-danger-subtle text-danger-emphasis',
                                            'Medium' => 'bg-warning-subtle text-warning-emphasis',
                                            'Low' => 'bg-info-subtle text-info-emphasis',
                                        ];
                                    @endphp
                                    <span class="badge {{ $pColors[$sr->priority] ?? 'bg-secondary' }}">
                                        {{ $sr->priority }}
                                    </span>
                                </td>
                                <td>{{ $sr->technician?->name ?? 'Unassigned' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $sr->status }}</span>
                                </td>
                                <td>
                                    @if($sr->jobAssignments && $sr->jobAssignments->count() > 0)
                                        @foreach($sr->jobAssignments as $ja)
                                             <div class="small mb-1">
                                                <i class="bi bi-person-badge text-primary me-1"></i>{{ $ja->technician?->name ?? 'Tech' }} 
                                                <span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $ja->status }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <a href="{{ route('job-assignments.create', ['service_request_id' => $sr->id]) }}" class="btn btn-xs btn-outline-success py-0 px-2 small" style="font-size:0.75rem;">
                                            + Assign Tech
                                        </a>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('service-requests.show', $sr->id) }}" class="btn btn-sm btn-outline-secondary px-2 py-1" title="View Request">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('service-requests.edit', $sr->id) }}" class="btn btn-sm btn-outline-primary px-2 py-1 ms-1" title="Edit Request">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-step-box">
                <div class="empty-step-icon"><i class="bi bi-tools"></i></div>
                <h6 class="fw-bold text-dark mb-1">No Service Request Or Job Created Yet</h6>
                <p class="text-muted small mb-3">Create an installation service order and assign a technician to execute the job.</p>
                <a href="{{ route('service-requests.create', ['customer_id' => $customer->id]) }}" class="btn-flow-action">
                    <i class="bi bi-plus-lg"></i> Create Service Request
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     STEP 4 PANEL: INVOICES & BILLING
══════════════════════════════════════════════════════════════════════ --}}
<div class="flow-panel-card step-panel d-none" id="step-invoices">
    <div class="flow-panel-header">
        <div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-purple-subtle text-purple-emphasis p-1.5 rounded" style="background:#f3e8ff;color:#6b21a8;"><i class="bi bi-receipt fs-6"></i></span>
                <h6 class="mb-0 fw-bold text-dark">Step 4: Invoices &amp; Payments</h6>
            </div>
            <p class="text-muted small mb-0 mt-0.5">Tax invoices, payment receipts, balance settlements, and financial tracking.</p>
        </div>
        <a href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}" class="btn-flow-action">
            <i class="bi bi-plus-lg"></i> Create Invoice
        </a>
    </div>

    <div class="p-0">
        @if($customer->invoices->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Payment Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->invoices as $inv)
                            <tr>
                                <td class="fw-bold text-dark">{{ $inv->invoice_number }}</td>
                                <td>{{ $inv->invoice_date ? $inv->invoice_date->format('d M Y') : '—' }}</td>
                                <td>{{ $inv->due_date ? $inv->due_date->format('d M Y') : '—' }}</td>
                                <td class="fw-bold text-dark">₹ {{ number_format($inv->total_amount ?? 0, 2) }}</td>
                                <td class="text-success fw-semibold">₹ {{ number_format($inv->paid_amount ?? 0, 2) }}</td>
                                <td>
                                    @php
                                        $invColors = [
                                            'Paid' => 'bg-success-subtle text-success-emphasis',
                                            'Partial' => 'bg-warning-subtle text-warning-emphasis',
                                            'Unpaid' => 'bg-danger-subtle text-danger-emphasis',
                                            'Overdue' => 'bg-danger text-white',
                                        ];
                                    @endphp
                                    <span class="badge {{ $invColors[$inv->payment_status] ?? 'bg-secondary' }} px-2 py-1">
                                        {{ $inv->payment_status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('invoices.show', $inv->id) }}" class="btn btn-sm btn-outline-secondary px-2 py-1" title="View Invoice">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('invoices.edit', $inv->id) }}" class="btn btn-sm btn-outline-primary px-2 py-1 ms-1" title="Edit Invoice">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-step-box">
                <div class="empty-step-icon"><i class="bi bi-receipt"></i></div>
                <h6 class="fw-bold text-dark mb-1">No Invoice Created Yet</h6>
                <p class="text-muted small mb-3">Generate tax invoice and record customer payment receipt.</p>
                <a href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}" class="btn-flow-action">
                    <i class="bi bi-plus-lg"></i> Create Invoice
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ── Bottom Delete / Management Area ── --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-3 border-top">
    <a href="{{ route('customers.index') }}" class="btn-flow-action-secondary">
        <i class="bi bi-arrow-left"></i> Back to Customers List
    </a>
    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger px-3 py-2 rounded-3" onclick="return confirm('Are you sure you want to delete this customer?');">
            <i class="bi bi-trash3 me-1"></i> Delete Customer
        </button>
    </form>
</div>

<script>
    function switchStep(stepId, cardElem) {
        // Remove active from all cards
        document.querySelectorAll('.flow-step-card').forEach(c => c.classList.remove('active'));
        // Add active to clicked card
        cardElem.classList.add('active');

        // Hide all step panels
        document.querySelectorAll('.step-panel').forEach(p => p.classList.add('d-none'));
        // Show target panel
        const target = document.getElementById(stepId);
        if (target) {
            target.classList.remove('d-none');
        }
    }
</script>

@endsection
