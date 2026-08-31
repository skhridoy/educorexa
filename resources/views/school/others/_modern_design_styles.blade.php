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

/* ══════════════════════════════════════════════
   EduCorexa Sidebar & Brand Header Styling
   ══════════════════════════════════════════════ */
.edu-sidebar {
    width: 260px;
    background: #ffffff;
    border-right: 1px solid #f1f5f9;
    box-shadow: 4px 0 24px rgba(15, 23, 42, 0.04);
    display: flex;
    flex-direction: column;
    z-index: 100;
    transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

[data-bs-theme="dark"] .edu-sidebar,
body.dark-mode .edu-sidebar {
    background: #0c1427 !important;
    border-color: #1a253b !important;
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.2) !important;
}

.edu-sidebar-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 16px 20px !important;
    height: 70px !important;
    border-bottom: 1px solid #f1f5f9 !important;
    background: #ffffff;
    flex-shrink: 0;
    transition: padding 0.25s ease;
}

[data-bs-theme="dark"] .edu-sidebar-header,
body.dark-mode .edu-sidebar-header {
    background: #0c1427 !important;
    border-color: #1a253b !important;
}

.edu-brand {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    text-decoration: none !important;
    min-width: 0;
    flex: 1;
}

.edu-brand-logo {
    width: 38px !important;
    height: 38px !important;
    border-radius: 10px !important;
    object-fit: cover !important;
    flex-shrink: 0 !important;
    border: 1px solid rgba(79, 70, 229, 0.12) !important;
    box-shadow: 0 3px 10px rgba(79, 70, 229, 0.12) !important;
    background: #ffffff;
}

.edu-brand-icon {
    width: 38px !important;
    height: 38px !important;
    border-radius: 10px !important;
    background: linear-gradient(135deg, #4f46e5, #818cf8) !important;
    color: #ffffff !important;
    font-weight: 800 !important;
    font-size: 1.1rem !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25) !important;
}

.edu-brand-text {
    display: flex;
    flex-direction: column;
    min-width: 0;
    overflow: hidden;
}

.edu-brand-name {
    font-family: 'Outfit', sans-serif !important;
    font-weight: 700 !important;
    font-size: 0.95rem !important;
    color: #1e293b !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    line-height: 1.25 !important;
}

[data-bs-theme="dark"] .edu-brand-name,
body.dark-mode .edu-brand-name {
    color: #f8fafc !important;
}

.edu-brand-sub {
    font-size: 0.65rem !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.06em !important;
    color: #6366f1 !important;
    line-height: 1.2 !important;
}

.edu-sidebar-body {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 6px 0 10px !important;
}

.edu-sidebar-footer {
    margin-top: 10px !important;
    margin-bottom: 10px !important;
}

