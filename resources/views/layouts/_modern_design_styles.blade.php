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
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0px 4px 20px rgba(15,23,42,0.05);
}
.form-card .form-label {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    font-size: 0.9rem;
}
.form-card .form-control,
.form-card .form-select {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 12px 16px;
}
.form-card .form-control:focus,
.form-card .form-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
}

/* Data Table */
.data-table-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    box-shadow: 0px 4px 20px rgba(15,23,42,0.05);
    overflow: hidden;
}
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
.data-table { margin-bottom: 0; }
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
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover { background: #fafbff; }

/* Button & Badge Helpers */
.btn-action {
    padding: 6px 12px;
    font-size: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s ease;
}
.btn-action:hover { transform: translateY(-2px); }
.btn-primary-gradient {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border: none;
    color: white !important;
    font-weight: 600;
    border-radius: 10px;
    padding: 12px 24px;
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
    .data-table thead { display: none; }
    .data-table tbody tr { display: block; padding: 15px; border-bottom: 8px solid #f8fafc; }
    .data-table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border: none;
        text-align: right;
    }
    .data-table tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        text-align: left;
    }
    .row { flex-direction: column-reverse; }
}
</style>
