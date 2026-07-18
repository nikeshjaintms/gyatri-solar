<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal: {{ $quotation->quotation_number }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --brand-yellow: #FFC000;
            --brand-orange: #F58220;
            --brand-dark: #002060;
            --text-dark: #000000;
            --text-muted: #4B5563;
            --border-color: #000000;
            --light-bg: #F8FAFC;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background-color: #F1F5F9;
            color: var(--text-dark);
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Screen view wrapper */
        .print-preview-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 0;
        }

        .control-bar {
            max-width: 900px;
            margin: 20px auto;
            background: #ffffff;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-secondary {
            background: #ffffff;
            color: var(--text-dark);
            border-color: #CBD5E1;
        }

        .btn-secondary:hover {
            background: #F1F5F9;
        }

        .btn-primary {
            background: var(--brand-orange);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #d66b13;
        }

        /* Proposal Pages styling */
        .proposal-page {
            background: #ffffff;
            width: 100%;
            height: 1270px; /* A4 Ratio */
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            margin-bottom: 30px;
            padding: 70px 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Diagonal Cover Shapes */
        .p1-top-yellow {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 230px;
            background: var(--brand-yellow);
            clip-path: polygon(0 0, 100% 0, 100% 100%);
            z-index: 1;
        }

        /* Header Logo */
        .proposal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 10;
        }

        .logo-img-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-sun-symbol {
            width: 45px;
            height: 45px;
            background: var(--brand-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.6rem;
            position: relative;
        }

        .logo-text-details h2 {
            font-family: 'Arial Black', sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--brand-dark);
            line-height: 1.1;
        }

        .logo-text-details span {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--brand-dark);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .logo-tagline {
            font-family: 'Georgia', serif;
            font-style: italic;
            font-size: 0.75rem;
            color: #DC2626;
            margin-top: 2px;
        }

        /* Page 1: Cover Page */
        .p1-proposal-title-section {
            margin-top: 130px;
            z-index: 10;
        }

        .p1-kw-badge {
            font-size: 3.2rem;
            font-weight: 900;
            color: var(--text-dark);
            line-height: 1;
            margin-bottom: 5px;
        }

        .p1-solar-proposal-text {
            font-family: 'Arial Black', sans-serif;
            font-size: 4rem;
            font-weight: 900;
            color: var(--brand-yellow);
            text-transform: uppercase;
            line-height: 1.1;
        }

        .p1-divider-line {
            width: 140px;
            height: 3px;
            background: #94A3B8;
            margin: 20px 0;
        }

        .p1-meta-details {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
            font-weight: 600;
        }

        .p1-footer-flex {
            display: flex;
            margin-top: auto;
            z-index: 5;
            height: 480px;
            margin-left: -60px;
            margin-right: -60px;
            margin-bottom: -70px;
        }

        .p1-yellow-info-card {
            background: #FFC000;
            width: 45%;
            padding: 50px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: var(--text-dark);
        }

        .p1-yellow-info-card h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .p1-yellow-info-card p {
            font-size: 0.95rem;
            margin-bottom: 2px;
        }

        .p1-cover-image {
            width: 55%;
            background: #CBD5E1;
            clip-path: polygon(25% 0%, 100% 0%, 100% 100%, 0% 100%);
            overflow: hidden;
        }

        .p1-cover-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Page 2: Welcome Letter */
        .p2-diagonal-image {
            position: absolute;
            top: 0;
            right: 0;
            width: 48%;
            height: 450px;
            background: var(--brand-yellow);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 30% 100%);
            z-index: 1;
            overflow: hidden;
        }

        .p2-diagonal-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .welcome-content-area {
            margin-top: 100px;
            z-index: 10;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-right: 40px;
        }

        .welcome-title-h1 {
            font-family: 'Arial Black', sans-serif;
            font-size: 3.8rem;
            font-weight: 900;
            color: #334155;
            margin-bottom: 40px;
        }

        .welcome-salutation-text {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .welcome-body-paragraph {
            font-size: 0.95rem;
            line-height: 1.8;
            color: #334155;
            margin-bottom: 20px;
            text-align: justify;
        }

        /* Page 3: Offer & Financial Schedule */
        .page-offer-title {
            font-family: 'Arial Black', sans-serif;
            font-size: 3.5rem;
            color: var(--brand-yellow);
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .offer-header-info {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--brand-yellow);
            padding-bottom: 5px;
        }

        .clean-pricing-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .clean-pricing-table th, .clean-pricing-table td {
            border: 1px solid var(--border-color);
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .clean-pricing-table th {
            background: #E2E8F0;
            font-weight: 700;
        }

        .clean-pricing-table td.amount {
            text-align: right;
            font-weight: 700;
        }

        .cash-loan-terms {
            margin-bottom: 25px;
            font-size: 0.85rem;
            line-height: 1.6;
        }

        .cash-loan-terms h5 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .bank-details-grid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 4px;
        }

        .bank-details-info h5 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .bank-details-info p {
            font-size: 0.85rem;
            margin-bottom: 3px;
        }

        .bank-details-info strong {
            font-weight: 700;
        }

        .qr-image-placeholder {
            width: 100px;
            height: 100px;
            border: 1px solid #CBD5E1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #475569;
        }

        /* Page 4: Bill of Materials */
        .bom-blocks-layout {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 15px;
            flex-grow: 1;
        }

        .bom-section-card {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 15px 20px;
        }

        .bom-section-card h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 3px;
        }

        .bom-items-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .bom-grid-item {
            font-size: 0.8rem;
        }

        .bom-grid-item span {
            display: block;
        }

        .bom-grid-item span.lbl {
            color: #475569;
            margin-bottom: 2px;
        }

        .bom-grid-item span.val {
            font-weight: 700;
        }

        .bom-flex-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px dashed #CBD5E1;
            padding-top: 10px;
            margin-top: 10px;
        }

        /* Page 5: Balance of System & Warranty */
        .bos-items-list {
            margin-top: 20px;
            margin-bottom: 35px;
        }

        .bos-items-list h4 {
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .bos-list-item-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #E2E8F0;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .bos-list-item-row:last-child {
            border-bottom: none;
        }

        .bos-list-item-lbl {
            font-weight: 700;
            width: 180px;
            flex-shrink: 0;
        }

        .bos-list-item-val {
            color: #334155;
        }

        .warranty-layout-box h4 {
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .warranty-grid-quad {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .warranty-quad-card {
            border: 1px solid var(--border-color);
            padding: 15px;
            text-align: center;
        }

        .warranty-quad-card span.lbl {
            font-size: 0.75rem;
            color: #475569;
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .warranty-quad-card span.val {
            font-size: 1.25rem;
            font-weight: 700;
        }

        /* Page 6: Scope of Work */
        .scope-page-layout {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .scope-list-block h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 3px;
        }

        .scope-list-block ol {
            padding-left: 20px;
        }

        .scope-list-block ol li {
            font-size: 0.85rem;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .scope-notes-block {
            border: 1px solid var(--border-color);
            padding: 15px 20px;
            background: #F8FAFC;
        }

        .scope-notes-block h5 {
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .scope-notes-block p {
            font-size: 0.8rem;
            line-height: 1.5;
        }

        /* Page 7: Savings */
        .savings-header-block {
            margin-top: 30px;
        }

        .savings-h1-kw {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .savings-h1-title {
            font-family: 'Arial Black', sans-serif;
            font-size: 4rem;
            font-weight: 900;
            color: var(--brand-yellow);
        }

        .savings-hex-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 35px;
            flex-grow: 1;
        }

        .savings-hex-card {
            border: 1px solid var(--border-color);
            padding: 30px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .savings-hex-card i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--brand-orange);
        }

        .savings-hex-card span.lbl {
            font-size: 0.8rem;
            color: #475569;
            margin-bottom: 5px;
        }

        .savings-hex-card span.val {
            font-size: 1.35rem;
            font-weight: 700;
        }

        /* Page 8: Visual Savings Guide Chart */
        .chart-card-wrapper {
            margin-top: 40px;
            border: 1px solid var(--border-color);
            padding: 40px;
            height: 480px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .chart-y-axis-labels {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 350px;
            color: #475569;
            font-size: 0.8rem;
            padding-right: 15px;
            border-right: 1px solid var(--border-color);
        }

        .chart-plot-graphic {
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            height: 350px;
            flex-grow: 1;
            padding-left: 15px;
            position: relative;
        }

        .chart-background-lines {
            position: absolute;
            left: 15px;
            right: 0;
            top: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            pointer-events: none;
            z-index: 1;
        }

        .chart-bg-line-item {
            width: 100%;
            height: 1px;
            background: #E2E8F0;
        }

        .chart-bar-pillar-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 6%;
            z-index: 10;
        }

        .chart-bar-pillar-val {
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .chart-bar-pillar {
            width: 100%;
            background: var(--brand-yellow);
            border: 1px solid var(--border-color);
            transition: height 0.5s;
        }

        .chart-bar-pillar-label {
            font-size: 0.75rem;
            color: #475569;
            margin-top: 10px;
            font-weight: 600;
        }

        /* Page 9: Signatures & Contact Footer */
        .signatures-flex-row {
            display: flex;
            justify-content: space-between;
            margin-top: 120px;
            padding: 0 30px;
        }

        .signature-signing-block {
            text-align: center;
            width: 240px;
        }

        .signature-line-divider {
            width: 100%;
            height: 1px;
            background: var(--border-color);
            margin-bottom: 8px;
        }

        .signature-signing-label {
            font-size: 0.9rem;
            font-weight: 700;
        }

        .signature-stamp-circle {
            width: 90px;
            height: 90px;
            border: 1px dashed #94A3B8;
            margin: 0 auto 20px auto;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: #94A3B8;
            font-weight: 700;
        }

        .footer-yellow-contact-bleed {
            background: #FFC000;
            margin: auto -60px -70px -60px;
            padding: 45px 60px;
        }

        .footer-yellow-contact-bleed h4 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .contact-details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            font-size: 0.9rem;
        }

        .contact-grid-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-grid-info-item i {
            font-size: 1.1rem;
        }

        /* Pagination & Document Footer details */
        .page-meta-footer-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            padding-top: 12px;
            z-index: 10;
        }

        /* Print media breaks */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
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
                padding: 60px 45px;
            }

            .footer-yellow-contact-bleed {
                margin: auto -45px -60px -45px;
                padding: 35px 45px;
            }
        }
    </style>
</head>
<body>

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

        <!-- ==================== PAGE 1: COVER PAGE ==================== -->
        <div class="proposal-page">
            <div class="p1-top-yellow"></div>
            
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div class="p1-proposal-title-section">
                <div class="p1-kw-badge">{{ $quotation->system_size }}</div>
                <div class="p1-solar-proposal-text">SOLAR<br><span style="color: var(--brand-dark);">PROPOSAL</span></div>
                <div class="p1-divider-line"></div>
                <div class="p1-meta-details">
                    Date: {{ $quotation->quotation_date?->format('d-m-Y') ?? '—' }}<br>
                    No: #{{ $quotation->quotation_number }}<br>
                    Valid Till: {{ $quotation->valid_until?->format('d-m-Y') ?? '—' }}
                </div>
            </div>

            <div class="p1-footer-flex">
                <div class="p1-yellow-info-card">
                    <h4>For,</h4>
                    <p style="font-weight: 700; font-size: 1.05rem;">{{ $quotation->customer?->name ?? '—' }}</p>
                    <p>{{ $quotation->customer?->address ?? '—' }}</p>
                    <p>Phone: {{ $quotation->customer?->phone ?? '—' }}</p>
                    
                    <h4 style="margin-top: 20px;">By,</h4>
                    <p style="font-weight: 700; font-size: 1.05rem;">{{ $quotation->created_by_name }}</p>
                    <p>{{ $quotation->created_by_phone }}</p>
                </div>
                <div class="p1-cover-image">
                    <img src="https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=800&q=80" alt="Solar Panels">
                </div>
            </div>
        </div>


        <!-- ==================== PAGE 2: WELCOME LETTER ==================== -->
        <div class="proposal-page">
            <div class="p2-diagonal-image">
                <img src="https://images.unsplash.com/photo-1620052581237-5d36667be337?auto=format&fit=crop&w=800&q=80" alt="Installers">
            </div>
            
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div class="welcome-content-area">
                <h1 class="welcome-title-h1">WELCOME</h1>
                <div class="welcome-salutation-text">Dear {{ $quotation->customer?->name ?? 'Customer' }},</div>
                <p class="welcome-body-paragraph">
                    It has been a privilege to understand your requirement and give you the best solution for you. As required, we have committed to the highest level of quality. That's why we select the best components and industry-leading performance models to ensure your system will produce optimally.
                </p>
                <p class="welcome-body-paragraph">
                    Our highly trained installation crews take pride in delivering beautiful well-made solar arrays. From the panels to the bolts on the roof, we'll deliberately consider every piece of your installation so you can rest easy throughout its many years of service. We take great pride in our guarantee of complete customer satisfaction.
                </p>
                <p class="welcome-body-paragraph">
                    We are looking forward to help you and have a long-term relationship with you. Please go through the proposal and give us your feedback.
                </p>
                
                <div style="margin-top: 20px; font-size: 0.95rem; line-height: 1.6;">
                    <p>Thank You,</p>
                    <strong>Delicate Solar Pvt. Ltd.</strong>
                </div>
            </div>

            <div class="page-meta-footer-bar">
                <span>Proposal Reference: {{ $quotation->quotation_number }}</span>
                <span>Page 2</span>
            </div>
        </div>


        <!-- ==================== PAGE 3: OFFER ==================== -->
        <div class="proposal-page">
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div>
                <h1 class="page-offer-title">OFFER</h1>
                <div class="offer-header-info">
                    Price Quote &amp; Payment schedule for {{ $quotation->system_size }} Grid Tie Rooftop Solar System:
                </div>

                <table class="clean-pricing-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="width: 250px; text-align: right;">Amount (INR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Per kW Rate</td>
                            <td class="amount">₹{{ $quotation->per_kw_rate }}</td>
                        </tr>
                        <tr>
                            <td>Rooftop ON-Grid Solar Power Plant System</td>
                            <td class="amount">₹{{ $quotation->rooftop_amount }}</td>
                        </tr>
                        <tr>
                            <td>Net-Metering Cost</td>
                            <td class="amount">₹{{ $quotation->net_metering_cost }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Grand Total Cost Of The Project</td>
                            <td class="amount">₹{{ $quotation->rooftop_amount }}</td>
                        </tr>
                        <tr>
                            <td>MNRE Subsidy</td>
                            <td class="amount">₹{{ $quotation->mnre_subsidy }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800; font-size: 0.95rem;">Final Effective Cost to Customer After Subsidy</td>
                            <td class="amount" style="font-weight: 800; font-size: 0.95rem;">₹{{ $quotation->final_effective_cost }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="cash-loan-terms">
                    <h5>Payment Terms</h5>
                    <p><strong>1. Cash:-</strong> 1) Token Amount: 5000/- &nbsp;&nbsp; 2) Before Structure Material Dispatch: 20000/- &nbsp;&nbsp; 3) Before Panel &amp; Inverter Dispatch: Pending Amount</p>
                    <p style="margin-top: 5px;"><strong>2. Loan:-</strong> 1) Down Payment: 10% of Project Cost</p>
                </div>

                <div class="bank-details-grid">
                    <div class="bank-details-info">
                        <h5 style="margin-bottom: 12px; font-weight: 700;">Bank Details</h5>
                        <p><strong>Bank Name:</strong> {{ $quotation->bank_name }}</p>
                        <p><strong>Name:</strong> {{ $quotation->bank_account_name }}</p>
                        <p><strong>Account No:</strong> {{ $quotation->bank_account_no }}</p>
                        <p><strong>IFSC Code:</strong> {{ $quotation->bank_ifsc }}</p>
                        <p><strong>Branch:</strong> {{ $quotation->bank_branch }}</p>
                        <p><strong>GST No:</strong> {{ $quotation->bank_gst_no }}</p>
                    </div>
                    <div class="qr-image-placeholder">
                        <i class="bi bi-qr-code"></i>
                    </div>
                </div>
            </div>

            <div class="page-meta-footer-bar">
                <span>Proposal Reference: {{ $quotation->quotation_number }}</span>
                <span>Page 3</span>
            </div>
        </div>


        <!-- ==================== PAGE 4: BILL OF MATERIALS ==================== -->
        <div class="proposal-page">
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div style="flex-grow: 1; display: flex; flex-direction: column;">
                <h1 class="page-offer-title" style="font-size: 3.2rem;">BILL OF MATERIALS</h1>
                
                <div class="bom-blocks-layout">
                    <!-- Panel Section -->
                    <div class="bom-section-card">
                        <h4>Panel</h4>
                        <div class="bom-items-grid">
                            <div class="bom-grid-item">
                                <span class="lbl">Watt Peak:</span>
                                <span class="val">{{ $quotation->panel_watt_peak }}</span>
                            </div>
                            <div class="bom-grid-item">
                                <span class="lbl">Panel Qty:</span>
                                <span class="val">{{ $quotation->panel_qty }}</span>
                            </div>
                            <div class="bom-grid-item">
                                <span class="lbl">Panel Type:</span>
                                <span class="val">{{ $quotation->panel_type }}</span>
                            </div>
                            <div class="bom-grid-item">
                                <span class="lbl">Panel Make:</span>
                                <span class="val">{{ $quotation->panel_make }}</span>
                            </div>
                        </div>
                        <div class="bom-flex-row">
                            <span style="font-size: 0.8rem; font-weight: 700;">TATA POWER</span>
                        </div>
                    </div>

                    <!-- Inverter Section -->
                    <div class="bom-section-card">
                        <h4>Inverter</h4>
                        <div class="bom-items-grid">
                            <div class="bom-grid-item">
                                <span class="lbl">Inverter Size:</span>
                                <span class="val">{{ $quotation->inverter_size }}</span>
                            </div>
                            <div class="bom-grid-item">
                                <span class="lbl">Inverter Qty:</span>
                                <span class="val">{{ $quotation->inverter_qty }}</span>
                            </div>
                            <div class="bom-grid-item">
                                <span class="lbl">Inverter Make:</span>
                                <span class="val">{{ $quotation->inverter_make }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cables Section -->
                    <div class="bom-section-card">
                        <h4>Cables</h4>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                                <span><strong>AC Cable:</strong> {{ $quotation->cable_ac }}</span>
                                <span style="font-weight: 700;">Qty: {{ $quotation->cable_ac_qty }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                                <span><strong>DC Cable:</strong> {{ $quotation->cable_dc }}</span>
                                <span style="font-weight: 700;">Qty: {{ $quotation->cable_dc_qty }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                                <span><strong>Earthing Cable:</strong> {{ $quotation->cable_earthing }}</span>
                                <span style="font-weight: 700;">Qty: {{ $quotation->cable_earthing_qty }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                                <span><strong>LA Cable:</strong> {{ $quotation->cable_la }}</span>
                                <span style="font-weight: 700;">Qty: {{ $quotation->cable_la_qty }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Structure Section -->
                    <div class="bom-section-card">
                        <h4>Structure</h4>
                        <div style="font-size: 0.8rem; line-height: 1.5;">
                            <span style="font-weight: 700; display: block; margin-bottom: 5px;">{{ $quotation->structure_height }}</span>
                            <span>{{ $quotation->structure_material }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-meta-footer-bar">
                <span>Proposal Reference: {{ $quotation->quotation_number }}</span>
                <span>Page 4</span>
            </div>
        </div>


        <!-- ==================== PAGE 5: BALANCE OF SYSTEM & WARRANTY ==================== -->
        <div class="proposal-page">
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-around;">
                <div class="bos-items-list">
                    <h4>Balance of System</h4>
                    <div class="bos-list-item-row">
                        <div class="bos-list-item-lbl">ACDB</div>
                        <div class="bos-list-item-val">{{ $quotation->bos_acdb }}</div>
                    </div>
                    <div class="bos-list-item-row">
                        <div class="bos-list-item-lbl">DCDB</div>
                        <div class="bos-list-item-val">{{ $quotation->bos_dcdb }}</div>
                    </div>
                    <div class="bos-list-item-row">
                        <div class="bos-list-item-lbl">Earthing</div>
                        <div class="bos-list-item-val">{{ $quotation->bos_earthing }}</div>
                    </div>
                    <div class="bos-list-item-row">
                        <div class="bos-list-item-lbl">Lightning Arrestor</div>
                        <div class="bos-list-item-val">{{ $quotation->bos_la }}</div>
                    </div>
                    <div class="bos-list-item-row">
                        <div class="bos-list-item-lbl">Miscellaneous Item</div>
                        <div class="bos-list-item-val">{{ $quotation->bos_misc }}</div>
                    </div>
                </div>

                <div class="warranty-layout-box">
                    <h4>Warranty</h4>
                    <div class="warranty-grid-quad">
                        <div class="warranty-quad-card">
                            <span class="lbl">Panel Warranty</span>
                            <span class="val">{{ $quotation->warranty_panel }}</span>
                        </div>
                        <div class="warranty-quad-card">
                            <span class="lbl">Performance Warranty</span>
                            <span class="val">{{ $quotation->warranty_performance }}</span>
                        </div>
                        <div class="warranty-quad-card">
                            <span class="lbl">Inverter Warranty</span>
                            <span class="val">{{ $quotation->warranty_inverter }}</span>
                        </div>
                        <div class="warranty-quad-card">
                            <span class="lbl">System Warranty</span>
                            <span class="val">{{ $quotation->warranty_system }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-meta-footer-bar">
                <span>Proposal Reference: {{ $quotation->quotation_number }}</span>
                <span>Page 5</span>
            </div>
        </div>


        <!-- ==================== PAGE 6: SCOPE OF WORK ==================== -->
        <div class="proposal-page">
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div>
                <h1 class="page-offer-title" style="font-size: 3rem;">SCOPE OF WORK</h1>
                
                <div class="scope-page-layout">
                    <div class="scope-list-block">
                        <h4>Our Scope</h4>
                        <ol>
                            <li>Preparation of Engineering Drawing, Design for solar structure and solar power plant as per relevant IS standard.</li>
                            <li>Supply of Solar Modules, Inverters, Structures, Cables, and Balance of Plant.</li>
                            <li>Installation of structure, solar modules, inverter, AC-DC cable, LT panel etc for solar power plant.</li>
                            <li>Installation of monitoring and controlling system for solar power plant.</li>
                            <li>Commissioning of Solar Power Plant and supply of power to LT panel of SGD.</li>
                        </ol>
                    </div>

                    <div class="scope-list-block">
                        <h4>Customer Scope</h4>
                        <ol>
                            <li>Providing safe storage place for material during installation &amp; commissioning period.</li>
                            <li>Access to Roof to be provided by Customer.</li>
                            <li>Internet connection for remote monitoring.</li>
                            <li>Area required is shadow free clean roof.</li>
                            <li>Solar panel cleaning has to be done by customer.</li>
                        </ol>
                    </div>

                    <div class="scope-notes-block">
                        <h5>Notes</h5>
                        <p>Structure Cost &amp; Cable Cost may Change as per Actual Material used on site.<br>
                        Fabrication as per site design<br>
                        30 Meter Uapr wiring jai to payment extra.</p>
                    </div>
                </div>
            </div>

            <div class="page-meta-footer-bar">
                <span>Proposal Reference: {{ $quotation->quotation_number }}</span>
                <span>Page 6</span>
            </div>
        </div>


        <!-- ==================== PAGE 7: SAVINGS ==================== -->
        <div class="proposal-page">
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div style="flex-grow: 1; display: flex; flex-direction: column;">
                <div class="savings-header-block">
                    <div class="savings-h1-kw">{{ $quotation->system_size }}</div>
                    <div class="savings-h1-title">SAVINGS</div>
                </div>

                <div class="savings-hex-grid">
                    <div class="savings-hex-card">
                        <i class="bi bi-hourglass-split"></i>
                        <span class="lbl">Payback Period</span>
                        <span class="val">{{ $quotation->savings_payback }}</span>
                    </div>
                    <div class="savings-hex-card">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span class="lbl">Average Yearly Generation</span>
                        <span class="val">{{ $quotation->savings_yearly_generation }}</span>
                    </div>
                    <div class="savings-hex-card">
                        <i class="bi bi-cash-stack"></i>
                        <span class="lbl">Average Annual Savings</span>
                        <span class="val">{{ $quotation->savings_annual_savings }}</span>
                    </div>
                    <div class="savings-hex-card">
                        <i class="bi bi-currency-rupee"></i>
                        <span class="lbl">Project Cost</span>
                        <span class="val">{{ $quotation->savings_project_cost }}</span>
                    </div>
                    <div class="savings-hex-card">
                        <i class="bi bi-tree-fill" style="color: #10B981;"></i>
                        <span class="lbl">Trees Saved</span>
                        <span class="val">{{ $quotation->savings_trees_saved }}</span>
                    </div>
                    <div class="savings-hex-card">
                        <i class="bi bi-cloud-arrow-down-fill"></i>
                        <span class="lbl">Co2 Reduction</span>
                        <span class="val">{{ $quotation->savings_co2_reduction }}</span>
                    </div>
                </div>
            </div>

            <div class="page-meta-footer-bar">
                <span>Proposal Reference: {{ $quotation->quotation_number }}</span>
                <span>Page 7</span>
            </div>
        </div>


        <!-- ==================== PAGE 8: VISUAL GUIDE ==================== -->
        <div class="proposal-page">
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div>
                <h1 class="page-offer-title" style="font-size: 2.8rem; line-height: 1.2; color: var(--brand-dark);">
                    A VISUAL GUIDE<br>
                    <span style="color: var(--brand-yellow);">TO SAVING MONEY</span>
                </h1>
                <div style="width: 140px; height: 3px; background: #94A3B8; margin: 15px 0;"></div>

                <div class="chart-card-wrapper">
                    <div style="display: flex; height: 100%;">
                        <!-- Y Axis labels -->
                        <div class="chart-y-axis-labels">
                            <span>300</span>
                            <span>250</span>
                            <span>200</span>
                            <span>150</span>
                            <span>100</span>
                            <span>50</span>
                            <span>0</span>
                        </div>

                        <!-- Plot Area -->
                        <div class="chart-plot-graphic">
                            <div class="chart-background-lines">
                                <div class="chart-bg-line-item"></div>
                                <div class="chart-bg-line-item"></div>
                                <div class="chart-bg-line-item"></div>
                                <div class="chart-bg-line-item"></div>
                                <div class="chart-bg-line-item"></div>
                                <div class="chart-bg-line-item"></div>
                                <div class="chart-bg-line-item"></div>
                            </div>

                            <!-- Bars -->
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">205</span>
                                <div class="chart-bar-pillar" style="height: 68%;"></div>
                                <span class="chart-bar-pillar-label">Jan</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">209</span>
                                <div class="chart-bar-pillar" style="height: 70%;"></div>
                                <span class="chart-bar-pillar-label">Feb</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">271</span>
                                <div class="chart-bar-pillar" style="height: 90%;"></div>
                                <span class="chart-bar-pillar-label">Mar</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">274</span>
                                <div class="chart-bar-pillar" style="height: 91%;"></div>
                                <span class="chart-bar-pillar-label">Apr</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">284</span>
                                <div class="chart-bar-pillar" style="height: 95%;"></div>
                                <span class="chart-bar-pillar-label">May</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">208</span>
                                <div class="chart-bar-pillar" style="height: 69%;"></div>
                                <span class="chart-bar-pillar-label">Jun</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">166</span>
                                <div class="chart-bar-pillar" style="height: 55%;"></div>
                                <span class="chart-bar-pillar-label">Jul</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">166</span>
                                <div class="chart-bar-pillar" style="height: 55%;"></div>
                                <span class="chart-bar-pillar-label">Aug</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">199</span>
                                <div class="chart-bar-pillar" style="height: 66%;"></div>
                                <span class="chart-bar-pillar-label">Sep</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">224</span>
                                <div class="chart-bar-pillar" style="height: 75%;"></div>
                                <span class="chart-bar-pillar-label">Oct</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">196</span>
                                <div class="chart-bar-pillar" style="height: 65%;"></div>
                                <span class="chart-bar-pillar-label">Nov</span>
                            </div>
                            <div class="chart-bar-pillar-wrap">
                                <span class="chart-bar-pillar-val">183</span>
                                <div class="chart-bar-pillar" style="height: 61%;"></div>
                                <span class="chart-bar-pillar-label">Dec</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-meta-footer-bar">
                <span>Proposal Reference: {{ $quotation->quotation_number }}</span>
                <span>Page 8</span>
            </div>
        </div>


        <!-- ==================== PAGE 9: CONTACTS & SIGNATURES ==================== -->
        <div class="proposal-page">
            <div class="proposal-header">
                <div class="logo-img-box">
                    <div class="logo-text-details">
                        <h2>DELICATE</h2>
                        <span>Solar Pvt Ltd</span>
                        <div class="logo-tagline">Get Power from The Sun</div>
                    </div>
                </div>
            </div>

            <div style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                
                <div class="signatures-flex-row">
                    <div class="signature-signing-block">
                        <div style="height: 110px;"></div>
                        <div class="signature-line-divider"></div>
                        <div class="signature-signing-label">Authorized Signatory</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Delicate Solar Pvt. Ltd.</div>
                    </div>

                    <div class="signature-signing-block">
                        <div style="height: 110px;"></div>
                        <div class="signature-line-divider"></div>
                        <div class="signature-signing-label">Customer Signatory</div>
                    </div>
                </div>

                <div class="footer-yellow-contact-bleed">
                    <h4>Contact Us</h4>
                    <div class="contact-details-grid">
                        <div class="contact-grid-info-item">
                            <i class="bi bi-telephone-fill"></i>
                            <span><strong>Contact No:</strong> 8238340740</span>
                        </div>
                        <div class="contact-grid-info-item">
                            <i class="bi bi-envelope-fill"></i>
                            <span><strong>E-Mail:</strong> marketing.delicatesolar@gmail.com</span>
                        </div>
                        <div class="contact-grid-info-item">
                            <i class="bi bi-globe"></i>
                            <span><strong>Website:</strong> http://www.delicatesolar.com</span>
                        </div>
                        <div class="contact-grid-info-item" style="grid-column: span 2;">
                            <i class="bi bi-geo-alt-fill" style="align-self: flex-start; margin-top: 3px;"></i>
                            <span><strong>Address:</strong> F-3/1, Shivam Avenue, Dhavat Road, Juna Bazar, Karjan, 391240</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="page-meta-footer-bar" style="border-top: none;">
                <span>Proposal Reference: {{ $quotation->quotation_number }}</span>
                <span>Page 9</span>
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
