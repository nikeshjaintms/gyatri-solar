@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-receipt"></i></span>
        Invoice Details
    </h1>
    <a href="{{ route('invoices.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Invoice Hero Banner ── --}}
<div class="profile-hero" id="printableArea">
    {{-- Print Header (hidden in screen, shown in print) --}}
    <div class="print-only-header" style="display:none;">
        <div style="text-align:center; border-bottom:2px solid #F58220; padding-bottom:16px; margin-bottom:20px;">
            <h2 style="margin:0; font-size:1.4rem; font-weight:800; color:#050505;">☀ Gayatri Solar Energy</h2>
            <p style="margin:4px 0 0; font-size:0.85rem; color:#6B7280;">Solar Energy Solutions — Field Service Management</p>
        </div>
    </div>

    <div class="hero-icon-wrap">
        <i class="bi bi-receipt-cutoff" style="font-size:2rem;"></i>
    </div>
    <div class="hero-info">
        <h2 class="hero-name">{{ $invoice->invoice_no }}</h2>
        <p class="hero-spec">
            <i class="bi bi-person me-1"></i>{{ $invoice->customer->name ?? '—' }}
            @if($invoice->service)
                &nbsp;·&nbsp;<i class="bi bi-wrench me-1"></i>{{ $invoice->service->service_name }}
            @endif
        </p>
        <div class="hero-meta">
            <span class="hero-meta-chip"><i class="bi bi-calendar3 me-1"></i> {{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : '—' }}</span>
            @if($invoice->due_date)
                <span class="hero-meta-chip"><i class="bi bi-calendar-x me-1"></i> Due: {{ $invoice->due_date->format('d M Y') }}</span>
            @endif
            @if($invoice->payment_mode)
                <span class="hero-meta-chip"><i class="bi bi-credit-card me-1"></i> {{ $invoice->payment_mode }}</span>
            @endif
        </div>
        @php
            $statusClass = match($invoice->payment_status) {
                'Paid'           => 'hero-status-active',
                'Partially Paid' => 'hero-status-partial',
                'Cancelled'      => 'hero-status-inactive',
                default          => 'hero-status-unpaid',
            };
        @endphp
        <span class="{{ $statusClass }}">
            <span class="dot"></span>
            {{ $invoice->payment_status }}
        </span>
    </div>
    <div class="hero-price" style="text-align:right; position:relative; z-index:1; flex-shrink:0;">
        <div class="hero-price-label">Total Amount</div>
        <div class="hero-price-value"><span>₹</span>{{ number_format($invoice->total_amount, 2) }}</div>
    </div>
</div>

{{-- ── Amount Summary Cards ── --}}
<div class="inv-summary-row">
    <div class="inv-summary-card">
        <div class="inv-sum-icon" style="background:#FFF3E8; color:#D96A0B;"><i class="bi bi-calculator"></i></div>
        <div>
            <div class="detail-label">Subtotal</div>
            <div class="detail-value price-val">₹{{ number_format($invoice->subtotal, 2) }}</div>
        </div>
    </div>
    <div class="inv-summary-card">
        <div class="inv-sum-icon" style="background:#faf5ff; color:#7c3aed;"><i class="bi bi-tag"></i></div>
        <div>
            <div class="detail-label">Discount</div>
            <div class="detail-value" style="color:#7c3aed; font-weight:600;">− ₹{{ number_format($invoice->discount, 2) }}</div>
        </div>
    </div>
    <div class="inv-summary-card">
        <div class="inv-sum-icon" style="background:#eff6ff; color:#2563eb;"><i class="bi bi-percent"></i></div>
        <div>
            <div class="detail-label">Tax</div>
            <div class="detail-value" style="color:#2563eb; font-weight:600;">+ ₹{{ number_format($invoice->tax, 2) }}</div>
        </div>
    </div>
    <div class="inv-summary-card" style="border-color:rgba(245,130,32,0.3); background:#FFF7ED;">
        <div class="inv-sum-icon" style="background:#FFE4C4; color:#D96A0B;"><i class="bi bi-currency-rupee"></i></div>
        <div>
            <div class="detail-label">Total Amount</div>
            <div class="detail-value price-val" style="font-size:1.1rem;">₹{{ number_format($invoice->total_amount, 2) }}</div>
        </div>
    </div>
    <div class="inv-summary-card" style="border-color:rgba(34,197,94,0.25);">
        <div class="inv-sum-icon" style="background:#f0fdf4; color:#16a34a;"><i class="bi bi-cash-coin"></i></div>
        <div>
            <div class="detail-label">Paid Amount</div>
            <div class="detail-value" style="color:#16a34a; font-weight:600;">₹{{ number_format($invoice->paid_amount, 2) }}</div>
        </div>
    </div>
    <div class="inv-summary-card" style="border-color:rgba(220,38,38,0.2);">
        <div class="inv-sum-icon" style="background:#FEF2F2; color:#dc2626;"><i class="bi bi-wallet2"></i></div>
        <div>
            <div class="detail-label">Balance Due</div>
            <div class="detail-value" style="color:#dc2626; font-weight:600;">₹{{ number_format($invoice->balance_amount, 2) }}</div>
        </div>
    </div>
