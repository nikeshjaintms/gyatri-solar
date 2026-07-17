@extends('layouts.admin')

@section('content')

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-pencil-square"></i></span>
        Edit User: {{ $user->name }}
    </h1>
    <a href="{{ route('users.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Account Profile Details</h6>
    </div>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-card-body">

            <p class="section-label">Operator Personal Details</p>
            <div class="row g-4 mb-2">

                <!-- Full Name -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Full Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <input type="text" name="name" class="form-field @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" placeholder="e.g. Mukesh Patel" required>
                    </div>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Email -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Email Address <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-envelope field-icon"></i>
                        <input type="email" name="email" class="form-field @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" placeholder="e.g. mukesh@gayatrisolar.com" required>
                    </div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Mobile Number -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Mobile Number</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-telephone field-icon"></i>
                        <input type="text" name="mobile_number" class="form-field @error('mobile_number') is-invalid @enderror"
                               value="{{ old('mobile_number', $user->mobile_number) }}" placeholder="e.g. +91 9876543210">
                    </div>
                    @error('mobile_number')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Profile Photo -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Replace Profile Photo <span class="text-muted">(JPG, PNG max 1MB)</span></label>
                    <div class="field-input-wrap mb-2">
                        <i class="bi bi-image field-icon"></i>
                        <input type="file" name="profile_photo" class="form-field @error('profile_photo') is-invalid @enderror" accept="image/*">
                    </div>
                    @if($user->profile_photo)
                        <div class="d-flex align-items-center gap-2 border p-2 rounded bg-light" style="width: fit-content;">
                            <img src="{{ $user->profile_photo_url }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;" alt="Current photo">
                            <span class="small text-muted">Current Avatar</span>
                        </div>
                    @endif
                    @error('profile_photo')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            <p class="section-label mt-2">Security Password Credentials <span class="text-muted">(Leave blank to keep current password)</span></p>
            <div class="row g-4 mb-2">

                <!-- Password -->
                <div class="col-12 col-md-6">
                    <label class="field-label">New Password</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-shield-lock field-icon"></i>
                        <input type="password" name="password" class="form-field @error('password') is-invalid @enderror"
                               placeholder="Minimum 8 characters">
                    </div>
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <!-- Confirm Password -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Confirm New Password</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-shield-check field-icon"></i>
                        <input type="password" name="password_confirmation" class="form-field"
                               placeholder="Retype password">
                    </div>
                </div>

            </div>

            <p class="section-label mt-2">Roles &amp; Status settings</p>
            <div class="row g-4 mb-2">

                <!-- Role -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Access Role <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person-badge field-icon"></i>
                        <select name="role" class="form-field form-field-select" required>
                            <option value="Super Admin" {{ old('role', $user->role) == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Manager" {{ old('role', $user->role) == 'Manager' ? 'selected' : '' }}>Manager</option>
                            <option value="Employee" {{ old('role', $user->role) == 'Employee' ? 'selected' : '' }}>Employee</option>
                            <option value="Technician" {{ old('role', $user->role) == 'Technician' ? 'selected' : '' }}>Technician</option>
                        </select>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-12 col-md-6">
                    <label class="field-label">Account Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-toggle2-on field-icon"></i>
                        <select name="status" class="form-field form-field-select" required>
                            <option value="Active" {{ old('status', $user->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $user->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

            </div>

            <p class="section-label mt-2">Address Contact Location</p>
            <div class="row g-4">
                <div class="col-12">
                    <label class="field-label">Address Description</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-geo-alt field-icon field-icon-textarea"></i>
                        <textarea name="address" rows="2" class="form-field form-field-textarea" 
                                  placeholder="Enter complete residential address...">{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-footer">
            <a href="{{ route('users.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Update Account
            </button>
        </div>
    </form>
</div>

@endsection
