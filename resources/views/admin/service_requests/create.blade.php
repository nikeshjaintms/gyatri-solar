@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-clipboard2-plus"></i></span>
        New Service Request
    </h1>
    @if(request('customer_id'))
        <a href="{{ route('customers.show', request('customer_id')) }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to Customer Details
        </a>
    @else
        <a href="{{ route('service-requests.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    @endif
</div>


<form action="{{ route('service-requests.store') }}" method="POST">
@csrf

{{-- ══ Section 1: Assignment ══ --}}
<div class="form-card mb-4">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Assignment Details</h6>
    </div>
    <div class="form-card-body">
        <div class="row g-4">

            {{-- Service --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Service <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-wrench-adjustable field-icon"></i>
                    <select name="service_id" id="sr_service_select"
                            class="form-field form-field-select @error('service_id') is-invalid @enderror"
                            required>
                        <option value="">— Select Service —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                data-category="{{ $service->category }}"
                                data-description="{{ $service->description }}"
                                data-price="{{ $service->price }}"
                                data-duration="{{ $service->duration }}"
                                {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->service_name }}
                                @if($service->category) [{{ $service->category }}] @endif
                                @if($service->service_code) ({{ $service->service_code }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="service_info_badge" class="mt-1" style="display:none;"></div> 
                @error('service_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Technician --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Technician <span style="color:#9CA3AF;font-weight:400;">(Optional)</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-person-badge field-icon"></i>
                    <select name="technician_id"
                            class="form-field form-field-select @error('technician_id') is-invalid @enderror">
                        <option value="">— Unassigned —</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}"
                                {{ old('technician_id') == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                                @if($tech->specialization) — {{ $tech->specialization }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('technician_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Customer --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Customer <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-person field-icon"></i>
                    <select name="customer_id" id="sr_customer_select"
                            class="form-field form-field-select @error('customer_id') is-invalid @enderror"
                            required>
                        <option value="">— Select Customer —</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                data-address="{{ $customer->address ? ($customer->address . ($customer->city ? ', ' . $customer->city : '')) : '' }}"
                                data-type="{{ $customer->customer_type }}"
                                {{ old('customer_id', request('customer_id')) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->customer_type }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('customer_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 col-md-6">
                <label class="field-label">Project <span style="color:#9CA3AF;font-weight:400;">(Optional)</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-sun field-icon"></i>
                    <select name="project_id" id="sr_project_select" class="form-field form-field-select @error('project_id') is-invalid @enderror">
                        <option value="">— No Project —</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" 
                                data-customer-id="{{ $project->customer_id }}"
                                @selected((string) old('project_id', request('project_id')) === (string) $project->id)>
                                {{ $project->project_name }} ({{ $project->solar_capacity }} kW - {{ $project->customer_type }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('project_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>
</div>

{{-- ══ Section 2: Scheduling ══ --}}
<div class="form-card mb-4">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Scheduling &amp; Priority</h6>
    </div>
    <div class="form-card-body">
        <div class="row g-4">

            {{-- Request Date --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Request Date <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-calendar-event field-icon"></i>
                    <input type="date" name="request_date"
                           class="form-field @error('request_date') is-invalid @enderror"
                           value="{{ old('request_date', date('Y-m-d')) }}"
                           required>
                </div>
                @error('request_date')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Service Date --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Preferred Service Date <span style="color:#9CA3AF;font-weight:400;">(Optional)</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-calendar-check field-icon"></i>
                    <input type="date" name="service_date"
                           class="form-field @error('service_date') is-invalid @enderror"
                           value="{{ old('service_date') }}">
                </div>
                @error('service_date')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Priority --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Priority <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-flag field-icon"></i>
                    <select name="priority"
                            class="form-field form-field-select @error('priority') is-invalid @enderror"
                            required>
                        @foreach(['Low','Medium','High','Urgent'] as $p)
                            <option value="{{ $p }}" {{ old('priority','Medium') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                @error('priority')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Status --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Status <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-toggle2-on field-icon"></i>
                    <select name="status"
                            class="form-field form-field-select @error('status') is-invalid @enderror"
                            required>
                        @foreach(['Pending','Assigned','In Progress','Completed','Cancelled'] as $s)
                            <option value="{{ $s }}" {{ old('status','Pending') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                @error('status')<div class="field-error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>
</div>

{{-- ══ Section 3: Details ══ --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Location &amp; Additional Details</h6>
    </div>
    <div class="form-card-body">
        <div class="row g-4">

            {{-- Address --}}
            <div class="col-12">
                <label class="field-label">Service Address</label>
                <div class="field-input-wrap">
                    <i class="bi bi-geo-alt field-icon field-icon-textarea"></i>
                    <textarea name="address" rows="2"
                              class="form-field form-field-textarea @error('address') is-invalid @enderror"
                              placeholder="e.g. 45 Solar Street, Phase 2, Pune - 411001">{{ old('address') }}</textarea>
                </div>
                @error('address')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Description --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Description / Problem Details</label>
                <div class="field-input-wrap">
                    <i class="bi bi-card-text field-icon field-icon-textarea"></i>
                    <textarea name="description" rows="3"
                              class="form-field form-field-textarea @error('description') is-invalid @enderror"
                              placeholder="Describe the issue or service requirement in detail...">{{ old('description') }}</textarea>
                </div>
                @error('description')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Remarks --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Remarks / Internal Notes</label>
                <div class="field-input-wrap">
                    <i class="bi bi-chat-left-text field-icon field-icon-textarea"></i>
                    <textarea name="remarks" rows="3"
                              class="form-field form-field-textarea @error('remarks') is-invalid @enderror"
                              placeholder="Internal notes, special instructions, follow-up info...">{{ old('remarks') }}</textarea>
                </div>
                @error('remarks')<div class="field-error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>

    <div class="form-footer">
        <a href="{{ route('service-requests.index') }}" class="btn-cancel">
            <i class="bi bi-x-lg"></i> Cancel
        </a>
        <button type="submit" class="btn-save">
            <i class="bi bi-check-lg"></i> Save Request
        </button>
    </div>
</div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const custSelect = document.getElementById('sr_customer_select');
    const projSelect = document.getElementById('sr_project_select');
    const addrInput = document.querySelector('textarea[name="address"]');
    const srvSelect = document.getElementById('sr_service_select');
    const srvBadge = document.getElementById('service_info_badge');
    const descInput = document.querySelector('textarea[name="description"]');

    function handleServiceChange() {
        if (!srvSelect) return;
        const opt = srvSelect.options[srvSelect.selectedIndex];
        if (srvSelect.value && opt) {
            const desc = opt.getAttribute('data-description');
            const cat = opt.getAttribute('data-category');
            const dur = opt.getAttribute('data-duration');
            const price = opt.getAttribute('data-price');

            if (desc && descInput && (!descInput.value || descInput.value.trim() === '')) {
                descInput.value = desc;
            }

            if (srvBadge) {
                let badgeHtml = '';
                if (cat) badgeHtml += `<span class="badge bg-success-subtle text-success border border-success-subtle me-1"><i class="bi bi-tag-fill me-1"></i>${cat}</span>`;
                if (dur) badgeHtml += `<span class="badge bg-info-subtle text-info-emphasis border border-info-subtle me-1"><i class="bi bi-clock me-1"></i>${dur}</span>`;
                if (price && parseFloat(price) > 0) badgeHtml += `<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle"><i class="bi bi-currency-rupee me-1"></i>₹${parseFloat(price).toFixed(2)}</span>`;
                srvBadge.innerHTML = badgeHtml;
                srvBadge.style.display = badgeHtml ? 'block' : 'none';
            }
        } else if (srvBadge) {
            srvBadge.style.display = 'none';
            srvBadge.innerHTML = '';
        }
    }

    if (srvSelect) {
        srvSelect.addEventListener('change', handleServiceChange);
        if (srvSelect.value) handleServiceChange();
    }

    function handleCustomerChange() {
        if (!custSelect) return;
        const opt = custSelect.options[custSelect.selectedIndex];
        const custId = custSelect.value;
        if (opt && opt.getAttribute('data-address') && addrInput && (!addrInput.value || addrInput.value.trim() === '')) {
            addrInput.value = opt.getAttribute('data-address');
        }
        if (projSelect) {
            Array.from(projSelect.options).forEach((pOpt, idx) => {
                if (idx === 0) return;
                const pCustId = pOpt.getAttribute('data-customer-id');
                if (!custId || pCustId === custId) {
                    pOpt.style.display = '';
                } else {
                    pOpt.style.display = 'none';
                    if (pOpt.selected) projSelect.value = '';
                }
            });
        }
    }

    if (custSelect) {
        custSelect.addEventListener('change', handleCustomerChange);
        if (custSelect.value) handleCustomerChange();
    }
});
</script>

@endsection
