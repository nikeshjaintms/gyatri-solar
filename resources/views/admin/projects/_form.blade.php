<div class="row g-3">
    <div class="col-12 col-md-6">
        <label class="form-label">Project name <span class="text-danger">*</span></label>
        <input name="project_name" value="{{ old('project_name', $project->project_name) }}" class="form-control @error('project_name') is-invalid @enderror" required>
        @error('project_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label class="form-label">Customer <span class="text-danger">*</span></label>
        <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
            <option value="">Select customer</option>
            @foreach($customers as $customer)<option value="{{ $customer->id }}" @selected((string) old('customer_id', $project->customer_id ?? request('customer_id')) === (string) $customer->id)>{{ $customer->name }} ({{ $customer->customer_type }})</option>@endforeach
        </select>
        @error('customer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Solar capacity (kW) <span class="text-danger">*</span></label>
        <input type="number" name="solar_capacity" min="0.01" step="0.01" value="{{ old('solar_capacity', $project->solar_capacity) }}" class="form-control @error('solar_capacity') is-invalid @enderror" required>
        @error('solar_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach(['New', 'In Progress', 'Completed', 'Cancelled'] as $status)<option value="{{ $status }}" @selected(old('status', $project->status ?: 'New') === $status)>{{ $status }}</option>@endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Start date</label>
        <input type="date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" class="form-control @error('start_date') is-invalid @enderror">
        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 col-md-6">
        <label class="form-label">Completion date</label>
        <input type="date" name="completion_date" value="{{ old('completion_date', $project->completion_date?->format('Y-m-d')) }}" class="form-control @error('completion_date') is-invalid @enderror">
        @error('completion_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Installation address <span class="text-danger">*</span></label>
        <textarea name="installation_address" rows="3" class="form-control @error('installation_address') is-invalid @enderror" required>{{ old('installation_address', $project->installation_address) }}</textarea>
        @error('installation_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $project->notes) }}</textarea>
        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>