@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-person-plus"></i></span>
        Add New Customer
    </h1>
    <a href="{{ route('customers.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


{{-- ── Form Card ── --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Customer Information</h6>
    </div>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div class="form-card-body">
            <div class="row g-4">

                {{-- Name --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Full Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <input type="text" name="name"
                               class="form-field @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="e.g. John Doe" required>
                    </div>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Email --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Email Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-envelope field-icon"></i>
                        <input type="email" name="email"
                               class="form-field @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="e.g. john@example.com">
                    </div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Phone --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Mobile Number <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-telephone field-icon"></i>
                        <input type="tel" name="phone" inputmode="numeric" maxlength="10" required
                               class="form-field @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}"
                               placeholder="10-digit Indian mobile number">
                    </div>
                    <div class="field-hint">Enter a valid 10-digit Indian mobile number.</div>
                    @error('phone')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Customer Type <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-people field-icon"></i>
                        <select name="customer_type" class="form-field form-field-select @error('customer_type') is-invalid @enderror" required>
                            @foreach(['Residential', 'Commercial', 'Other'] as $type)
                                <option value="{{ $type }}" {{ old('customer_type', 'Residential') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('customer_type')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- City --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">City</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-building field-icon"></i>
                        <input type="text" name="city"
                               class="form-field @error('city') is-invalid @enderror"
                               value="{{ old('city') }}"
                               placeholder="e.g. Mumbai, Delhi, Pune">
                    </div>
                    @error('city')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">State</label>
                    <input type="text" name="state" class="form-field @error('state') is-invalid @enderror" value="{{ old('state') }}">
                    @error('state')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Pincode</label>
                    <input type="text" name="pincode" inputmode="numeric" maxlength="6" class="form-field @error('pincode') is-invalid @enderror" value="{{ old('pincode') }}">
                    @error('pincode')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Status --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-toggle2-on field-icon"></i>
                        <select name="status"
                                class="form-field form-field-select @error('status') is-invalid @enderror">
                            <option value="Active"   {{ old('status', 'Active') == 'Active'   ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @error('status')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="field-label">Notes</label>
                    <textarea name="notes" rows="3" class="form-field form-field-textarea @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                    @error('notes')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Address --}}
                <div class="col-12">
                    <label class="field-label">Street Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-geo-alt field-icon field-icon-textarea"></i>
                        <textarea name="address" rows="3"
                                  class="form-field form-field-textarea @error('address') is-invalid @enderror"
                                  placeholder="e.g. 123 Main St, Suite 100">{{ old('address') }}</textarea>
                    </div>
                    @error('address')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        {{-- Footer ── --}}
        <div class="form-footer">
            <a href="{{ route('customers.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Save Customer
            </button>
        </div>
    </form>
</div>

@endsection
