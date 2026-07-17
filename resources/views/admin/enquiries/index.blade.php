@extends('layouts.admin')

@section('content')

<style>
    .badge-new { background-color: #E5E7EB; color: #374151; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-contacted { background-color: #E1EFFE; color: #1E429F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-followup { background-color: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-converted { background-color: #DEF7EC; color: #03543F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-closed { background-color: #F3F4F6; color: #4B5563; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-cancelled { background-color: #FDE8E8; color: #9B1C1C; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
</style>

<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-chat-left-quote me-2"></i>Enquiries Management
        </h1>
        <p class="page-hero-sub">Manage customer enquiries, leads, sources, follow-ups and conversions</p>
    </div>
    <a href="{{ route('enquiries.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add Enquiry
    </a>
</div>


{{-- ── Filter Card ── --}}
<div class="filter-card mb-4">
    <form method="GET" action="{{ route('enquiries.index') }}">
        <div class="row g-2 align-items-center">
            <!-- Search -->
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search Enquiry #, customer, mobile..."
                           value="{{ request('search') }}">
                </div>
            </div>

            <!-- Status -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="New" {{ request('status') == 'New' ? 'selected' : '' }}>New</option>
                        <option value="Contacted" {{ request('status') == 'Contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="Follow-up" {{ request('status') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                        <option value="Converted" {{ request('status') == 'Converted' ? 'selected' : '' }}>Converted</option>
                        <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <!-- Assigned Employee -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <select name="assigned_employee_id" class="form-select">
                        <option value="">All Assigned</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ request('assigned_employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }}
                            </option>
                        @endforeach
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
                <a href="{{ route('enquiries.index') }}" class="btn-reset" title="Reset Filters">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 1100px;">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Enquiry Number</th>
                    <th>Customer Name</th>
                    <th>Mobile Number</th>
                    <th>Service / Product</th>
                    <th>Source</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Follow-up Date</th>
                    <th class="text-end" style="width: 240px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enquiries as $key => $enquiry)
                    @php
                        $srNo = ($enquiries instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($enquiries->firstItem() + $key)
                            : ($key + 1);

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
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td><span class="code-badge">{{ $enquiry->enquiry_number }}</span></td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $enquiry->customer_name }}</span>
                            @if($enquiry->customer_id)
                                <i class="bi bi-patch-check-fill text-primary ms-1" title="Registered Customer"></i>
                            @endif
                        </td>
                        <td>{{ $enquiry->mobile_number }}</td>
                        <td>{{ $enquiry->service_product }}</td>
                        <td style="color:#6B7280;">{{ $enquiry->enquiry_source ?? '—' }}</td>
                        <td>{{ $enquiry->assignedEmployee?->name ?? 'Unassigned' }}</td>
                        <td><span class="{{ $badge }}">{{ $enquiry->status }}</span></td>
                        <td>
                            @if($enquiry->follow_up_date)
                                <span class="text-dark fw-medium">{{ $enquiry->follow_up_date->format('d M Y') }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group d-flex justify-content-end align-items-center gap-1">
                                <a href="{{ route('enquiries.show', $enquiry->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('enquiries.destroy', $enquiry->id) }}" method="POST" class="delete-form d-inline m-0" onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
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
                                <div class="empty-state-icon"><i class="bi bi-chat-left-text"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No enquiries found</h6>
                                <p class="text-muted small mb-3">Adjust your filter options or add a new customer lead.</p>
                                <a href="{{ route('enquiries.create') }}" class="btn-add-primary" style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Enquiry
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($enquiries instanceof \Illuminate\Pagination\LengthAwarePaginator && $enquiries->hasPages())
        <div class="card-footer-pagination border-top px-4 py-3 bg-white">
            {{ $enquiries->links() }}
        </div>
    @endif
</div>

@endsection
