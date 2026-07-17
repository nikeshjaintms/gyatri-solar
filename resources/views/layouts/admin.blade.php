<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gayatri Solar Energy - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Gayatri Solar Energy Brand CSS -->
    <link rel="stylesheet" href="{{ asset('css/brand.css') }}">

    <style>
        :root {
            /* ── Gayatri Solar Energy Brand Colors ── */
            --brand-orange: #F58220;
            --brand-orange-hover: #D96A0B;
            --brand-black: #050505ff;
            --sidebar-bg: #0B0B0B;
            --sidebar-header-bg: #111111;
            --bg-main: #F4F6F9;
            --white: #FFFFFF;
            --border-soft: #E8ECF0;
            --text-dark: #111827;
            --text-muted: #6B7280;
            --sidebar-width: 270px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: var(--bg-main);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            overflow: hidden; /* Prevent default page/body scrolling to eliminate double scrollbars */
        }

        .app-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* ══════════════════════════════════════════════════════════
           SIDEBAR - Dark Black with Orange Accents
           Independent scroll, fixed height, collapsable
        ══════════════════════════════════════════════════════════ */
        .sidebar-container {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, var(--brand-black) 100%);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(245,130,32,0.15);
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            z-index: 1050;
            position: relative;
        }

        /* Sidebar collapsed state (Desktop toggle) */
        .app-container.sidebar-collapsed .sidebar-container {
            width: 78px;
        }

        /* ── Sidebar Brand ── */
        .sidebar-brand {
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 12px;
            border-bottom: 1px solid rgba(245,130,32,0.2);
            text-decoration: none;
            flex-shrink: 0;
            background: var(--sidebar-header-bg);
            position: relative;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .admin-logo {
            transition: all 0.3s ease;
        }

        .full-logo {
            height: 50px;
            width: auto;
            max-width: 170px;
            object-fit: contain;
            display: block;
        }

        .collapsed-logo {
            height: 36px;
            width: 36px;
            object-fit: contain;
            display: none;
            margin: 0 auto;
        }

        .sidebar.collapsed .full-logo,
        .app-container.sidebar-collapsed .full-logo {
            display: none !important;
        }

        .sidebar.collapsed .collapsed-logo,
        .app-container.sidebar-collapsed .collapsed-logo {
            display: block !important;
        }

        .sidebar:not(.collapsed) .full-logo,
        .app-container:not(.sidebar-collapsed) .full-logo {
            display: block !important;
        }

        .sidebar:not(.collapsed) .collapsed-logo,
        .app-container:not(.sidebar-collapsed) .collapsed-logo {
            display: none !important;
        }

        /* Mobile Close Button inside Brand area */
        .sidebar-close-btn {
            display: none;
            background: transparent;
            border: none;
            color: var(--white);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .sidebar-close-btn:hover {
            background: rgba(255,255,255,0.1);
        }

        /* ── Sidebar Menu ── */
        .sidebar-menu {
            padding: 18px 12px 20px;
            list-style: none;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--brand-orange) transparent;
            transition: padding 0.3s ease;
        }
        .app-container.sidebar-collapsed .sidebar-menu {
            padding: 18px 8px 20px;
        }
        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-track { background: transparent; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: var(--brand-orange); border-radius: 4px; }

        .menu-header {
            font-size: 0.68rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #4B5563;
            letter-spacing: 1px;
            margin: 22px 0 8px 14px;
            transition: opacity 0.2s ease, margin 0.2s ease;
            opacity: 1;
        }
        .menu-header:first-child { margin-top: 6px; }

        /* Hide headings in collapsed mode */
        .app-container.sidebar-collapsed .menu-header {
            opacity: 0;
            margin: 10px 0 0 0;
            height: 0;
            overflow: hidden;
        }

        .menu-item { margin-bottom: 3px; }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #9CA3AF;
            text-decoration: none;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        .menu-link .menu-icon {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
            color: #9CA3AF;
            transition: all 0.2s ease;
        }
        .menu-link .menu-text {
            color: #D1D5DB;
            transition: opacity 0.2s ease, width 0.2s ease;
            opacity: 1;
            white-space: nowrap;
        }

        /* Collapsed menu styling adjustments */
        .app-container.sidebar-collapsed .menu-link {
            justify-content: center;
            gap: 0;
            padding: 11px 0;
        }
        .app-container.sidebar-collapsed .menu-link .menu-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
            display: none;
        }

        /* ── Hover state: Orange tint + white text ── */
        .menu-link:hover {
            background: rgba(245,130,32,0.1);
            color: var(--white);
        }
        .menu-link:hover .menu-text { color: var(--white); }
        .menu-link:hover .menu-icon { 
            color: var(--brand-orange);
            transform: scale(1.1);
        }

        /* ── Active state: Orange background + left border ── */
        .menu-link.active {
            background: linear-gradient(90deg, rgba(245,130,32,0.15), rgba(245,130,32,0.05));
            color: var(--white);
            box-shadow: 0 2px 8px rgba(245,130,32,0.2);
        }
        .menu-link.active .menu-text { color: var(--white); font-weight: 600; }
        .menu-link.active .menu-icon { color: var(--brand-orange); }
        .menu-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 28px;
            background: var(--brand-orange);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 12px var(--brand-orange);
            transition: all 0.2s;
        }
        /* Reposition border indicator inside collapsed menu link item */
        .app-container.sidebar-collapsed .menu-link.active::before {
            left: 0;
            height: 22px;
        }

        /* ── Sidebar footer (user profile) ── */
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(245,130,32,0.2);
            flex-shrink: 0;
            background: var(--sidebar-header-bg);
            transition: padding 0.3s ease;
        }
        .app-container.sidebar-collapsed .sidebar-footer {
            padding: 16px 8px;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 13px;
            border-radius: 10px;
            background: rgba(245,130,32,0.08);
            border: 1px solid rgba(245,130,32,0.15);
            transition: all 0.3s ease;
        }
        .app-container.sidebar-collapsed .sidebar-user {
            justify-content: center;
            padding: 8px 0;
            gap: 0;
        }
        .sidebar-user:hover {
            background: rgba(245,130,32,0.12);
            transform: translateY(-1px);
        }
        .sidebar-user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--brand-orange), #FF9D4D);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--white);
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.15);
        }
        .sidebar-user-info {
            min-width: 0;
            flex: 1;
            transition: opacity 0.2s ease;
            opacity: 1;
        }
        .app-container.sidebar-collapsed .sidebar-user-info {
            opacity: 0;
            width: 0;
            display: none;
        }
        .sidebar-user-name {
            font-size: 0.84rem;
            font-weight: 600;
            color: #F3F4F6;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-role {
            font-size: 0.72rem;
            color: #9CA3AF;
        }

        /* ══════════════════════════════════════════════════════════
           TOPBAR - Clean White with Orange Accents
        ══════════════════════════════════════════════════════════ */
        .main-wrapper {
            flex-grow: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden; /* Wrapper stays full height without page scroll */
        }

        .topbar-container {
            height: 70px;
            background: var(--white);
            border-bottom: 2px solid var(--border-soft);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            position: relative;
        }
        /* Orange accent line at bottom */
        .topbar-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--brand-orange) 0%, transparent 100%);
        }

        .page-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -0.3px;
        }
        .topbar-breadcrumb {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 2px;
        }
        .topbar-breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .topbar-breadcrumb a:hover { color: var(--brand-orange); }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .topbar-user-chip {
            display: flex;
            align-items: center;
            gap: 9px;
            background: #F9FAFB;
            border: 1.5px solid var(--border-soft);
            border-radius: 24px;
            padding: 6px 16px 6px 8px;
            font-size: 0.84rem;
            color: var(--text-dark);
            transition: all 0.2s;
        }
        .topbar-user-chip:hover {
            border-color: var(--brand-orange);
            background: #FFF7ED;
        }
        .topbar-user-chip .chip-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--brand-orange), #FF9D4D);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--white);
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 9px;
            background: var(--white);
            color: #dc2626;
            border: 1.5px solid #fecaca;
            font-size: 0.84rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover {
            background: #dc2626;
            color: var(--white);
            border-color: #dc2626;
            box-shadow: 0 4px 12px rgba(220,38,38,0.25);
            transform: translateY(-1px);
        }

        .content-body {
            padding: 28px;
            background: #F4F6F9;
            flex-grow: 1;
            overflow-y: auto;
            width: 100%;
            height: calc(100vh - 70px);
        }

        /* ── Sidebar Toggle Button (Desktop & Mobile) ── */
        .sidebar-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px; height: 38px;
            border-radius: 9px;
            background: #F9FAFB;
            border: 1.5px solid var(--border-soft);
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.2s;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .sidebar-toggle-btn:hover { 
            background: #FFF7ED; 
            border-color: var(--brand-orange);
            color: var(--brand-orange);
        }

        /* ══════════════════════════════════════════════════════════
           RESPONSIVE & MOBILE
         ══════════════════════════════════════════════════════════ */
        @media (max-width: 991.98px) {
            .sidebar-close-btn {
                display: block;
            }

            .sidebar-container {
                position: fixed;
                top: 0; bottom: 0;
                left: calc(-1 * var(--sidebar-width));
                z-index: 1050;
                box-shadow: none;
                transition: left 0.3s cubic-bezier(0.4,0,0.2,1);
            }
            /* Override desktop collapse wrapper shift on mobile */
            .app-container.sidebar-collapsed .sidebar-container {
                width: var(--sidebar-width);
                left: calc(-1 * var(--sidebar-width));
            }
            .sidebar-container.show {
                left: 0 !important;
                box-shadow: 12px 0 48px rgba(0,0,0,0.4);
            }
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
                display: none;
                backdrop-filter: blur(3px);
            }
            .sidebar-overlay.show { display: block; }

            .content-body { padding: 22px 18px; }
        }

        @media (max-width: 575.98px) {
            .topbar-user-chip { display: none; }
            .page-title { font-size: 1rem; }
            .content-body { padding: 14px 10px; }
        }

        /* ─── jQuery Validation Styles ─── */
        input.is-invalid, select.is-invalid, textarea.is-invalid {
            border-color: #dc2626 !important;
            background-image: none !important;
        }
        input.is-valid, select.is-valid, textarea.is-valid {
            border-color: #10b981 !important;
            background-image: none !important;
        }
        div.invalid-feedback, div.field-error {
            color: #dc2626 !important;
            font-size: 0.82rem;
            font-weight: 500;
            display: block;
            margin-top: 6px;
        }
    </style>
