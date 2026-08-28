@extends($layout)

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ══════════════════════════════════════════════
           RESULT SEARCH DASHBOARD PANEL STYLES
        ══════════════════════════════════════════════ */
        .search-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(15,23,42,0.18);
        }
        .search-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 240px; height: 240px;
            background: rgba(99,102,241,0.18);
            border-radius: 50%;
            filter: blur(20px);
        }
        .search-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 180px; height: 180px;
            background: rgba(168,85,247,0.12);
            border-radius: 50%;
            filter: blur(15px);
        }
        .search-hero-content { position: relative; z-index: 2; }
        .search-hero-title {
            font-size: 1.7rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 6px 0;
            letter-spacing: -0.5px;
        }
        .search-hero-subtitle {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.8);
            margin: 0;
        }

        /* ── Search Form Card ── */
        .search-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 24px 28px;
            box-shadow: 0 10px 30px rgba(15,23,42,0.06);
            border: 1px solid rgba(226,232,240,0.8);
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }
        .search-card:hover {
            box-shadow: 0 15px 35px rgba(15,23,42,0.09);
        }
        .input-group-search {
            position: relative;
        }
        .input-group-search .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6366f1;
            font-size: 1.15rem;
            z-index: 5;
        }
        .search-input-main {
            height: 52px;
            padding-left: 50px !important;
            padding-right: 18px !important;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 14px;
            border: 2px solid #e2e8f0;
            background-color: #f8fafc;
            color: #0f172a;
            transition: all 0.25s ease;
        }
        .search-input-main:focus {
            background-color: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
        }
        .btn-search-submit {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            height: 52px;
            padding: 0 28px;
            font-weight: 700;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 8px 20px rgba(79,70,229,0.3);
            transition: all 0.25s ease;
            white-space: nowrap;
        }
        .btn-search-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(79,70,229,0.4);
            color: #ffffff;
        }
        .btn-search-submit:active {
            transform: translateY(0);
        }

        /* ── Filter Fields ── */
        .filter-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
        }
        .filter-select {
            height: 44px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.88rem;
            font-weight: 500;
            color: #1e293b;
            background-color: #f8fafc;
            transition: border-color 0.2s;
        }
        .filter-select:focus {
            border-color: #6366f1;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }

        /* ── Result Container ── */
        #resultDisplayContainer {
            animation: fadeIn 0.4s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Exam Switcher Tabs ── */
        .exam-pills-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 12px 16px;
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }
        .exam-pill-btn {
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #334155;
            font-weight: 600;
            font-size: 0.84rem;
            padding: 7px 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .exam-pill-btn:hover {
            border-color: #6366f1;
            color: #4f46e5;
            background: #eef2ff;
        }
        .exam-pill-btn.active {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            border-color: #4f46e5;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79,70,229,0.25);
        }

        /* ── Student Header Card ── */
        .student-profile-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 18px;
            padding: 24px;
            color: #ffffff;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(15,23,42,0.15);
        }
        .student-avatar {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
            border: 2.5px solid rgba(255,255,255,0.2);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .student-avatar i {
            font-size: 2.2rem;
            color: rgba(255,255,255,0.6);
        }
        .student-name-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 4px;
        }
        .student-meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255,255,255,0.12);
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
        }
        .student-meta-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 20px;
            margin-top: 14px;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.75);
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 12px;
        }
        .student-meta-grid span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .student-meta-grid strong {
            color: #ffffff;
            font-weight: 700;
        }

        /* ── KPI Stats Grid ── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }
        @media (max-width: 991px) {
            .kpi-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 576px) {
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        }
        .kpi-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(15,23,42,0.04);
            text-align: center;
            transition: transform 0.2s;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
        }
        .kpi-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 4px;
        }
        .kpi-value {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }
        .kpi-card.kpi-gpa {
            border-left: 4px solid #4f46e5;
        }
        .kpi-card.kpi-gpa .kpi-value {
            color: #4f46e5;
        }
        .kpi-card.kpi-grade {
            border-left: 4px solid #10b981;
        }
        .kpi-card.kpi-grade .kpi-value {
            color: #10b981;
        }
        .kpi-card.kpi-marks {
            border-left: 4px solid #f59e0b;
        }
        .kpi-card.kpi-marks .kpi-value {
            color: #d97706;
        }
        .kpi-card.kpi-merit {
            border-left: 4px solid #8b5cf6;
        }
        .kpi-card.kpi-merit .kpi-value {
            color: #7c3aed;
        }
        .kpi-card.kpi-status {
            border-left: 4px solid #06b6d4;
        }
        .kpi-status-pass { color: #10b981 !important; }
        .kpi-status-fail { color: #ef4444 !important; }

        /* ── Action Hub Bar ── */
        .action-hub-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px 22px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 6px 20px rgba(15,23,42,0.04);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .btn-marksheet-download {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 10px 24px;
            font-size: 0.92rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 18px rgba(16,185,129,0.28);
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .btn-marksheet-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(16,185,129,0.38);
            color: #ffffff;
        }
        .btn-print-screen {
            background: #f1f5f9;
            color: #334155;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .btn-print-screen:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        /* ── Marks Table ── */
        .marks-table-card {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(15,23,42,0.05);
            margin-bottom: 24px;
        }
        .marks-table-header {
            padding: 18px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .marks-table-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .marks-table thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border: none;
        }
        .marks-table tbody td {
            padding: 14px 16px;
            font-size: 0.88rem;
            color: #1e293b;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .marks-table tbody tr:last-child td {
            border-bottom: none;
        }
        .marks-table tbody tr:hover {
            background-color: #f8fafc;
        }
        .subject-code-tag {
            display: inline-block;
            background: #e0e7ff;
            color: #4338ca;
            padding: 2px 7px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            margin-right: 6px;
        }
        .badge-grade {
            font-weight: 800;
            font-size: 0.82rem;
            padding: 4px 10px;
            border-radius: 8px;
        }
        .badge-grade-aplus { background: #dcfce7; color: #15803d; }
        .badge-grade-a     { background: #d1fae5; color: #047857; }
        .badge-grade-aminus{ background: #e0f2fe; color: #0369a1; }
        .badge-grade-b     { background: #fef3c7; color: #b45309; }
        .badge-grade-c     { background: #ffedd5; color: #c2410c; }
        .badge-grade-d     { background: #fee2e2; color: #b91c1c; }
        .badge-grade-f     { background: #fef2f2; color: #dc2626; font-weight: 900; }

        /* ── Empty & Loading States ── */
        .empty-search-state {
            background: #ffffff;
            border-radius: 18px;
            padding: 48px 24px;
            text-align: center;
            border: 2px dashed #cbd5e1;
            margin-top: 10px;
        }
        .empty-search-icon {
            width: 72px;
            height: 72px;
            background: #eef2ff;
            color: #6366f1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 16px;
        }
        .spinner-search {
            width: 20px;
            height: 20px;
            border: 2.5px solid rgba(255,255,255,0.3);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ── Print Specific Styles ── */
        @media print {
            body * { visibility: hidden; }
            #printableArea, #printableArea * { visibility: visible; }
            #printableArea {
                position: absolute;
                left: 0; top: 0; width: 100%;
            }
            .search-hero, .search-card, .action-hub-card, .exam-pills-bar, .btn-print-screen, .edu-sidebar-wrapper, .edu-header-wrapper {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-2 px-md-3">

        {{-- ── 1. Hero Header Banner ── --}}
        <div class="search-hero">
            <div class="search-hero-content">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="search-hero-title">
                            <i class="fa-solid fa-graduation-cap me-2 text-warning"></i> Result Search & Marksheet Portal
                        </h1>
                        <p class="search-hero-subtitle">
                            স্টুডেন্ট আইডি বা রোল দিয়ে ফলাফল অনুসন্ধান করুন এবং তাত্ক্ষণিকভাবে মার্কশিট ডাউনলোড করুন।
                        </p>
                    </div>
                    <div>
                        <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 rounded-pill fw-semibold" style="font-size: 0.82rem;">
                            <i class="fa-solid fa-bolt me-1 text-warning"></i> Fast Search Engine
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 2. Search & Filter Card ── --}}
        <div class="search-card">
            <form id="resultSearchForm" onsubmit="handleResultSearch(event)">
                @csrf
                <div class="row g-3 align-items-end">
                    {{-- Student ID / Roll Input --}}
                    <div class="col-lg-5 col-md-12">
                        <label class="filter-label">
                            <i class="fa-solid fa-id-card text-primary me-1"></i> Student ID / Roll / Phone <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-search">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text"
                                   id="searchQueryInput"
                                   name="search_query"
                                   class="form-control search-input-main"
                                   placeholder="e.g. STD-261004 or 1004 or Roll..."
                                   autofocus
                                   required>
                        </div>
                    </div>

                    {{-- Class Filter (Optional) --}}
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="filter-label">Class (Optional)</label>
                        <select id="filterClassSelect" name="class_id" class="form-select filter-select">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Academic Year Filter (Optional) --}}
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="filter-label">Academic Year</label>
                        <select id="filterYearSelect" name="academic_year_id" class="form-select filter-select">
                            <option value="">Current / All</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Exam Filter (Optional) --}}
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <label class="filter-label">Exam (Optional)</label>
                                <select id="filterExamSelect" name="exam_id" class="form-select filter-select">
                                    <option value="">Latest / Auto</option>
                                    @foreach($exams as $exam)
                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="align-self-end">
                                <button type="submit" id="btnSearchSubmit" class="btn-search-submit w-100">
                                    <span id="btnSearchText"><i class="fa-solid fa-search"></i> Search</span>
                                    <div id="btnSearchSpinner" class="spinner-search d-none"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- ── 3. Alert Messages ── --}}
        <div id="searchAlertBox" class="alert d-none" role="alert"></div>

        {{-- ── 4. Initial Ready State ── --}}
        <div id="initialStateBox" class="empty-search-state">
            <div class="empty-search-icon">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">ফলাফল ও মার্কশিট অনুসন্ধান</h4>
            <p class="text-muted mb-3" style="max-width: 520px; margin: 0 auto; font-size: 0.9rem;">
                শিক্ষার্থীর স্টুডেন্ট আইডি (যেমন: <strong>STD-261004</strong>) অথবা রোল নম্বর লিখে উপরের সার্চ বাটনে ক্লিক করুন। এক ক্লিকেই সম্পূর্ণ রেজাল্ট এবং অফিশিয়াল মার্কশিট PDF পাওয়া যাবে।
            </p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <span class="badge bg-light text-dark border px-3 py-2"><i class="fa-solid fa-check text-success me-1"></i> লাইভ মেরিট র‍্যাঙ্কিং</span>
                <span class="badge bg-light text-dark border px-3 py-2"><i class="fa-solid fa-check text-success me-1"></i> বিষয়ভিত্তিক মার্ক ও গ্রেড</span>
                <span class="badge bg-light text-dark border px-3 py-2"><i class="fa-solid fa-check text-success me-1"></i> ইনস্ট্যান্ট PDF মার্কশিট</span>
            </div>
        </div>

        {{-- ── 5. Dynamic Result Display Container ── --}}
        <div id="resultDisplayContainer" class="d-none">

            {{-- ── Multi-Exam Switcher Bar (Visible if multiple exams exist) ── --}}
            <div id="examPillsBar" class="exam-pills-bar d-none">
                <span class="text-muted fw-bold me-2" style="font-size: 0.82rem;">
                    <i class="fa-solid fa-layer-group text-primary me-1"></i> Available Exams:
                </span>
                <div id="examPillsList" class="d-flex flex-wrap gap-2"></div>
            </div>

            <div id="printableArea">
                {{-- ── Student Information Profile Card ── --}}
                <div class="student-profile-card">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="student-avatar" id="studentAvatarBox">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <h3 class="student-name-title" id="studentName">Student Name</h3>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="student-meta-badge" id="studentIdBadge">ID: STD-0000</span>
                                        <span class="student-meta-badge" id="studentRollBadge">Roll: #00</span>
                                        <span class="student-meta-badge" id="studentClassBadge">Class: N/A</span>
                                        <span class="student-meta-badge" id="studentSectionBadge">Section: N/A</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="badge bg-warning text-dark px-3 py-2 fw-bold" id="examNameBadge" style="font-size: 0.86rem; border-radius: 8px;">
                                        Annual Examination
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="student-meta-grid">
                        <span><i class="fa-solid fa-user-group opacity-75"></i> Group: <strong id="studentGroup">General</strong></span>
                        <span><i class="fa-solid fa-calendar-days opacity-75"></i> Session: <strong id="studentSession">2026</strong></span>
                        <span><i class="fa-solid fa-user opacity-75"></i> Father's Name: <strong id="studentFather">N/A</strong></span>
                        <span><i class="fa-solid fa-phone opacity-75"></i> Contact: <strong id="studentPhone">N/A</strong></span>
                    </div>
                </div>

                {{-- ── Action Hub Bar (Download PDF & Print) ── --}}
                <div class="action-hub-card">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-subtle text-primary fw-bold px-2.5 py-1.5" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-award me-1"></i> Result Summary
                        </span>
                        <span class="text-muted small" id="examResultStatusText">Official Exam Result Summary</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn-print-screen" onclick="window.print()">
                            <i class="fa-solid fa-print"></i> Print
                        </button>
                        <a href="#" id="btnDownloadMarksheet" class="btn-marksheet-download" target="_blank">
                            <i class="fa-solid fa-file-arrow-down"></i> Download Marksheet (PDF)
                        </a>
                    </div>
                </div>

                {{-- ── KPI Result Summary Cards ── --}}
                <div class="kpi-grid">
                    <div class="kpi-card kpi-gpa">
                        <div class="kpi-label">GPA (Out of 5.00)</div>
                        <div class="kpi-value" id="kpiGpa">0.00</div>
                    </div>
                    <div class="kpi-card kpi-grade">
                        <div class="kpi-label">Letter Grade</div>
                        <div class="kpi-value" id="kpiGrade">F</div>
                    </div>
                    <div class="kpi-card kpi-marks">
                        <div class="kpi-label">Total Marks</div>
                        <div class="kpi-value" id="kpiTotalMarks">0</div>
                    </div>
                    <div class="kpi-card kpi-merit">
                        <div class="kpi-label">Merit Position</div>
                        <div class="kpi-value" id="kpiMerit">N/A</div>
                    </div>
                    <div class="kpi-card kpi-status">
                        <div class="kpi-label">Result Status</div>
                        <div class="kpi-value" id="kpiStatus">PASS</div>
                    </div>
                </div>

                {{-- ── Subject-Wise Marks Breakdown Table ── --}}
                <div class="marks-table-card">
                    <div class="marks-table-header">
                        <h4 class="marks-table-title">
                            <i class="fa-solid fa-table-list text-primary"></i> Subject-Wise Marks & Grade Breakdown
                        </h4>
                        <span class="badge bg-secondary-subtle text-secondary px-3 py-1 fw-semibold" id="totalSubjectsBadge">
                            0 Subjects
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table marks-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">#</th>
                                    <th>Subject Name & Code</th>
                                    <th class="text-center">Full Marks</th>
                                    <th class="text-center">CQ</th>
                                    <th class="text-center">MCQ</th>
                                    <th class="text-center">Practical</th>
                                    <th class="text-center">Total Marks</th>
                                    <th class="text-center">Grade Point</th>
                                    <th class="text-center">Letter Grade</th>
                                </tr>
                            </thead>
                            <tbody id="subjectMarksTableBody">
                                {{-- Rows populated via JavaScript --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('customJS')
<script>
    const SEARCH_ROUTE = "{{ route('marks.result-search-query', ['tenant' => $tenant]) }}";
    let currentStudentIdentifier = '';

    function handleResultSearch(e, examId = null) {
        if (e) e.preventDefault();

        const queryInput = document.getElementById('searchQueryInput');
        const query = (queryInput ? queryInput.value : '').trim() || currentStudentIdentifier;

        if (!query) {
            showAlert('warning', 'অনুগ্রহ করে স্টুডেন্ট আইডি বা রোল নম্বর লিখুন।');
            return;
        }

        currentStudentIdentifier = query;

        const classId = document.getElementById('filterClassSelect').value;
        const yearId = document.getElementById('filterYearSelect').value;
        const selectedExamId = examId || document.getElementById('filterExamSelect').value;

        // UI Loading State
        setLoadingState(true);
        hideAlert();

        const payload = {
            search_query: query,
            class_id: classId || null,
            academic_year_id: yearId || null,
            exam_id: selectedExamId || null,
            _token: "{{ csrf_token() }}"
        };

        fetch(SEARCH_ROUTE, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(async (response) => {
            const data = await response.json();
            setLoadingState(false);

            if (!response.ok || !data.status) {
                showAlert('danger', data.message || 'ফলাফল পাওয়া যায়নি। অনুগ্রহ করে সঠিক তথ্য প্রদান করুন।');
                document.getElementById('resultDisplayContainer').classList.add('d-none');
                document.getElementById('initialStateBox').classList.remove('d-none');
                return;
            }

            // Render Result
            renderResultData(data);
        })
        .catch((error) => {
            setLoadingState(false);
            console.error('Search Error:', error);
            showAlert('danger', 'সার্ভার সমস্যা হয়েছে। অনুগ্রহ করে পুনরায় চেষ্টা করুন।');
        });
    }

    function renderResultData(data) {
        document.getElementById('initialStateBox').classList.add('d-none');
        const container = document.getElementById('resultDisplayContainer');
        container.classList.remove('d-none');

        const student = data.student;
        const exam = data.exam;
        const summary = data.result_summary;
        const subjects = data.subject_rows || [];
        const availableExams = data.available_exams || [];

        // 1. Student Profile
        document.getElementById('studentName').textContent = student.name || 'N/A';
        document.getElementById('studentIdBadge').innerHTML = `<i class="fa-solid fa-id-badge opacity-75"></i> ID: <strong>${student.student_id || student.id}</strong>`;
        document.getElementById('studentRollBadge').innerHTML = `<i class="fa-solid fa-hashtag opacity-75"></i> Roll: <strong>${student.roll || 'N/A'}</strong>`;
        document.getElementById('studentClassBadge').innerHTML = `<i class="fa-solid fa-school opacity-75"></i> Class: <strong>${student.class_name || 'N/A'}</strong>`;
        document.getElementById('studentSectionBadge').innerHTML = `<i class="fa-solid fa-layer-group opacity-75"></i> Sec: <strong>${student.section_name || 'N/A'}</strong>`;

        document.getElementById('studentGroup').textContent = student.group_name || 'General';
        document.getElementById('studentSession').textContent = student.academic_year || 'N/A';
        document.getElementById('studentFather').textContent = student.fathers_name || 'N/A';
        document.getElementById('studentPhone').textContent = student.contact_number || 'N/A';

        const avatarBox = document.getElementById('studentAvatarBox');
        if (student.photo) {
            avatarBox.innerHTML = `<img src="${student.photo}" alt="${student.name}" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\\'fa-solid fa-user-graduate\\'></i>';">`;
        } else {
            avatarBox.innerHTML = '<i class="fa-solid fa-user-graduate"></i>';
        }

        // Exam badge
        document.getElementById('examNameBadge').textContent = `${exam.name} ${exam.year_name ? '(' + exam.year_name + ')' : ''}`;

        // 2. Multi-Exam Switcher Bar
        const examPillsBar = document.getElementById('examPillsBar');
        const examPillsList = document.getElementById('examPillsList');
        if (availableExams.length > 1) {
            examPillsBar.classList.remove('d-none');
            examPillsList.innerHTML = availableExams.map(ex => `
                <button type="button"
                        class="exam-pill-btn ${ex.is_selected ? 'active' : ''}"
                        onclick="handleResultSearch(null, ${ex.id})">
                    <i class="fa-solid ${ex.is_selected ? 'fa-circle-check' : 'fa-circle'}"></i> ${ex.name}
                </button>
            `).join('');
        } else {
            examPillsBar.classList.add('d-none');
        }

        // 3. KPI Cards
        document.getElementById('kpiGpa').textContent = summary.gpa || '0.00';
        document.getElementById('kpiGrade').textContent = summary.grade || 'F';
        document.getElementById('kpiTotalMarks').textContent = summary.total_marks || '0';
        document.getElementById('kpiMerit').textContent = summary.merit_position || 'N/A';

        const statusEl = document.getElementById('kpiStatus');
        if (summary.is_passed) {
            statusEl.textContent = 'PASSED';
            statusEl.className = 'kpi-value kpi-status-pass';
        } else {
            statusEl.textContent = summary.fail_count > 0 ? `FAILED (${summary.fail_count})` : 'FAILED';
            statusEl.className = 'kpi-value kpi-status-fail';
        }

        // 4. Download Marksheet Link
        const downloadBtn = document.getElementById('btnDownloadMarksheet');
        if (data.marksheet_url) {
            downloadBtn.href = data.marksheet_url;
            downloadBtn.classList.remove('d-none');
        } else {
            downloadBtn.classList.add('d-none');
        }

        // 5. Subject Marks Table
        document.getElementById('totalSubjectsBadge').textContent = `${subjects.length} Subjects`;
        const tbody = document.getElementById('subjectMarksTableBody');

        if (subjects.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="fa-solid fa-inbox me-1"></i> এই পরীক্ষার কোনো বিষয়ের নম্বর পাওয়া যায়নি।
                    </td>
                </tr>
            `;
            return;
        }

        let tableHtml = '';
        subjects.forEach((sub, idx) => {
            const gradeClass = getGradeBadgeClass(sub.grade);
            const codeTag = sub.subject_code ? `<span class="subject-code-tag">${sub.subject_code}</span>` : '';

            tableHtml += `
                <tr>
                    <td class="text-center text-muted fw-bold">${idx + 1}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            ${codeTag}
                            <span class="fw-bold text-dark">${sub.subject_name}</span>
                        </div>
                    </td>
                    <td class="text-center fw-semibold text-muted">${sub.full_mark || '-'}</td>
                    <td class="text-center">${sub.cq !== null && sub.cq !== undefined && sub.cq !== '' ? sub.cq : '-'}</td>
                    <td class="text-center">${sub.mcq !== null && sub.mcq !== undefined && sub.mcq !== '' ? sub.mcq : '-'}</td>
                    <td class="text-center">${sub.practical !== null && sub.practical !== undefined && sub.practical !== '' ? sub.practical : '-'}</td>
                    <td class="text-center fw-bold text-dark">${sub.marks !== null && sub.marks !== undefined ? sub.marks : '-'}</td>
                    <td class="text-center fw-bold text-primary">${sub.point !== null && sub.point !== undefined ? Number(sub.point).toFixed(2) : '-'}</td>
                    <td class="text-center">
                        <span class="badge-grade ${gradeClass}">${sub.grade || '-'}</span>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = tableHtml;
    }

    function getGradeBadgeClass(grade) {
        if (!grade) return 'badge-grade-f';
        const g = String(grade).trim().toUpperCase();
        if (g === 'A+') return 'badge-grade-aplus';
        if (g === 'A')  return 'badge-grade-a';
        if (g === 'A-') return 'badge-grade-aminus';
        if (g === 'B')  return 'badge-grade-b';
        if (g === 'C')  return 'badge-grade-c';
        if (g === 'D')  return 'badge-grade-d';
        return 'badge-grade-f';
    }

    function setLoadingState(isLoading) {
        const btn = document.getElementById('btnSearchSubmit');
        const text = document.getElementById('btnSearchText');
        const spinner = document.getElementById('btnSearchSpinner');

        if (isLoading) {
            btn.disabled = true;
            text.classList.add('d-none');
            spinner.classList.remove('d-none');
        } else {
            btn.disabled = false;
            text.classList.remove('d-none');
            spinner.classList.add('d-none');
        }
    }

    function showAlert(type, message) {
        const box = document.getElementById('searchAlertBox');
        box.className = `alert alert-${type} d-flex align-items-center gap-2 mb-3`;
        box.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> <div>${message}</div>`;
        box.classList.remove('d-none');
    }

    function hideAlert() {
        const box = document.getElementById('searchAlertBox');
        box.classList.add('d-none');
    }
</script>
@endsection
