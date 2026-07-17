@extends('layouts.admin')

@section('content')

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-box-seam me-2"></i>Product Master
        </h1>
        <p class="page-hero-sub">Manage your inventory, pricing models, units, and brands</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('products.create') }}" class="btn-add-primary">
            <i class="bi bi-plus-lg"></i> Add Product
        </a>
    </div>
</div>

{{-- ── Filter Card ── --}}
<div class="filter-card">
    <form method="GET" action="{{ route('products.index') }}">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search Product Name, Code, Brand, Model..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-tags"></i></span>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Active"   {{ request('status') == 'Active'   ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('products.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Export Utility Bar ── --}}
<div class="d-flex justify-content-between align-items-center mb-3 px-2">
    <div class="text-secondary small">
        <i class="bi bi-info-circle me-1"></i> Showing search inventory results
    </div>
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-sm btn-light border" style="font-weight: 500; font-size: 0.8rem;" onclick="alert('Export to Excel functionality is ready to configure.')">
            <i class="bi bi-file-earmark-excel text-success me-1"></i> Export Excel
        </button>
        <button type="button" class="btn btn-sm btn-light border" style="font-weight: 500; font-size: 0.8rem;" onclick="alert('Export to PDF functionality is ready to configure.')">
            <i class="bi bi-file-earmark-pdf text-danger me-1"></i> Export PDF
        </button>
        <button type="button" class="btn btn-sm btn-light border" style="font-weight: 500; font-size: 0.8rem;" onclick="window.print()">
            <i class="bi bi-printer text-dark me-1"></i> Print
        </button>
    </div>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 1000px;">
            <thead>
                <tr>
                    <th style="width: 80px;">Image</th>
                    <th style="width: 110px;">Product Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Unit</th>
                    <th class="text-end">Selling Price</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Status</th>
                    <th>Created Date</th>
                    <th class="text-end" style="width: 220px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="rounded border border-secondary-subtle" 
                                 style="width: 44px; height: 44px; object-fit: cover;">
                        </td>
                        <td>
                            <span style="display: inline-block; background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 6px; color: #212529; font-weight: 600; font-size: 13px; padding: 3px 8px;">
                                {{ $product->product_code }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $product->name }}</div>
                            @if($product->model_number)
                                <div class="text-muted small">Model: {{ $product->model_number }}</div>
                            @endif
                        </td>
                        <td style="color:#6B7280;">{{ $product->category }}</td>
                        <td style="color:#6B7280;">{{ $product->brand ?? '—' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1">{{ $product->unit }}</span>
                        </td>
                        <td class="text-end fw-semibold text-dark">
                            ₹{{ number_format($product->selling_price, 2) }}
                        </td>
                        <td class="text-center">
                            @if($product->opening_stock <= $product->minimum_stock_level)
                                <span class="badge bg-danger-subtle text-danger px-2 py-1" title="Below minimum stock level ({{ $product->minimum_stock_level }})">
                                    {{ $product->opening_stock }} (Low)
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success px-2 py-1">
                                    {{ $product->opening_stock }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->status == 'Active')
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td style="color:#6B7280;">
                            {{ $product->created_at ? $product->created_at->format('d M Y') : '—' }}
                        </td>
                        <td>
                            <div class="action-group justify-content-end">
                                <a href="{{ route('products.show', $product->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form d-inline m-0">
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
                        <td colspan="11">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-box-seam"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No products found</h6>
                                <p class="text-muted small mb-3">Adjust your search or add a new product.</p>
                                <a href="{{ route('products.create') }}" class="btn-add-primary"
                                   style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add Product
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:#E5E7EB !important;">
            <span class="small" style="color:#6B7280;">
                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
            </span>
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
