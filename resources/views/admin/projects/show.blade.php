@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div><h1 class="h3 mb-1">{{ $project->project_name }}</h1><span class="text-muted">{{ $project->customer_type }} project</span></div>
    <div class="d-flex gap-2"><a href="{{ route('projects.index') }}" class="btn-secondary-action"><i class="bi bi-arrow-left"></i>Projects</a><a href="{{ route('projects.edit', $project) }}" class="btn-edit-primary"><i class="bi bi-pencil"></i>Edit</a></div>
</div>
<div class="card border-0 shadow-sm mb-4"><div class="card-body p-4">
    <div class="row g-4">
        <div class="col-6 col-lg-3"><div class="text-muted small">Customer</div><a href="{{ route('customers.show', $project->customer) }}" class="fw-semibold">{{ $project->customer->name }}</a></div>
        <div class="col-6 col-lg-3"><div class="text-muted small">Capacity</div><div class="fw-semibold">{{ number_format((float) $project->solar_capacity, 2) }} kW</div></div>
        <div class="col-6 col-lg-3"><div class="text-muted small">Status</div><span class="badge text-bg-warning">{{ $project->status }}</span></div>
        <div class="col-6 col-lg-3"><div class="text-muted small">Schedule</div><div>{{ $project->start_date?->format('d M Y') ?? 'Not started' }}{{ $project->completion_date ? ' – '.$project->completion_date->format('d M Y') : '' }}</div></div>
        <div class="col-12"><div class="text-muted small">Installation address</div><div>{{ $project->installation_address }}</div></div>
        @if($project->notes)<div class="col-12"><div class="text-muted small">Notes</div><div>{{ $project->notes }}</div></div>@endif
    </div>
</div></div>
<div class="row g-3">
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Quotations</div><div class="h4 mb-0">{{ $project->quotations->count() }}</div></div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Payments</div><div class="h4 mb-0">{{ $project->payments->count() }}</div></div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Service requests</div><div class="h4 mb-0">{{ $project->serviceRequests->count() }}</div></div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Invoices</div><div class="h4 mb-0">{{ $project->invoices->count() }}</div></div></div></div>
</div>
@endsection