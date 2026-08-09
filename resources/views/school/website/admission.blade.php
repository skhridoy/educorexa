@extends('school.website.layouts.app')

@section('customCSS')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

    .admission-page-wrapper {
        font-family: 'Outfit', sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    /* ══════════════════════════════════════════════
       HERO BANNER
    ══════════════════════════════════════════════ */
    .adm-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 45%, #312e81 100%);
        padding: 55px 0 75px 0;
        position: relative;
        overflow: hidden;
        color: #ffffff;
    }
    .adm-hero::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 280px; height: 280px;
        background: rgba(99,102,241,0.18);
        border-radius: 50%;
        filter: blur(50px);
    }
    .adm-hero::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -60px;
        width: 220px; height: 220px;
        background: rgba(168,85,247,0.14);
        border-radius: 50%;
        filter: blur(40px);
    }
    .adm-hero-content { position: relative; z-index: 2; }
    .adm-school-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.18);
        backdrop-filter: blur(10px);
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 0.82rem;
        font-weight: 700;
        color: #c7d2fe;
        letter-spacing: 0.5px;
        margin-bottom: 14px;
    }
    .adm-hero-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
        color: #ffffff;
    }
    .adm-hero-subtitle {
        font-size: 1rem;
        color: rgba(255,255,255,0.75);
        margin: 0;
    }

    /* ══════════════════════════════════════════════
       FLOATING SEARCH PDF CARD
    ══════════════════════════════════════════════ */
    .adm-search-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px 28px;
        margin-top: -35px;
        margin-bottom: 30px;
        box-shadow: 0 15px 35px rgba(15,23,42,0.06);
        position: relative;
        z-index: 10;
    }
    .adm-search-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #1e1b4b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .adm-search-sub {
        font-size: 0.83rem;
        color: #64748b;
        margin-bottom: 14px;
    }
    .adm-search-input-wrap {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .adm-search-input {
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        padding: 11px 16px;
        font-size: 0.9rem;
        font-weight: 500;
        background: #f8fafc;
        transition: all 0.25s;
    }
    .adm-search-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99,102,241,0.12);
        background: #ffffff;
    }
    .btn-adm-search {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #ffffff !important;
        border: none;
        border-radius: 12px;
        padding: 11px 24px;
        font-size: 0.88rem;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-adm-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79,70,229,0.32);
    }
    .adm-results-container {
        margin-top: 16px;
        display: none;
    }
    .adm-result-chip {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        transition: all 0.2s;
    }
    .adm-result-chip:hover { border-color: #c7d2fe; background: #ffffff; }

    /* ══════════════════════════════════════════════
       MAIN FORM CARD
    ══════════════════════════════════════════════ */
    .adm-form-card {
        background: #ffffff;
        border: 1.5px solid #f1f5f9;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(15,23,42,0.07);
        overflow: hidden;
        margin-bottom: 50px;
    }
    .adm-form-header {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 24px 32px;
        border-bottom: 1.5px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .adm-form-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .adm-form-title-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    .adm-form-body {
        padding: 36px 36px;
    }

    /* Section Header Dividers */
    .adm-section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        font-weight: 800;
        color: #1e1b4b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding-bottom: 10px;
        margin-bottom: 22px;
        border-bottom: 2px solid #e0e7ff;
    }
    .adm-section-header i {
        color: #4f46e5;
        font-size: 1.1rem;
    }

    /* Input styling */
    .adm-field-group { margin-bottom: 20px; }
    .adm-label {
        font-size: 0.83rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 7px;
        display: block;
    }
    .adm-input, .adm-select {
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        padding: 11px 15px;
        font-size: 0.9rem;
        font-weight: 500;
        background: #f8fafc;
        color: #0f172a;
        transition: all 0.25s;
    }
    .adm-input:focus, .adm-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99,102,241,0.12);
        background: #ffffff;
    }

    /* Photo Upload Dropzone Box */
    .photo-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        background: #f8fafc;
        transition: all 0.25s;
        cursor: pointer;
    }
    .photo-upload-zone:hover {
        border-color: #6366f1;
        background: #f5f3ff;
    }
    .photo-preview-img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 16px;
        border: 3px solid #ffffff;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        display: none;
        margin: 10px auto 0;
    }

    /* Form Action Buttons */
    .btn-adm-submit {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 12px;
        padding: 12px 36px;
        font-size: 0.95rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 6px 20px rgba(79,70,229,0.28);
    }
    .btn-adm-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(79,70,229,0.38);
    }
    .btn-adm-reset {
        background: #f1f5f9;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 24px;
        font-size: 0.9rem;
        font-weight: 700;
        transition: all 0.2s;
    }
    .btn-adm-reset:hover { background: #e2e8f0; color: #334155; }

    /* ══════════════════════════════════════════════
       ADMISSION CLOSED BOX
    ══════════════════════════════════════════════ */
    .closed-notice-card {
        background: linear-gradient(135deg, #fff5f5 0%, #fef2f2 100%);
        border: 1.5px solid #fecaca;
        border-radius: 20px;
        padding: 44px 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(239,68,68,0.06);
    }
    .closed-notice-icon {
        width: 72px; height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 18px;
        box-shadow: 0 8px 24px rgba(239,68,68,0.3);
    }

    /* ══════════════════════════════════════════════
       RESPONSIVE MEDIA QUERIES
    ══════════════════════════════════════════════ */
    @media (max-width: 991.98px) {
        .adm-hero { padding: 40px 0 60px 0; }
        .adm-hero-title { font-size: 1.65rem; }
        .adm-form-body { padding: 24px 20px; }
        .adm-search-card { padding: 18px 20px; margin-top: -25px; }
    }
    @media (max-width: 575.98px) {
        .adm-hero-title { font-size: 1.35rem; }
        .adm-search-input-wrap { flex-direction: column; }
        .btn-adm-search { width: 100%; justify-content: center; }
        .btn-adm-submit { width: 100%; justify-content: center; }
        .btn-adm-reset  { width: 100%; text-align: center; }
        .adm-form-header { padding: 18px 20px; }
    }
</style>
@endsection

@section('content')
<div class="admission-page-wrapper">

    {{-- ══ HERO HEADER BANNER ══ --}}
    <div class="adm-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center adm-hero-content">
                    <div class="adm-school-badge">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Academic Session {{ $admissionYear?->name ?? date('Y') }} — Online Portal
                    </div>
                    <h1 class="adm-hero-title">
                        {{ app('currentSchool')->name ?? 'School Admission Portal' }}
                    </h1>
                    <p class="adm-hero-subtitle">
                        স্বাগতম! {{ $admissionYear?->name ?? '' }} শিক্ষাবর্ষে অনলাইনে সহজ ও দ্রুত ভর্তি আবেদনের প্রাতিষ্ঠানিক পোর্টাল।
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- ══ FLOATING PDF SEARCH & DOWNLOAD CARD ══ --}}
                <div class="adm-search-card">
                    <div class="adm-search-title">
                        <i class="fa-solid fa-file-pdf text-indigo-600" style="color:#4f46e5;"></i>
                        পূর্বে জমাকৃত ভর্তি আবেদন (PDF) ডাউনলোড করুন
                    </div>
                    <div class="adm-search-sub">
                        আবেদনকারীর ১১ ডিজিটের মোবাইল নম্বর অথবা অ্যাডমিশন আইডি দিয়ে যেকোনো সময় পিডিএফ ডাউনলোড করুন
                    </div>

                    <div class="adm-search-input-wrap">
                        <input type="text"
                               id="searchPhoneOrId"
                               class="form-control adm-search-input flex-grow-1"
                               placeholder="মোবাইল নম্বর (যেমন: 01712345678) অথবা Admission ID..." />
                        <button type="button" class="btn-adm-search" id="searchPdfBtn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            ডাউনলোড/খুঁজুন
                        </button>
                    </div>

                    {{-- Dynamic AJAX Results Container --}}
                    <div id="pdfSearchResults" class="adm-results-container"></div>
                </div>

                {{-- ══ MAIN ADMISSION FORM CARD / CLOSED NOTICE ══ --}}
                <div class="adm-form-card">
                    
                    <div class="adm-form-header">
                        <h4 class="adm-form-title">
                            <span class="adm-form-title-icon">
                                <i class="fa-solid fa-id-card"></i>
                            </span>
                            শিক্ষার্থী ভর্তি আবেদন ফর্ম
                        </h4>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="badge bg-indigo-100 text-indigo-700 border px-3 py-2 fw-bold" style="background:#e0e7ff; color:#3730a3; font-size:0.8rem; border-radius:20px;">
                                <i class="fa-solid fa-calendar-days me-1"></i>সেশন: {{ $admissionYear?->name ?? 'N/A' }}
                            </span>
                            @if(!empty($isAdmissionClosed))
                                <span class="badge bg-danger px-3 py-2" style="font-size:0.8rem; border-radius:20px;">
                                    <i class="fa-solid fa-lock me-1"></i>Admission Closed
                                </span>
                            @else
                                <span class="badge bg-success px-3 py-2" style="font-size:0.8rem; border-radius:20px;">
                                    <i class="fa-solid fa-circle-dot me-1"></i>Admission Active
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="adm-form-body">

                        @if(!empty($isAdmissionClosed))
                            {{-- ══ ADMISSION CLOSED STATE NOTICE ══ --}}
                            <div class="closed-notice-card">
                                <div class="closed-notice-icon">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <h3 class="fw-bold text-danger mb-2" style="font-size:1.5rem;">
                                    ভর্তি কার্যক্রম বর্তমানে বন্ধ রয়েছে
                                </h3>
                                <p class="text-dark fs-6 mb-4" style="max-width: 620px; margin: 0 auto; line-height: 1.6;">
                                    {{ $closedMessage }}
                                </p>
                                
                                @if(!empty($school->phone) || !empty($school->email))
                                    <div class="pt-3 border-top border-danger border-opacity-25 d-inline-flex flex-wrap justify-content-center gap-3">
                                        @if(!empty($school->phone))
                                            <div class="bg-white border px-3 py-2 rounded-3 shadow-sm text-dark fw-bold">
                                                <i class="fa-solid fa-phone text-danger me-2"></i>{{ $school->phone }}
                                            </div>
                                        @endif
                                        @if(!empty($school->email))
                                            <div class="bg-white border px-3 py-2 rounded-3 shadow-sm text-dark fw-bold">
                                                <i class="fa-solid fa-envelope text-danger me-2"></i>{{ $school->email }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @else
                            {{-- ══ ONLINE ADMISSION FORM ══ --}}
                            <div class="alert border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: linear-gradient(135deg, #e0e7ff, #eff6ff); border-left: 5px solid #4f46e5 !important;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-calendar-check fa-lg" style="color:#4f46e5;"></i>
                                    <div>
                                        <strong class="text-dark">ভর্তি সেশন (Academic Session):</strong>
                                        <span class="badge text-white px-2 py-1 ms-1 fw-bold" style="background:#4f46e5; font-size:0.88rem; border-radius:8px;">
                                            {{ $admissionYear?->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                                <small class="text-muted fw-bold">
                                    <i class="fa-solid fa-circle-info me-1"></i>এই আবেদনের তথ্য {{ $admissionYear?->name ?? '' }} শিক্ষাবর্ষের জন্য জমা হবে।
                                </small>
                            </div>
                            @if(session('success'))
                                <div class="alert alert-success border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2" role="alert">
                                    <div>
                                        <i class="fa-solid fa-circle-check fa-lg me-2"></i>
                                        <strong>সফল আবেদন!</strong> {{ session('success') }}
                                    </div>
                                    <a href="{{ route('admissions.pdf', ['tenant' => app('currentSchool')->slug, 'id' => session('admission_id')]) }}"
                                       class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-bold" target="_blank">
                                        <i class="fa-solid fa-file-pdf me-1"></i> PDF ডাউনলোড করুন
                                    </a>
                                </div>
                            @endif

                            @if($errors->has('admission_closed'))
                                <div class="alert alert-danger rounded-3 p-3 mb-4">
                                    <i class="fa-solid fa-circle-exclamation me-2"></i>{{ $errors->first('admission_closed') }}
                                </div>
                            @endif

                            <form action="{{ route('admission.store', ['tenant' => app('currentSchool')->slug]) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row g-4">
                                    
                                    {{-- COLUMN 1: STUDENT INFORMATION --}}
                                    <div class="col-md-6 pe-md-4">
                                        <div class="adm-section-header">
                                            <i class="fa-solid fa-user-graduate"></i>
                                            ১. শিক্ষার্থীর তথ্য (Student Information)
                                        </div>

                                        <div class="adm-field-group">
                                            <label class="adm-label">
                                                শিক্ষার্থীর পূর্ণ নাম <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   name="name"
                                                   class="form-control adm-input @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}"
                                                   placeholder="Student full name in English"
                                                   required>
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="adm-field-group">
                                            <label class="adm-label">
                                                ভর্তির প্রার্থীত শ্রেণী <span class="text-danger">*</span>
                                            </label>
                                            <select name="class_id" class="form-select adm-select @error('class_id') is-invalid @enderror" required>
                                                <option value="">Select Applying Class</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="adm-field-group">
                                            <label class="adm-label">
                                                মোবাইল নম্বর <span class="text-danger">*</span>
                                            </label>
                                            <input type="tel"
                                                   name="contact_number"
                                                   maxlength="11"
                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                   class="form-control adm-input @error('contact_number') is-invalid @enderror"
                                                   value="{{ old('contact_number') }}"
                                                   placeholder="017XXXXXXXX (11 digits)"
                                                   required>
                                            @error('contact_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <small class="text-muted mt-1 d-block" style="font-size:0.75rem;">
                                                <i class="fa-solid fa-info-circle me-1"></i>অবশ্যই ১১ ডিজিটের নম্বর দিন
                                            </small>
                                        </div>

                                        <div class="adm-field-group">
                                            <label class="adm-label">শিক্ষার্থীর ছবি (Student Photo)</label>
                                            <div class="photo-upload-zone" onclick="document.getElementById('photoInput').click()">
                                                <i class="fa-solid fa-cloud-arrow-up fa-2x text-muted mb-2 d-block"></i>
                                                <span class="fw-bold text-indigo-600" style="color:#4f46e5; font-size:0.88rem;">ছবি নির্বাচন করতে এখানে ক্লিক করুন</span>
                                                <small class="text-muted d-block" style="font-size:0.75rem;">Max file size: 2MB (JPG, PNG)</small>
                                                <img id="photoPreview" class="photo-preview-img" src="#" alt="Preview">
                                            </div>
                                            <input type="file" name="photo" id="photoInput" class="d-none @error('photo') is-invalid @enderror" accept="image/*">
                                            @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- COLUMN 2: GUARDIAN & SECURITY --}}
                                    <div class="col-md-6 ps-md-4 border-start-md">
                                        <div class="adm-section-header">
                                            <i class="fa-solid fa-shield-halved"></i>
                                            ২. অভিভাবক ও পাসওয়ার্ড (Guardian &amp; Security)
                                        </div>

                                        <div class="adm-field-group">
                                            <label class="adm-label">
                                                পিতার নাম <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   name="fathers_name"
                                                   class="form-control adm-input @error('fathers_name') is-invalid @enderror"
                                                   value="{{ old('fathers_name') }}"
                                                   placeholder="Father's name"
                                                   required>
                                            @error('fathers_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="adm-field-group">
                                            <label class="adm-label">
                                                মাতার নাম <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   name="mothers_name"
                                                   class="form-control adm-input @error('mothers_name') is-invalid @enderror"
                                                   value="{{ old('mothers_name') }}"
                                                   placeholder="Mother's name"
                                                   required>
                                            @error('mothers_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="adm-field-group">
                                            <label class="adm-label">
                                                ইমেইল ঠিকানা <span class="text-danger">*</span>
                                            </label>
                                            <input type="email"
                                                   name="email"
                                                   class="form-control adm-input @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}"
                                                   placeholder="student@example.com"
                                                   required>
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 adm-field-group">
                                                <label class="adm-label">
                                                    পাসওয়ার্ড <span class="text-danger">*</span>
                                                </label>
                                                <input type="password"
                                                       name="password"
                                                       class="form-control adm-input @error('password') is-invalid @enderror"
                                                       placeholder="••••••••"
                                                       required>
                                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-sm-6 adm-field-group">
                                                <label class="adm-label">
                                                    পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span>
                                                </label>
                                                <input type="password"
                                                       name="password_confirmation"
                                                       class="form-control adm-input"
                                                       placeholder="••••••••"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 opacity-50">

                                <div class="d-flex justify-content-end gap-3 flex-wrap">
                                    <button type="reset" class="btn-adm-reset">
                                        <i class="fa-solid fa-rotate-left me-1"></i>Reset Form
                                    </button>
                                    <button type="submit" class="btn-adm-submit">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Submit Admission Application
                                    </button>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    // Phone validation
    const contactInput = document.querySelector('input[name="contact_number"]');
    if (contactInput) {
        contactInput.addEventListener('blur', function (e) {
            const pattern = /^(01)[3-9]{1}[0-9]{8}$/;
            const value = e.target.value;
            if (value.length > 0 && (!pattern.test(value) || value.length !== 11)) {
                alert("সঠিক বাংলাদেশি মোবাইল নম্বর দিন (১১ ডিজিট হতে হবে)");
                e.target.classList.add('is-invalid');
            } else {
                e.target.classList.remove('is-invalid');
            }
        });
    }

    // Image preview
    const photoInput = document.getElementById('photoInput');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photoPreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // PDF Search Handler
    document.getElementById('searchPdfBtn')?.addEventListener('click', function () {
        const query = document.getElementById('searchPhoneOrId').value.trim();
        const resultsBox = document.getElementById('pdfSearchResults');

        if (!query) {
            alert('অনুগ্রহ করে মোবাইল নম্বর অথবা অ্যাডমিশন আইডি প্রদান করুন');
            return;
        }

        if (/^\d{1,6}$/.test(query)) {
            const baseUrl = "{{ route('admissions.pdf', ['tenant' => app('currentSchool')->slug, 'id' => ':id']) }}";
            window.open(baseUrl.replace(':id', query), '_blank');
            return;
        }

        resultsBox.style.display = 'block';
        resultsBox.innerHTML = '<div class="text-center text-muted py-3"><i class="fa-solid fa-spinner fa-spin me-2"></i>খোঁজা হচ্ছে...</div>';

        const searchUrl = "{{ route('admissions.searchByPhone', ['tenant' => app('currentSchool')->slug]) }}?phone=" + encodeURIComponent(query);
        
        fetch(searchUrl)
            .then(res => res.json())
            .then(data => {
                if (data.status && data.admissions.length > 0) {
                    let html = '<h6 class="fw-bold mb-3 text-dark">আবেদন পাওয়া গেছে (' + data.admissions.length + 'টি):</h6>';
                    data.admissions.forEach(adm => {
                        html += `
                            <div class="adm-result-chip">
                                <div>
                                    <strong class="text-indigo-700" style="color:#4338ca;">${adm.name}</strong> 
                                    <span class="badge bg-light text-dark border ms-2">${adm.admission_number}</span><br>
                                    <small class="text-muted">মোবাইল: ${adm.contact_number} &nbsp;·&nbsp; তারিখ: ${adm.date} &nbsp;·&nbsp; স্ট্যাটাস: ${adm.status}</small>
                                </div>
                                <a href="${adm.pdf_url}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
                                    <i class="fa-solid fa-file-pdf me-1"></i> PDF ডাউনলোড
                                </a>
                            </div>
                        `;
                    });
                    resultsBox.innerHTML = html;
                } else {
                    resultsBox.innerHTML = `<div class="alert alert-warning mb-0 py-2 small">${data.message || 'কোনো আবেদন পাওয়া যায়নি।'}</div>`;
                }
            })
            .catch(() => {
                resultsBox.innerHTML = '<div class="alert alert-danger mb-0 py-2 small">সার্চ করতে সমস্যা হয়েছে। আবার চেষ্টা করুন।</div>';
            });
    });
</script>
@endsection