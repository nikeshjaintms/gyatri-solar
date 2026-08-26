<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techno-commercial Offer - {{ $quotation->quotation_number }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --brand-navy: #002060;
            --brand-orange: #F58220;
            --brand-yellow: #FFC000;
            --text-dark: #000000;
            --text-muted: #000000;
            --border-color: #CBD5E1;
            --bg-light: #F8FAFC;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: #F1F5F9;
            color: var(--text-dark);
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .control-bar {
            max-width: 210mm;
            margin: 20px auto;
            background: #ffffff;
            padding: 12px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-secondary {
            background: #ffffff;
            color: var(--text-dark);
            border-color: #E2E8F0;
        }

        .btn-secondary:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f58220, #e06d0b);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(245, 130, 32, 0.3);
            border: none;
        }

        .btn-primary:hover {
            background: #e07216;
            transform: translateY(-1px);
        }

        /* Printable A4 Pages */
        .print-preview-container {
            width: 210mm;
            max-width: 210mm;
            margin: 20px auto 50px auto;
        }

        .proposal-page {
            background: #ffffff;
            width: 210mm;
            height: 297mm;
            min-height: 297mm;
            max-height: 297mm;
            position: relative;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            margin: 0 auto 30px auto;
            padding: 14mm 18mm 12mm 18mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
            overflow: hidden;
            page-break-inside: avoid;
            break-inside: avoid;
            page-break-after: always;
            break-after: page;
        }

        .proposal-page:last-child {
            margin-bottom: 0;
            page-break-after: avoid;
            break-after: avoid;
        }

        /* Header Style */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 2px solid var(--brand-orange);
            padding-bottom: 8px;
            margin-bottom: 18px;
            min-height: 60px;
        }

        .header-logo-left {
            display: flex;
            align-items: flex-end;
        }

        .header-logo-left img {
            height: 56px;
            max-width: 220px;
            object-fit: contain;
            display: block;
        }

        .header-logo-right {
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            text-align: right;
            height: 56px;
        }

        /* Footer Style */
        .page-footer {
            border-top: 1.5px solid #000000;
            padding-top: 6px;
            margin-top: auto;
            font-size: 0.74rem;
            color: #111827;
            text-align: center;
            line-height: 1.4;
            font-family: 'Outfit', 'Segoe UI', Arial, sans-serif;
        }

        .page-footer-address {
            font-size: 0.76rem;
            color: #111827;
            margin-bottom: 2px;
            font-weight: 500;
        }

        .page-footer-links {
            font-size: 0.74rem;
            color: #111827;
            margin-bottom: 2px;
        }

        .page-footer-phone {
            font-size: 0.74rem;
            font-weight: 600;
            color: #111827;
        }

        /* Common Typography */
        h2.section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.3rem;
            color: var(--brand-navy);
            margin-bottom: 16px;
            border-left: 4px solid var(--brand-orange);
            padding-left: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-date {
            text-align: right;
            font-weight: 600;
            margin-bottom: 16px;
            font-size: 0.92rem;
        }

        /* Tables styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 0.85rem;
        }

        .data-table th, .data-table td {
            border: 1px solid var(--border-color);
            padding: 8px 12px;
            text-align: left;
        }

        .data-table th {
            background-color: var(--brand-navy);
            color: #ffffff;
            font-weight: 600;
        }

        .data-table tr:nth-child(even) {
            background-color: var(--brand-gray);
        }

        /* Compact Features Table for Page 3 */
        .features-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            font-size: 0.72rem;
            line-height: 1.35;
        }

        .features-table th, .features-table td {
            border: 1px solid var(--border-color);
            padding: 5px 8px;
            text-align: left;
            vertical-align: middle;
        }

        .features-table th {
            background-color: var(--brand-navy);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.74rem;
            padding: 6px 8px;
        }

        .features-table tr:nth-child(even) {
            background-color: var(--brand-gray);
        }

        /* Lists */
        ul.bullet-list {
            padding-left: 20px;
            margin-bottom: 16px;
            line-height: 1.6;
            font-size: 0.88rem;
        }

        ul.bullet-list li {
            margin-bottom: 6px;
        }

        /* Welcome text block */
        .welcome-block {
            font-size: 0.90rem;
            line-height: 1.65;
            margin-bottom: 20px;
        }

        /* Highlight Boxes */
        .highlight-box {
            background: #fffbeb;
            border-left: 4px solid var(--brand-yellow);
            padding: 12px 15px;
            margin-bottom: 15px;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        /* Signatures block */
        .signatures-row {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .sig-block {
            width: 45%;
            font-size: 0.85rem;
        }

        .sig-line {
            border-top: 1px solid var(--text-dark);
            margin-top: 0;
            padding-top: 6px;
            font-weight: 700;
        }

        @page {
            size: A4 portrait;
            margin: 10mm 15mm 10mm 15mm;
        }

        @media print {
            html, body {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .control-bar {
                display: none !important;
            }
            .print-preview-container {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .proposal-page {
                width: 100% !important;
                height: 275mm !important;
                min-height: 275mm !important;
                max-height: 275mm !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
                box-sizing: border-box !important;
                page-break-after: always !important;
                break-after: page !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                overflow: hidden !important;
            }
            .proposal-page:last-child {
                page-break-after: avoid !important;
                break-after: avoid !important;
            }
        }
    </style>
</head>
<body>

    @php
        // Dynamically compute system size capacity value (e.g. 60.18)
        $capacityStr = $quotation->system_size ?? '60.18';
        preg_match('/[0-9.]+(?:\.[0-9]+)?/', $capacityStr, $matches);
        $capacity = isset($matches[0]) ? (float)$matches[0] : 60.18;
        if ($capacity <= 0) {
            $capacity = 60.18;
        }

        $panelMakeRaw = trim($quotation->panel_make ?? 'TATA POWER');
        $panelMakeUpper = strtoupper($panelMakeRaw);
    @endphp

    <!-- Control bar for screen view -->
    <div class="control-bar">
        <a href="{{ route('quotations.show', $quotation->id) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Details
        </a>
        <button id="downloadPdfBtn" onclick="downloadPDF()" class="btn btn-primary" style="background: linear-gradient(135deg, #10b981, #059669); border: none; font-weight: 700; font-size: 0.95rem; padding: 10px 26px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35); display: inline-flex; align-items: center; gap: 8px;">
            <i class="bi bi-download"></i> Download PDF
        </button>
    </div>

    <!-- Print pages container -->
    <div class="print-preview-container">

        <!-- ==================== PAGE 1 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 56px; max-width: 220px; object-fit: contain;">
                    </div>
                    @include('admin.quotations._right_logo')
                </div>

                <div class="meta-date">Date: {{ $quotation->quotation_date?->format('d/m/Y') ?? '12/06/2023' }}</div>

                <div class="welcome-block">
                    <p>To,</p>
                    <p style="font-weight: 700; font-size: 1rem; color: var(--brand-navy); margin-bottom: 3px;">{{ $quotation->customer?->name ?? 'ASIAN MARKETING' }}</p>
                    <p style="font-weight: 600; margin-bottom: 15px;">{{ $quotation->customer?->address ?? 'ANKLESHWAR GIDC' }}</p>

                    <p style="font-weight: 700; text-decoration: underline; margin-bottom: 14px; color: var(--brand-navy);">
                        Subject: - Techno-commercial offer for Supply, Installation and Commissioning of Solar PV Power Plant in your Industry.
                    </p>

                    <p>Dear Sir,</p>
                    <p style="margin-top: 6px;">
                        This refers to the telephonic conversation with you, kindly find the techno commercial offer for Ground-Mount {{ number_format($capacity * 2.674, 2) }}kW of solar PV power plant for your Industry.
                    </p>
                    <p style="font-weight: 700; font-size: 1.05rem; margin-top: 14px; margin-bottom: 15px;">
                        System Capacity: - <span style="color: var(--brand-orange)">{{ $quotation->system_size ?? '60.18Kwp' }}</span> Grid tied solar power plant.
                    </p>
                </div>

                <!-- Schematics Diagram -->
                <div style="display: flex; gap: 18px; margin: 15px 0 20px 0;">
                    <div style="flex: 1; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 14px; background: #f8fafc; text-align: center;">
                        <h4 style="font-size: 0.80rem; font-weight: 700; color: var(--brand-navy); margin-bottom: 8px; text-transform: uppercase;">Solar Panel to Inverter</h4>
                        <svg viewBox="0 0 200 90" style="width: 100%; height: 85px; display: block;">
                            <rect x="15" y="10" width="20" height="28" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1"/>
                            <line x1="25" y1="10" x2="25" y2="38" stroke="#ffffff" stroke-width="0.8"/>
                            <line x1="15" y1="24" x2="35" y2="24" stroke="#ffffff" stroke-width="0.8"/>

                            <rect x="42" y="10" width="20" height="28" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1"/>
                            <line x1="52" y1="10" x2="52" y2="38" stroke="#ffffff" stroke-width="0.8"/>
                            <line x1="42" y1="24" x2="62" y2="24" stroke="#ffffff" stroke-width="0.8"/>

                            <rect x="69" y="10" width="20" height="28" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1"/>
                            <line x1="79" y1="10" x2="79" y2="38" stroke="#ffffff" stroke-width="0.8"/>
                            <line x1="69" y1="24" x2="89" y2="24" stroke="#ffffff" stroke-width="0.8"/>

                            <rect x="15" y="46" width="20" height="28" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1"/>
                            <line x1="25" y1="46" x2="25" y2="74" stroke="#ffffff" stroke-width="0.8"/>
                            <line x1="15" y1="60" x2="35" y2="60" stroke="#ffffff" stroke-width="0.8"/>

                            <rect x="42" y="46" width="20" height="28" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1"/>
                            <line x1="52" y1="46" x2="52" y2="74" stroke="#ffffff" stroke-width="0.8"/>
                            <line x1="42" y1="60" x2="62" y2="60" stroke="#ffffff" stroke-width="0.8"/>

                            <rect x="69" y="46" width="20" height="28" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1"/>
                            <line x1="79" y1="46" x2="79" y2="74" stroke="#ffffff" stroke-width="0.8"/>
                            <line x1="69" y1="60" x2="89" y2="60" stroke="#ffffff" stroke-width="0.8"/>

                            <path d="M 90 24 L 130 24 L 130 38" fill="none" stroke="#64748b" stroke-width="1.2"/>
                            <path d="M 90 60 L 130 60 L 130 50" fill="none" stroke="#64748b" stroke-width="1.2"/>

                            <rect x="120" y="36" width="28" height="18" rx="3" fill="#334155" stroke="#0f172a" stroke-width="1"/>
                            <text x="134" y="48" fill="#ffffff" font-size="6" font-family="sans-serif" text-anchor="middle" font-weight="bold">Inverter</text>

                            <line x1="148" y1="45" x2="185" y2="45" stroke="#f58220" stroke-width="1.5"/>
                            <polygon points="185,42 192,45 185,48" fill="#f58220"/>
                        </svg>
                    </div>

                    <div style="flex: 1; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 14px; background: #f8fafc; text-align: center;">
                        <h4 style="font-size: 0.80rem; font-weight: 700; color: var(--brand-navy); margin-bottom: 8px; text-transform: uppercase;">PV Strings to Transformer</h4>
                        <svg viewBox="0 0 200 90" style="width: 100%; height: 85px; display: block;">
                            <rect x="10" y="8" width="36" height="12" rx="2" fill="#0284c7"/>
                            <text x="28" y="16.5" fill="#ffffff" font-size="5.5" font-family="sans-serif" text-anchor="middle">PV String</text>

                            <rect x="10" y="27" width="36" height="12" rx="2" fill="#0284c7"/>
                            <text x="28" y="35.5" fill="#ffffff" font-size="5.5" font-family="sans-serif" text-anchor="middle">PV String</text>

                            <rect x="10" y="46" width="36" height="12" rx="2" fill="#0284c7"/>
                            <text x="28" y="54.5" fill="#ffffff" font-size="5.5" font-family="sans-serif" text-anchor="middle">PV String</text>

                            <rect x="10" y="65" width="36" height="12" rx="2" fill="#0284c7"/>
                            <text x="28" y="73.5" fill="#ffffff" font-size="5.5" font-family="sans-serif" text-anchor="middle">PV String</text>

                            <rect x="75" y="8" width="28" height="12" rx="2" fill="#334155"/>
                            <text x="89" y="16.5" fill="#ffffff" font-size="5.5" font-family="sans-serif" text-anchor="middle">Inverter</text>

                            <rect x="75" y="27" width="28" height="12" rx="2" fill="#334155"/>
                            <text x="89" y="35.5" fill="#ffffff" font-size="5.5" font-family="sans-serif" text-anchor="middle">Inverter</text>

                            <rect x="75" y="46" width="28" height="12" rx="2" fill="#334155"/>
                            <text x="89" y="54.5" fill="#ffffff" font-size="5.5" font-family="sans-serif" text-anchor="middle">Inverter</text>

                            <rect x="75" y="65" width="28" height="12" rx="2" fill="#334155"/>
                            <text x="89" y="73.5" fill="#ffffff" font-size="5.5" font-family="sans-serif" text-anchor="middle">Inverter</text>

                            <rect x="135" y="8" width="20" height="69" rx="2" fill="#f58220"/>
                            <text x="145" y="45" fill="#ffffff" font-size="6" font-family="sans-serif" text-anchor="middle" transform="rotate(-90 145 45)" font-weight="bold">HT Panel</text>

                            <line x1="46" y1="14" x2="75" y2="14" stroke="#64748b" stroke-width="1"/>
                            <line x1="46" y1="33" x2="75" y2="33" stroke="#64748b" stroke-width="1"/>
                            <line x1="46" y1="52" x2="75" y2="52" stroke="#64748b" stroke-width="1"/>
                            <line x1="46" y1="71" x2="75" y2="71" stroke="#64748b" stroke-width="1"/>

                            <line x1="103" y1="14" x2="135" y2="14" stroke="#64748b" stroke-width="1"/>
                            <line x1="103" y1="33" x2="135" y2="33" stroke="#64748b" stroke-width="1"/>
                            <line x1="103" y1="52" x2="135" y2="52" stroke="#64748b" stroke-width="1"/>
                            <line x1="103" y1="71" x2="135" y2="71" stroke="#64748b" stroke-width="1"/>

                            <line x1="155" y1="42.5" x2="190" y2="42.5" stroke="#f58220" stroke-width="1.5"/>
                            <polygon points="187,39.5 194,42.5 187,45.5" fill="#f58220"/>
                        </svg>
                    </div>
                </div>

                <div class="welcome-block" style="margin-top: 15px;">
                    <p style="font-weight: 700; color: var(--brand-navy); font-size: 0.95rem;">Maintenance: -</p>
                    <p style="font-size: 0.88rem; margin-top: 4px;">
                        We will provide training of maintenance service free of cost. The process of maintenance contains Cleaning of solar panels and regularly check-up of voltage range.
                    </p>
                </div>
            </div>

            @include('admin.quotations._footer')
        </div>


        <!-- ==================== PAGE 2 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 56px; max-width: 220px; object-fit: contain;">
                    </div>
                    @include('admin.quotations._right_logo')
                </div>

                <h2 class="section-title">Part 1: Technical Specification Solar Panel</h2>
                
                <p style="font-weight: 700; color: var(--brand-navy); margin-bottom: 10px; font-size: 0.95rem;">Solar Panel Specification*</p>
                <table class="data-table" style="margin-bottom: 12px;">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Unit</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Open Circuit Voltage</td>
                            <td>V</td>
                            <td>{{ $quotation->panel_open_circuit_voltage ?? '52.31' }}</td>
                        </tr>
                        <tr>
                            <td>Maximum Voltage</td>
                            <td>V</td>
                            <td>{{ $quotation->panel_max_voltage ?? '43.71' }}</td>
                        </tr>
                        <tr>
                            <td>Short Circuit Current</td>
                            <td>A</td>
                            <td>{{ $quotation->panel_short_circuit_current ?? '14.11' }}</td>
                        </tr>
                        <tr>
                            <td>Maximum Current</td>
                            <td>A</td>
                            <td>{{ $quotation->panel_max_current ?? '13.27' }}</td>
                        </tr>
                        <tr>
                            <td>Power</td>
                            <td>WP</td>
                            <td>{{ $quotation->panel_watt_peak ?? '590 Wp' }}</td>
                        </tr>
                    </tbody>
                </table>
                <p style="font-size: 0.76rem; color: #475569; font-style: italic; margin-bottom: 20px;">*Solar Panel Specification may vary as per the availability</p>

                <p style="font-weight: 700; color: var(--brand-navy); margin-bottom: 10px; font-size: 0.95rem;">Inverter: -</p>
                <ul class="bullet-list" style="font-size: 0.86rem; line-height: 1.65;">
                    <li>Inbuilt Fuses and SPD (surge protection devices) for AC and DC.</li>
                    <li>LCD display on inverter. Protection provided:
                        <ol style="margin-left: 24px; margin-top: 6px; margin-bottom: 6px;">
                            <li>Short circuit</li>
                            <li>Insulation resistance to ground surveillance</li>
                            <li>Residual current protection</li>
                            <li>DC over voltage / current protection</li>
                        </ol>
                    </li>
                    <li>Module to module connection <strong>4 sq mm² cable</strong> provided.</li>
                    <li>MC4 connectors IP45 provided | As Per manufacturing warranty | Easy to operate.</li>
                </ul>
            </div>

            @include('admin.quotations._footer')
        </div>


        <!-- ==================== PAGE 3 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 56px; max-width: 220px; object-fit: contain;">
                    </div>
                    @include('admin.quotations._right_logo')
                </div>

                <h2 class="section-title" style="margin-bottom: 14px;">System Features :-</h2>
                
                <table class="features-table">
                    <thead>
                        <tr>
                            <th style="width: 17%;">Item</th>
                            <th style="width: 19%;">Make</th>
                            <th>Detail Specification</th>
                            <th style="width: 14%;">Value</th>
                            <th style="width: 14%;">Warranty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 700;">Solar Panel</td>
                            <td>{{ $quotation->panel_make ?? 'TATA' }}</td>
                            <td>{{ $quotation->panel_type ?? 'MonoBifacial' }}</td>
                            <td>{{ $quotation->panel_watt_peak ?? '590 Wp' }}</td>
                            <td>12 Year replacement, 30 Year performance</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Inverter</td>
                            <td>{{ $quotation->inverter_make ?? 'TATA' }}</td>
                            <td>String Inverters with IP 67 Standards</td>
                            <td>{{ $quotation->inverter_size ?? '1.00 kW' }}</td>
                            <td>{{ $quotation->warranty_inverter ?? '10 Year' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Module Mounting Structure</td>
                            <td>{{ $quotation->structure_height ?? 'Column Post-Ys 350, confirms to Gr E350A: IS 2062-2011' }}</td>
                            <td>{{ $quotation->structure_material ?? 'Suitable for module mounting to withstand wind of 150-180 kmph' }}</td>
                            <td>As per requirement</td>
                            <td>5 Years</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Cables</td>
                            <td>Tata Power Approved</td>
                            <td>
                                AC: {{ $quotation->cable_ac ?? 'Tinned copper, Aluminum Armored' }} (Qty: {{ $quotation->cable_ac_qty ?? '1' }})<br>
                                DC: {{ $quotation->cable_dc ?? 'Solar Cable' }} (Qty: {{ $quotation->cable_dc_qty ?? '1' }})<br>
                                Earthing: {{ $quotation->cable_earthing ?? 'Earthing Wire' }} (Qty: {{ $quotation->cable_earthing_qty ?? '2' }})<br>
                                LA: {{ $quotation->cable_la ?? 'LA Wire' }} (Qty: {{ $quotation->cable_la_qty ?? '1' }})
                            </td>
                            <td>As per requirement</td>
                            <td>As per Manufacturer</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Protection System</td>
                            @php
                                $protection = explode('|', $quotation->bos_protection_system ?? 'Schneider + Elmex | Surge Protecting Devices, MCCBs, Relays etc.');
                            @endphp
                            <td>{{ trim($protection[0] ?? 'Schneider + Elmex') }}</td>
                            <td>{{ trim($protection[1] ?? 'Surge Protecting Devices, MCCBs, Relays etc.') }}</td>
                            <td>As per requirement</td>
                            <td>As per Manufacturer</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">LT/ HT Panels</td>
                            @php
                                $ltht = explode('|', $quotation->bos_lt_ht_panels ?? 'Tata Power Approved | Air Circuit Breakers, Switching Devices, Bus Bars etc. RPR Not considered- if required that will be in client scope');
                            @endphp
                            <td>{{ trim($ltht[0] ?? 'Tata Power Approved') }}</td>
                            <td>{{ trim($ltht[1] ?? 'Air Circuit Breakers, Switching Devices, Bus Bars etc. RPR Not considered- if required that will be in client scope') }}</td>
                            <td>Not required</td>
                            <td>As per Manufacturer</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Earthing</td>
                            <td>Maintenance free Chemical Standard</td>
                            <td>{{ $quotation->bos_earthing ?? 'As per Design Requirements' }}</td>
                            <td>Module & Structure earthing with LA</td>
                            <td>As per Manufacturer</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Lightning Arrester</td>
                            <td>Tata Power Approved</td>
                            <td>{{ $quotation->bos_la ?? 'ESE Type Lightning Arrester' }}</td>
                            <td>As per Requirement</td>
                            <td>As per Manufacturer</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Metering</td>
                            @php
                                $metering = explode('|', $quotation->bos_metering ?? 'SECURE/HPL/L&T | As per Solar Policy');
                            @endphp
                            <td>{{ trim($metering[0] ?? 'SECURE/HPL/L&T') }}</td>
                            <td>{{ trim($metering[1] ?? 'As per Solar Policy') }}</td>
                            <td>As per requirement</td>
                            <td>As per Manufacturer</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">ACDB - 5in1out</td>
                            @php
                                $acdb = explode('|', $quotation->bos_acdb ?? 'L&T/ Schneider/ siemens | 1 in 1 Out - IP65 rated');
                            @endphp
                            <td>{{ trim($acdb[0] ?? 'L&T/ Schneider/ siemens') }}</td>
                            <td>{{ trim($acdb[1] ?? '1 in 1 Out - IP65 rated') }}</td>
                            <td>1</td>
                            <td>As per Manufacturer</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @include('admin.quotations._footer')
        </div>


        <!-- ==================== PAGE 4 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 56px; max-width: 220px; object-fit: contain;">
                    </div>
                    @include('admin.quotations._right_logo')
                </div>

                <h2 class="section-title" style="margin-bottom: 12px; font-size: 1.25rem;">Performance of Plant (Approx.)</h2>
                
                <ul class="bullet-list" style="font-size: 0.82rem; line-height: 1.55; margin-bottom: 14px;">
                    <li>Electricity generation/kW/Day = <strong>4.5 kWh</strong> (Pv-syst P90 report attached)</li>
                    <li>Electricity generation for {{ $capacity }} kW/Day = <strong>{{ number_format($capacity * 4.5, 2) }} kWh</strong></li>
                    <li>Electricity generation/kW/year = <strong>1642.5 kWh</strong></li>
                    <li>Total Generation in one year = <strong>{{ $quotation->savings_yearly_generation ?? number_format($capacity * 4.5 * 365, 1) . ' kWh' }}</strong></li>
                    <li>Cost of Electricity per kWh = <strong>6.5 Rs/kWh</strong></li>
                    <li>Total Saving per Year = <strong>{{ $quotation->savings_annual_savings ?? 'Rs. ' . number_format($capacity * 4.5 * 365 * 6.5, 2) }}</strong></li>
                    <li>Return On Investment = Project Cost / Yearly Savings = <strong>{{ $quotation->savings_payback ?? number_format((($capacity * 28700 * 1.05) + ($capacity * 12300 * 1.18)) / ($capacity * 4.5 * 365 * 6.5), 1) . ' Years' }}</strong></li>
                </ul>

                <h2 class="section-title" style="margin-top: 14px; margin-bottom: 12px; font-size: 1.25rem;">Part 2: Commercial Offer</h2>
                <table class="data-table" style="font-size: 0.78rem; margin-bottom: 10px;">
                    <thead>
                        <tr>
                            <th style="padding: 6px 8px; width: 5%;">No</th>
                            <th style="padding: 6px 8px;">Specification</th>
                            <th style="padding: 6px 8px; width: 18%;">Price INR/kW</th>
                            <th style="padding: 6px 8px; width: 10%;">GST</th>
                            <th style="padding: 6px 8px; width: 25%;">Estimated Amount in INR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 700; text-align: center; padding: 5px 7px;">A</td>
                            <td style="padding: 5px 7px;">
                                <strong>Supply of solar power generating kit from Tata Power</strong>
                                <div style="font-size: 0.72rem; color: #334155; margin-top: 2px;">• Modules &amp; Structure &nbsp;|&nbsp; • Inverters &amp; ACDB &nbsp;|&nbsp; • Monitoring, DC Cables, I&amp;C Kit</div>
                            </td>
                            <td style="padding: 5px 7px;">28,700/-</td>
                            <td style="padding: 5px 7px;">5%</td>
                            <td style="font-weight: 700; text-align: right; padding: 5px 7px;">{{ number_format($capacity * 28700 * 1.05, 2) }}/-</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700; text-align: center; padding: 5px 7px;">B</td>
                            <td style="padding: 5px 7px;">
                                <strong>Installation and commissioning of solar plant By Gayatri Solar Energy</strong>
                                <div style="font-size: 0.72rem; color: #334155; margin-top: 2px;">• GEDA liasoning, Earthing kit, LA &nbsp;|&nbsp; • Lugs, Cable Tray, Inverter Stand, Grouting</div>
                            </td>
                            <td style="padding: 5px 7px;">12,300/-</td>
                            <td style="padding: 5px 7px;">18%</td>
                            <td style="font-weight: 700; text-align: right; padding: 5px 7px;">{{ number_format($capacity * 12300 * 1.18, 2) }}/-</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700; text-align: center; padding: 5px 7px;">C</td>
                            <td style="padding: 5px 7px;">
                                <strong>Scope of:- {{ $quotation->customer?->name ?? 'ASIAN MARKETING' }}</strong>
                                <div style="font-size: 0.72rem; color: #334155; margin-top: 2px;">• GEDA Fee &amp; Meter Charge &nbsp;|&nbsp; • Liasoning Work (CAG approval) &nbsp;|&nbsp; • AC cables to LT panel</div>
                            </td>
                            <td style="padding: 5px 7px;">NA</td>
                            <td style="padding: 5px 7px;">NA</td>
                            <td style="font-weight: 700; text-align: center; padding: 5px 7px;">NA</td>
                        </tr>
                        @php
                            $subtotalA = $capacity * 28700 * 1.05;
                            $subtotalB = $capacity * 12300 * 1.18;
                            $grandTotal = $subtotalA + $subtotalB;
                            $weightedGst = (($grandTotal - ($capacity * 41000)) / ($capacity * 41000)) * 100;
                        @endphp
                        <tr style="background-color: #FEF3C7; font-weight: 800;">
                            <td style="text-align: center; padding: 5px 7px;">D</td>
                            <td style="padding: 5px 7px;">Total (A+B)</td>
                            <td style="padding: 5px 7px;">41,000/-</td>
                            <td style="padding: 5px 7px;">{{ number_format($weightedGst, 1) }}%</td>
                            <td style="text-align: right; padding: 5px 7px;">{{ $quotation->savings_project_cost ?? number_format($grandTotal, 2) }}/-</td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top: 10px; margin-bottom: 0;">
                    <p style="font-weight: 700; text-decoration: underline; margin-bottom: 4px; font-size: 0.90rem; color: #000000;">NOTE:</p>
                    <ul style="margin-left: 20px; font-size: 0.80rem; line-height: 1.45; color: #DC2626; font-weight: 700;">
                        <li>• GEDA Registration fees would be extra at actual 15340/-</li>
                        <li>• Mgvcl Net Meter &amp; Testing charge would be extra at actual 1,40,000/- approx.</li>
                        <li>• All invoices will be generated in the name of client and directly paid by client</li>
                    </ul>
                </div>
            </div>

            @include('admin.quotations._footer')
        </div>


        <!-- ==================== PAGE 5 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 56px; max-width: 220px; object-fit: contain;">
                    </div>
                    @include('admin.quotations._right_logo')
                </div>

                <h2 class="section-title">Terms &amp; Conditions</h2>

                <p style="font-weight: 700; text-decoration: underline; margin-top: 15px; margin-bottom: 12px; font-size: 1.02rem; color: #000000;">General Terms and Conditions :-</p>
                <ol style="margin-left: 22px; font-size: 0.86rem; line-height: 1.75;">
                    <li style="color: #DC2626; font-weight: 700; margin-bottom: 8px;">GST is Inclusive in above quoted price (On supply part 5% and on service part 18%)</li>
                    <li style="margin-bottom: 8px;">Bi Directional METER &amp; Testing charges are <strong>Excluding</strong> in above quoted price.</li>
                    <li style="margin-bottom: 8px;">Price mentioned above <strong>includes</strong> compliances for Electrical Distribution Authority, State Nodal Agencies (GEDA) and Electrical Inspector.</li>
                    <li style="margin-bottom: 8px;">Impact of any duty, taxes, basic custom duty as imposed by government shall be in <strong>client’s scope</strong>.</li>
                    <li style="margin-bottom: 8px;">We are not liable for delay in work due to delay in any Govt. procedures.</li>
                    <li style="margin-bottom: 8px;">Client need to take care of any local issues if arise. Any obstacle/damage caused by local body/authority which resulting in delay of work, we will be granted extra time accordingly and not held responsible for damage.</li>
                    <li style="margin-bottom: 8px;">Land levelling and tree cutting will be in client scope.</li>
                </ol>

                <h3 style="font-size: 1.02rem; color: var(--brand-navy); margin-top: 25px; margin-bottom: 12px; font-weight: 700;">Warranty: -</h3>
                <ol style="margin-left: 22px; font-size: 0.86rem; line-height: 1.75;">
                    <li style="margin-bottom: 8px;"><strong>{{ $quotation->warranty_system ?? '5 Years' }}</strong> warranty on whole system.</li>
                    <li style="margin-bottom: 8px;"><strong>Performance Warranty</strong> on Solar Panels is as below:
                        <ul style="margin-left: 20px; margin-top: 4px; margin-bottom: 4px;">
                            <li>Up to <strong>90% output</strong> for first 10 years.</li>
                            <li>Up to <strong>80% output</strong> for rest 15 years.</li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 8px;"><strong>{{ $quotation->warranty_inverter ?? '10 Years' }}</strong> Replacement warranty on Inverter.</li>
                    <li style="margin-bottom: 8px;"><strong>{{ $quotation->warranty_panel ?? '12 Years' }}</strong> Replacement warranty on Solar Panels in manufacturing &amp; Technical Defects.</li>
                </ol>
            </div>

            @include('admin.quotations._footer')
        </div>


        <!-- ==================== PAGE 6 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 56px; max-width: 220px; object-fit: contain;">
                    </div>
                    @include('admin.quotations._right_logo')
                </div>

                <h3 style="font-size: 1.05rem; color: var(--brand-navy); margin-top: 15px; margin-bottom: 12px; font-weight: 700;">Project Execution Timeline :</h3>
                <ul class="bullet-list" style="font-size: 0.86rem; line-height: 1.75; margin-bottom: 25px;">
                    <li style="margin-bottom: 8px;"><strong>Material Delivery:</strong> 3 to 4 Weeks from the date of Advance received and site clearance.</li>
                    <li style="margin-bottom: 8px;"><strong>Installation &amp; Commissioning:</strong> 2 to 3 Weeks after complete material delivery at site.</li>
                    <li style="margin-bottom: 8px;"><strong>Net Metering &amp; Grid Synchronization:</strong> Subject to DISCOM / CEI approval process.</li>
                </ul>

                <h3 style="font-size: 1.05rem; color: var(--brand-navy); margin-top: 25px; margin-bottom: 12px; font-weight: 700;">Validity of Quotation :</h3>
                <p style="font-size: 0.86rem; margin-bottom: 25px; line-height: 1.75;">
                    This offer is valid up to <strong>{{ $quotation->valid_until?->format('d/m/Y') ?? '30 Days' }}</strong> from the date of issue. Prices are subject to revision thereafter.
                </p>

                <h3 style="font-size: 1.05rem; color: var(--brand-navy); margin-top: 25px; margin-bottom: 12px; font-weight: 700;">Payment Terms &amp; Condition :</h3>
                <ul class="bullet-list" style="font-size: 0.86rem; line-height: 1.75;">
                    <li style="margin-bottom: 8px;"><strong>A) For the Material Supply Part from TATA</strong> - 85% on first dispatch of material Against material readiness mail from TATA to {{ $quotation->customer?->name ?? 'ASIAN MARKETING' }}</li>
                    <li style="margin-bottom: 8px;"><strong>B) For installation and commissioning from channel Partner (Gayatri Solar)</strong> - 10% on installation time and 5% after commissioning done by Gayatri Solar.</li>
                </ul>
            </div>

            @include('admin.quotations._footer')
        </div>


        <!-- ==================== PAGE 7 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 56px; max-width: 220px; object-fit: contain;">
                    </div>
                    @include('admin.quotations._right_logo')
                </div>

                <p style="font-weight: 700; text-decoration: underline; margin-bottom: 10px; font-size: 0.95rem; color: var(--brand-navy);">Warranty – Exclusion and Limitation :-</p>
                <ul class="bullet-list" style="font-size: 0.78rem; line-height: 1.45; color: var(--text-dark); margin-bottom: 15px;">
                    <li style="margin-bottom: 6px;">Warranty should be claimed within the applicable warranty period of the concerned part claimed by the manufacturer and it should be claimed by or claim on behalf of original buyer of solar power plant.</li>
                    <li style="margin-bottom: 6px;">Limited product warranty does not cover damages done by any natural calamities, fire, war, epidemic, riot, insurrection. It covers only normal use. Damage caused during transportation or alteration done after commissioning of plant without consent of GAYATRI SOLAR ENERGY (TATA POWER SOLAR) are not covered in this warranty.</li>
                    <li style="margin-bottom: 6px;">All the queries or breakdown will be resolved earliest by GAYATRI SOLAR ENERGY (TATA POWER SOLAR) and their associates, there could be delays due to factors beyond the control of GAYATRI SOLAR ENERGY (TATA POWER SOLAR) and should not be held responsible for the delay caused by original manufacturer/third party vendor or customer representative.</li>
                    <li style="margin-bottom: 6px;">Service or repair after the standard warranty period is subject to GAYATRI SOLAR ENERGY (TATA POWER SOLAR) or Original part manufacturer price and terms, repaired/replaced part is warranted for the residual warranty time remains in the original warranty.</li>
                    <li style="margin-bottom: 6px;">GAYATRI SOLAR ENERGY (TATA POWER SOLAR) should not be held responsible for the down time due to equipment error or inappropriate handling of the power plant.</li>
                </ul>

                <p style="font-style: italic; font-weight: 600; font-size: 0.90rem; text-align: center; color: var(--brand-navy); margin: 16px 0;">
                    “We hope our techno-commercial offer fulfils your requirements in all aspects. We request you to kindly give us an opportunity to serve your esteemed organization.”
                </p>

                <div style="margin-top: 14px; font-size: 0.85rem; line-height: 1.45;">
                    <p>Thanking You,</p>
                    <p style="font-weight: 700; margin-top: 6px;">Yours Faithfully,</p>
                    <p style="font-weight: 800; font-size: 0.92rem; color: var(--brand-navy); margin-top: 2px;">{{ $quotation->created_by_name ?? 'VIBHU H. PATEL' }}</p>
                    <p>M : +91 {{ $quotation->created_by_phone ?? '88667 78940' }}</p>
                    <strong style="color: var(--brand-orange)">GAYATRI SOLAR ENERGY</strong><br>
                    <span>AUTHORIZED CHANNEL PARTNER</span><br>
                    <strong>TATA POWER SOLAR</strong><br>
                    <span>GSTIN : {{ $quotation->bank_gst_no ?? '24CTRPP6745D1ZA' }}</span>
                </div>

                <div class="signatures-row" style="margin-top: 12px;">
                    <div class="sig-block">
                        <div style="height: 65px; display: flex; align-items: flex-end; justify-content: flex-start; padding-bottom: 2px;">
                            @if(!empty($quotation->signature_image))
                                <img src="{{ asset('storage/' . $quotation->signature_image) }}" alt="Authorized Signature" style="max-height: 65px; max-width: 220px; height: 58px; width: auto; object-fit: contain; display: block;">
                            @endif
                        </div>
                        <div class="sig-line" style="margin-top: 0;">Authorized Signatory</div>
                        <span style="font-size: 0.75rem; color: var(--text-dark);">Gyatri Solar Energy</span>
                    </div>
                    <div class="sig-block">
                        <div style="height: 65px;"></div>
                        <div class="sig-line" style="margin-top: 0;">Customer Signatory</div>
                        <span style="font-size: 0.75rem; color: var(--text-dark);">{{ $quotation->customer?->name ?? 'ASIAN MARKETING' }}</span>
                    </div>
                </div>
            </div>

            @include('admin.quotations._footer')
        </div>

    </div>

    <!-- CDN scripts for Direct 1-Click Page-by-Page PDF Download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        async function downloadPDF() {
            const btn = document.getElementById('downloadPdfBtn');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Downloading PDF...';
            btn.disabled = true;

            try {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'p',
                    unit: 'mm',
                    format: 'a4',
                    compress: true
                });

                const pages = document.querySelectorAll('.proposal-page');

                for (let i = 0; i < pages.length; i++) {
                    const page = pages[i];
                    const canvas = await html2canvas(page, {
                        scale: 2,
                        useCORS: true,
                        logging: false,
                        backgroundColor: '#ffffff'
                    });

                    const imgData = canvas.toDataURL('image/jpeg', 0.96);
                    if (i > 0) {
                        pdf.addPage('a4', 'p');
                    }
                    pdf.addImage(imgData, 'JPEG', 0, 0, 210, 297, undefined, 'FAST');
                }

                pdf.save('Quotation_{{ str_replace(['/', '\\'], '-', $quotation->quotation_number) }}.pdf');
            } catch (err) {
                console.error('PDF Generation Error:', err);
                alert('An error occurred while generating PDF. Please try again.');
            } finally {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
