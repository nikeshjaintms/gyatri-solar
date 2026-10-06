@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-gear-wide-connected"></i></span>
        Company Settings
    </h1>
</div>

{{-- ── Form Card ── --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Company Information &amp; Branding</h6>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card-body">

            <p class="section-label">General &amp; Contact Details</p>
            <div class="row g-4 mb-3">

                <!-- Company Name -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Company Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-building field-icon"></i>
                        <input type="text" name="company_name" 
                               class="form-field @error('company_name') is-invalid @enderror"
                               value="{{ old('company_name', $settings->company_name) }}" 
                               placeholder="e.g. Gayatri Solar Energy" required>
                    </div>
                    @error('company_name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Phone -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Phone Number</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-telephone field-icon"></i>
                        <input type="tel" name="phone" inputmode="numeric" maxlength="10"
                               class="form-field @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $settings->phone) }}" 
                               placeholder="e.g. 9876543210">
                    </div>
                    @error('phone')<div class="field-error">Enter a valid 10-digit Indian mobile number.</div>@enderror
                </div>

                <!-- Email -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Email Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-envelope field-icon"></i>
                        <input type="email" name="email" 
                               class="form-field @error('email') is-invalid @enderror"
                               value="{{ old('email', $settings->email) }}" 
                               placeholder="e.g. contact@gayatrisolar.com">
                    </div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- GST Number -->
                <div class="col-12 col-md-6">
                    <label class="field-label">GST Number (GSTIN)</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-receipt-cutoff field-icon"></i>
                        <input type="text" name="gst_number" maxlength="15"
                               class="form-field @error('gst_number') is-invalid @enderror"
                               value="{{ old('gst_number', $settings->gst_number) }}" 
                               placeholder="e.g. 24ABCDE1234F1Z5" style="text-transform:uppercase;">
                    </div>
                    @error('gst_number')<div class="field-error">Enter a valid 15-character GSTIN.</div>@enderror
                </div>

                <!-- Address -->
                <div class="col-12">
                    <label class="field-label">Company / Office Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-geo-alt field-icon field-icon-textarea"></i>
                        <textarea name="address" rows="3" 
                                  class="form-field form-field-textarea @error('address') is-invalid @enderror" 
                                  placeholder="Enter official registered office address...">{{ old('address', $settings->address) }}</textarea>
                    </div>
                    @error('address')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-2">Company Logo &amp; Branding</p>
            <div class="row g-4 mb-2 align-items-center">

                <!-- Logo Upload -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Upload New Logo <span class="text-muted">(JPG, PNG, WebP)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-image field-icon"></i>
                        <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" 
                               class="form-field @error('logo') is-invalid @enderror"
                               style="padding-top: 7px;">
                    </div>
                    @error('logo')<div class="field-error">{{ $message }}</div>@enderror
                    <div class="field-hint text-muted small mt-1">Recommended transparent PNG or vector logo for quotations &amp; invoices.</div>
                </div>

                <!-- Current Logo Preview -->
                @if($settings->logo)
                    <div class="col-12 col-md-6">
                        <label class="field-label">Current Logo</label>
                        <div>
                            <div class="p-2.5 bg-light rounded-3 d-inline-flex align-items-center justify-content-center border" style="min-height: 50px; min-width: 120px;">
                                <img src="{{ asset('storage/'.$settings->logo) }}" alt="Company Logo" style="max-height: 48px; max-width: 160px; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>

        <div class="form-footer">
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Save Settings
            </button>
        </div>
    </form>
</div>

@endsection