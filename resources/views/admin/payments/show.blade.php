@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4"><div><h1 class="h3 mb-1">{{ $payment->payment_number }}</h1><span class="text-muted">Payment details</span></div><div class="d-flex gap-2"><a href="{{ route('payments.index') }}" class="btn-secondary-action"><i class="bi bi-arrow-left"></i>Payments</a><a href="{{ route('payments.edit', $payment) }}" class="btn-edit-primary"><i class="bi bi-pencil"></i>Edit</a></div></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4"><div class="row g-4">
    <div class="col-6 col-lg-3"><div class="text-muted small">Customer</div><a href="{{ route('customers.show', $payment->customer) }}" class="fw-semibold">{{ $payment->customer->name }}</a></div>
    <div class="col-6 col-lg-3"><div class="text-muted small">Project</div><div>{{ $payment->project->project_name ?? '—' }}</div></div>
    <div class="col-6 col-lg-3"><div class="text-muted small">Date</div><div>{{ $payment->payment_date->format('d M Y') }}</div></div>
    <div class="col-6 col-lg-3"><div class="text-muted small">Amount</div><div class="fw-semibold">₹{{ number_format((float) $payment->amount, 2) }}</div></div>
    <div class="col-6 col-lg-3"><div class="text-muted small">Mode</div><div>{{ $payment->payment_mode }}</div></div>
    <div class="col-6 col-lg-3"><div class="text-muted small">Reference number</div><div>{{ $payment->reference_number ?? '—' }}</div></div>
    @if($payment->notes)<div class="col-12"><div class="text-muted small">Notes</div><div>{{ $payment->notes }}</div></div>@endif
</div></div></div>
@endsection