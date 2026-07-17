@extends('layouts.admin')

@section('content')

<style>
    .badge-draft { background-color: #E5E7EB; color: #374151; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-sent { background-color: #E1EFFE; color: #1E429F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-accepted { background-color: #DEF7EC; color: #03543F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-rejected { background-color: #FDE8E8; color: #9B1C1C; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-expired { background-color: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-cancelled { background-color: #F3F4F6; color: #4B5563; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }

    .show-card-label { font-size: 0.82rem; color: #6B7280; font-weight: 500; text-transform: uppercase; margin-bottom: 4px; }
    .show-card-val { font-size: 0.95rem; color: #111827; font-weight: 600; }
</style>

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-file-earmark-text"></i></span>
        Quotation Details: {{ $quotation->quotation_number }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('quotations.print', $quotation->id) }}" target="_blank" class="btn-add-primary" style="background-color: #6366F1;">
            <i class="bi bi-printer"></i> Print Quotation
        </a>
        <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn-add-primary" style="background-color: #3B82F6;">
            <i class="bi bi-pencil"></i> Edit Quotation
        </a>
        <a href="{{ route('quotations.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Meta Details Card -->
    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 12px;">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="show-card-label">Quotation Number</div>
                    <div class="show-card-val"><span class="code-badge">{{ $quotation->quotation_number }}</span></div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="show-card-label">Quotation Date</div>
                    <div class="show-card-val">{{ $quotation->quotation_date?->format('d M Y') ?? '—' }}</div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="show-card-label">Valid Until</div>
                    <div class="show-card-val">{{ $quotation->valid_until?->format('d M Y') ?? '—' }}</div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="show-card-label">Related Enquiry</div>
                    <div class="show-card-val">
                        @if($quotation->enquiry)
                            <a href="{{ route('enquiries.show', $quotation->enquiry_id) }}" class="text-primary text-decoration-none">
                                {{ $quotation->enquiry->enquiry_number }}
                            </a>
                        @else
                            <span class="text-muted">None</span>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="show-card-label">Status</div>
                    <div class="show-card-val">
                        @php
                            $badge = match($quotation->status) {
                                'Draft' => 'badge-draft',
                                'Sent' => 'badge-sent',
                                'Accepted' => 'badge-accepted',
                                'Rejected' => 'badge-rejected',
                                'Expired' => 'badge-expired',
                                'Cancelled' => 'badge-cancelled',
                                default => 'badge-draft',
                            };
                        @endphp
                        <span class="{{ $badge }}">{{ $quotation->status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Card -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 12px; height: 100%;">
            <div class="show-card-label mb-2">Customer Details</div>
            <div class="d-flex align-items-center mb-3">
                <div class="td-avatar me-2" style="width:40px; height:40px; font-size:1rem; border-radius:50%;">
                    {{ strtoupper(substr($quotation->customer?->name ?? 'C', 0, 2)) }}
                </div>
                <div>
                    <div class="fw-bold text-dark">{{ $quotation->customer?->name ?? '—' }}</div>
                    <div class="text-muted small">{{ $quotation->customer?->email ?? 'No email recorded' }}</div>
                </div>
            </div>
            <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $quotation->customer?->phone ?? '—' }}</div>
            <div class="small text-muted mt-1"><i class="bi bi-geo-alt me-1"></i> {{ $quotation->customer?->address ?? '—' }}</div>
        </div>
    </div>
</div>

<!-- Quotation Items Card -->
<div class="card border-0 shadow-sm p-4 bg-white mb-4" style="border-radius: 12px;">
    <h6 class="fw-bold text-dark mb-3">Quotation Items Listing</h6>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th class="text-end" style="width: 80px;">Qty</th>
                    <th class="text-center" style="width: 80px;">Unit</th>
                    <th class="text-end" style="width: 120px;">Rate (₹)</th>
                    <th class="text-end" style="width: 110px;">Discount (%)</th>
                    <th class="text-end" style="width: 90px;">GST (%)</th>
                    <th class="text-end" style="width: 110px;">GST Amt (₹)</th>
                    <th class="text-end" style="width: 140px;">Line Total (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->items as $idx => $item)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td class="text-dark fw-medium">
                            @if($item->product)
                                <a href="{{ route('products.show', $item->product_id) }}" class="text-primary text-decoration-none fw-semibold">
                                    {{ $item->product->product_code }} - {{ $item->product->name }}
                                </a>
                            @else
                                {{ $item->product_service }}
                            @endif
                        </td>
                        <td style="color:#6B7280;">{{ $item->description ?? '—' }}</td>
                        <td class="text-end">{{ $item->quantity }}</td>
                        <td class="text-center"><span class="badge bg-light text-dark border">{{ $item->unit ?? '—' }}</span></td>
                        <td class="text-end">₹{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-end">{{ number_format($item->discount_percentage, 2) }}%</td>
                        <td class="text-end">{{ number_format($item->tax_percentage, 2) }}%</td>
                        <td class="text-end">₹{{ number_format($item->tax_amount, 2) }}</td>
                        <td class="text-end fw-semibold">₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Calculations summary -->
    <div class="row justify-content-end mt-3">
        <div class="col-12 col-md-4">
            <div class="d-flex justify-content-between py-1 small border-bottom">
                <span class="text-muted">Sub Total:</span>
                <span class="fw-semibold text-dark">₹{{ number_format($quotation->subtotal, 2) }}</span>
            </div>
            @if($quotation->discount > 0)
                <div class="d-flex justify-content-between py-1 small border-bottom">
                    <span class="text-muted">Total Discount:</span>
                    <span class="fw-semibold text-danger">-₹{{ number_format($quotation->discount, 2) }}</span>
                </div>
            @endif
            @if($quotation->tax_amount > 0)
                <div class="d-flex justify-content-between py-1 small border-bottom">
                    <span class="text-muted">Total Tax (GST):</span>
                    <span class="fw-semibold text-dark">₹{{ number_format($quotation->tax_amount, 2) }}</span>
                </div>
            @endif
            <div class="d-flex justify-content-between py-2 fs-5 border-top border-2 mt-1">
                <span class="fw-bold text-dark">Grand Total:</span>
                <span class="fw-bold text-success">₹{{ number_format($quotation->grand_total, 2) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Terms & Notes -->
<div class="row g-4">
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 12px;">
            <h6 class="fw-bold text-dark mb-2">Terms &amp; Conditions</h6>
            <div style="font-size:0.88rem; color:#4B5563; white-space: pre-line;">{{ $quotation->terms_conditions ?? 'None' }}</div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 12px;">
            <h6 class="fw-bold text-dark mb-2">Internal / Public Notes</h6>
            <div style="font-size:0.88rem; color:#4B5563; white-space: pre-line;">{{ $quotation->notes ?? 'None' }}</div>
        </div>
    </div>
</div>

@endsection
