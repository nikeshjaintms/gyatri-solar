@extends('layouts.admin')

@section('content')

<style>
/* ═══════════════════════════════════════════════════════════════
   GAYATRI SOLAR ENERGY — PREMIUM WHITE DASHBOARD
   White/light bg · Orange accents · Dark text · Full responsive
   Sidebar stays dark — only main content area is light
═══════════════════════════════════════════════════════════════ */

/* ── CSS Custom Properties ── */
:root {
    --d-orange:        #F58220;
    --d-orange-dark:   #D96A0B;
    --d-orange-light:  #FF9D4D;
    --d-orange-soft:   rgba(245,130,32,0.09);
    --d-orange-border: rgba(245,130,32,0.28);
    --d-orange-shadow: rgba(245,130,32,0.18);

    /* Light theme surfaces */
    --d-bg:            #F4F6F9;
    --d-card:          #FFFFFF;
    --d-card-hover:    #FDFEFF;
    --d-card-border:   #E8ECF0;
    --d-card-border-h: rgba(245,130,32,0.4);

    /* Typography */
    --d-text:          #111827;
    --d-text-muted:    #6B7280;
    --d-text-dim:      #9CA3AF;

    /* Semantic colors */
    --d-green:         #059669;
    --d-green-bg:      #ECFDF5;
    --d-green-border:  #A7F3D0;
    --d-blue:          #2563EB;
    --d-blue-bg:       #EFF6FF;
    --d-blue-border:   #BFDBFE;
    --d-red:           #DC2626;
    --d-red-bg:        #FEF2F2;
    --d-red-border:    #FECACA;
    --d-yellow:        #D97706;
    --d-yellow-bg:     #FFFBEB;
    --d-yellow-border: #FDE68A;
    --d-purple:        #7C3AED;
    --d-purple-bg:     #F5F3FF;
    --d-purple-border: #DDD6FE;
    --d-teal:          #0D9488;
    --d-teal-bg:       #F0FDFA;
    --d-indigo:        #4338CA;
    --d-indigo-bg:     #EEF2FF;

    --d-radius:        14px;
    --d-radius-sm:     10px;
    --d-shadow-sm:     0 1px 4px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
    --d-shadow-md:     0 4px 16px rgba(0,0,0,0.08), 0 8px 32px rgba(0,0,0,0.06);
    --d-shadow-orange: 0 4px 20px rgba(245,130,32,0.22);
}

/* ── Dashboard outer wrapper — light background ── */
.dash-wrap {
    background: transparent;
    padding: 0;
    min-height: auto;
    border-radius: 0;
}

/* ── Section labels ── */
.d-section-label {
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.4px;
    color: var(--d-orange);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.d-section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, var(--d-orange-border), transparent);
}

/* ══════════════════════════════════════════════════════
   HERO BANNER — keep dark for brand identity
══════════════════════════════════════════════════════ */
.d-hero {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #0F0F0F 0%, #1A1005 55%, #0B0B0B 100%);
    border: 1px solid var(--d-orange-border);
    border-radius: var(--d-radius);
    padding: 30px 34px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: var(--d-shadow-orange);
}
.d-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(245,130,32,0.15) 0%, transparent 68%);
    pointer-events: none;
}
.d-hero::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, var(--d-orange) 0%, var(--d-orange-light) 50%, transparent 100%);
}
.d-hero-left h1 {
    font-size: 1.4rem;
    font-weight: 800;
    color: #FFFFFF;
    margin: 0 0 6px;
    letter-spacing: -0.4px;
}
.d-hero-left h1 span { color: var(--d-orange); }
.d-hero-left p {
    font-size: 0.88rem;
    color: #9CA3AF;
    margin: 0;
}
.d-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245,130,32,0.12);
    border: 1px solid var(--d-orange-border);
    color: var(--d-orange);
    font-size: 0.8rem;
    font-weight: 700;
    padding: 10px 20px;
    border-radius: 40px;
    white-space: nowrap;
}
.pulse-dot {
    width: 8px; height: 8px;
    background: var(--d-orange);
    border-radius: 50%;
    animation: pulse-anim 1.8s ease-in-out infinite;
}
@keyframes pulse-anim {
    0%,100% { opacity:1; transform:scale(1); box-shadow:0 0 0 0 rgba(245,130,32,.6); }
    50%      { opacity:.7; transform:scale(1.3); box-shadow:0 0 0 5px rgba(245,130,32,0); }
}

