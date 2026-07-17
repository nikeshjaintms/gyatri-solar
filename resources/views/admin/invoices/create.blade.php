@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-receipt"></i></span>
        New Invoice
    </h1>
    <a href="{{ route('invoices.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>


{{-- ── Form Card ── --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Invoice Information</h6>
    </div>

    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
        @csrf

        <div class="form-card-body">

            {{-- ── Section: Invoice & Customer ── --}}
            <div class="section-label"><i class="bi bi-file-earmark-text me-1"></i> Invoice & Customer Details</div>

            <div class="row g-4 mb-4">

                {{-- Service --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Service <span style="color:#9CA3AF;">(optional)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-wrench field-icon"></i>
                        <select name="service_id"
                                class="form-field form-field-select @error('service_id') is-invalid @enderror">
                            <option value="">— Select Service —</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->service_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('service_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Job Assignment --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Job Assignment <span style="color:#9CA3AF;">(optional)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-tools field-icon"></i>
                        <select name="job_assignment_id"
                                class="form-field form-field-select @error('job_assignment_id') is-invalid @enderror">
                            <option value="">— Select Job Assignment —</option>
                            @foreach($jobAssignments as $ja)
                                <option value="{{ $ja->id }}" {{ old('job_assignment_id') == $ja->id ? 'selected' : '' }}>
                                    #{{ $ja->id }} — {{ $ja->serviceRequest->customer->name ?? '' }} | {{ $ja->technician->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('job_assignment_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Invoice No (read-only) --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Invoice Number</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-hash field-icon"></i>
                        <input type="text" class="form-field"
                               value="{{ $invoiceNo }}" readonly
                               style="background:#F3F4F6; color:#6B7280; cursor:not-allowed;">
                    </div>
                    <div class="field-hint">Auto-generated invoice number</div>
                </div>

                {{-- Customer --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Customer <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <select name="customer_id"
                                class="form-field form-field-select @error('customer_id') is-invalid @enderror">
                            <option value="">— Select Customer —</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('customer_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Service Request --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Service Request <span style="color:#9CA3AF;">(optional)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-clipboard2-check field-icon"></i>
                        <select name="service_request_id"
                                class="form-field form-field-select @error('service_request_id') is-invalid @enderror">
                            <option value="">— Select Service Request —</option>
                            @foreach($serviceRequests as $sr)
                                <option value="{{ $sr->id }}" {{ old('service_request_id') == $sr->id ? 'selected' : '' }}>
                                    #{{ $sr->id }} — {{ $sr->customer->name ?? '' }} | {{ $sr->service->service_name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('service_request_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Invoice Date --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Invoice Date <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar3 field-icon"></i>
                        <input type="date" name="invoice_date"
                               class="form-field @error('invoice_date') is-invalid @enderror"
                               value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                    </div>
                    @error('invoice_date')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Due Date --}}
                <div class="col-12 col-md-6">
                    <label class="field-label">Due Date <span style="color:#9CA3AF;">(optional)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar-x field-icon"></i>
                        <input type="date" name="due_date"
                               class="form-field @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date') }}">
                    </div>
                    @error('due_date')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            {{-- ── Section: Amount Breakdown ── --}}
            <div class="section-label"><i class="bi bi-currency-rupee me-1"></i> Amount Breakdown</div>

            <div class="row g-4 mb-4">

                {{-- Subtotal --}}
                <div class="col-12 col-md-3">
                    <label class="field-label">Subtotal <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calculator field-icon"></i>
                        <input type="number" name="subtotal" id="subtotal" step="0.01" min="0"
                               class="form-field @error('subtotal') is-invalid @enderror"
                               value="{{ old('subtotal', '0.00') }}"
                               placeholder="0.00" oninput="recalculate()" required>
                    </div>
                    @error('subtotal')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Discount --}}
                <div class="col-12 col-md-3">
                    <label class="field-label">Discount</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-tag field-icon"></i>
                        <input type="number" name="discount" id="discount" step="0.01" min="0"
                               class="form-field @error('discount') is-invalid @enderror"
                               value="{{ old('discount', '0.00') }}"
                               placeholder="0.00" oninput="recalculate()">
                    </div>
                    @error('discount')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Tax --}}
                <div class="col-12 col-md-3">
                    <label class="field-label">Tax</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-percent field-icon"></i>
                        <input type="number" name="tax" id="tax" step="0.01" min="0"
                               class="form-field @error('tax') is-invalid @enderror"
                               value="{{ old('tax', '0.00') }}"
                               placeholder="0.00" oninput="recalculate()">
                    </div>
                    @error('tax')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Total Amount (computed) --}}
                <div class="col-12 col-md-3">
                    <label class="field-label">Total Amount</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-currency-rupee field-icon"></i>
                        <input type="text" id="totalDisplay" class="form-field"
                               value="₹ 0.00" readonly
                               style="background:#FFF7ED; color:#D96A0B; font-weight:700; cursor:not-allowed;">
                    </div>
                    <div class="field-hint">Subtotal − Discount + Tax</div>
                </div>

            </div>

            {{-- ── Section: Payment ── --}}
            <div class="section-label"><i class="bi bi-credit-card me-1"></i> Payment Details</div>

            <div class="row g-4 mb-4">

                {{-- Paid Amount --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Paid Amount</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-cash-coin field-icon"></i>
                        <input type="number" name="paid_amount" id="paidAmount" step="0.01" min="0"
                               class="form-field @error('paid_amount') is-invalid @enderror"
                               value="{{ old('paid_amount', '0.00') }}"
                               placeholder="0.00" oninput="recalculate()">
                    </div>
                    @error('paid_amount')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Balance (computed) --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Balance Amount</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-wallet2 field-icon"></i>
                        <input type="text" id="balanceDisplay" class="form-field"
                               value="₹ 0.00" readonly
                               style="background:#FEF2F2; color:#dc2626; font-weight:700; cursor:not-allowed;">
                    </div>
                    <div class="field-hint">Total − Paid Amount</div>
                </div>

                {{-- Payment Mode --}}
                <div class="col-12 col-md-4">
                    <label class="field-label">Payment Mode</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-credit-card field-icon"></i>
                        <select name="payment_mode"
                                class="form-field form-field-select @error('payment_mode') is-invalid @enderror">
                            <option value="">— Select Mode —</option>
                            <option value="Cash"          {{ old('payment_mode') == 'Cash'          ? 'selected' : '' }}>Cash</option>
                            <option value="UPI"           {{ old('payment_mode') == 'UPI'           ? 'selected' : '' }}>UPI</option>
                            <option value="Bank Transfer" {{ old('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="Cheque"        {{ old('payment_mode') == 'Cheque'        ? 'selected' : '' }}>Cheque</option>
                            <option value="Card"          {{ old('payment_mode') == 'Card'          ? 'selected' : '' }}>Card</option>
                        </select>
                    </div>
                    @error('payment_mode')<div class="field-error">{{ $message }}</div>@enderror
                </div>

            </div>

            {{-- ── Notes ── --}}
            <div class="row g-4">
                <div class="col-12">
                    <label class="field-label">Notes <span style="color:#9CA3AF;">(optional)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-chat-left-text field-icon field-icon-textarea"></i>
                        <textarea name="notes" rows="3"
                                  class="form-field form-field-textarea @error('notes') is-invalid @enderror"
                                  placeholder="Additional notes, remarks or payment instructions...">{{ old('notes') }}</textarea>
                    </div>
                    @error('notes')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>

        {{-- ── Form Footer ── --}}
        <div class="form-footer">
            <a href="{{ route('invoices.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Back
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Save Invoice
            </button>
        </div>

    </form>
</div>

{{-- ── Live Calculation Script ── --}}
<script>
function recalculate() {
    var subtotal  = parseFloat(document.getElementById('subtotal').value)   || 0;
    var discount  = parseFloat(document.getElementById('discount').value)   || 0;
    var tax       = parseFloat(document.getElementById('tax').value)        || 0;
    var paid      = parseFloat(document.getElementById('paidAmount').value) || 0;

    var total   = Math.max(0, subtotal - discount + tax);
    var balance = Math.max(0, total - paid);

    document.getElementById('totalDisplay').value   = '₹ ' + total.toFixed(2);
    document.getElementById('balanceDisplay').value = '₹ ' + balance.toFixed(2);
}
// Init on load
document.addEventListener('DOMContentLoaded', recalculate);
</script>

@endsection