/* ══════════════════════════════════════════════
   FOLDED SIDEBAR STATE (Desktop Collapsed)
   When sidebar is folded/closed, hide text & footer banner
══════════════════════════════════════════════ */
@media (min-width: 992px) {
    body.sidebar-folded:not(.open-sidebar-folded) .edu-sidebar {
        width: 70px !important;
    }

    body.sidebar-folded:not(.open-sidebar-folded) .page-wrapper {
        margin-left: 70px !important;
    }

    body.sidebar-folded:not(.open-sidebar-folded) .edu-brand-text,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-brand-name,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-brand-sub,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-nav-category,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-nav-link span,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-arrow,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-mobile-close,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-sidebar-footer,
    body.sidebar-folded:not(.open-sidebar-folded) .sidebar-folded-hide,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-sidebar .collapse,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-sidebar .collapse.show,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-sidebar .edu-sub-nav,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-sidebar .edu-sub-item,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-sidebar .edu-sub-link {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        overflow: hidden !important;
    }

    body.sidebar-folded:not(.open-sidebar-folded) .edu-sidebar-header {
        padding: 14px 0 !important;
        justify-content: center !important;
    }

    body.sidebar-folded:not(.open-sidebar-folded) .edu-brand {
        justify-content: center !important;
        margin: 0 auto !important;
        flex: 0 0 auto !important;
    }

    body.sidebar-folded:not(.open-sidebar-folded) .edu-brand-logo,
    body.sidebar-folded:not(.open-sidebar-folded) .edu-brand-icon {
        margin: 0 auto !important;
    }

    body.sidebar-folded:not(.open-sidebar-folded) .edu-nav-link {
        justify-content: center !important;
        padding: 10px 0 !important;
        margin: 4px 8px !important;
    }

    /* Hover expanded state */
    body.sidebar-folded.open-sidebar-folded .edu-sidebar {
        width: 260px !important;
        box-shadow: 10px 0 30px rgba(15, 23, 42, 0.15) !important;
    }
    body.sidebar-folded.open-sidebar-folded .edu-sidebar-header {
        padding: 16px 20px !important;
        justify-content: space-between !important;
    }
    body.sidebar-folded.open-sidebar-folded .edu-brand {
        justify-content: flex-start !important;
        margin: 0 !important;
    }
    body.sidebar-folded.open-sidebar-folded .edu-brand-logo,
    body.sidebar-folded.open-sidebar-folded .edu-brand-icon {
        margin: 0 !important;
    }
    body.sidebar-folded.open-sidebar-folded .edu-brand-text {
        display: flex !important;
    }
    body.sidebar-folded.open-sidebar-folded .edu-nav-category,
    body.sidebar-folded.open-sidebar-folded .edu-nav-link span,
    body.sidebar-folded.open-sidebar-folded .edu-sidebar-footer,
    body.sidebar-folded.open-sidebar-folded .sidebar-folded-hide {
        display: block !important;
    }
    body.sidebar-folded.open-sidebar-folded .edu-arrow {
        display: inline-block !important;
        margin-left: auto !important;
    }
    body.sidebar-folded.open-sidebar-folded .edu-nav-link {
        justify-content: flex-start !important;
        padding: 9px 14px !important;
        margin: 1px 8px !important;
    }
}

@media (max-width: 991px) {
    .edu-sidebar-header {
        padding: 15px 18px !important;
    }
    .edu-sidebar-header .edu-mobile-close {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
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
    .page-title { font-size: 1.15rem !important; margin-bottom: 4px !important; }
    .page-subtitle { font-size: 0.78rem !important; }
    .page-header-card { padding: 18px 20px !important; margin-bottom: 20px !important; }
    .page-header-card h2 { font-size: 1.1rem !important; }
    .form-card, .data-table-card { padding: 16px !important; }
}
.page-subtitle { font-size: 0.95rem; opacity: 0.85; }

/* Filter & Search Section */
.filter-section, .search-container, .search-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
}
.filter-label, .form-label {
    font-weight: 700 !important;
    color: #475569 !important;
    font-size: 0.72rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    margin-bottom: 6px !important;
    display: inline-block;
}
[data-bs-theme="dark"] .filter-label,
[data-bs-theme="dark"] .form-label,
body.dark-mode .filter-label,
body.dark-mode .form-label {
    color: #94a3b8 !important;
}

