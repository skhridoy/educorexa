@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Exact Exam Page Stats Bar */
        .fee-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 20px;
        }
        .fee-stat-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            backdrop-filter: blur(8px);
        }
        .fee-stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
        }
        .fee-stat-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }
        .fee-stat-lbl {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }

        /* ═════════════════════════════════════════════════════════════
           FEE AMOUNT PAGE CARDS & MODERN DESIGN SYSTEM
        ══════════════════════════════════════════════════════════════ */
        .fee-card-wrap {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(79, 70, 229, 0.06);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
        }
        .fee-card-wrap {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
        }
        .fee-card-header {
            padding: 13px 18px;
            background: linear-gradient(135deg, #fafbff 0%, #f1f5ff 100%);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
        .fee-card-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .fee-icon-indigo {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            box-shadow: 0 3px 8px rgba(79, 70, 229, 0.2);
        }
        .fee-icon-sky {
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            box-shadow: 0 3px 8px rgba(14, 165, 233, 0.2);
        }
        .fee-card-title {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.2;
        }
        .fee-card-subtitle {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        .fee-card-body {
            padding: 16px;
        }
        .fee-pill-badge {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: #4f46e5;
            font-weight: 700;
            font-size: 10.5px;
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid #c7d2fe;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .fee-pill-sky {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: #0284c7;
            border-color: #7dd3fc;
        }

        /* ── Modern Form Labels ── */
        .fee-form-label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            display: block;
            margin-bottom: 5px;
        }

        /* ── Modern Select Box (Compact, Tidy, No Arrow Overlap) ── */
        .fee-select-modern {
            width: 100%;
            height: 38px;
            padding: 7px 32px 7px 11px;
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
            background-position: right 10px center;
            background-size: 14px 14px;
            cursor: pointer;
        }
        .fee-select-modern:hover {
            border-color: #94a3b8;
            background-color: #ffffff;
        }
        .fee-select-modern:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            background-color: #ffffff;
        }

        /* ── Disable Number Input Steppers / Spin Buttons ── */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button,
        .fee-amount-input::-webkit-inner-spin-button,
        .fee-amount-input::-webkit-outer-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }
        input[type="number"],
        .fee-amount-input {
            -moz-appearance: textfield !important;
        }

        /* ── Class-wise Fee Table & Input Wrap ── */
        .fee-class-table-box {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.02);
            margin-bottom: 16px;
        }
        .fee-class-table-scroll {
            max-height: 300px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .fee-class-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }
        .fee-class-table thead tr th {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            padding: 8px 12px;
            position: sticky;
            top: 0;
            z-index: 5;
        }
        .fee-class-table tbody tr {
            transition: background 0.15s ease;
        }
        .fee-class-table tbody tr:hover {
            background: #f8faff;
        }
        .fee-class-table tbody tr td {
            padding: 6px 12px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 12px;
        }
        .fee-class-table tbody tr:last-child td {
            border-bottom: none;
        }
        .fee-class-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #4f46e5;
            display: inline-block;
            flex-shrink: 0;
        }

        /* ── Modern Amount Input Wrap (Compact, No Spinner) ── */
        .fee-amount-input-wrap {
            display: flex;
            align-items: center;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            background: #f8fafc;
            overflow: hidden;
            width: 110px;
            margin-left: auto;
            transition: all 0.2s ease;
        }
        .fee-amount-input-wrap:hover {
            border-color: #94a3b8;
            background: #ffffff;
        }
        .fee-amount-input-wrap:focus-within {
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 0 0 2.5px rgba(79, 70, 229, 0.15);
        }
        .fee-curr-prefix {
            padding: 4px 7px;
            font-size: 12px;
            font-weight: 700;
            color: #4f46e5;
            background: #eef2ff;
            border-right: 1px solid #c7d2fe;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .fee-amount-input {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 12.5px;
            font-weight: 700;
            color: #1e293b;
            text-align: right;
            padding: 4px 6px;
            outline: none;
        }
        .fee-amount-input::placeholder {
            color: #94a3b8;
            font-weight: 500;
        }

        /* ── Primary Submit Button ── */
        .fee-btn-save {
            width: 100%;
            padding: 10px 16px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.25);
            transition: all 0.2s ease;
        }
        .fee-btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.35);
            color: #ffffff;
        }

        /* ═════════════════════════════════════════════════════════════
           RIGHT TABLE: CURRENT CONFIGURATIONS
        ══════════════════════════════════════════════════════════════ */
        .fee-list-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }
        .fee-list-table thead tr th {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            padding: 11px 14px;
            white-space: nowrap;
        }
        .fee-list-table tbody tr {
            transition: background 0.15s ease;
        }
        .fee-list-table tbody tr:hover {
            background: #f8faff;
        }
        .fee-list-table tbody tr td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 12px;
        }
        .fee-list-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Fee Head Badge */
        .fee-head-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            color: #4338ca;
            border: 1px solid #c7d2fe;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 16px;
            box-shadow: 0 1px 2px rgba(79, 70, 229, 0.05);
        }

        /* Class pill in table */
        .fee-class-pill {
            display: inline-flex;
            align-items: center;
            font-size: 10.5px;
            font-weight: 700;
            color: #334155;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 1px 8px;
            border-radius: 12px;
            margin-top: 2px;
        }

        /* Amount Display */
        .fee-amount-val {
            font-size: 13.5px;
            font-weight: 800;
            color: #059669;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            white-space: nowrap;
        }
        .fee-amount-val .fee-taka-sign {
            font-size: 12px;
            font-weight: 700;
            color: #10b981;
        }

        /* Action Buttons */
        .fee-btn-edit {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            background: #eff6ff !important;
            color: #2563eb !important;
            border: 1px solid #bfdbfe !important;
            transition: all 0.2s;
            font-size: 12px;
            cursor: pointer;
        }
        .fee-btn-edit:hover {
            background: #2563eb !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
        }
        .fee-btn-del {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            background: #fef2f2 !important;
            color: #dc2626 !important;
            border: 1px solid #fecaca !important;
            transition: all 0.2s;
            font-size: 12px;
            cursor: pointer;
        }
        .fee-btn-del:hover {
            background: #dc2626 !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
        }

        /* ═════════════════════════════════════════════════════════════
           DARK MODE OVERRIDES
        ══════════════════════════════════════════════════════════════ */
        [data-bs-theme="dark"] .fee-card-wrap,
        body.dark-mode .fee-card-wrap {
            background: #0c1427 !important;
            border-color: #1a253b !important;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.3) !important;
        }
        [data-bs-theme="dark"] .fee-card-header,
        body.dark-mode .fee-card-header {
            background: linear-gradient(135deg, #0c1427, #111d35) !important;
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .fee-card-title,
        body.dark-mode .fee-card-title {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .fee-card-subtitle,
        body.dark-mode .fee-card-subtitle {
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .fee-form-label,
        body.dark-mode .fee-form-label {
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .fee-select-modern,
        body.dark-mode .fee-select-modern {
            background-color: #111d35 !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2394a3b8'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
        }
        [data-bs-theme="dark"] .fee-select-modern:focus,
        body.dark-mode .fee-select-modern:focus {
            border-color: #6366f1 !important;
            background-color: #14213d !important;
        }
        [data-bs-theme="dark"] .fee-class-table-box,
        body.dark-mode .fee-class-table-box {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .fee-class-table thead tr th,
        body.dark-mode .fee-class-table thead tr th,
        [data-bs-theme="dark"] .fee-list-table thead tr th,
        body.dark-mode .fee-list-table thead tr th {
            background: #111d35 !important;
            border-color: #1a253b !important;
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .fee-class-table tbody tr:hover,
        body.dark-mode .fee-class-table tbody tr:hover,
        [data-bs-theme="dark"] .fee-list-table tbody tr:hover,
        body.dark-mode .fee-list-table tbody tr:hover {
            background: #111d35 !important;
        }
        [data-bs-theme="dark"] .fee-class-table tbody tr td,
        body.dark-mode .fee-class-table tbody tr td,
        [data-bs-theme="dark"] .fee-list-table tbody tr td,
        body.dark-mode .fee-list-table tbody tr td {
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .fee-amount-input-wrap,
        body.dark-mode .fee-amount-input-wrap {
            background: #111d35 !important;
            border-color: #1e293b !important;
        }
        [data-bs-theme="dark"] .fee-curr-prefix,
        body.dark-mode .fee-curr-prefix {
            background: #1a253b !important;
            border-color: #334155 !important;
            color: #818cf8 !important;
        }
        [data-bs-theme="dark"] .fee-amount-input,
        body.dark-mode .fee-amount-input {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .fee-class-pill,
        body.dark-mode .fee-class-pill {
            background: #111d35 !important;
            border-color: #1e293b !important;
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .fee-head-badge,
        body.dark-mode .fee-head-badge {
            background: #172554 !important;
            border-color: #1e3a8a !important;
            color: #93c5fd !important;
        }
        [data-bs-theme="dark"] .fee-amount-val,
        body.dark-mode .fee-amount-val {
            color: #34d399 !important;
        }
        [data-bs-theme="dark"] .fee-btn-edit,
        body.dark-mode .fee-btn-edit {
            background: #172554 !important;
            border-color: #1e3a8a !important;
            color: #60a5fa !important;
        }
        [data-bs-theme="dark"] .fee-btn-del,
        body.dark-mode .fee-btn-del {
            background: #450a0a !important;
            border-color: #7f1d1d !important;
            color: #f87171 !important;
        }

        @media (max-width: 991.98px) {
            .fee-stats-bar { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 767.98px) {
            .fee-stats-bar { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .fee-stat-card { padding: 10px 12px; gap: 10px; }
            .fee-stat-icon { width: 36px; height: 36px; font-size: 1.1rem; }
            .fee-stat-val  { font-size: 1.25rem; }
            .fee-stat-lbl  { font-size: 0.7rem; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ═════════════════════════════════════════════════════════════
         HERO HEADER CARD (Matches Exam Page Header Exactly)
    ══════════════════════════════════════════════════════════════ --}}
    <div class="page-header-card">
        <div class="page-header-content">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon">
                        <i class="fa-solid fa-coins text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ __('Fee Structures (ফি স্ট্রাকচার ও রেট নির্ধারণ)') }}</h4>
                        <p class="page-subtitle mb-0">
                            {{ __('Define class-wise and category-wise amount for each fee category') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('fee-heads.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-secondary">
                        <i class="fa-solid fa-tags"></i> {{ __('Manage Fee Heads') }}
                    </a>
                    <a href="{{ route('student-fees.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-primary">
                        <i class="fa-solid fa-bolt"></i> {{ __('Generate Bills') }}
                    </a>
                </div>
            </div>

            {{-- Exact Exam Stats Bar Component --}}
            <div class="fee-stats-bar">
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(59, 130, 246, 0.35);">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $feeAmounts->total() }}</div>
                        <div class="fee-stat-lbl">{{ __('Total Fee Rates') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(16, 185, 129, 0.35);">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $feeHeads->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('Available Fee Heads') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(245, 158, 11, 0.35);">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $categories->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('School Categories') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         MAIN CONTENT ROW
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row g-4">
        {{-- ── Left: Fee Setup Form ── --}}
        <div class="col-xl-4 col-lg-5 col-md-12">
            <div class="fee-card-wrap sticky-top" style="top: 80px; z-index: 10;">
                <div class="fee-card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fee-card-icon fee-icon-indigo">
                            <i class="fa-solid fa-plus-circle"></i>
                        </div>
                        <div>
                            <h6 class="fee-card-title">{{ __('Setup Category & Class Rates') }}</h6>
                            <small class="fee-card-subtitle">{{ __('Set class-wise fee amounts') }}</small>
                        </div>
                    </div>
                    <span class="fee-pill-badge">
                        <i class="fa-solid fa-tag"></i> {{ __('Fee Rates') }}
                    </span>
                </div>
                <div class="fee-card-body">
                    <form action="{{ route('fee-amounts.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="fee-form-label">
                                <i class="fa-solid fa-coins text-primary me-1"></i>
                                {{ __('Select Fee Head') }} <span class="text-danger">*</span>
                            </label>
                            <select name="fee_head_id" class="fee-select-modern" required>
                                <option value="" disabled selected>{{ __('Choose a Fee Head...') }}</option>
                                @foreach($feeHeads as $head)
                                    <option value="{{ $head->id }}">{{ $head->name }} ({{ ucfirst($head->type) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6 col-12">
                                <label class="fee-form-label">
                                    <i class="fa-solid fa-layer-group text-primary me-1"></i>
                                    {{ __('Category') }} <span class="text-danger">*</span>
                                </label>
                                <select id="setup_category_id" name="school_category_id" class="fee-select-modern" required>
                                    <option value="">{{ __('Select Category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-12">
                                <label class="fee-form-label">
                                    <i class="fa-solid fa-cubes text-info me-1"></i>
                                    {{ __('Sub-Category') }}
                                </label>
                                <select id="setup_sub_category_id" name="school_sub_category_id" class="fee-select-modern">
                                    <option value="">{{ __('None / All Groups') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <label class="fee-form-label mb-0">
                                <i class="fa-solid fa-graduation-cap text-primary me-1"></i>
                                {{ __('Class-wise Amounts (টাকা)') }}:
                            </label>
                        </div>
                        <div class="fee-class-table-box">
                            <div class="fee-class-table-scroll">
                                <table class="fee-class-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-3">{{ __('Class Name') }}</th>
                                            <th class="pe-3 text-end" style="width: 125px;">{{ __('Amount (৳)') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="class_amount_body">
                                        <tr>
                                            <td colspan="2" class="text-center py-4 text-muted small">
                                                <i class="fa-solid fa-layer-group d-block mb-2 fs-5 opacity-50 text-primary"></i>
                                                {{ __('প্রথমে ক্যাটেগরি সিলেক্ট করুন') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="fee-btn-save">
                            <i class="fa-solid fa-floppy-disk"></i> {{ __('Save Fee Structure') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Right: Existing Configurations List ── --}}
        <div class="col-xl-8 col-lg-7">
            <div class="fee-card-wrap">
                <div class="fee-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fee-card-icon fee-icon-sky">
                            <i class="fa-solid fa-table-list"></i>
                        </div>
                        <div>
                            <h6 class="fee-card-title">{{ __('Current Fee Configurations') }}</h6>
                            <small class="fee-card-subtitle">{{ __('All configured rates by head, class & category') }}</small>
                        </div>
                    </div>
                    <span class="fee-pill-badge fee-pill-sky">
                        <i class="fa-solid fa-sliders"></i> {{ $feeAmounts->total() }} {{ __('Rates Defined') }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="fee-list-table">
                        <thead>
                            <tr>
                                <th class="ps-3">{{ __('Fee Head') }}</th>
                                <th>{{ __('Category / Target') }}</th>
                                <th class="text-end">{{ __('Amount') }}</th>
                                <th class="text-center pe-3" style="width: 95px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeAmounts as $setup)
                            <tr>
                                <td class="ps-3">
                                    <span class="fee-head-badge">
                                        <i class="fa-solid fa-tag text-primary opacity-75"></i>
                                        {{ $setup->feeHead->name }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-12">{{ $setup->category->name ?? 'N/A' }}</div>
                                    @if($setup->subCategory)
                                        <div class="text-muted fs-11">{{ $setup->subCategory->name }}</div>
                                    @endif
                                    <span class="fee-class-pill">
                                        <i class="fa-solid fa-graduation-cap me-1 text-primary"></i>{{ $setup->class->name ?? 'All Classes' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="fee-amount-val">
                                        <span class="fee-taka-sign">৳</span>{{ number_format($setup->amount, 0) }}
                                    </span>
                                </td>
                                <td class="text-center pe-3">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        {{-- Edit Button --}}
                                        <button type="button" class="fee-btn-edit" 
                                                onclick="editFee('{{ $setup->id }}', '{{ $setup->amount }}', '{{ addslashes($setup->feeHead->name) }}')"
                                                title="{{ __('Quick Edit Amount') }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('fee-amounts.destroy', ['tenant' => auth()->user()->school->slug, 'fee_amount' => $setup->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="fee-btn-del" onclick="confirmDelete(this)" title="{{ __('Delete Rate') }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <div style="width: 64px; height: 64px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                                        <i class="fa-solid fa-receipt fs-2 text-secondary opacity-50"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">{{ __('No Fee Structure Configured') }}</h6>
                                    <p class="small text-muted mb-0">{{ __('Use the form on the left to set class-wise fee amounts.') }}</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($feeAmounts->hasPages())
                <div class="p-3 border-top d-flex justify-content-center">
                    {{ $feeAmounts->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    $(document).ready(function() {
        // Category change logic
        $('#setup_category_id').on('change', function() {
            let categoryId = $(this).val();
            let subCategorySelect = $('#setup_sub_category_id');
            
            if (categoryId) {
                $.ajax({
                    url: "{{ route('get-sub-categories', ['tenant' => auth()->user()->school->slug, 'categoryId' => ':id']) }}".replace(':id', categoryId),
                    method: 'GET',
                    success: function(data) {
                        subCategorySelect.html('<option value="">{{ __("None / All Groups") }}</option>');
                        $.each(data, function(key, value) {
                            subCategorySelect.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                        loadClassesForSetup(categoryId);
                    }
                });
            } else {
                subCategorySelect.html('<option value="">{{ __("None / All Groups") }}</option>');
                $('#class_amount_body').html('<tr><td colspan="2" class="text-center text-muted py-4">{{ __("প্রথমে ক্যাটেগরি সিলেক্ট করুন") }}</td></tr>');
            }
        });

        // Trigger reload on sub-category or fee head change
        $(document).on('change', '#setup_sub_category_id, select[name="fee_head_id"]', function() {
            let categoryId = $('#setup_category_id').val();
            if (categoryId) {
                loadClassesForSetup(categoryId);
            }
        });

        // Disable mouse wheel increment on number inputs
        $(document).on('wheel', 'input[type=number]', function (e) {
            $(this).blur();
        });
    });

    function loadClassesForSetup(categoryId) {
        let feeHeadId = $('select[name="fee_head_id"]').val();
        let subCategoryId = $('#setup_sub_category_id').val();

        if (!feeHeadId) {
            $('#class_amount_body').html('<tr><td colspan="2" class="text-center text-warning py-4">{{ __("প্রথমে Fee Head সিলেক্ট করুন") }}</td></tr>');
            return;
        }

        $('#class_amount_body').html('<tr><td colspan="2" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div> লোড হচ্ছে...</td></tr>');
        
        $.ajax({
            url: "{{ route('get-classes-by-category', ['tenant' => auth()->user()->school->slug]) }}",
            method: 'GET',
            data: { 
                category_id: categoryId,
                fee_head_id: feeHeadId,
                sub_category_id: subCategoryId
            },
            success: function(response) {
                let html = '';
                let classes = response.classes;
                let existingAmounts = response.existingAmounts; 

                if(classes.length > 0) {
                    $.each(classes, function(key, item) {
                        let amount = (existingAmounts && existingAmounts[item.id] !== undefined) ? existingAmounts[item.id] : '';
                        
                        html += `<tr>
                            <td class="ps-3 py-1 text-truncate" title="${item.name}">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fee-class-dot"></span>
                                    <span class="fw-bold text-dark fs-12 text-truncate">${item.name}</span>
                                </div>
                            </td>
                            <td class="pe-3 py-1 text-end" style="width: 125px;">
                                <div class="fee-amount-input-wrap">
                                    <span class="fee-curr-prefix">৳</span>
                                    <input type="number" name="amounts[${item.id}]" 
                                        value="${amount ? Math.round(amount) : ''}" 
                                        class="fee-amount-input" 
                                        placeholder="0" step="1"
                                        onwheel="this.blur()">
                                </div>
                            </td>
                        </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="2" class="text-center text-danger py-4"><i class="fa-solid fa-circle-exclamation me-1"></i> {{ __("কোনো ক্লাস পাওয়া যায়নি।") }}</td></tr>';
                }
                $('#class_amount_body').html(html);
            }
        });
    }

    // Delete Confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: '{{ __("আপনি কি নিশ্চিত?") }}',
            text: '{{ __("এটি ডিলিট করলে পুনরায় ফিরে পাওয়া যাবে না!") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> {{ __("হ্যাঁ, ডিলিট করুন") }}',
            cancelButtonText: '{{ __("বাতিল") }}',
            customClass: {
                confirmButton: 'rounded-pill px-4 py-2',
                cancelButton: 'rounded-pill px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // Edit Function via SweetAlert
    function editFee(id, amount, headName) {
        Swal.fire({
            title: headName,
            text: '{{ __("নতুন অ্যামাউন্ট লিখুন:") }}',
            input: 'number',
            inputAttributes: {
                step: '1'
            },
            inputValue: amount ? Math.round(amount) : '',
            showCancelButton: true,
            confirmButtonText: '{{ __("Update Rate") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#64748b',
            showLoaderOnConfirm: true,
            customClass: {
                confirmButton: 'rounded-pill px-4 py-2',
                cancelButton: 'rounded-pill px-4 py-2'
            },
            preConfirm: (newAmount) => {
                let tenantSlug = "{{ auth()->user()->school->slug }}";
                return $.ajax({
                    url: `/${tenantSlug}/fee-amounts/${id}`,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: 'PUT',
                        amount: newAmount
                    },
                    error: function() {
                        Swal.showValidationMessage(`Update failed!`);
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("Updated!") }}',
                    text: '{{ __("অ্যামাউন্ট আপডেট হয়েছে।") }}',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }
        });
    }

    // Notifications
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', timer: 1500, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session('error') }}' });
    @endif
</script>
@endsection