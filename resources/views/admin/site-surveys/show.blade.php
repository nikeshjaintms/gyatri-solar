@extends('layouts.admin')

@section('content')

<style>
    .badge-pending { background-color: #E5E7EB; color: #374151; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-scheduled { background-color: #E1EFFE; color: #1E429F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-completed { background-color: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-approved { background-color: #DEF7EC; color: #03543F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-rejected { background-color: #FDE8E8; color: #9B1C1C; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }

    .detail-row { padding: 16px 20px; border-bottom: 1px solid #E8ECF0; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { font-size: 0.85rem; color: #6B7280; font-weight: 500; }
    .detail-value { font-size: 0.9rem; color: #111827; font-weight: 600; }
</style>

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-map"></i></span>
        Site Survey Details: {{ $survey->survey_number }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('site-surveys.edit', $survey->id) }}" class="btn-add-primary" style="background-color: #3B82F6;">
            <i class="bi bi-pencil"></i> Edit Survey
        </a>
        <a href="{{ route('site-surveys.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Meta Details -->
    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 12px;">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <span class="detail-label d-block">Survey Number</span>
                    <span class="detail-value"><span class="code-badge">{{ $survey->survey_number }}</span></span>
                </div>
                <div class="col-12 col-md-4">
                    <span class="detail-label d-block">Survey Date</span>
                    <span class="detail-value">{{ $survey->survey_date?->format('d M Y') ?? '—' }}</span>
                </div>
                <div class="col-12 col-md-4">
                    <span class="detail-label d-block">Survey Status</span>
                    <span class="detail-value">
                        @php
                            $badge = match($survey->status) {
                                'Pending' => 'badge-pending',
                                'Scheduled' => 'badge-scheduled',
                                'Completed' => 'badge-completed',
                                'Approved' => 'badge-approved',
                                'Rejected' => 'badge-rejected',
                                default => 'badge-pending',
                            };
                        @endphp
                        <span class="{{ $badge }}">{{ $survey->status }}</span>
                    </span>
                </div>
                <div class="col-12 col-md-4">
                    <span class="detail-label d-block">Assigned Surveyor</span>
                    <span class="detail-value text-dark">{{ $survey->surveyor?->name ?? 'Unassigned' }}</span>
                </div>
                <div class="col-12 col-md-4">
                    <span class="detail-label d-block">Related Enquiry</span>
                    <span class="detail-value">
                        @if($survey->enquiry)
                            <a href="{{ route('enquiries.show', $survey->enquiry_id) }}" class="text-primary text-decoration-none">
                                {{ $survey->enquiry->enquiry_number }}
                            </a>
                        @else
                            <span class="text-muted">None</span>
                        @endif
                    </span>
                </div>
                <div class="col-12 col-md-4">
                    <span class="detail-label d-block">Installation Feasibility</span>
                    <span class="detail-value">
                        @if($survey->installation_feasibility == 'Feasible')
                            <span class="text-success"><i class="bi bi-check-circle-fill"></i> Feasible</span>
                        @elseif($survey->installation_feasibility == 'Not Feasible')
                            <span class="text-danger"><i class="bi bi-x-circle-fill"></i> Not Feasible</span>
                        @else
                            <span class="text-warning"><i class="bi bi-exclamation-circle-fill"></i> Conditional</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Card -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 12px; height: 100%;">
            <span class="detail-label d-block mb-2">Customer Details</span>
            <div class="d-flex align-items-center mb-3">
                <div class="td-avatar me-2" style="width:40px; height:40px; font-size:1rem; border-radius:50%;">
                    {{ strtoupper(substr($survey->customer?->name ?? 'C', 0, 2)) }}
                </div>
                <div>
                    <div class="fw-bold text-dark">{{ $survey->customer?->name ?? '—' }}</div>
                    <div class="text-muted small">{{ $survey->customer?->email ?? 'No email recorded' }}</div>
                </div>
            </div>
            <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $survey->customer?->phone ?? '—' }}</div>
            <div class="small text-muted mt-1"><i class="bi bi-geo-alt me-1"></i> {{ $survey->site_address }}</div>
        </div>
    </div>
</div>

<!-- Technical Details Card -->
<div class="card border-0 shadow-sm p-4 bg-white mb-4" style="border-radius: 12px;">
    <h6 class="fw-bold text-dark mb-3">Technical Specifications Summary</h6>
    
    <div class="form-card-body p-0">
        <div class="detail-row row">
            <div class="col-6 col-md-3 detail-label">Property Type</div>
            <div class="col-6 col-md-3 detail-value">{{ $survey->property_type ?? '—' }}</div>
            <div class="col-6 col-md-3 detail-label">Roof Type</div>
            <div class="col-6 col-md-3 detail-value">{{ $survey->roof_type ?? '—' }}</div>
        </div>
        <div class="detail-row row">
            <div class="col-6 col-md-3 detail-label">Available Roof Area</div>
            <div class="col-6 col-md-3 detail-value">{{ $survey->available_area ?? '—' }}</div>
            <div class="col-6 col-md-3 detail-label">Suggested Solar Capacity</div>
            <div class="col-6 col-md-3 detail-value">{{ $survey->required_solar_capacity ?? '—' }}</div>
        </div>
        <div class="detail-row row">
            <div class="col-6 col-md-3 detail-label">Existing Electrical Load</div>
            <div class="col-6 col-md-3 detail-value">{{ $survey->existing_electricity_load ?? '—' }}</div>
            <div class="col-6 col-md-3 detail-label">Average Monthly Bill</div>
            <div class="col-6 col-md-3 detail-value">{{ $survey->average_electricity_bill ?? '—' }}</div>
        </div>
        <div class="detail-row row">
            <div class="col-6 col-md-3 detail-label">Meter Type</div>
            <div class="col-6 col-md-3 detail-value">{{ $survey->meter_type ?? '—' }}</div>
            <div class="col-6 col-md-3 detail-label">Shadow Condition</div>
            <div class="col-6 col-md-3 detail-value">{{ $survey->shadow_condition ?? '—' }}</div>
        </div>
        <div class="detail-row row">
            <div class="col-12 col-md-3 detail-label">Observations Notes</div>
            <div class="col-12 col-md-9 detail-value" style="font-weight: normal; color: #4B5563; white-space: pre-line;">{{ $survey->survey_notes ?? '—' }}</div>
        </div>
        <div class="detail-row row">
            <div class="col-12 col-md-3 detail-label">Recommendations</div>
            <div class="col-12 col-md-9 detail-value" style="font-weight: normal; color: #4B5563; white-space: pre-line;">{{ $survey->recommendation ?? '—' }}</div>
        </div>
    </div>
</div>

<!-- Uploaded Photos Grid -->
<div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 12px;">
    <h6 class="fw-bold text-dark mb-3">Site Inspection Photos</h6>
    @if($survey->site_photos && count($survey->site_photos) > 0)
        <div class="row g-3">
            @foreach($survey->site_photos as $photo)
                <div class="col-6 col-md-3">
                    <a href="{{ asset('storage/' . $photo) }}" target="_blank">
                        <img src="{{ asset('storage/' . $photo) }}" class="img-fluid rounded border shadow-sm" style="height: 180px; width: 100%; object-fit: cover;">
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-muted small p-3 border rounded bg-light">No inspection photos uploaded for this survey.</div>
    @endif
</div>

@endsection
