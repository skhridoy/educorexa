{{-- =====================================================
     Modern Design Shared Styles
     ===================================================== --}}
<style>

/* =====================================================
   SCHOOL SIDEBAR — Arrow & active state CSS
   (Bootstrap .collapse is handled natively)
   ===================================================== */

/* Arrow rotates when menu is open */
.edu-sidebar a.edu-has-submenu[aria-expanded="true"] .edu-arrow {
    transform: rotate(180deg) !important;
}
.edu-sidebar .edu-has-submenu .edu-arrow {
    transition: transform 0.22s ease !important;
}

/* Active parent highlight when open */
.edu-sidebar a.edu-has-submenu[aria-expanded="true"] {
    color: #4f46e5 !important;
    background: #eef2ff !important;
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

/* Page Header */
.page-header-card {
    background: linear-gradient(135deg, #1e293b, #334155);
    color: white;
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 32px;
    box-shadow: 0 10px 30px rgba(15,23,42,0.15);
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
.page-subtitle { font-size: 0.95rem; opacity: 0.85; }

/* Search Card */
.search-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0px 4px 20px rgba(15,23,42,0.05);
}
.search-card .form-control,
.search-card .form-select {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 12px 16px;
    font-size: 0.9rem;
}
.search-card .form-control:focus,
.search-card .form-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
}

/* Form Card */
.form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(15,23,42,0.03);
}
.form-card .form-label, .form-label, .filter-label {
    font-weight: 700 !important;
    color: #475569 !important;
    margin-bottom: 6px !important;
    font-size: 0.72rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    display: inline-block;
}
.form-card .form-control,
.form-card .form-select,
.form-control,
.form-select {
    border-radius: 5px !important;
    border: 1px solid #cbd5e1 !important;
    padding: 6px 12px !important;
    font-size: 0.82rem !important;
    height: 38px !important;
    background-color: #ffffff !important;
    transition: all 0.2s ease !important;
}
textarea.form-control {
    height: auto !important;
    min-height: 75px !important;
}
.form-card .form-control:focus,
.form-card .form-select:focus,
.form-control:focus,
.form-select:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79,70,229,0.1) !important;
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

/* Modals */
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

/* Data Table */
.data-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(15,23,42,0.03);
    overflow: hidden;
}
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
.data-table { margin-bottom: 0; }
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
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover { background: #fafbfc; }

/* GLOBAL: All .table-responsive tables scroll horizontally on mobile */
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
@media (max-width: 767.98px) {
    .table-responsive .table,
    .table-responsive table { min-width: 580px !important; display: table !important; }
    .table-responsive .table thead tr,
    .table-responsive .table tbody tr { display: table-row !important; }
    .table-responsive .table th,
    .table-responsive .table td { display: table-cell !important; }
}

/* Button & Badge Helpers */
.btn-action {
    padding: 4px 8px;
    font-size: 0.75rem;
    border-radius: 5px;
    font-weight: 600;
    transition: all 0.2s ease;
}
.btn-action:hover { transform: translateY(-1px); }
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


.teacher-image {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}
.badge-primary { background: #dbeafe; color: #1e40af; font-weight: 600; }
.badge-success { background: #dcfce7; color: #16a34a; font-weight: 600; }
.badge-warning { background: #fef3c7; color: #d97706; font-weight: 600; }
.badge-danger { background: #fee2e2; color: #dc2626; font-weight: 600; }

/* Pagination */
.pagination { justify-content: center; gap: 8px; }
.pagination .page-link {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
    margin: 0;
    min-width: 40px;
    text-align: center;
    transition: all 0.2s ease;
    color: #475569;
    font-weight: 600;
}
.pagination .page-link:hover {
    background: #4f46e5;
    color: #fff;
    border-color: #4f46e5;
}
.pagination .page-item.active .page-link {
    background: #4f46e5;
    border-color: #4f46e5;
    color: #fff;
}
.pagination .page-link:focus { box-shadow: none; }

/* Empty state */
.empty-state {
    text-align: center;
    padding: 40px 20px;
}
.empty-state i {
    font-size: 3rem;
    color: #e2e8f0;
    margin-bottom: 16px;
}

/* Dashboard cards */
.edu-stat-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0px 4px 20px rgba(15,23,42,0.05);
    transition: border-color 0.2s ease, transform 0.2s ease;
}
.edu-stat-card:hover { border-color: #c7d2fe; transform: translateY(-2px); }
.edu-stat-card .icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: transform 0.2s ease;
}
.edu-stat-card:hover .icon-wrap { transform: scale(1.1); }
.edu-stat-card .stat-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 20px;
}
.edu-stat-card .stat-label {
    font-size: 10px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 4px;
}
.edu-stat-card .stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}
.edu-stat-card .icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: transform 0.2s ease;
}
.edu-stat-card:hover .icon-wrap { transform: scale(1.1); }
.edu-stat-card .stat-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 20px;
}
.edu-stat-card .stat-label {
    font-size: 10px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 4px;
}
@media (max-width: 576px) {
    .edu-stat-card { padding: 16px; }
    .edu-stat-card .stat-value { font-size: 1.4rem; }
    .edu-stat-card .icon-wrap { width: 38px; height: 38px; font-size: 1rem; }
}

