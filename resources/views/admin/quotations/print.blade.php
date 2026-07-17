<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quotation: {{ $quotation->quotation_number }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #FFFFFF;
            color: #111827;
            padding: 30px;
        }
        .invoice-box {
            max-width: 900px;
            margin: auto;
            border: 1px solid #E8ECF0;
            padding: 40px;
            border-radius: 8px;
        }
        .brand-header {
            border-bottom: 2px solid #F58220;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .brand-title {
            color: #050505;
            font-weight: 800;
            font-size: 1.8rem;
        }
        .brand-title span {
            color: #F58220;
        }
        .table-light-header th {
            background-color: #F9FAFB !important;
            color: #374151;
            font-weight: 600;
        }
        .total-box {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        .print-btn-bar {
            max-width: 900px;
            margin: 0 auto 20px auto;
        }
        @media print {
            .print-btn-bar {
                display: none !important;
            }
            body {
                padding: 0;
            }
            .invoice-box {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <div class="print-btn-bar d-flex justify-content-between align-items-center">
        <a href="{{ route('quotations.show', $quotation->id) }}" class="btn btn-sm btn-outline-secondary">
            &larr; Back to Details
        </a>
        <button onclick="window.print()" class="btn btn-sm btn-warning text-white" style="background-color: #F58220; border-color: #F58220;">
            Print / Save PDF
        </button>
    </div>

    <div class="invoice-box">
        <div class="brand-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="brand-title">GAYATRI <span>SOLAR ENERGY</span></h1>
                <p class="text-muted small mb-0">Solar panel solutions, service & maintenance installer</p>
            </div>
            <div class="text-end">
                <h2 class="h4 text-dark mb-1">QUOTATION</h2>
                <span class="badge bg-secondary" style="font-size: 0.85rem;">{{ $quotation->quotation_number }}</span>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-6">
                <p class="text-muted small mb-1 uppercase font-weight-bold">QUOTED TO:</p>
                <strong>{{ $quotation->customer?->name ?? '—' }}</strong>
                <div class="text-muted small mt-1">
                    Phone: {{ $quotation->customer?->phone ?? '—' }}<br>
                    Email: {{ $quotation->customer?->email ?? '—' }}<br>
                    Address: {{ $quotation->customer?->address ?? '—' }}
                </div>
            </div>
            <div class="col-6 text-end">
                <p class="text-muted small mb-1">QUOTATION DETAILS:</p>
                <div class="text-muted small">
                    Date: <strong>{{ $quotation->quotation_date?->format('d M Y') ?? '—' }}</strong><br>
                    Valid Until: <strong>{{ $quotation->valid_until?->format('d M Y') ?? '—' }}</strong><br>
                    Status: <strong>{{ $quotation->status }}</strong><br>
                    Enquiry Reference: <strong>{{ $quotation->enquiry?->enquiry_number ?? 'Direct' }}</strong>
                </div>
            </div>
        </div>

        <table class="table table-bordered align-middle">
            <thead class="table-light-header">
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th class="text-end" style="width: 70px;">Qty</th>
                    <th class="text-center" style="width: 70px;">Unit</th>
                    <th class="text-end" style="width: 110px;">Rate (₹)</th>
                    <th class="text-end" style="width: 100px;">Discount (%)</th>
                    <th class="text-end" style="width: 90px;">GST (%)</th>
                    <th class="text-end" style="width: 110px;">GST Amt (₹)</th>
                    <th class="text-end" style="width: 130px;">Total (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->items as $idx => $item)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>
                            @if($item->product)
                                {{ $item->product->product_code }} - {{ $item->product->name }}
                            @else
                                {{ $item->product_service }}
                            @endif
                        </td>
                        <td>{{ $item->description ?? '—' }}</td>
                        <td class="text-end">{{ $item->quantity }}</td>
                        <td class="text-center">{{ $item->unit ?? '—' }}</td>
                        <td class="text-end">₹{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-end">{{ number_format($item->discount_percentage, 2) }}%</td>
                        <td class="text-end">{{ number_format($item->tax_percentage, 2) }}%</td>
                        <td class="text-end">₹{{ number_format($item->tax_amount, 2) }}</td>
                        <td class="text-end fw-semibold">₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="clearfix">
            <div class="total-box">
                <div class="d-flex justify-content-between py-1 small border-bottom">
                    <span class="text-muted">Sub Total:</span>
                    <span class="fw-semibold">₹{{ number_format($quotation->subtotal, 2) }}</span>
                </div>
                @if($quotation->discount > 0)
                    <div class="d-flex justify-content-between py-1 small border-bottom">
                        <span class="text-muted">Total Discount:</span>
                        <span class="fw-semibold">₹{{ number_format($quotation->discount, 2) }}</span>
                    </div>
                @endif
                @if($quotation->tax_amount > 0)
                    <div class="d-flex justify-content-between py-1 small border-bottom">
                        <span class="text-muted">Total Tax (GST):</span>
                        <span class="fw-semibold">₹{{ number_format($quotation->tax_amount, 2) }}</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between py-2 fs-6 border-top border-2 mt-1">
                    <span class="fw-bold">Grand Total:</span>
                    <span class="fw-bold text-success">₹{{ number_format($quotation->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4 pt-4 border-top">
            <div class="col-12 col-md-6">
                <p class="text-muted small mb-1">TERMS &amp; CONDITIONS:</p>
                <div style="font-size: 0.8rem; color: #4B5563; white-space: pre-line;">{{ $quotation->terms_conditions }}</div>
            </div>
            <div class="col-12 col-md-6">
                <p class="text-muted small mb-1">NOTES / INSTRUCTIONS:</p>
                <div style="font-size: 0.8rem; color: #4B5563; white-space: pre-line;">{{ $quotation->notes ?? 'Thank you for choosing Gayatri Solar Energy.' }}</div>
            </div>
        </div>
    </div>

    <!-- Trigger print dialog on load -->
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
