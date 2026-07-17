@extends('layouts.admin')

@section('content')

<style>
/* ── Shared report styles ── */
.report-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid #E8ECF0;
    overflow: hidden;
}
.report-card-header {
    padding: 18px 24px;
    border-bottom: 1.5px solid #E8ECF0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    background: #FFFFFF;
}
.report-card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.report-card-title i {
    color: #F58220;
    font-size: 1.1rem;
}
.filter-section { padding: 20px 24px; background: #FFFFFF; border-bottom: 1px solid #E8ECF0; }
.filter-label { font-size: 0.78rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
.filter-control {
    border-radius: 9px;
    border: 1.5px solid #E5E7EB;
    padding: 8px 12px;
    font-size: 0.85rem;
    color: #374151;
    background: #fff;
    width: 100%;
    transition: border-color 0.2s;
}
.filter-control:focus { outline: none; border-color: #F58220; box-shadow: 0 0 0 3px rgba(245,130,32,0.1); }
.btn-filter {
    background: linear-gradient(135deg, #F58220, #FF9D4D);
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 9px 20px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-filter:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(245,130,32,0.4); }
.btn-reset {
    background: #F9FAFB;
    color: #374151;
    border: 1.5px solid #E5E7EB;
    border-radius: 9px;
    padding: 9px 20px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-reset:hover { border-color: #F58220; color: #F58220; background: #FFF7ED; }
.btn-print {
    background: #1F2937;
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 9px 20px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-print:hover { background: #111827; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }

/* ── Table ── */
.report-table-wrap { overflow-x: auto; }
.report-table { width: 100%; border-collapse: collapse; }
.report-table thead th {
    background: #F8F9FA;
    padding: 12px 16px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6B7280;
    border-bottom: 2px solid #F0F1F3;
    white-space: nowrap;
}
.report-table tbody td {
    padding: 13px 16px;
    font-size: 0.85rem;
    color: #374151;
    border-bottom: 1px solid #F5F6F8;
    vertical-align: middle;
}
.report-table tbody tr:hover { background: #FFFBF5; }
.report-table tbody tr:last-child td { border-bottom: none; }

/* ── Badges ── */
.badge-status {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 0.73rem;
    font-weight: 600;
    white-space: nowrap;
}
.badge-pending    { background: rgba(245,130,32,0.12); color: #c2640a; }
.badge-assigned   { background: rgba(59,130,246,0.12);  color: #1d4ed8; }
.badge-inprogress { background: rgba(245,130,32,0.2);   color: #b45309; }
.badge-completed  { background: rgba(16,185,129,0.12);  color: #065f46; }
.badge-cancelled  { background: rgba(239,68,68,0.1);    color: #991b1b; }

.badge-priority-low    { background: rgba(156,163,175,0.15); color: #4B5563; }
.badge-priority-medium { background: rgba(234,179,8,0.15);   color: #92400e; }
.badge-priority-high   { background: rgba(245,130,32,0.15);  color: #c2640a; }
.badge-priority-urgent { background: rgba(239,68,68,0.15);   color: #991b1b; }

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #9CA3AF;
}
.empty-state i { font-size: 2.5rem; display: block; margin-bottom: 10px; color: #D1D5DB; }
.empty-state p { font-size: 0.88rem; margin: 0; }

.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: #6B7280;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 18px;
    padding: 7px 14px;
    background: #fff;
    border: 1.5px solid #E5E7EB;
    border-radius: 9px;
    transition: all 0.2s;
}
.back-link:hover { color: #F58220; border-color: #F58220; background: #FFF7ED; }

/* ── Print ── */
@media print {
    .sidebar-container, .topbar-container, .filter-section,
    .no-print, .back-link, .report-card-header .d-flex { display: none !important; }
    .report-card { box-shadow: none; border: none; }
    .content-body { padding: 0 !important; }
    .report-table thead th { background: #eee !important; -webkit-print-color-adjust: exact; }
    body { background: #fff !important; }
    .print-title { display: block !important; }
}
.print-title {
    display: none;
    font-size: 1.2rem;
    font-weight: 700;
    color: #1F2937;
    margin-bottom: 6px;
}
</style>
<div class="page-hero no-print">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-clipboard2-pulse me-2"></i>Service Requests Report
        </h1>
        <p class="page-hero-sub">Generate and print service requests reports for Gayatri Solar Energy</p>
    </div>
    <a href="{{ route('reports.index') }}" class="btn-add-primary">
        <i class="bi bi-arrow-left"></i> Back to Reports
    </a>
</div>

<div class="print-title">
    Gayatri Solar Energy — Service Requests Report<br>
    <small style="font-size:.8rem;font-weight:400;color:#6B7280;">Printed on {{ now()->format('d M Y, h:i A') }}</small>
</div>

<div class="report-card">
    {{-- Header --}}
    <div class="report-card-header">
        <h5 class="report-card-title">
            <i class="bi bi-clipboard2-pulse-fill"></i>
            Service Requests Report
        </h5>
        <div class="d-flex gap-2 no-print">
            <button class="btn-print" onclick="window.print()">
                <i class="bi bi-printer-fill"></i> Print
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="filter-section no-print">
        <form method="GET" action="{{ route('reports.service-requests') }}">
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
                    <div class="filter-label">Status</div>
                    <select name="status" class="filter-control">
                        <option value="">All Status</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="filter-label">Priority</div>
                    <select name="priority" class="filter-control">
                        <option value="">All Priority</option>
                        @foreach($priorities as $p)
                            <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-auto d-flex gap-2">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                    <a href="{{ route('reports.service-requests') }}" class="btn-reset">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Technician</th>
                    <th>Request Date</th>
                    <th>Service Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $row)
                <tr>
                    <td style="color:#9CA3AF;font-size:.78rem;">{{ $i + 1 }}</td>
                    <td>
                        <span style="font-weight:600;color:#1F2937;">
                            {{ $row->customer->name ?? '—' }}
                        </span>
                    </td>
                    <td>{{ $row->service->service_name ?? '—' }}</td>
                    <td>{!! $row->technician->name ?? '<span style="color:#9CA3AF;font-style:italic;">Unassigned</span>' !!}</td>
                    <td>{{ $row->request_date ? $row->request_date->format('d M Y') : '—' }}</td>
                    <td>{{ $row->service_date ? $row->service_date->format('d M Y') : '—' }}</td>
                    <td>
                        @php
                            $pClass = match(strtolower($row->priority ?? '')) {
                                'low'    => 'badge-priority-low',
                                'medium' => 'badge-priority-medium',
                                'high'   => 'badge-priority-high',
                                'urgent' => 'badge-priority-urgent',
                                default  => 'badge-priority-low',
                            };
                        @endphp
                        <span class="badge-status {{ $pClass }}">{{ $row->priority ?? '—' }}</span>
                    </td>
                    <td>
                        @php
                            $sClass = match(strtolower($row->status ?? '')) {
                                'pending'     => 'badge-pending',
                                'assigned'    => 'badge-assigned',
                                'in progress' => 'badge-inprogress',
                                'completed'   => 'badge-completed',
                                'cancelled'   => 'badge-cancelled',
                                default       => 'badge-pending',
                            };
                        @endphp
                        <span class="badge-status {{ $sClass }}">{{ $row->status ?? '—' }}</span>
                    </td>
                    <td style="max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $row->address }}">
                        {{ $row->address ?? '—' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="bi bi-clipboard2-x"></i>
                            <p>No records found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer count --}}
    @if($records->count())
    <div style="padding:14px 24px; border-top:1px solid #F0F1F3; font-size:.8rem; color:#6B7280;" class="no-print">
        Showing <strong>{{ $records->count() }}</strong> record(s)
    </div>
    @endif
</div>

@endsection
