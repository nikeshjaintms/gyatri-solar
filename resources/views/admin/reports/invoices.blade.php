@extends('layouts.admin')

@section('content')

<style>
.report-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid #E8ECF0; overflow: hidden;
}
.report-card-header {
    padding: 18px 24px; border-bottom: 1.5px solid #E8ECF0;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 12px;
    background: #FFFFFF;
}
.report-card-title {
    font-size: 1rem; font-weight: 700; color: #111827;
    margin: 0; display: flex; align-items: center; gap: 10px;
}
.report-card-title i { color: #F58220; font-size: 1.1rem; }
.filter-section { padding: 20px 24px; background: #FFFFFF; border-bottom: 1px solid #E8ECF0; }
.filter-label { font-size: 0.78rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
.filter-control {
    border-radius: 9px; border: 1.5px solid #E5E7EB;
    padding: 8px 12px; font-size: 0.85rem; color: #374151;
    background: #fff; width: 100%; transition: border-color 0.2s;
}
.filter-control:focus { outline: none; border-color: #F58220; box-shadow: 0 0 0 3px rgba(245,130,32,0.1); }
.btn-filter {
    background: linear-gradient(135deg, #F58220, #FF9D4D);
    color: #fff; border: none; border-radius: 9px;
    padding: 9px 20px; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-filter:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(245,130,32,0.4); }
.btn-reset {
    background: #F9FAFB; color: #374151; border: 1.5px solid #E5E7EB;
    border-radius: 9px; padding: 9px 20px; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
}
.btn-reset:hover { border-color: #F58220; color: #F58220; background: #FFF7ED; }
.btn-print {
    background: #1F2937; color: #fff; border: none; border-radius: 9px;
    padding: 9px 20px; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-print:hover { background: #111827; transform: translateY(-1px); }
.report-table-wrap { overflow-x: auto; }
.report-table { width: 100%; border-collapse: collapse; }
.report-table thead th {
    background: #F8F9FA; padding: 12px 16px;
    font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.5px; color: #6B7280;
    border-bottom: 2px solid #F0F1F3; white-space: nowrap;
}
.report-table tbody td {
    padding: 13px 16px; font-size: 0.85rem; color: #374151;
    border-bottom: 1px solid #F5F6F8; vertical-align: middle;
}
.report-table tbody tr:hover { background: #FFFBF5; }
.report-table tbody tr:last-child td { border-bottom: none; }
.report-table tfoot td {
    padding: 14px 16px; font-size: 0.85rem;
    font-weight: 700; color: #1F2937;
    border-top: 2px solid #F0F1F3; background: #FAFAFA;
}
.badge-status {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px; border-radius: 20px;
    font-size: 0.73rem; font-weight: 600; white-space: nowrap;
}
.badge-paid    { background: rgba(16,185,129,0.12); color: #065f46; }
.badge-unpaid  { background: rgba(239,68,68,0.1);   color: #991b1b; }
.badge-partial { background: rgba(245,130,32,0.12); color: #c2640a; }
.amount-positive { color: #10B981; font-weight: 600; }
.amount-negative { color: #EF4444; font-weight: 600; }
.amount-neutral  { color: #374151; font-weight: 600; }
.empty-state { text-align: center; padding: 60px 20px; color: #9CA3AF; }
.empty-state i { font-size: 2.5rem; display: block; margin-bottom: 10px; color: #D1D5DB; }
.empty-state p { font-size: 0.88rem; margin: 0; }
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: #6B7280; font-size: 0.85rem; font-weight: 500;
    text-decoration: none; margin-bottom: 18px;
    padding: 7px 14px; background: #fff;
    border: 1.5px solid #E5E7EB; border-radius: 9px; transition: all 0.2s;
}
.back-link:hover { color: #F58220; border-color: #F58220; background: #FFF7ED; }

@media print {
    .sidebar-container, .topbar-container, .filter-section,
    .no-print, .back-link, .report-card-header .d-flex { display: none !important; }
    .report-card { box-shadow: none; border: none; }
    .content-body { padding: 0 !important; }
    body { background: #fff !important; }
    .print-title { display: block !important; }
}
.print-title { display: none; font-size: 1.2rem; font-weight: 700; color: #1F2937; margin-bottom: 6px; }
</style>
<div class="page-hero no-print">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-file-earmark-text me-2"></i>Invoice Report
        </h1>
        <p class="page-hero-sub">Generate and print invoice reports for Gayatri Solar Energy</p>
    </div>
    <a href="{{ route('reports.index') }}" class="btn-add-primary">
        <i class="bi bi-arrow-left"></i> Back to Reports
    </a>
</div>

<div class="print-title">
    Gayatri Solar Energy — Invoice Report<br>
    <small style="font-size:.8rem;font-weight:400;color:#6B7280;">Printed on {{ now()->format('d M Y, h:i A') }}</small>
</div>

<div class="report-card">
    <div class="report-card-header">
        <h5 class="report-card-title">
            <i class="bi bi-file-earmark-text-fill"></i>
            Invoice Report
        </h5>
        <div class="d-flex gap-2 no-print">
            <button class="btn-print" onclick="window.print()">
                <i class="bi bi-printer-fill"></i> Print
            </button>
        </div>
    </div>

    <div class="filter-section no-print">
        <form method="GET" action="{{ route('reports.invoices') }}">
            <div class="row g-3 align-items-end">
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="filter-label">From Date</div>
                    <input type="date" name="from_date" class="filter-control" value="{{ request('from_date') }}">
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="filter-label">To Date</div>
                    <input type="date" name="to_date" class="filter-control" value="{{ request('to_date') }}">
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="filter-label">Payment Status</div>
                    <select name="payment_status" class="filter-control">
                        <option value="">All Status</option>
                        @foreach($paymentStatuses as $s)
                            <option value="{{ $s }}" {{ request('payment_status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="filter-label">Payment Mode</div>
                    <select name="payment_mode" class="filter-control">
                        <option value="">All Modes</option>
                        @foreach($paymentModes as $m)
                            <option value="{{ $m }}" {{ request('payment_mode') == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-auto d-flex gap-2">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                    <a href="{{ route('reports.invoices') }}" class="btn-reset">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice No</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Invoice Date</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Balance</th>
                    <th>Payment Status</th>
                    <th>Payment Mode</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $row)
                <tr>
                    <td style="color:#9CA3AF;font-size:.78rem;">{{ $i + 1 }}</td>
                    <td>
                        <span style="font-weight:700;color:#F58220;font-size:.82rem;letter-spacing:.3px;">
                            {{ $row->invoice_no ?? '—' }}
                        </span>
                    </td>
                    <td style="font-weight:600;color:#1F2937;">{{ optional($row->customer)->name ?? '—' }}</td>
                    <td>{{ optional($row->service)->service_name ?? '—' }}</td>
                    <td>{{ $row->invoice_date ? $row->invoice_date->format('d M Y') : '—' }}</td>
                    <td class="amount-neutral">₹{{ number_format($row->total_amount ?? 0, 2) }}</td>
                    <td class="amount-positive">₹{{ number_format($row->paid_amount ?? 0, 2) }}</td>
                    <td class="{{ ($row->balance_amount ?? 0) > 0 ? 'amount-negative' : 'amount-positive' }}">
                        ₹{{ number_format($row->balance_amount ?? 0, 2) }}
                    </td>
                    <td>
                        @php
                            $psClass = match(strtolower($row->payment_status ?? '')) {
                                'paid'    => 'badge-paid',
                                'unpaid'  => 'badge-unpaid',
                                'partial' => 'badge-partial',
                                default   => 'badge-unpaid',
                            };
                        @endphp
                        <span class="badge-status {{ $psClass }}">{{ $row->payment_status ?? '—' }}</span>
                    </td>
                    <td>{{ $row->payment_mode ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="empty-state">
                            <i class="bi bi-receipt-cutoff"></i>
                            <p>No records found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($records->count())
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align:right;padding-right:20px;">Totals:</td>
                    <td>₹{{ number_format($records->sum('total_amount'), 2) }}</td>
                    <td>₹{{ number_format($records->sum('paid_amount'), 2) }}</td>
                    <td>₹{{ number_format($records->sum('balance_amount'), 2) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    @if($records->count())
    <div style="padding:14px 24px; border-top:1px solid #F0F1F3; font-size:.8rem; color:#6B7280;" class="no-print">
        Showing <strong>{{ $records->count() }}</strong> record(s)
    </div>
    @endif
</div>

@endsection
