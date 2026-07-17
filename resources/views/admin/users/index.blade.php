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

    .user-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--border-soft); }
</style>

<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-person-gear me-2"></i>User Management
        </h1>
        <p class="page-hero-sub">Configure login accounts, roles, access levels and contact profiles for administrators and staff</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn-add-primary">
        <i class="bi bi-plus-lg"></i> Add User
    </a>
</div>



{{-- ── Filter Card ── --}}
<div class="filter-card mb-4">
    <form method="GET" action="{{ route('users.index') }}">
        <div class="row g-2 align-items-center">
            <!-- Search -->
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search name, email, mobile..."
                           value="{{ request('search') }}">
                </div>
            </div>

            <!-- Role -->
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="Super Admin" {{ request('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Manager" {{ request('role') == 'Manager' ? 'selected' : '' }}>Manager</option>
                        <option value="Employee" {{ request('role') == 'Employee' ? 'selected' : '' }}>Employee</option>
                        <option value="Technician" {{ request('role') == 'Technician' ? 'selected' : '' }}>Technician</option>
                    </select>
                </div>
            </div>

            <!-- Status -->
            <div class="col-12 col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="col-12 col-md-auto d-flex align-items-center gap-2">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                <a href="{{ route('users.index') }}" class="btn-reset" title="Reset Filters">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ── Table Card ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" style="min-width: 900px;">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th style="width: 80px;">Photo</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Mobile Number</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 240px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $key => $user)
                    @php
                        $srNo = ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            ? ($users->firstItem() + $key)
                            : ($key + 1);

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
                    <tr>
                        <td><span class="sr-badge">{{ $srNo }}</span></td>
                        <td>
                            <img src="{{ $user->profile_photo_url }}" class="user-avatar" alt="Avatar">
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $user->name }}</span>
                            @if($user->id === auth()->id())
                                <span class="badge bg-secondary ms-1" style="font-size:0.65rem;">You</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile_number ?? '—' }}</td>
                        <td><span class="{{ $roleBadge }}">{{ $user->role }}</span></td>
                        <td><span class="{{ $statusBadge }}">{{ $user->status }}</span></td>
                        <td>
                            <div class="action-group d-flex justify-content-end align-items-center gap-1">
                                <a href="{{ route('users.show', $user->id) }}" class="btn-action btn-action-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn-action btn-action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form d-inline m-0" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-action-delete">
                                            <i class="bi bi-trash3"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn-action btn-action-delete" disabled style="opacity:0.5; cursor:not-allowed;" title="You cannot delete your own account">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-people-fill"></i></div>
                                <h6 class="fw-semibold text-secondary mb-1">No users found</h6>
                                <p class="text-muted small mb-3">Adjust your filters or register a new system operator user.</p>
                                <a href="{{ route('users.create') }}" class="btn-add-primary" style="border-radius:20px; padding:8px 20px; font-size:0.82rem;">
                                    <i class="bi bi-plus-lg"></i> Add User
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
        <div class="card-footer-pagination border-top px-4 py-3 bg-white">
            {{ $users->links() }}
        </div>
    @endif
</div>

@endsection
