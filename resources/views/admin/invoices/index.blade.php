@extends('layouts.admin')

@section('content')

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-receipt me-2"></i>Invoice / Payment Management
        </h1>
        <p class="page-hero-sub">Manage invoices, track payments and monitor billing status</p>
    </div>
    <a href="{{ route('invoices.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Invoice
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('invoices.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search invoice no, customer, service..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="payment_status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Unpaid"          {{ request('payment_status') == 'Unpaid'          ? 'selected' : '' }}>Unpaid</option>
                        <option value="Partially Paid"  {{ request('payment_status') == 'Partially Paid'  ? 'selected' : '' }}>Partially Paid</option>
                        <option value="Paid"            {{ request('payment_status') == 'Paid'            ? 'selected' : '' }}>Paid</option>
                        <option value="Cancelled"       {{ request('payment_status') == 'Cancelled'       ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                    <select name="payment_mode" class="form-select">
                        <option value="">All Modes</option>
                        <option value="Cash"          {{ request('payment_mode') == 'Cash'          ? 'selected' : '' }}>Cash</option>
                        <option value="UPI"           {{ request('payment_mode') == 'UPI'           ? 'selected' : '' }}>UPI</option>
                        <option value="Bank Transfer" {{ request('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="Cheque"        {{ request('payment_mode') == 'Cheque'        ? 'selected' : '' }}>Cheque</option>
                        <option value="Card"          {{ request('payment_mode') == 'Card'          ? 'selected' : '' }}>Card</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('invoices.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 900px;">
            <thead>
                <tr>
                    <th style="width:52px;">#</th>
                    <th>Invoice No</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Invoice Date</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th class="text-end" style="width:210px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $key => $invoice)
                    @php
                        $srNo = ($invoices instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($invoices->firstItem() + $key)
                            : ($key + 1);
                    @endphp
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <span class="code-badge">{{ $invoice->invoice_no }}</span>
                        </td>
                        <td>
                            <div class="td-name">
                                <div class="td-avatar">{{ strtoupper(substr($invoice->customer->name ?? 'C', 0, 1)) }}</div>
                                <span>{{ $invoice->customer->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td style="color:#6B7280; font-size:0.86rem;">
                            {{ $invoice->service->service_name ?? '—' }}
                        </td>
                        <td style="color:#6B7280; font-size:0.86rem;">
                            {{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : '—' }}
                        </td>
                        <td>
                            <span class="price-cell">₹{{ number_format($invoice->total_amount, 2) }}</span>
                        </td>
                        <td style="color:#16a34a; font-weight:600; font-size:0.88rem;">
                            ₹{{ number_format($invoice->paid_amount, 2) }}
                        </td>
                        <td style="color:#dc2626; font-weight:600; font-size:0.88rem;">
                            ₹{{ number_format($invoice->balance_amount, 2) }}
                        </td>
                        <td>
                            @php
                                $statusClass = match($invoice->payment_status) {
                                    'Paid'           => 'badge-inv-paid',
                                    'Partially Paid' => 'badge-inv-partial',
                                    'Cancelled'      => 'badge-inv-cancelled',
                                    default          => 'badge-inv-unpaid',
                                };
                            @endphp
                            <span class="{{ $statusClass }}">{{ $invoice->payment_status }}</span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="delete-form d-inline m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-action-delete">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-receipt"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No records found</h6>
                                <p class="text-muted small mb-3">Adjust your search filters or create a new invoice.</p>
                                <a href="{{ route('invoices.create') }}" class="btn-add-primary"
                                   style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Invoice
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($invoices instanceof \Illuminate\Pagination\LengthAwarePaginator && $invoices->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }} of {{ $invoices->total() }} invoices
            </span>
            {{ $invoices->links() }}
        </div>
    @endif
</div>

{{-- ── Payment Status Badge Styles ── --}}
<style>
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
</style>

@endsection
