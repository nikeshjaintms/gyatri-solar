<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gayatri Solar Energy - Employee Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-orange: #F58220;
            --brand-orange-hover: #D96A0B;
            --brand-black: #0A0A0A;
            --bg-main: #FFFFFF;
            --text-dark: #111827;
            --border-soft: #E8ECF0;
        }
        body {
            background-color: var(--bg-main);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }
        .navbar-employee {
            background-color: var(--brand-black);
            padding: 15px 30px;
            border-bottom: 2px solid var(--brand-orange);
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #FFFFFF;
        }
        .brand-logo-img {
            height: 40px;
            border: 1px solid var(--brand-orange);
            border-radius: 4px;
        }
        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--brand-orange), #FF9D4D);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #FFFFFF;
            font-size: 0.85rem;
        }
        .btn-logout {
            padding: 6px 14px;
            border-radius: 6px;
            background: transparent;
            color: #EF4444;
            border: 1.5px solid #FCA5A5;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-logout:hover {
            background: #EF4444;
            color: #FFFFFF;
            border-color: #EF4444;
        }
        .portal-content {
            flex-grow: 1;
            padding: 40px 20px;
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

    <!-- Top Navbar -->
    <header class="navbar-employee">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('assets/images/logo.jpg') }}" class="brand-logo-img" alt="GSE Logo">
            <span class="fw-bold tracking-wide" style="font-size: 1.1rem; letter-spacing: 0.5px;">GAYATRI <span style="color: var(--brand-orange);">SOLAR</span></span>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="user-chip d-none d-sm-flex">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'E', 0, 1)) }}
                </div>
                <div class="text-start">
                    <div class="fw-semibold text-white small" style="line-height: 1.2;">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size: 0.72rem;">{{ Auth::user()->role }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </header>

    <!-- Main Container -->
    <main class="portal-content">
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery and jQuery Validation Plugin -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.1/dist/additional-methods.min.js"></script>

    <script>
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
                    if ($(this).attr('name').indexOf('panel') === -1) {
                        $(this).rules('add', { pan: true });
                    }
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