/* Clean Form Inputs & Selects */
.form-control, .form-select {
    border-radius: 5px !important;
    border: 1px solid #cbd5e1 !important;
    padding: 6px 12px !important;
    background-color: #ffffff !important;
    transition: all 0.2s ease !important;
    font-size: 0.82rem !important;
    height: 38px !important;
    color: #1e293b;
}
textarea.form-control {
    height: auto !important;
    min-height: 75px !important;
}
.form-control:focus, .form-select:focus {
    background-color: #ffffff !important;
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
    outline: none !important;
}
[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select,
body.dark-mode .form-control,
body.dark-mode .form-select {
    background-color: #09101f !important;
    border-color: #1a253b !important;
    color: #f8fafc !important;
}
[data-bs-theme="dark"] .form-control:focus,
[data-bs-theme="dark"] .form-select:focus,
body.dark-mode .form-control:focus,
body.dark-mode .form-select:focus {
    border-color: #6366f1 !important;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2) !important;
}

/* Search Input Wrapper */
.search-input-wrapper {
    display: flex;
    align-items: center;
    border: 1px solid #cbd5e1;
    border-radius: 5px;
    background-color: #ffffff !important;
    height: 38px;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}
.search-input-wrapper:focus-within {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
}
.search-input-wrapper .input-group-text {
    border: none !important;
    background: transparent !important;
    padding: 0 8px 0 12px !important;
    box-shadow: none !important;
    outline: none !important;
    color: #64748b !important;
}
.search-input-wrapper .form-control {
    border: none !important;
    background: transparent !important;
    background-color: transparent !important;
    box-shadow: none !important;
    outline: none !important;
    height: 100% !important;
    font-size: 0.82rem !important;
    padding-left: 0 !important;
    color: #1e293b !important;
}
.search-input-wrapper .form-control:focus {
    box-shadow: none !important;
    outline: none !important;
    border: none !important;
    background: transparent !important;
    background-color: transparent !important;
}

[data-bs-theme="dark"] .search-input-wrapper,
body.dark-mode .search-input-wrapper {
    background-color: #09101f !important;
    border-color: #1a253b !important;
}
[data-bs-theme="dark"] .search-input-wrapper:focus-within,
body.dark-mode .search-input-wrapper:focus-within {
    border-color: #6366f1 !important;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2) !important;
}
[data-bs-theme="dark"] .search-input-wrapper .input-group-text,
body.dark-mode .search-input-wrapper .input-group-text {
    background: transparent !important;
    background-color: transparent !important;
    color: #94a3b8 !important;
}
[data-bs-theme="dark"] .search-input-wrapper .form-control,
body.dark-mode .search-input-wrapper .form-control {
    background: transparent !important;
    background-color: transparent !important;
    color: #f8fafc !important;
}


/* Cards (Form, Table, Activity) */
.form-card, .data-table-card, .activity-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    margin-bottom: 20px;
}
.data-table-card { padding: 0; overflow: hidden; }
[data-bs-theme="dark"] .form-card,
[data-bs-theme="dark"] .data-table-card,
[data-bs-theme="dark"] .activity-card,
[data-bs-theme="dark"] .search-card,
body.dark-mode .form-card,
body.dark-mode .data-table-card,
body.dark-mode .activity-card,
body.dark-mode .search-card {
    background: #0c1427 !important;
    border-color: #1a253b !important;
}

/* Clean Modals Design System (View, Create, Edit) */
.modal-content {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12) !important;
    overflow: hidden;
}
.modal-header {
    padding: 14px 18px !important;
    border-bottom: 1px solid #f1f5f9 !important;
    background: #fafbfc;
}
.modal-title {
    font-size: 0.95rem !important;
    font-weight: 700 !important;
    color: #1e293b;
}
.modal-body {
    padding: 18px !important;
    font-size: 0.82rem !important;
}
.modal-footer {
    padding: 12px 18px !important;
    border-top: 1px solid #f1f5f9 !important;
    background: #fafbfc;
}
[data-bs-theme="dark"] .modal-content,
body.dark-mode .modal-content {
    background: #0c1427 !important;
    border-color: #1a253b !important;
}
[data-bs-theme="dark"] .modal-header,
[data-bs-theme="dark"] .modal-footer,
body.dark-mode .modal-header,
body.dark-mode .modal-footer {
    background: #101a33 !important;
    border-color: #1a253b !important;
}
[data-bs-theme="dark"] .modal-title,
body.dark-mode .modal-title {
    color: #f8fafc !important;
}

