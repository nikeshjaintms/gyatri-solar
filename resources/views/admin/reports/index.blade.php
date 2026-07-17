@extends('layouts.admin')

@section('content')

<style>
/* ── Report Cards ── */
.report-stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px 22px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #F0F1F3;
    transition: all 0.28s cubic-bezier(0.4,0,0.2,1);
    text-decoration: none;
    position: relative;
    overflow: hidden;
}
.report-stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #F58220, #FF9D4D);
    opacity: 0;
    transition: opacity 0.28s;
}
.report-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(245,130,32,0.15);
    border-color: rgba(245,130,32,0.3);
}
.report-stat-card:hover::before { opacity: 1; }

.stat-icon-wrap {
    width: 56px; height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}
.stat-icon-orange  { background: rgba(245,130,32,0.12); color: #F58220; }
.stat-icon-blue    { background: rgba(59,130,246,0.1);  color: #3B82F6; }
.stat-icon-green   { background: rgba(16,185,129,0.1);  color: #10B981; }
.stat-icon-red     { background: rgba(239,68,68,0.1);   color: #EF4444; }
.stat-icon-purple  { background: rgba(139,92,246,0.1);  color: #8B5CF6; }
.stat-icon-teal    { background: rgba(20,184,166,0.1);  color: #14B8A6; }
.stat-icon-indigo  { background: rgba(99,102,241,0.1);  color: #6366F1; }
.stat-icon-yellow  { background: rgba(234,179,8,0.1);   color: #CA8A04; }

.stat-value {
    font-size: 1.7rem;
    font-weight: 800;
    color: #1F2937;
    line-height: 1;
    margin-bottom: 4px;
}
.stat-label {
    font-size: 0.8rem;
    color: #6B7280;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.stat-sub {
    font-size: 0.72rem;
    color: #9CA3AF;
    margin-top: 2px;
}

/* ── Quick Link Cards ── */
.report-nav-card {
    background: #fff;
    border-radius: 16px;
    padding: 28px 24px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #F0F1F3;
    transition: all 0.28s cubic-bezier(0.4,0,0.2,1);
    position: relative;
    overflow: hidden;
}
.report-nav-card::after {
    content: '\F135';
    font-family: 'bootstrap-icons';
    position: absolute;
    bottom: 20px;
    right: 22px;
    font-size: 1.1rem;
    color: #D1D5DB;
    transition: all 0.25s;
}
.report-nav-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(245,130,32,0.15);
    border-color: rgba(245,130,32,0.3);
}
.report-nav-card:hover::after {
    color: #F58220;
    transform: translateX(3px);
}
.nav-card-icon {
    width: 52px; height: 52px;
    border-radius: 13px;
    background: linear-gradient(135deg, #F58220, #FF9D4D);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: #fff;
    box-shadow: 0 4px 14px rgba(245,130,32,0.35);
}
.nav-card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1F2937;
    margin: 0;
}
.nav-card-desc {
    font-size: 0.78rem;
    color: #6B7280;
    margin: 0;
}

.section-heading {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #9CA3AF;
    margin-bottom: 16px;
    padding-left: 4px;
}

@media print {
    body * { visibility: hidden; }
}
</style>

{{-- ── Page Hero Header ── --}}
<div class="page-hero">
    <div class="page-hero-left">
        <h1 class="page-hero-title">
            <i class="bi bi-bar-chart-line me-2"></i>Reports &amp; Dashboard Summary
        </h1>
        <p class="page-hero-sub">Overview of all key metrics across your operations</p>
    </div>
</div>

{{-- ── Section 1: People & Services ── --}}
<p class="section-heading">People &amp; Services</p>
<div class="row g-3 mb-4">
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-orange"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_customers']) }}</div>
                <div class="stat-label">Total Customers</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-blue"><i class="bi bi-person-badge-fill"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_technicians']) }}</div>
                <div class="stat-label">Total Technicians</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-purple"><i class="bi bi-wrench-adjustable-circle-fill"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_services']) }}</div>
                <div class="stat-label">Total Services</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Section 2: Service Requests ── --}}
<p class="section-heading">Service Requests</p>
<div class="row g-3 mb-4">
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-indigo"><i class="bi bi-clipboard2-data-fill"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_requests']) }}</div>
                <div class="stat-label">Total Requests</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-yellow"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['pending_requests']) }}</div>
                <div class="stat-label">Pending</div>
                <div class="stat-sub">Awaiting action</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-green"><i class="bi bi-clipboard2-check-fill"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['completed_requests']) }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Section 3: Job Assignments ── --}}
<p class="section-heading">Job Assignments</p>
<div class="row g-3 mb-4">
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-teal"><i class="bi bi-tools"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_jobs']) }}</div>
                <div class="stat-label">Total Assignments</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-green"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['completed_jobs']) }}</div>
                <div class="stat-label">Completed Jobs</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Section 4: Financial ── --}}
<p class="section-heading">Financial Summary</p>
<div class="row g-3 mb-5">
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-orange"><i class="bi bi-receipt-cutoff"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_invoices']) }}</div>
                <div class="stat-label">Total Invoices</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-blue"><i class="bi bi-currency-rupee"></i></div>
            <div>
                <div class="stat-value">₹{{ number_format($stats['total_revenue'], 0) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-green"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="stat-value">₹{{ number_format($stats['paid_amount'], 0) }}</div>
                <div class="stat-label">Paid Amount</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="report-stat-card">
            <div class="stat-icon-wrap stat-icon-red"><i class="bi bi-exclamation-circle-fill"></i></div>
            <div>
                <div class="stat-value">₹{{ number_format($stats['pending_amount'], 0) }}</div>
                <div class="stat-label">Pending Amount</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Quick Links ── --}}
<p class="section-heading">Detailed Reports</p>
<div class="row g-3">
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="{{ route('reports.service-requests') }}" class="report-nav-card">
            <div class="nav-card-icon"><i class="bi bi-clipboard2-pulse-fill"></i></div>
            <div>
                <p class="nav-card-title">Service Requests</p>
                <p class="nav-card-desc">Filter by date, status &amp; priority</p>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="{{ route('reports.job-assignments') }}" class="report-nav-card">
            <div class="nav-card-icon"><i class="bi bi-person-gear"></i></div>
            <div>
                <p class="nav-card-title">Job Assignments</p>
                <p class="nav-card-desc">Track technician job schedules</p>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="{{ route('reports.invoices') }}" class="report-nav-card">
            <div class="nav-card-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div>
                <p class="nav-card-title">Invoice Report</p>
                <p class="nav-card-desc">Invoice details with payment status</p>
            </div>
        </a>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="{{ route('reports.payments') }}" class="report-nav-card">
            <div class="nav-card-icon"><i class="bi bi-wallet2"></i></div>
            <div>
                <p class="nav-card-title">Payment Report</p>
                <p class="nav-card-desc">Paid, pending &amp; balance amounts</p>
            </div>
        </a>
    </div>
</div>

@endsection
