@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-pencil-square"></i></span>
        Edit Employee: {{ $employee->employee_id }}
    </h1>
    <a href="{{ route('employees.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Form Card ── --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Update Employee Information</h6>
    </div>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card-body">
            <div class="row g-4">

                {{-- Employee ID (Read-only) --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Employee ID</label>
                    <div class="field-input-wrap bg-light">
                        <i class="bi bi-hash field-icon"></i>
                        <input type="text" class="form-field"
                               value="{{ $employee->employee_id }}" readonly
                               style="background-color: #f3f4f6; color: #4B5563; font-weight: bold; cursor: not-allowed;">
                    </div>
                </div>

                {{-- Full Name --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Full Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <input type="text" name="name"
                               class="form-field @error('name') is-invalid @enderror"
                               value="{{ old('name', $employee->user->name ?? '') }}"
                               placeholder="e.g. John Doe" required>
                    </div>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Mobile Number --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Mobile Number <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-telephone field-icon"></i>
                        <input type="text" name="mobile_number"
                               class="form-field @error('mobile_number') is-invalid @enderror"
                               value="{{ old('mobile_number', $employee->user->mobile_number ?? '') }}"
                               placeholder="e.g. +91 9876543210" required>
                    </div>
                    @error('mobile_number')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Email Address --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Email Address <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-envelope field-icon"></i>
                        <input type="email" name="email"
                               class="form-field @error('email') is-invalid @enderror"
                               value="{{ old('email', $employee->user->email ?? '') }}"
                               placeholder="e.g. john@gayatrisolar.com" required>
                    </div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Password (Optional) --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Password <span class="text-muted" style="font-weight: normal;">(Leave blank to keep current)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-lock field-icon"></i>
                        <input type="password" name="password"
                               class="form-field @error('password') is-invalid @enderror"
                               placeholder="Enter new password">
                    </div>
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Confirm Password --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Confirm New Password</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-lock-fill field-icon"></i>
                        <input type="password" name="password_confirmation"
                               class="form-field"
                               placeholder="Confirm new password">
                    </div>
                </div>

                {{-- Department --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Department <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-building field-icon"></i>
                        <select name="department" class="form-field form-field-select @error('department') is-invalid @enderror" required>
                            <option value="">Select Department</option>
                            <option value="Sales" {{ old('department', $employee->department) == 'Sales' ? 'selected' : '' }}>Sales</option>
                            <option value="Operations" {{ old('department', $employee->department) == 'Operations' ? 'selected' : '' }}>Operations</option>
                            <option value="Engineering" {{ old('department', $employee->department) == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="Accounts" {{ old('department', $employee->department) == 'Accounts' ? 'selected' : '' }}>Accounts</option>
                            <option value="HR" {{ old('department', $employee->department) == 'HR' ? 'selected' : '' }}>HR</option>
                        </select>
                    </div>
                    @error('department')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Designation --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Designation <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person-badge field-icon"></i>
                        <input type="text" name="designation"
                               class="form-field @error('designation') is-invalid @enderror"
                               value="{{ old('designation', $employee->designation) }}"
                               placeholder="e.g. Solar Engineer, Sales Executive" required>
                    </div>
                    @error('designation')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Joining Date --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Joining Date <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar-event field-icon"></i>
                        <input type="date" name="joining_date"
                               class="form-field @error('joining_date') is-invalid @enderror"
                               value="{{ old('joining_date', $employee->joining_date ? $employee->joining_date->format('Y-m-d') : '') }}" required>
                    </div>
                    @error('joining_date')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Salary --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Salary (Monthly, Optional)</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-currency-rupee field-icon"></i>
                        <input type="number" name="salary" step="0.01"
                               class="form-field @error('salary') is-invalid @enderror"
                               value="{{ old('salary', $employee->salary) }}"
                               placeholder="e.g. 45000">
                    </div>
                    @error('salary')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Profile Photo Upload --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Profile Photo (Optional)</label>
                    <div class="d-flex align-items-center gap-3">
                        @if($employee->user && $employee->user->profile_photo)
                            <img src="{{ asset('storage/' . $employee->user->profile_photo) }}" 
                                 alt="Current profile photo" 
                                 class="rounded border" 
                                 style="width: 55px; height: 55px; object-fit: cover;">
                        @endif
                        <div class="field-input-wrap flex-grow-1">
                            <i class="bi bi-image field-icon"></i>
                            <input type="file" name="profile_photo"
                                   class="form-field @error('profile_photo') is-invalid @enderror"
                                   accept="image/*">
                        </div>
                    </div>
                    <div class="form-text text-muted small mt-1">Accepted: jpeg, png, jpg, gif. Max size: 2MB.</div>
                    @error('profile_photo')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Status --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-toggle2-on field-icon"></i>
                        <select name="status"
                                class="form-field form-field-select @error('status') is-invalid @enderror">
                            <option value="Active"   {{ old('status', $employee->user->status ?? 'Active') == 'Active'   ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $employee->user->status ?? '') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @error('status')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Address --}}
                <div class="col-12">
                    <label class="field-label">Residential Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-geo-alt field-icon field-icon-textarea"></i>
                        <textarea name="address" rows="3"
                                  class="form-field form-field-textarea @error('address') is-invalid @enderror"
                                  placeholder="Enter complete address...">{{ old('address', $employee->user->address ?? '') }}</textarea>
                    </div>
                    @error('address')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="form-footer">
            <a href="{{ route('employees.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Update Employee
            </button>
        </div>
    </form>
</div>

@endsection