/* Table Styles */
.table-header {
    padding: 14px 18px;
    border-bottom: 1px solid #eef2f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafbfc;
}
.table-title {
    font-size: 0.92rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.data-table thead th, .table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 14px;
    border-bottom: 1px solid #e2e8f0;
}
.data-table tbody td, .table tbody td {
    padding: 9px 14px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
    font-size: 0.78rem;
}
.data-table tbody tr:hover, .table tbody tr:hover { background: #fafbfc; }

/* ══════════════════════════════════════════════
   GLOBAL: All tables stay as horizontal scroll on mobile
   No card/block collapse - rows & columns always preserved
══════════════════════════════════════════════ */
.table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
}
.table-responsive .table,
.table-responsive table {
    display: table !important;
    min-width: 580px;
    width: 100%;
}
.table-responsive .table thead,
.table-responsive .table tbody,
.table-responsive .table tr,
.table-responsive .table th,
.table-responsive .table td {
    display: revert !important;
}
@media (max-width: 767.98px) {
    .table-responsive .table,
    .table-responsive table {
        min-width: 580px !important;
        display: table !important;
    }
    .table-responsive .table thead tr,
    .table-responsive .table tbody tr { display: table-row !important; }
    .table-responsive .table th,
    .table-responsive .table td { display: table-cell !important; }
    /* Unpaid list table */
    .unpaid-table { min-width: 620px !important; display: table !important; }
}

/* Clean Universal Action & Form Buttons */
.btn-primary-gradient, .btn-primary-modern, .btn-primary, .btn-submit {
    background: transparent !important;
    border: 1.5px solid #4f46e5 !important;
    color: #4f46e5 !important;
    font-weight: 600 !important;
    border-radius: 5px !important;
    padding: 6px 14px !important;
    font-size: 0.78rem !important;
    transition: all 0.2s ease !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    box-shadow: none !important;
}
.btn-primary-gradient:hover, .btn-primary-modern:hover, .btn-primary:hover, .btn-submit:hover {
    background: rgba(79, 70, 229, 0.08) !important;
    color: #4338ca !important;
    border-color: #4338ca !important;
    transform: none !important;
    box-shadow: none !important;
}

.btn-outline-secondary, .btn-secondary, .btn-cancel {
    background: transparent !important;
    border: 1.5px solid #94a3b8 !important;
    color: #64748b !important;
    font-weight: 600 !important;
    border-radius: 5px !important;
    padding: 6px 14px !important;
    font-size: 0.78rem !important;
    transition: all 0.2s ease !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    box-shadow: none !important;
}
.btn-outline-secondary:hover, .btn-secondary:hover, .btn-cancel:hover {
    background: rgba(148, 163, 184, 0.08) !important;
    color: #475569 !important;
    border-color: #64748b !important;
    transform: none !important;
    box-shadow: none !important;
}

.btn-success, .btn-outline-success {
    background: transparent !important;
    border: 1.5px solid #10b981 !important;
    color: #10b981 !important;
    font-weight: 600 !important;
    border-radius: 5px !important;
    padding: 6px 14px !important;
    font-size: 0.78rem !important;
    transition: all 0.2s ease !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    box-shadow: none !important;
}
.btn-success:hover, .btn-outline-success:hover {
    background: rgba(16, 185, 129, 0.08) !important;
    color: #059669 !important;
    border-color: #059669 !important;
    box-shadow: none !important;
}

.btn-danger, .btn-outline-danger {
    background: transparent !important;
    border: 1.5px solid #ef4444 !important;
    color: #ef4444 !important;
    font-weight: 600 !important;
    border-radius: 5px !important;
    padding: 6px 14px !important;
    font-size: 0.78rem !important;
    transition: all 0.2s ease !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    box-shadow: none !important;
}
.btn-danger:hover, .btn-outline-danger:hover {
    background: rgba(239, 68, 68, 0.08) !important;
    color: #dc2626 !important;
    border-color: #dc2626 !important;
    box-shadow: none !important;
}

.btn-warning, .btn-outline-warning {
    background: transparent !important;
    border: 1.5px solid #f59e0b !important;
    color: #d97706 !important;
    font-weight: 600 !important;
    border-radius: 5px !important;
    padding: 6px 14px !important;
    font-size: 0.78rem !important;
    transition: all 0.2s ease !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    box-shadow: none !important;
}
.btn-warning:hover, .btn-outline-warning:hover {
    background: rgba(245, 158, 11, 0.08) !important;
    color: #b45309 !important;
    border-color: #d97706 !important;
    box-shadow: none !important;
}