</head>
<body>

    <!-- Overlay for mobile sidebar toggling -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="app-container">
        <!-- ══════════════════════════════════════════════════════════
             SIDEBAR
        ══════════════════════════════════════════════════════════ -->
        <aside class="sidebar-container sidebar" id="sidebarContainer">
            <!-- Brand -->
            <div class="sidebar-brand">
                <img src="{{ asset('assets/images/logo.jpg') }}" alt="Gayatri Solar Logo" class="admin-logo full-logo">
                <img src="{{ asset('assets/images/logo-g.png') }}" alt="G Logo" class="admin-logo collapsed-logo">
                <button type="button" class="sidebar-close-btn" id="sidebarClose" aria-label="Close Sidebar" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%);">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

             <!-- Navigation Menu -->
             <ul class="sidebar-menu">
                 @if(in_array(Auth::user()->role ?? '', ['Super Admin', 'Admin', 'Manager']))
                     <div class="menu-header">CORE</div>
                     <li class="menu-item">
                         <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                             <i class="bi bi-speedometer2 menu-icon"></i>
                             <span class="menu-text">Dashboard</span>
                         </a>
                     </li>
 
                     <div class="menu-header">MANAGEMENT</div>
                     <li class="menu-item">
                         <a href="{{ route('customers.index') }}" class="menu-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                             <i class="bi bi-people menu-icon"></i>
                             <span class="menu-text">Customers</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('enquiries.index') }}" class="menu-link {{ request()->routeIs('enquiries.*') ? 'active' : '' }}">
                             <i class="bi bi-chat-left-quote menu-icon"></i>
                             <span class="menu-text">Enquiries</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('site-surveys.index') }}" class="menu-link {{ request()->routeIs('site-surveys.*') ? 'active' : '' }}">
                             <i class="bi bi-map menu-icon"></i>
                             <span class="menu-text">Site Surveys</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('quotations.index') }}" class="menu-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}">
                             <i class="bi bi-file-earmark-ruled menu-icon"></i>
                             <span class="menu-text">Quotations</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('service-requests.index') }}" class="menu-link {{ request()->routeIs('service-requests.*') ? 'active' : '' }}">
                             <i class="bi bi-clipboard2-check menu-icon"></i>
                             <span class="menu-text">Service Requests</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('job-assignments.index') }}" class="menu-link {{ request()->routeIs('job-assignments.*') ? 'active' : '' }}">
                             <i class="bi bi-tools menu-icon"></i>
                             <span class="menu-text">Job Assignments</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('job-status-tracking.index') }}" class="menu-link {{ request()->routeIs('job-status-tracking.*') ? 'active' : '' }}">
                             <i class="bi bi-geo-alt menu-icon"></i>
                             <span class="menu-text">Job Status Tracking</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('technicians.index') }}" class="menu-link {{ request()->routeIs('technicians.*') ? 'active' : '' }}">
                             <i class="bi bi-person-badge menu-icon"></i>
                             <span class="menu-text">Technicians</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('services.index') }}" class="menu-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                             <i class="bi bi-wrench-adjustable menu-icon"></i>
                             <span class="menu-text">Services</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('employees.index') }}" class="menu-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                             <i class="bi bi-person-workspace menu-icon"></i>
                             <span class="menu-text">Employees</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('employee-attendances.index') }}" class="menu-link {{ request()->routeIs('employee-attendances.*') ? 'active' : '' }}">
                             <i class="bi bi-calendar-check menu-icon"></i>
                             <span class="menu-text">Employee Attendance</span>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('users.index') }}" class="menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                             <i class="bi bi-person-gear menu-icon"></i>
                             <span class="menu-text">Users</span>
                         </a>
                     </li>
 
                     <div class="menu-header">MASTERS</div>
                     <li class="menu-item">
                         <a href="{{ route('products.index') }}" class="menu-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                             <i class="bi bi-box-seam menu-icon"></i>
                             <span class="menu-text">Product Master</span>
                         </a>
                     </li>
 
                     <div class="menu-header">BILLING</div>
                     <li class="menu-item">
                         <a href="{{ route('invoices.index') }}" class="menu-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                             <i class="bi bi-receipt menu-icon"></i>
                             <span class="menu-text">Invoices / Payments</span>
                         </a>
                     </li>
 
                     <div class="menu-header">ANALYTICS</div>
                     <li class="menu-item">
                         <a href="{{ route('reports.index') }}"
                            class="menu-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                             <i class="bi bi-bar-chart-line menu-icon"></i>
                             <span class="menu-text">Reports</span>
                         </a>
                     </li>
                     @if(request()->routeIs('reports.*'))
                     <li class="menu-item ms-3">
                         <a href="{{ route('reports.service-requests') }}"
                            class="menu-link {{ request()->routeIs('reports.service-requests') ? 'active' : '' }}"
                            style="font-size:.82rem; padding:8px 14px;">
                             <i class="bi bi-clipboard2-pulse menu-icon" style="font-size:.95rem;"></i>
                             <span class="menu-text">Service Requests</span>
                         </a>
                     </li>
                     <li class="menu-item ms-3">
                         <a href="{{ route('reports.job-assignments') }}"
                            class="menu-link {{ request()->routeIs('reports.job-assignments') ? 'active' : '' }}"
                            style="font-size:.82rem; padding:8px 14px;">
                             <i class="bi bi-person-gear menu-icon" style="font-size:.95rem;"></i>
                             <span class="menu-text">Job Assignments</span>
                         </a>
                     </li>
                     <li class="menu-item ms-3">
                         <a href="{{ route('reports.invoices') }}"
                            class="menu-link {{ request()->routeIs('reports.invoices') ? 'active' : '' }}"
                            style="font-size:.82rem; padding:8px 14px;">
                             <i class="bi bi-file-earmark-text menu-icon" style="font-size:.95rem;"></i>
                             <span class="menu-text">Invoice Report</span>
                         </a>
                     </li>
                     <li class="menu-item ms-3">
                         <a href="{{ route('reports.payments') }}"
                            class="menu-link {{ request()->routeIs('reports.payments') ? 'active' : '' }}"
                            style="font-size:.82rem; padding:8px 14px;">
                             <i class="bi bi-wallet2 menu-icon" style="font-size:.95rem;"></i>
                             <span class="menu-text">Payment Report</span>
                         </a>
                     </li>
                     @endif
                 @else
                     <div class="menu-header">EMPLOYEE PANEL</div>
                     <li class="menu-item">
                         <a href="{{ route('employee.attendance') }}" class="menu-link {{ request()->routeIs('employee.attendance') ? 'active' : '' }}">
                             <i class="bi bi-calendar-check menu-icon"></i>
                             <span class="menu-text">Attendance</span>
                         </a>
                     </li>
                 @endif
             </ul>
 
             <!-- Sidebar Footer -->
             <div class="sidebar-footer">
                 <div class="sidebar-user">
                     <div class="sidebar-user-avatar">
                         {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                     </div>
                     <div class="sidebar-user-info">
                         <div class="sidebar-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                         <div class="sidebar-user-role">{{ Auth::user()->role ?? 'Employee' }}</div>
                     </div>
                 </div>
            </div>
        </aside>

        <!-- ══════════════════════════════════════════════════════════
             MAIN WRAPPER
        ══════════════════════════════════════════════════════════ -->
        <div class="main-wrapper">
            <!-- Topbar -->
            <header class="topbar-container">
                <div class="d-flex align-items-center">
                    <button class="sidebar-toggle-btn" id="sidebarToggle" type="button" aria-label="Toggle Sidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <h2 class="page-title">
                            @if(request()->routeIs('employee.attendance'))
                                Daily attendance Punch
                            @elseif(request()->routeIs('dashboard'))
                                Dashboard
                            @elseif(request()->routeIs('customers.create'))
                                Add Customer
                            @elseif(request()->routeIs('customers.edit'))
                                Edit Customer
                            @elseif(request()->routeIs('customers.show'))
                                Customer Details
                            @elseif(request()->routeIs('customers.*'))
                                Customers
                            @elseif(request()->routeIs('enquiries.create'))
                                Add Enquiry
                            @elseif(request()->routeIs('enquiries.edit'))
                                Edit Enquiry
                            @elseif(request()->routeIs('enquiries.show'))
                                Enquiry Details
                            @elseif(request()->routeIs('enquiries.*'))
                                Enquiries
                            @elseif(request()->routeIs('quotations.create'))
                                Add Quotation
                            @elseif(request()->routeIs('quotations.edit'))
                                Edit Quotation
                            @elseif(request()->routeIs('quotations.show'))
                                Quotation Details
                            @elseif(request()->routeIs('quotations.print'))
                                Print Quotation
                            @elseif(request()->routeIs('quotations.*'))
                                Quotations
                            @elseif(request()->routeIs('site-surveys.create'))
                                Add Site Survey
                            @elseif(request()->routeIs('site-surveys.edit'))
                                Edit Site Survey
                            @elseif(request()->routeIs('site-surveys.show'))
                                Site Survey Details
                            @elseif(request()->routeIs('site-surveys.*'))
                                Site Surveys
                            @elseif(request()->routeIs('users.create'))
                                Add User
                            @elseif(request()->routeIs('users.edit'))
                                Edit User
                            @elseif(request()->routeIs('users.show'))
                                User Details
                            @elseif(request()->routeIs('users.*'))
                                User Management
                            @elseif(request()->routeIs('technicians.create'))
                                Add Technician
                            @elseif(request()->routeIs('technicians.edit'))
                                Edit Technician
                            @elseif(request()->routeIs('technicians.show'))
                                Technician Details
                            @elseif(request()->routeIs('technicians.*'))
                                Technicians
                            @elseif(request()->routeIs('employee-attendances.create'))
                                Record Attendance
                            @elseif(request()->routeIs('employee-attendances.edit'))
                                Edit Attendance
                            @elseif(request()->routeIs('employee-attendances.show'))
                                Attendance Details
                            @elseif(request()->routeIs('employee-attendances.*'))
                                Employee Attendance
                            @elseif(request()->routeIs('services.create'))
                                Add Service
                            @elseif(request()->routeIs('services.edit'))
                                Edit Service
                            @elseif(request()->routeIs('services.show'))
                                Service Details
                            @elseif(request()->routeIs('services.*'))
                                Services
                            @elseif(request()->routeIs('products.create'))
                                Add Product
                            @elseif(request()->routeIs('products.edit'))
                                Edit Product
                            @elseif(request()->routeIs('products.show'))
                                Product Details
                            @elseif(request()->routeIs('products.*'))
                                Product Master
                            @elseif(request()->routeIs('service-requests.create'))
                                New Service Request
                            @elseif(request()->routeIs('service-requests.edit'))
                                Edit Service Request
                            @elseif(request()->routeIs('service-requests.show'))
                                Service Request Details
                            @elseif(request()->routeIs('service-requests.*'))
                                Service Requests
                            @elseif(request()->routeIs('job-assignments.create'))
                                New Job Assignment
                            @elseif(request()->routeIs('job-assignments.edit'))
                                Edit Job Assignment
                            @elseif(request()->routeIs('job-assignments.show'))
                                Job Assignment Details
                            @elseif(request()->routeIs('job-assignments.*'))
                                Job Assignments
                            @elseif(request()->routeIs('job-status-tracking.create'))
                                New Status Update
                            @elseif(request()->routeIs('job-status-tracking.edit'))
                                Edit Status Update
                            @elseif(request()->routeIs('job-status-tracking.show'))
                                Status Update Details
                            @elseif(request()->routeIs('job-status-tracking.*'))
                                Job Status Tracking
                            @elseif(request()->routeIs('invoices.create'))
                                New Invoice
                            @elseif(request()->routeIs('invoices.edit'))
                                Edit Invoice
                            @elseif(request()->routeIs('invoices.show'))
                                Invoice Details
                            @elseif(request()->routeIs('invoices.*'))
                                Invoices / Payments
                            @elseif(request()->routeIs('reports.service-requests'))
                                Service Requests Report
                            @elseif(request()->routeIs('reports.job-assignments'))
                                Job Assignments Report
                            @elseif(request()->routeIs('reports.invoices'))
                                Invoice Report
                            @elseif(request()->routeIs('reports.payments'))
                                Payment Report
                            @elseif(request()->routeIs('reports.*'))
                                Reports &amp; Dashboard
                            @else
                                Admin
                            @endif
                        </h2>
                        <div class="topbar-breadcrumb">
                            @if(in_array(Auth::user()->role ?? '', ['Super Admin', 'Admin', 'Manager']))
                                <a href="{{ route('dashboard') }}">Home</a>
                            @else
                                <a href="{{ route('employee.attendance') }}">Home</a>
                            @endif

                            @if(request()->routeIs('employee.attendance'))
                                &nbsp;/&nbsp; <span>Attendance Punch</span>
                            @elseif(request()->routeIs('technicians.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('technicians.index'))
                                    <span>Technicians</span>
                                @elseif(request()->routeIs('technicians.create'))
                                    <a href="{{ route('technicians.index') }}">Technicians</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('technicians.edit'))
                                    <a href="{{ route('technicians.index') }}">Technicians</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('technicians.show'))
                                    <a href="{{ route('technicians.index') }}">Technicians</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('employees.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('employees.index'))
                                    <span>Employees</span>
                                @elseif(request()->routeIs('employees.create'))
                                    <a href="{{ route('employees.index') }}">Employees</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('employees.edit'))
                                    <a href="{{ route('employees.index') }}">Employees</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('employees.show'))
                                    <a href="{{ route('employees.index') }}">Employees</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('products.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('products.index'))
                                    <span>Products</span>
                                @elseif(request()->routeIs('products.create'))
                                    <a href="{{ route('products.index') }}">Products</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('products.edit'))
                                    <a href="{{ route('products.index') }}">Products</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('products.show'))
                                    <a href="{{ route('products.index') }}">Products</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('employee-attendances.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('employee-attendances.index'))
                                    <span>Employee Attendance</span>
                                @elseif(request()->routeIs('employee-attendances.create'))
                                    <a href="{{ route('employee-attendances.index') }}">Employee Attendance</a> &nbsp;/&nbsp; <span>Record New</span>
                                @elseif(request()->routeIs('employee-attendances.edit'))
                                    <a href="{{ route('employee-attendances.index') }}">Employee Attendance</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('employee-attendances.show'))
                                    <a href="{{ route('employee-attendances.index') }}">Employee Attendance</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('enquiries.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('enquiries.index'))
                                    <span>Enquiries</span>
                                @elseif(request()->routeIs('enquiries.create'))
                                    <a href="{{ route('enquiries.index') }}">Enquiries</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('enquiries.edit'))
                                    <a href="{{ route('enquiries.index') }}">Enquiries</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('enquiries.show'))
                                    <a href="{{ route('enquiries.index') }}">Enquiries</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('quotations.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('quotations.index'))
                                    <span>Quotations</span>
                                @elseif(request()->routeIs('quotations.create'))
                                    <a href="{{ route('quotations.index') }}">Quotations</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('quotations.edit'))
                                    <a href="{{ route('quotations.index') }}">Quotations</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('quotations.show'))
                                    <a href="{{ route('quotations.index') }}">Quotations</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('site-surveys.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('site-surveys.index'))
                                    <span>Site Surveys</span>
                                @elseif(request()->routeIs('site-surveys.create'))
                                    <a href="{{ route('site-surveys.index') }}">Site Surveys</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('site-surveys.edit'))
                                    <a href="{{ route('site-surveys.index') }}">Site Surveys</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('site-surveys.show'))
                                    <a href="{{ route('site-surveys.index') }}">Site Surveys</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('users.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('users.index'))
                                    <span>Users</span>
                                @elseif(request()->routeIs('users.create'))
                                    <a href="{{ route('users.index') }}">Users</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('users.edit'))
                                    <a href="{{ route('users.index') }}">Users</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('users.show'))
                                    <a href="{{ route('users.index') }}">Users</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('customers.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('customers.index'))
                                    <span>Customers</span>
                                @elseif(request()->routeIs('customers.create'))
                                    <a href="{{ route('customers.index') }}">Customers</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('customers.edit'))
                                    <a href="{{ route('customers.index') }}">Customers</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('customers.show'))
                                    <a href="{{ route('customers.index') }}">Customers</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('services.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('services.index'))
                                    <span>Services</span>
                                @elseif(request()->routeIs('services.create'))
                                    <a href="{{ route('services.index') }}">Services</a> &nbsp;/&nbsp; <span>Add New</span>
                                @elseif(request()->routeIs('services.edit'))
                                    <a href="{{ route('services.index') }}">Services</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('services.show'))
                                    <a href="{{ route('services.index') }}">Services</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('service-requests.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('service-requests.index'))
                                    <span>Service Requests</span>
                                @elseif(request()->routeIs('service-requests.create'))
                                    <a href="{{ route('service-requests.index') }}">Service Requests</a> &nbsp;/&nbsp; <span>New Request</span>
                                @elseif(request()->routeIs('service-requests.edit'))
                                    <a href="{{ route('service-requests.index') }}">Service Requests</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('service-requests.show'))
                                    <a href="{{ route('service-requests.index') }}">Service Requests</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('job-assignments.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('job-assignments.index'))
                                    <span>Job Assignments</span>
                                @elseif(request()->routeIs('job-assignments.create'))
                                    <a href="{{ route('job-assignments.index') }}">Job Assignments</a> &nbsp;/&nbsp; <span>New Assignment</span>
                                @elseif(request()->routeIs('job-assignments.edit'))
                                    <a href="{{ route('job-assignments.index') }}">Job Assignments</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('job-assignments.show'))
                                    <a href="{{ route('job-assignments.index') }}">Job Assignments</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('job-status-tracking.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('job-status-tracking.index'))
                                    <span>Job Status Tracking</span>
                                @elseif(request()->routeIs('job-status-tracking.create'))
                                    <a href="{{ route('job-status-tracking.index') }}">Job Status Tracking</a> &nbsp;/&nbsp; <span>New Update</span>
                                @elseif(request()->routeIs('job-status-tracking.edit'))
                                    <a href="{{ route('job-status-tracking.index') }}">Job Status Tracking</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('job-status-tracking.show'))
                                    <a href="{{ route('job-status-tracking.index') }}">Job Status Tracking</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('invoices.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('invoices.index'))
                                    <span>Invoices</span>
                                @elseif(request()->routeIs('invoices.create'))
                                    <a href="{{ route('invoices.index') }}">Invoices</a> &nbsp;/&nbsp; <span>New Invoice</span>
                                @elseif(request()->routeIs('invoices.edit'))
                                    <a href="{{ route('invoices.index') }}">Invoices</a> &nbsp;/&nbsp; <span>Edit</span>
                                @elseif(request()->routeIs('invoices.show'))
                                    <a href="{{ route('invoices.index') }}">Invoices</a> &nbsp;/&nbsp; <span>Details</span>
                                @endif
                            @elseif(request()->routeIs('reports.*'))
                                &nbsp;/&nbsp;
                                @if(request()->routeIs('reports.index'))
                                    <span>Reports</span>
                                @elseif(request()->routeIs('reports.service-requests'))
                                    <a href="{{ route('reports.index') }}">Reports</a> &nbsp;/&nbsp; <span>Service Requests</span>
                                @elseif(request()->routeIs('reports.job-assignments'))
                                    <a href="{{ route('reports.index') }}">Reports</a> &nbsp;/&nbsp; <span>Job Assignments</span>
                                @elseif(request()->routeIs('reports.invoices'))
                                    <a href="{{ route('reports.index') }}">Reports</a> &nbsp;/&nbsp; <span>Invoices</span>
                                @elseif(request()->routeIs('reports.payments'))
                                    <a href="{{ route('reports.index') }}">Reports</a> &nbsp;/&nbsp; <span>Payments</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="topbar-right">
                    <div class="topbar-user-chip d-none d-sm-flex">
                        <div class="chip-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-sm-inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content Body -->
            <main class="content-body">
                @include('admin.partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery and jQuery Validation Plugin -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.1/dist/additional-methods.min.js"></script>

    <!-- Sidebar Toggler Script for Desktop & Mobile Viewports -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const closeBtn = document.getElementById('sidebarClose');
            const sidebar = document.getElementById('sidebarContainer');
            const overlay = document.getElementById('sidebarOverlay');
            const container = document.querySelector('.app-container');

            function toggleSidebar() {
                if (window.innerWidth >= 992) {
                    container.classList.toggle('sidebar-collapsed');
                    sidebar.classList.toggle('collapsed');
                } else {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            }

            function closeSidebarMobile() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebarMobile);
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebarMobile);
            }

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    closeSidebarMobile();
                }
            });

            // Global Delete Confirmation
            document.addEventListener('submit', function(event) {
                const form = event.target;
                if (form && form.classList.contains('delete-form')) {
                    if (!confirm('Are you sure you want to delete this record?')) {
                        event.preventDefault();
                    }
                }
            });
        });

        // jQuery Validation Integration
        $(document).ready(function() {
            // Register custom validation rules for Indian formats & others
            $.validator.addMethod("mobile", function(value, element) {
                return this.optional(element) || /^[0-9]{10}$/.test(value.trim());
            }, "Please enter a valid 10-digit Mobile Number.");

            $.validator.addMethod("gst", function(value, element) {
                return this.optional(element) || /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/.test(value.trim());
            }, "Please enter a valid GST Number.");

            $.validator.addMethod("pan", function(value, element) {
                return this.optional(element) || /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(value.trim());
            }, "Please enter a valid PAN Number.");

            $.validator.addMethod("aadhaar", function(value, element) {
                return this.optional(element) || /^[0-9]{12}$/.test(value.trim());
            }, "Please enter a valid Aadhaar Number.");

            $.validator.addMethod("pincode", function(value, element) {
                return this.optional(element) || /^[0-9]{6}$/.test(value.trim());
            }, "Please enter a valid 6-digit Pincode.");

            $.validator.addMethod("ifsc", function(value, element) {
                return this.optional(element) || /^[A-Z]{4}0[A-Z0-9]{6}$/.test(value.trim());
            }, "Please enter a valid IFSC Code.");

            $.validator.addMethod("vehicle", function(value, element) {
                return this.optional(element) || /^[A-Z]{2}[0-9]{2}[A-Z]{1,2}[0-9]{4}$/.test(value.trim());
            }, "Please enter a valid Vehicle Number.");

            $.validator.addMethod("letters", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9\s\.\-]+$/.test(value.trim());
            }, "Please enter a valid name.");

            // Dynamic customized messages similar to the user's reference design (never falls back to placeholder)
            $.extend($.validator.messages, {
                required: function(param, element) {
                    let labelText = '';
                    const id = $(element).attr('id');
                    if (id) {
                        labelText = $('label[for="' + id + '"]').text().trim();
                    }
                    if (!labelText) {
                        labelText = $(element).closest('.col-12, .col-md-6, .col-md-4, .col-md-3, .col-md-8, .form-group, .mb-3, div').find('label').first().text().trim();
                    }
                    
                    // Strip asterisks, colons, or HTML tags from label
                    labelText = labelText.replace(/\*/g, '').replace(/:/g, '').trim();

                    // If still empty, fall back to clean name attribute parsing (never use placeholder)
                    if (!labelText) {
                        const nameAttr = $(element).attr('name') || '';
                        labelText = nameAttr.replace(/_id$/i, '')
                                             .replace(/[\[\]]/g, ' ')
                                             .replace(/_/g, ' ')
                                             .trim();
                    }

                    // Format common field names to match expected layout examples perfectly
                    const lowerLabel = labelText.toLowerCase();
                    if (lowerLabel === 'name' || lowerLabel === 'full name') {
                        labelText = 'Name';
                    } else if (lowerLabel === 'email' || lowerLabel === 'email address') {
                        labelText = 'Email Address';
                    } else if (lowerLabel === 'phone' || lowerLabel === 'phone number' || lowerLabel === 'mobile' || lowerLabel === 'mobile number') {
                        labelText = 'Phone Number';
                    } else if (lowerLabel === 'address' || lowerLabel === 'street address') {
                        labelText = 'Address';
                    } else if (lowerLabel === 'gst' || lowerLabel === 'gst number' || lowerLabel === 'gstin') {
                        labelText = 'GST Number';
                    } else if (lowerLabel === 'pan' || lowerLabel === 'pan number') {
                        labelText = 'PAN Number';
                    } else if (lowerLabel === 'ifsc' || lowerLabel === 'ifsc code') {
                        labelText = 'IFSC Code';
                    } else if (lowerLabel === 'pincode' || lowerLabel === 'pin code') {
                        labelText = 'Pincode';
                    } else if (lowerLabel === 'bank' || lowerLabel === 'bank name') {
                        labelText = 'Bank Name';
                    } else if (lowerLabel === 'account number' || lowerLabel === 'bank account') {
                        labelText = 'Account Number';
                    } else if (lowerLabel === 'branch' || lowerLabel === 'branch name') {
                        labelText = 'Branch Name';
                    }

                    if (labelText) {
                        // Title Case formatting
                        labelText = labelText.replace(/\w\S*/g, function(txt) {
                            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                        });

                        if ($(element).is('select')) {
                            return "Please select " + labelText + ".";
                        }
                        if ($(element).attr('type') === 'file') {
                            if ($(element).attr('accept') && $(element).attr('accept').indexOf('image') !== -1) {
                                return "Please select an Image.";
                            }
                            return "Please upload a valid file.";
                        }
                        return "The " + labelText + " field is required.";
                    }
                    
                    if ($(element).is('select')) {
                        return "Please select the option.";
                    }
                    return "This field is required.";
                },
                email: "Please enter a valid Email Address."
            });

            // Default configuration for jQuery validation plugin (integrated with Bootstrap states)
            $.validator.setDefaults({
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback d-block mt-1').css('color', 'red');
                    if (element.parent('.field-input-wrap').length) {
                        error.insertAfter(element.parent('.field-input-wrap'));
                    } else if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                onkeyup: function(element) {
                    $(element).valid();
                },
                onfocusout: function(element) {
                    $(element).valid();
                },
                onchange: function(element) {
                    $(element).valid();
                }
            });

            // Auto-bind validation rules to all forms on page
            $('form:not(.delete-form)').each(function() {
                const form = $(this);
                form.attr('novalidate', 'novalidate'); // Disable browser native tooltip validation!

                // Initialize validator on the form first so that rules('add') works correctly
                form.validate({
                    invalidHandler: function(event, validator) {
                        // Automatically focus the first invalid field
                        if (validator.errorList.length) {
                            $(validator.errorList[0].element).focus();
                        }
                    },
                    submitHandler: function(formElement) {
                        const submitBtn = $(formElement).find('button[type="submit"], input[type="submit"]');
                        submitBtn.prop('disabled', true);
                        if (!submitBtn.find('.spinner-border').length) {
                            submitBtn.html(`<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...`);
                        }
                        formElement.submit();
                    }
                });

                // Find all inputs/selects/textareas and enforce required validation
                form.find('input:not([type="hidden"]), select, textarea').each(function() {
                    const input = $(this);
                    const name = input.attr('name');
                    if (!name) return;

                    // Skip search/filter forms
                    if (form.attr('method') && form.attr('method').toUpperCase() === 'GET') {
                        return;
                    }
                    if (name.indexOf('search') !== -1 || name.indexOf('filter') !== -1) {
                        return;
                    }

                    input.rules('add', { required: true });
                });

                // Auto-configure rules based on common input names/types
                form.find('input[name*="email"]').each(function() {
                    $(this).rules('add', { email: true });
                });

                form.find('input[name*="phone"], input[name*="mobile"]').each(function() {
                    $(this).rules('add', { required: true, mobile: true });
                });

                form.find('input[name*="gst"]').each(function() {
                    const input = $(this);
                    if (input.attr('type') === 'number' || input.attr('name').indexOf('percentage') !== -1 || input.attr('name').indexOf('rate') !== -1) {
                        input.rules('add', {
                            required: true,
                            number: true,
                            min: 0,
                            max: 100,
                            messages: {
                                required: "Please enter GST (%).",
                                number: "Please enter a valid GST Percentage.",
                                min: "Please enter a valid GST Percentage.",
                                max: "GST cannot be greater than 100%."
                            }
                        });
                    } else {
                        input.rules('add', { gst: true });
                    }
                });

                form.find('input[name*="pan"]').each(function() {
                    $(this).rules('add', { pan: true });
                });

                form.find('input[name*="pincode"], input[name*="pin_code"]').each(function() {
                    $(this).rules('add', { pincode: true });
                });

                form.find('input[name*="ifsc"]').each(function() {
                    $(this).rules('add', { ifsc: true });
                });

                form.find('input[name*="aadhaar"], input[name*="aadhar"]').each(function() {
                    $(this).rules('add', { aadhaar: true });
                });

                form.find('input[name*="vehicle"]').each(function() {
                    $(this).rules('add', { vehicle: true });
                });

                form.find('input[name="name"], input[name*="owner_name"], input[name*="firm_name"]').each(function() {
                    $(this).rules('add', { letters: true });
                });

                form.find('input[type="number"], input[name*="amount"], input[name*="price"], input[name*="qty"], input[name*="quantity"], input[name*="salary"], input[name*="rate"]').each(function() {
                    $(this).rules('add', {
                        number: true,
                        min: 0,
                        messages: {
                            number: "Please enter a valid number.",
                            min: "Value must be positive."
                        }
                    });
                });

                form.find('input[type="url"]').each(function() {
                    $(this).rules('add', { url: true });
                });

                form.find('input[type="password"]').each(function() {
                    if ($(this).attr('name') === 'password_confirmation' || $(this).attr('name') === 'password-confirm') {
                        const passwordField = form.find('input[name="password"]');
                        if (passwordField.length) {
                            $(this).rules('add', {
                                equalTo: passwordField,
                                messages: {
                                    equalTo: "Passwords do not match."
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
