@extends('layouts.admin')

@section('content')

<style>
    .badge-new { background-color: #E5E7EB; color: #374151; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-contacted { background-color: #E1EFFE; color: #1E429F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-followup { background-color: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-converted { background-color: #DEF7EC; color: #03543F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-closed { background-color: #F3F4F6; color: #4B5563; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-cancelled { background-color: #FDE8E8; color: #9B1C1C; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    
    .detail-row { padding: 16px 20px; border-bottom: 1px solid #E8ECF0; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { font-size: 0.85rem; color: #6B7280; font-weight: 500; }
    .detail-value { font-size: 0.9rem; color: #111827; font-weight: 600; }
</style>

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-chat-left-text"></i></span>
        Enquiry Details: {{ $enquiry->enquiry_number }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn-add-primary" style="background-color: #3B82F6;">
            <i class="bi bi-pencil"></i> Edit Lead
        </a>
        <a href="{{ route('enquiries.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Enquiry Reference Details</h6>
    </div>

    <div class="form-card-body p-0">
        <!-- Enquiry Number -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Enquiry Number</div>
            <div class="col-12 col-md-9 detail-value">
                <span class="code-badge">{{ $enquiry->enquiry_number }}</span>
            </div>
        </div>

        <!-- Customer Name -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Customer Name</div>
            <div class="col-12 col-md-9 detail-value">
                <div class="td-name">
                    <div class="td-avatar">{{ strtoupper(substr($enquiry->customer_name, 0, 2)) }}</div>
                    <span>{{ $enquiry->customer_name }}</span>
                    @if($enquiry->customer_id)
                        <span class="badge bg-light text-primary ms-2" style="font-size:0.7rem; border:1px solid rgba(59,130,246,0.2);">Registered</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Numbers -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Contact / Phone</div>
            <div class="col-12 col-md-9 detail-value">
                {{ $enquiry->mobile_number }}
            </div>
        </div>

        <!-- Email -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Email Address</div>
            <div class="col-12 col-md-9 detail-value">
                {{ $enquiry->email ?? '—' }}
            </div>
        </div>

        <!-- Address -->
        <div class="detail-row row">
            <div class="col-12 col-md-3 detail-label">Site Address</div>
            <div class="col-12 col-md-9 detail-value" style="font-weight: normal; color: #374151;">
                {{ $enquiry->address ?? '—' }}
            </div>
        </div>

        <!-- Service / Product -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Product / Service Required</div>
            <div class="col-12 col-md-9 detail-value">
                {{ $enquiry->service_product }}
            </div>
        </div>

        <!-- Enquiry Date -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Enquiry Date</div>
            <div class="col-12 col-md-9 detail-value">
                {{ $enquiry->enquiry_date?->format('d M Y') ?? '—' }}
            </div>
        </div>

        <!-- Source -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Lead Source</div>
            <div class="col-12 col-md-9 detail-value">
                {{ $enquiry->enquiry_source ?? 'Direct / Walk-in' }}
            </div>
        </div>

        <!-- Assigned employee -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Assigned Staff</div>
            <div class="col-12 col-md-9 detail-value">
                {{ $enquiry->assignedEmployee?->name ?? 'Unassigned' }}
            </div>
        </div>

        <!-- Status -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Status</div>
            <div class="col-12 col-md-9 detail-value">
                @php
                    $badge = match($enquiry->status) {
                        'New' => 'badge-new',
                        'Contacted' => 'badge-contacted',
                        'Follow-up' => 'badge-followup',
                        'Converted' => 'badge-converted',
                        'Closed' => 'badge-closed',
                        'Cancelled' => 'badge-cancelled',
                        default => 'badge-new',
                    };
                @endphp
                <span class="{{ $badge }}">{{ $enquiry->status }}</span>
            </div>
        </div>

        <!-- Follow-up Date -->
        <div class="detail-row row align-items-center">
            <div class="col-12 col-md-3 detail-label">Follow-up Date</div>
            <div class="col-12 col-md-9 detail-value">
                @if($enquiry->follow_up_date)
                    <span class="text-warning">{{ $enquiry->follow_up_date->format('d M Y') }}</span>
                @else
                    <span class="text-muted">No follow-up scheduled</span>
                @endif
            </div>
        </div>

        <!-- Remarks -->
        <div class="detail-row row">
            <div class="col-12 col-md-3 detail-label">Remarks / Follow-up Notes</div>
            <div class="col-12 col-md-9 detail-value" style="font-weight: normal; color: #4B5563;">
                {{ $enquiry->remarks ?? '—' }}
            </div>
        </div>
    </div>
</div>

@endsection
