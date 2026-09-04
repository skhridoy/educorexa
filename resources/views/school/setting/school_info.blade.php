@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ═════════════════════════════════════════════════════════════
           SCHOOL SETTINGS & INFO PAGE REDESIGN
        ══════════════════════════════════════════════════════════════ */
        .info-page-wrap {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* ── Hero Header ── */
        .info-header-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 20px;
            padding: 24px 28px;
            color: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .info-header-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .info-header-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);
        }
        .info-header-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0;
            color: #ffffff;
            line-height: 1.25;
        }
        .info-header-sub {
            font-size: 12.5px;
            color: #94a3b8;
            margin-top: 3px;
        }
        .info-code-badge {
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

        /* ── Settings Navigation Tabs ── */
        .info-tabs-bar {
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
        .info-tab-link {
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
        .info-tab-link:hover {
            color: #4f46e5;
            background: #f1f5f9;
        }
        .info-tab-link.active {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            box-shadow: 0 3px 12px rgba(79, 70, 229, 0.3);
        }

        /* ── Modern Card Section ── */
        .info-section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.04);
            overflow: hidden;
            margin-bottom: 24px;
            transition: all 0.2s ease;
        }
        .info-section-card:hover {
            box-shadow: 0 6px 24px rgba(79, 70, 229, 0.07);
        }
        .info-card-header {
            padding: 16px 22px;
            background: linear-gradient(135deg, #fafbff 0%, #f1f5ff 100%);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .info-card-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            color: #ffffff;
            flex-shrink: 0;
        }
        .icon-indigo {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            box-shadow: 0 3px 8px rgba(79, 70, 229, 0.25);
        }
        .icon-sky {
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            box-shadow: 0 3px 8px rgba(14, 165, 233, 0.25);
        }
        .icon-emerald {
            background: linear-gradient(135deg, #10b981, #34d399);
            box-shadow: 0 3px 8px rgba(16, 185, 129, 0.25);
        }
        .icon-purple {
            background: linear-gradient(135deg, #8b5cf6, #a855f7);
            box-shadow: 0 3px 8px rgba(139, 92, 246, 0.25);
        }
        .info-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.25;
        }
        .info-card-desc {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        .info-card-body {
            padding: 22px;
        }

        /* ── Input Controls ── */
        .info-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .info-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .info-input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 13.5px;
            pointer-events: none;
            transition: color 0.2s ease;
        }
        .info-input {
            width: 100%;
            height: 40px;
            padding: 8px 14px 8px 38px;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            background-color: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            transition: all 0.2s ease;
            outline: none;
        }
        .info-input:focus {
            background-color: #ffffff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }
        .info-input:focus + .info-input-icon,
        .info-input-wrap:focus-within .info-input-icon {
            color: #4f46e5;
        }
        .info-input.is-readonly {
            background-color: #f1f5f9;
            color: #64748b;
            cursor: default;
        }

        /* ── Copy Button inside App Code ── */
        .btn-copy-code {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #4f46e5;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 7px;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-copy-code:hover {
            background: #4f46e5;
            color: #ffffff;
        }

        /* ── Modern Select Box ── */
        .info-select-modern {
            width: 100%;
            height: 40px;
            padding: 8px 34px 8px 12px;
            font-size: 12.5px;
            font-weight: 600;
            color: #1e293b;
            background-color: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            transition: all 0.2s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 11px center;
            background-size: 14px 14px;
            cursor: pointer;
            outline: none;
        }
        .info-select-modern:hover {
            border-color: #94a3b8;
            background-color: #ffffff;
        }
        .info-select-modern:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            background-color: #ffffff;
        }
        .info-select-modern:disabled {
            background-color: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            border-color: #e2e8f0;
        }

        /* ── Textarea ── */
        .info-textarea {
            width: 100%;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 500;
            color: #1e293b;
            background-color: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            transition: all 0.2s ease;
            outline: none;
            resize: vertical;
            min-height: 80px;
        }
        .info-textarea:focus {
            background-color: #ffffff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        /* ── Branding Assets Upload Box ── */
        .asset-upload-card {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.2s ease;
            position: relative;
        }
        .asset-upload-card:hover {
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.05);
        }
        .asset-preview-box {
            width: 72px; height: 72px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        .asset-preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .asset-preview-box i {
            font-size: 28px;
            color: #94a3b8;
        }
        .asset-upload-meta {
            flex: 1;
            min-width: 0;
        }
        .asset-upload-title {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 2px;
        }
        .asset-upload-hint {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 8px;
            line-height: 1.35;
        }
        .asset-file-btn {
            font-size: 11.5px;
            font-weight: 700;
            color: #4f46e5;
            background: #ffffff;
            border: 1px solid #c7d2fe;
            padding: 5px 12px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }
        .asset-file-btn:hover {
            background: #4f46e5;
            color: #ffffff;
        }

        /* ── Browser Tab Mockup for Favicon ── */
        .browser-mockup-tab {
            background: #e2e8f0;
            border-radius: 8px 8px 0 0;
            padding: 5px 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            color: #334155;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            border-bottom: 1.5px solid #cbd5e1;
        }

        /* ── Submit Action Bar ── */
        .info-action-bar {
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
        }
        .btn-info-submit {
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
        .btn-info-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            color: #ffffff;
        }
        .btn-info-reset {
            padding: 11px 18px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-info-reset:hover {
            background: #e2e8f0;
            color: #1e293b;
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
        [data-bs-theme="dark"] .info-tabs-bar,
        body.dark-mode .info-tabs-bar,
        [data-bs-theme="dark"] .info-section-card,
        body.dark-mode .info-section-card,
        [data-bs-theme="dark"] .info-action-bar,
        body.dark-mode .info-action-bar {
            background: #0c1427 !important;
            border-color: #1a253b !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
        }
        [data-bs-theme="dark"] .info-card-header,
        body.dark-mode .info-card-header {
            background: linear-gradient(135deg, #0c1427, #111d35) !important;
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .info-card-title,
        body.dark-mode .info-card-title {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .info-card-desc,
        body.dark-mode .info-card-desc {
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .info-label,
        body.dark-mode .info-label {
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .info-input,
        body.dark-mode .info-input,
        [data-bs-theme="dark"] .info-textarea,
        body.dark-mode .info-textarea,
        [data-bs-theme="dark"] .info-select-modern,
        body.dark-mode .info-select-modern {
            background-color: #111d35 !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .info-input.is-readonly,
        body.dark-mode .info-input.is-readonly,
        [data-bs-theme="dark"] .info-select-modern:disabled,
        body.dark-mode .info-select-modern:disabled {
            background-color: #0b1324 !important;
            border-color: #1a253b !important;
            color: #64748b !important;
        }
        [data-bs-theme="dark"] .asset-upload-card,
        body.dark-mode .asset-upload-card {
            background-color: #111d35 !important;
            border-color: #1e293b !important;
        }
        [data-bs-theme="dark"] .asset-preview-box,
        body.dark-mode .asset-preview-box {
            background-color: #0c1427 !important;
            border-color: #1e293b !important;
        }
        [data-bs-theme="dark"] .asset-upload-title,
        body.dark-mode .asset-upload-title {
            color: #f1f5f9 !important;
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
        <div class="info-page-wrap">

            {{-- ═════════════════════════════════════════════════════════════
                 PAGE HERO HEADER
            ══════════════════════════════════════════════════════════════ --}}
            <div class="info-header-card">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="info-header-icon">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <div>
                            <h4 class="info-header-title">{{ __('School Settings & Profile (স্কুল সেটিংস ও প্রোফাইল)') }}</h4>
                            <p class="info-header-sub mb-0">
                                {{ __('Update your institution profile, regional location, branding logo and credentials') }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="info-code-badge">
                            <i class="fa-solid fa-qrcode text-warning"></i>
                            App Code: <strong class="text-white">{{ $school->app_code ?? 'N/A' }}</strong>
                        </span>
                        <span class="info-code-badge" style="background: rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.4);">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            {{ ucfirst($school->status ?? 'Active') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ═════════════════════════════════════════════════════════════
                 SETTINGS NAVIGATION TABS
            ══════════════════════════════════════════════════════════════ --}}
            <div class="info-tabs-bar">
                <a href="{{ route('admin.school.info-edit', ['tenant' => auth()->user()->school->slug]) }}" class="info-tab-link active">
                    <i class="fa-solid fa-sliders"></i> {{ __('General Profile') }}
                </a>
                <a href="{{ route('admin.school.api-setup', ['tenant' => auth()->user()->school->slug]) }}" class="info-tab-link">
                    <i class="fa-solid fa-plug"></i> {{ __('API & SMTP Setup') }}
                </a>
                <a href="{{ route('admin.school.communication', ['tenant' => auth()->user()->school->slug]) }}" class="info-tab-link">
                    <i class="fa-solid fa-comments"></i> {{ __('Communication') }}
                </a>
            </div>

            {{-- ═════════════════════════════════════════════════════════════
                 SETTINGS UPDATE FORM
            ══════════════════════════════════════════════════════════════ --}}
            <form action="{{ route('admin.school.info-update', ['tenant' => auth()->user()->school->slug]) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  id="schoolInfoForm">
                @csrf

                {{-- ── SECTION 1: Institutional General Details ── --}}
                <div class="info-section-card">
                    <div class="info-card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="info-card-icon icon-indigo">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div>
                                <h6 class="info-card-title">{{ __('Institutional Information (প্রাতিষ্ঠানিক মৌলিক তথ্য)') }}</h6>
                                <p class="info-card-desc">{{ __('General identification codes, institutional name and official contacts') }}</p>
                            </div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                            {{ __('Basic Info') }}
                        </span>
                    </div>
                    <div class="info-card-body">
                        <div class="row g-3">
                            {{-- School Name --}}
                            <div class="col-md-6">
                                <label class="info-label">
                                    <i class="fa-solid fa-school text-primary"></i>
                                    {{ __('School Name') }} <span class="text-danger">*</span>
                                </label>
                                <div class="info-input-wrap">
                                    <i class="fa-solid fa-school info-input-icon"></i>
                                    <input type="text" name="name" class="info-input" 
                                           value="{{ old('name', $school->name) }}" 
                                           placeholder="e.g. Dhaka Ideal High School & College" required>
                                </div>
                            </div>

                            {{-- Official Email --}}
                            <div class="col-md-6">
                                <label class="info-label">
                                    <i class="fa-solid fa-envelope text-primary"></i>
                                    {{ __('Official Email') }}
                                </label>
                                <div class="info-input-wrap">
                                    <i class="fa-solid fa-envelope info-input-icon"></i>
                                    <input type="email" name="email" class="info-input" 
                                           value="{{ old('email', $school->email) }}" 
                                           placeholder="contact@school.edu.bd">
                                </div>
                            </div>

                            {{-- Phone Number --}}
                            <div class="col-md-4">
                                <label class="info-label">
                                    <i class="fa-solid fa-phone text-primary"></i>
                                    {{ __('Phone Number') }}
                                </label>
                                <div class="info-input-wrap">
                                    <i class="fa-solid fa-phone info-input-icon"></i>
                                    <input type="text" name="phone" class="info-input" 
                                           value="{{ old('phone', $school->phone) }}" 
                                           placeholder="+880 1XXX-XXXXXX">
                                </div>
                            </div>

                            {{-- EIN Number --}}
                            <div class="col-md-4">
                                <label class="info-label">
                                    <i class="fa-solid fa-id-card text-primary"></i>
                                    {{ __('EIIN Number') }}
                                </label>
                                <div class="info-input-wrap">
                                    <i class="fa-solid fa-id-card info-input-icon"></i>
                                    <input type="text" name="ein_number" class="info-input" 
                                           value="{{ old('ein_number', $school->ein_number) }}" 
                                           placeholder="e.g. 132456">
                                </div>
                            </div>

                            {{-- EMIS Code --}}
                            <div class="col-md-4">
                                <label class="info-label">
                                    <i class="fa-solid fa-barcode text-primary"></i>
                                    {{ __('EMIS Code') }}
                                </label>
                                <div class="info-input-wrap">
                                    <i class="fa-solid fa-barcode info-input-icon"></i>
                                    <input type="text" name="emis_code" class="info-input" 
                                           value="{{ old('emis_code', $school->emis_code) }}" 
                                           placeholder="e.g. 804020101">
                                </div>
                            </div>

                            {{-- App Code (Auto Generated & Read-only) --}}
                            <div class="col-md-6">
                                <label class="info-label">
                                    <i class="fa-solid fa-qrcode text-warning"></i>
                                    {{ __('App Code (Auto Generated)') }}
                                </label>
                                <div class="info-input-wrap">
                                    <i class="fa-solid fa-qrcode info-input-icon text-warning"></i>
                                    <input type="text" id="schoolAppCode" class="info-input is-readonly" 
                                           value="{{ $school->app_code ?? 'N/A' }}" readonly>
                                    @if(!empty($school->app_code))
                                        <button type="button" class="btn-copy-code" onclick="copyAppCode()" title="{{ __('Copy to clipboard') }}">
                                            <i class="fa-solid fa-copy me-1"></i> Copy
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- Slug / Domain --}}
                            <div class="col-md-6">
                                <label class="info-label">
                                    <i class="fa-solid fa-globe text-info"></i>
                                    {{ __('Institution Slug / Subdomain') }}
                                </label>
                                <div class="info-input-wrap">
                                    <i class="fa-solid fa-globe info-input-icon text-info"></i>
                                    <input type="text" class="info-input is-readonly" 
                                           value="{{ $school->slug }}.educorexa.com" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── SECTION 2: Location & Address ── --}}
                <div class="info-section-card">
                    <div class="info-card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="info-card-icon icon-sky">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </div>
                            <div>
                                <h6 class="info-card-title">{{ __('Location & Regional Reporting (ঠিকানা ও ভৌগোলিক তথ্য)') }}</h6>
                                <p class="info-card-desc">{{ __('Division, district and upazila hierarchy for geographic identification and reporting') }}</p>
                            </div>
                        </div>
                        <span class="badge bg-info-subtle text-info fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                            {{ __('Geographic') }}
                        </span>
                    </div>
                    <div class="info-card-body">
                        <div class="row g-3">
                            {{-- Division --}}
                            <div class="col-md-4">
                                <label class="info-label">
                                    <i class="fa-solid fa-map text-primary"></i>
                                    {{ __('Division (বিভাগ)') }}
                                </label>
                                <select name="division" id="division" class="info-select-modern" data-selected="{{ $school->division }}">
                                    <option value="">{{ __('Select division') }}</option>
                                </select>
                            </div>

                            {{-- District --}}
                            <div class="col-md-4">
                                <label class="info-label">
                                    <i class="fa-solid fa-city text-primary"></i>
                                    {{ __('District (জেলা)') }}
                                </label>
                                <select name="district" id="district" class="info-select-modern" data-selected="{{ $school->district }}" disabled>
                                    <option value="">{{ __('Select district') }}</option>
                                </select>
                            </div>

                            {{-- Upazila --}}
                            <div class="col-md-4">
                                <label class="info-label">
                                    <i class="fa-solid fa-location-arrow text-primary"></i>
                                    {{ __('Upazila / Thana (উপজেলা/থানা)') }}
                                </label>
                                <select name="upazila" id="upazila" class="info-select-modern" data-selected="{{ $school->upazila }}" disabled>
                                    <option value="">{{ __('Select upazila') }}</option>
                                </select>
                            </div>

                            {{-- Institutional Street Address --}}
                            <div class="col-12">
                                <label class="info-label">
                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                    {{ __('Institutional Full Address (বিস্তারিত ঠিকানা)') }}
                                </label>
                                <textarea name="address" class="info-textarea" rows="3" 
                                          placeholder="e.g. House #12, Road #4, Sector #3, Uttara, Dhaka-1230">{{ old('address', $school->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── SECTION 3: Branding & Visual Assets ── --}}
                <div class="info-section-card">
                    <div class="info-card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="info-card-icon icon-purple">
                                <i class="fa-solid fa-palette"></i>
                            </div>
                            <div>
                                <h6 class="info-card-title">{{ __('Branding & Assets (লোগো ও ভিজ্যুয়াল আইডেন্টিটি)') }}</h6>
                                <p class="info-card-desc">{{ __('Upload your school logo for report cards, bills and favicon for browser branding') }}</p>
                            </div>
                        </div>
                        <span class="badge bg-purple-subtle text-purple fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                            {{ __('Visuals') }}
                        </span>
                    </div>
                    <div class="info-card-body">
                        <div class="row g-4">
                            {{-- School Logo --}}
                            <div class="col-md-6">
                                <div class="asset-upload-card">
                                    <div class="asset-preview-box" id="logoPreviewContainer">
                                        @if($school->logo && file_exists(public_path($school->logo)))
                                            <img src="{{ asset($school->logo) }}?v={{ time() }}" alt="School Logo" id="logoPreviewImg">
                                        @else
                                            <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Default Logo" id="logoPreviewImg" 
                                                 onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($school->name) }}&background=4f46e5&color=fff&size=128';">
                                        @endif
                                    </div>
                                    <div class="asset-upload-meta">
                                        <div class="asset-upload-title">{{ __('School Official Logo') }}</div>
                                        <div class="asset-upload-hint">
                                            {{ __('Appears on student admit cards, money receipts & documents.') }}<br>
                                            <span class="text-muted">{{ __('PNG, JPG, JPEG (Max 2MB)') }}</span>
                                        </div>
                                        <label class="asset-file-btn">
                                            <i class="fa-solid fa-cloud-arrow-up"></i> {{ __('Choose Logo') }}
                                            <input type="file" name="logo" id="logoInput" accept="image/png, image/jpeg, image/jpg" class="d-none" onchange="previewImage(this, 'logoPreviewImg')">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Favicon --}}
                            <div class="col-md-6">
                                <div class="asset-upload-card">
                                    <div class="d-flex flex-column align-items-center gap-1 flex-shrink-0">
                                        <div class="browser-mockup-tab" title="{{ $school->name }}">
                                            <img src="{{ !empty($school->favicon) ? asset($school->favicon).'?v='.time() : asset('default-favicon.png') }}" 
                                                 alt="Favicon" id="faviconPreviewImg" style="width: 14px; height: 14px; object-fit: contain;">
                                            <span style="font-size: 10px; max-width: 90px;" class="text-truncate">{{ Str::limit($school->name, 14) }}</span>
                                        </div>
                                        <div class="asset-preview-box" style="width: 48px; height: 48px;">
                                            <img src="{{ !empty($school->favicon) ? asset($school->favicon).'?v='.time() : asset('default-favicon.png') }}" 
                                                 alt="Favicon" id="faviconLargeImg" style="width: 28px; height: 28px; object-fit: contain;">
                                        </div>
                                    </div>
                                    <div class="asset-upload-meta">
                                        <div class="asset-upload-title">{{ __('Browser Favicon (32x32)') }}</div>
                                        <div class="asset-upload-hint">
                                            {{ __('Small icon displayed next to your website title in browser tabs.') }}<br>
                                            <span class="text-muted">{{ __('ICO, PNG, JPG (Square 32x32 or 64x64)') }}</span>
                                        </div>
                                        <label class="asset-file-btn">
                                            <i class="fa-solid fa-cloud-arrow-up"></i> {{ __('Choose Favicon') }}
                                            <input type="file" name="favicon" id="faviconInput" accept="image/x-icon, image/png, image/jpeg, image/jpg" class="d-none" onchange="previewFavicon(this)">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Bottom Save Action Bar ── --}}
                <div class="info-action-bar">
                    <a href="{{ route('admin.school.info-edit', ['tenant' => auth()->user()->school->slug]) }}" class="btn-info-reset">
                        <i class="fa-solid fa-rotate-left me-1"></i> {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn-info-submit" id="saveInfoBtn">
                        <i class="fa-solid fa-cloud-arrow-up"></i> {{ __('Save Changes (পরিবর্তন সংরক্ষণ করুন)') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    // Copy App Code helper
    function copyAppCode() {
        const codeInput = document.getElementById('schoolAppCode');
        if (!codeInput || !codeInput.value || codeInput.value === 'N/A') return;
        
        navigator.clipboard.writeText(codeInput.value).then(() => {
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
                title: 'App Code Copied: ' + codeInput.value
            });
        });
    }

    // Image preview helper for School Logo
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Favicon preview helper for both mockup tab and large square
    function previewFavicon(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const small = document.getElementById('faviconPreviewImg');
                const large = document.getElementById('faviconLargeImg');
                if (small) small.src = e.target.result;
                if (large) large.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Locations Loader (Division, District, Upazila)
    document.addEventListener('DOMContentLoaded', function () {
        const division = document.getElementById('division');
        const district = document.getElementById('district');
        const upazila = document.getElementById('upazila');

        const selectedDivision = (division.dataset.selected || '').trim();
        const selectedDistrict = (district.dataset.selected || '').trim();
        const selectedUpazila = (upazila.dataset.selected || '').trim();

        let locations = [];

        const isMatch = (item, target) => {
            if (!target) return false;
            const t = String(target).trim().toLowerCase();
            const n = (item.name || '').trim().toLowerCase();
            const bn = (item.name_bn || '').trim().toLowerCase();
            return t === n || t === bn;
        };

        const resetSelect = (select, placeholder) => {
            select.innerHTML = `<option value="">${placeholder}</option>`;
            select.disabled = true;
        };

        const populateUpazilas = (distObj, preSelected = '') => {
            resetSelect(upazila, 'Select upazila');
            if (!distObj || !Array.isArray(distObj.upazilas) || distObj.upazilas.length === 0) return;

            distObj.upazilas.forEach(u => {
                const opt = document.createElement('option');
                opt.value = u.name;
                opt.textContent = u.name_bn ? `${u.name_bn} (${u.name})` : u.name;
                if (isMatch(u, preSelected)) {
                    opt.selected = true;
                }
                upazila.appendChild(opt);
            });
            upazila.disabled = false;
        };

        const populateDistricts = (divObj, preSelectedDist = '', preSelectedUpz = '') => {
            resetSelect(district, 'Select district');
            resetSelect(upazila, 'Select upazila');
            if (!divObj || !Array.isArray(divObj.districts) || divObj.districts.length === 0) return;

            let matchedDist = null;
            divObj.districts.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.name;
                opt.textContent = d.name_bn ? `${d.name_bn} (${d.name})` : d.name;
                if (isMatch(d, preSelectedDist)) {
                    opt.selected = true;
                    matchedDist = d;
                }
                district.appendChild(opt);
            });
            district.disabled = false;

            if (matchedDist) {
                populateUpazilas(matchedDist, preSelectedUpz);
            }
        };

        const initLocations = (data) => {
            locations = data.divisions || data || [];
            division.innerHTML = '<option value="">Select division</option>';

            let matchedDiv = null;
            locations.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.name;
                opt.textContent = d.name_bn ? `${d.name_bn} (${d.name})` : d.name;
                if (isMatch(d, selectedDivision)) {
                    opt.selected = true;
                    matchedDiv = d;
                }
                division.appendChild(opt);
            });

            if (matchedDiv) {
                populateDistricts(matchedDiv, selectedDistrict, selectedUpazila);
            }
        };

        // Load from local JSON asset directly
        const jsonUrl = @json(asset('data/bangladesh-locations.json'));
        fetch(jsonUrl)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                initLocations(data);
            })
            .catch(err => {
                console.warn('Direct JSON fetch failed, trying backend route:', err);
                const backendDivUrl = @json(route('school.locations.divisions', ['tenant' => auth()->user()->school->slug]));
                fetch(backendDivUrl)
                    .then(r => r.json())
                    .then(divisions => {
                        division.innerHTML = '<option value="">Select division</option>';
                        divisions.forEach(d => {
                            const opt = document.createElement('option');
                            opt.value = d.name;
                            opt.textContent = d.name_bn ? `${d.name_bn} (${d.name})` : d.name;
                            if (isMatch(d, selectedDivision)) opt.selected = true;
                            division.appendChild(opt);
                        });
                    })
                    .catch(e => console.error('All location loaders failed:', e));
            });

        // Event listeners for selects
        division.addEventListener('change', function () {
            const divName = this.value;
            if (!divName) {
                resetSelect(district, 'Select district');
                resetSelect(upazila, 'Select upazila');
                return;
            }
            const divObj = locations.find(d => isMatch(d, divName));
            if (divObj) {
                populateDistricts(divObj);
            }
        });

        district.addEventListener('change', function () {
            const distName = this.value;
            if (!distName) {
                resetSelect(upazila, 'Select upazila');
                return;
            }
            const divName = division.value;
            const divObj = locations.find(d => isMatch(d, divName));
            const distObj = divObj ? (divObj.districts || []).find(d => isMatch(d, distName)) : null;
            if (distObj) {
                populateUpazilas(distObj);
            }
        });

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
    });
</script>
@endsection