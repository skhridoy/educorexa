@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    /* ── Top Header Toolbar ── */
    .preview-header-toolbar {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
    }

    /* ── Side View Toggle Buttons (আইডি কার্ড প্রিভিউ পেজ এর বাটন স্টাইল) ── */
    .idcard-view-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
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

    /* ── Preset Pill Buttons ── */
    .preset-pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        transition: all 0.2s ease;
        text-decoration: none;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .preset-pill-btn:hover {
        border-color: #0d6efd;
        color: #0d6efd;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.15);
    }
    .preset-color-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 1.5px solid #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        flex-shrink: 0;
    }

    /* ── Upload Dropzone ── */
    .upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .upload-box:hover {
        border-color: #0d6efd;
        background: #f0f7ff;
    }
    .upload-box input[type="file"] {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .upload-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #ffffff;
        border: 1.5px solid #0d6efd;
        color: #0d6efd;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 8px;
        box-shadow: 0 2px 6px rgba(13, 110, 253, 0.1);
    }

    /* ── Color Input Cards ── */
    .color-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        transition: all 0.15s;
    }
    .color-card:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .color-picker-input {
        width: 42px;
        height: 38px;
        border-radius: 8px;
        border: 1.5px solid #cbd5e1;
        padding: 2px;
        cursor: pointer;
        background: #ffffff;
        flex-shrink: 0;
    }

    /* ── Live Sticky Preview Station ── */
    .preview-station {
        position: sticky;
        top: 24px;
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* ── Simulator Stage & Cards ── */
    .sim-stage-flex {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        width: 100%;
        padding: 12px 0;
        flex-wrap: wrap;
    }
    .sim-card {
        width: 162px;
        height: 250px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 10px 24px rgba(0,0,0,0.12), 0 2px 6px rgba(0,0,0,0.04);
        position: relative;
        overflow: hidden;
        border: 0.5px solid #cbd5e1;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }
    .sim-card:hover {
        transform: scale(1.02);
    }
    .sim-card-gloss {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, transparent 55%);
        pointer-events: none;
        z-index: 5;
    }

    /* Front Card Elements */
    .card-front-header {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 75px;
        background-color: #6a1b9a;
        z-index: 1;
        overflow: hidden;
    }
    .card-front-header img {
        width: 100%; height: 100%;
        object-fit: fill;
        display: block;
    }
    .card-school-name {
        position: absolute;
        top: 7px; left: 0; width: 100%;
        text-align: center;
        color: #ffffff;
        font-weight: 800;
        font-size: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        z-index: 2;
        padding: 0 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-shadow: 0 1px 2px rgba(0,0,0,0.4);
    }
    .card-avatar-box {
        position: relative;
        z-index: 3;
        margin: 45px auto 0 auto;
        width: 48px;
        height: 58px;
        border-radius: 6px;
        background: #f8fafc;
        border: 2.5px solid #ab47bc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 20px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.12);
        overflow: hidden;
    }
    .card-student-name {
        margin-top: 5px;
        font-size: 9.5px;
        font-weight: 800;
        color: #1e293b;
        text-align: center;
        line-height: 1.1;
    }
    .card-badge-pill {
        margin: 3px auto 0 auto;
        display: table;
        font-size: 7px;
        font-weight: 700;
        color: #ffffff;
        background: #6a1b9a;
        padding: 1.5px 10px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .card-meta-table {
        margin: 6px auto 0 auto;
        width: 88%;
        font-size: 7px;
        border-collapse: collapse;
    }
    .card-meta-table td {
        padding: 1px 2px;
    }
    .card-lbl {
        font-weight: 700;
        color: #7b1fa2;
        width: 42%;
    }
    .card-val {
        font-weight: 600;
        color: #334155;
    }
    .card-bottom-bar {
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 7px;
        background: #6a1b9a;
        z-index: 2;
    }
    .card-bottom-bar img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Back Card Elements */
    .card-back-container {
        width: 100%; height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 14px 10px 8px 10px;
        position: relative;
    }
    .card-back-hd {
        font-size: 7.5px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 3px;
        text-align: center;
        width: 92%;
        letter-spacing: 0.2px;
        background: #f3e8ff;
        color: #6a1b9a;
    }
    .card-back-terms {
        font-size: 6.5px;
        color: #475569;
        line-height: 1.35;
        margin-top: 8px;
        text-align: center;
    }
    .card-back-qr {
        margin-top: auto;
        margin-bottom: 12px;
        padding: 3px;
        border: 0.5px solid #cbd5e1;
        background: #ffffff;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .card-back-qr i {
        font-size: 26px;
        color: #6a1b9a;
    }
    .card-back-id {
        font-size: 6.5px;
        font-weight: 700;
        margin-top: 2px;
        color: #7b1fa2;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.id-card-designs.index') }}">ID Card Designs</a></li>
        <li><span>/</span></li>
        <li class="active">Add Template</li>
    </ul>

    {{-- Top Action Toolbar (Matching preview toolbar) --}}
    <div class="preview-header-toolbar d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark" style="font-family:'Outfit',sans-serif;">
                <i class="fa-solid fa-wand-magic-sparkles text-primary me-2"></i>{{ __('নতুন আইডি কার্ড ডিজাইন তৈরি') }}
            </h4>
            <p class="text-muted small mb-0">{{ __('কাস্টম হেডার শেপ আপলোড করুন এবং প্রিভিউ পেজ এর মতো লাইভ কার্ডে টেস্ট করুন।') }}</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('super.id-card-designs.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-pill fw-semibold shadow-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> {{ __('টেমপ্লেট তালিকা') }}
            </a>
            <button type="button" onclick="document.getElementById('designCreateForm').submit();" class="btn btn-primary fw-bold px-4 py-2 rounded-pill shadow-sm">
                <i class="fa-solid fa-check me-1.5"></i> {{ __('সেভ ও পাবলিশ') }}
            </button>
        </div>
    </div>

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
            <h6 class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> ত্রুটিগুলো সংশোধন করুন:</h6>
            <ul class="mb-0 small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Left Form Panel --}}
        <div class="col-lg-7">
            <form action="{{ route('super.id-card-designs.store') }}" method="POST" enctype="multipart/form-data" id="designCreateForm">
                @csrf

                {{-- Section 1: Details --}}
                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd">
                        <h6 class="edu-panel-ttl"><i class="fa-solid fa-tag text-primary me-2"></i>১. ডিজাইনের নাম ও তথ্য</h6>
                    </div>
                    <div class="edu-panel-bd">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="edu-label">টেমপ্লেট নাম <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="nameInput" class="form-control edu-input" placeholder="যেমন: Royal Purple Classic" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-5">
                                <label class="edu-label">স্লাগ (Slug)</label>
                                <input type="text" name="slug" id="slugInput" class="form-control edu-input" placeholder="যেমন: royal-purple-classic" value="{{ old('slug') }}">
                                <small class="text-muted" style="font-size:11px;">ফাঁকা রাখলে স্বয়ংক্রিয়ভাবে তৈরি হবে</small>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">সিরিয়াল / সাজানোর ক্রম (Sort Order)</label>
                                <input type="number" name="sort_order" class="form-control edu-input" value="{{ old('sort_order', 0) }}" placeholder="0">
                            </div>
                            <div class="col-md-6 d-flex align-items-center pt-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} style="cursor:pointer; width:40px; height:22px;">
                                    <label class="form-check-label fw-bold ms-2" for="isActiveCheck" style="font-size:13px; cursor:pointer;">
                                        স্কুলের তালিকায় সক্রিয় রাখুন
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Header Shape & Assets --}}
                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd d-flex justify-content-between align-items-center">
                        <h6 class="edu-panel-ttl"><i class="fa-solid fa-shapes text-primary me-2"></i>২. হেডার শেপ ও গ্রাফিক ফাইল</h6>
                        <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-2.5 py-1" style="font-size:11px;">PNG / JPG</span>
                    </div>
                    <div class="edu-panel-bd">
                        {{-- Header Shape Upload Box --}}
                        <div class="mb-3">
                            <label class="edu-label">
                                হেডার শেপ ওভারলে ইমেজ <span class="text-muted">(ট্রান্সপারেন্ট PNG ফাইল বাঞ্ছনীয়)</span>
                            </label>
                            <div class="upload-box" id="shapeUploadBox">
                                <input type="file" name="header_shape" id="headerShapeInput" accept="image/png, image/jpeg, image/jpg">
                                <div class="upload-icon-circle">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <h6 class="fw-bold mb-1 text-dark" style="font-size:13px;">ক্লিক করে হেডার শেপ ফাইল সিলেক্ট করুন</h6>
                                <p class="text-muted small mb-0">অনুকূল সাইজ: ~720x240px (3:1 অনুপাত) ট্রান্সপারেন্ট ব্যাকগ্রাউন্ড</p>
                            </div>

                            <div class="d-none align-items-center gap-3 p-2.5 bg-light rounded-3 border mt-2" id="shapePill">
                                <img src="" id="shapeThumb" style="width:60px; height:32px; object-fit:contain; background:#fff; border-radius:6px; border:1px solid #cbd5e1;" alt="Shape">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-bold small text-dark text-truncate" id="shapeFileName">shape.png</div>
                                    <div class="text-muted" style="font-size:11px;" id="shapeFileSize">0 KB</div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2.5 rounded-pill" onclick="clearHeaderShape()">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="edu-label">নিচের গ্রেডিয়েন্ট বার <span class="text-muted">(ঐচ্ছিক)</span></label>
                                <input type="file" name="gradient_bar" id="gradientBarInput" class="form-control edu-input" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted" style="font-size:11px;">কার্ডের একদম নিচে পাতলা স্ট্রিপ</small>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">ওয়াটারমার্ক প্যাটার্ন <span class="text-muted">(ঐচ্ছিক)</span></label>
                                <input type="file" name="pattern" class="form-control edu-input" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted" style="font-size:11px;">হালকা ডট বা ব্যাকগ্রাউন্ড ওয়াটারমার্ক</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Palette Studio with Preview Page Button Style --}}
                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd d-flex justify-content-between align-items-center">
                        <h6 class="edu-panel-ttl"><i class="fa-solid fa-palette text-primary me-2"></i>৩. কালার প্যালেট স্টুডিও</h6>
                        <span class="text-muted small">এক ক্লিকে প্রিসেট সেট করুন</span>
                    </div>
                    <div class="edu-panel-bd">
                        {{-- Presets using pill style matching preview buttons --}}
                        <div class="mb-4">
                            <label class="edu-label mb-2">রেডিমেড কালার প্রিসেট সমূহ:</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="preset-pill-btn" onclick="applyPreset('#6a1b9a','#841778','#6a1b9a','#ab47bc','#f3e8ff','#6a1b9a','Classic Purple')">
                                    <span class="preset-color-dot" style="background:#6a1b9a;"></span>
                                    <span>রয়্যাল পার্পল</span>
                                </button>
                                <button type="button" class="preset-pill-btn" onclick="applyPreset('#1e3a8a','#0f172a','#1e40af','#3b82f6','#e0e7ff','#1e3a8a','Royal Navy')">
                                    <span class="preset-color-dot" style="background:#1e3a8a;"></span>
                                    <span>ডিপ নেভি</span>
                                </button>
                                <button type="button" class="preset-pill-btn" onclick="applyPreset('#065f46','#064e3b','#047857','#10b981','#ecfdf5','#065f46','Emerald Wave')">
                                    <span class="preset-color-dot" style="background:#065f46;"></span>
                                    <span>এমারেল্ড গ্রিন</span>
                                </button>
                                <button type="button" class="preset-pill-btn" onclick="applyPreset('#0284c7','#0369a1','#0284c7','#38bdf8','#e0f2fe','#0369a1','Modern Cyan')">
                                    <span class="preset-color-dot" style="background:#0284c7;"></span>
                                    <span>মডার্ন সিয়ান</span>
                                </button>
                                <button type="button" class="preset-pill-btn" onclick="applyPreset('#be123c','#881337','#9f1239','#fb7185','#ffe4e6','#9f1239','Regal Maroon')">
                                    <span class="preset-color-dot" style="background:#be123c;"></span>
                                    <span>রিগ্যাল মেরুন</span>
                                </button>
                                <button type="button" class="preset-pill-btn" onclick="applyPreset('#ea580c','#c2410c','#ea580c','#f97316','#ffedd5','#c2410c','Sunset Amber')">
                                    <span class="preset-color-dot" style="background:#ea580c;"></span>
                                    <span>সানসেট আম্বার</span>
                                </button>
                                <button type="button" class="preset-pill-btn" onclick="applyPreset('#1e293b','#0f172a','#334155','#64748b','#f1f5f9','#1e293b','Dark Slate')">
                                    <span class="preset-color-dot" style="background:#1e293b;"></span>
                                    <span>ডার্ক স্লেট</span>
                                </button>
                                <button type="button" class="preset-pill-btn" onclick="applyPreset('#0d9488','#115e59','#0f766e','#2dd4bf','#ccfbf1','#0f766e','Teal Ocean')">
                                    <span class="preset-color-dot" style="background:#0d9488;"></span>
                                    <span>টিয়াল ওশান</span>
                                </button>
                            </div>
                        </div>

                        {{-- Granular Color Pickers --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="color-card">
                                    <label class="edu-label mb-1">প্রাইমারি থিম কালার <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="primaryPick" class="color-picker-input" value="{{ old('primary_color', '#6a1b9a') }}">
                                        <input type="text" name="primary_color" id="primaryText" class="form-control edu-input" value="{{ old('primary_color', '#6a1b9a') }}" required>
                                    </div>
                                    <small class="text-muted" style="font-size:11px;">হেডার ব্যাকগ্রাউন্ড ও কিউআর অ্যাকসেন্ট</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="color-card">
                                    <label class="edu-label mb-1">স্টুডেন্ট ব্যাজ কালার <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="badgePick" class="color-picker-input" value="{{ old('badge_color', '#841778') }}">
                                        <input type="text" name="badge_color" id="badgeText" class="form-control edu-input" value="{{ old('badge_color', '#841778') }}" required>
                                    </div>
                                    <small class="text-muted" style="font-size:11px;">STUDENT লেখার ব্যাকগ্রাউন্ড</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="color-card">
                                    <label class="edu-label mb-1">ফিল্ড লেবেল কালার <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="labelPick" class="color-picker-input" value="{{ old('label_color', '#6a1b9a') }}">
                                        <input type="text" name="label_color" id="labelText" class="form-control edu-input" value="{{ old('label_color', '#6a1b9a') }}" required>
                                    </div>
                                    <small class="text-muted" style="font-size:11px;">Class, Roll, ID লেবেল ফন্ট কালার</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="color-card">
                                    <label class="edu-label mb-1">ছবির বর্ডার কালার <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="photoBorderPick" class="color-picker-input" value="{{ old('photo_border_color', '#ab47bc') }}">
                                        <input type="text" name="photo_border_color" id="photoBorderText" class="form-control edu-input" value="{{ old('photo_border_color', '#ab47bc') }}" required>
                                    </div>
                                    <small class="text-muted" style="font-size:11px;">শিক্ষার্থীর ছবির ফ্রেমের রঙ</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="color-card">
                                    <label class="edu-label mb-1">পেছনের হেডার ব্যাকগ্রাউন্ড <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="backBgPick" class="color-picker-input" value="{{ old('back_header_bg', '#f3e8ff') }}">
                                        <input type="text" name="back_header_bg" id="backBgText" class="form-control edu-input" value="{{ old('back_header_bg', '#f3e8ff') }}" required>
                                    </div>
                                    <small class="text-muted" style="font-size:11px;">TERMS AND CONDITIONS বক্স ব্যাকগ্রাউন্ড</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="color-card">
                                    <label class="edu-label mb-1">পেছনের হেডার টেক্সট কালার <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" id="backTextPick" class="color-picker-input" value="{{ old('back_header_text', '#6a1b9a') }}">
                                        <input type="text" name="back_header_text" id="backTextText" class="form-control edu-input" value="{{ old('back_header_text', '#6a1b9a') }}" required>
                                    </div>
                                    <small class="text-muted" style="font-size:11px;">TERMS AND CONDITIONS টেক্সটের রঙ</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons (Matching id_card_preview.blade.php styles) --}}
                <div class="d-flex align-items-center gap-3 pt-2">
                    <button type="submit" class="btn btn-primary fw-bold px-4 py-2.5 rounded-pill shadow-sm">
                        <i class="fa-solid fa-cloud-arrow-up me-1.5"></i> {{ __('সেভ ও পাবলিশ করুন') }}
                    </button>
                    <a href="{{ route('super.id-card-designs.index') }}" class="btn btn-outline-secondary px-4 py-2.5 rounded-pill fw-semibold shadow-sm">
                        {{ __('বাতিল') }}
                    </a>
                </div>
            </form>
        </div>

        {{-- Right: Live Interactive Card Simulator Station --}}
        <div class="col-lg-5">
            <div class="preview-station">
                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-eye text-primary me-1.5"></i>{{ __('লাইভ আইডি কার্ড প্রিভিউ') }}
                    </h6>
                    <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-2.5 py-1" style="font-size:11px;">CR80 Scaled</span>
                </div>

                {{-- Side Visibility Toggle Buttons (EXACTLY like id_card_preview.blade.php) --}}
                <div class="idcard-view-group mb-3" role="group" aria-label="Side visibility">
                    <button type="button" class="idcard-view-btn active" id="btnShowBoth" onclick="setSideView('both')">
                        <i class="fa-solid fa-table-columns me-1"></i>
                        <span>{{ __('উভয় পাশ') }}</span>
                    </button>
                    <button type="button" class="idcard-view-btn" id="btnShowFront" onclick="setSideView('front')">
                        <i class="fa-solid fa-id-card me-1"></i>
                        <span>{{ __('সম্মুখভাগ (Front)') }}</span>
                    </button>
                    <button type="button" class="idcard-view-btn" id="btnShowBack" onclick="setSideView('back')">
                        <i class="fa-solid fa-qrcode me-1"></i>
                        <span>{{ __('পেছনভাগ (Back)') }}</span>
                    </button>
                </div>

                {{-- Card Simulator Stage --}}
                <div class="sim-stage-flex" id="simStageFlex">
                    
                    {{-- ── FRONT CARD ── --}}
                    <div class="sim-card card-front-box" id="cardFrontBox">
                        <div class="sim-card-gloss"></div>

                        <div class="card-front-header" id="simFrontHeader">
                            <img id="simHeaderShapeImg" src="" style="display:none;" alt="Header Shape">
                        </div>
                        <div class="card-school-name">IDEAL MODEL HIGH SCHOOL</div>

                        <div class="card-avatar-box" id="simAvatarBox">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <div class="card-student-name">ARIF HOSSAIN</div>
                        <div class="card-badge-pill" id="simBadgePill">STUDENT</div>

                        <table class="card-meta-table">
                            <tr>
                                <td class="card-lbl" id="simLblClass">Class</td>
                                <td class="card-val">: Class 8</td>
                            </tr>
                            <tr>
                                <td class="card-lbl" id="simLblRoll">Roll No</td>
                                <td class="card-val">: 12</td>
                            </tr>
                            <tr>
                                <td class="card-lbl" id="simLblId">Student ID</td>
                                <td class="card-val">: STU-2026-0812</td>
                            </tr>
                            <tr>
                                <td class="card-lbl" id="simLblBlood">Blood Grp</td>
                                <td class="card-val">: B+</td>
                            </tr>
                        </table>

                        <div class="card-bottom-bar" id="simBottomBar">
                            <img id="simBottomBarImg" src="" style="display:none;" alt="Bar">
                        </div>
                    </div>

                    {{-- ── BACK CARD ── --}}
                    <div class="sim-card card-back-box" id="cardBackBox">
                        <div class="sim-card-gloss"></div>

                        <div class="card-back-container">
                            <div class="card-bottom-bar" id="simBackTopBar" style="top:0; height:6px;"></div>

                            <div class="card-back-hd" id="simBackHeader">
                                TERMS AND CONDITIONS
                            </div>

                            <div class="card-back-terms">
                                <p class="mb-1">• Property of <strong>Ideal Model High School</strong>.</p>
                                <p class="mb-1">• Return if found to school administration office.</p>
                                <p class="mb-0"><strong>Session:</strong> 2026</p>
                            </div>

                            <div class="card-back-qr">
                                <i class="fa-solid fa-qrcode" id="simQrIcon"></i>
                                <span class="card-back-id" id="simBackIdTxt">STU-2026-0812</span>
                            </div>

                            <div class="card-bottom-bar" id="simBackBottomBar"></div>
                        </div>
                    </div>

                </div>

                {{-- Footnote helper --}}
                <div class="text-center mt-3 pt-2 text-muted small border-top w-100" style="font-size:11.5px;">
                    <i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i>
                    {{ __('কালার পিকার বা শেপ সিলেক্ট করলে সরাসরি উভয় পাশে পরিবর্তন দেখা যাবে।') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJS')
<script>
    // Side View Switcher (Exactly matching id_card_preview.blade.php buttons & logic)
    function setSideView(view) {
        const frontBox = document.getElementById('cardFrontBox');
        const backBox = document.getElementById('cardBackBox');
        const btnBoth = document.getElementById('btnShowBoth');
        const btnFront = document.getElementById('btnShowFront');
        const btnBack = document.getElementById('btnShowBack');

        $('.idcard-view-btn').removeClass('active');

        if (view === 'both') {
            btnBoth.classList.add('active');
            frontBox.style.display = 'block';
            backBox.style.display = 'block';
        } else if (view === 'front') {
            btnFront.classList.add('active');
            frontBox.style.display = 'block';
            backBox.style.display = 'none';
        } else if (view === 'back') {
            btnBack.classList.add('active');
            frontBox.style.display = 'none';
            backBox.style.display = 'block';
        }
    }

    // Color sync binding helper
    function bindColorSync(pickerId, textId, onUpdate) {
        const pick = document.getElementById(pickerId);
        const txt = document.getElementById(textId);
        if (!pick || !txt) return;

        pick.addEventListener('input', () => {
            txt.value = pick.value;
            if (onUpdate) onUpdate(pick.value);
        });
        txt.addEventListener('input', () => {
            if (/^#[0-9A-Fa-f]{6}$/.test(txt.value)) {
                pick.value = txt.value;
                if (onUpdate) onUpdate(txt.value);
            }
        });
    }

    // Realtime card updates
    function updatePrimary(c) {
        document.getElementById('simFrontHeader').style.backgroundColor = c;
        document.getElementById('simBottomBar').style.backgroundColor = c;
        document.getElementById('simBackTopBar').style.backgroundColor = c;
        document.getElementById('simBackBottomBar').style.backgroundColor = c;
        document.getElementById('simQrIcon').style.color = c;
    }
    function updateBadge(c) {
        document.getElementById('simBadgePill').style.backgroundColor = c;
    }
    function updateLabel(c) {
        ['simLblClass', 'simLblRoll', 'simLblId', 'simLblBlood'].forEach(id => {
            document.getElementById(id).style.color = c;
        });
        document.getElementById('simBackIdTxt').style.color = c;
    }
    function updateBorder(c) {
        document.getElementById('simAvatarBox').style.borderColor = c;
    }
    function updateBackHeader(bg, text) {
        const el = document.getElementById('simBackHeader');
        if (bg) el.style.backgroundColor = bg;
        if (text) el.style.color = text;
    }

    bindColorSync('primaryPick', 'primaryText', updatePrimary);
    bindColorSync('badgePick', 'badgeText', updateBadge);
    bindColorSync('labelPick', 'labelText', updateLabel);
    bindColorSync('photoBorderPick', 'photoBorderText', updateBorder);
    bindColorSync('backBgPick', 'backBgText', (v) => updateBackHeader(v, null));
    bindColorSync('backTextPick', 'backTextText', (v) => updateBackHeader(null, v));

    // Preset helper
    function applyPreset(primary, badge, label, border, backBg, backText, name) {
        document.getElementById('primaryPick').value = primary;
        document.getElementById('primaryText').value = primary;
        updatePrimary(primary);

        document.getElementById('badgePick').value = badge;
        document.getElementById('badgeText').value = badge;
        updateBadge(badge);

        document.getElementById('labelPick').value = label;
        document.getElementById('labelText').value = label;
        updateLabel(label);

        document.getElementById('photoBorderPick').value = border;
        document.getElementById('photoBorderText').value = border;
        updateBorder(border);

        document.getElementById('backBgPick').value = backBg;
        document.getElementById('backBgText').value = backBg;

        document.getElementById('backTextPick').value = backText;
        document.getElementById('backTextText').value = backText;
        updateBackHeader(backBg, backText);

        if (!document.getElementById('nameInput').value.trim() && name) {
            document.getElementById('nameInput').value = name;
            autoSlug(name);
        }
    }

    // Auto slug generator
    function autoSlug(text) {
        const slug = text.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('slugInput').value = slug;
    }
    document.getElementById('nameInput').addEventListener('input', function() {
        if (!document.getElementById('slugInput').dataset.customized) {
            autoSlug(this.value);
        }
    });
    document.getElementById('slugInput').addEventListener('input', function() {
        this.dataset.customized = 'true';
    });

    // Header shape dropzone & preview
    const shapeInput = document.getElementById('headerShapeInput');
    const shapePill = document.getElementById('shapePill');
    const shapeThumb = document.getElementById('shapeThumb');
    const shapeName = document.getElementById('shapeFileName');
    const shapeSize = document.getElementById('shapeFileSize');
    const simShapeImg = document.getElementById('simHeaderShapeImg');

    shapeInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                simShapeImg.src = evt.target.result;
                simShapeImg.style.display = 'block';
                shapeThumb.src = evt.target.result;
                shapeName.textContent = file.name;
                shapeSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
                shapePill.classList.remove('d-none');
                shapePill.classList.add('d-flex');
            };
            reader.readAsDataURL(file);
        } else {
            clearHeaderShape();
        }
    });

    function clearHeaderShape() {
        shapeInput.value = '';
        simShapeImg.src = '';
        simShapeImg.style.display = 'none';
        shapePill.classList.remove('d-flex');
        shapePill.classList.add('d-none');
    }

    // Bottom bar preview
    const barInput = document.getElementById('gradientBarInput');
    const simBarImg = document.getElementById('simBottomBarImg');
    barInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                simBarImg.src = evt.target.result;
                simBarImg.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            simBarImg.style.display = 'none';
        }
    });

    // Initialize values on start
    updatePrimary(document.getElementById('primaryText').value);
    updateBadge(document.getElementById('badgeText').value);
    updateLabel(document.getElementById('labelText').value);
    updateBorder(document.getElementById('photoBorderText').value);
    updateBackHeader(document.getElementById('backBgText').value, document.getElementById('backTextText').value);
</script>
@endsection
