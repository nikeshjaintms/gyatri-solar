@extends('layouts.admin')

@section('content')

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-tools"></i></span>
        New Job Assignment
    </h1>
    <a href="{{ route('job-assignments.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


<form action="{{ route('job-assignments.store') }}" method="POST">
@csrf

{{-- ══ Section 1: Assignment Linking ══ --}}
<div class="form-card mb-4">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Assignment Linking</h6>
    </div>
    <div class="form-card-body">
        <div class="row g-4">

            {{-- Service Request --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Service Request <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-clipboard2-check field-icon"></i>
                    <select name="service_request_id"
                            class="form-field form-field-select @error('service_request_id') is-invalid @enderror"
                            required>
                        <option value="">— Select Service Request —</option>
                        @foreach($serviceRequests as $sr)
                            <option value="{{ $sr->id }}"
                                {{ old('service_request_id') == $sr->id ? 'selected' : '' }}>
                                {{ $sr->customer?->name ?? 'N/A' }}
                                — {{ $sr->service?->service_name ?? 'N/A' }}
                                — {{ $sr->request_date?->format('d M Y') ?? '' }}
                                ({{ $sr->status }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('service_request_id')<div class="field-error">{{ $message }}</div>@enderror
                <div class="field-hint">Only active (non-completed/cancelled) service requests shown.</div>
            </div>

            {{-- Technician --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Technician <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-person-badge field-icon"></i>
                    <select name="technician_id"
                            class="form-field form-field-select @error('technician_id') is-invalid @enderror"
                            required>
                        <option value="">— Select Technician —</option>
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

            {{-- Assigned Date --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Assigned Date <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-calendar-event field-icon"></i>
                    <input type="date" name="assigned_date"
                           class="form-field @error('assigned_date') is-invalid @enderror"
                           value="{{ old('assigned_date', date('Y-m-d')) }}"
                           required>
                </div>
                @error('assigned_date')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Scheduled Date --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Scheduled Date <span style="color:#9CA3AF;font-weight:400;">(Optional)</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-calendar-check field-icon"></i>
                    <input type="date" name="scheduled_date"
                           class="form-field @error('scheduled_date') is-invalid @enderror"
                           value="{{ old('scheduled_date') }}">
                </div>
                @error('scheduled_date')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Scheduled Time --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Scheduled Time <span style="color:#9CA3AF;font-weight:400;">(Optional)</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-clock field-icon"></i>
                    <input type="time" name="scheduled_time"
                           class="form-field @error('scheduled_time') is-invalid @enderror"
                           value="{{ old('scheduled_time') }}">
                </div>
                @error('scheduled_time')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Priority --}}
            <div class="col-12 col-md-3">
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
            <div class="col-12 col-md-3">
                <label class="field-label">Status <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-toggle2-on field-icon"></i>
                    <select name="status"
                            class="form-field form-field-select @error('status') is-invalid @enderror"
                            required>
                        @foreach(['Assigned','Accepted','In Progress','Completed','Cancelled'] as $s)
                            <option value="{{ $s }}" {{ old('status','Assigned') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                @error('status')<div class="field-error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>
</div>

{{-- ══ Section 3: Notes ══ --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Work Notes &amp; Remarks</h6>
    </div>
    <div class="form-card-body">
        <div class="row g-4">

            {{-- Work Notes --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Work Notes</label>
                <div class="field-input-wrap">
                    <i class="bi bi-card-text field-icon field-icon-textarea"></i>
                    <textarea name="work_notes" rows="4"
                              class="form-field form-field-textarea @error('work_notes') is-invalid @enderror"
                              placeholder="Describe the work to be performed, tools required, safety checks...">{{ old('work_notes') }}</textarea>
                </div>
                @error('work_notes')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Remarks --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Remarks / Internal Notes</label>
                <div class="field-input-wrap">
                    <i class="bi bi-chat-left-text field-icon field-icon-textarea"></i>
                    <textarea name="remarks" rows="4"
                              class="form-field form-field-textarea @error('remarks') is-invalid @enderror"
                              placeholder="Internal notes, supervisor comments, follow-up instructions...">{{ old('remarks') }}</textarea>
                </div>
                @error('remarks')<div class="field-error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>

    <div class="form-footer">
        <a href="{{ route('job-assignments.index') }}" class="btn-cancel">
            <i class="bi bi-x-lg"></i> Cancel
        </a>
        <button type="submit" class="btn-save">
            <i class="bi bi-check-lg"></i> Save Assignment
        </button>
    </div>
</div>

</form>

@endsection
