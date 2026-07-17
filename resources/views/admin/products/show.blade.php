@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="show-page-header">
    <h1 class="show-page-title">
        <span class="title-icon"><i class="bi bi-box-seam"></i></span>
        Product Details
    </h1>
    <a href="{{ route('products.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Profile Hero ── --}}
<div class="profile-hero">
    <img src="{{ $product->image_url }}" 
         alt="{{ $product->name }}" 
         class="rounded" 
         style="width: 72px; height: 72px; object-fit: cover; border: 3px solid rgba(255,255,255,0.2);">
    <div class="hero-info">
        <h2 class="hero-name">{{ $product->name }}</h2>
        <p class="hero-spec">
            <span class="badge bg-dark text-warning border border-warning px-2 py-1 font-monospace me-2" style="font-size: 0.8rem;">
                {{ $product->product_code }}
            </span>
            <i class="bi bi-tag me-1"></i>
            {{ $product->category }}
        </p>
        @if($product->status == 'Active')
            <span class="hero-status-active"><span class="dot"></span> Active</span>
        @else
            <span class="hero-status-inactive"><span class="dot"></span> Inactive</span>
        @endif
    </div>
</div>

{{-- ── Detail Grid ── --}}
<div class="detail-grid">

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-award"></i></div>
        <div>
            <div class="detail-label">Brand / Manufacturer</div>
            <div class="detail-value {{ !$product->brand ? 'empty' : '' }}">
                {{ $product->brand ?? 'Not provided' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-blue"><i class="bi bi-info-circle"></i></div>
        <div>
            <div class="detail-label">Model Number</div>
            <div class="detail-value {{ !$product->model_number ? 'empty' : '' }}">
                {{ $product->model_number ?? 'Not specified' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-box"></i></div>
        <div>
            <div class="detail-label">Unit of Measure</div>
            <div class="detail-value">
                {{ $product->unit }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-ticket-detailed"></i></div>
        <div>
            <div class="detail-label">HSN/SAC Code</div>
            <div class="detail-value {{ !$product->hsn_sac_code ? 'empty' : '' }}">
                {{ $product->hsn_sac_code ?? 'Not provided' }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-teal"><i class="bi bi-percent"></i></div>
        <div>
            <div class="detail-label">GST Rate</div>
            <div class="detail-value">
                {{ number_format($product->gst, 2) }}%
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-orange"><i class="bi bi-cash-stack"></i></div>
        <div>
            <div class="detail-label">Selling Price</div>
            <div class="detail-value">
                ₹{{ number_format($product->selling_price, 2) }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-blue"><i class="bi bi-wallet2"></i></div>
        <div>
            <div class="detail-label">Purchase Price</div>
            <div class="detail-value">
                ₹{{ number_format($product->purchase_price, 2) }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-green"><i class="bi bi-archive"></i></div>
        <div>
            <div class="detail-label">Current Stock / Opening Stock</div>
            <div class="detail-value">
                {{ $product->opening_stock }}
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-icon icon-solar-purple"><i class="bi bi-exclamation-triangle"></i></div>
        <div>
            <div class="detail-label">Minimum Stock Level</div>
            <div class="detail-value">
                {{ $product->minimum_stock_level }}
            </div>
        </div>
    </div>

</div>

{{-- ── Description Card ── --}}
<div class="address-card">
    <div class="address-card-header">
        <div class="detail-card-icon icon-solar-teal" style="width:36px;height:36px;border-radius:8px;">
            <i class="bi bi-card-text"></i>
        </div>
        <div class="detail-label mb-0">Product Description</div>
    </div>
    @if($product->description)
        <p class="address-text mb-0">{{ $product->description }}</p>
    @else
        <p class="mb-0" style="color:#D1D5DB;font-style:italic;font-size:0.9rem;">No description provided</p>
    @endif
</div>

{{-- ── Timestamps ── --}}
<div class="timestamps-row">
    <div class="timestamp-chip">
        <i class="bi bi-calendar-plus" style="color:#F58220;"></i>
        <span>Created: <strong>{{ $product->created_at ? $product->created_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
    <div class="timestamp-chip">
        <i class="bi bi-calendar-check" style="color:#16a34a;"></i>
        <span>Last Updated: <strong>{{ $product->updated_at ? $product->updated_at->format('M d, Y — h:i A') : '—' }}</strong></span>
    </div>
</div>

{{-- ── Footer Actions ── --}}
<div class="show-footer">
    <a href="{{ route('products.index') }}" class="btn-back-footer">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form d-inline m-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete-detail">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </form>
    <a href="{{ route('products.edit', $product->id) }}" class="btn-edit-detail">
        <i class="bi bi-pencil"></i> Edit Product
    </a>
</div>

@endsection