.btn-icon, .btn-icon-custom, .btn-action, .btn-icon-sm {
    border-radius: 5px !important;
    width: 30px !important;
    height: 30px !important;
    padding: 0 !important;
    font-size: 0.76rem !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.2s ease !important;
    background: transparent !important;
    border: 1.5px solid transparent !important;
    cursor: pointer;
    text-decoration: none !important;
}

/* Soft Border-Only Button Variants (Transparent background with 5px radius) */
.btn-soft-primary, .btn-icon-sm.btn-soft-primary {
    border-color: rgba(79, 70, 229, 0.35) !important;
    color: #4f46e5 !important;
    background: transparent !important;
}
.btn-soft-primary:hover, .btn-icon-sm.btn-soft-primary:hover {
    background: rgba(79, 70, 229, 0.08) !important;
    border-color: #4f46e5 !important;
    color: #4338ca !important;
}

.btn-soft-success, .btn-icon-sm.btn-soft-success, .btn-collect-outline {
    border-color: #10b981 !important;
    color: #10b981 !important;
    background: transparent !important;
    border: 1.5px solid #10b981 !important;
    font-weight: 600 !important;
    border-radius: 5px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.2s ease !important;
    text-decoration: none !important;
}
.btn-soft-success:hover, .btn-icon-sm.btn-soft-success:hover, .btn-collect-outline:hover {
    background: rgba(16, 185, 129, 0.08) !important;
    border-color: #059669 !important;
    color: #059669 !important;
}

.btn-soft-warning, .btn-icon-sm.btn-soft-warning {
    border-color: rgba(217, 119, 6, 0.35) !important;
    color: #d97706 !important;
    background: transparent !important;
}
.btn-soft-warning:hover, .btn-icon-sm.btn-soft-warning:hover {
    background: rgba(245, 158, 11, 0.08) !important;
    border-color: #d97706 !important;
    color: #b45309 !important;
}

.btn-soft-danger, .btn-icon-sm.btn-soft-danger {
    border-color: rgba(239, 68, 68, 0.35) !important;
    color: #ef4444 !important;
    background: transparent !important;
}
.btn-soft-danger:hover, .btn-icon-sm.btn-soft-danger:hover {
    background: rgba(239, 68, 68, 0.08) !important;
    border-color: #ef4444 !important;
    color: #dc2626 !important;
}

.btn-soft-secondary, .btn-icon-sm.btn-soft-secondary, .btn-reminder-outline {
    border-color: #cbd5e1 !important;
    color: #64748b !important;
    background: transparent !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 5px !important;
}
.btn-soft-secondary:hover, .btn-icon-sm.btn-soft-secondary:hover, .btn-reminder-outline:hover {
    background: rgba(100, 116, 139, 0.08) !important;
    border-color: #94a3b8 !important;
    color: #475569 !important;
}

/* Header Action Buttons */
.header-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}
.btn-header-outline {
    background: transparent !important;
    color: #ffffff !important;
    border: 1.5px solid rgba(255, 255, 255, 0.45) !important;
    font-weight: 600 !important;
    font-size: 0.78rem !important;
    height: 32px !important;
    padding: 0 12px !important;
    border-radius: 5px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    transition: all 0.2s ease !important;
    text-decoration: none !important;
    box-shadow: none !important;
    cursor: pointer;
}
.btn-header-outline:hover {
    background: rgba(255, 255, 255, 0.12) !important;
    border-color: #ffffff !important;
    color: #ffffff !important;
    box-shadow: none !important;
    transform: none !important;
}
.btn-header-solid {
    background: transparent !important;
    color: #ffffff !important;
    border: 1.5px solid #818cf8 !important;
    font-weight: 600 !important;
    font-size: 0.78rem !important;
    height: 32px !important;
    padding: 0 12px !important;
    border-radius: 5px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    transition: all 0.2s ease !important;
    box-shadow: none !important;
    text-decoration: none !important;
}
.btn-header-solid:hover {
    background: rgba(129, 140, 248, 0.18) !important;
    border-color: #a5b4fc !important;
    color: #ffffff !important;
    box-shadow: none !important;
    transform: none !important;
}


