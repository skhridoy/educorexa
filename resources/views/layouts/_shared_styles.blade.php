{{-- =====================================================
     EduCorexa Shared Page Styles (included per-page)
     ===================================================== --}}
<style>
/* Breadcrumb */
.edu-bc { display:flex; align-items:center; gap:6px; list-style:none; padding:0; margin-bottom:20px; }
.edu-bc li { font-size:0.78rem; color:#94a3b8; }
.edu-bc li a { color:#4f46e5; text-decoration:none; font-weight:500; }
.edu-bc li a:hover { text-decoration:underline; }
.edu-bc li.active { color:#64748b; font-weight:600; }

/* Page header */
.edu-page-title { font-family:'Outfit',sans-serif; font-weight:700; color:#1e293b; margin:0; font-size:1.4rem; }
.edu-page-sub   { color:#64748b; font-size:0.875rem; margin:4px 0 0; }

/* Panel */
.edu-panel { background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 4px 24px rgba(15,23,42,0.06); overflow:hidden; margin-bottom:24px; }
.edu-panel-hd  { padding:20px 28px; border-bottom:1px solid #f8fafc; display:flex; justify-content:space-between; align-items:center; }
.edu-panel-ttl { font-family:'Outfit',sans-serif; font-weight:700; color:#1e293b; font-size:1rem; margin:0; }
.edu-panel-bd  { padding:28px; }

/* Table */
.edu-table { width:100%; border-collapse:separate; border-spacing:0; }
.edu-table thead th { background:#1e293b; color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; padding:14px 20px; border:none; white-space:nowrap; }
.edu-table tbody td { padding:13px 20px; vertical-align:middle; border-bottom:1px solid #f8fafc; color:#475569; font-size:0.875rem; }
.edu-table tbody tr:last-child td { border-bottom:none; }
.edu-table tbody tr:hover td { background:#fafbff; }

/* Buttons */
.btn-edu { display:inline-flex; align-items:center; gap:7px; font-weight:600; font-size:0.875rem; padding:9px 18px; border-radius:10px; border:none; text-decoration:none; transition:all 0.15s; cursor:pointer; }
.btn-edu-primary { background:linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff; box-shadow:0 4px 12px rgba(79,70,229,0.3); }
.btn-edu-primary:hover { color:#fff; transform:translateY(-1px); box-shadow:0 6px 16px rgba(79,70,229,0.4); }
.btn-edu-light   { background:#f8fafc; color:#64748b; border:1px solid #e2e8f0; }
.btn-edu-light:hover { background:#eef2ff; color:#4f46e5; }
.btn-edu-danger  { background:#fef2f2; color:#ef4444; border:1px solid #fecaca; }
.btn-edu-danger:hover { background:#ef4444; color:#fff; }

/* Icon action buttons */
.act-btn { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; border:none; background:transparent; color:#64748b; transition:all 0.15s; text-decoration:none; cursor:pointer; }
.act-btn:hover       { background:#eef2ff; color:#4f46e5; }
.act-btn.del:hover   { background:#fef2f2; color:#ef4444; }
.act-btn.succ:hover  { background:#f0fdf4; color:#16a34a; }

/* Badges */
.badge-indigo  { background:#eef2ff; color:#4f46e5; font-weight:700; font-size:0.72rem; padding:4px 10px; border-radius:20px; }
.badge-green   { background:#dcfce7; color:#16a34a; font-weight:700; font-size:0.72rem; padding:4px 10px; border-radius:20px; }
.badge-red     { background:#fef2f2; color:#ef4444; font-weight:700; font-size:0.72rem; padding:4px 10px; border-radius:20px; }
.badge-amber   { background:#fffbeb; color:#d97706; font-weight:700; font-size:0.72rem; padding:4px 10px; border-radius:20px; }
.badge-gray    { background:#f1f5f9; color:#64748b; font-weight:700; font-size:0.72rem; padding:4px 10px; border-radius:20px; }
.badge-id      { background:#eef2ff; color:#4f46e5; font-weight:700; font-size:0.72rem; padding:3px 10px; border-radius:6px; font-family:monospace; }

/* Form fields */
.edu-label  { font-size:0.82rem; font-weight:600; color:#374151; margin-bottom:6px; display:block; }
.edu-input  { border-radius:10px !important; border-color:#e2e8f0 !important; font-size:0.875rem !important; padding:10px 14px !important; box-shadow:none !important; }
.edu-input:focus { border-color:#a5b4fc !important; box-shadow:0 0 0 3px rgba(79,70,229,0.1) !important; }
.edu-section-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#94a3b8; margin-bottom:14px; }
.edu-divider { border:none; border-top:1px solid #f1f5f9; margin:20px 0; }

/* Alert */
.edu-alert-success { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px 16px; font-size:0.875rem; color:#16a34a; font-weight:600; margin-bottom:20px; }
.edu-alert-error   { background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:12px 16px; font-size:0.875rem; color:#ef4444; font-weight:600; margin-bottom:20px; }

/* Empty state */
.edu-empty { text-align:center; padding:60px 20px; }
.edu-empty i { font-size:2rem; color:#e2e8f0; margin-bottom:12px; display:block; }
.edu-empty p { color:#94a3b8; font-size:0.875rem; margin:0; }

/* Star rating */
.star-filled { color:#f59e0b; }
.star-empty  { color:#e2e8f0; }
</style>
