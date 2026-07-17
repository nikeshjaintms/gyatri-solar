@extends('layouts.admin')

@section('content')

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-plus-circle"></i></span>
        Add New Enquiry
    </h1>
    <a href="{{ route('enquiries.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Enquiry Information</h6>
    </div>

    <form action="{{ route('enquiries.store') }}" method="POST">
        @csrf
        <div class="form-card-body">

            <p class="section-label">Enquiry Reference &amp; Customer Link</p>
            <div class="row g-4 mb-2">

                <!-- Enquiry Number (Read-only / Auto-generated) -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Enquiry Number <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-upc field-icon"></i>
                        <input type="text" name="enquiry_number" class="form-field" style="background-color: #F3F4F6;" 
                               value="{{ old('enquiry_number', $enquiryNumber) }}" readonly required>
                    </div>
                </div>

                <!-- Customer Link Dropdown -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Link Registered Customer <span class="text-muted">(Optional)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-link-45deg field-icon"></i>
                        <select id="customer_select" name="customer_id" class="form-field form-field-select">
                            <option value="">-- New Customer / Unregistered Lead --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" 
                                        data-name="{{ $customer->name }}"
                                        data-phone="{{ $customer->phone }}"
                                        data-email="{{ $customer->email }}"
                                        data-address="{{ $customer->address }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <p class="section-label mt-2">Customer &amp; Contact Details</p>
            <div class="row g-4 mb-2">

                <!-- Customer Name -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Customer Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <input type="text" name="customer_name" id="customer_name" 
                               class="form-field @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name') }}" placeholder="Enter Customer Name" required>
                    </div>
                    @error('customer_name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Mobile Number -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Mobile Number <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-telephone field-icon"></i>
                        <input type="text" name="mobile_number" id="mobile_number" 
                               class="form-field @error('mobile_number') is-invalid @enderror"
                               value="{{ old('mobile_number') }}" placeholder="e.g. +91 9876543210" required>
                    </div>
                    @error('mobile_number')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Email -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Email Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-envelope field-icon"></i>
                        <input type="email" name="email" id="email" 
                               class="form-field @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="e.g. customer@example.com">
                    </div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Address -->
                <div class="col-12">
                    <label class="field-label">Site / Billing Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-geo-alt field-icon field-icon-textarea"></i>
                        <textarea name="address" id="address" rows="2" 
                                  class="form-field form-field-textarea @error('address') is-invalid @enderror" 
                                  placeholder="Enter complete address...">{{ old('address') }}</textarea>
                    </div>
                    @error('address')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-2">Requirement &amp; Staff Assignment</p>
            <div class="row g-4 mb-2">

                <!-- Service / Product -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Service / Product Required <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-wrench-adjustable field-icon"></i>
                        <input type="text" name="service_product" class="form-field @error('service_product') is-invalid @enderror"
                               value="{{ old('service_product') }}" placeholder="e.g. 5kW Solar System Installation" required>
                    </div>
                    @error('service_product')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Enquiry Date -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Enquiry Date <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar-event field-icon"></i>
                        <input type="date" name="enquiry_date" class="form-field @error('enquiry_date') is-invalid @enderror"
                               value="{{ old('enquiry_date', date('Y-m-d')) }}" required>
                    </div>
                    @error('enquiry_date')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Enquiry Source -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Enquiry Source</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-funnel field-icon"></i>
                        <input type="text" name="enquiry_source" class="form-field @error('enquiry_source') is-invalid @enderror"
                               value="{{ old('enquiry_source') }}" placeholder="e.g. Website, Reference, Google Maps">
                    </div>
                    @error('enquiry_source')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Assigned Employee -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Assign Employee / Staff</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person-badge field-icon"></i>
                        <select name="assigned_employee_id" class="form-field form-field-select @error('assigned_employee_id') is-invalid @enderror">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('assigned_employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('assigned_employee_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Status -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-info-circle field-icon"></i>
                        <select name="status" class="form-field form-field-select @error('status') is-invalid @enderror" required>
                            <option value="New" {{ old('status', 'New') == 'New' ? 'selected' : '' }}>New</option>
                            <option value="Contacted" {{ old('status') == 'Contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="Follow-up" {{ old('status') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                            <option value="Converted" {{ old('status') == 'Converted' ? 'selected' : '' }}>Converted</option>
                            <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                            <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    @error('status')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Follow-up Date -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Follow-up Date</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar-check field-icon"></i>
                        <input type="date" name="follow_up_date" class="form-field @error('follow_up_date') is-invalid @enderror"
                               value="{{ old('follow_up_date') }}">
                    </div>
                    @error('follow_up_date')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-2">Remarks / Notes</p>
            <div class="row g-4">
                <div class="col-12">
                    <label class="field-label">Remarks</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-chat-text field-icon field-icon-textarea"></i>
                        <textarea name="remarks" rows="3"
                                  class="form-field form-field-textarea @error('remarks') is-invalid @enderror"
                                  placeholder="Enter internal follow-up notes or comments...">{{ old('remarks') }}</textarea>
                    </div>
                    @error('remarks')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>

        <div class="form-footer">
            <a href="{{ route('enquiries.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Save Enquiry
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerSelect = document.getElementById('customer_select');
    const customerNameInput = document.getElementById('customer_name');
    const mobileNumberInput = document.getElementById('mobile_number');
    const emailInput = document.getElementById('email');
    const addressInput = document.getElementById('address');

    customerSelect.addEventListener('change', function() {
        const selectedOption = customerSelect.options[customerSelect.selectedIndex];
        if (customerSelect.value) {
            customerNameInput.value = selectedOption.getAttribute('data-name') || '';
            mobileNumberInput.value = selectedOption.getAttribute('data-phone') || '';
            emailInput.value = selectedOption.getAttribute('data-email') || '';
            addressInput.value = selectedOption.getAttribute('data-address') || '';
        } else {
            customerNameInput.value = '';
            mobileNumberInput.value = '';
            emailInput.value = '';
            addressInput.value = '';
        }
    });
});
</script>

@endsection
