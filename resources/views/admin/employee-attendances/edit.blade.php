@extends('layouts.admin')

@section('content')

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-pencil-square"></i></span>
        Edit Employee Attendance
    </h1>
    <a href="{{ route('employee-attendances.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Attendance Details</h6>
    </div>

    <form action="{{ route('employee-attendances.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-card-body">

            <p class="section-label">Basic Information</p>
            <div class="row g-4 mb-2">

                <!-- Employee Name Dropdown -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Employee Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <select name="employee_id" class="form-field form-field-select @error('employee_id') is-invalid @enderror" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $attendance->employee_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('employee_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Attendance Date -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Attendance Date <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar-event field-icon"></i>
                        <input type="date" name="attendance_date" class="form-field @error('attendance_date') is-invalid @enderror"
                               value="{{ old('attendance_date', $attendance->attendance_date?->format('Y-m-d')) }}" required>
                    </div>
                    @error('attendance_date')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Status -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-info-circle field-icon"></i>
                        <select name="status" id="status" class="form-field form-field-select @error('status') is-invalid @enderror" required>
                            <option value="Present" {{ old('status', $attendance->status) == 'Present' ? 'selected' : '' }}>Present</option>
                            <option value="Absent" {{ old('status', $attendance->status) == 'Absent' ? 'selected' : '' }}>Absent</option>
                            <option value="Half Day" {{ old('status', $attendance->status) == 'Half Day' ? 'selected' : '' }}>Half Day</option>
                            <option value="Leave" {{ old('status', $attendance->status) == 'Leave' ? 'selected' : '' }}>Leave</option>
                        </select>
                    </div>
                    @error('status')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-3">Timing &amp; Hours</p>
            <div class="row g-4 mb-2">

                <!-- Check In Time -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Check In Time <span id="check_in_req" class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-box-arrow-in-right field-icon"></i>
                        <input type="time" name="check_in_time" id="check_in_time" 
                               class="form-field @error('check_in_time') is-invalid @enderror"
                               value="{{ old('check_in_time', $attendance->check_in_time ? \Carbon\Carbon::createFromTimeString($attendance->check_in_time)->format('H:i') : '') }}">
                    </div>
                    @error('check_in_time')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Check Out Time -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Check Out Time <span id="check_out_req" class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-box-arrow-left field-icon"></i>
                        <input type="time" name="check_out_time" id="check_out_time" 
                               class="form-field @error('check_out_time') is-invalid @enderror"
                               value="{{ old('check_out_time', $attendance->check_out_time ? \Carbon\Carbon::createFromTimeString($attendance->check_out_time)->format('H:i') : '') }}">
                    </div>
                    @error('check_out_time')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Work Hours (Read-Only) -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Work Hours <span class="text-muted">(Calculated)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-clock field-icon"></i>
                        <input type="text" id="work_hours_display" class="form-field" 
                               style="background-color: #F3F4F6;" readonly value="—">
                    </div>
                </div>

            </div>

            <p class="section-label mt-3">Remarks</p>
            <div class="row g-4">
                <div class="col-12">
                    <label class="field-label">Remarks / Notes</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-chat-text field-icon field-icon-textarea"></i>
                        <textarea name="remarks" rows="3"
                                  class="form-field form-field-textarea @error('remarks') is-invalid @enderror"
                                  placeholder="Enter remarks or comments if applicable...">{{ old('remarks', $attendance->remarks) }}</textarea>
                    </div>
                    @error('remarks')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>

        <div class="form-footer">
            <a href="{{ route('employee-attendances.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Update Attendance
            </button>
        </div>
    </form>
</div>

{{-- ── Javascript for dynamic Work Hours calculation & input enabling ── --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const checkInInput = document.getElementById('check_in_time');
    const checkOutInput = document.getElementById('check_out_time');
    const workHoursDisplay = document.getElementById('work_hours_display');
    const checkInReq = document.getElementById('check_in_req');
    const checkOutReq = document.getElementById('check_out_req');

    function toggleTimeFields() {
        const status = statusSelect.value;
        if (status === 'Present' || status === 'Half Day') {
            checkInInput.disabled = false;
            checkOutInput.disabled = false;
            if (checkInReq) checkInReq.style.display = 'inline';
            if (checkOutReq) checkOutReq.style.display = 'inline';
            calculateWorkHours();
        } else {
            checkInInput.disabled = true;
            checkOutInput.disabled = true;
            checkInInput.value = '';
            checkOutInput.value = '';
            if (checkInReq) checkInReq.style.display = 'none';
            if (checkOutReq) checkOutReq.style.display = 'none';
            workHoursDisplay.value = '—';
        }
    }

    function calculateWorkHours() {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;

        if (!checkIn || !checkOut) {
            workHoursDisplay.value = '—';
            return;
        }

        const [inH, inM] = checkIn.split(':').map(Number);
        const [outH, outM] = checkOut.split(':').map(Number);

        let diffMins = (outH * 60 + outM) - (inH * 60 + inM);

        if (diffMins < 0) {
            workHoursDisplay.value = 'Check Out must be after Check In';
            return;
        }

        const hours = Math.floor(diffMins / 60);
        const minutes = diffMins % 60;

        const formattedHours = String(hours).padStart(2, '0');
        const formattedMinutes = String(minutes).padStart(2, '0');

        workHoursDisplay.value = `${formattedHours} Hours ${formattedMinutes} Minutes`;
    }

    statusSelect.addEventListener('change', toggleTimeFields);
    checkInInput.addEventListener('change', calculateWorkHours);
    checkOutInput.addEventListener('change', calculateWorkHours);

    // Initial state setup
    toggleTimeFields();
});
</script>

@endsection
