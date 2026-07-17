<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gayatri Solar Energy - Admin Access</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --brand-dark: #0A0A0A;
            --brand-dark-card: #141414;
            --brand-orange: #F58220;
            --brand-orange-grad: linear-gradient(135deg, #F58220 0%, #FF9F43 100%);
            --brand-orange-soft: rgba(245, 130, 32, 0.1);
            --brand-border: #E5E7EB;
            --text-dark: #1F2937;
            --text-muted: #6B7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--brand-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            margin: 0;
        }

        .login-container {
            width: 100vw;
            min-height: 100vh;
            display: flex;
        }

        /* Left Visual Column */
        .visual-column {
            flex: 0 0 50%;
            width: 50%;
            background: radial-gradient(circle at 80% 20%, rgba(245, 130, 32, 0.15) 0%, rgba(10, 10, 10, 1) 70%), #0A0A0A;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px;
            color: #FFFFFF;
            position: relative;
            overflow: hidden;
        }

        .visual-column::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(245, 130, 32, 0.2) 0%, rgba(0,0,0,0) 70%);
            top: -50px;
            left: -50px;
            pointer-events: none;
        }

        .visual-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2;
        }

        .brand-logo-img {
            height: 50px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            border-radius: 8px;
            border: 2px solid var(--brand-orange);
            background-color: var(--brand-dark);
            padding: 2px;
        }

        .brand-logo-text {
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
            margin-bottom: 0;
        }

        .brand-logo-text span {
            color: var(--brand-orange);
        }

        .visual-body {
            max-width: 500px;
            margin-top: auto;
            margin-bottom: auto;
            z-index: 2;
        }

        .visual-title {
            font-weight: 800;
            font-size: 2.8rem;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .visual-title span {
            color: var(--brand-orange);
        }

        .visual-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        /* Advanced CSS Solar Panel Visual */
        .solar-visual-wrapper {
            position: relative;
            width: 100%;
            height: 200px;
            margin-top: 20px;
        }

        .solar-grid {
            width: 280px;
            height: 160px;
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            border: 6px solid #475569;
            border-radius: 8px;
            position: relative;
            transform: perspective(600px) rotateX(25deg) rotateY(-10deg);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5), 0 0 30px rgba(245, 130, 32, 0.2);
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(3, 1fr);
            gap: 3px;
            padding: 3px;
            overflow: hidden;
        }

        .solar-cell {
            background: linear-gradient(180deg, #1E3A8A 0%, #172554 100%);
            border-radius: 2px;
            position: relative;
        }

        .solar-cell::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 50%);
        }

        .sun-ray-glow {
            position: absolute;
            top: -20px;
            right: 80px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(245,130,32,0.4) 0%, rgba(245,130,32,0) 70%);
            filter: blur(10px);
            animation: sunGlow 6s ease-in-out infinite alternate;
        }

        @keyframes sunGlow {
            0% { transform: scale(1); opacity: 0.7; }
            100% { transform: scale(1.3); opacity: 1; }
        }

        .visual-footer {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
            z-index: 2;
        }

        /* Right Form Column */
        .form-column {
            flex: 0 0 50%;
            width: 50%;
            background-color: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            box-shadow: -10px 0 30px rgba(0,0,0,0.15);
            z-index: 5;
            animation: formSlideIn 0.6s ease-out;
        }

        .form-column-content {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        @keyframes formSlideIn {
            0% { transform: translateX(50px); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        .form-header-wrap {
            margin-bottom: 35px;
        }

        .secure-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: var(--brand-orange-soft);
            color: var(--brand-orange);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }

        .form-title {
            font-weight: 800;
            font-size: 1.85rem;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-sub {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Input Controls */
        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-label-custom {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: block;
        }

        .input-field-wrap {
            position: relative;
        }

        .input-icon-left {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.3s;
        }

        .input-field {
            width: 100%;
            padding: 14px 44px 14px 44px;
            border: 1.5px solid var(--brand-border);
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-dark);
            background-color: #FFFFFF;
            transition: all 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--brand-orange);
            box-shadow: 0 0 0 4px rgba(245, 130, 32, 0.15);
        }

        .input-field:focus ~ .input-icon-left {
            color: var(--brand-orange);
        }

        .pwd-toggle-btn {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0;
            transition: color 0.3s;
        }

        .pwd-toggle-btn:hover {
            color: var(--brand-orange);
        }

        /* Remember & Forgot */
        .option-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .remember-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .remember-checkbox input {
            width: 16px;
            height: 16px;
            accent-color: var(--brand-orange);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.88rem;
            color: var(--brand-orange);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #E06D12;
            text-decoration: underline;
        }

        /* Buttons */
        .btn-login {
            width: 100%;
            background: var(--brand-orange-grad);
            color: #FFFFFF;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(245, 130, 32, 0.3);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 130, 32, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            background: #CCCCCC;
            box-shadow: none;
            cursor: not-allowed;
            transform: none;
        }

        /* Errors Alert */
        .error-alert-box {
            background-color: #FEF2F2;
            border: 1.5px solid #FCA5A5;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        /* Mobile Responsive adjustments */
        @media (max-width: 991px) {
            .visual-column {
                display: none !important;
            }
            body {
                background-color: #0A0A0A;
                padding: 20px;
            }
            .form-column {
                flex: none;
                width: 100%;
                max-width: 440px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                border-radius: 12px;
                padding: 40px 30px;
            }
            .mobile-header-logo {
                display: flex !important;
                justify-content: center;
                margin-bottom: 30px;
            }
        }

        @media (min-width: 992px) {
            .mobile-header-logo {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <!-- Left Section: Solar visual & Info -->
        <div class="visual-column">
            <div class="visual-brand">
                <img src="{{ asset('assets/images/logo.jpg') }}" class="brand-logo-img" alt="Gayatri Solar Energy Logo">
                <h2 class="brand-logo-text">GAYATRI <span>SOLAR</span></h2>
            </div>

            <div class="visual-body">
                <h1 class="visual-title">Powering a <span>Smarter</span> Tomorrow</h1>
                <p class="visual-desc">
                    Manage customers, enquiries, surveys, quotations, service requests and solar operations from one secure platform.
                </p>

                <!-- Modern Solar Panel Simulation -->
                <div class="solar-visual-wrapper">
                    <div class="sun-ray-glow"></div>
                    <div class="solar-grid">
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                        <div class="solar-cell"></div>
                    </div>
                </div>
            </div>

            <div class="visual-footer">
                &copy; 2026 Gayatri Solar Energy. All rights reserved.
            </div>
        </div>

        <!-- Right Section: Login Form Card -->
        <div class="form-column">
            <div class="form-column-content">
                <!-- Mobile View Logo Header -->
                <div class="mobile-header-logo">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('assets/images/logo.jpg') }}" class="brand-logo-img" alt="Gayatri Solar Energy Logo">
                        <h2 class="brand-logo-text" style="color: #111111;">GAYATRI <span style="color: var(--brand-orange);">SOLAR</span></h2>
                    </div>
                </div>

                <div class="form-header-wrap">
                    <div class="secure-badge">
                        <i class="bi bi-shield-lock-fill"></i> Secure Access
                    </div>
                    <h2 class="form-title">Welcome Back</h2>
                    <p class="form-sub">Sign in to access your dashboard</p>
                </div>

                {{-- Role Selection Switcher --}}
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <button type="button" id="adminRoleBtn" class="btn w-100 py-3 rounded-3 d-flex flex-column align-items-center justify-content-center gap-1 border" 
                                style="background-color: var(--brand-orange-soft); border-color: var(--brand-orange) !important; color: var(--brand-orange); font-weight: 700; font-size: 0.9rem;">
                            <span class="fs-4">🛠</span>
                            <span>Admin Login</span>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" id="employeeRoleBtn" class="btn w-100 py-3 rounded-3 d-flex flex-column align-items-center justify-content-center gap-1 border" 
                                style="background-color: #f8f9fa; border-color: #dee2e6; color: var(--text-dark); font-weight: 600; font-size: 0.9rem;">
                            <span class="fs-4">👷</span>
                            <span>Employee Login</span>
                        </button>
                    </div>
                </div>

                <!-- Single error rendering container -->
                @if ($errors->any())
                    <div class="error-alert-box">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-0.5" style="font-size: 1rem;"></i>
                        <div>
                            <ul class="mb-0 ps-0 list-unstyled fw-semibold">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email / Username -->
                    <div class="input-group-custom">
                        <label class="input-label-custom" for="email" id="loginLabel">Email Address</label>
                        <div class="input-field-wrap">
                            <input type="text" name="email" id="email" class="input-field" 
                                   value="{{ old('email') }}" placeholder="admin@gayatrisolar.com" required autofocus autocomplete="username">
                            <i class="bi bi-envelope input-icon-left" id="loginIcon"></i>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group-custom">
                        <label class="input-label-custom" for="password">Password</label>
                        <div class="input-field-wrap">
                            <input type="password" name="password" id="password" class="input-field" 
                                   placeholder="••••••••" required autocomplete="current-password">
                            <i class="bi bi-lock input-icon-left"></i>
                            <button type="button" class="pwd-toggle-btn" id="passwordToggle" aria-label="Toggle Password Visibility">
                                <i class="bi bi-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                    </div>



                    <!-- Login Submit -->
                    <button type="submit" class="btn-login" id="submitBtn">
                        <span id="btnText">Sign In</span>
                        <i class="bi bi-arrow-right" id="btnIcon"></i>
                    </button>
                </form>

                <div class="text-center mt-5 d-lg-none" style="font-size: 0.8rem; color: var(--text-muted);">
                    &copy; 2026 Gayatri Solar Energy. All rights reserved.
                </div>
            </div>
        </div>

    </div>

    <!-- Show/Hide Password & Form Submit Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggle = document.getElementById('passwordToggle');
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');

            const adminRoleBtn = document.getElementById('adminRoleBtn');
            const employeeRoleBtn = document.getElementById('employeeRoleBtn');
            const secureBadge = document.querySelector('.secure-badge');
            const formTitle = document.querySelector('.form-title');
            const formSub = document.querySelector('.form-sub');
            const loginLabel = document.getElementById('loginLabel');
            const emailInput = document.getElementById('email');
            const loginIcon = document.getElementById('loginIcon');

            const roleInput = document.createElement('input');
            roleInput.type = 'hidden';
            roleInput.name = 'login_type';
            roleInput.value = 'admin';
            loginForm.appendChild(roleInput);

            adminRoleBtn.addEventListener('click', function() {
                adminRoleBtn.style.backgroundColor = 'var(--brand-orange-soft)';
                adminRoleBtn.style.borderColor = 'var(--brand-orange)';
                adminRoleBtn.style.color = 'var(--brand-orange)';
                adminRoleBtn.style.fontWeight = '700';

                employeeRoleBtn.style.backgroundColor = '#f8f9fa';
                employeeRoleBtn.style.borderColor = '#dee2e6';
                employeeRoleBtn.style.color = 'var(--text-dark)';
                employeeRoleBtn.style.fontWeight = '600';

                secureBadge.innerHTML = '<i class="bi bi-shield-lock-fill"></i> Secure Access';
                formSub.textContent = 'Sign in to access your dashboard';
                loginLabel.textContent = 'Email Address';
                emailInput.placeholder = 'admin@gayatrisolar.com';
                loginIcon.className = 'bi bi-envelope input-icon-left';
                roleInput.value = 'admin';
            });

            employeeRoleBtn.addEventListener('click', function() {
                employeeRoleBtn.style.backgroundColor = 'var(--brand-orange-soft)';
                employeeRoleBtn.style.borderColor = 'var(--brand-orange)';
                employeeRoleBtn.style.color = 'var(--brand-orange)';
                employeeRoleBtn.style.fontWeight = '700';

                adminRoleBtn.style.backgroundColor = '#f8f9fa';
                adminRoleBtn.style.borderColor = '#dee2e6';
                adminRoleBtn.style.color = 'var(--text-dark)';
                adminRoleBtn.style.fontWeight = '600';

                secureBadge.innerHTML = '<i class="bi bi-person-badge-fill"></i> Secure Employee Access';
                formSub.textContent = 'Sign in to access your attendance dashboard';
                loginLabel.textContent = 'Employee Email or ID';
                emailInput.placeholder = 'e.g. EMP0001 or employee@gayatrisolar.com';
                loginIcon.className = 'bi bi-person input-icon-left';
                roleInput.value = 'employee';
            });

            // Show/Hide Password
            passwordToggle.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordIcon.classList.remove('bi-eye');
                    passwordIcon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordIcon.classList.remove('bi-eye-slash');
                    passwordIcon.classList.add('bi-eye');
                }
            });

            // Prevent duplicate submit & show loading state
            loginForm.addEventListener('submit', function() {
                submitBtn.disabled = true;
                btnText.textContent = 'Signing In...';
                btnIcon.className = 'spinner-border spinner-border-sm';
                btnIcon.setAttribute('role', 'status');
            });
        });
    </script>
</body>
</html>
