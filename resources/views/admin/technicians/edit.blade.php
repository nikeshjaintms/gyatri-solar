@extends('layouts.admin')

@section('content')

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-pencil-square"></i></span>
        Edit Technician
    </h1>
    <a href="{{ route('technicians.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

<div class="edit-info-banner">
    <i class="bi bi-info-circle-fill flex-shrink-0" style="color:#F58220; font-size:1rem;"></i>
    <span>Editing <strong>{{ $technician->name }}</strong> — changes will be saved immediately after updating.</span>
</div>


<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Update Technician Information</h6>
    </div>

    <form action="{{ route('technicians.update', $technician->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card-body">
            <div class="row g-4">

                <div class="col-12 col-md-6">
                    <label class="field-label">Full Name <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <input type="text" name="name" class="form-field @error('name') is-invalid @enderror"
                               value="{{ old('name', $technician->name) }}" placeholder="e.g. John Smith" required>
                    </div>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Email Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-envelope field-icon"></i>
                        <input type="email" name="email" class="form-field @error('email') is-invalid @enderror"
                               value="{{ old('email', $technician->email) }}" placeholder="e.g. john@example.com">
                    </div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Phone Number <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-telephone field-icon"></i>
                        <input type="text" name="phone" class="form-field @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $technician->phone) }}" placeholder="e.g. +1 (555) 000-0000" required>
                    </div>
                    @error('phone')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Specialization</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-tools field-icon"></i>
                        <input type="text" name="specialization" class="form-field @error('specialization') is-invalid @enderror"
                               value="{{ old('specialization', $technician->specialization) }}" placeholder="e.g. Solar Panel Installation">
                    </div>
                    @error('specialization')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Experience</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-award field-icon"></i>
                        <input type="text" name="experience" class="form-field @error('experience') is-invalid @enderror"
                               value="{{ old('experience', $technician->experience) }}" placeholder="e.g. 5 years / Senior Level">
                    </div>
                    @error('experience')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-toggle2-on field-icon"></i>
                        <select name="status" class="form-field form-field-select @error('status') is-invalid @enderror" required>
                            <option value="Active"   {{ old('status',$technician->status)=='Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status',$technician->status)=='Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @error('status')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="field-label">Street Address</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-geo-alt field-icon field-icon-textarea"></i>
                        <textarea name="address" rows="3"
                                  class="form-field form-field-textarea @error('address') is-invalid @enderror"
                                  placeholder="e.g. 789 Maple Ave, Suite 200">{{ old('address', $technician->address) }}</textarea>
                    </div>
                    @error('address')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('technicians.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-update">
                <i class="bi bi-check2-all"></i> Update Technician
            </button>
        </div>
    </form>
</div>

@endsection
