@extends('layouts.admin')

@section('content')

<style>
    .badge-superadmin { background-color: #F3E8FF; color: #6B21A8; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-admin { background-color: #FCE8E6; color: #C53030; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-manager { background-color: #E1EFFE; color: #1E429F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-employee { background-color: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-technician { background-color: #E6FFFA; color: #00A389; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }

    .badge-active { background-color: #DEF7EC; color: #03543F; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-inactive { background-color: #FDE8E8; color: #9B1C1C; padding: 5px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block; }

    .detail-row { padding: 16px 20px; border-bottom: 1px solid #E8ECF0; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { font-size: 0.85rem; color: #6B7280; font-weight: 500; }
    .detail-value { font-size: 0.9rem; color: #111827; font-weight: 600; }
</style>

<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-person-lines-fill"></i></span>
        User Account Profile
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('users.edit', $user->id) }}" class="btn-add-primary" style="background-color: #3B82F6;">
            <i class="bi bi-pencil"></i> Edit Profile
        </a>
        <a href="{{ route('users.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Profile Card Summary -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm p-4 bg-white text-center" style="border-radius: 12px; height:100%;">
            <div class="position-relative d-inline-block mx-auto mb-3">
                <img src="{{ $user->profile_photo_url }}" style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 3px solid var(--brand-orange);" alt="Profile Avatar">
            </div>
            <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
            <p class="text-muted small mb-3">{{ $user->email }}</p>
            
            <div class="d-flex justify-content-center gap-2 mb-2">
                @php
                    $roleBadge = match($user->role) {
                        'Super Admin' => 'badge-superadmin',
                        'Admin' => 'badge-admin',
                        'Manager' => 'badge-manager',
                        'Employee' => 'badge-employee',
                        'Technician' => 'badge-technician',
                        default => 'badge-employee',
                    };
                    $statusBadge = match($user->status) {
                        'Active' => 'badge-active',
                        'Inactive' => 'badge-inactive',
                        default => 'badge-active',
                    };
                @endphp
                <span class="{{ $roleBadge }}">{{ $user->role }}</span>
                <span class="{{ $statusBadge }}">{{ $user->status }}</span>
            </div>
        </div>
    </div>

    <!-- Contact & Details Info -->
    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm p-0 bg-white" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom px-4 py-3">
                <h6 class="fw-bold text-dark mb-0">Complete Contact Information</h6>
            </div>
            <div class="form-card-body p-0">
                
                <!-- Email -->
                <div class="detail-row row">
                    <div class="col-4 detail-label">Email Address</div>
                    <div class="col-8 detail-value text-primary">{{ $user->email }}</div>
                </div>

                <!-- Phone -->
                <div class="detail-row row">
                    <div class="col-4 detail-label">Mobile / Phone Number</div>
                    <div class="col-8 detail-value">{{ $user->mobile_number ?? '—' }}</div>
                </div>

                <!-- Role -->
                <div class="col-4 detail-row row d-none"></div> {{-- Spacer --}}

                <!-- Address -->
                <div class="detail-row row">
                    <div class="col-4 detail-label">Contact Address</div>
                    <div class="col-8 detail-value" style="font-weight: normal; color: #4B5563;">
                        {{ $user->address ?? 'No address registered' }}
                    </div>
                </div>

                <!-- Registered Date -->
                <div class="detail-row row">
                    <div class="col-4 detail-label">Registered Date</div>
                    <div class="col-8 detail-value" style="font-weight: normal; color: #6B7280;">
                        {{ $user->created_at?->format('d M Y h:i A') ?? '—' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