.btn-upgrade-premium {
    background-color: #ffcc00 !important;
    color: #1f2937 !important;
    border: none !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 14px;
    font-weight: 800 !important;
    letter-spacing: 1px;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
}
.btn-upgrade-premium:hover {
    background-color: #ffdb4d !important;
    color: #000000 !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 204, 0, 0.4) !important;
}
.edu-upgrade-card .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4) !important;
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
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px 18px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    transition: all 0.2s ease;
    color: #1e293b;
    height: 100%;
}
[data-bs-theme="dark"] .edu-stat-card, body.dark-mode .edu-stat-card {
    background: #0c1427 !important;
    border-color: #1a253b !important;
    color: #ffffff !important;
}
.edu-stat-card:hover { border-color: #4f46e5; transform: translateY(-2px); }
.edu-stat-card .icon-wrap {
    width: 38px; height: 38px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    transition: transform 0.2s ease;
}
.edu-stat-card .stat-badge {
    font-size: 0.65rem; font-weight: 700; padding: 2px 8px; border-radius: 20px;
}
.edu-stat-card .stat-label {
    font-size: 0.70rem; letter-spacing: 0.5px; text-transform: uppercase;
    font-weight: 700; color: #64748b; margin-bottom: 4px;
}
[data-bs-theme="dark"] .edu-stat-card .stat-label, body.dark-mode .edu-stat-card .stat-label {
    color: #94a3b8;
}
.edu-stat-card .stat-value {
    font-size: 1.35rem; font-weight: 800; color: inherit; line-height: 1;
}
@media (max-width: 576px) {
    .edu-stat-card { padding: 12px 14px; }
    .edu-stat-card .stat-value { font-size: 1.15rem; }
    .edu-stat-card .icon-wrap { width: 32px; height: 32px; font-size: 0.88rem; }
}

/* Quick Actions Card & Buttons */
.quick-actions-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    height: 100%;
}
[data-bs-theme="dark"] .quick-actions-card, body.dark-mode .quick-actions-card {
    background: #0c1427 !important;
    border-color: #1a253b !important;
}
.quick-action-btn {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 9px 12px;
    font-size: 0.78rem;
    font-weight: 600;
    background: #ffffff;
    color: #1e293b;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
}
.quick-action-btn:hover {
    border-color: #4f46e5;
    background: rgba(79, 70, 229, 0.04);
    color: #4f46e5;
    transform: none;
}
[data-bs-theme="dark"] .quick-action-btn, body.dark-mode .quick-action-btn {
    background: #09101f !important;
    border-color: #1a253b !important;
    color: #f8fafc !important;
}
[data-bs-theme="dark"] .quick-action-btn:hover, body.dark-mode .quick-action-btn:hover {
    border-color: #6366f1 !important;
    background: rgba(99, 102, 241, 0.1) !important;
    color: #818cf8 !important;
}

