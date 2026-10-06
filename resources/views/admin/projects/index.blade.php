@extends('layouts.admin')

@section('content')
<div class="page-hero d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-hero-title"><i class="bi bi-sun me-2"></i>Solar Projects</h1>
        <p class="page-hero-sub mb-0">Track customer installations and project progress.</p>
    </div>
    <a href="{{ route('projects.create') }}" class="btn-add-primary"><i class="bi bi-plus-lg"></i>Add Project</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('projects.index') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-5"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Search project or customer"></div>
            <div class="col-12 col-md-2">
                <select name="status" class="form-select"><option value="">All statuses</option>@foreach(['New', 'In Progress', 'Completed', 'Cancelled'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select>
            </div>
            <div class="col-12 col-md-2">
                <select name="customer_type" class="form-select"><option value="">All types</option>@foreach(['Residential', 'Commercial', 'Other'] as $type)<option value="{{ $type }}" @selected(request('customer_type') === $type)>{{ $type }}</option>@endforeach</select>
            </div>
            <div class="col-auto"><button class="btn-filter"><i class="bi bi-funnel"></i>Filter</button></div>
            <div class="col-auto"><a href="{{ route('projects.index') }}" class="btn-reset" title="Clear filters" aria-label="Clear filters"><i class="bi bi-arrow-counterclockwise"></i></a></div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Project</th><th>Customer</th><th>Type</th><th>Capacity</th><th>Status</th><th>Start date</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse($projects as $project)
                <tr>
                    <td class="fw-semibold">{{ $project->project_name }}</td>
                    <td>{{ $project->customer->name }}</td>
                    <td>{{ $project->customer_type }}</td>
                    <td>{{ number_format((float) $project->solar_capacity, 2) }} kW</td>
                    <td><span class="badge text-bg-{{ $project->status === 'Completed' ? 'success' : ($project->status === 'Cancelled' ? 'secondary' : 'warning') }}">{{ $project->status }}</span></td>
                    <td>{{ $project->start_date?->format('d M Y') ?? '—' }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('projects.show', $project) }}" class="btn-action btn-action-view btn-action-icon" title="View project" aria-label="View project"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('projects.edit', $project) }}" class="btn-action btn-action-edit btn-action-icon" title="Edit project" aria-label="Edit project"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?')">@csrf @method('DELETE')<button class="btn-action btn-action-delete btn-action-icon" title="Delete project" aria-label="Delete project"><i class="bi bi-trash"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">No projects found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $projects->links() }}</div>
</div>
@endsection