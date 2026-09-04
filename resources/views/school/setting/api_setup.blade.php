@extends('layouts.school')

@section('title', __('API & Professional Account Setup'))

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ═════════════════════════════════════════════════════════════
           API & INTEGRATION SETUP PAGE MODERN DESIGN
        ══════════════════════════════════════════════════════════════ */
        .api-page-wrap {
            max-width: 1140px;
            margin: 0 auto;
        }

        /* ── Hero Header ── */
        .api-header-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 20px;
            padding: 24px 28px;
            color: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .api-header-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .api-header-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(14, 165, 233, 0.4);
        }
        .api-header-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0;
            color: #ffffff;
            line-height: 1.25;
        }
        .api-header-sub {
            font-size: 12.5px;
            color: #94a3b8;
            margin-top: 3px;
        }
        .api-pill-badge {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 11.5px;
            font-weight: 700;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Settings Navigation Tabs Bar ── */
        .api-tabs-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 8px 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
            overflow-x: auto;
        }
        .api-tab-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .api-tab-link:hover {
            color: #4f46e5;
            background: #f1f5f9;
        }
        .api-tab-link.active {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            box-shadow: 0 3px 12px rgba(79, 70, 229, 0.3);
        }

        /* ── Section Cards ── */
        .api-section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.04);
            overflow: hidden;
            margin-bottom: 24px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease;
        }
        .api-section-card:hover {
            box-shadow: 0 6px 24px rgba(79, 70, 229, 0.07);
        }
        .api-card-header {
            padding: 16px 22px;
            background: linear-gradient(135deg, #fafbff 0%, #f1f5ff 100%);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .api-card-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            color: #ffffff;
            flex-shrink: 0;
        }
        .icon-blue {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
        }
        .icon-gold {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            box-shadow: 0 3px 8px rgba(217, 119, 6, 0.25);
        }
        .icon-green {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 3px 8px rgba(5, 150, 105, 0.25);
        }
        .icon-purple {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
            box-shadow: 0 3px 8px rgba(124, 58, 237, 0.25);
        }
        .icon-teal {
            background: linear-gradient(135deg, #0d9488, #14b8a6);
            box-shadow: 0 3px 8px rgba(13, 148, 136, 0.25);
        }
        .api-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.25;
        }
        .api-card-desc {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        .api-card-body {
            padding: 22px;
            flex: 1;
        }

        /* ── Modern Form Controls ── */
        .api-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .api-input, .api-select {
            width: 100%;
            height: 39px;
            padding: 7px 12px;
            font-size: 12.5px;
            font-weight: 600;
            color: #1e293b;
            background-color: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            transition: all 0.2s ease;
            outline: none;
        }
        .api-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 32px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 11px center;
            background-size: 14px 14px;
            cursor: pointer;
        }
        .api-input:focus, .api-select:focus {
            background-color: #ffffff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }
        .api-input:disabled, .api-select:disabled {
            background-color: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            border-color: #e2e8f0;
        }

        /* ── Input Group with Eye Toggle ── */
        .api-input-group {
            display: flex;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            overflow: hidden;
            transition: all 0.2s;
        }
        .api-input-group:focus-within {
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }
        .api-input-group input {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            color: #1e293b;
            padding: 7px 12px;
            outline: none;
            min-width: 0;
        }
        .api-eye-btn {
            background: transparent;
            border: none;
            padding: 0 12px;
            color: #64748b;
            cursor: pointer;
            transition: color 0.15s;
            display: flex;
            align-items: center;
        }
        .api-eye-btn:hover {
            color: #4f46e5;
        }

        /* ── Status Boxes ── */
        .api-status-box {
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 16px;
        }
        .api-status-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        .api-status-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }
        .api-status-amber {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
        }

        /* ── Webhook Info Box ── */
        .api-webhook-code-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            font-family: monospace;
            font-size: 12px;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-top: 8px;
        }
        .btn-copy-sm {
            background: #eef2ff;
            color: #4f46e5;
            border: 1px solid #c7d2fe;
            border-radius: 6px;
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 8px;
            cursor: pointer;
            transition: all 0.15s;
            flex-shrink: 0;
        }
        .btn-copy-sm:hover {
            background: #4f46e5;
            color: #ffffff;
        }

        /* ── Bottom Save Action Bar ── */
        .api-action-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            padding: 16px 22px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            margin-top: 10px;
            margin-bottom: 30px;
        }
        .btn-api-save {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            border: none;
            padding: 11px 26px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
            transition: all 0.2s ease;
        }
        .btn-api-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            color: #ffffff;
        }

        /* ── Top Toast Alert Styling ── */
        .edu-top-toast {
            background: #ffffff !important;
            border: 1.5px solid #86efac !important;
            border-radius: 14px !important;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.15) !important;
            padding: 12px 20px !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            color: #15803d !important;
            margin-top: 20px !important;
        }
        .edu-top-toast-error {
            border-color: #fca5a5 !important;
            color: #b91c1c !important;
        }

        /* ═════════════════════════════════════════════════════════════
           DARK MODE OVERRIDES
        ══════════════════════════════════════════════════════════════ */
        [data-bs-theme="dark"] .api-tabs-bar,
        body.dark-mode .api-tabs-bar,
        [data-bs-theme="dark"] .api-section-card,
        body.dark-mode .api-section-card,
        [data-bs-theme="dark"] .api-action-bar,
        body.dark-mode .api-action-bar {
            background: #0c1427 !important;
            border-color: #1a253b !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
        }
        [data-bs-theme="dark"] .api-card-header,
        body.dark-mode .api-card-header {
            background: linear-gradient(135deg, #0c1427, #111d35) !important;
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .api-card-title,
        body.dark-mode .api-card-title {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .api-card-desc,
        body.dark-mode .api-card-desc {
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .api-label,
        body.dark-mode .api-label {
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .api-input,
        body.dark-mode .api-input,
        [data-bs-theme="dark"] .api-select,
        body.dark-mode .api-select,
        [data-bs-theme="dark"] .api-input-group,
        body.dark-mode .api-input-group {
            background-color: #111d35 !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .api-input-group input,
        body.dark-mode .api-input-group input {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .api-webhook-code-box,
        body.dark-mode .api-webhook-code-box {
            background: #111d35 !important;
            border-color: #1e293b !important;
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .edu-top-toast,
        body.dark-mode .edu-top-toast {
            background: #0c1427 !important;
            border-color: #166534 !important;
            color: #4ade80 !important;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.6) !important;
        }
        [data-bs-theme="dark"] .edu-top-toast-error,
        body.dark-mode .edu-top-toast-error {
            border-color: #991b1b !important;
            color: #f87171 !important;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="api-page-wrap">

            {{-- ═════════════════════════════════════════════════════════════
                 HERO HEADER CARD
            ══════════════════════════════════════════════════════════════ --}}
            <div class="api-header-card">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="api-header-icon">
                            <i class="fa-solid fa-gears"></i>
                        </div>
                        <div>
                            <h4 class="api-header-title">{{ __('API & Professional Integration Setup (এপিআই ও ইন্টিগ্রেশন সেটিংস)') }}</h4>
                            <p class="api-header-sub mb-0">
                                {{ __('Configure professional SMTP email, custom domain email, WhatsApp gateway and SMS providers') }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="api-pill-badge">
                            <i class="fa-solid fa-server text-info"></i>
                            SMTP: <strong class="text-white">{{ strtoupper($school->mail_mailer ?? 'Default') }}</strong>
                        </span>
                        <span class="api-pill-badge" style="background: rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.4);">
                            <i class="fa-brands fa-whatsapp text-success"></i>
                            WA: <strong class="text-white">{{ ucfirst($school->whatsapp_api_provider ?? 'Disabled') }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            {{-- ═════════════════════════════════════════════════════════════
                 SETTINGS NAVIGATION TABS
            ══════════════════════════════════════════════════════════════ --}}
            <div class="api-tabs-bar">
                <a href="{{ route('admin.school.info-edit', ['tenant' => auth()->user()->school->slug]) }}" class="api-tab-link">
                    <i class="fa-solid fa-sliders"></i> {{ __('General Profile') }}
                </a>
                <a href="{{ route('admin.school.api-setup', ['tenant' => auth()->user()->school->slug]) }}" class="api-tab-link active">
                    <i class="fa-solid fa-plug"></i> {{ __('API & SMTP Setup') }}
                </a>
                <a href="{{ route('admin.school.communication', ['tenant' => auth()->user()->school->slug]) }}" class="api-tab-link">
                    <i class="fa-solid fa-comments"></i> {{ __('Communication') }}
                </a>
            </div>

            {{-- ═════════════════════════════════════════════════════════════
                 SETTINGS FORM
            ══════════════════════════════════════════════════════════════ --}}
            <form action="{{ route('admin.school.api-setup.update', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                @csrf

                <div class="row g-4">
                    {{-- ── 1. Professional Email (SMTP) ── --}}
                    <div class="col-lg-7">
                        <div class="api-section-card">
                            <div class="api-card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="api-card-icon icon-blue">
                                        <i class="fa-solid fa-envelope-open-text"></i>
                                    </div>
                                    <div>
                                        <h6 class="api-card-title">{{ __('Professional Email (SMTP Settings)') }}</h6>
                                        <p class="api-card-desc">{{ __('Outgoing mail server used for notices, invoices and credential emails') }}</p>
                                    </div>
                                </div>
                                <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                    SMTP
                                </span>
                            </div>
                            <div class="api-card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="api-label">{{ __('Mail Driver') }}</label>
                                        <select name="mail_mailer" class="api-select">
                                            <option value="smtp" {{ $school->mail_mailer == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                            <option value="mailgun" {{ $school->mail_mailer == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                            <option value="sendmail" {{ $school->mail_mailer == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="api-label">{{ __('Mail Host') }}</label>
                                        <input type="text" name="mail_host" class="api-input" value="{{ $school->mail_host }}" placeholder="e.g. mail.domain.com">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="api-label">{{ __('Port') }}</label>
                                        <input type="text" name="mail_port" class="api-input" value="{{ $school->mail_port }}" placeholder="465">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="api-label">{{ __('Encryption') }}</label>
                                        <select name="mail_encryption" class="api-select">
                                            <option value="ssl" {{ $school->mail_encryption == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            <option value="tls" {{ $school->mail_encryption == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="" {{ $school->mail_encryption == '' ? 'selected' : '' }}>None</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="api-label">{{ __('Username / Email') }}</label>
                                        <input type="text" name="mail_username" class="api-input" value="{{ $school->mail_username }}" placeholder="support@domain.com">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="api-label">{{ __('Password') }}</label>
                                        <div class="api-input-group">
                                            <input type="password" name="mail_password" value="{{ $school->mail_password }}" id="smtp_pass" placeholder="••••••••">
                                            <button class="api-eye-btn" type="button" onclick="togglePass('smtp_pass')" title="Toggle visibility">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="api-label">{{ __('From Email Address') }}</label>
                                        <input type="email" name="mail_from_address" class="api-input" value="{{ $school->mail_from_address }}" placeholder="noreply@domain.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="api-label">{{ __('From Display Name') }}</label>
                                        <input type="text" name="mail_from_name" class="api-input" value="{{ $school->mail_from_name }}" placeholder="Your School Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── 2. Professional School Email Service ── --}}
                    <div class="col-lg-5">
                        <div class="api-section-card">
                            <div class="api-card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="api-card-icon icon-gold">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <div>
                                        <h6 class="api-card-title">{{ __('Professional Domain Email') }}</h6>
                                        <p class="api-card-desc">{{ __('Custom branded mailbox on your institution subdomain') }}</p>
                                    </div>
                                </div>
                                <span class="badge bg-warning-subtle text-warning-emphasis fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                    Pro Email
                                </span>
                            </div>
                            <div class="api-card-body d-flex flex-column justify-content-between">
                                @if($school->pro_email_status == 'none' || $school->pro_email_status == 'rejected')
                                    <div class="text-center py-4 my-auto">
                                        <div class="mb-3" style="width: 60px; height: 60px; border-radius: 50%; background: #fffbeb; display: inline-flex; align-items: center; justify-content: center; color: #d97706;">
                                            <i class="fa-solid fa-envelope-circle-check fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">{{ __('Get a Professional School Email') }}</h6>
                                        <p class="text-muted small mb-3">
                                            {{ __('Create an official institutional email like info@:domain', ['domain' => $school->slug . '.educorexa.com']) }}
                                        </p>
                                        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#requestEmailModal">
                                            <i class="fa-solid fa-plus-circle me-1"></i> {{ __('Request Email') }}
                                        </button>
                                    </div>
                                @elseif($school->pro_email_status == 'pending')
                                    <div class="text-center py-4 my-auto">
                                        <div class="spinner-border text-primary mb-3" role="status"></div>
                                        <h6 class="fw-bold text-dark mb-1">{{ __('Request Under Review') }}</h6>
                                        <p class="text-muted small mb-0">
                                            {{ __('Super Admin is provisioning your custom mailbox for') }} <strong>{{ $school->pro_email_prefix }}@...</strong>
                                        </p>
                                    </div>
                                @elseif($school->pro_email_status == 'approved')
                                    <div class="my-auto">
                                        <div class="api-status-box api-status-success d-flex align-items-center gap-3 mb-3">
                                            <i class="fa-solid fa-circle-check fs-3"></i>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ __('Mailbox Active') }}</h6>
                                                <p class="mb-0 small opacity-90">{{ $school->pro_email_address }}</p>
                                            </div>
                                        </div>
                                        <div class="api-status-box api-status-info small mb-0">
                                            <i class="fa-solid fa-lightbulb me-1"></i>
                                            {{ __('Credentials and webmail link have been sent to your primary admin email: :email', ['email' => $school->email]) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ── 3. WhatsApp Gateway Setup ── --}}
                    <div class="col-lg-7">
                        <div class="api-section-card">
                            <div class="api-card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="api-card-icon icon-green">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </div>
                                    <div>
                                        <h6 class="api-card-title">{{ __('WhatsApp API Gateway') }}</h6>
                                        <p class="api-card-desc">{{ __('Automated instant notifications for fees, attendance and student notices') }}</p>
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                    WhatsApp
                                </span>
                            </div>
                            <div class="api-card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="api-label">{{ __('API Provider') }}</label>
                                        <select name="whatsapp_api_provider" class="api-select">
                                            <option value="ultramsg" {{ $school->whatsapp_api_provider == 'ultramsg' ? 'selected' : '' }}>UltraMsg (Recommended)</option>
                                            <option value="twilio" {{ $school->whatsapp_api_provider == 'twilio' ? 'selected' : '' }}>Twilio WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="api-label">{{ __('Instance ID') }}</label>
                                        <input type="text" name="whatsapp_api_instance_id" class="api-input" value="{{ $school->whatsapp_api_instance_id }}" placeholder="e.g. instance10582">
                                    </div>
                                    <div class="col-12">
                                        <label class="api-label">{{ __('API Key / Token / Secret') }}</label>
                                        <div class="api-input-group">
                                            <input type="password" name="whatsapp_api_key" value="{{ $school->whatsapp_api_key }}" id="wa_key" placeholder="Enter provider API token">
                                            <button class="api-eye-btn" type="button" onclick="togglePass('wa_key')" title="Toggle visibility">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="api-status-box api-status-info small mb-0">
                                            <i class="fa-solid fa-circle-info me-1"></i>
                                            {{ __('Once configured, parent phone numbers with valid country code (+880) will receive automated WhatsApp notifications.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── 4. Bulk SMS API Setup ── --}}
                    <div class="col-lg-5">
                        <div class="api-section-card">
                            <div class="api-card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="api-card-icon icon-teal">
                                        <i class="fa-solid fa-comment-sms"></i>
                                    </div>
                                    <div>
                                        <h6 class="api-card-title">{{ __('Bulk SMS Gateway') }}</h6>
                                        <p class="api-card-desc">{{ __('Carrier SMS provider configuration') }}</p>
                                    </div>
                                </div>
                                <span class="badge bg-teal-subtle text-teal fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                    SMS
                                </span>
                            </div>
                            <div class="api-card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="api-label">{{ __('SMS Gateway Provider') }}</label>
                                        <select name="sms_api_provider" class="api-select" {{ !$school->hasPackagePermission('sms.send') ? 'disabled' : '' }}>
                                            <option value="" {{ !$school->sms_api_provider ? 'selected' : '' }}>Disabled</option>
                                            <option value="generic" {{ $school->sms_api_provider == 'generic' ? 'selected' : '' }}>Generic JSON API</option>
                                            <option value="bulksmsbd" {{ $school->sms_api_provider == 'bulksmsbd' ? 'selected' : '' }}>Bulk SMS BD</option>
                                            <option value="sslwireless" {{ $school->sms_api_provider == 'sslwireless' ? 'selected' : '' }}>SSL Wireless</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="api-label">{{ __('API Endpoint URL') }}</label>
                                        <input type="url" name="sms_api_url" class="api-input" value="{{ $school->sms_api_url }}" placeholder="https://provider.example/api/send" {{ !$school->hasPackagePermission('sms.send') ? 'disabled' : '' }}>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="api-label">{{ __('API Key') }}</label>
                                        <input type="password" name="sms_api_key" class="api-input" value="{{ $school->sms_api_key }}" placeholder="Key" {{ !$school->hasPackagePermission('sms.send') ? 'disabled' : '' }}>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="api-label">{{ __('API Secret') }}</label>
                                        <input type="password" name="sms_api_secret" class="api-input" value="{{ $school->sms_api_secret }}" placeholder="Secret" {{ !$school->hasPackagePermission('sms.send') ? 'disabled' : '' }}>
                                    </div>
                                    <div class="col-12">
                                        <label class="api-label">{{ __('Approved Sender ID') }}</label>
                                        <input type="text" name="sms_sender_id" class="api-input" value="{{ $school->sms_sender_id }}" placeholder="e.g. EduCorexa or School Name" {{ !$school->hasPackagePermission('sms.send') ? 'disabled' : '' }}>
                                    </div>
                                    <div class="col-12">
                                        <div class="api-status-box api-status-amber small mb-0">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                            {{ $school->hasPackagePermission('sms.send') ? __('Leave provider blank to stop all SMS dispatch.') : __('Upgrade the institution package to enable SMS gateway access.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── 5. Inbound Webhook Settings ── --}}
                    <div class="col-lg-7">
                        <div class="api-section-card">
                            <div class="api-card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="api-card-icon icon-purple">
                                        <i class="fa-solid fa-inbox"></i>
                                    </div>
                                    <div>
                                        <h6 class="api-card-title">{{ __('Incoming Email Webhook') }}</h6>
                                        <p class="api-card-desc">{{ __('Receive incoming emails automatically in School Email Inbox') }}</p>
                                    </div>
                                </div>
                                <span class="badge bg-purple-subtle text-purple fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                    Webhook
                                </span>
                            </div>
                            <div class="api-card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="inbound_webhook_enabled" value="1" id="inbound_toggle" {{ $school->inbound_webhook_enabled ? 'checked' : '' }} style="cursor: pointer;">
                                    <label class="form-check-label fw-bold text-dark small" for="inbound_toggle">{{ __('Enable receiving emails into School Inbox') }}</label>
                                </div>
                                <div class="mb-3">
                                    <label class="api-label">{{ __('Webhook Secret Token') }}</label>
                                    <input type="password" name="inbound_webhook_secret" class="api-input" placeholder="{{ __('Leave empty to preserve existing secret') }}">
                                </div>
                                <div class="api-webhook-code-box">
                                    <div class="text-truncate">
                                        <span class="text-muted me-1">URL:</span>
                                        <span id="webhookUrlText">{{ url('/webhooks/inbound-email') }}</span>
                                    </div>
                                    <button type="button" class="btn-copy-sm" onclick="copyText('webhookUrlText')">
                                        <i class="fa-solid fa-copy me-1"></i> Copy
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2" style="font-size: 11px;">
                                    {{ __('Send the secret in the header:') }} <code>X-Inbound-Mail-Secret</code>
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- ── 6. IMAP Polling Inbox ── --}}
                    <div class="col-lg-5">
                        <div class="api-section-card">
                            <div class="api-card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="api-card-icon icon-blue">
                                        <i class="fa-solid fa-envelope-open"></i>
                                    </div>
                                    <div>
                                        <h6 class="api-card-title">{{ __('IMAP Mailbox Polling') }}</h6>
                                        <p class="api-card-desc">{{ __('Direct inbox polling for incoming messages') }}</p>
                                    </div>
                                </div>
                                <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                    IMAP
                                </span>
                            </div>
                            <div class="api-card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="imap_enabled" value="1" id="imap_toggle" {{ $school->imap_enabled ? 'checked' : '' }} style="cursor: pointer;">
                                    <label class="form-check-label fw-bold text-dark small" for="imap_toggle">{{ __('Enable IMAP polling') }}</label>
                                </div>
                                <div class="row g-2">
                                    <div class="col-8">
                                        <label class="api-label">{{ __('Host') }}</label>
                                        <input type="text" name="imap_host" class="api-input" value="{{ $school->imap_host }}" placeholder="mail.domain.com">
                                    </div>
                                    <div class="col-4">
                                        <label class="api-label">{{ __('Port') }}</label>
                                        <input type="number" name="imap_port" class="api-input" value="{{ $school->imap_port ?: 993 }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="api-label">{{ __('Username') }}</label>
                                        <input type="email" name="imap_username" class="api-input" value="{{ $school->imap_username }}" placeholder="school@example.com">
                                    </div>
                                    <div class="col-12">
                                        <label class="api-label">{{ __('Password') }}</label>
                                        <input type="password" name="imap_password" class="api-input" placeholder="{{ __('Leave empty to keep current') }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="api-label">{{ __('Security') }}</label>
                                        <select name="imap_encryption" class="api-select">
                                            <option value="ssl" @selected($school->imap_encryption === 'ssl')>SSL/TLS</option>
                                            <option value="tls" @selected($school->imap_encryption === 'tls')>TLS</option>
                                            <option value="none" @selected($school->imap_encryption === 'none')>None</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="api-label">{{ __('Folder') }}</label>
                                        <input type="text" name="imap_folder" class="api-input" value="{{ $school->imap_folder ?: 'INBOX' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Bottom Save Action Bar ── --}}
                <div class="api-action-bar">
                    <button type="submit" class="btn-api-save">
                        <i class="fa-solid fa-cloud-arrow-up"></i> {{ __('Save All API Settings (সকল সেটিংস সংরক্ষণ করুন)') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Request Professional Email Modal -->
<div class="modal fade" id="requestEmailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #e0e7ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa-solid fa-envelope-circle-check"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-dark">{{ __('Request Professional Email') }}</h5>
                        <small class="text-muted">{{ __('Custom institutional mailbox provisioning') }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.school.pro-email.request', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                @csrf
                <div class="modal-body py-4 px-4">
                    <p class="text-muted small mb-4">
                        {{ __('Choose a prefix for your official school mailbox. We will provision it under your institution domain.') }}
                    </p>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">{{ __('Email Prefix') }}</label>
                        <div class="input-group">
                            <input type="text" name="prefix" class="form-control" placeholder="e.g. info, admin, principal" required>
                            <span class="input-group-text bg-light text-muted fw-bold">@ {{ $school->slug }}.{{ parse_url(config('app.url'), PHP_URL_HOST) ?? 'educorexa.com' }}</span>
                        </div>
                        <div class="form-text mt-2 small">
                            {{ __('Example:') }} info@{{ $school->slug }}.{{ parse_url(config('app.url'), PHP_URL_HOST) ?? 'educorexa.com' }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">{{ __('Submit Request') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function togglePass(id) {
        let x = document.getElementById(id);
        if (!x) return;
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function copyText(elemId) {
        const elem = document.getElementById(elemId);
        if (!elem) return;
        const text = elem.textContent || elem.innerText;
        navigator.clipboard.writeText(text).then(() => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                customClass: { popup: 'edu-top-toast' }
            });
            Toast.fire({
                icon: 'success',
                title: 'Copied to clipboard: ' + text
            });
        });
    }

    // ═════════════════════════════════════════════════════════════
    // TOP TOAST ALERT (SweetAlert2)
    // ═════════════════════════════════════════════════════════════
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        iconColor: '#10b981',
        customClass: {
            popup: 'edu-top-toast'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: @json(session('success'))
        });
    @endif

    @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: @json(session('error')),
            customClass: {
                popup: 'edu-top-toast edu-top-toast-error'
            }
        });
    @endif

    @if($errors->any())
        Toast.fire({
            icon: 'error',
            title: @json($errors->first()),
            customClass: {
                popup: 'edu-top-toast edu-top-toast-error'
            }
        });
    @endif
</script>
@endsection
