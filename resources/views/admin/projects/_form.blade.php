<div class="row g-4 mb-2">
    <div class="col-12 col-md-6">
        <label class="field-label">Project Name <span class="req">*</span></label>
        <div class="field-input-wrap">
            <i class="bi bi-sun field-icon"></i>
            <input type="text" name="project_name" value="{{ old('project_name', $project->project_name) }}"
                   class="form-field @error('project_name') is-invalid @enderror"
                   placeholder="e.g. 5kW Solar Rooftop Installation" required>
        </div>
        @error('project_name')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label class="field-label">Customer <span class="req">*</span></label>
        <div class="field-input-wrap">
            <i class="bi bi-person field-icon"></i>
            <select name="customer_id" id="project_customer_select"
                    class="form-field form-field-select @error('customer_id') is-invalid @enderror" required>
                <option value="">— Select Customer —</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" 
                            data-address="{{ $customer->address ? ($customer->address . ($customer->city ? ', ' . $customer->city : '')) : '' }}"
                            data-type="{{ $customer->customer_type }}"
                            @selected((string) old('customer_id', $project->customer_id ?? request('customer_id')) === (string) $customer->id)>
                        {{ $customer->name }} ({{ $customer->customer_type }})
                    </option>
                @endforeach
            </select>
        </div>
        @error('customer_id')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label class="field-label">Solar Capacity (kW) <span class="req">*</span></label>
        <div class="field-input-wrap">
            <i class="bi bi-lightning-charge field-icon"></i>
            <input type="number" name="solar_capacity" min="0.01" step="0.01"
                   value="{{ old('solar_capacity', $project->solar_capacity) }}"
                   class="form-field @error('solar_capacity') is-invalid @enderror"
                   placeholder="e.g. 5.50" required>
        </div>
        @error('solar_capacity')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label class="field-label">Project Status <span class="req">*</span></label>
        <div class="field-input-wrap">
            <i class="bi bi-activity field-icon"></i>
            <select name="status" class="form-field form-field-select @error('status') is-invalid @enderror" required>
                @foreach(['New', 'In Progress', 'Completed', 'Cancelled'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $project->status ?: 'New') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        @error('status')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label class="field-label">Start Date</label>
        <div class="field-input-wrap">
            <i class="bi bi-calendar-date field-icon"></i>
            <input type="date" name="start_date"
                   value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                   class="form-field @error('start_date') is-invalid @enderror">
        </div>
        @error('start_date')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label class="field-label">Completion Date</label>
        <div class="field-input-wrap">
            <i class="bi bi-calendar-check field-icon"></i>
            <input type="date" name="completion_date"
                   value="{{ old('completion_date', $project->completion_date?->format('Y-m-d')) }}"
                   class="form-field @error('completion_date') is-invalid @enderror">
        </div>
        @error('completion_date')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="field-label">Installation Address <span class="req">*</span></label>
        <div class="field-input-wrap">
            <textarea name="installation_address" id="installation_address" rows="3"
                      class="form-field @error('installation_address') is-invalid @enderror"
                      placeholder="Enter full site installation address..." required style="height:auto; padding-top:10px; padding-left:14px;">{{ old('installation_address', $project->installation_address) }}</textarea>
        </div>
        @error('installation_address')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="field-label">Notes & Specifications</label>
        <div class="field-input-wrap">
            <textarea name="notes" rows="3"
                      class="form-field @error('notes') is-invalid @enderror"
                      placeholder="Any additional notes or specifications..." style="height:auto; padding-top:10px; padding-left:14px;">{{ old('notes', $project->notes) }}</textarea>
        </div>
        @error('notes')<div class="field-error">{{ $message }}</div>@enderror
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const custSelect = document.getElementById('project_customer_select');
    const addrInput = document.getElementById('installation_address');
    if (custSelect && addrInput) {
        custSelect.addEventListener('change', function() {
            const opt = custSelect.options[custSelect.selectedIndex];
            if (opt && opt.getAttribute('data-address') && (!addrInput.value || addrInput.value.trim() === '')) {
                addrInput.value = opt.getAttribute('data-address');
            }
        });
        if (custSelect.value && (!addrInput.value || addrInput.value.trim() === '')) {
            const opt = custSelect.options[custSelect.selectedIndex];
            if (opt && opt.getAttribute('data-address')) {
                addrInput.value = opt.getAttribute('data-address');
            }
        }
    }
});
</script>