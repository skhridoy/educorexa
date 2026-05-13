{{-- =====================================================
     School Others Modern Design Shared Styles
     ===================================================== --}} 
<style>
/* Font Import */
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

:root {
    --primary-gradient: linear-gradient(135deg, #4f46e5, #7c3aed);
    --navy-gradient: linear-gradient(135deg, #1e293b, #334155);
    --gold-accent: #D4AF37;
    --card-shadow: 0px 10px 30px rgba(15,23,42,0.08);
    --page-bg: #f8fafc;
    --card-bg-light: #ffffff;
    --text-main-light: #1e293b;
    --text-muted-light: #64748b;
    --card-bg: #ffffff; 
}

/* Fix: Prevent sticky elements from overlapping sidebar */
.sticky-top {
    z-index: 10 !important;
}


body {
    background-color: var(--page-bg) !important;
    color: var(--text-main-light);
    font-family: 'Outfit', sans-serif;
}

[data-bs-theme="dark"] body, body.dark-mode {
    --page-bg: #060c18;
    --card-bg: #0c1427;
    --text-main-light: #f8fafc;
    --text-muted-light: #cbd5e1;
}

/* Page Header */
.page-header-card {
    background: var(--navy-gradient);
    color: white;
    border-radius: 20px;
    padding: 32px;
    margin-bottom: 32px;
    box-shadow: 0 15px 35px rgba(15,23,42,0.12);
    position: relative;
    overflow: hidden;
}
.page-header-card::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 150px;
    height: 150px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}
.page-header-content { position: relative; z-index: 1; }
.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
    font-family: 'Outfit', sans-serif;
}
@media (max-width: 768px) {
    .page-title { font-size: 1.5rem; }
    .page-header-card h2 { font-size: 1.25rem !important; }
}
.page-subtitle { font-size: 0.95rem; opacity: 0.85; }

/* Filter & Search Section */
.filter-section, .search-container, .search-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 32px;
    box-shadow: var(--card-shadow);
}
.filter-label, .form-label {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    display: block;
}

/* Form Elements */
.form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 12px 16px;
    background-color: #f8fafc;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}
.form-control:focus, .form-select:focus {
    background-color: #fff;
    border-color: #4f46e5;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
}

/* Cards */
.form-card, .data-table-card, .activity-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 24px;
    box-shadow: var(--card-shadow);
    margin-bottom: 24px;
}
.data-table-card { padding: 0; overflow: hidden; }

/* Table Styles */
.table-header {
    padding: 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.table-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.data-table thead th {
    background: #1e293b;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 14px 16px;
    border: none;
}
.data-table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f8fafc;
    color: #475569;
}
.data-table tbody tr:hover { background: rgba(0,0,0,0.02); }