/* Schools Panel & Panels */
.schools-panel {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    overflow: hidden;
    margin-bottom: 20px;
}
[data-bs-theme="dark"] .schools-panel, body.dark-mode .schools-panel {
    background: #0c1427 !important;
    border-color: #1a253b !important;
}
.panel-header {
    padding: 12px 18px;
    border-bottom: 1px solid #f1f5f9;
    background: #fafbfc;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
[data-bs-theme="dark"] .panel-header, body.dark-mode .panel-header {
    background: #101a33 !important;
    border-color: #1a253b !important;
}
.panel-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
[data-bs-theme="dark"] .panel-title, body.dark-mode .panel-title {
    color: #f8fafc !important;
}

/* White Panel Override */
.schools-panel.white-panel {
    background: #ffffff !important;
    border-color: #e2e8f0 !important;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03) !important;
}
.schools-panel.white-panel .panel-header {
    background: #fafbfc !important;
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

/* Welcome Hero Card (Professional Banner matching reference) */
.welcome-card {
    border-radius: 12px !important;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 20px rgba(79, 70, 229, 0.25) !important;
    position: relative;
    overflow: hidden;
    border: none !important;
    padding: 20px 24px !important;
}
.welcome-user-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid rgba(255, 255, 255, 0.85);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
    flex-shrink: 0;
}
.welcome-card-title {
    font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff !important;
    margin-bottom: 2px;
    line-height: 1.25;
}
.welcome-card-subtitle {
    font-size: 0.82rem;
    color: rgba(255, 255, 255, 0.85) !important;
    margin: 0;
    font-weight: 400;
}
.btn-welcome-action {
    background: #ffffff !important;
    color: #1e293b !important;
    font-weight: 700 !important;
    font-size: 0.82rem !important;
    border-radius: 6px !important;
    padding: 8px 18px !important;
    border: none !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12) !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    transition: all 0.2s ease !important;
    white-space: nowrap !important;
}
.btn-welcome-action:hover {
    background: #f8fafc !important;
    color: #4f46e5 !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18) !important;
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
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            overflow-x: auto;
        }
        
        /* Mobile Button Adjustments */
        .btn-primary-gradient, .btn-primary-modern, .btn-action {
            padding: 5px 12px !important;
            font-size: 0.76rem !important;
        }

        
        .header-actions .btn {
            width: 100%;
            margin-top: 10px;
        }
        
        .modern-form .p-4.bg-light {
            padding: 1.5rem !important;
        }
        
        .modern-form .d-flex.align-items-center.justify-content-between {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        
        .modern-form .d-flex.gap-3 {
            width: 100%;
            flex-direction: column !important;
            gap: 10px !important;
        }
        
        .modern-form .d-flex.gap-3 .btn {
            width: 100% !important;
        }
        
        /* Stats Card Mobile Fix */
        .stats-card {
            margin-bottom: 15px !important;
        }
        .stats-icon {
            width: 40px !important;
            height: 40px !important;
            font-size: 1rem !important;
        }
        .stats-card h4 {
            font-size: 1.25rem !important;
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

    /* Premium Glassmorphism */
    .glass-card {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
    }
    [data-bs-theme="dark"] .glass-card, body.dark-mode .glass-card {
        background: rgba(15, 23, 42, 0.6) !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }

    /* Stats Cards */
    .stats-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .stats-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Modern Table Rows */
    .table-row-hover {
        transition: all 0.2s ease;
    }
    .table-row-hover:hover {
        background-color: rgba(79, 70, 229, 0.02) !important;
        transform: scale(1.002);
    }
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4f46e5, #818cf8);
    }

    /* Modern Badges */
    .badge-modern {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    /* Action Buttons */
    .btn-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
        background: white;
    }
    .edit-btn { color: #f59e0b; }
    .edit-btn:hover { background: #fef3c7; border-color: #f59e0b; color: #d97706; }
    .delete-btn { color: #ef4444; }
    .delete-btn:hover { background: #fee2e2; border-color: #ef4444; color: #dc2626; }

    [data-bs-theme="dark"] .btn-action, body.dark-mode .btn-action {
        background: #1e293b;
        border-color: #334155;
    }

    /* Profile Upload Styling */
    .profile-preview-container {
        width: 130px;
        height: 130px;
        position: relative;
    }
    .profile-preview {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
    }
    .upload-btn-floating {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 38px;
        height: 38px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid white;
        transition: all 0.3s ease;
        z-index: 5;
    }
    .upload-btn-floating:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
    }
    [data-bs-theme="dark"] .upload-btn-floating {
        border-color: var(--card-bg);
    }

    /* Modern Input Groups */
    .input-group-custom {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }
    .input-group-custom:focus-within {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
    }
    .input-icon {
        min-width: 46px;
        justify-content: center;
    }
    [data-bs-theme="dark"] .input-group-custom {
        border-color: #334155;
    }

</style>
