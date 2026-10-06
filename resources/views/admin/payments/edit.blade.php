@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4"><h1 class="h3 mb-0">Edit Payment</h1><a href="{{ route('payments.show', $payment) }}" class="btn-secondary-action"><i class="bi bi-arrow-left"></i>Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4"><form action="{{ route('payments.update', $payment) }}" method="POST">@csrf @method('PUT') @include('admin.payments._form')<div class="d-flex justify-content-end gap-2 mt-4"><a href="{{ route('payments.show', $payment) }}" class="btn-secondary-action">Cancel</a><button class="btn-add-primary"><i class="bi bi-check-lg"></i>Update Payment</button></div></form></div></div>
@endsection