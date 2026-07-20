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
            max-width: 820px;
            margin: 20px auto;
            background: #ffffff;
            padding: 15px 25px;
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
            padding: 10px 20px;
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
            background: var(--brand-orange);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(245, 130, 32, 0.2);
        }

        .btn-primary:hover {
            background: #e07216;
            transform: translateY(-1px);
        }

        /* Printable A4 Pages */
        .print-preview-container {
            max-width: 820px;
            margin: 0 auto 50px auto;
        }

        .proposal-page {
            background: #ffffff;
            width: 100%;
            height: 1160px; /* A4 Ratio */
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            padding: 50px 50px 70px 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
        }

        /* Header Style */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--brand-orange);
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header-logo-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .gyatri-logo-mark {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--brand-orange), var(--brand-yellow));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.8rem;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            box-shadow: 0 4px 10px rgba(245, 130, 32, 0.3);
        }

        .gyatri-logo-text h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--brand-navy);
            line-height: 1.1;
        }

        .gyatri-logo-text span {
            font-size: 0.75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--brand-orange);
        }

        .header-logo-right {
            text-align: right;
        }

        .tata-logo-text {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 1.4rem;
            color: #008ccf;
            letter-spacing: 0.5px;
        }

        .tata-logo-text span.tata {
            color: #1e3a8a;
        }

        .tata-logo-text span.power {
            color: #0284c7;
        }

        .tata-solaroof {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--brand-orange);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: -3px;
        }

        /* Footer Style */
        .page-footer {
            border-top: 1px solid var(--border-color);
            padding-top: 12px;
            font-size: 0.75rem;
            color: var(--text-dark);
            text-align: center;
            line-height: 1.4;
        }

        .page-footer-contact {
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--brand-navy);
        }

        .page-number-indicator {
            float: right;
            font-weight: 700;
            color: var(--brand-orange);
        }

        /* Common Typography */
        h2.section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            color: var(--brand-navy);
            margin-bottom: 20px;
            border-left: 4px solid var(--brand-orange);
            padding-left: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-date {
            text-align: right;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        /* Tables styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        .data-table th, .data-table td {
            border: 1px solid #94A3B8;
            padding: 10px 12px;
            text-align: left;
        }

        .data-table th {
            background-color: #E2E8F0;
            color: var(--brand-navy);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .data-table tr:nth-child(even) td {
            background-color: #F8FAFC;
        }

        /* Custom Content Areas */
        .welcome-block {
            margin-bottom: 20px;
        }

        .welcome-block p {
            margin-bottom: 12px;
            font-size: 0.9rem;
            text-align: justify;
        }

        /* Diagrams Page 1 */
        .schematics-container {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            justify-content: space-between;
        }

        .schematic-box {
            width: 48%;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            background: #F8FAFC;
            text-align: center;
        }

        .schematic-box h4 {
            font-size: 0.8rem;
            color: var(--brand-navy);
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: 700;
        }

        /* SVG styles */
        .svg-dia {
            width: 100%;
            height: 120px;
        }

        /* Bullet lists */
        .bullet-list {
            margin-left: 20px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        .bullet-list li {
            margin-bottom: 8px;
        }

        .highlight-box {
            background: #EFF6FF;
            border-left: 4px solid #3B82F6;
            padding: 15px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        /* Signatures block */
        .signatures-row {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .sig-block {
            width: 45%;
            font-size: 0.85rem;
        }

        .sig-line {
            border-top: 1px solid var(--text-dark);
            margin-top: 50px;
            padding-top: 8px;
            font-weight: 700;
        }

        @media print {
            body {
                background: #ffffff;
            }
            .control-bar {
                display: none !important;
            }
            .print-preview-container {
                max-width: 100%;
                margin: 0;
            }
            .proposal-page {
                box-shadow: none;
                margin-bottom: 0;
                page-break-after: always;
                break-after: page;
                height: 100vh;
                padding: 40px 40px 60px 40px;
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
    @endphp

    <!-- Control bar for screen view -->
    <div class="control-bar">
        <a href="{{ route('quotations.show', $quotation->id) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Details
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Print / Save PDF
        </button>
    </div>

    <!-- Print pages container -->
    <div class="print-preview-container">

        <!-- ==================== PAGE 1 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 52px; object-fit: contain; margin-bottom: 2px;">
                    </div>
                    <div class="header-logo-right">
                        <div class="tata-logo-text"><span class="tata">TATA</span> <span class="power">POWER</span></div>
                        <div class="tata-solaroof">SOLAROOF</div>
                    </div>
                </div>

                <div class="meta-date">Date: {{ $quotation->quotation_date?->format('d/m/Y') ?? '12/06/2023' }}</div>

                <div class="welcome-block">
                    <p>To,</p>
                    <p style="font-weight: 700; font-size: 1rem; color: var(--brand-navy); margin-bottom: 2px;">{{ $quotation->customer?->name ?? 'ASIAN MARKETING' }}</p>
                    <p style="font-weight: 600; margin-bottom: 15px;">{{ $quotation->customer?->address ?? 'ANKLESHWAR GIDC' }}</p>

                    <p style="font-weight: 700; text-decoration: underline; margin-bottom: 15px; color: var(--brand-navy);">
                        Subject: - Techno-commercial offer for Supply, Installation and Commissioning of Solar PV Power Plant in your Industry.
                    </p>

                    <p>Dear Sir,</p>
                    <p>
                        This refers to the telephonic conversation with you, kindly find the techno commercial offer for Ground-Mount {{ number_format($capacity * 2.674, 2) }}kW of solar PV power plant for your Industry.
                    </p>
                    <p style="font-weight: 700; font-size: 1.05rem; margin-top: 15px; margin-bottom: 15px;">
                        System Capacity: - <span style="color: var(--brand-orange)">{{ $quotation->system_size ?? '60.18Kwp' }}</span> Grid tied solar power plant.
                    </p>
                </div>

                <!-- Schematics Diagram -->
                <div class="schematics-container">
                    <div class="schematic-box">
                        <h4>Solar Panel to Inverter</h4>
                        <svg class="svg-dia" viewBox="0 0 200 120">
                            <!-- Panels -->
                            <rect x="10" y="20" width="22" height="35" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1.5"/>
                            <line x1="21" y1="20" x2="21" y2="55" stroke="#ffffff" stroke-width="1"/>
                            <line x1="10" y1="37" x2="32" y2="37" stroke="#ffffff" stroke-width="1"/>
                            
                            <rect x="40" y="20" width="22" height="35" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1.5"/>
                            <line x1="51" y1="20" x2="51" y2="55" stroke="#ffffff" stroke-width="1"/>
                            <line x1="40" y1="37" x2="62" y2="37" stroke="#ffffff" stroke-width="1"/>

                            <rect x="70" y="20" width="22" height="35" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1.5"/>
                            <line x1="81" y1="20" x2="81" y2="55" stroke="#ffffff" stroke-width="1"/>
                            <line x1="70" y1="37" x2="92" y2="37" stroke="#ffffff" stroke-width="1"/>

                            <rect x="10" y="65" width="22" height="35" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1.5"/>
                            <line x1="21" y1="65" x2="21" y2="100" stroke="#ffffff" stroke-width="1"/>
                            <line x1="10" y1="82" x2="32" y2="82" stroke="#ffffff" stroke-width="1"/>
                            
                            <rect x="40" y="65" width="22" height="35" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1.5"/>
                            <line x1="51" y1="65" x2="51" y2="100" stroke="#ffffff" stroke-width="1"/>
                            <line x1="40" y1="82" x2="62" y2="82" stroke="#ffffff" stroke-width="1"/>

                            <rect x="70" y="65" width="22" height="35" rx="2" fill="#0284c7" stroke="#1e3a8a" stroke-width="1.5"/>
                            <line x1="81" y1="65" x2="81" y2="100" stroke="#ffffff" stroke-width="1"/>
                            <line x1="70" y1="82" x2="92" y2="82" stroke="#ffffff" stroke-width="1"/>

                            <text x="51" y="12" font-size="8" text-anchor="middle" font-weight="700">Solar Panels</text>

                            <!-- Connections -->
                            <path d="M 95 37 L 140 37 L 140 50" fill="none" stroke="#64748b" stroke-width="1.5"/>
                            <path d="M 95 82 L 140 82 L 140 70" fill="none" stroke="#64748b" stroke-width="1.5"/>

                            <!-- Inverter -->
                            <rect x="125" y="50" width="30" height="20" rx="3" fill="#334155" stroke="#0f172a" stroke-width="1.5"/>
                            <text x="140" y="62" fill="#ffffff" font-size="7" text-anchor="middle" font-weight="600">Inverter</text>
                            
                            <!-- Output -->
                            <line x1="155" y1="60" x2="190" y2="60" stroke="#f58220" stroke-width="1.5"/>
                        </svg>
                    </div>

                    <div class="schematic-box">
                        <h4>PV Strings to Transformer</h4>
                        <svg class="svg-dia" viewBox="0 0 200 120">
                            <!-- PV Strings -->
                            <rect x="10" y="15" width="40" height="12" rx="2" fill="#0284c7"/>
                            <text x="30" y="24" fill="#ffffff" font-size="7" text-anchor="middle">PV String</text>
                            
                            <rect x="10" y="40" width="40" height="12" rx="2" fill="#0284c7"/>
                            <text x="30" y="49" fill="#ffffff" font-size="7" text-anchor="middle">PV String</text>
                            
                            <rect x="10" y="65" width="40" height="12" rx="2" fill="#0284c7"/>
                            <text x="30" y="74" fill="#ffffff" font-size="7" text-anchor="middle">PV String</text>
                            
                            <rect x="10" y="90" width="40" height="12" rx="2" fill="#0284c7"/>
                            <text x="30" y="99" fill="#ffffff" font-size="7" text-anchor="middle">PV String</text>

                            <!-- Inverters -->
                            <rect x="75" y="15" width="30" height="12" rx="2" fill="#334155"/>
                            <text x="90" y="24" fill="#ffffff" font-size="6" text-anchor="middle">Inverter</text>
                            
                            <rect x="75" y="40" width="30" height="12" rx="2" fill="#334155"/>
                            <text x="90" y="49" fill="#ffffff" font-size="6" text-anchor="middle">Inverter</text>
                            
                            <rect x="75" y="65" width="30" height="12" rx="2" fill="#334155"/>
                            <text x="90" y="74" fill="#ffffff" font-size="6" text-anchor="middle">Inverter</text>
                            
                            <rect x="75" y="90" width="30" height="12" rx="2" fill="#334155"/>
                            <text x="90" y="99" fill="#ffffff" font-size="6" text-anchor="middle">Inverter</text>

                            <!-- HT Panel -->
                            <rect x="130" y="15" width="20" height="87" rx="2" fill="#f58220"/>
                            <text x="140" y="60" fill="#ffffff" font-size="7" text-anchor="middle" transform="rotate(-90 140 60)">HT Panel</text>

                            <!-- Connections -->
                            <line x1="50" y1="21" x2="75" y2="21" stroke="#64748b" stroke-width="1"/>
                            <line x1="50" y1="46" x2="75" y2="46" stroke="#64748b" stroke-width="1"/>
                            <line x1="50" y1="71" x2="75" y2="71" stroke="#64748b" stroke-width="1"/>
                            <line x1="50" y1="96" x2="75" y2="96" stroke="#64748b" stroke-width="1"/>

                            <line x1="105" y1="21" x2="130" y2="21" stroke="#64748b" stroke-width="1"/>
                            <line x1="105" y1="46" x2="130" y2="46" stroke="#64748b" stroke-width="1"/>
                            <line x1="105" y1="71" x2="130" y2="71" stroke="#64748b" stroke-width="1"/>
                            <line x1="105" y1="96" x2="130" y2="96" stroke="#64748b" stroke-width="1"/>

                            <!-- To Transformer -->
                            <line x1="150" y1="58" x2="170" y2="58" stroke="#1e3a8a" stroke-width="1.5"/>
                            <rect x="170" y="48" width="25" height="20" rx="2" fill="#1e3a8a"/>
                            <text x="182" y="60" fill="#ffffff" font-size="5" text-anchor="middle">XFMR</text>
                        </svg>
                    </div>
                </div>

                <div class="welcome-block" style="margin-top: 15px;">
                    <p style="font-weight: 700; color: var(--brand-navy);">Maintenance: -</p>
                    <p style="font-size: 0.85rem;">
                        We will provide training of maintenance service free of cost. The process of maintenance contains Cleaning of solar panels and regularly check-up of voltage range.
                    </p>
                </div>
            </div>

            <div class="page-footer">
                <div class="page-footer-contact">REGD. OFFICE: Plot No. 162, Phase-2 Beside New Safari, Nr. Mipko Chokdi, Narmadanagar, Bharuch, Gujarat 392015</div>
                Email: Info@gayatrisolarenergy.com | Website: WWW.Gayatrisolarenergy.com | Mo: 8866778940 / 6357293251
                <span class="page-number-indicator">Page 1</span>
            </div>
        </div>


        <!-- ==================== PAGE 2 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 52px; object-fit: contain; margin-bottom: 2px;">
                    </div>
                    <div class="header-logo-right">
                        <div class="tata-logo-text"><span class="tata">TATA</span> <span class="power">POWER</span></div>
                        <div class="tata-solaroof">SOLAROOF</div>
                    </div>
                </div>

                <h2 class="section-title">Part 1: Technical Specification Solar Panel</h2>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-bottom: 10px; font-weight: 700;">Solar Panel Specification*</h3>
                <table class="data-table">
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
                            <td>{{ $quotation->panel_watt_peak ?? '590+' }}</td>
                        </tr>
                    </tbody>
                </table>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 25px; font-style: italic;">
                    *Solar Panel Specification may vary as per the availability
                </p>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-bottom: 10px; font-weight: 700;">Inverter: -</h3>
                <ul class="bullet-list">
                    <li>Inbuilt Fuses and SPD (surge protection devices) for AC and DC.</li>
                    <li>LCD display on inverter. Protection provided:
                        <ol style="margin-left: 20px; margin-top: 5px;">
                            <li>Short circuit</li>
                            <li>Insulation resistance to ground surveillance</li>
                            <li>Residual current protection</li>
                            <li>DC over voltage / current protection</li>
                        </ol>
                    </li>
                    <li>Module to module connection <strong>4 sq mm² cable</strong> provided.</li>
                    <li>MC4 connectors IP45 provided | As Per manufacturing warranty | Easy to operate.</li>
                </ul>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-top: 25px; margin-bottom: 10px; font-weight: 700;">System Features :-</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Make</th>
                            <th>Detail Specification</th>
                            <th>Value</th>
                            <th>Warranty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 700;">Solar Panel</td>
                            <td>{{ $quotation->panel_make ?? 'TATA POWER' }}</td>
                            <td>{{ $quotation->panel_type ?? 'Latest Technology Half Cut Mono Perc' }}</td>
                            <td>{{ $quotation->panel_watt_peak ?? '590+' }} Wp</td>
                            <td>{{ $quotation->warranty_panel ?? '12 years' }} replacement, {{ $quotation->warranty_performance ?? '30 years' }} performance</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="page-footer">
                <div class="page-footer-contact">REGD. OFFICE: Plot No. 162, Phase-2 Beside New Safari, Nr. Mipko Chokdi, Narmadanagar, Bharuch, Gujarat 392015</div>
                Email: Info@gayatrisolarenergy.com | Website: WWW.Gayatrisolarenergy.com | Mo: 8866778940 / 6357293251
                <span class="page-number-indicator">Page 2</span>
            </div>
        </div>


        <!-- ==================== PAGE 3 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 52px; object-fit: contain; margin-bottom: 2px;">
                    </div>
                    <div class="header-logo-right">
                        <div class="tata-logo-text"><span class="tata">TATA</span> <span class="power">POWER</span></div>
                        <div class="tata-solaroof">SOLAROOF</div>
                    </div>
                </div>

                <h2 class="section-title">System Features (Continued)</h2>
                <table class="data-table" style="font-size: 0.78rem;">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Make</th>
                            <th>Detail Specification</th>
                            <th>Value</th>
                            <th>Warranty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 700;">Inverter</td>
                            <td>{{ $quotation->inverter_make ?? 'TATA Approved Make (Solis/Sofar/Goodwe)' }}</td>
                            <td>String Inverters with IP 67 Standards</td>
                            <td>{{ $quotation->inverter_size ?? 'As per requirement' }}</td>
                            <td>{{ $quotation->warranty_inverter ?? '10 Years' }}</td>
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

            <div class="page-footer">
                <div class="page-footer-contact">REGD. OFFICE: Plot No. 162, Phase-2 Beside New Safari, Nr. Mipko Chokdi, Narmadanagar, Bharuch, Gujarat 392015</div>
                Email: Info@gayatrisolarenergy.com | Website: WWW.Gayatrisolarenergy.com | Mo: 8866778940 / 6357293251
                <span class="page-number-indicator">Page 3</span>
            </div>
        </div>


        <!-- ==================== PAGE 4 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 52px; object-fit: contain; margin-bottom: 2px;">
                    </div>
                    <div class="header-logo-right">
                        <div class="tata-logo-text"><span class="tata">TATA</span> <span class="power">POWER</span></div>
                        <div class="tata-solaroof">SOLAROOF</div>
                    </div>
                </div>

                <h2 class="section-title">Performance of Plant (Approx.) &amp; Commercial Offer</h2>
                
                <ul class="bullet-list" style="font-size: 0.9rem; line-height: 1.8;">
                    <li>Electricity generation/kW/Day = <strong>4.5 kWh</strong> (Pv-syst P90 report attached)</li>
                    <li>Electricity generation for {{ $capacity }} kW/Day = <strong>{{ number_format($capacity * 4.5, 2) }} kWh</strong></li>
                    <li>Electricity generation/kW/year = <strong>1642.5 kWh</strong></li>
                    <li>Total Generation in one year = <strong>{{ $quotation->savings_yearly_generation ?? number_format($capacity * 4.5 * 365, 1) . ' kWh' }}</strong></li>
                    <li>Cost of Electricity per kWh = <strong>{{ $quotation->per_kw_rate ? '6.5 Rs/kWh' : '6.5 Rs/kWh' }}</strong></li>
                    <li>Total Saving per Year = <strong>{{ $quotation->savings_annual_savings ?? 'Rs. ' . number_format($capacity * 4.5 * 365 * 6.5, 2) }}</strong></li>
                    <li>Return On Investment = Project Cost / Yearly Savings = <strong>{{ $quotation->savings_payback ?? number_format((($capacity * 28700 * 1.05) + ($capacity * 12300 * 1.18)) / ($capacity * 4.5 * 365 * 6.5), 1) . ' Years' }}</strong></li>
                </ul>

                <h2 class="section-title" style="margin-top: 30px;">Part 2: Commercial Offer</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Specification</th>
                            <th>Price INR/kW</th>
                            <th>GST</th>
                            <th>Estimated Amount in INR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 700; text-align: center;">A</td>
                            <td>
                                <strong>Supply of solar power generating kit from Tata Power</strong>
                                <ul style="margin-left: 20px; font-size: 0.75rem; margin-top: 5px;">
                                    <li>Modules &amp; Structure</li>
                                    <li>Inverters &amp; ACDB</li>
                                    <li>Monitoring setup, DC Cables, I&amp;C Kit</li>
                                </ul>
                            </td>
                            <td>28,700/-</td>
                            <td>5%</td>
                            <td style="font-weight: 700; text-align: right;">{{ number_format($capacity * 28700 * 1.05, 2) }}/-</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700; text-align: center;">B</td>
                            <td>
                                <strong>Installation and commissioning of solar plant By Gayatri Solar Energy</strong>
                                <ul style="margin-left: 20px; font-size: 0.75rem; margin-top: 5px;">
                                    <li>GEDA liasoning Work, Earthing kit &amp; lightning arrestor</li>
                                    <li>Lugs, Cable Tray/ Cable Tie, Inverter Stand</li>
                                    <li>Structure mounting with solar PV installation with Grouting</li>
                                </ul>
                            </td>
                            <td>12,300/-</td>
                            <td>18%</td>
                            <td style="font-weight: 700; text-align: right;">{{ number_format($capacity * 12300 * 1.18, 2) }}/-</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700; text-align: center;">C</td>
                            <td>
                                <strong>Scope of:- {{ $quotation->customer?->name ?? 'ASIAN MARKETING' }}</strong>
                                <ul style="margin-left: 20px; font-size: 0.75rem; margin-top: 5px;">
                                    <li>GEDA Fee &amp; Meter Charge</li>
                                    <li>Liasoning Work (CAG approval, lab test of meter)</li>
                                    <li>AC cables from ACDB to LT panel</li>
                                </ul>
                            </td>
                            <td>NA</td>
                            <td>NA</td>
                            <td style="font-weight: 700; text-align: center;">NA</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="page-footer">
                <div class="page-footer-contact">REGD. OFFICE: Plot No. 162, Phase-2 Beside New Safari, Nr. Mipko Chokdi, Narmadanagar, Bharuch, Gujarat 392015</div>
                Email: Info@gayatrisolarenergy.com | Website: WWW.Gayatrisolarenergy.com | Mo: 8866778940 / 6357293251
                <span class="page-number-indicator">Page 4</span>
            </div>
        </div>


        <!-- ==================== PAGE 5 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 52px; object-fit: contain; margin-bottom: 2px;">
                    </div>
                    <div class="header-logo-right">
                        <div class="tata-logo-text"><span class="tata">TATA</span> <span class="power">POWER</span></div>
                        <div class="tata-solaroof">SOLAROOF</div>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Specification</th>
                            <th>Price INR/kW</th>
                            <th>GST</th>
                            <th>Estimated Amount in INR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotalA = $capacity * 28700 * 1.05;
                            $subtotalB = $capacity * 12300 * 1.18;
                            $grandTotal = $subtotalA + $subtotalB;
                            $weightedGst = (($grandTotal - ($capacity * 41000)) / ($capacity * 41000)) * 100;
                        @endphp
                        <tr style="background-color: #FEF3C7; font-weight: 800;">
                            <td style="text-align: center;">D</td>
                            <td>Total (A+B)</td>
                            <td>41,000/-</td>
                            <td>{{ number_format($weightedGst, 1) }}%</td>
                            <td style="text-align: right;">{{ $quotation->savings_project_cost ?? number_format($grandTotal, 2) }}/-</td>
                        </tr>
                    </tbody>
                </table>

                <div class="highlight-box" style="background: #FFFBEB; border-left-color: #F59E0B; margin-top: 15px;">
                    <strong style="color: #B45309;">NOTE:</strong>
                    <ul style="margin-left: 15px; margin-top: 5px; font-size: 0.8rem;">
                        <li>GEDA Registration fees would be extra at actual 15340</li>
                        <li>Dgvcl Net Meter &amp; Testing charge would be extra at actual 75,000/- approx.</li>
                        <li>All invoices will be generated in the name of client and directly paid by client</li>
                    </ul>
                </div>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-top: 20px; margin-bottom: 10px; font-weight: 700;">General Terms and Conditions :-</h3>
                <ol style="margin-left: 20px; font-size: 0.8rem; line-height: 1.6;">
                    <li>GST is Inclusive in above quoted price <strong>(On supply part 5% and on service part 18%)</strong></li>
                    <li>Bi Directional METER &amp; Testing charges are <strong>Excluding</strong> in above quoted price.</li>
                    <li>Price mentioned above <strong>includes</strong> compliances for Electrical Distribution Authority, State Nodal Agencies (GEDA) and Electrical Inspector.</li>
                    <li>Impact of any duty, taxes, basic custom duty as imposed by government shall be in <strong>client’s scope</strong>.</li>
                    <li>We are not liable for delay in work due to delay in any Govt. procedures.</li>
                    <li>Client need to take care of any local issues if arise. Any obstacle/damage caused by local body/authority which resulting in delay of work, we will be granted extra time accordingly and not held responsible for damage.</li>
                    <li>Land levelling and tree cutting will be in client scope.</li>
                </ol>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-top: 20px; margin-bottom: 10px; font-weight: 700;">Warranty: -</h3>
                <ol style="margin-left: 20px; font-size: 0.8rem; line-height: 1.6;">
                    <li><strong>{{ $quotation->warranty_system ?? '5 Years' }}</strong> warranty on whole system.</li>
                    <li><strong>Performance Warranty</strong> on Solar Panels is as below:
                        <ul style="margin-left: 20px;">
                            <li>Up to <strong>90% output</strong> for first 10 years.</li>
                            <li>Up to <strong>80% output</strong> for rest 15 years.</li>
                        </ul>
                    </li>
                    <li><strong>{{ $quotation->warranty_inverter ?? '10 Years' }}</strong> Replacement warranty on Inverter.</li>
                    <li><strong>{{ $quotation->warranty_panel ?? '12 Years' }}</strong> Replacement warranty on Solar Panels in manufacturing &amp; Technical Defects.</li>
                </ol>
            </div>

            <div class="page-footer">
                <div class="page-footer-contact">REGD. OFFICE: Plot No. 162, Phase-2 Beside New Safari, Nr. Mipko Chokdi, Narmadanagar, Bharuch, Gujarat 392015</div>
                Email: Info@gayatrisolarenergy.com | Website: WWW.Gayatrisolarenergy.com | Mo: 8866778940 / 6357293251
                <span class="page-number-indicator">Page 5</span>
            </div>
        </div>


        <!-- ==================== PAGE 6 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 52px; object-fit: contain; margin-bottom: 2px;">
                    </div>
                    <div class="header-logo-right">
                        <div class="tata-logo-text"><span class="tata">TATA</span> <span class="power">POWER</span></div>
                        <div class="tata-solaroof">SOLAROOF</div>
                    </div>
                </div>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-bottom: 10px; font-weight: 700;">Project completion timeline :-</h3>
                <p style="font-size: 0.85rem; margin-bottom: 15px; text-align: justify;">
                    Considering all necessary approvals from concerned state agencies at various stages, procurement of project materials, Installation work and process of Net Meter agreement, the total project completion time will take around 3-4 months approx.
                </p>
                <div class="highlight-box" style="background: #FEF2F2; border-left-color: #EF4444; font-size: 0.8rem; margin-bottom: 25px;">
                    <strong>Note:</strong> We will not be liable for any further delay in getting approvals from Govt. Authorities and will be granted relaxation in project completion timeline.
                </div>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-bottom: 10px; font-weight: 700;">Validity :-</h3>
                <p style="font-size: 0.85rem; margin-bottom: 15px;">
                    1) Total cost is subjected to change as per system design &amp; time duration.
                </p>
                <p style="font-size: 0.85rem; color: #EF4444; font-weight: 600; margin-bottom: 25px;">
                    (As per current Global market scenario, High price escalation in raw material &amp; Material shortage we are bound to give you above quotation validity for 7 Days).
                </p>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-bottom: 10px; font-weight: 700;">Payment Terms &amp; Condition :</h3>
                <ul class="bullet-list" style="font-size: 0.85rem; line-height: 1.6;">
                    <li><strong>A) For the Material Supply Part from TATA</strong> - 85% on first dispatch of material Against material readiness mail from TATA to {{ $quotation->customer?->name ?? 'ASIAN MARKETING' }}</li>
                    <li><strong>B) For installation and commissioning from channel Partner (Gayatri Solar)</strong> - 10% on installation time and 5% after commissioning done by Gayatri Solar.</li>
                </ul>

                <h3 style="font-size: 1rem; color: var(--brand-navy); margin-top: 30px; margin-bottom: 10px; font-weight: 700;">Warranty – Exclusion and Limitation :-</h3>
                <ul class="bullet-list" style="font-size: 0.8rem; line-height: 1.5; color: var(--text-muted);">
                    <li>Warranty should be claimed within the applicable warranty period of the concerned part claimed by the manufacturer and it should be claimed by or claim on behalf of original buyer of solar power plant.</li>
                    <li>Limited product warranty does not cover damages done by any natural calamities, fire, war, epidemic, riot, insurrection. It covers only normal use. Damage caused during transportation or alteration done after commissioning of plant without consent of GAYATRI SOLAR ENERGY (TATA POWER SOLAR) are not covered in this warranty.</li>
                    <li>All the queries or breakdown will be resolved earliest by GAYATRI SOLAR ENERGY (TATA POWER SOLAR) and their associates, there could be delays due to factors beyond the control of GAYATRI SOLAR ENERGY (TATA POWER SOLAR) and should not be held responsible for the delay caused by original manufacturer/third party vendor or customer representative.</li>
                </ul>
            </div>

            <div class="page-footer">
                <div class="page-footer-contact">REGD. OFFICE: Plot No. 162, Phase-2 Beside New Safari, Nr. Mipko Chokdi, Narmadanagar, Bharuch, Gujarat 392015</div>
                Email: Info@gayatrisolarenergy.com | Website: WWW.Gayatrisolarenergy.com | Mo: 8866778940 / 6357293251
                <span class="page-number-indicator">Page 6</span>
            </div>
        </div>


        <!-- ==================== PAGE 7 ==================== -->
        <div class="proposal-page">
            <div>
                <div class="page-header">
                    <div class="header-logo-left">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Gyatri Solar Energy" style="height: 52px; object-fit: contain; margin-bottom: 2px;">
                    </div>
                    <div class="header-logo-right">
                        <div class="tata-logo-text"><span class="tata">TATA</span> <span class="power">POWER</span></div>
                        <div class="tata-solaroof">SOLAROOF</div>
                    </div>
                </div>

                <ul class="bullet-list" style="font-size: 0.85rem; line-height: 1.6; color: var(--text-muted); margin-bottom: 30px;">
                    <li>Service or repair after the standard warranty period is subject to GAYATRI SOLAR ENERGY (TATA POWER SOLAR) or Original part manufacturer price and terms, repaired/replaced part is warranted for the residual warranty time remains in the original warranty.</li>
                    <li>GAYATRI SOLAR ENERGY (TATA POWER SOLAR) should not be held responsible for the down time due to equipment error or inappropriate handling of the power plant.</li>
                </ul>

                <p style="font-style: italic; font-weight: 600; font-size: 1rem; text-align: center; color: var(--brand-navy); margin: 50px 0;">
                    “We hope our techno-commercial offer fulfils your requirements in all aspects. We request you to kindly give us an opportunity to serve your esteemed organization.”
                </p>

                <div style="margin-top: 40px; font-size: 0.9rem; line-height: 1.6;">
                    <p>Thanking You,</p>
                    <p style="font-weight: 700; margin-top: 15px;">Yours Faithfully,</p>
                    <p style="font-weight: 800; font-size: 1rem; color: var(--brand-navy); margin-top: 5px;">{{ $quotation->created_by_name ?? 'VIBHU H. PATEL' }}</p>
                    <p>M : +91 {{ $quotation->created_by_phone ?? '88667 78940' }}</p>
                    <strong style="color: var(--brand-orange)">GAYATRI SOLAR ENERGY</strong><br>
                    <span>AUTHORIZED CHANNEL PARTNER</span><br>
                    <strong>TATA POWER SOLAR</strong><br>
                    <span>GSTIN : {{ $quotation->bank_gst_no ?? '24CTRPP6745D1ZA' }}</span>
                </div>

                <div class="signatures-row" style="margin-top: 60px;">
                    <div class="sig-block">
                        <div class="sig-line">Authorized Signatory</div>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Gyatri Solar Energy</span>
                    </div>
                    <div class="sig-block">
                        <div class="sig-line">Customer Signatory</div>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $quotation->customer?->name ?? 'ASIAN MARKETING' }}</span>
                    </div>
                </div>
            </div>

            <div class="page-footer">
                <div class="page-footer-contact">REGD. OFFICE: Plot No. 162, Phase-2 Beside New Safari, Nr. Mipko Chokdi, Narmadanagar, Bharuch, Gujarat 392015</div>
                Email: Info@gayatrisolarenergy.com | Website: WWW.Gayatrisolarenergy.com | Mo: 8866778940 / 6357293251
                <span class="page-number-indicator">Page 7</span>
            </div>
        </div>

    </div>

    <!-- Automatically open print dialog -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 1000);
        });
    </script>
</body>
</html>
