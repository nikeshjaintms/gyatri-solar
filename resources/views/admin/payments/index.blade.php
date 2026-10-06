@extends('layouts.admin')

@section('content')
<div class="page-hero">
    <div class="page-hero-left"><h1 class="page-hero-title"><i class="bi bi-cash-stack me-2"></i>Payments</h1><p class="page-hero-sub">₹{{ number_format((float) $totalPaid, 2) }} recorded for the current filters.</p></div>
    <a href="{{ route('payments.create') }}" class="btn-add-primary"><i class="bi bi-plus-lg"></i>Record Payment</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Total Project Amount</div><div class="h4 mb-0">₹{{ number_format((float) $totalProjectAmount, 2) }}</div></div></div></div>
    <div class="col-12 col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Total Paid Amount</div><div class="h4 mb-0 text-success">₹{{ number_format((float) $totalProjectPaid, 2) }}</div></div></div></div>
    <div class="col-12 col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Pending Amount</div><div class="h4 mb-0 text-danger">₹{{ number_format((float) $pendingProjectAmount, 2) }}</div></div></div></div>
</div>
<div class="card border-0 shadow-sm mb-4"><div class="card-body">
    <form method="GET" action="{{ route('payments.index') }}" class="row g-2 align-items-center">
        <div class="col-12 col-md-4"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Search payment, customer, project"></div>
        <div class="col-6 col-md-2"><select name="payment_mode" class="form-select"><option value="">All modes</option>@foreach(['Cash', 'Mobile Banking', 'RTGS', 'NEFT', 'Other'] as $mode)<option value="{{ $mode }}" @selected(request('payment_mode') === $mode)>{{ $mode }}</option>@endforeach</select></div>
        <div class="col-6 col-md-2"><input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control" aria-label="From date"></div>
        <div class="col-6 col-md-2"><input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control" aria-label="To date"></div>
        <div class="col-auto"><button class="btn-filter"><i class="bi bi-funnel"></i>Filter</button></div>
        <div class="col-auto"><a href="{{ route('payments.index') }}" class="btn-reset" title="Clear filters" aria-label="Clear filters"><i class="bi bi-arrow-counterclockwise"></i></a></div>
    </form>
</div></div>
<div class="card border-0 shadow-sm"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th>Payment</th><th>Customer</th><th>Project</th><th>Date</th><th>Mode</th><th class="text-end">Amount</th><th class="text-end">Actions</th></tr></thead><tbody>
    @forelse($payments as $payment)
        <tr><td class="fw-semibold">{{ $payment->payment_number }}</td><td>{{ $payment->customer->name }}</td><td>{{ $payment->project->project_name ?? '—' }}</td><td>{{ $payment->payment_date->format('d M Y') }}</td><td>{{ $payment->payment_mode }}</td><td class="text-end">₹{{ number_format((float) $payment->amount, 2) }}</td><td class="text-end text-nowrap"><a href="{{ route('payments.show', $payment) }}" class="btn-action btn-action-view btn-action-icon" title="View payment" aria-label="View payment"><i class="bi bi-eye"></i></a> <a href="{{ route('payments.edit', $payment) }}" class="btn-action btn-action-edit btn-action-icon" title="Edit payment" aria-label="Edit payment"><i class="bi bi-pencil"></i></a> <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this payment?')">@csrf @method('DELETE')<button class="btn-action btn-action-delete btn-action-icon" title="Delete payment" aria-label="Delete payment"><i class="bi bi-trash"></i></button></form></td></tr>
    @empty<tr><td colspan="7" class="text-center text-muted py-5">No payments found.</td></tr>@endforelse
    </tbody></table>
</div><div class="card-footer bg-white">{{ $payments->links() }}</div></div>
@endsection