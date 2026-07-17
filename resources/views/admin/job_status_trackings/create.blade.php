@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-geo-alt"></i></span>
        Add Status Update
    </h1>
    <a href="{{ route('job-status-tracking.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


<form action="{{ route('job-status-tracking.store') }}" method="POST">
@csrf

{{-- ══ Section 1: Job Link ══ --}}
<div class="form-card mb-4">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Job Assignment Link</h6>
    </div>
    <div class="form-card-body">
        <div class="row g-4">

            {{-- Job Assignment --}}
            <div class="col-12">
                <label class="field-label">Job Assignment <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-tools field-icon"></i>
                    <select name="job_assignment_id"
                            class="form-field form-field-select @error('job_assignment_id') is-invalid @enderror"
                            required>
                        <option value="">— Select Job Assignment —</option>
                        @foreach($jobAssignments as $job)
                            <option value="{{ $job->id }}"
                                {{ old('job_assignment_id') == $job->id ? 'selected' : '' }}>
                                {{ $job->serviceRequest?->customer?->name ?? 'N/A' }}
                                — {{ $job->serviceRequest?->service?->service_name ?? 'N/A' }}
                                — {{ $job->technician?->name ?? 'N/A' }}
                                @if($job->scheduled_date)
                                    — {{ $job->scheduled_date->format('d M Y') }}
                                @endif
                                ({{ $job->status }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('job_assignment_id')<div class="field-error">{{ $message }}</div>@enderror
                <div class="field-hint">Select the job assignment you want to log a status update for.</div>
            </div>

        </div>
    </div>
</div>

{{-- ══ Section 2: Status & Schedule ══ --}}
<div class="form-card mb-4">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Status &amp; Schedule</h6>
    </div>
    <div class="form-card-body">
        <div class="row g-4">

            {{-- Status --}}
            <div class="col-12 col-md-4">
                <label class="field-label">Status <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-activity field-icon"></i>
                    <select name="status"
                            class="form-field form-field-select @error('status') is-invalid @enderror"
                            required>
                        <option value="">— Select Status —</option>
                        @foreach(['Assigned','Accepted','On The Way','In Progress','Hold','Completed','Cancelled'] as $s)
                            <option value="{{ $s }}" {{ old('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                @error('status')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Status Date --}}
            <div class="col-12 col-md-4">
                <label class="field-label">Status Date <span class="req">*</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-calendar-event field-icon"></i>
                    <input type="date" name="status_date"
                           class="form-field @error('status_date') is-invalid @enderror"
                           value="{{ old('status_date', date('Y-m-d')) }}"
                           required>
                </div>
                @error('status_date')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Status Time --}}
            <div class="col-12 col-md-4">
                <label class="field-label">Status Time <span style="color:#9CA3AF;font-weight:400;">(Optional)</span></label>
                <div class="field-input-wrap">
                    <i class="bi bi-clock field-icon"></i>
                    <input type="time" name="status_time"
                           class="form-field @error('status_time') is-invalid @enderror"
                           value="{{ old('status_time') }}">
                </div>
                @error('status_time')<div class="field-error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>
</div>

{{-- ══ Section 3: Notes ══ --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Progress &amp; Notes</h6>
    </div>
    <div class="form-card-body">
        <div class="row g-4">

            {{-- Work Progress --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Work Progress</label>
                <div class="field-input-wrap">
                    <i class="bi bi-list-check field-icon field-icon-textarea"></i>
                    <textarea name="work_progress" rows="4"
                              class="form-field form-field-textarea @error('work_progress') is-invalid @enderror"
                              placeholder="Describe the work done so far, percentage complete, next steps...">{{ old('work_progress') }}</textarea>
                </div>
                @error('work_progress')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            {{-- Notes --}}
            <div class="col-12 col-md-6">
                <label class="field-label">Notes / Observations</label>
                <div class="field-input-wrap">
                    <i class="bi bi-chat-left-text field-icon field-icon-textarea"></i>
                    <textarea name="notes" rows="4"
                              class="form-field form-field-textarea @error('notes') is-invalid @enderror"
                              placeholder="Any issues encountered, customer feedback, materials used...">{{ old('notes') }}</textarea>
                </div>
                @error('notes')<div class="field-error">{{ $message }}</div>@enderror
            </div>

        </div>
    </div>

    <div class="form-footer">
        <a href="{{ route('job-status-tracking.index') }}" class="btn-cancel">
            <i class="bi bi-x-lg"></i> Cancel
        </a>
        <button type="submit" class="btn-save">
            <i class="bi bi-check-lg"></i> Save Status
        </button>
    </div>
</div>

</form>

@endsection
