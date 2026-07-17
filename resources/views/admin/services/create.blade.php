@extends('layouts.admin')

@section('content')

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-plus-circle"></i></span>
        Add New Service
    </h1>
    <a href="{{ route('services.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Service Information</h6>
    </div>

    <form action="{{ route('services.store') }}" method="POST">
        @csrf
        <div class="form-card-body">

            <p class="section-label">Basic Details</p>
            <div class="row g-4 mb-2">

                <div class="col-12 col-md-6">
                    <label class="field-label">Service Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-wrench-adjustable field-icon"></i>
                        <input type="text" name="service_name" class="form-field @error('service_name') is-invalid @enderror"
                               value="{{ old('service_name') }}" placeholder="e.g. Solar Panel Installation" required>
                    </div>
                    @error('service_name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Service Code</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-upc field-icon"></i>
                        <input type="text" name="service_code" class="form-field @error('service_code') is-invalid @enderror"
                               value="{{ old('service_code') }}" placeholder="e.g. SVC-001">
                    </div>
                    @error('service_code')<div class="field-error">{{ $message }}</div>@enderror
                    <div class="field-hint">Must be unique across all services.</div>
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Category</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-tag field-icon"></i>
                        <input type="text" name="category" class="form-field @error('category') is-invalid @enderror"
                               value="{{ old('category') }}" placeholder="e.g. Installation, Maintenance, Repair">
                    </div>
                    @error('category')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-toggle2-on field-icon"></i>
                        <select name="status" class="form-field form-field-select @error('status') is-invalid @enderror" required>
                            <option value="Active"   {{ old('status','Active')=='Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status')=='Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @error('status')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-2">Pricing &amp; Duration</p>
            <div class="row g-4 mb-2">

                <div class="col-12 col-md-6">
                    <label class="field-label">Price ($)</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-currency-dollar field-icon"></i>
                        <input type="number" name="price" step="0.01" min="0"
                               class="form-field @error('price') is-invalid @enderror"
                               value="{{ old('price') }}" placeholder="e.g. 150.00">
                    </div>
                    @error('price')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Duration</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-clock field-icon"></i>
                        <input type="text" name="duration" class="form-field @error('duration') is-invalid @enderror"
                               value="{{ old('duration') }}" placeholder="e.g. 2 hours, 30 minutes">
                    </div>
                    @error('duration')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-2">Description</p>
            <div class="row g-4">
                <div class="col-12">
                    <label class="field-label">Service Description</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-card-text field-icon field-icon-textarea"></i>
                        <textarea name="description" rows="4"
                                  class="form-field form-field-textarea @error('description') is-invalid @enderror"
                                  placeholder="Describe what this service includes, tools used, and expected outcomes...">{{ old('description') }}</textarea>
                    </div>
                    @error('description')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>

        <div class="form-footer">
            <a href="{{ route('services.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Save Service
            </button>
        </div>
    </form>
</div>

@endsection