/* ══════════════════════════════════════════════════════
   QUICK ACTION BUTTONS
══════════════════════════════════════════════════════ */
.d-quick-actions { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:28px; }
.d-qa-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 20px;
    border-radius: var(--d-radius-sm);
    font-size: 0.83rem;
    font-weight: 600;
    text-decoration: none;
    border: 1.5px solid transparent;
    transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
    white-space: nowrap;
}
.d-qa-primary {
    background: linear-gradient(135deg, var(--d-orange) 0%, var(--d-orange-light) 100%);
    color: #FFFFFF;
    box-shadow: 0 4px 14px var(--d-orange-shadow);
}
.d-qa-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(245,130,32,0.4);
    color: #FFFFFF;
}
.d-qa-outline {
    background: #FFFFFF;
    color: #374151;
    border-color: #D1D5DB;
    box-shadow: var(--d-shadow-sm);
}
.d-qa-outline:hover {
    border-color: var(--d-orange);
    color: var(--d-orange);
    background: var(--d-orange-soft);
    transform: translateY(-2px);
    box-shadow: var(--d-shadow-orange);
}

/* ══════════════════════════════════════════════════════
   KPI CARDS — WHITE PREMIUM WITH DARK ACCENTS
══════════════════════════════════════════════════════ */
.d-kpi-card {
    background: var(--d-card);
    border: 1px solid var(--d-card-border);
    border-radius: var(--d-radius);
    padding: 22px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.26s cubic-bezier(0.4,0,0.2,1);
    position: relative;
    overflow: hidden;
    height: 100%;
    cursor: default;
    box-shadow: var(--d-shadow-sm);
}
/* Colored top accent bar on hover */
.d-kpi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 3px;
    background: var(--kpi-color, var(--d-orange));
    opacity: 0;
    transition: opacity 0.26s;
}
/* Very soft and light transparent shade of matching color family in the corner */
.d-kpi-card::after {
    content: '';
    position: absolute;
    bottom: -20px; right: -20px;
    width: 85px; height: 85px;
    border-radius: 50%;
    /* Use the standard base color of the family (very light/subtle gradient feel) */
    background: var(--kpi-color, var(--d-orange));
    opacity: 0.07;
    transition: opacity 0.26s, transform 0.32s;
}
.d-kpi-card:hover {
    background: var(--d-card-hover);
    border-color: var(--d-card-border-h);
    transform: translateY(-4px);
    box-shadow: var(--d-shadow-md), 0 0 0 1px var(--d-orange-border);
}
.d-kpi-card:hover::before { opacity: 1; }
.d-kpi-card:hover::after  { opacity: 0.14; transform: scale(1.2); }

.d-kpi-icon {
    width: 52px; height: 52px;
    border-radius: var(--d-radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem;
    flex-shrink: 0;
    /* Custom CSS custom property defined inside elements to use the dark solid matching color family */
    background: var(--kpi-color-dark, var(--d-orange-dark));
    color: #FFFFFF; /* white/light icon */
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 4px 12px var(--kpi-color-glow, var(--d-orange-shadow));
}
.d-kpi-body { flex:1; min-width:0; }
.d-kpi-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--d-text-muted);
    margin-bottom: 6px;
}
.d-kpi-value {
    font-size: 1.85rem;
    font-weight: 800;
    color: var(--d-text);
    line-height: 1;
    margin: 0;
}
.d-kpi-value.money { font-size: 1.45rem; }
.d-kpi-sub {
    font-size: 0.7rem;
    color: var(--d-text-dim);
    margin-top: 5px;
}

