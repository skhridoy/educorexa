@extends($layout)

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ══════════════════════════════════════════════
           MARK INPUT STATES
        ══════════════════════════════════════════════ */
        input.mark-input::-webkit-outer-spin-button,
        input.mark-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input.mark-input[type=number] { -moz-appearance: textfield; }
        .mark-input.saving { border-color: #f59e0b; background: #fffbeb; }
        .mark-input.saved  { border-color: #22c55e; background: #f0fdf4; }
        .mark-input.error  { border-color: #ef4444; background: #fef2f2; }

        /* ══════════════════════════════════════════════
           PAGE HERO BANNER
        ══════════════════════════════════════════════ */
        .mark-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(15,23,42,0.18);
        }
        .mark-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            background: rgba(79,70,229,0.12);
            border-radius: 50%;
        }
        .mark-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 160px; height: 160px;
            background: rgba(99,102,241,0.08);
            border-radius: 50%;
        }
        .mark-hero-content { position: relative; z-index: 2; }
        .mark-hero-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 6px 0;
            letter-spacing: -0.5px;
        }
        .mark-hero-subtitle {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.7);
            margin: 0;
        }
        .mark-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            color: #a5b4fc;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            backdrop-filter: blur(8px);
            margin-top: 12px;
        }

        /* ══════════════════════════════════════════════
           FILTER SECTION
        ══════════════════════════════════════════════ */
        .mark-filter-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 18px;
            padding: 20px 24px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(15,23,42,0.05);
        }
        .mark-filter-card .filter-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
        }
        .mark-filter-card .form-select,
        .mark-filter-card .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 9px 12px;
            font-size: 0.88rem;
            font-weight: 500;
            background: #f8fafc;
            transition: all 0.2s;
        }
        .mark-filter-card .form-select:focus,
        .mark-filter-card .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
            background: #fff;
        }

        /* ══════════════════════════════════════════════
           TAB TOGGLE
        ══════════════════════════════════════════════ */
        .tab-toggle {
            display: flex;
            gap: 4px;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 4px;
        }
        .tab-btn {
            flex: 1;
            padding: 8px 18px;
            border: none;
            border-radius: 9px;
            font-size: 0.83rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            background: transparent;
            color: #64748b;
            text-decoration: none;
            text-align: center;
            white-space: nowrap;
        }
        .tab-btn.active {
            background: #fff;
            color: #4f46e5;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* ══════════════════════════════════════════════
           STATS BAR
        ══════════════════════════════════════════════ */
        .stats-bar {
            display: flex;
            gap: 10px;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 4px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .stats-bar::-webkit-scrollbar { height: 3px; }
        .stats-bar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 12px 16px;
            border: 1.5px solid #f1f5f9;
            flex: 1 0 auto;
            min-width: 80px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(15,23,42,0.04);
            transition: all 0.2s;
        }
        .stat-card:hover { border-color: #c7d2fe; transform: translateY(-2px); }
        .stat-card .num { font-size: 1.3rem; font-weight: 800; color: #0f172a; line-height: 1.2; }
        .stat-card .lbl { font-size: 0.6rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px; }

        /* ══════════════════════════════════════════════
           STATUS TOGGLE
        ══════════════════════════════════════════════ */
        .status-toggle {
            display: inline-flex;
            border-radius: 10px;
            overflow: hidden;
            border: 1.5px solid #cbd5e1;
            background: #f8fafc;
            flex-shrink: 0;
            height: 38px;
        }
        .status-toggle .st-btn {
            padding: 0 12px;
            font-size: 0.78rem;
            font-weight: 700;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            transition: all 0.18s;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .status-toggle .st-btn:first-child { border-right: 1.5px solid #cbd5e1; }
        .status-toggle .st-btn.active-present { background: #dcfce7; color: #16a34a; }
        .status-toggle .st-btn.active-absent  { background: #fee2e2; color: #dc2626; }
        .status-toggle .st-btn:hover:not(.active-present):not(.active-absent) { background: #f1f5f9; color: #475569; }

        /* ══════════════════════════════════════════════
           RESPONSIVE TABLE STYLES (DESKTOP & MOBILE)
        ══════════════════════════════════════════════ */
        .edit-table-wrap,
        .report-table-wrap {
            width: 100%;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            padding: 0 0 6px;
        }
        .edit-table-wrap::-webkit-scrollbar,
        .report-table-wrap::-webkit-scrollbar { height: 6px; }
        .edit-table-wrap::-webkit-scrollbar-track,
        .report-table-wrap::-webkit-scrollbar-track { background: #f1f5f9; }
        .edit-table-wrap::-webkit-scrollbar-thumb,
        .report-table-wrap::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

        .edit-tbl,
        .report-tbl {
            width: 100% !important;
            min-width: 720px;
            border-collapse: collapse !important;
            display: table !important;
        }
        .edit-tbl thead,
        .report-tbl thead {
            display: table-header-group !important;
        }
        .edit-tbl thead th,
        .report-tbl thead th {
            background: #f8fafc !important;
            color: #475569 !important;
            font-size: 0.65rem !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.04em !important;
            padding: 8px 10px !important;
            border: none !important;
            border-bottom: 2px solid #e2e8f0 !important;
            white-space: nowrap !important;
            display: table-cell !important;
            vertical-align: middle !important;
        }
        .edit-tbl tbody,
        .report-tbl tbody {
            display: table-row-group !important;
        }
        .edit-tbl tbody tr,
        .report-tbl tbody tr {
            display: table-row !important;
            padding: 0 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            transition: background 0.15s ease;
        }
        .edit-tbl tbody tr:hover,
        .report-tbl tbody tr:hover { background: #fafbff !important; }
        .edit-tbl tbody tr.row-absent { background: #fff8f8 !important; }

        .edit-tbl tbody td,
        .report-tbl tbody td {
            display: table-cell !important;
            padding: 6px 10px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 0.75rem !important;
            white-space: nowrap !important;
            text-align: center;
        }
        .edit-tbl tbody td::before,
        .report-tbl tbody td::before {
            display: none !important;
            content: none !important;
        }

        /* Student name column */
        .student-name-text {
            font-weight: 700;
            font-size: 0.75rem;
            color: #0f172a;
        }
        .edit-tbl .col-name,
        .report-tbl .col-name {
            min-width: 150px;
            white-space: normal !important;
            text-align: left !important;
        }

        /* Avatar chip */
        .tbl-avatar {
            width: 26px; height: 26px;
            border-radius: 6px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .tbl-id-badge {
            display: inline-flex; align-items: center;
            font-size: 0.6rem; font-weight: 600;
            padding: 2px 5px; border-radius: 4px;
            background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;
        }
        .tbl-roll-badge {
            display: inline-flex; align-items: center;
            font-size: 0.6rem; font-weight: 600;
            padding: 2px 5px; border-radius: 4px;
            background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
        }

        .mark-cell { font-weight: 600; color: #374151; }
        .grade-text { font-size: 0.65rem; color: #94a3b8; font-weight: 400; }
        .total-badge {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1d4ed8;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.72rem;
            border: 1px solid #bfdbfe;
        }
        .gpa-badge {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            color: #15803d;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.72rem;
            border: 1px solid #bbf7d0;
        }
        .merit-badge {
            background: linear-gradient(135deg, #fef9c3, #fef08a);
            color: #a16207;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            border: 1px solid #fde68a;
        }

        /* Mark Box */
        .smc-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .smc-mark-box {
            display: inline-flex;
            align-items: center;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.2s;
            height: 32px;
        }
        .smc-mark-box:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .mark-input {
            width: 40px;
            height: 100%;
            text-align: center;
            border: none;
            font-size: 0.8rem;
            font-weight: 700;
            color: #0f172a;
            background: transparent;
            outline: none;
            padding: 0 2px;
        }
        .save-icon-indicator {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            padding: 0 3px;
            height: 100%;
        }
        .smc-mark-denom {
            font-size: 0.65rem;
            font-weight: 600;
            color: #94a3b8;
            padding-right: 6px;
            padding-left: 4px;
            border-left: 1px solid #e2e8f0;
            height: 100%;
            display: inline-flex;
            align-items: center;
            background: #f8fafc;
            user-select: none;
            white-space: nowrap;
        }

        /* Grade Pill */
        .smc-grade-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }
        .grade-pill-lg {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }
        .grade-pill-lg.gp-ap { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
        .grade-pill-lg.gp-a  { background: #d1fae5; color: #047857; border-color: #a7f3d0; }
        .grade-pill-lg.gp-am { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
        .grade-pill-lg.gp-b  { background: #dbeafe; color: #1d4ed8; border-color: #bfdbfe; }
        .grade-pill-lg.gp-c  { background: #fef9c3; color: #a16207; border-color: #fef08a; }
        .grade-pill-lg.gp-d  { background: #ffedd5; color: #c2410c; border-color: #fed7aa; }
        .grade-pill-lg.gp-f  { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }

        /* ══════════════════════════════════════════════
           FULL REPORT TABLE: always scrollable
        ══════════════════════════════════════════════ */
        .desktop-report-table { display: block; width: 100%; }

        /* ══════════════════════════════════════════════
           EDITING MODE BADGE
        ══════════════════════════════════════════════ */
        .editing-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1d4ed8;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #bfdbfe;
        }

        .records-badge {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        /* ══════════════════════════════════════════════
           SECTION HEADER
        ══════════════════════════════════════════════ */
        .section-header-bar {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .section-header-bar .sec-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .autosave-note {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ══════════════════════════════════════════════
           EMPTY STATE
        ══════════════════════════════════════════════ */
        .empty-state-card {
            background: #fff;
            border: 1.5px solid #f1f5f9;
            border-radius: 18px;
            padding: 48px 24px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(15,23,42,0.05);
        }
        .empty-icon-wrap {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #fef9c3, #fde68a);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 16px;
            color: #d97706;
        }

        /* ══════════════════════════════════════════════
           DOWNLOAD & ACTION BUTTONS
        ══════════════════════════════════════════════ */
        .btn-download-csv {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #047857;
            border: 1.5px solid #a7f3d0;
            border-radius: 9px;
            height: 36px;
            padding: 0 13px;
            font-size: 0.80rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-download-csv:hover {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #064e3b;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(16,185,129,0.2);
        }

        .btn-download-pdf {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #b91c1c;
            border: 1.5px solid #fca5a5;
            border-radius: 9px;
            height: 36px;
            padding: 0 13px;
            font-size: 0.80rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-download-pdf:hover {
            background: linear-gradient(135deg, #fecaca, #f87171);
            color: #7f1d1d;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(239,68,68,0.25);
        }

        .btn-summary-all-pdf {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: #0369a1;
            border: 1.5px solid #7dd3fc;
            border-radius: 9px;
            height: 36px;
            padding: 0 13px;
            font-size: 0.80rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-summary-all-pdf:hover {
            background: linear-gradient(135deg, #bae6fd, #7dd3fc);
            color: #0c4a6e;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(14,165,233,0.25);
        }

        .btn-summary-class-pdf {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
            color: #6d28d9;
            border: 1.5px solid #c4b5fd;
            border-radius: 9px;
            height: 36px;
            padding: 0 13px;
            font-size: 0.80rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-summary-class-pdf:hover {
            background: linear-gradient(135deg, #ddd6fe, #c4b5fd);
            color: #4c1d95;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(124,58,237,0.25);
        }

        .btn-show-results {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff !important;
            border: none;
            border-radius: 9px;
            padding: 0 16px;
            height: 36px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
        }
        .btn-show-results:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(79,70,229,0.32);
        }

        /* ══════════════════════════════════════════════
           MARKSHEET DOWNLOAD ICON BUTTON
        ══════════════════════════════════════════════ */
        .btn-marksheet {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #4f46e5;
            border: 1px solid #bfdbfe;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-marksheet:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            border-color: transparent;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(79,70,229,0.25);
        }

        /* ══════════════════════════════════════════════
           DARK MODE SUPPORT
        ══════════════════════════════════════════════ */
        body.dark-mode .mark-filter-card,
        [data-bs-theme="dark"] .mark-filter-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        body.dark-mode .student-mark-card,
        [data-bs-theme="dark"] .student-mark-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        body.dark-mode .stat-card,
        [data-bs-theme="dark"] .stat-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        body.dark-mode .stat-card .num,
        [data-bs-theme="dark"] .stat-card .num { color: #f8fafc !important; }
        body.dark-mode .smc-name,
        [data-bs-theme="dark"] .smc-name,
        body.dark-mode .student-name-text,
        [data-bs-theme="dark"] .student-name-text { color: #f8fafc !important; }
        body.dark-mode .smc-mark-box,
        [data-bs-theme="dark"] .smc-mark-box {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        body.dark-mode .mark-input,
        [data-bs-theme="dark"] .mark-input { color: #f8fafc !important; }
        body.dark-mode .smc-mark-denom,
        [data-bs-theme="dark"] .smc-mark-denom {
            background: #060c18 !important;
            border-color: #1a253b !important;
        }
        body.dark-mode .edit-tbl thead th,
        body.dark-mode .report-tbl thead th,
        [data-bs-theme="dark"] .edit-tbl thead th,
        [data-bs-theme="dark"] .report-tbl thead th {
            background: linear-gradient(135deg, #0c1427, #1a253b) !important;
            color: #f8fafc !important;
        }
        body.dark-mode .edit-tbl tbody td,
        body.dark-mode .report-tbl tbody td,
        [data-bs-theme="dark"] .edit-tbl tbody td,
        [data-bs-theme="dark"] .report-tbl tbody td {
            border-color: #1a253b !important;
            color: #e2e8f0 !important;
        }
        body.dark-mode .edit-tbl tbody tr:hover,
        body.dark-mode .report-tbl tbody tr:hover,
        [data-bs-theme="dark"] .edit-tbl tbody tr:hover,
        [data-bs-theme="dark"] .report-tbl tbody tr:hover { background: #0a1020 !important; }
        body.dark-mode .tab-toggle,
        [data-bs-theme="dark"] .tab-toggle { background: #1a253b; }
        body.dark-mode .tab-btn.active,
        [data-bs-theme="dark"] .tab-btn.active {
            background: #0c1427;
            color: #a5b4fc;
        }
        body.dark-mode .tab-btn,
        [data-bs-theme="dark"] .tab-btn { color: #94a3b8; }
        body.dark-mode .mark-filter-card .form-select,
        body.dark-mode .mark-filter-card .form-control,
        [data-bs-theme="dark"] .mark-filter-card .form-select,
        [data-bs-theme="dark"] .mark-filter-card .form-control {
            background: #060c18 !important;
            border-color: #1a253b !important;
            color: #f8fafc !important;
        }
        body.dark-mode .section-header-bar .sec-title,
        [data-bs-theme="dark"] .section-header-bar .sec-title { color: #f8fafc !important; }
        body.dark-mode .empty-state-card,
        [data-bs-theme="dark"] .empty-state-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        body.dark-mode .records-badge,
        [data-bs-theme="dark"] .records-badge {
            background: #060c18 !important;
            color: #94a3b8 !important;
            border-color: #1a253b !important;
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE BREAKPOINTS
        ══════════════════════════════════════════════ */
        .st-text { display: inline; }

        /* ── Tablet (≤ 991px) ── */
        @media (max-width: 991.98px) {
            .mark-hero { padding: 22px 20px; }
            .mark-hero-title { font-size: 1.4rem; }
            .mark-filter-card { padding: 16px 18px; }
            /* Section header stacks vertically on tablet */
            .section-header-bar { flex-direction: column; align-items: flex-start !important; gap: 10px; }
            .pdf-actions-bar { width: 100%; flex-wrap: wrap; }
        }

        /* ── Mobile (≤ 767px) ── */
        @media (max-width: 767.98px) {
            .mark-hero { padding: 18px 16px; border-radius: 14px; margin-bottom: 16px; }
            .mark-hero-title { font-size: 1.2rem; }
            .mark-hero-subtitle { font-size: 0.8rem; }
            .mark-hero-badge { font-size: 0.72rem; margin-top: 8px; }
            .mark-filter-card { padding: 14px; border-radius: 14px; }
            .tab-toggle { width: 100%; }
            .tab-btn { font-size: 0.78rem; padding: 7px 10px; }

            .st-text { display: none; }
            .st-icon { margin-right: 0 !important; }

            /* Stats bar on mobile */
            .stat-card { min-width: 68px; padding: 10px 12px; }
            .stat-card .num { font-size: 1.1rem; }

            /* Section header */
            .section-header-bar { padding: 12px 14px; flex-direction: column; align-items: flex-start; }

            /* Edit table on small mobile: compact */
            .edit-tbl thead th { font-size: 0.62rem; padding: 9px 10px; }
            .edit-tbl tbody td { font-size: 0.8rem; padding: 8px 10px; }
            .tbl-avatar { width: 28px; height: 28px; font-size: 0.75rem; }

            /* Filter grid: 2 cols on small mobile */
            .filter-grid-row .col-md-2,
            .filter-grid-row .col-md-3 { width: 50%; }

            /* Buttons stay compact on mobile too */
            .btn-show-results { font-size: 0.8rem; padding: 0 12px; }

            /* PDF action buttons: 2-column grid on mobile */
            .pdf-actions-bar {
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                width: 100%;
                gap: 8px !important;
            }
            .pdf-actions-bar .btn-download-pdf,
            .pdf-actions-bar .btn-summary-all-pdf,
            .pdf-actions-bar .btn-summary-class-pdf,
            .pdf-actions-bar .btn-download-csv {
                width: 100%;
                justify-content: center;
                white-space: nowrap;
                font-size: 0.75rem;
                padding: 0 8px;
                height: 38px;
            }
            .pdf-actions-bar .badge {
                grid-column: 1 / -1;
                text-align: center;
                width: 100%;
            }
        }

        /* ── Very small (≤ 400px) ── */
        @media (max-width: 399.98px) {
            .mark-hero-title { font-size: 1.1rem; }
            .status-toggle .st-btn { padding: 0 7px; font-size: 0.7rem; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- ══ HERO BANNER ══ --}}
        <div class="mark-hero mb-4">
            <div class="mark-hero-content">
                <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="mark-hero-title">
                            <i class="fa-solid fa-list-check me-2"></i>Result Management Panel
                        </h1>
                        <p class="mark-hero-subtitle">View & analyze academic results by session, exam & class — select subject to edit marks</p>
                        @php
                            $activeYearId     = \App\Models\AcademicYear::where('school_id', auth()->user()->school_id)->where('is_active', 1)->value('id');
                            $isHistorical     = $selectedYearId && $selectedYearId != $activeYearId;
                            $selectedYearName = $academicYears->where('id', $selectedYearId)->first()?->name ?? 'N/A';
                            $selectedExamObj  = $examTypes->where('id', $selectedExamId)->first();
                            $selectedClassObj = $classes->where('id', $selectedClassId)->first();
                        @endphp
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <div class="mark-hero-badge">
                                <i class="fa-solid fa-calendar-days"></i>
                                {{ $selectedYearName }}
                                @if($isHistorical)
                                    <span style="margin-left:4px; background:rgba(251,191,36,0.25); padding:1px 6px; border-radius:6px; font-size:0.72rem;">Past Session</span>
                                @else
                                    <span style="margin-left:4px; background:rgba(52,211,153,0.25); padding:1px 6px; border-radius:6px; font-size:0.72rem;">Current</span>
                                @endif
                            </div>
                            @if($selectedExamObj)
                                <div class="mark-hero-badge" style="color:#fcd34d;">
                                    <i class="fa-solid fa-file-pen"></i> {{ $selectedExamObj->name }}
                                </div>
                            @endif
                            @if($selectedClassObj)
                                <div class="mark-hero-badge" style="color:#86efac;">
                                    <i class="fa-solid fa-chalkboard"></i> Class: {{ $selectedClassObj->name }}
                                </div>
                            @endif
                            <div class="mark-hero-badge">
                                <i class="fa-solid fa-bolt"></i> Auto-saves on input
                            </div>
                        </div>
                    </div>
                    @if($selectedSubjectId)
                        <div class="editing-badge">
                            <i class="fa-solid fa-pencil"></i>
                            Editing: {{ $selectedSubject?->name ?? 'Subject' }}
                            &nbsp;·&nbsp; Full Mark: <strong>{{ $fullMark }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        {{-- ══ TAB TOGGLE ══ --}}
        <div class="mb-3">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="tab-toggle">
                    <a href="{{ request()->fullUrlWithQuery(['subject_id' => '']) }}"
                       class="tab-btn {{ !$selectedSubjectId ? 'active' : '' }}">
                        <i class="fa-solid fa-table me-1"></i>
                        <span>Full Report</span>
                    </a>
                    <span class="tab-btn {{ $selectedSubjectId ? 'active' : '' }}" style="cursor:default;">
                        <i class="fa-solid fa-pencil me-1"></i>
                        <span>Edit Mode</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- ══ FILTER SECTION ══ --}}
        <div class="mark-filter-card mb-4">
            <form method="GET" action="{{ route('marks.view-marks', ['tenant' => auth()->user()->school->slug]) }}" id="filterForm">
                <div class="row align-items-end g-2 filter-grid-row">
                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="filter-label">
                            <i class="fa-solid fa-calendar-days me-1 text-indigo-500"></i>
                            Academic Year
                        </label>
                        <select name="academic_year_id" class="form-select">
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="filter-label">
                            <i class="fa-solid fa-chalkboard me-1"></i> Class
                        </label>
                        <select name="class_id" id="classSelect" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="filter-label">
                            <i class="fa-solid fa-file-pen me-1"></i> Exam
                        </label>
                        <select name="exam_id" class="form-select" required>
                            <option value="">Select Exam</option>
                            @foreach($examTypes as $exam)
                                <option value="{{ $exam->id }}" {{ $selectedExamId == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <label class="filter-label">
                            <i class="fa-solid fa-book-open me-1"></i>
                            Subject <small class="text-muted fw-normal" style="text-transform:none;letter-spacing:0">(optional)</small>
                        </label>
                        <select name="subject_id" id="subjectSelect" class="form-select">
                            <option value="">All Subjects (Full Report)</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <button type="submit" class="btn-show-results w-100">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Show Results
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ════════════════════════════════════════════════════ --}}
        {{-- MODE 1: SINGLE SUBJECT EDIT TABLE                    --}}
        {{-- ════════════════════════════════════════════════════ --}}
        @if($selectedSubjectId && $selectedClassId && $selectedExamId)

            @php
                $totalStudents = $students->count();
                $enteredCount  = $subjectMarks->count();
                $absentCount   = $subjectMarks->where('status', 'absent')->count();
                $avgMark       = $enteredCount > 0 ? round($subjectMarks->avg('marks'), 1) : 0;
                $pendingCount  = $totalStudents - $enteredCount;
            @endphp

            {{-- Stats Bar --}}
            <div class="stats-bar mb-3">
                <div class="stat-card">
                    <div class="num">{{ $totalStudents }}</div>
                    <div class="lbl">Total</div>
                </div>
                <div class="stat-card">
                    <div class="num text-success">{{ $enteredCount }}</div>
                    <div class="lbl">Entered</div>
                </div>
                <div class="stat-card">
                    <div class="num text-warning">{{ $pendingCount }}</div>
                    <div class="lbl">Pending</div>
                </div>
                <div class="stat-card">
                    <div class="num text-danger">{{ $absentCount }}</div>
                    <div class="lbl">Absent</div>
                </div>
                <div class="stat-card">
                    <div class="num" style="color:#6366f1;">{{ $avgMark }}</div>
                    <div class="lbl">Avg Mark</div>
                </div>
            </div>

            <div class="data-table-card">
                <div class="section-header-bar">
                    <h5 class="sec-title">
                        <i class="fa-solid fa-pencil" style="color:#6366f1;"></i>
                        {{ $selectedSubject?->name }} — Marks Entry &amp; Edit
                    </h5>
                    <div class="autosave-note">
                        <i class="fa-solid fa-cloud-arrow-up" style="color:#22c55e;"></i>
                        Auto-saves on change
                    </div>
                </div>

                {{-- Responsive Table --}}
                <div class="edit-table-wrap">
                    <table class="edit-tbl mb-0 text-center">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Roll</th>
                                <th>Student ID</th>
                                <th class="text-start">Student Name</th>
                                <th>Attendance</th>
                                <th>Mark <small class="opacity-60" style="font-weight:400;font-size:0.6rem;">(/ {{ $fullMark }})</small></th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($students as $i => $student)
                            @php
                                $markRecord = $subjectMarks->get($student->id);
                                $markValue  = $markRecord?->marks;
                                $status     = $markRecord?->status ?? 'present';
                                $grade      = null;
                                $gradeClass = '';
                                if ($markValue !== null && $fullMark > 0) {
                                    $pct = ($markValue / $fullMark) * 100;
                                    if      ($pct >= 80) { $grade = 'A+'; $gradeClass = 'gp-ap'; }
                                    elseif  ($pct >= 70) { $grade = 'A';  $gradeClass = 'gp-a';  }
                                    elseif  ($pct >= 60) { $grade = 'A-'; $gradeClass = 'gp-am'; }
                                    elseif  ($pct >= 50) { $grade = 'B';  $gradeClass = 'gp-b';  }
                                    elseif  ($pct >= 40) { $grade = 'C';  $gradeClass = 'gp-c';  }
                                    elseif  ($pct >= 33) { $grade = 'D';  $gradeClass = 'gp-d';  }
                                    else                 { $grade = 'F';  $gradeClass = 'gp-f';  }
                                }
                                $initials = strtoupper(substr($student->name, 0, 1));
                            @endphp
                            <tr id="row-{{ $student->id }}" data-student="{{ $student->id }}"
                                class="{{ $status === 'absent' ? 'row-absent' : '' }} align-middle">

                                {{-- # (Serial) --}}
                                <td class="text-muted fw-bold" style="font-size:0.7rem;">{{ $i + 1 }}</td>

                                {{-- Roll --}}
                                <td><span class="tbl-roll-badge"><i class="fa-solid fa-hashtag me-1"></i>{{ $student->roll }}</span></td>

                                {{-- Student ID --}}
                                <td><span class="tbl-id-badge"><i class="fa-solid fa-id-badge me-1"></i>{{ $student->student_id ?? 'N/A' }}</span></td>

                                {{-- Student Name + Avatar --}}
                                <td class="col-name text-start">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="tbl-avatar">{{ $initials }}</div>
                                        <span class="student-name-text">{{ strtoupper($student->name) }}</span>
                                    </div>
                                </td>

                                {{-- Attendance Toggle --}}
                                <td>
                                    <div class="status-toggle" data-student="{{ $student->id }}">
                                        <button type="button"
                                                class="st-btn {{ $status == 'present' ? 'active-present' : '' }}"
                                                data-value="present"
                                                data-student="{{ $student->id }}"
                                                onclick="setStatus({{ $student->id }}, 'present', this)">
                                            <i class="fa-solid fa-check me-1 st-icon"></i>
                                            <span class="st-text">Present</span>
                                        </button>
                                        <button type="button"
                                                class="st-btn {{ $status == 'absent' ? 'active-absent' : '' }}"
                                                data-value="absent"
                                                data-student="{{ $student->id }}"
                                                onclick="setStatus({{ $student->id }}, 'absent', this)">
                                            <i class="fa-solid fa-xmark me-1 st-icon"></i>
                                            <span class="st-text">Absent</span>
                                        </button>
                                    </div>
                                    <input type="hidden" class="status-hidden" id="status-{{ $student->id }}" value="{{ $status }}">
                                </td>

                                {{-- Mark Input --}}
                                <td>
                                    <div class="smc-mark-box">
                                        <input type="number"
                                               class="mark-input"
                                               id="mark-{{ $student->id }}"
                                               value="{{ $markValue }}"
                                               min="0" max="{{ $fullMark }}"
                                               placeholder="—"
                                               data-student="{{ $student->id }}"
                                               {{ $status == 'absent' ? 'disabled' : '' }}>
                                        <span class="save-icon-indicator" id="ind-{{ $student->id }}">
                                            @if($markValue !== null)
                                                <i class="fa-solid fa-check text-success" title="Saved"></i>
                                            @endif
                                        </span>
                                        <span class="smc-mark-denom">/ {{ $fullMark }}</span>
                                    </div>
                                </td>

                                {{-- Grade --}}
                                <td>
                                    <div class="grade-pill-lg {{ $gradeClass }}" id="grade-{{ $student->id }}">
                                        {{ $grade ?? '—' }}
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-users fa-2x mb-2 d-block"></i>
                                    No students found for this class.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- ════════════════════════════════════════════════════ --}}
        {{-- MODE 2: FULL REPORT (all subjects)                   --}}
        {{-- ════════════════════════════════════════════════════ --}}
        @elseif(isset($paginatedResults) && count($paginatedResults) > 0)

            @php
                // Summary stats for the full result sheet
                $allItems = $paginatedResults->getCollection() ?? collect();
                // We need all items from meritList for stats, build from marksData
                $passCount  = 0; $failCount = 0; $totalGpaSum = 0; $gpaCount = 0;
                foreach ($students as $st) {
                    $gpaStr = $marksData[$st->id]['GPA'] ?? null;
                    if ($gpaStr !== null) {
                        $isFailed = str_contains($gpaStr, 'F-');
                        if ($isFailed) $failCount++;
                        else { $passCount++; $totalGpaSum += (float)$gpaStr; $gpaCount++; }
                    }
                }
                $avgGpa   = $gpaCount > 0 ? number_format($totalGpaSum / $gpaCount, 2) : '0.00';
                $totalRec = $students->count();
                $passRate = $totalRec > 0 ? round(($passCount / $totalRec) * 100) : 0;
            @endphp

            {{-- Summary Stats Bar --}}
            <div class="stats-bar mb-3">
                <div class="stat-card">
                    <div class="num">{{ $totalRec }}</div>
                    <div class="lbl">Total</div>
                </div>
                <div class="stat-card">
                    <div class="num text-success">{{ $passCount }}</div>
                    <div class="lbl">Passed</div>
                </div>
                <div class="stat-card">
                    <div class="num text-danger">{{ $failCount }}</div>
                    <div class="lbl">Failed</div>
                </div>
                <div class="stat-card">
                    <div class="num" style="color:#6366f1;">{{ $passRate }}%</div>
                    <div class="lbl">Pass Rate</div>
                </div>
                <div class="stat-card">
                    <div class="num" style="color:#f59e0b;">{{ $avgGpa }}</div>
                    <div class="lbl">Avg GPA</div>
                </div>
            </div>

            <div class="data-table-card">
                <div class="section-header-bar d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="sec-title mb-0 d-flex align-items-center flex-wrap gap-2">
                        <span><i class="fa-solid fa-table me-1" style="color:#6366f1;"></i> Result Sheet</span>
                        @if($selectedExamObj ?? false)
                            <span class="badge" style="background:#eff6ff; color:#3b82f6; font-size:0.72rem; padding:4px 10px; border-radius:8px; font-weight:700;">{{ $selectedExamObj->name }}</span>
                        @endif
                        @if($isHistorical ?? false)
                            <span class="badge ms-1" style="background:#fef9c3; color:#a16207; font-size:0.7rem; padding:4px 9px; border-radius:8px; font-weight:700;">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i>{{ $selectedYearName }}
                            </span>
                        @endif
                    </h5>
                    <div class="d-flex align-items-center flex-wrap gap-2 pdf-actions-bar">
                        <a href="{{ route('marks.bulk-marksheet', ['tenant' => auth()->user()->school->slug, 'class' => $selectedClassId, 'exam' => $selectedExamId, 'academic_year_id' => $selectedYearId]) }}"
                           class="btn-download-pdf" title="Download All Marksheets in one PDF">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Marksheets</span>
                        </a>
                        <a href="{{ route('marks.result-summary', ['tenant' => auth()->user()->school->slug, 'exam_id' => $selectedExamId, 'academic_year_id' => $selectedYearId]) }}"
                           class="btn-summary-all-pdf" title="Download All Classes Result Summary in one PDF">
                            <i class="fa-solid fa-list-check"></i>
                            <span>All Summary</span>
                        </a>
                        <a href="{{ route('marks.result-summary', ['tenant' => auth()->user()->school->slug, 'exam_id' => $selectedExamId, 'class_id' => $selectedClassId, 'academic_year_id' => $selectedYearId]) }}"
                           class="btn-summary-class-pdf" title="Download This Class Result Summary in PDF">
                            <i class="fa-solid fa-file-lines"></i>
                            <span>Class Summary</span>
                        </a>
                        <a href="{{ route('marks.download-sheet', array_merge(['tenant' => auth()->user()->school->slug], request()->all())) }}"
                           class="btn-download-csv" title="Download CSV Result Sheet">
                            <i class="fa-solid fa-file-csv"></i>
                            <span>CSV</span>
                        </a>
                        <span class="badge records-badge py-2 px-3" style="font-size:0.75rem; border-radius:8px;">
                            {{ $paginatedResults->total() }} Records
                        </span>
                    </div>
                </div>

                {{-- ── FULL REPORT TABLE (RESPONSIVE) ── --}}
                <div class="report-table-wrap">
                    <table class="report-tbl mb-0 text-center">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Roll</th>
                                <th>Student ID</th>
                                <th class="text-start">Student Name</th>
                                @foreach($subjects as $subject)
                                    <th>{{ $subject->name }}<br><small class="opacity-50" style="font-size:0.6rem;">(M | G)</small></th>
                                @endforeach
                                <th>Total</th>
                                <th>GPA</th>
                                <th>Merit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedResults as $item)
                                @php
                                    $studentId = $item['student_id'];
                                    $student   = $students->where('id', $studentId)->first();
                                    $history   = DB::table('student_sessions')
                                                    ->where('student_id', $studentId)
                                                    ->where('academic_year_id', $selectedYearId)
                                                    ->first();
                                    $displayId = $history ? $history->old_student_id : ($student ? $student->student_id : 'N/A');
                                @endphp
                                @if($student)
                                <tr class="align-middle">
                                    <td class="text-muted fw-bold" style="font-size:0.7rem;">
                                        {{ $loop->iteration + ($paginatedResults->currentPage() - 1) * $paginatedResults->perPage() }}
                                    </td>
                                    <td><span class="tbl-roll-badge"><i class="fa-solid fa-hashtag me-1"></i>{{ $student->roll }}</span></td>
                                    <td><span class="tbl-id-badge"><i class="fa-solid fa-id-badge me-1"></i>{{ $displayId }}</span></td>
                                    <td class="col-name text-start">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="tbl-avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                                            <span class="student-name-text">{{ strtoupper($student->name) }}</span>
                                        </div>
                                    </td>
                                    @foreach($subjects as $subject)
                                        @php
                                            $m = $marksData[$student->id][$subject->id]['marks'] ?? null;
                                            $g = $marksData[$student->id][$subject->id]['grade'] ?? '-';
                                        @endphp
                                        <td class="mark-cell">
                                            @if($m !== null)
                                                {{ $m }} <span class="grade-text">| {{ $g }}</span>
                                            @else
                                                <span class="text-danger" style="font-size:0.7rem;">N/A</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td><span class="total-badge">{{ $item['total_marks'] }}</span></td>
                                    <td><span class="gpa-badge">{{ $marksData[$student->id]['GPA'] ?? '0.00' }}</span></td>
                                    <td><span class="merit-badge">{{ $meritPosition[$student->id] ?? '-' }}</span></td>
                                    <td>
                                        <a href="{{ route('marks.marksheet', ['tenant' => auth()->user()->school->slug, 'student' => $student->id, 'class' => $selectedClassId, 'exam' => $selectedExamId, 'year' => $selectedYearId]) }}"
                                           class="btn-marksheet" title="Download Marksheet">
                                            <i class="fa-solid fa-file-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile cards removed — table is responsive via overflow-x --}}
            </div>

            {{-- Pagination --}}
            <div class="mt-4">{{ $paginatedResults->links() }}</div>

        @elseif($selectedClassId && $selectedExamId)
            <div class="empty-state-card">
                <div class="empty-icon-wrap">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <h5 class="fw-700" style="color:#1e293b; margin-bottom:8px;">No Marks Found</h5>
                <p class="text-muted" style="font-size:0.9rem; margin:0;">
                    No marks found for the selected criteria. Please try a different filter.
                </p>
            </div>
        @endif

    </div>
</div>
@endsection

@section('customJs')
<script>
const AUTOSAVE_URL = "{{ route('marks.autosave', ['tenant' => auth()->user()->school->slug]) }}";
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
const CLASS_ID   = '{{ $selectedClassId }}';
const EXAM_ID    = '{{ $selectedExamId }}';
const SUBJECT_ID = '{{ $selectedSubjectId }}';
const YEAR_ID    = '{{ $selectedYearId }}';
const FULL_MARK  = {{ $fullMark ?? 0 }};

let saveTimers = {};

// ── Auto save on mark input change ──
document.querySelectorAll('.mark-input').forEach(input => {
    input.addEventListener('input', function () {
        const sid = this.dataset.student;
        clearTimeout(saveTimers[sid]);
        setIndicator(sid, 'saving');
        this.classList.add('saving');
        saveTimers[sid] = setTimeout(() => doSave(sid), 800);
    });
    input.addEventListener('blur', function () {
        const sid = this.dataset.student;
        clearTimeout(saveTimers[sid]);
        doSave(sid);
    });
});

// ── Status toggle button handler ──
function setStatus(sid, value, clickedBtn) {
    const markInput   = document.getElementById('mark-' + sid);
    const hiddenInput = document.getElementById('status-' + sid);
    const container   = clickedBtn.closest('.status-toggle');
    const card        = document.getElementById('row-' + sid);

    hiddenInput.value = value;

    container.querySelectorAll('.st-btn').forEach(btn => {
        btn.classList.remove('active-present', 'active-absent');
    });
    clickedBtn.classList.add(value === 'absent' ? 'active-absent' : 'active-present');

    if (value === 'absent') {
        markInput.value    = 0;
        markInput.disabled = true;
        card?.classList.add('card-absent');
    } else {
        markInput.disabled = false;
        card?.classList.remove('card-absent');
    }

    doSave(sid);
}

function doSave(sid) {
    const input  = document.getElementById('mark-' + sid);
    const status = document.getElementById('status-' + sid)?.value ?? 'present';
    const marks  = input?.value ?? '';

    if (marks === '' && status === 'present') {
        setIndicator(sid, '');
        input.classList.remove('saving','saved','error');
        return;
    }

    const val = parseFloat(marks);
    if (!isNaN(val) && FULL_MARK > 0 && val > FULL_MARK) {
        input.value = FULL_MARK;
    }

    setIndicator(sid, 'saving');
    input?.classList.remove('saved','error');
    input?.classList.add('saving');

    fetch(AUTOSAVE_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({
            student_id:       sid,
            class_id:         CLASS_ID,
            exam_id:          EXAM_ID,
            subject_id:       SUBJECT_ID,
            academic_year_id: YEAR_ID,
            marks:            marks,
            status:           status,
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.status) {
            setIndicator(sid, 'saved');
            input?.classList.remove('saving','error');
            input?.classList.add('saved');
            updateGrade(sid, parseFloat(marks));
        } else {
            setIndicator(sid, 'error');
            input?.classList.remove('saving','saved');
            input?.classList.add('error');
        }
    })
    .catch(() => {
        setIndicator(sid, 'error');
        input?.classList.remove('saving','saved');
        input?.classList.add('error');
    });
}

function setIndicator(sid, type) {
    const el = document.getElementById('ind-' + sid);
    if (!el) return;
    if (type === 'saving') {
        el.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-warning" title="Saving..."></i>`;
    } else if (type === 'saved') {
        el.innerHTML = `<i class="fa-solid fa-check text-success" title="Saved"></i>`;
    } else if (type === 'error') {
        el.innerHTML = `<i class="fa-solid fa-circle-exclamation text-danger" title="Error"></i>`;
    } else {
        el.innerHTML = '';
    }
}

function updateGrade(sid, marks) {
    if (FULL_MARK <= 0 || isNaN(marks)) return;
    const pct = (marks / FULL_MARK) * 100;
    let grade = 'F', cls = 'gp-f';
    if      (pct >= 80) { grade = 'A+'; cls = 'gp-ap'; }
    else if (pct >= 70) { grade = 'A';  cls = 'gp-a';  }
    else if (pct >= 60) { grade = 'A-'; cls = 'gp-am'; }
    else if (pct >= 50) { grade = 'B';  cls = 'gp-b';  }
    else if (pct >= 40) { grade = 'C';  cls = 'gp-c';  }
    else if (pct >= 33) { grade = 'D';  cls = 'gp-d';  }
    const cell = document.getElementById('grade-' + sid);
    if (cell) {
        cell.className = `grade-pill-lg ${cls}`;
        cell.textContent = grade;
    }
}

// ── Load subjects when class changes ──
document.getElementById('classSelect')?.addEventListener('change', function () {
    const classId    = this.value;
    const subjectSel = document.getElementById('subjectSelect');
    if (!classId || !subjectSel) return;
    subjectSel.innerHTML = '<option value="">Loading...</option>';

    fetch("{{ route('marks.findSubject', ['tenant' => auth()->user()->school->slug]) }}", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ class_id: classId })
    })
    .then(r => r.json())
    .then(data => {
        subjectSel.innerHTML = '<option value="">All Subjects (Full Report)</option>';
        data.subjects.forEach(s => {
            subjectSel.innerHTML += `<option value="${s.id}">${s.name}</option>`;
        });
    })
    .catch(() => {
        subjectSel.innerHTML = '<option value="">Error loading subjects</option>';
    });
});
</script>
@endsection