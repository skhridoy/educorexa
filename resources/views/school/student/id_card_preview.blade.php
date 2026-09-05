@extends('layouts.school')

@section('title', __('আইডি কার্ড প্রিভিউ'))

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ── Toolbar & Filter Controls ── */
        .preview-toolbar {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 70px;
            z-index: 30;
            backdrop-filter: blur(10px);
            margin-bottom: 24px;
        }

        .search-input-wrap {
            position: relative;
            min-width: 260px;
        }
        .search-input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }
        .search-input-wrap input {
            padding: 8px 14px 8px 38px !important;
            height: 38px !important;
            line-height: 1.5 !important;
            border-radius: 10px !important;
            font-size: 13px !important;
            border: 1px solid #cbd5e1 !important;
            background: #f8fafc !important;
            transition: all 0.2s ease !important;
        }
        .search-input-wrap input:focus {
            background: #ffffff !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
        }

        /* ── Side View Toggle Buttons (স্ক্রিনশটের বাটনসমূহ) ── */
        .idcard-view-group {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .idcard-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid #0d6efd;
            background: #ffffff;
            color: #0d6efd;
            transition: all 0.2s ease;
            text-decoration: none;
            line-height: 1.4;
        }
        .idcard-view-btn i {
            font-size: 13px;
            color: #0d6efd;
            transition: color 0.2s ease;
        }
        .idcard-view-btn:hover:not(.active) {
            background: #e7f1ff;
            color: #0b5ed7;
        }
        .idcard-view-btn.active {
            background: #0d6efd !important;
            border-color: #0d6efd !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.35);
        }
        .idcard-view-btn.active i {
            color: #ffffff !important;
        }

        /* ── Mobile Responsive Styles for Controls & Buttons ── */
        @media (max-width: 767.98px) {
            .preview-toolbar {
                padding: 12px 14px;
                top: 60px;
                margin-bottom: 16px;
            }
            .search-input-wrap {
                width: 100%;
                min-width: 100%;
            }
            .idcard-view-group {
                display: flex !important;
                width: 100%;
                gap: 5px;
            }
            .idcard-view-btn {
                flex: 1 1 0;
                min-width: 0;
                justify-content: center;
                padding: 7px 5px !important;
                font-size: 11.5px !important;
                text-align: center;
                white-space: nowrap;
            }
            .idcard-view-btn i {
                font-size: 11px;
                margin-right: 2px !important;
            }
            .header-actions-wrap {
                width: 100%;
                display: flex;
                gap: 8px !important;
            }
            .header-actions-wrap a {
                flex: 1;
                justify-content: center;
                text-align: center;
                padding: 8px 10px !important;
                font-size: 12px !important;
                white-space: nowrap;
            }
            .floating-action-bar {
                bottom: 14px;
                width: calc(100% - 24px);
                max-width: 390px;
                padding: 8px 12px;
                gap: 8px;
                justify-content: space-between;
            }
            .floating-action-bar .small {
                font-size: 11px !important;
            }
            .floating-action-bar .btn {
                padding: 5px 12px !important;
                font-size: 11px !important;
                white-space: nowrap;
            }
        }
        @media (max-width: 420px) {
            .idcard-view-btn {
                font-size: 10.5px !important;
                padding: 6px 3px !important;
            }
            .idcard-view-btn i {
                display: none;
            }
        }

        /* ── Preview Grid & Student Cards ── */
        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(480px, 1fr));
            gap: 24px;
        }

        @media (max-width: 575.98px) {
            .preview-grid {
                grid-template-columns: 1fr;
            }
        }

        .student-preview-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
        }
        .student-preview-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .card-block-header {
            padding: 12px 18px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .card-stage-wrap {
            padding: 24px 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            flex-wrap: wrap;
            flex-grow: 1;
        }

        /* ── Standard ID Card Container (CR80 Standard) ── */
        .card-container {
            width: 2.125in;
            height: 3.375in;
            background: #ffffff;
            position: relative;
            overflow: hidden;
            border: 0.5px solid #d1d5db;
            flex-shrink: 0;
            border-radius: 9px;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.12), 0 2px 6px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease;
        }
        .card-container:hover {
            transform: scale(1.02);
        }

        .card-side-tag {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            text-align: center;
            margin-top: 6px;
        }

        /* ── FRONT SIDE STYLING ── */
        .dot-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(106, 27, 154, 0.1) 1.5px, transparent 1.5px);
            background-size: 10px 10px;
            z-index: 0;
        }
        .top-header-shape {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 140px;
            background: linear-gradient(135deg, #6a1b9a 0%, #ad1457 100%);
            clip-path: polygon(0 0, 100% 0, 100% 70%, 85% 75%, 75% 85%, 50% 100%, 25% 85%, 15% 75%, 0 70%);
            z-index: 1;
        }
        .header-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: white;
            padding-top: 10px;
            margin: 1px 8px;
        }
        .school-logo {
            max-height: 32px;
            max-width: 54px;
            object-fit: contain;
            margin-bottom: 2px;
            display: inline-block;
        }
        .school-name-text {
            font-size: 11px;
            margin-top: -2px;
            text-transform: uppercase;
            font-weight: 800;
            line-height: 1.1;
            white-space: normal;
            overflow: wrap;
            text-overflow: ellipsis;
        }
        .photo-border {
            position: absolute;
            top: 82px;
            left: 50%;
            transform: translateX(-50%);
            width: 74px;
            height: 74px;
            background: white;
            border-radius: 50%;
            padding: 2.5px;
            z-index: 3;
            border: 2px solid #6a1b9a;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
        }
        .photo-border img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .details {
            position: absolute;
            top: 165px;
            width: 100%;
            padding: 0 10px;
            box-sizing: border-box;
            z-index: 2;
        }
        .name-badge {
            justify-content: center;
            text-align: center;
            position: relative;
            margin: 0 2px 4px 2px;
        }
        .name {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            text-transform: uppercase;
            border-radius: 8px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
            font-size: 9.5px;
            padding: 2.5px 8px;
            font-weight: 800;
            color: #ffffff;
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 95%;
        }
        .row-info {
            display: flex;
            font-size: 9px;
            line-height: 1.28;
            margin-bottom: 1px;
        }
        .label {
            width: 42%;
            font-weight: 700;
            color: #6a1b9a;
        }
        .val {
            width: 58%;
            color: #1e293b;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .front-signature {
            position: absolute;
            bottom: 16px;
            right: 12px;
            text-align: center;
            z-index: 2;
        }
        .front-signature img {
            max-height: 22px;
            max-width: 48px;
            object-fit: contain;
            margin-bottom: -3px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .front-signature p {
            margin: 0;
            font-size: 6px;
            font-weight: 800;
            border-top: 0.5px solid #333;
            color: #1e293b;
        }

        /* ── BACK SIDE STYLING ── */
        .back-top-bar {
            width: 100%;
            height: 24px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
        }
        .back-header {
            margin: 10px auto 6px auto;
            width: 86%;
            background: rgba(106, 27, 154, 0.15);
            color: #6a1b9a;
            text-align: center;
            font-size: 8.5px;
            font-weight: 800;
            padding: 3px 0;
            border-radius: 3px;
            letter-spacing: 0.3px;
        }
        .terms-text {
            padding: 0 12px;
            font-size: 8px;
            color: #334155;
            line-height: 1.25;
        }
        .extra-info-section {
            margin-top: 8px;
            padding: 0 14px;
            font-size: 8.5px;
            color: #334155;
            line-height: 1.35;
        }
        .school-info-section {
            margin-top: 6px;
            padding: 0 14px;
            font-size: 8.5px;
            color: #334155;
            line-height: 1.3;
        }
        .qr-section {
            text-align: center;
            margin-top: 8px;
        }
        .qr-section img, .qr-section svg {
            width: 44px; height: 44px;
            background: white;
            padding: 2px;
            border: 0.5px solid #cbd5e1;
        }
        .bottom-bar {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
        }

        /* ── DYNAMIC MULTI-DESIGN THEME STYLES ── */
        @foreach($designs as $slug => $d)
        .card-container.theme-{{ $slug }} .dot-pattern {
            @if(!empty($d['pattern']) && file_exists(public_path($d['pattern'])))
                background-image: url('{{ asset($d['pattern']) }}');
                background-size: cover;
            @else
                background-image: radial-gradient(rgba(0, 0, 0, 0.12) 1.5px, transparent 1.5px);
            @endif
        }
        .card-container.theme-{{ $slug }} .top-header-shape {
            background-color: {{ $d['primary_color'] }};
            @if(!empty($d['header_shape']) && file_exists(public_path($d['header_shape'])))
                background-image: url('{{ asset($d['header_shape']) }}') !important;
                background-size: 100% 100% !important;
                background-repeat: no-repeat !important;
                clip-path: none !important;
            @else
                background: {{ $d['gradient_css'] ?? $d['primary_color'] }};
                clip-path: polygon(0 0, 100% 0, 100% 70%, 85% 75%, 75% 85%, 50% 100%, 25% 85%, 15% 75%, 0 70%);
            @endif
        }
        .card-container.theme-{{ $slug }} .photo-border {
            border-color: {{ $d['photo_border'] ?? $d['primary_color'] }};
        }
        .card-container.theme-{{ $slug }} .name {
            background: {{ $d['badge_color'] ?? $d['primary_color'] }};
            border: none;
        }
        .card-container.theme-{{ $slug }} .label,
        .card-container.theme-{{ $slug }} .extra-info-section strong,
        .card-container.theme-{{ $slug }} .school-info-section strong,
        .card-container.theme-{{ $slug }} .qr-section-id {
            color: {{ $d['label_color'] ?? $d['primary_color'] }} !important;
        }
        .card-container.theme-{{ $slug }} .bottom-bar,
        .card-container.theme-{{ $slug }} .back-top-bar {
            @if(!empty($d['gradient_bar']) && file_exists(public_path($d['gradient_bar'])))
                background-image: url('{{ asset($d['gradient_bar']) }}') !important;
                background-size: 100% 100% !important;
            @else
                background: {{ $d['gradient_css'] ?? $d['primary_color'] }};
            @endif
        }
        .card-container.theme-{{ $slug }} .back-header {
            background: {{ $d['back_header_bg'] ?? '#f3e8ff' }};
            color: {{ $d['back_header_text'] ?? $d['primary_color'] }};
        }
        @endforeach

        /* ── Floating Sticky Bottom Action Bar ── */
        .floating-action-bar {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(12px);
            padding: 10px 24px;
            border-radius: 50px;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.28);
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 1020;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Dark mode overrides */
        [data-bs-theme="dark"] .preview-toolbar,
        body.dark-mode .preview-toolbar {
            background: #111c34 !important;
            border-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .search-input-wrap input,
        body.dark-mode .search-input-wrap input {
            background: #0c1427 !important;
            border-color: #1e2d45 !important;
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .student-preview-card,
        body.dark-mode .student-preview-card {
            background: #111c34 !important;
            border-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .card-block-header,
        body.dark-mode .card-block-header {
            background: #0f1a2e !important;
            border-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .card-stage-wrap,
        body.dark-mode .card-stage-wrap {
            background: #080e1a !important;
        }
    </style>
@endsection

@php
    $school = auth()->user()?->school ?? (app()->bound('currentSchool') ? app('currentSchool') : null);
    $tenantSlug = $school?->slug ?? (auth()->user()?->school?->slug ?? 'school');
    $signaturePath = $school?->signature ?? auth()->user()?->signature;
    $hasSignature = !empty($signaturePath) && file_exists(public_path($signaturePath));
@endphp

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- ── Breadcrumb & Top Bar ── --}}
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <a href="{{ route('students.idcard.index', ['tenant' => $tenantSlug]) }}" class="text-secondary text-decoration-none small">
                        <i class="fa-solid fa-arrow-left me-1"></i> {{ __('ক্লাস পরিবর্তন') }}
                    </a>
                    <span class="text-muted small">/</span>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                        {{ $selectedClass->name ?? __('Class') }}
                    </span>
                    <span class="badge bg-secondary-subtle text-secondary fw-bold px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                        <span id="studentTotalBadge">{{ $students->count() }}</span> {{ __('জন শিক্ষার্থী') }}
                    </span>
                </div>
                <h4 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-id-badge text-primary me-2"></i>{{ __('স্টুডেন্ট আইডি কার্ড প্রিভিউ') }}
                </h4>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap header-actions-wrap">
                <a href="{{ route('students.idcard.index', ['tenant' => $tenantSlug, 'design' => $selectedDesign ?? 'purple_classic']) }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-pill fw-semibold shadow-sm">
                    <i class="fa-solid fa-sliders me-1"></i> {{ __('সেটিংস পেজ') }}
                </a>
                <a href="{{ route('students.idcard.download', ['tenant' => $tenantSlug, 'class_id' => $class_id, 'design' => $selectedDesign ?? 'purple_classic']) }}" 
                   id="btnDownloadPdf"
                   class="btn btn-primary fw-bold px-3 px-sm-4 py-2 rounded-pill shadow-sm">
                    <i class="fa-solid fa-file-arrow-down me-1.5"></i>
                    <span class="d-none d-sm-inline">{{ __('ডাউনলোড(Download)') }}</span>
                    <span class="d-sm-none">{{ __('ডাউনলোড') }}</span>
                </a>
            </div>
        </div>

        {{-- ── Sticky Controls & Search Toolbar ── --}}
        <div class="preview-toolbar">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 z-0">
                <div class="d-flex align-items-center gap-3 flex-wrap flex-grow-1">
                    {{-- Search Box --}}
                    <div class="search-input-wrap">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="previewSearchInput" class="form-control" placeholder="{{ __('নাম, রোল বা আইডি দিয়ে খুঁজুন...') }}">
                    </div>

                    {{-- Side Visibility Toggles (স্ক্রিনশটের বাটনসমূহ) --}}
                    <div class="idcard-view-group" role="group" aria-label="Side visibility">
                        <button type="button" class="idcard-view-btn active" id="btnShowBoth">
                            <i class="fa-solid fa-table-columns me-1"></i>
                            <span>{{ __('উভয় পাশ') }}</span>
                        </button>
                        <button type="button" class="idcard-view-btn" id="btnShowFront">
                            <i class="fa-solid fa-id-card me-1"></i>
                            <span class="d-none d-md-inline">{{ __('শুধু সম্মুখভাগ (Front)') }}</span>
                            <span class="d-md-none">{{ __('সম্মুখ (Front)') }}</span>
                        </button>
                        <button type="button" class="idcard-view-btn" id="btnShowBack">
                            <i class="fa-solid fa-qrcode me-1"></i>
                            <span class="d-none d-md-inline">{{ __('শুধু পেছনভাগ (Back)') }}</span>
                            <span class="d-md-none">{{ __('পেছন (Back)') }}</span>
                        </button>
                    </div>

                    {{-- ── Multi-Design Dropdown Switcher ── --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm rounded-pill dropdown-toggle fw-bold d-flex align-items-center gap-2 px-3 py-1.5" 
                                type="button" id="designSelectorDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12.5px; border-width: 1.5px;">
                            <i class="fa-solid fa-palette text-primary"></i>
                            <span id="currentDesignLabel">{{ $designs[$selectedDesign ?? 'purple_classic']['name_bn'] ?? 'ডিজাইন ১: ক্লাসিক পার্পল' }}</span>
                        </button>
                        <ul class="dropdown-menu shadow-lg border-0 p-2" aria-labelledby="designSelectorDropdown" style="min-width: 250px; border-radius: 14px; z-index: 1060;">
                            <li class="dropdown-header small text-muted fw-bold text-uppercase px-2 py-1">
                                <i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i>{{ __('আইডি কার্ড ডিজাইন পরিবর্তন') }}
                            </li>
                            @foreach($designs as $dKey => $dCfg)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between rounded-3 py-2 px-2.5 design-select-item {{ $dKey === ($selectedDesign ?? 'purple_classic') ? 'active fw-bold' : '' }}" 
                                       href="javascript:void(0);" 
                                       data-design="{{ $dKey }}"
                                       data-title="{{ $dCfg['name_bn'] }}">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="rounded-circle shadow-sm" style="width: 15px; height: 15px; background: {{ $dCfg['gradient_css'] }}; display: inline-block; border: 1px solid #fff;"></span>
                                            <span>{{ $dCfg['name_bn'] }}</span>
                                        </div>
                                        <i class="fa-solid fa-check check-icon text-primary {{ $dKey === ($selectedDesign ?? 'purple_classic') ? '' : 'd-none' }}" style="font-size: 12px;"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Status Pills --}}
                <div class="d-flex align-items-center gap-2">
                    @if($hasSignature)
                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill small">
                            <i class="fa-solid fa-circle-check me-1"></i> {{ __('প্রধান শিক্ষকের স্বাক্ষর সক্রিয়') }}
                        </span>
                    @else
                        <a href="{{ route('user.profile', ['tenant' => $tenantSlug]) }}" class="badge bg-warning-subtle text-warning fw-bold px-3 py-2 rounded-pill small text-decoration-none" title="{{ __('স্বাক্ষর আপলোড করতে ক্লিক করুন') }}">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ __('ডিফল্ট স্বাক্ষর (আপলোড করুন)') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── No Match Alert (Hidden by default) ── --}}
        <div id="noMatchAlert" class="alert alert-warning text-center border-0 rounded-4 py-5 shadow-sm d-none" style="background: #fffbeb;">
            <i class="fa-solid fa-user-xmark fa-3x text-warning mb-3"></i>
            <h5 class="fw-bold text-dark">{{ __('কোনো শিক্ষার্থী খুঁজে পাওয়া যায়নি!') }}</h5>
            <p class="text-muted small mb-0">{{ __('অনুগ্রহ করে সঠিক নাম, রোল নম্বর বা আইডি লিখে পুনরায় চেষ্টা করুন।') }}</p>
        </div>

        {{-- ── Preview Grid of Student Cards ── --}}
        @if(isset($students) && $students->count() > 0)
            <div class="preview-grid" id="previewCardsGrid">
                @foreach($students as $student)
                    @php
                        $searchKeyword = mb_strtolower($student->name . ' ' . $student->roll . ' ' . $student->student_id . ' ' . ($student->contact_number ?? ''));
                        $schoolSig = $student->school->signature ?? ($school->signature ?? null);
                    @endphp
                    
                    <div class="student-preview-card student-card-item" data-search="{{ $searchKeyword }}">
                        
                        {{-- Card Block Header --}}
                        <div class="card-block-header">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary text-white fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                    {{ __('রোল:') }} {{ $student->roll }}
                                </span>
                                <h6 class="fw-bold text-dark mb-0 small">{{ $student->name }}</h6>
                            </div>
                            <span class="badge bg-light text-secondary border fw-bold px-2 py-1 rounded-pill" style="font-size: 10.5px;">
                                ID: {{ $student->student_id }}
                            </span>
                        </div>

                        {{-- Card Stage (Front & Back) --}}
                        <div class="card-stage-wrap">
                            
                            {{-- ── FRONT SIDE ── --}}
                            <div class="card-side-wrapper card-front-side">
                                <div class="card-container theme-{{ $selectedDesign ?? 'purple_classic' }}">
                                    <div class="dot-pattern"></div>
                                    <div class="top-header-shape"></div>
                                    
                                    <div class="header-content">
                                        @if($student->school && $student->school->logo && file_exists(public_path($student->school->logo)))
                                            <img src="{{ asset($student->school->logo) }}" class="school-logo" alt="Logo">
                                        @else
                                            <div class="school-logo d-inline-flex align-items-center justify-content-center text-white fw-bold" style="font-size: 15px;">
                                                <i class="fa-solid fa-school"></i>
                                            </div>
                                        @endif
                                        <h1 class="school-name-text">{{ $student->school->name }}</h1>
                                    </div>

                                    <div class="photo-border">
                                        @if($student->photo && file_exists(public_path($student->photo)))
                                            <img src="{{ asset($student->photo) }}" alt="{{ $student->name }}">
                                        @else
                                            <img src="{{ asset('assets/images/profile.webp') }}" alt="Student">
                                        @endif
                                    </div>

                                    <div class="details">
                                        <div class="name-badge">
                                            <span class="name">{{ $student->name }}</span>
                                        </div>
                                        
                                        <div class="row-info">
                                            <span class="label">{{ __('Class') }}</span>
                                            <span class="val">: {{ $student->class->name }}</span>
                                        </div>

                                        <div class="row-info">
                                            <span class="label">{{ __('Roll No') }}</span>
                                            <span class="val">: {{ $student->roll }}</span>
                                        </div>

                                        <div class="row-info">
                                            <span class="label">{{ __('Student ID') }}</span>
                                            <span class="val">: {{ $student->student_id }}</span>
                                        </div>

                                        <div class="row-info">
                                            <span class="label">{{ __('Guardians') }}</span>
                                            <span class="val">: {{ $student->fathers_name ?: 'N/A' }}</span>
                                        </div>

                                        <div class="row-info">
                                            <span class="label">{{ __('Blood Group') }}</span>
                                            <span class="val">: {{ $student->blood_group ?: 'N/A' }}</span>
                                        </div>

                                        <div class="row-info">
                                            <span class="label">{{ __('Emergency') }}</span>
                                            <span class="val">: {{ $student->contact_number ?: 'N/A' }}</span>
                                        </div>
                                    </div>

                                    <div class="front-signature">
                                        @if($schoolSig && file_exists(public_path($schoolSig)))
                                            <img src="{{ asset($schoolSig) }}" alt="Sign">
                                        @else
                                            <img src="{{ asset('assets/images/signature.png') }}" alt="Sign">
                                        @endif
                                        <p>{{ __('Principal') }}</p>
                                    </div>

                                    <div class="bottom-bar"></div>
                                </div>
                                <div class="card-side-tag">{{ __('Front Side') }}</div>
                            </div>

                            {{-- ── BACK SIDE ── --}}
                            <div class="card-side-wrapper card-back-side">
                                <div class="card-container theme-{{ $selectedDesign ?? 'purple_classic' }}">
                                    <div class="dot-pattern"></div>
                                    <div class="back-top-bar"></div>

                                    <div class="back-header">
                                        {{ __('TERMS AND CONDITIONS') }}
                                    </div>

                                    <div class="terms-text">
                                        <ul style="list-style: none; padding: 0; margin: 0;">
                                            <li style="margin-bottom: 3px;">• This card is the property of <strong>{{ $student->school->name }}</strong>.</li>
                                            <li>• If found, please return to the school office immediately.</li>
                                        </ul>
                                    </div>

                                    {{-- Session, DOB & Validity --}}
                                    <div class="extra-info-section">
                                        <div style="margin-bottom: 2px; display: flex;">
                                            <strong style="color: #6a1b9a; width: 50px;">Session</strong> 
                                            <span>: {{ $student->academicYear->name ?? 'N/A' }}</span>
                                        </div>
                                        <div style="margin-bottom: 2px; display: flex;">
                                            <strong style="color: #6a1b9a; width: 50px;">D.O.B</strong> 
                                            <span>: {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d-m-Y') : 'N/A' }}</span>
                                        </div>
                                        <div style="margin-bottom: 2px; display: flex;">
                                            <strong style="color: #6a1b9a; width: 50px;">Valid Up To</strong> 
                                            <span>: {{ $student->academicYear?->end_date ? \Carbon\Carbon::parse($student->academicYear->end_date)->format('M Y') : 'N/A' }}</span>
                                        </div>
                                    </div>

                                    <div class="school-info-section">
                                        <div style="margin-bottom: 2px; display: flex; align-items: center;">
                                            <strong style="color: #6a1b9a; width: 50px;">Phone</strong> 
                                            <span>: {{ $student->school->phone ?? '01XXX-XXXXXX' }}</span>
                                        </div>
                                        <div style="margin-bottom: 2px; display: flex; align-items: center;">
                                            <strong style="color: #6a1b9a; width: 50px;">Website</strong> 
                                            @php    
                                                $schoolSlug = $student->school->slug;
                                                $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
                                                $fullUrl = $schoolSlug . '.' . $mainDomain;
                                            @endphp
                                            <span>: {{ $fullUrl ?? 'www.school.com' }}</span>
                                        </div>
                                    </div>

                                    <div class="qr-section">
                                        <div style="display: inline-block; padding: 3px; border: 1px solid #eee; background: white; border-radius: 4px;">
                                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(42)->color(106, 27, 154)->generate("ID: " . $student->student_id . " | Name: " . $student->name) !!}
                                        </div>
                                        <div style="font-size: 7px; margin-top: 2px; font-weight: bold; color: #6a1b9a;">
                                            {{ $student->student_id }}
                                        </div>
                                    </div>

                                    <div class="bottom-bar"></div>
                                </div>
                                <div class="card-side-tag">{{ __('Back Side') }}</div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                <i class="fa-solid fa-users-slash fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold text-dark">{{ __('এই ক্লাসে কোনো শিক্ষার্থী খুঁজে পাওয়া যায়নি!') }}</h5>
                <p class="text-muted small mb-3">{{ __('অন্য কোনো ক্লাস নির্বাচন করে পুনরায় আইডি কার্ড তৈরি করুন।') }}</p>
                <div>
                    <a href="{{ route('students.idcard.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
                        <i class="fa-solid fa-arrow-left me-1"></i> {{ __('ক্লাস নির্বাচন পেজে ফিরুন') }}
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>

{{-- ── Floating Sticky Print Bar ── --}}
@if(isset($students) && $students->count() > 0)
    <div class="floating-action-bar">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-users text-primary"></i>
            <span class="small fw-semibold">
                {{ __('শিক্ষার্থী:') }} <strong id="visibleCount" class="text-white">{{ $students->count() }}</strong> / {{ $students->count() }}
            </span>
        </div>
        <div style="height: 18px; width: 1px; background: rgba(255,255,255,0.2);"></div>
        <a href="{{ route('students.idcard.download', ['tenant' => $tenantSlug, 'class_id' => $class_id, 'design' => $selectedDesign ?? 'purple_classic']) }}" 
           id="floatingDownloadBtn"
           class="btn btn-primary btn-sm px-4 py-1.5 rounded-pill fw-bold shadow">
            <i class="fa-solid fa-file-arrow-down me-1.5"></i> {{ __('ডাউনলোড') }}
        </a>
    </div>
@endif

@section('customJs')
<script>
    $(document).ready(function() {
        // Realtime search filter
        $('#previewSearchInput').on('keyup', function() {
            let term = $(this).val().toLowerCase().trim();
            let visibleCount = 0;

            $('.student-card-item').each(function() {
                let searchData = $(this).data('search') || '';
                if (term === '' || searchData.indexOf(term) > -1) {
                    $(this).removeClass('d-none');
                    visibleCount++;
                } else {
                    $(this).addClass('d-none');
                }
            });

            $('#visibleCount').text(visibleCount);

            if (visibleCount === 0) {
                $('#noMatchAlert').removeClass('d-none');
            } else {
                $('#noMatchAlert').addClass('d-none');
            }
        });

        // View Toggles (Both, Front Only, Back Only)
        $('#btnShowBoth').on('click', function() {
            $('.idcard-view-btn').removeClass('active');
            $(this).addClass('active');
            $('.card-front-side, .card-back-side').removeClass('d-none');
        });

        $('#btnShowFront').on('click', function() {
            $('.idcard-view-btn').removeClass('active');
            $(this).addClass('active');
            $('.card-front-side').removeClass('d-none');
            $('.card-back-side').addClass('d-none');
        });

        $('#btnShowBack').on('click', function() {
            $('.idcard-view-btn').removeClass('active');
            $(this).addClass('active');
            $('.card-front-side').addClass('d-none');
            $('.card-back-side').removeClass('d-none');
        });

        // ── Multi-Design Switcher ──
        let currentDesign = '{{ $selectedDesign ?? 'purple_classic' }}';

        function setPreviewDesign(designKey, designTitle) {
            currentDesign = designKey;
            
            // 1. Update active item in dropdown
            $('.design-select-item').removeClass('active fw-bold');
            $('.design-select-item[data-design="' + designKey + '"]').addClass('active fw-bold');
            $('.design-select-item .check-icon').addClass('d-none');
            $('.design-select-item[data-design="' + designKey + '"] .check-icon').removeClass('d-none');
            $('#currentDesignLabel').text(designTitle);

            // 2. Update all card-container theme classes dynamically
            $('.card-container').each(function() {
                this.className = this.className.replace(/\btheme-\S+/g, '').trim() + ' theme-' + designKey;
            });

            // 3. Update download URLs
            const baseDownloadUrl = "{{ route('students.idcard.download', ['tenant' => $tenantSlug, 'class_id' => $class_id]) }}";
            const fullUrl = baseDownloadUrl + '?design=' + designKey;
            $('#btnDownloadPdf').attr('href', fullUrl);
            $('#floatingDownloadBtn').attr('href', fullUrl);
        }

        $(document).on('click', '.design-select-item', function() {
            const dKey = $(this).data('design');
            const dTitle = $(this).data('title');
            setPreviewDesign(dKey, dTitle);
        });

        // Initialize on page load
        setPreviewDesign(currentDesign, "{{ $designs[$selectedDesign ?? 'purple_classic']['name_bn'] ?? 'ডিজাইন ১: ক্লাসিক পার্পল' }}");
    });
</script>
@endsection
@endsection