</div>

{{-- ── Detail Grid ── --}}
<div class="detail-grid">

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-person"></i></div>
        <div>
            <div class="detail-label">Customer</div>
            <div class="detail-value">{{ $invoice->customer->name ?? '—' }}</div>
            @if($invoice->customer->phone ?? false)
                <div style="font-size:0.8rem; color:#6B7280; margin-top:3px;">
                    <i class="bi bi-telephone me-1"></i>{{ $invoice->customer->phone }}
                </div>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-blue"><i class="bi bi-wrench"></i></div>
        <div>
            <div class="detail-label">Service</div>
            <div class="detail-value {{ !$invoice->service ? 'empty' : '' }}">
                {{ $invoice->service->service_name ?? 'Not linked' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-credit-card"></i></div>
        <div>
            <div class="detail-label">Payment Mode</div>
            <div class="detail-value {{ !$invoice->payment_mode ? 'empty' : '' }}">
                {{ $invoice->payment_mode ?? 'Not specified' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-teal"><i class="bi bi-clipboard2-check"></i></div>
        <div>
            <div class="detail-label">Service Request</div>
            <div class="detail-value {{ !$invoice->serviceRequest ? 'empty' : '' }}">
                @if($invoice->serviceRequest)
                    #{{ $invoice->serviceRequest->id }}
                @else
                    Not linked
                @endif
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-slate"><i class="bi bi-tools"></i></div>
        <div>
            <div class="detail-label">Job Assignment</div>
            <div class="detail-value {{ !$invoice->jobAssignment ? 'empty' : '' }}">
                @if($invoice->jobAssignment)
                    #{{ $invoice->jobAssignment->id }}
                    @if($invoice->jobAssignment->technician)
                        <div style="font-size:0.8rem; color:#6B7280; margin-top:3px;">
                            <i class="bi bi-person-badge me-1"></i>{{ $invoice->jobAssignment->technician->name }}
                        </div>
                    @endif
                @else
                    Not linked
                @endif
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-toggle2-on"></i></div>
        <div>
            <div class="detail-label">Payment Status</div>
            <div class="detail-value">
                @php
                    $badgeClass = match($invoice->payment_status) {
                        'Paid'           => 'badge-inv-paid',
                        'Partially Paid' => 'badge-inv-partial',
                        'Cancelled'      => 'badge-inv-cancelled',
                        default          => 'badge-inv-unpaid',
                    };
                @endphp
                <span class="{{ $badgeClass }}">{{ $invoice->payment_status }}</span>
            </div>
        </div>
    </div>

</div>

{{-- ── Notes Card ── --}}
@if($invoice->notes)
<div class="desc-card">
    <div class="desc-card-header">
        <div class="detail-card-icon icon-solar-slate" style="width:36px;height:36px;border-radius:8px;">
            <i class="bi bi-chat-left-text"></i>
        </div>
        <div class="detail-label mb-0">Notes / Remarks</div>
    </div>
    <p class="desc-text mb-0">{{ $invoice->notes }}</p>
</div>
@endif

{{-- ── Timestamps ── --}}
<div class="timestamps-row">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $invoice->created_at ? $invoice->created_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $invoice->updated_at ? $invoice->updated_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('invoices.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <button type="button" onclick="printInvoice()" class="btn-print-inv">
        <i class="bi bi-printer"></i> Print Invoice
    </button>
    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Invoice
    </a>
</div>

{{-- ── Invoice-specific badge styles ── --}}
<style>
/* Payment status badges */
.badge-inv-unpaid {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 20px;
    background: rgba(220,38,38,0.1); color: #dc2626;
    font-size: 0.75rem; font-weight: 600;
    border: 1px solid rgba(220,38,38,0.25);
}
.badge-inv-unpaid::before { content:''; width:6px; height:6px; border-radius:50%; background:#dc2626; display:block; }

.badge-inv-partial {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 20px;
    background: rgba(245,130,32,0.12); color: #D96A0B;
    font-size: 0.75rem; font-weight: 600;
    border: 1px solid rgba(245,130,32,0.3);
}
.badge-inv-partial::before { content:''; width:6px; height:6px; border-radius:50%; background:#F58220; display:block; }

.badge-inv-paid {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 20px;
    background: rgba(34,197,94,0.1); color: #16a34a;
    font-size: 0.75rem; font-weight: 600;
    border: 1px solid rgba(34,197,94,0.2);
}
.badge-inv-paid::before { content:''; width:6px; height:6px; border-radius:50%; background:#22c55e; display:block; }

.badge-inv-cancelled {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 20px;
    background: rgba(107,114,128,0.1); color: #6B7280;
    font-size: 0.75rem; font-weight: 600;
    border: 1px solid rgba(107,114,128,0.2);
}
.badge-inv-cancelled::before { content:''; width:6px; height:6px; border-radius:50%; background:#9CA3AF; display:block; }

/* Hero status overrides for show page */
.hero-status-unpaid {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 20px;
    background: rgba(220,38,38,0.18); color: #fca5a5;
    font-size: 0.82rem; font-weight: 600; border: 1px solid rgba(220,38,38,0.3);
}
.hero-status-unpaid .dot { width:7px; height:7px; border-radius:50%; background:#ef4444; display:block; }

.hero-status-partial {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 20px;
    background: rgba(245,130,32,0.18); color: #FFBA7A;
    font-size: 0.82rem; font-weight: 600; border: 1px solid rgba(245,130,32,0.35);
}
.hero-status-partial .dot { width:7px; height:7px; border-radius:50%; background:#F58220; display:block; }

/* Amount summary row */
.inv-summary-row {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}
.inv-summary-card {
    background: #fff; border-radius: 12px; padding: 16px 18px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    display: flex; align-items: center; gap: 13px;
    transition: transform 0.18s, box-shadow 0.18s;
}
.inv-summary-card:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,0.09); }
.inv-sum-icon {
    width: 40px; height: 40px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; flex-shrink: 0;
}

/* Print button */
.btn-print-inv {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 22px; border-radius: 9px;
    background: #fff; color: #2563eb; border: 1.5px solid #BFDBFE;
    font-weight: 500; font-size: 0.88rem; cursor: pointer; transition: all 0.18s;
    text-decoration: none;
}
.btn-print-inv:hover {
    background: #2563eb; color: #fff; border-color: #2563eb;
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.25);
}

/* Hide print section on screen */
.print-invoice-section {
    display: none;
}

/* ══════════════════════════
   PRINT STYLES
   ══════════════════════════ */
@media print {
    /* Hide layout wrapper, sidebar, header, and buttons */
    .sidebar-container,
    .topbar-container,
    .show-page-header,
    .profile-hero,
    .inv-summary-row,
    .detail-grid,
    .desc-card,
    .timestamps-row,
    .show-footer,
    .sidebar,
    .navbar,
    .topbar,
    .btn,
    .no-print {
        display: none !important;
    }

    body, html {
        background: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        overflow: visible !important;
    }

    /* Force all other elements hidden on paper */
    body > :not(.print-invoice-section) {
        display: none !important;
    }

    /* Display the print invoice section */
    .print-invoice-section {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 20px !important;
        background: #fff !important;
        color: #000 !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* Header styling */
    .invoice-print-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
    }
    .company-info h2 {
        color: #F58220 !important;
        margin: 0 0 6px;
        font-size: 1.6rem;
        font-weight: 800;
    }
    .company-info p {
        margin: 0;
        font-size: 0.88rem;
        color: #555;
    }
    .invoice-title h1 {
        margin: 0 0 8px;
        font-size: 2rem;
        color: #111;
        font-weight: 800;
        text-align: right;
    }
    .invoice-meta-item {
        font-size: 0.88rem;
        text-align: right;
        margin-bottom: 4px;
        color: #333;
    }
    
    .divider {
        border: none;
        border-top: 2px solid #F58220 !important;
        margin: 20px 0;
    }

    /* Billing Section */
    .invoice-print-billing {
        display: flex;
        justify-content: space-between;
        margin-bottom: 35px;
    }
    .billing-col {
        width: 48%;
    }
    .billing-col h3 {
        font-size: 1rem;
        font-weight: 700;
        border-bottom: 2px solid #eee;
        padding-bottom: 6px;
        margin-bottom: 12px;
        color: #222;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-row {
        font-size: 0.88rem;
        margin-bottom: 6px;
        color: #444;
    }
    
    /* Table Styling */
    .invoice-print-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 35px;
    }
    .invoice-print-table th {
        background: #f8f9fa !important;
        font-size: 0.88rem;
        font-weight: 700;
        padding: 10px 12px;
        border: 1px solid #dee2e6;
        text-align: left;
        color: #333;
    }
    .invoice-print-table td {
        padding: 12px;
        font-size: 0.88rem;
        border: 1px solid #dee2e6;
        color: #444;
        vertical-align: top;
    }
    .text-end {
        text-align: right !important;
    }

    /* Summary Section */
    .invoice-print-summary {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .summary-col {
        width: 48%;
    }
    .print-notes {
        font-size: 0.82rem;
        border: 1px solid #dee2e6;
        padding: 12px;
        border-radius: 6px;
        background: #f8f9fa !important;
        color: #555;
        line-height: 1.5;
    }
    .summary-totals {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.88rem;
        color: #444;
    }
    .grand-total {
        font-size: 1.05rem;
        font-weight: 800;
        color: #111;
        border-top: 1px solid #dee2e6;
        padding-top: 8px;
    }
    .balance-due {
        font-weight: 800;
        color: #dc2626 !important;
        font-size: 1.05rem;
        background: #fef2f2 !important;
        padding: 6px 10px;
        border-radius: 4px;
        border: 1px solid #fecaca;
    }
    
    @page {
        margin: 15mm;
        size: A4;
    }
}
</style>

{{-- ── Professional Print-only Invoice Section ── --}}
<div class="print-invoice-section">
    <div class="invoice-print-header">
        <div class="company-info">
            <h2>Gayatri Solar Energy</h2>
            <p>Solar Energy Solutions &amp; Field Service Management</p>
        </div>
        <div class="invoice-title">
            <h1>INVOICE</h1>
            <div class="invoice-meta-item"><strong>Invoice No:</strong> {{ $invoice->invoice_no }}</div>
            <div class="invoice-meta-item"><strong>Date:</strong> {{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : 'N/A' }}</div>
            @if($invoice->due_date)
                <div class="invoice-meta-item"><strong>Due Date:</strong> {{ $invoice->due_date->format('d M Y') }}</div>
            @endif
        </div>
    </div>

    <hr class="divider">

    <div class="invoice-print-billing">
        <div class="billing-col">
            <h3>Billed To</h3>
            <div class="info-row"><strong>Name:</strong> {{ $invoice->customer->name ?? 'N/A' }}</div>
            <div class="info-row"><strong>Phone:</strong> {{ $invoice->customer->phone ?? 'N/A' }}</div>
            <div class="info-row"><strong>Email:</strong> {{ $invoice->customer->email ?? 'N/A' }}</div>
            <div class="info-row"><strong>City:</strong> {{ $invoice->customer->city ?? 'N/A' }}</div>
            <div class="info-row"><strong>Address:</strong> {{ $invoice->customer->address ?? 'N/A' }}</div>
        </div>
        <div class="billing-col">
            <h3>Payment Status</h3>
            <div class="info-row"><strong>Status:</strong> {{ $invoice->payment_status ?? 'N/A' }}</div>
            <div class="info-row"><strong>Payment Mode:</strong> {{ $invoice->payment_mode ?? 'N/A' }}</div>
        </div>
    </div>

    <table class="invoice-print-table">
        <thead>
            <tr>
                <th>Service / Job Description</th>
                <th class="text-end" style="width: 150px;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="font-weight: 700; color: #111;">{{ $invoice->service->service_name ?? 'Service Details' }}</div>
                    @if($invoice->service && $invoice->service->service_code)
                        <div style="font-size: 0.8rem; color: #666; margin-top: 2px;">Code: {{ $invoice->service->service_code }}</div>
                    @endif
                    @if($invoice->jobAssignment && $invoice->jobAssignment->technician)
                        <div style="font-size: 0.8rem; color: #666; margin-top: 4px;">
                            <strong>Technician:</strong> {{ $invoice->jobAssignment->technician->name }}
                        </div>
                    @endif
                </td>
                <td class="text-end">₹{{ number_format($invoice->subtotal ?? 0, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-print-summary">
        <div class="summary-col">
            @if($invoice->notes)
                <div class="print-notes">
                    <strong>Notes / Remarks:</strong><br>
                    {{ $invoice->notes }}
                </div>
            @endif
        </div>
        <div class="summary-col summary-totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>₹{{ number_format($invoice->subtotal ?? 0, 2) }}</span>
            </div>
            @if(($invoice->discount ?? 0) > 0)
                <div class="total-row">
                    <span>Discount:</span>
                    <span>− ₹{{ number_format($invoice->discount, 2) }}</span>
                </div>
            @endif
            @if(($invoice->tax ?? 0) > 0)
                <div class="total-row">
                    <span>Tax:</span>
                    <span>+ ₹{{ number_format($invoice->tax, 2) }}</span>
                </div>
            @endif
            <div class="total-row grand-total">
                <span>Total Amount:</span>
                <span>₹{{ number_format($invoice->total_amount ?? 0, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Paid Amount:</span>
                <span>₹{{ number_format($invoice->paid_amount ?? 0, 2) }}</span>
            </div>
            <div class="total-row balance-due">
                <span>Balance Due:</span>
                <span>₹{{ number_format($invoice->balance_amount ?? 0, 2) }}</span>
            </div>
        </div>
    </div>
</div>

<script>
function printInvoice() {
    window.print();
}
</script>

@endsection