.quick-actions-card {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 16px;
    padding: 32px;
    color: #ffffff;
    min-height: 100%;
}
.quick-action-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.875rem;
    transition: background 0.2s ease;
    text-decoration: none;
    margin-bottom: 10px;
}
.quick-action-btn:hover { background: rgba(255,255,255,0.2); color: #ffffff; }
.quick-action-btn i { font-size: 1rem; opacity: 0.7; }
.quick-action-btn .arrow {
    opacity: 0;
    transition: opacity 0.2s, transform 0.2s;
}
.quick-action-btn:hover .arrow { opacity: 1; transform: translateX(4px); }

.activity-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0px 4px 20px rgba(15,23,42,0.05);
}
.activity-item { display: flex; gap: 16px; }
.activity-avatar { position: relative; flex-shrink: 0; }
.activity-avatar img,
.activity-avatar .avatar-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}
.activity-avatar .avatar-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fef3c7;
    color: #d97706;
    font-size: 1rem;
}
.activity-badge {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
}
.item-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.9rem;
}
.item-date {
    font-size: 0.75rem;
    color: #94a3b8;
}
.item-icon {
    width: 36px;
    height: 36px;
    background: #eef2ff;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4f46e5;
    font-size: 0.9rem;
    flex-shrink: 0;
}
.badge-active {
    background: #dcfce7;
    color: #16a34a;
    font-weight: 700;
    font-size: 0.7rem;
    padding: 4px 10px;
    border-radius: 20px;
}
.badge-inactive {
    background: #f1f5f9;
    color: #64748b;
    font-weight: 700;
    font-size: 0.7rem;
    padding: 4px 10px;
    border-radius: 20px;
}

.attendance-card {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
    border-radius: 16px;
    padding: 24px;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.attendance-card::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(99,102,241,0.2);
    filter: blur(40px);
}
.bar-chart {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 80px;
    position: relative;
    z-index: 1;
}
.bar {
    flex: 1;
    border-radius: 4px 4px 0 0;
    background: rgba(255,255,255,0.15);
    transition: background 0.2s;
}
.bar.active { background: #6366f1; box-shadow: 0 0 15px rgba(99,102,241,0.5); }
.bar:hover { background: rgba(255,255,255,0.3); }

.schools-panel {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0px 4px 20px rgba(15,23,42,0.05);
}
.panel-header {
    padding: 24px 28px;
    border-bottom: 1px solid #f8fafc;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.panel-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.edu-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.edu-table thead th {
    background: #1e293b;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 14px 16px;
    border: none;
}
.edu-table thead th:first-child { border-radius: 8px 0 0 8px; }
.edu-table thead th:last-child { border-radius: 0 8px 8px 0; }
.edu-table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f8fafc;
    color: #475569;
}
.edu-table tbody tr:last-child td { border-bottom: none; }
.edu-table tbody tr:hover td { background: #fafbff; }

/* Responsive */
@media (max-width: 768px) {
    .page-header-card { padding: 20px; }
    .page-title { font-size: 1.5rem; }
    .table-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    .table-responsive {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto;
    }
    .row { flex-direction: column-reverse; }
}
</style>
