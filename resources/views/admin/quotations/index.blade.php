@extends('layouts.admin')

@section('content')

<style>
    .badge-draft { background-color: #E5E7EB; color: #374151; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-sent { background-color: #E1EFFE; color: #1E429F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-accepted { background-color: #DEF7EC; color: #03543F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-rejected { background-color: #FDE8E8; color: #9B1C1C; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-expired { background-color: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-cancelled { background-color: #F3F4F6; color: #4B5563; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
</style>

<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-file-earmark-ruled me-2"></i>Quotations Management
        </h1>
        <p class="page-hero-sub">Generate, negotiate, print and manage quotations for customer leads</p>
    </div>
    <a href="{{ route('quotations.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Quotation
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card mb-4">
    <form method="GET" action="{{ route('quotations.index') }}">
        <div class="row g-2 align-items-center">
            <!-- Search -->
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search Quotation # or customer name..."
                           value="{{ request('search') }}">
                </div>
            </div>

            <!-- Status -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Sent" {{ request('status') == 'Sent' ? 'selected' : '' }}>Sent</option>
                        <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <!-- From Date -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text">From</span>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
            </div>

            <!-- To Date -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text">To</span>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>
            </div>

            <!-- Buttons -->
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                <a href="{{ route('quotations.index') }}" class="btn-reset" title="Reset Filters">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 1000px;">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Quotation Number</th>
                    <th>Customer Name</th>
                    <th>Quotation Date</th>
                    <th>Valid Until</th>
                    <th>Grand Total</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 320px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quotations as $key => $quotation)
                    @php
                        $srNo = ($quotations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($quotations->firstItem() + $key)
                            : ($key + 1);

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
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td><span class="code-badge">{{ $quotation->quotation_number }}</span></td>
                        <td>
                            <div class="td-name">
                                <div class="td-avatar">{{ strtoupper(substr($quotation->customer?->name ?? 'C', 0, 2)) }}</div>
                                <span>{{ $quotation->customer?->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="fw-medium text-dark">{{ $quotation->quotation_date?->format('d M Y') ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="fw-medium text-dark">{{ $quotation->valid_until?->format('d M Y') ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="price-cell">${{ number_format($quotation->grand_total, 2) }}</span>
                        </td>
                        <td><span class="{{ $badge }}">{{ $quotation->status }}</span></td>
                        <td>
                            <div class="action-group d-flex justify-content-end align-items-center gap-1">
                                <a href="{{ route('quotations.show', $quotation->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('quotations.print', $quotation->id) }}" target="_blank" class="btn-action" style="color: #6366F1; border-color: rgba(99,102,241,0.2); background-color: #EEF2FF;">
                                    <i class="bi bi-printer"></i> Print
                                </a>
                                <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('quotations.destroy', $quotation->id) }}" method="POST" class="delete-form d-inline m-0" onsubmit="return confirm('Are you sure you want to delete this quotation?');">
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
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-file-earmark-break"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No quotations found</h6>
                                <p class="text-muted small mb-3">Adjust your filters or generate a quotation for a customer.</p>
                                <a href="{{ route('quotations.create') }}" class="btn-add-primary" style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Quotation
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($quotations instanceof \Illuminate\Pagination\LengthAwarePaginator && $quotations->hasPages())
        <div class="card-footer-pagination border-top px-4 py-3 bg-white">
            {{ $quotations->links() }}
        </div>
    @endif
</div>

@endsection
