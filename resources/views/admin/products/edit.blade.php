@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-pencil-square"></i></span>
        Edit Product: {{ $product->product_code }}
    </h1>
    <a href="{{ route('products.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Form Card ── --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Update Product Information</h6>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card-body">
            
            <p class="section-label">Basic Information</p>
            <div class="row g-4 mb-3">
                {{-- Product Code (Read-only) --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Product Code</label>
                    <div class="field-input-wrap bg-light">
                        <i class="bi bi-hash field-icon"></i>
                        <input type="text" class="form-field"
                               value="{{ $product->product_code }}" readonly
                               style="background-color: #f3f4f6; color: #4B5563; font-weight: 600; cursor: not-allowed;">
                    </div>
                </div>

                {{-- Product Name --}}
                <div class="col-12 col-md-8">
                    <label class="field-label">Product Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-tag field-icon"></i>
                        <input type="text" name="name"
                               class="form-field @error('name') is-invalid @enderror"
                               value="{{ old('name', $product->name) }}"
                               placeholder="e.g. Solar Inverter 5kW" required>
                    </div>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Category --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Category <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-grid field-icon"></i>
                        <select name="category" class="form-field form-field-select @error('category') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            <option value="Solar Panels" {{ old('category', $product->category) == 'Solar Panels' ? 'selected' : '' }}>Solar Panels</option>
                            <option value="Inverters" {{ old('category', $product->category) == 'Inverters' ? 'selected' : '' }}>Inverters</option>
                            <option value="Batteries" {{ old('category', $product->category) == 'Batteries' ? 'selected' : '' }}>Batteries</option>
                            <option value="Cables" {{ old('category', $product->category) == 'Cables' ? 'selected' : '' }}>Cables</option>
                            <option value="Mounting Structure" {{ old('category', $product->category) == 'Mounting Structure' ? 'selected' : '' }}>Mounting Structure</option>
                            <option value="Accessories" {{ old('category', $product->category) == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                        </select>
                    </div>
                    @error('category')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Brand --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Brand / Manufacturer</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-award field-icon"></i>
                        <input type="text" name="brand"
                               class="form-field @error('brand') is-invalid @enderror"
                               value="{{ old('brand', $product->brand) }}"
                               placeholder="e.g. Tata Power, Luminous">
                    </div>
                    @error('brand')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Model Number --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Model Number</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-info-circle field-icon"></i>
                        <input type="text" name="model_number"
                               class="form-field @error('model_number') is-invalid @enderror"
                               value="{{ old('model_number', $product->model_number) }}"
                               placeholder="e.g. LMU-5000">
                    </div>
                    @error('model_number')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Unit --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Unit <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-box field-icon"></i>
                        <select name="unit" class="form-field form-field-select @error('unit') is-invalid @enderror" required>
                            <option value="Nos" {{ old('unit', $product->unit) == 'Nos' ? 'selected' : '' }}>Nos (Numbers)</option>
                            <option value="Set" {{ old('unit', $product->unit) == 'Set' ? 'selected' : '' }}>Set</option>
                            <option value="Box" {{ old('unit', $product->unit) == 'Box' ? 'selected' : '' }}>Box</option>
                            <option value="Meter" {{ old('unit', $product->unit) == 'Meter' ? 'selected' : '' }}>Meter</option>
                            <option value="Kg" {{ old('unit', $product->unit) == 'Kg' ? 'selected' : '' }}>Kg (Kilogram)</option>
                            <option value="Liter" {{ old('unit', $product->unit) == 'Liter' ? 'selected' : '' }}>Liter</option>
                        </select>
                    </div>
                    @error('unit')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- HSN/SAC Code --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">HSN/SAC Code</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-ticket-detailed field-icon"></i>
                        <input type="text" name="hsn_sac_code"
                               class="form-field @error('hsn_sac_code') is-invalid @enderror"
                               value="{{ old('hsn_sac_code', $product->hsn_sac_code) }}"
                               placeholder="e.g. 8504">
                    </div>
                    @error('hsn_sac_code')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- GST (%) --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">GST (%)</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-percent field-icon"></i>
                        <input type="number" name="gst" min="0" max="100" step="0.01"
                               class="form-field @error('gst') is-invalid @enderror"
                               value="{{ old('gst', $product->gst) }}"
                               placeholder="18.00">
                    </div>
                    @error('gst')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <p class="section-label mt-3">Pricing &amp; Stock Metrics</p>
            <div class="row g-4 mb-3">
                {{-- Purchase Price --}}
                <div class="col-12 col-md-3">
                    <label class="field-label">Purchase Price (₹)</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-currency-rupee field-icon"></i>
                        <input type="number" name="purchase_price" min="0" step="0.01"
                               class="form-field @error('purchase_price') is-invalid @enderror"
                               value="{{ old('purchase_price', $product->purchase_price) }}"
                               placeholder="0.00">
                    </div>
                    @error('purchase_price')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Selling Price --}}
                <div class="col-12 col-md-3">
                    <label class="field-label">Selling Price (₹)</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-currency-rupee field-icon"></i>
                        <input type="number" name="selling_price" min="0" step="0.01"
                               class="form-field @error('selling_price') is-invalid @enderror"
                               value="{{ old('selling_price', $product->selling_price) }}"
                               placeholder="0.00">
                    </div>
                    @error('selling_price')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Opening Stock --}}
                <div class="col-12 col-md-3">
                    <label class="field-label">Opening Stock</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-archive field-icon"></i>
                        <input type="number" name="opening_stock" min="0"
                               class="form-field @error('opening_stock') is-invalid @enderror"
                               value="{{ old('opening_stock', $product->opening_stock) }}"
                               placeholder="0">
                    </div>
                    @error('opening_stock')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Minimum Stock Level --}}
                <div class="col-12 col-md-3">
                    <label class="field-label">Minimum Stock Level</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-exclamation-triangle field-icon"></i>
                        <input type="number" name="minimum_stock_level" min="0"
                               class="form-field @error('minimum_stock_level') is-invalid @enderror"
                               value="{{ old('minimum_stock_level', $product->minimum_stock_level) }}"
                               placeholder="5">
                    </div>
                    @error('minimum_stock_level')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <p class="section-label mt-3">Visual &amp; Status</p>
            <div class="row g-4">
                {{-- Image upload --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Product Image</label>
                    <div class="d-flex align-items-center gap-3">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" 
                                 alt="Current image" 
                                 class="rounded border border-secondary-subtle" 
                                 style="width: 55px; height: 55px; object-fit: cover;">
                        @endif
                        <div class="field-input-wrap flex-grow-1">
                            <i class="bi bi-image field-icon"></i>
                            <input type="file" name="image"
                                   class="form-field @error('image') is-invalid @enderror"
                                   accept="image/*">
                        </div>
                    </div>
                    <div class="form-text text-muted small mt-1">Accepted: jpeg, png, jpg, gif. Max size: 2MB.</div>
                    @error('image')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Status --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-toggle2-on field-icon"></i>
                        <select name="status"
                                class="form-field form-field-select @error('status') is-invalid @enderror">
                            <option value="Active"   {{ old('status', $product->status) == 'Active'   ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $product->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @error('status')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Product Description --}}
                <div class="col-12">
                    <label class="field-label">Product Description</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-card-text field-icon field-icon-textarea"></i>
                        <textarea name="description" rows="3"
                                  class="form-field form-field-textarea @error('description') is-invalid @enderror"
                                  placeholder="Enter description, special properties, warranties...">{{ old('description', $product->description) }}</textarea>
                    </div>
                    @error('description')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="form-footer">
            <a href="{{ route('products.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Update Product
            </button>
        </div>
    </form>
</div>

@endsection
