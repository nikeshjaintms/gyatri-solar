@extends('layouts.admin')

@section('content')
<div class="mb-4"><h1 class="h3 mb-1">Company Settings</h1><p class="text-muted mb-0">Update the company details used across the system.</p></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-12 col-md-6"><label class="form-label">Company name <span class="text-danger">*</span></label><input name="company_name" value="{{ old('company_name', $settings->company_name) }}" class="form-control @error('company_name') is-invalid @enderror" required>@error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-12 col-md-6"><label class="form-label">Phone</label><input type="tel" name="phone" inputmode="numeric" maxlength="10" value="{{ old('phone', $settings->phone) }}" class="form-control @error('phone') is-invalid @enderror">@error('phone')<div class="invalid-feedback">Enter a valid 10-digit Indian mobile number.</div>@enderror</div>
            <div class="col-12 col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email', $settings->email) }}" class="form-control @error('email') is-invalid @enderror">@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-12 col-md-6"><label class="form-label">GST Number</label><input name="gst_number" maxlength="15" value="{{ old('gst_number', $settings->gst_number) }}" class="form-control @error('gst_number') is-invalid @enderror">@error('gst_number')<div class="invalid-feedback">Enter a valid 15-character GSTIN.</div>@enderror</div>
            <div class="col-12"><label class="form-label">Address</label><textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $settings->address) }}</textarea>@error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-12 col-md-6"><label class="form-label">Logo</label><input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="form-control @error('logo') is-invalid @enderror">@error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            @if($settings->logo)<div class="col-12"><img src="{{ asset('storage/'.$settings->logo) }}" alt="Company logo" style="max-width:180px; max-height:90px; object-fit:contain"></div>@endif
        </div>
        <div class="d-flex justify-content-end mt-4"><button class="btn-add-primary"><i class="bi bi-check-lg"></i>Save Settings</button></div>
    </form>
</div></div>
@endsection