/* Buttons & Badges */
.btn-primary-gradient {
    background: var(--primary-gradient);
    border: none;
    color: white !important;
    font-weight: 700;
    border-radius: 10px;
    padding: 12px 24px;
    transition: all 0.3s ease;
}
.btn-primary-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
}
.btn-action {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.badge-primary { background: #dbeafe; color: #1e40af; }
.badge-success { background: #dcfce7; color: #16a34a; }
.badge-warning { background: #fef3c7; color: #d97706; }
.badge-danger { background: #fee2e2; color: #dc2626; }
.bg-soft-primary { background-color: rgba(79, 70, 229, 0.1) !important; }
.bg-soft-success { background-color: rgba(16, 185, 129, 0.1) !important; }

/* Dashboard Badges */
.badge-edu {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.badge-present { background: #dcfce7; color: #16a34a; border: 1px solid #bcf0da; }
.badge-absent { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
[data-bs-theme="dark"] .badge-present, body.dark-mode .badge-present { background: rgba(22, 163, 74, 0.1); color: #4ade80; border-color: rgba(74, 222, 128, 0.2); }
[data-bs-theme="dark"] .badge-absent, body.dark-mode .badge-absent { background: rgba(220, 38, 38, 0.1); color: #f87171; border-color: rgba(248, 113, 113, 0.2); }

/* Student Profile Classes */
.student-profile-header {
    background: linear-gradient(135deg, #002147 0%, #003366 100%);
    border-radius: 16px 16px 0 0;
    padding: 30px 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.student-img-wrapper {
    width: 110px; height: 110px;
    margin: 0 auto 15px;
    position: relative;
}
.student-img {
    width: 100%; height: 100%;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.2);
    object-fit: cover;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
.student-id-badge {
    background: rgba(212, 175, 55, 0.2);
    color: #D4AF37;
    border: 1px solid rgba(212, 175, 55, 0.3);
    font-weight: 700; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem;
}
.info-list-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 12px 0; border-bottom: 1px solid #f1f5f9;
}
.info-label { color: #64748b; font-size: 0.85rem; font-weight: 500; }
.info-value { color: #1e293b; font-weight: 700; }

/* Result Badges */
.mark-cell { font-size: 0.9rem; font-weight: 600; }
.grade-text { font-size: 0.75rem; color: #94a3b8; font-weight: 400; }
.total-badge { background: #f1f5f9; color: #1e293b; font-weight: 700; padding: 4px 10px; border-radius: 6px; }
.gpa-badge { background: #eef2ff; color: #4f46e5; font-weight: 700; padding: 4px 10px; border-radius: 6px; }
.merit-badge { background: #dcfce7; color: #16a34a; font-weight: 800; padding: 4px 12px; border-radius: 20px; border: 1px solid #bdf2d5; }

/* Settings Helpers */
.img-preview-box {
    background: #f1f5f9; border-radius: 12px; padding: 10px;
    display: inline-block; border: 2px dashed #cbd5e1;
}
.section-divider { height: 1px; background: #f1f5f9; margin: 24px 0; }

/* Dashboard Stat Cards */
.edu-stat-card {
    background: var(--card-bg-light);
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 20px;
    box-shadow: var(--card-shadow);
    transition: all 0.3s ease;
    color: var(--text-main-light);
    height: 100%;
}
[data-bs-theme="dark"] .edu-stat-card, body.dark-mode .edu-stat-card {
    background: #0c1427 !important;
    border-color: #1a253b !important;
    color: #ffffff !important;
}
.edu-stat-card:hover { border-color: #4f46e5; transform: translateY(-5px); }
.edu-stat-card .icon-wrap {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
    transition: transform 0.2s ease;
}
.edu-stat-card .stat-badge {
    font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 20px;
}
.edu-stat-card .stat-label {
    font-size: 10px; letter-spacing: 0.08em; text-transform: uppercase;
    font-weight: 700; color: #64748b; margin-bottom: 4px;
}
.edu-stat-card .stat-value {
    font-size: 1.75rem; font-weight: 700; color: inherit; line-height: 1;
}
@media (max-width: 576px) {
    .edu-stat-card { padding: 15px; }
    .edu-stat-card .stat-value { font-size: 1.4rem; }
    .edu-stat-card .icon-wrap { width: 36px; height: 36px; font-size: 1rem; }
}

/* Attendance Summary Table (Edu Table) */
.schools-panel {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    margin-bottom: 24px;
}
.panel-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    background: #fff;
}
.panel-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

/* White Panel Override */
.schools-panel.white-panel {
    background: #ffffff !important;
    border-color: #f1f5f9 !important;
    box-shadow: var(--card-shadow) !important;
}
.schools-panel.white-panel .panel-header {
    background: #ffffff !important;
    border-color: #f1f5f9 !important;
}
.schools-panel.white-panel .panel-title {
    color: #1e293b !important;
}

.edu-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.edu-table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 16px 24px;
    border-bottom: 1px solid #f1f5f9;
}
.edu-table tbody td {
    padding: 16px 24px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
}
.edu-table tbody tr:last-child td { border-bottom: none; }
.edu-table tbody tr:hover td { background: var(--bg-color); opacity: 0.9; }

/* Table Item Styles */
.item-name { font-weight: 700; color: inherit; font-size: 0.9rem; }
.item-date { font-size: 0.75rem; color: var(--text-muted); }
.stat-index { font-weight: 800; color: var(--text-muted); font-size: 0.8rem; }
.teacher-name { font-weight: 600; color: inherit; font-size: 0.85rem; }
.time-stamp { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; }
.item-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: rgba(79, 70, 229, 0.1); color: #4f46e5;
    display: flex; align-items: center; justify-content: center; font-size: 0.8rem;
}

/* Attendance Chart Card */
.attendance-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px;
    color: #1e293b;
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
    border: 1px solid #f1f5f9;
}
.attendance-card::before {
    content: '';
    position: absolute;
    bottom: -50px;
    left: -50px;
    width: 150px;
    height: 150px;
    background: rgba(79, 70, 229, 0.02);
    border-radius: 50%;
}
.bar-chart {
    height: 160px;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 8px;
    margin-top: 20px;
}
.bar {
    flex: 1;
    background: rgba(99, 102, 241, 0.15); /* Light mode visible faint color */
    border-radius: 6px 6px 0 0;
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 4px;
}
.bar.active {
    background: var(--primary-gradient);
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
}
.bar:hover {
    background: rgba(99, 102, 241, 0.3); /* Light mode hover */
}
.bar.active:hover {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
}

/* Dark Mode Overrides for Bars */
[data-bs-theme="dark"] .bar,
body.dark-mode .bar {
    background: rgba(255, 255, 255, 0.1);
}
[data-bs-theme="dark"] .bar:hover:not(.active),
body.dark-mode .bar:hover:not(.active) {
    background: rgba(255, 255, 255, 0.25);
}

.completed-item { padding: 15px; border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease; }
.completed-item:last-child { border-bottom: none; }
.completed-item:hover { background: #f8fafc; }

/* Activity Feed Styles */
.activity-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 32px;
    box-shadow: var(--card-shadow);
}
.activity-item {
    display: flex;
    gap: 16px;
    position: relative;
    padding-bottom: 24px;
}
.activity-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 40px;
    bottom: 0;
    width: 2px;
    background: #f1f5f9;
}
.activity-avatar {
    position: relative;
    flex-shrink: 0;
    width: 42px;
    height: 42px;
}
.avatar-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    z-index: 1;
    position: relative;
}
.activity-badge {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}
[data-bs-theme="dark"] .activity-badge { border-color: var(--card-bg); }

/* Quick Actions Card */
.quick-actions-card {
    background: var(--card-bg);
    border-radius: 20px; padding: 32px; color: var(--text-main-light);
    min-height: 100%;
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
    border: 1px solid #f1f5f9;
}
.quick-actions-card::before {
    content: '';
    position: absolute;
    top: -20px;
    right: -20px;
    width: 100px;
    height: 100px;
    background: rgba(79, 70, 229, 0.03);
    border-radius: 50%;
}
.quick-action-btn {
    width: 100%; display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px; background: #f8fafc;
    border: 1px solid #e2e8f0; border-radius: 14px;
    color: #475569; font-weight: 600; font-size: 0.9rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
    text-decoration: none; margin-bottom: 12px;
}
.quick-action-btn:hover { 
    background: #f1f5f9; 
    color: #1e293b; 
    transform: translateX(5px);
    border-color: #cbd5e1;
}
.quick-action-btn i { font-size: 1.1rem; color: #4f46e5; }
.quick-action-btn .arrow { opacity: 0.4; transition: all 0.3s ease; color: #94a3b8; }
.quick-action-btn:hover .arrow { opacity: 1; transform: translateX(4px); color: #4f46e5; }

/* Welcome Hero Card */
.welcome-card {
    border-radius: 24px;
    background: var(--card-bg);
    color: var(--text-main-light);
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
    border: 1px solid #f1f5f9;
}
.welcome-card::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(79, 70, 229, 0.03);
    border-radius: 50%;
}
.greet-icon-box {
    width: 50px;
    height: 50px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

/* Force White Mode for Specific Cards */
html .white-panel, html body.dark-mode .white-panel, html [data-bs-theme="dark"] .white-panel {
    background-color: #ffffff !important;
    background-image: none !important;
    border-color: #f1f5f9 !important;
    box-shadow: var(--card-shadow) !important;
}

html .white-panel .panel-title, html .white-panel table, html .white-panel table td, html .white-panel table th {
    color: #1e293b !important;
}

.welcome-card .badge {
    color: #1e293b;
    background: rgba(0,0,0,0.05);
    border-color: rgba(0,0,0,0.1);
}


/* Attendance Report Calendar & Profile Styles */
.calendar-card {
    background: var(--card-bg, #fff);
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--border-color, #e2e8f0);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    height: 100%;
    transition: transform 0.2s ease;
}
.calendar-card:hover { transform: translateY(-3px); }

.month-header-modern {
    background: #1e293b;
    color: #fff;
    padding: 12px;
    text-align: center;
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.calendar-table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 2px;
}
.calendar-table-modern th {
    text-align: center;
    font-size: 0.65rem;
    font-weight: 800;
    color: #94a3b8;
    padding: 8px 0;
    text-transform: uppercase;
}
.calendar-table-modern td {
    height: 35px;
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: #475569;
    vertical-align: middle;
    border-radius: 8px;
    position: relative;
}

.day-present {
    background: #dcfce7;
    color: #16a34a !important;
    border: 1px solid #bcf0da;
}
.day-absent {
    background: #fee2e2;
    color: #dc2626 !important;
    border: 1px solid #fecaca;
}
.day-off {
    background: #f1f5f9;
    color: #94a3b8 !important;
    font-weight: 400;
}
.off-label {
    font-size: 6px;
    position: absolute;
    top: 2px;
    left: 0;
    right: 0;
    color: #ef4444;
    font-weight: 800;
    text-transform: uppercase;
}

/* Profile Sidebar Premium */
.profile-header-premium {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 30px 20px;
    text-align: center;
    border-radius: 16px 16px 0 0;
}
.profile-img-premium {
    width: 110px;
    height: 110px;
    border: 4px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    padding: 3px;
    background: #fff;
    object-fit: cover;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);
}

.stat-card-mini {
    background: var(--input-bg, #f8fafc);
    border: 1px solid var(--border-color, #e2e8f0);
    border-radius: 12px;
    padding: 15px;
    text-align: center;
}

/* Responsive Overrides */
@media (max-width: 768px) {
    .page-header-card { padding: 20px; }
    .page-title { font-size: 1.5rem; }
    .data-table thead { display: none; }
    .data-table tbody tr { display: block; padding: 15px; border-bottom: 8px solid #f8fafc; }
    .data-table tbody td {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 0; border: none; text-align: right;
    }
    .data-table tbody td::before {
        content: attr(data-label); font-weight: 700;
        text-transform: uppercase; color: #94a3b8; font-size: 0.7rem;
    }
}

/* =====================================================
   DARK MODE SUPPORT
   ===================================================== */
[data-bs-theme="dark"], 
body.dark-mode, 
body.theme-dark,
.dark-wrapper {
    --card-bg: #0c1427;
    --input-bg: #060c18;
    --border-color: #1a253b;
    --text-main: #f8fafc;
    --text-muted: #94a3b8;
    --page-bg: #060c18;
}

[data-bs-theme="dark"] body, body.dark-mode {
    background-color: var(--page-bg) !important;
}

[data-bs-theme="dark"] .page-header-card,
body.dark-mode .page-header-card { 
    background: linear-gradient(135deg, #0f172a, #1e293b); 
    border: 1px solid var(--border-color); 
}

[data-bs-theme="dark"] .filter-section, 
[data-bs-theme="dark"] .search-container, 
[data-bs-theme="dark"] .search-card,
[data-bs-theme="dark"] .form-card, 
[data-bs-theme="dark"] .data-table-card,
[data-bs-theme="dark"] .edu-stat-card,
[data-bs-theme="dark"] .activity-card,
[data-bs-theme="dark"] .schools-panel,
[data-bs-theme="dark"] .attendance-card,
[data-bs-theme="dark"] .welcome-card,
[data-bs-theme="dark"] .quick-actions-card,
body.dark-mode .filter-section, 
body.dark-mode .search-container, 
body.dark-mode .search-card,
body.dark-mode .form-card, 
body.dark-mode .data-table-card,
body.dark-mode .edu-stat-card,
body.dark-mode .activity-card,
body.dark-mode .schools-panel,
body.dark-mode .attendance-card,
body.dark-mode .welcome-card,
body.dark-mode .quick-actions-card {
    background: var(--card-bg) !important;
    border-color: var(--border-color) !important;
    color: var(--text-main) !important;
}

[data-bs-theme="dark"] .bg-white,
body.dark-mode .bg-white {
    background-color: var(--card-bg) !important;
}

[data-bs-theme="dark"] .text-indigo,
body.dark-mode .text-indigo {
    color: #818cf8 !important;
}

[data-bs-theme="dark"] .text-dark,
body.dark-mode .text-dark {
    color: var(--text-main) !important;
}

[data-bs-theme="dark"] .bg-light,
body.dark-mode .bg-light {
    background-color: rgba(255,255,255,0.05) !important;
}

/* Table Dark Mode */
[data-bs-theme="dark"] .table,
body.dark-mode .table,
[data-bs-theme="dark"] .data-table,
body.dark-mode .data-table,
[data-bs-theme="dark"] .edu-table,
body.dark-mode .edu-table {
    color: var(--text-main) !important;
    background-color: var(--card-bg) !important;
    --bs-table-bg: var(--card-bg) !important;
    --bs-table-color: var(--text-main) !important;
}

[data-bs-theme="dark"] .table thead th,
body.dark-mode .table thead th,
[data-bs-theme="dark"] .data-table thead th,
body.dark-mode .data-table thead th,
[data-bs-theme="dark"] .edu-table thead th,
body.dark-mode .edu-table thead th {
    background-color: #0f172a !important; 
    color: var(--text-main) !important;
    border-color: var(--border-color) !important;
}

[data-bs-theme="dark"] .table tbody td,
body.dark-mode .table tbody td,
[data-bs-theme="dark"] .data-table tbody td,
body.dark-mode .data-table tbody td,
[data-bs-theme="dark"] .edu-table tbody td,
body.dark-mode .edu-table tbody td {
    background-color: var(--card-bg) !important;
    color: var(--text-main) !important;
    border-color: var(--border-color) !important;
}

[data-bs-theme="dark"] .table tbody tr:hover td,
body.dark-mode .table tbody tr:hover td,
[data-bs-theme="dark"] .edu-table tbody tr:hover td,
body.dark-mode .edu-table tbody tr:hover td {
    background-color: #1e293b !important;
    color: #ffffff !important;
}

/* Form Elements Dark Mode */
[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select,
[data-bs-theme="dark"] .input-group-text,
body.dark-mode .form-control,
body.dark-mode .form-select,
body.dark-mode .input-group-text {
    background-color: var(--input-bg) !important;
    border-color: var(--border-color) !important;
    color: var(--text-main) !important;
}

[data-bs-theme="dark"] .form-select,
body.dark-mode .form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23f8fafc' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
}

/* Modal Dark Mode */
[data-bs-theme="dark"] .modal-content,
body.dark-mode .modal-content {
    background-color: var(--card-bg) !important;
    border: 1px solid var(--border-color) !important;
    color: var(--text-main) !important;
}

[data-bs-theme="dark"] .modal-header,
body.dark-mode .modal-header {
    border-bottom: 1px solid var(--border-color) !important;
}

[data-bs-theme="dark"] .modal-footer,
body.dark-mode .modal-footer {
    border-top: 1px solid var(--border-color) !important;
}

/* Pagination Dark Mode */
[data-bs-theme="dark"] .pagination .page-link,
body.dark-mode .pagination .page-link {
    background-color: var(--card-bg) !important;
    border-color: var(--border-color) !important;
    color: var(--text-main) !important;
}

[data-bs-theme="dark"] .pagination .page-item.active .page-link,
body.dark-mode .pagination .page-item.active .page-link {
    background-color: #4f46e5 !important;
    border-color: #4f46e5 !important;
}

/* Panels & Headers */
[data-bs-theme="dark"] .panel-header,
body.dark-mode .panel-header {
    background: transparent !important;
    border-color: var(--border-color) !important;
}

[data-bs-theme="dark"] .panel-title,
body.dark-mode .panel-title {
    color: #ffffff !important;
}

/* Welcome & Quick Actions */
[data-bs-theme="dark"] .welcome-card .greet-icon-box,
body.dark-mode .welcome-card .greet-icon-box,
[data-bs-theme="dark"] .quick-action-btn,
body.dark-mode .quick-action-btn {
    background: rgba(255, 255, 255, 0.05) !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
    color: var(--text-main) !important;
}

[data-bs-theme="dark"] .quick-action-btn:hover,
body.dark-mode .quick-action-btn:hover {
    background: rgba(255, 255, 255, 0.1) !important;
}

[data-bs-theme="dark"] .edu-stat-card .stat-value,
body.dark-mode .edu-stat-card .stat-value {
    color: #ffffff !important;
}

/* Vibrant Action Buttons */
.btn-action-view {
    background: #4f46e5;
    color: white !important;
    border: none;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
}
.btn-action-view:hover {
    background: #4338ca;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
}

.btn-action-edit {
    background: #f59e0b;
    color: white !important;
    border: none;
    box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);
}
.btn-action-edit:hover {
    background: #d97706;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(245, 158, 11, 0.3);
}

.btn-action-delete {
    background: #ef4444;
    color: white !important;
    border: none;
    box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);
}
.btn-action-delete:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3);
}

.btn-icon-custom {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.3s ease;
}

[data-bs-theme="dark"] .btn-action-view,
body.dark-mode .btn-action-view {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}
[data-bs-theme="dark"] .btn-action-edit,
body.dark-mode .btn-action-edit {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}
[data-bs-theme="dark"] .btn-action-delete,
body.dark-mode .btn-action-delete {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

</style>