/* ══════════════════════════════════════════════════════
   STATUS SUMMARY CARDS — WHITE
══════════════════════════════════════════════════════ */
.d-summary-card {
    background: var(--d-card);
    border: 1px solid var(--d-card-border);
    border-radius: var(--d-radius);
    padding: 22px 24px;
    height: 100%;
    box-shadow: var(--d-shadow-sm);
}
.d-summary-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--d-text);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.d-summary-title i { color: var(--d-orange); }

.d-chip-row { display:flex; flex-wrap:wrap; gap:8px; }
.d-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 13px;
    border-radius: 24px;
    font-size: 0.77rem;
    font-weight: 600;
    white-space: nowrap;
    border: 1.5px solid transparent;
    transition: transform 0.18s, box-shadow 0.18s;
}
.d-chip:hover { transform: translateY(-2px); box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
.d-chip-num { font-size: 1rem; font-weight: 800; line-height: 1; }

/* Light-bg chip variants with proper dark readable colors */
.ch-pending   { background:#FFF7ED; border-color:#FDBA74; color:#C2640A; }
.ch-assigned  { background:#EFF6FF; border-color:#93C5FD; color:#1D4ED8; }
.ch-inprog    { background:#FFFBEB; border-color:#FCD34D; color:#B45309; }
.ch-completed { background:#ECFDF5; border-color:#6EE7B7; color:#065F46; }
.ch-cancelled { background:#FEF2F2; border-color:#FCA5A5; color:#991B1B; }
.ch-accepted  { background:#F5F3FF; border-color:#C4B5FD; color:#5B21B6; }

/* Payment rows */
.d-pay-row {
    display:flex; align-items:center; justify-content:space-between;
    padding: 11px 0;
    border-bottom: 1px solid #F3F4F6;
}
.d-pay-row:last-child { border-bottom:none; }
.d-pay-label { font-size:0.82rem; color:var(--d-text-muted); display:flex; align-items:center; gap:8px; }
.d-pay-val { font-size:0.94rem; font-weight:700; color:var(--d-text); }
.d-pay-val.g { color: var(--d-green); }
.d-pay-val.r { color: var(--d-red); }
.d-pay-val.o { color: var(--d-orange-dark); }

/* ══════════════════════════════════════════════════════
   RECENT RECORDS TABLES — WHITE
══════════════════════════════════════════════════════ */
.d-recent-card {
    background: var(--d-card);
    border: 1px solid var(--d-card-border);
    border-radius: var(--d-radius);
    overflow: hidden;
    box-shadow: var(--d-shadow-sm);
}
.d-recent-header {
    padding: 16px 22px;
    border-bottom: 1px solid #F0F2F5;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    background: #FFFFFF;
}
.d-recent-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--d-text);
    margin: 0;
    display: flex; align-items: center; gap: 8px;
}
.d-recent-title i { color: var(--d-orange); }
.d-view-all {
    font-size: 0.74rem;
    font-weight: 600;
    color: var(--d-orange);
    text-decoration: none;
    display: flex; align-items: center; gap: 4px;
    transition: gap 0.2s, color 0.2s;
}
.d-view-all:hover { color: var(--d-orange-dark); gap: 8px; }

.d-rtable { width:100%; border-collapse:collapse; }
.d-rtable thead th {
    background: #F8F9FB;
    padding: 10px 16px;
    font-size: 0.69rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #6B7280;
    border-bottom: 1.5px solid #E8ECF0;
    white-space: nowrap;
}
.d-rtable tbody td {
    padding: 12px 16px;
    font-size: 0.84rem;
    color: #374151;
    border-bottom: 1px solid #F3F4F6;
    vertical-align: middle;
}
.d-rtable tbody tr:last-child td { border-bottom: none; }
.d-rtable tbody tr:hover td { background: #FFF7F0; }

/* Status badges — solid/saturated on white background */
.d-badge {
    display: inline-flex; align-items:center; gap:4px;
    padding: 3px 10px; border-radius:20px;
    font-size:0.7rem; font-weight:700; white-space:nowrap;
}
.db-pending    { background:#FFF3E0; color:#BF5000; border:1px solid #FFCB8E; }
.db-assigned   { background:#E8F0FE; color:#1A56DB; border:1px solid #A4C2FB; }
.db-inprogress { background:#FFFDE7; color:#9A6300; border:1px solid #FFE082; }
.db-completed  { background:#E6F4EA; color:#1E6631; border:1px solid #A8D5B5; }
.db-cancelled  { background:#FEECEC; color:#B91C1C; border:1px solid #FCAAA8; }
.db-accepted   { background:#F0EFFE; color:#5B21B6; border:1px solid #C4B5FD; }
.db-paid       { background:#E6F4EA; color:#1E6631; border:1px solid #A8D5B5; }
.db-unpaid     { background:#FEECEC; color:#B91C1C; border:1px solid #FCAAA8; }
.db-partial    { background:#FFF3E0; color:#BF5000; border:1px solid #FFCB8E; }

.d-table-empty { text-align:center; padding:36px 20px; color:var(--d-text-dim); }
.d-table-empty i { font-size:2rem; display:block; margin-bottom:8px; color:#D1D5DB; }
.d-table-empty p { font-size:.82rem; margin:0; }

/* ── Invoice number ── */
.inv-no { font-weight:700; color:var(--d-orange-dark); font-size:.8rem; letter-spacing:.4px; }

/* ── Name cells ── */
.td-name { font-weight:600; color:var(--d-text); }

/* ══════════════════════════════════════════════════════
   RESPONSIVE TWEAKS
══════════════════════════════════════════════════════ */
@media (max-width: 767.98px) {
    .dash-wrap { padding: 16px 12px; }
    .d-hero { padding: 22px 20px; }
    .d-hero-left h1 { font-size: 1.15rem; }
    .d-kpi-value { font-size: 1.5rem; }
    .d-kpi-value.money { font-size: 1.2rem; }
}
@media (max-width: 575.98px) {
    .d-hero-badge { display: none; }
    .dash-wrap { padding: 12px 8px; }
    .d-kpi-card { padding: 16px 14px; }
    .d-kpi-icon { width:44px; height:44px; font-size:1.1rem; }
}
</style>

<div class="dash-wrap">

{{-- ════════════════════════════════════════════════════
     HERO BANNER
════════════════════════════════════════════════════ --}}
<div class="d-hero">
    <div class="d-hero-left">
        <h1><i class="bi bi-brightness-high-fill me-2" style="color:var(--d-orange);"></i>
            <span>Gayatri Solar Energy</span> — Admin Panel
        </h1>
        <p>Welcome back, <strong style="color:#F3F4F6;">{{ Auth::user()->name ?? 'Admin' }}</strong>! Here's your complete business overview.</p>
    </div>
    <div class="d-hero-badge">
        <span class="pulse-dot"></span>
        Live Dashboard
    </div>
</div>

{{-- ════════════════════════════════════════════════════
     QUICK ACTIONS
════════════════════════════════════════════════════ --}}
<p class="d-section-label"><i class="bi bi-lightning-charge-fill"></i> Quick Actions</p>
<div class="d-quick-actions mb-4">
    @if(Route::has('customers.create'))
    <a href="{{ route('customers.create') }}" class="d-qa-btn d-qa-primary">
        <i class="bi bi-person-plus-fill"></i> Add Customer
    </a>
    @endif
    @if(Route::has('technicians.create'))
    <a href="{{ route('technicians.create') }}" class="d-qa-btn d-qa-outline">
        <i class="bi bi-person-badge"></i> Add Technician
    </a>
    @endif
    @if(Route::has('service-requests.create'))
    <a href="{{ route('service-requests.create') }}" class="d-qa-btn d-qa-outline">
        <i class="bi bi-clipboard2-plus"></i> New Service Request
    </a>
    @endif
    @if(Route::has('invoices.create'))
    <a href="{{ route('invoices.create') }}" class="d-qa-btn d-qa-outline">
        <i class="bi bi-receipt"></i> New Invoice
    </a>
    @endif
    @if(Route::has('reports.index'))
    <a href="{{ route('reports.index') }}" class="d-qa-btn d-qa-outline">
        <i class="bi bi-bar-chart-line"></i> View Reports
    </a>
    @endif
</div>

{{-- ════════════════════════════════════════════════════
     KPI CARDS — ROW 1: People & Bookings
════════════════════════════════════════════════════ --}}
<p class="d-section-label"><i class="bi bi-grid-3x3-gap-fill"></i> Key Performance Indicators</p>

<div class="row g-3 mb-2">

    {{-- Total Technicians --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#3B82F6; --kpi-color-dark:#1E3A8A; --kpi-color-glow:rgba(59,130,246,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-person-badge-fill"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Total Technicians</div>
                <div class="d-kpi-value">{{ number_format($stats['total_technicians'] ?? 0) }}</div>
                <div class="d-kpi-sub">Field engineers</div>
            </div>
        </div>
    </div>

    {{-- Total Services --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#8B5CF6; --kpi-color-dark:#4C1D95; --kpi-color-glow:rgba(139,92,246,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-wrench-adjustable-circle-fill"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Total Services</div>
                <div class="d-kpi-value">{{ number_format($stats['total_services'] ?? 0) }}</div>
                <div class="d-kpi-sub">Service catalogue</div>
            </div>
        </div>
    </div>

    {{-- Total Service Requests / Bookings --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#6366F1; --kpi-color-dark:#312E81; --kpi-color-glow:rgba(99,102,241,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-clipboard2-data-fill"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Total Bookings</div>
                <div class="d-kpi-value">{{ number_format($stats['total_requests'] ?? 0) }}</div>
                <div class="d-kpi-sub">All-time requests</div>
            </div>
        </div>
    </div>

    {{-- Total Customers --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#F58220; --kpi-color-dark:#7C2D12; --kpi-color-glow:rgba(245,130,32,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-people-fill"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Total Customers</div>
                <div class="d-kpi-value">{{ number_format($stats['total_customers'] ?? 0) }}</div>
                <div class="d-kpi-sub">Registered clients</div>
            </div>
        </div>
    </div>

</div>

{{-- KPI Row 2 — Job Statuses --}}
<div class="row g-3 mb-2">

    {{-- Pending Jobs --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#F59E0B; --kpi-color-dark:#78350F; --kpi-color-glow:rgba(245,158,11,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Pending Jobs</div>
                <div class="d-kpi-value">{{ number_format($stats['pending_requests'] ?? 0) }}</div>
                <div class="d-kpi-sub">Awaiting action</div>
            </div>
        </div>
    </div>

    {{-- Assigned Jobs --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#3B82F6; --kpi-color-dark:#1E3A8A; --kpi-color-glow:rgba(59,130,246,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-person-check-fill"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Assigned Jobs</div>
                <div class="d-kpi-value{{ ($stats['assigned_requests'] ?? 0) > 0 ? '' : '' }}">{{ number_format($stats['assigned_requests'] ?? 0) }}</div>
                <div class="d-kpi-sub">Technician allocated</div>
            </div>
        </div>
    </div>

    {{-- In Progress --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#14B8A6; --kpi-color-dark:#115E59; --kpi-color-glow:rgba(20,184,166,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-tools"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">In Progress</div>
                <div class="d-kpi-value">{{ number_format($stats['inprogress_jobs'] ?? 0) }}</div>
                <div class="d-kpi-sub">Currently active</div>
            </div>
        </div>
    </div>

    {{-- Completed Jobs --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#10B981; --kpi-color-dark:#064E3B; --kpi-color-glow:rgba(16,185,129,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Completed Jobs</div>
                <div class="d-kpi-value">{{ number_format($stats['completed_jobs'] ?? 0) }}</div>
                <div class="d-kpi-sub">Successfully done</div>
            </div>
        </div>
    </div>

</div>

{{-- KPI Row 3 — Financial --}}
<div class="row g-3 mb-4">

    {{-- Total Invoices --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#F58220; --kpi-color-dark:#7C2D12; --kpi-color-glow:rgba(245,130,32,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-receipt-cutoff"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Total Invoices</div>
                <div class="d-kpi-value">{{ number_format($stats['total_invoices'] ?? 0) }}</div>
                <div class="d-kpi-sub">Bills generated</div>
            </div>
        </div>
    </div>

    {{-- Total Revenue --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#3B82F6; --kpi-color-dark:#1E3A8A; --kpi-color-glow:rgba(59,130,246,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-currency-rupee"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Total Revenue</div>
                <div class="d-kpi-value money">₹{{ number_format($stats['total_revenue'] ?? 0, 0) }}</div>
                <div class="d-kpi-sub">Invoice value</div>
            </div>
        </div>
    </div>

    {{-- Paid Amount --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#10B981; --kpi-color-dark:#064E3B; --kpi-color-glow:rgba(16,185,129,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Paid Amount</div>
                <div class="d-kpi-value money">₹{{ number_format($stats['paid_amount'] ?? 0, 0) }}</div>
                <div class="d-kpi-sub">Collected</div>
            </div>
        </div>
    </div>

    {{-- Pending Payments --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="d-kpi-card" style="--kpi-color:#EF4444; --kpi-color-dark:#7F1D1D; --kpi-color-glow:rgba(239,68,68,0.35);">
            <div class="d-kpi-icon"><i class="bi bi-exclamation-circle-fill"></i></div>
            <div class="d-kpi-body">
                <div class="d-kpi-label">Pending Payments</div>
                <div class="d-kpi-value money">₹{{ number_format($stats['pending_amount'] ?? 0, 0) }}</div>
                <div class="d-kpi-sub">Balance due</div>
            </div>
        </div>
    </div>

</div>

{{-- ════════════════════════════════════════════════════
     STATUS SUMMARIES — 3 columns
════════════════════════════════════════════════════ --}}
<p class="d-section-label"><i class="bi bi-pie-chart-fill"></i> Status Summaries</p>
<div class="row g-3 mb-4">

    {{-- Service Request Summary --}}
    <div class="col-12 col-md-4">
        <div class="d-summary-card">
            <div class="d-summary-title">
                <i class="bi bi-clipboard2-pulse-fill"></i> Service Requests
            </div>
            <div class="d-chip-row">
                <div class="d-chip ch-pending">
                    <span class="d-chip-num">{{ $srSummary['Pending'] ?? 0 }}</span> Pending
                </div>
                <div class="d-chip ch-assigned">
                    <span class="d-chip-num">{{ $srSummary['Assigned'] ?? 0 }}</span> Assigned
                </div>
                <div class="d-chip ch-inprog">
                    <span class="d-chip-num">{{ $srSummary['In Progress'] ?? 0 }}</span> In Progress
                </div>
                <div class="d-chip ch-completed">
                    <span class="d-chip-num">{{ $srSummary['Completed'] ?? 0 }}</span> Completed
                </div>
                <div class="d-chip ch-cancelled">
                    <span class="d-chip-num">{{ $srSummary['Cancelled'] ?? 0 }}</span> Cancelled
                </div>
            </div>
        </div>
    </div>

    {{-- Job Assignment Summary --}}
    <div class="col-12 col-md-4">
        <div class="d-summary-card">
            <div class="d-summary-title">
                <i class="bi bi-person-gear"></i> Job Assignments
            </div>
            <div class="d-chip-row">
                <div class="d-chip ch-assigned">
                    <span class="d-chip-num">{{ $jaSummary['Assigned'] ?? 0 }}</span> Assigned
                </div>
                <div class="d-chip ch-accepted">
                    <span class="d-chip-num">{{ $jaSummary['Accepted'] ?? 0 }}</span> Accepted
                </div>
                <div class="d-chip ch-inprog">
                    <span class="d-chip-num">{{ $jaSummary['In Progress'] ?? 0 }}</span> In Progress
                </div>
                <div class="d-chip ch-completed">
                    <span class="d-chip-num">{{ $jaSummary['Completed'] ?? 0 }}</span> Completed
                </div>
                <div class="d-chip ch-cancelled">
                    <span class="d-chip-num">{{ $jaSummary['Cancelled'] ?? 0 }}</span> Cancelled
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Summary --}}
    <div class="col-12 col-md-4">
        <div class="d-summary-card">
            <div class="d-summary-title">
                <i class="bi bi-wallet2"></i> Payment Summary
            </div>
            <div class="d-pay-row">
                <span class="d-pay-label"><i class="bi bi-receipt" style="color:var(--d-orange);"></i> Total Invoiced</span>
                <span class="d-pay-val">₹{{ number_format($paySummary['total_amount'] ?? 0, 0) }}</span>
            </div>
            <div class="d-pay-row">
                <span class="d-pay-label"><i class="bi bi-cash-coin" style="color:var(--d-green);"></i> Total Paid</span>
                <span class="d-pay-val g">₹{{ number_format($paySummary['total_paid'] ?? 0, 0) }}</span>
            </div>
            <div class="d-pay-row">
                <span class="d-pay-label"><i class="bi bi-clock" style="color:var(--d-red);"></i> Balance Due</span>
                <span class="d-pay-val r">₹{{ number_format($paySummary['total_balance'] ?? 0, 0) }}</span>
            </div>
            <div class="d-pay-row">
                <span class="d-pay-label"><i class="bi bi-check-circle" style="color:var(--d-green);"></i> Paid Invoices</span>
                <span class="d-pay-val g">{{ $paySummary['paid_count'] ?? 0 }}</span>
            </div>
            <div class="d-pay-row">
                <span class="d-pay-label"><i class="bi bi-x-circle" style="color:var(--d-red);"></i> Unpaid Invoices</span>
                <span class="d-pay-val r">{{ $paySummary['unpaid_count'] ?? 0 }}</span>
            </div>
            <div class="d-pay-row">
                <span class="d-pay-label"><i class="bi bi-dash-circle" style="color:var(--d-orange);"></i> Partially Paid</span>
                <span class="d-pay-val o">{{ $paySummary['partial_count'] ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════
     RECENT ACTIVITY — Service Requests & Jobs
════════════════════════════════════════════════════ --}}
<p class="d-section-label"><i class="bi bi-activity"></i> Recent Activity</p>
<div class="row g-3 mb-3">

    {{-- Recent Service Requests --}}
    <div class="col-12 col-xl-6">
        <div class="d-recent-card">
            <div class="d-recent-header">
                <h6 class="d-recent-title">
                    <i class="bi bi-clipboard2-pulse-fill"></i> Recent Service Requests
                </h6>
                @if(Route::has('service-requests.index'))
                <a href="{{ route('service-requests.index') }}" class="d-view-all">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
                @endif
            </div>
            <div style="overflow-x:auto;">
                <table class="d-rtable">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Technician</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRequests as $r)
                        <tr>
                            <td class="td-name">{{ optional($r->customer)->name ?? '—' }}</td>
                            <td>{{ optional($r->service)->service_name ?? '—' }}</td>
                            <td>
                                @if(optional($r->technician)->name)
                                    {{ $r->technician->name }}
                                @else
                                    <span style="color:var(--d-text-dim);font-style:italic;font-size:.77rem;">Unassigned</span>
                                @endif
                            </td>
                            <td style="white-space:nowrap;color:var(--d-text-muted);">
                                {{ $r->request_date ? $r->request_date->format('d M Y') : '—' }}
                            </td>
                            <td>
                                @php
                                    $sc = match(strtolower($r->status ?? '')) {
                                        'pending'     => 'db-pending',
                                        'assigned'    => 'db-assigned',
                                        'in progress' => 'db-inprogress',
                                        'completed'   => 'db-completed',
                                        'cancelled'   => 'db-cancelled',
                                        default       => 'db-pending',
                                    };
                                @endphp
                                <span class="d-badge {{ $sc }}">{{ $r->status ?? '—' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5"><div class="d-table-empty">
                            <i class="bi bi-clipboard2-x"></i>
                            <p>No service requests yet.</p>
                        </div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Job Assignments --}}
    <div class="col-12 col-xl-6">
        <div class="d-recent-card">
            <div class="d-recent-header">
                <h6 class="d-recent-title">
                    <i class="bi bi-person-gear"></i> Recent Job Assignments
                </h6>
                @if(Route::has('job-assignments.index'))
                <a href="{{ route('job-assignments.index') }}" class="d-view-all">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
                @endif
            </div>
            <div style="overflow-x:auto;">
                <table class="d-rtable">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Technician</th>
                            <th>Scheduled</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentJobs as $j)
                        <tr>
                            <td class="td-name">
                                {{ optional(optional($j->serviceRequest)->customer)->name ?? '—' }}
                            </td>
                            <td>{{ optional(optional($j->serviceRequest)->service)->service_name ?? '—' }}</td>
                            <td>{{ optional($j->technician)->name ?? '—' }}</td>
                            <td style="white-space:nowrap;color:var(--d-text-muted);">
                                {{ $j->scheduled_date ? $j->scheduled_date->format('d M Y') : '—' }}
                            </td>
                            <td>
                                @php
                                    $jc = match(strtolower($j->status ?? '')) {
                                        'assigned'    => 'db-assigned',
                                        'accepted'    => 'db-accepted',
                                        'in progress' => 'db-inprogress',
                                        'completed'   => 'db-completed',
                                        'cancelled'   => 'db-cancelled',
                                        default       => 'db-assigned',
                                    };
                                @endphp
                                <span class="d-badge {{ $jc }}">{{ $j->status ?? '—' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5"><div class="d-table-empty">
                            <i class="bi bi-calendar2-x"></i>
                            <p>No job assignments yet.</p>
                        </div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════
     RECENT INVOICES / PAYMENTS
════════════════════════════════════════════════════ --}}
<div class="row g-3 mb-2">
    <div class="col-12">
        <div class="d-recent-card">
            <div class="d-recent-header">
                <h6 class="d-recent-title">
                    <i class="bi bi-file-earmark-text-fill"></i> Recent Invoices &amp; Payments
                </h6>
                @if(Route::has('invoices.index'))
                <a href="{{ route('invoices.index') }}" class="d-view-all">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
                @endif
            </div>
            <div style="overflow-x:auto;">
                <table class="d-rtable">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Invoice Date</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentInvoices as $inv)
                        <tr>
                            <td><span class="inv-no">{{ $inv->invoice_no ?? '—' }}</span></td>
                            <td class="td-name">{{ optional($inv->customer)->name ?? '—' }}</td>
                            <td style="white-space:nowrap;color:var(--d-text-muted);">
                                {{ $inv->invoice_date ? $inv->invoice_date->format('d M Y') : '—' }}
                            </td>
                            <td style="font-weight:600;color:var(--d-text);">₹{{ number_format($inv->total_amount ?? 0, 2) }}</td>
                            <td style="font-weight:600;color:var(--d-green);">₹{{ number_format($inv->paid_amount ?? 0, 2) }}</td>
                            <td style="font-weight:600;color:{{ ($inv->balance_amount ?? 0) > 0 ? 'var(--d-red)' : 'var(--d-green)' }};">
                                ₹{{ number_format($inv->balance_amount ?? 0, 2) }}
                            </td>
                            <td>
                                @php
                                    $pc = match(strtolower($inv->payment_status ?? '')) {
                                        'paid'    => 'db-paid',
                                        'unpaid'  => 'db-unpaid',
                                        'partial' => 'db-partial',
                                        default   => 'db-unpaid',
                                    };
                                @endphp
                                <span class="d-badge {{ $pc }}">{{ $inv->payment_status ?? '—' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7"><div class="d-table-empty">
                            <i class="bi bi-receipt-cutoff"></i>
                            <p>No invoices created yet.</p>
                        </div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>{{-- /dash-wrap --}}

@endsection
