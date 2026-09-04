@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-pencil-square"></i></span>
        Edit Quotation #{{ $quotation->quotation_number }}
    </h1>
    <a href="{{ route('quotations.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Form Card ── --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Quotation Header Details</h6>
    </div>

    <form action="{{ route('quotations.update', $quotation->id) }}" method="POST" id="quotation_form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-card-body">

            <p class="section-label">References &amp; Date</p>
            <div class="row g-4 mb-3">

                <!-- Quotation Number -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Quotation Number <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-upc field-icon"></i>
                        <input type="text" name="quotation_number" class="form-field" style="background-color: #F3F4F6;" 
                               value="{{ old('quotation_number', $quotation->quotation_number) }}" readonly required>
                    </div>
                </div>

                <!-- Enquiry Dropdown -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Select Enquiry <span class="text-muted">(Auto-populates customer)</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-chat-left-quote field-icon"></i>
                        <select name="enquiry_id" id="enquiry_select" class="form-field form-field-select">
                            <option value="">-- Select Enquiry --</option>
                            @foreach($enquiries as $enq)
                                <option value="{{ $enq->id }}" {{ old('enquiry_id', $quotation->enquiry_id) == $enq->id ? 'selected' : '' }}>
                                    {{ $enq->enquiry_number }} - {{ $enq->customer_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Customer Dropdown -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Customer <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-person field-icon"></i>
                        <select name="customer_id" id="customer_select" class="form-field form-field-select" required>
                            <option value="">-- Select Customer --</option>
                            @foreach($customers as $cust)
                                <option value="{{ $cust->id }}" {{ old('customer_id', $quotation->customer_id) == $cust->id ? 'selected' : '' }}>
                                    {{ $cust->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Quotation Date -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Quotation Date <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar-event field-icon"></i>
                        <input type="date" name="quotation_date" class="form-field @error('quotation_date') is-invalid @enderror"
                               value="{{ old('quotation_date', $quotation->quotation_date?->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Valid Until -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Valid Until <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-calendar-x field-icon"></i>
                        <input type="date" name="valid_until" class="form-field @error('valid_until') is-invalid @enderror"
                               value="{{ old('valid_until', $quotation->valid_until?->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-12 col-md-4">
                    <label class="field-label">Status <span class="req">*</span></label>
                    <div class="field-input-wrap">
                        <i class="bi bi-info-circle field-icon"></i>
                        <select name="status" class="form-field form-field-select" required>
                            <option value="Draft" {{ old('status', $quotation->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Sent" {{ old('status', $quotation->status) == 'Sent' ? 'selected' : '' }}>Sent</option>
                            <option value="Accepted" {{ old('status', $quotation->status) == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="Rejected" {{ old('status', $quotation->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="Expired" {{ old('status', $quotation->status) == 'Expired' ? 'selected' : '' }}>Expired</option>
                            <option value="Cancelled" {{ old('status', $quotation->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>

            </div>

            <p class="section-label mt-3">Quotation Items</p>
            <div class="table-responsive mb-3">
                <table class="table table-bordered bg-white align-middle quotation-items-table" id="items_table" style="min-width: 1050px;">
                    <thead class="table-light">
                        <tr>
                            <th style="min-width: 240px;">Product <span class="req">*</span></th>
                            <th style="min-width: 160px;">Description</th>
                            <th style="width: 85px; min-width: 85px;">Qty <span class="req">*</span></th>
                            <th style="width: 95px; min-width: 95px;">Unit</th>
                            <th style="width: 120px; min-width: 120px;">Rate <span class="req">*</span></th>
                            <th style="width: 105px; min-width: 105px;">Discount %</th>
                            <th style="width: 100px; min-width: 100px;">GST %</th>
                            <th style="width: 115px; min-width: 115px;">GST Amt</th>
                            <th style="width: 130px; min-width: 130px;">Line Total</th>
                            <th style="width: 55px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="items_container">
                        @foreach($quotation->items as $idx => $item)
                        <tr class="item-row">
                            <td>
                                <select name="items[{{ $idx }}][product_id]" class="form-select item-product-select" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $prod)
                                        <option value="{{ $prod->id }}"
                                                data-code="{{ $prod->product_code }}"
                                                data-name="{{ $prod->name }}"
                                                data-category="{{ $prod->category }}"
                                                data-unit="{{ $prod->unit }}"
                                                data-hsn="{{ $prod->hsn_sac_code }}"
                                                data-gst="{{ $prod->gst }}"
                                                data-price="{{ $prod->selling_price }}"
                                                data-desc="{{ $prod->description }}"
                                                {{ $item->product_id == $prod->id ? 'selected' : '' }}>
                                            {{ $prod->product_code }} - {{ $prod->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="items[{{ $idx }}][description]" class="form-control item-desc" placeholder="Description details" value="{{ $item->description }}">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $idx }}][quantity]" class="form-control item-qty text-end" min="1" value="{{ $item->quantity }}" required>
                            </td>
                            <td>
                                <input type="text" name="items[{{ $idx }}][unit]" class="form-control item-unit text-center" placeholder="Unit" value="{{ $item->unit }}">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $idx }}][unit_price]" class="form-control item-price text-end" min="0" step="0.01" value="{{ $item->unit_price }}" required>
                            </td>
                            <td>
                                <input type="number" name="items[{{ $idx }}][discount_percentage]" class="form-control item-discount text-end" min="0" max="100" step="0.01" value="{{ $item->discount_percentage ?? '0.00' }}">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $idx }}][tax_percentage]" class="form-control item-tax-percent text-end" min="0" max="100" step="0.01" value="{{ $item->tax_percentage ?? '0.00' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control item-tax-amount text-end" readonly style="background-color: #F9FAFB;" value="{{ number_format($item->tax_amount, 2) }}">
                            </td>
                            <td>
                                <input type="text" class="form-control item-total text-end" readonly style="background-color: #F9FAFB;" value="{{ number_format($item->subtotal, 2) }}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-sm btn-dark mb-4" id="add_item_btn">
                <i class="bi bi-plus-lg"></i> Add More Product
            </button>

            <p class="section-label">Summary Calculations</p>
            <div class="row g-4 mb-2 justify-content-end">
                <div class="col-12 col-md-5">
                    <div class="card p-3 bg-light border-0">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Sub Total (₹):</span>
                            <span class="fw-semibold" id="lbl_subtotal">{{ number_format($quotation->subtotal, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Discount (₹):</span>
                            <span class="fw-semibold text-danger" id="lbl_total_discount">{{ number_format($quotation->discount, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Tax (GST) (₹):</span>
                            <span class="fw-semibold" id="lbl_total_tax">{{ number_format($quotation->tax_amount, 2) }}</span>
                        </div>
                        
                        <hr class="my-2">

                        <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                            <span>Grand Total (₹):</span>
                            <span id="lbl_grand_total">{{ number_format($quotation->grand_total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <p class="section-label mt-2">Terms, Conditions &amp; Notes</p>
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="field-label">Terms and Conditions</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-file-earmark-text field-icon field-icon-textarea"></i>
                        <textarea name="terms_conditions" rows="3" class="form-field form-field-textarea" placeholder="Enter quotation validity, delivery, warranty terms...">{{ old('terms_conditions', $quotation->terms_conditions) }}</textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="field-label">Internal / Public Notes</label>
                    <div class="field-input-wrap">
                        <i class="bi bi-chat-text field-icon field-icon-textarea"></i>
                        <textarea name="notes" rows="3" class="form-field form-field-textarea" placeholder="Add payment plans, solar specs or internal notes...">{{ old('notes', $quotation->notes) }}</textarea>
                    </div>
                </div>
            </div>

            @include('admin.quotations.proposal_fields')
        </div>

        <div class="form-footer">
            <a href="{{ route('quotations.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Update Quotation
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const enquirySelect = document.getElementById('enquiry_select');
    const customerSelect = document.getElementById('customer_select');
    const itemsContainer = document.getElementById('items_container');
    const addItemBtn = document.getElementById('add_item_btn');

    let rowIdx = {{ count($quotation->items) }};

    // AJAX Fetch Customer on Selecting Enquiry
    enquirySelect.addEventListener('change', function() {
        if (!enquirySelect.value) return;

        fetch(`/admin/enquiries/${enquirySelect.value}/details`)
            .then(res => res.json())
            .then(data => {
                if (data.customer_id) {
                    customerSelect.value = data.customer_id;
                }
            })
            .catch(err => console.error('Error fetching details:', err));
    });

    // Add Item Line
    addItemBtn.addEventListener('click', function() {
        const row = document.createElement('tr');
        row.className = 'item-row';
        row.innerHTML = `
            <td>
                <select name="items[${rowIdx}][product_id]" class="form-select item-product-select" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}"
                                data-code="{{ $prod->product_code }}"
                                data-name="{{ $prod->name }}"
                                data-category="{{ $prod->category }}"
                                data-unit="{{ $prod->unit }}"
                                data-hsn="{{ $prod->hsn_sac_code }}"
                                data-gst="{{ $prod->gst }}"
                                data-price="{{ $prod->selling_price }}"
                                data-desc="{{ $prod->description }}">
                            {{ $prod->product_code }} - {{ $prod->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="items[${rowIdx}][description]" class="form-control item-desc" placeholder="Description details">
            </td>
            <td>
                <input type="number" name="items[${rowIdx}][quantity]" class="form-control item-qty text-end" min="1" value="1" required>
            </td>
            <td>
                <input type="text" name="items[${rowIdx}][unit]" class="form-control item-unit text-center" placeholder="Unit">
            </td>
            <td>
                <input type="number" name="items[${rowIdx}][unit_price]" class="form-control item-price text-end" min="0" step="0.01" required>
            </td>
            <td>
                <input type="number" name="items[${rowIdx}][discount_percentage]" class="form-control item-discount text-end" min="0" max="100" step="0.01" value="0.00">
            </td>
            <td>
                <input type="number" name="items[${rowIdx}][tax_percentage]" class="form-control item-tax-percent text-end" min="0" max="100" step="0.01" value="0.00">
            </td>
            <td>
                <input type="text" class="form-control item-tax-amount text-end" readonly style="background-color: #F9FAFB;" value="0.00">
            </td>
            <td>
                <input type="text" class="form-control item-total text-end" readonly style="background-color: #F9FAFB;" value="0.00">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn"><i class="bi bi-trash"></i></button>
            </td>
        `;
        itemsContainer.appendChild(row);
        rowIdx++;
        bindRowEvents(row);
        calculateTotalMath();
    });

    // Bind row events
    function bindRowEvents(row) {
        const productSelect = row.querySelector('.item-product-select');
        const qtyInput = row.querySelector('.item-qty');
        const priceInput = row.querySelector('.item-price');
        const discountInput = row.querySelector('.item-discount');
        const taxInput = row.querySelector('.item-tax-percent');
        const removeBtn = row.querySelector('.remove-item-btn');

        productSelect.addEventListener('change', function() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                const unit = selectedOption.getAttribute('data-unit') || '';
                const gst = parseFloat(selectedOption.getAttribute('data-gst')) || 0;
                const desc = selectedOption.getAttribute('data-desc') || '';

                priceInput.value = price.toFixed(2);
                row.querySelector('.item-unit').value = unit;
                taxInput.value = gst.toFixed(2);
                row.querySelector('.item-desc').value = desc;
            } else {
                priceInput.value = '';
                row.querySelector('.item-unit').value = '';
                taxInput.value = '0.00';
                row.querySelector('.item-desc').value = '';
            }
            calculateRowTotal();
        });

        qtyInput.addEventListener('input', calculateRowTotal);
        priceInput.addEventListener('input', calculateRowTotal);
        discountInput.addEventListener('input', calculateRowTotal);
        if (taxInput) {
            taxInput.addEventListener('input', calculateRowTotal);
        }
        
        removeBtn.addEventListener('click', function() {
            row.remove();
            calculateTotalMath();
        });

        function calculateRowTotal() {
            const qty = parseFloat(qtyInput.value) || 0;
            const rate = parseFloat(priceInput.value) || 0;
            const discountPct = parseFloat(discountInput.value) || 0;
            const taxPct = parseFloat(row.querySelector('.item-tax-percent').value) || 0;

            const amount = qty * rate;
            const discountAmt = amount * (discountPct / 100);
            const taxable = Math.max(0, amount - discountAmt);
            const taxAmt = taxable * (taxPct / 100);
            const lineTotal = taxable + taxAmt;

            row.querySelector('.item-tax-amount').value = taxAmt.toFixed(2);
            row.querySelector('.item-total').value = lineTotal.toFixed(2);
            calculateTotalMath();
        }
    }

    // Calculate Total Math
    function calculateTotalMath() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalTax = 0;

        const rows = document.querySelectorAll('.item-row');
        
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            const rate = parseFloat(row.querySelector('.item-price').value) || 0;
            const discountPct = parseFloat(row.querySelector('.item-discount').value) || 0;
            const taxPct = parseFloat(row.querySelector('.item-tax-percent').value) || 0;

            const amount = qty * rate;
            const discountAmt = amount * (discountPct / 100);
            const taxable = Math.max(0, amount - discountAmt);
            const taxAmt = taxable * (taxPct / 100);
            const lineTotal = taxable + taxAmt;

            subtotal += amount;
            totalDiscount += discountAmt;
            totalTax += taxAmt;
        });

        const grandTotal = subtotal - totalDiscount + totalTax;

        document.getElementById('lbl_subtotal').innerText = subtotal.toFixed(2);
        document.getElementById('lbl_total_discount').innerText = totalDiscount.toFixed(2);
        document.getElementById('lbl_total_tax').innerText = totalTax.toFixed(2);
        document.getElementById('lbl_grand_total').innerText = grandTotal.toFixed(2);

        // Auto-update proposal pricing details
        const rooftopInput = document.querySelector('input[name="rooftop_amount"]');
        if (rooftopInput) {
            rooftopInput.value = grandTotal.toFixed(2);
        }

        const projectCostInput = document.querySelector('input[name="savings_project_cost"]');
        if (projectCostInput) {
            projectCostInput.value = 'Rs. ' + Math.round(grandTotal).toLocaleString('en-IN');
        }

        updateProposalCalculations(grandTotal);
    }

    function updateProposalCalculations(grandTotalVal) {
        const grandTotal = typeof grandTotalVal === 'number' ? grandTotalVal : (parseFloat(document.getElementById('lbl_grand_total').innerText) || 0);
        
        // Per kW Rate calculation
        const systemSizeInput = document.querySelector('input[name="system_size"]');
        const perKwInput = document.querySelector('input[name="per_kw_rate"]');
        if (systemSizeInput && perKwInput) {
            const sizeNum = parseFloat(systemSizeInput.value) || 0;
            if (sizeNum > 0) {
                const perKw = Math.round(grandTotal / sizeNum);
                perKwInput.value = perKw.toLocaleString('en-IN');
            }
        }

        // Final effective cost calculation
        const subsidyInput = document.querySelector('input[name="mnre_subsidy"]');
        const finalCostInput = document.querySelector('input[name="final_effective_cost"]');
        if (subsidyInput && finalCostInput) {
            const subsidyVal = parseFloat(subsidyInput.value.replace(/,/g, '')) || 0;
            const finalCost = Math.round(grandTotal - subsidyVal);
            finalCostInput.value = finalCost.toLocaleString('en-IN');
        }
    }

    // Attach listener to system size and subsidy inputs to recalculate dynamically
    setTimeout(() => {
        const systemSizeInput = document.querySelector('input[name="system_size"]');
        if (systemSizeInput) {
            systemSizeInput.addEventListener('input', () => updateProposalCalculations());
        }
        const subsidyInput = document.querySelector('input[name="mnre_subsidy"]');
        if (subsidyInput) {
            subsidyInput.addEventListener('input', () => updateProposalCalculations());
        }
    }, 500);

    // Init existing rows
    document.querySelectorAll('.item-row').forEach(row => bindRowEvents(row));
    calculateTotalMath();
});
</script>

@endsection
