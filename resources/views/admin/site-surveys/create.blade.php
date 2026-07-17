@extends('layouts.admin')

@section('content')

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-plus-circle"></i></span>
        Add Site Survey
    </h1>
    <a href="{{ route('site-surveys.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Site Inspection Details</h6>
    </div>

    <form action="{{ route('site-surveys.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-card-body">

            <p class="section-label">General &amp; Link Details</p>
            <div class="row g-4 mb-2">

                <!-- Survey Number -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Survey Number <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-upc field-icon"></i>
                        <input type="text" name="survey_number" class="form-field" style="background-color: #F3F4F6;" 
                               value="{{ old('survey_number', $surveyNumber) }}" readonly required>
                    </div>
                </div>

                <!-- Link Enquiry -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Link Enquiry <span class="text-muted">(Optional)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-chat-left-quote field-icon"></i>
                        <select name="enquiry_id" id="enquiry_select" class="form-field form-field-select">
                            <option value="">-- Select Enquiry --</option>
                            @foreach($enquiries as $enq)
                                <option value="{{ $enq->id }}" {{ old('enquiry_id') == $enq->id ? 'selected' : '' }}>
                                    {{ $enq->enquiry_number }} - {{ $enq->customer_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Link Customer -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Customer <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <select name="customer_id" id="customer_select" class="form-field form-field-select" required>
                            <option value="">-- Select Customer --</option>
                            @foreach($customers as $cust)
                                <option value="{{ $cust->id }}" {{ old('customer_id') == $cust->id ? 'selected' : '' }}>
                                    {{ $cust->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Survey Date -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Survey Date <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar-event field-icon"></i>
                        <input type="date" name="survey_date" class="form-field @error('survey_date') is-invalid @enderror"
                               value="{{ old('survey_date', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Surveyor / Staff -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Assigned Surveyor <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person-badge field-icon"></i>
                        <select name="surveyor_id" class="form-field form-field-select" required>
                            <option value="">-- Select Surveyor --</option>
                            @foreach($surveyors as $sv)
                                <option value="{{ $sv->id }}" {{ old('surveyor_id') == $sv->id ? 'selected' : '' }}>
                                    {{ $sv->name }} ({{ $sv->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-info-circle field-icon"></i>
                        <select name="status" class="form-field form-field-select" required>
                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Scheduled" {{ old('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>

                <!-- Site Address -->
                <div class="col-12">
                    <label class="field-label">Site Address <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-geo-alt field-icon field-icon-textarea"></i>
                        <textarea name="site_address" id="site_address" rows="2" 
                                  class="form-field form-field-textarea @error('site_address') is-invalid @enderror" 
                                  placeholder="Enter complete address of the installation site..." required>{{ old('site_address') }}</textarea>
                    </div>
                    @error('site_address')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-2">Technical Specifications</p>
            <div class="row g-4 mb-2">

                <!-- Property Type -->
                <div class="col-12 col-md-3">
                    <label class="field-label">Property Type</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-building field-icon"></i>
                        <select name="property_type" class="form-field form-field-select">
                            <option value="Residential" {{ old('property_type') == 'Residential' ? 'selected' : '' }}>Residential</option>
                            <option value="Commercial" {{ old('property_type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="Industrial" {{ old('property_type') == 'Industrial' ? 'selected' : '' }}>Industrial</option>
                            <option value="Agricultural" {{ old('property_type') == 'Agricultural' ? 'selected' : '' }}>Agricultural</option>
                        </select>
                    </div>
                </div>

                <!-- Roof Type -->
                <div class="col-12 col-md-3">
                    <label class="field-label">Roof Type</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-house field-icon"></i>
                        <input type="text" name="roof_type" class="form-field" 
                               value="{{ old('roof_type') }}" placeholder="e.g. RCC Flat Slab, Metal Sheet, Sloped Tile">
                    </div>
                </div>

                <!-- Available Area -->
                <div class="col-12 col-md-3">
                    <label class="field-label">Available Shadow-Free Area</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-aspect-ratio field-icon"></i>
                        <input type="text" name="available_area" class="form-field" 
                               value="{{ old('available_area') }}" placeholder="e.g. 800 Sq Ft">
                    </div>
                </div>

                <!-- Required Capacity -->
                <div class="col-12 col-md-3">
                    <label class="field-label">Required Capacity</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-lightning-charge field-icon"></i>
                        <input type="text" name="required_solar_capacity" class="form-field" 
                               value="{{ old('required_solar_capacity') }}" placeholder="e.g. 8 kW">
                    </div>
                </div>

                <!-- Existing Load -->
                <div class="col-12 col-md-3">
                    <label class="field-label">Existing Load</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-speedometer field-icon"></i>
                        <input type="text" name="existing_electricity_load" class="form-field" 
                               value="{{ old('existing_electricity_load') }}" placeholder="e.g. 12 kW / HP">
                    </div>
                </div>

                <!-- Avg Bill -->
                <div class="col-12 col-md-3">
                    <label class="field-label">Avg Electricity Bill ($ / Month)</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-currency-dollar field-icon"></i>
                        <input type="text" name="average_electricity_bill" class="form-field" 
                               value="{{ old('average_electricity_bill') }}" placeholder="e.g. $150">
                    </div>
                </div>

                <!-- Meter Type -->
                <div class="col-12 col-md-3">
                    <label class="field-label">Meter Type</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-hdd-network field-icon"></i>
                        <input type="text" name="meter_type" class="form-field" 
                               value="{{ old('meter_type') }}" placeholder="e.g. Single Phase, Three Phase">
                    </div>
                </div>

                <!-- Shadow Condition -->
                <div class="col-12 col-md-3">
                    <label class="field-label">Shadow Condition</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-brightness-low field-icon"></i>
                        <input type="text" name="shadow_condition" class="form-field" 
                               value="{{ old('shadow_condition') }}" placeholder="e.g. No shadow / partial shadow">
                    </div>
                </div>

                <!-- Feasibility -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Installation Feasibility <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-hand-thumbs-up field-icon"></i>
                        <select name="installation_feasibility" class="form-field form-field-select" required>
                            <option value="Feasible" {{ old('installation_feasibility') == 'Feasible' ? 'selected' : '' }}>Feasible</option>
                            <option value="Not Feasible" {{ old('installation_feasibility') == 'Not Feasible' ? 'selected' : '' }}>Not Feasible</option>
                            <option value="Conditional Feasible" {{ old('installation_feasibility') == 'Conditional Feasible' ? 'selected' : '' }}>Conditional Feasible</option>
                        </select>
                    </div>
                </div>

                <!-- Multiple Site Photos -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Site Photos <span class="text-muted">(Max 2MB per photo)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-camera field-icon"></i>
                        <input type="file" name="site_photos[]" class="form-field @error('site_photos') is-invalid @enderror" multiple accept="image/*">
                    </div>
                    @error('site_photos')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-2">Survey Notes &amp; Recommendations</p>
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="field-label">Survey Notes / Observations</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-journals field-icon field-icon-textarea"></i>
                        <textarea name="survey_notes" rows="3" class="form-field form-field-textarea" placeholder="Enter observations like roof structure stability, cable routes...">{{ old('survey_notes') }}</textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="field-label">Recommendations</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-award field-icon field-icon-textarea"></i>
                        <textarea name="recommendation" rows="3" class="form-field form-field-textarea" placeholder="Suggest structure height, panel type, inverter location...">{{ old('recommendation') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-footer">
            <a href="{{ route('site-surveys.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Save Survey
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const enquirySelect = document.getElementById('enquiry_select');
    const customerSelect = document.getElementById('customer_select');
    const siteAddressInput = document.getElementById('site_address');

    enquirySelect.addEventListener('change', function() {
        if (!enquirySelect.value) return;

        fetch(`/admin/enquiries/${enquirySelect.value}/details`)
            .then(res => res.json())
            .then(data => {
                if (data.customer_id) {
                    customerSelect.value = data.customer_id;
                }
                if (data.address) {
                    siteAddressInput.value = data.address;
                }
            })
            .catch(err => console.error('Error fetching details:', err));
    });
});
</script>

@endsection
