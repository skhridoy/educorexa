@extends('layouts.main')

@section('customCSS')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* Page Layout */
    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-family: 'Outfit', sans-serif; font-weight: 700; color: #1e293b; margin: 0; font-size: 1.35rem; }
    .page-header p  { color: #64748b; font-size: 0.85rem; margin: 4px 0 0; }

    /* Breadcrumb */
    .edu-breadcrumb { display: flex; align-items: center; gap: 6px; margin-bottom: 16px; list-style: none; padding: 0; flex-wrap: wrap; }
    .edu-breadcrumb li { font-size: 0.8rem; color: #94a3b8; }
    .edu-breadcrumb li a { color: #4f46e5; text-decoration: none; font-weight: 500; }
    .edu-breadcrumb li a:hover { text-decoration: underline; }
    .edu-breadcrumb li.active { color: #64748b; font-weight: 600; }
    .edu-breadcrumb .sep { color: #cbd5e1; }

    /* Quick Stats Bar */
    .emp-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }
    .emp-stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 14px 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 10px rgba(15,23,42,0.03);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .emp-stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .emp-stat-val { font-size: 1.15rem; font-weight: 800; color: #1e293b; line-height: 1; font-family: 'Outfit', sans-serif; }
    .emp-stat-lbl { font-size: 0.72rem; color: #64748b; font-weight: 600; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.04em; }

    /* Add button */
    .btn-edu-primary {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff !important; font-weight: 600; font-size: 0.875rem;
        padding: 10px 20px; border-radius: 12px; border: none;
        box-shadow: 0 4px 14px rgba(79,70,229,0.28);
        text-decoration: none !important; transition: all 0.2s ease;
    }
    .btn-edu-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(79,70,229,0.38); }

    /* Panel */
    .edu-panel { background: #fff; border-radius: 18px; border: 1px solid #f1f5f9; box-shadow: 0 4px 24px rgba(15,23,42,0.05); overflow: hidden; }
    .edu-panel-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        background: #fff;
    }
    .edu-panel-title { font-family: 'Outfit', sans-serif; font-weight: 700; color: #1e293b; font-size: 1.05rem; margin: 0; }

    /* Search & Filter Controls */
    .search-filter-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }
    @media (min-width: 768px) {
        .search-filter-wrapper { width: auto; }
    }
    .search-input-box {
        position: relative;
        flex-grow: 1;
        min-width: 220px;
    }
    .search-input-box input {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 14px 8px 36px;
        font-size: 0.84rem;
        color: #1e293b;
        outline: none;
        background: #f8fafc;
        transition: all 0.2s;
    }
    .search-input-box input:focus {
        background: #fff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }
    .search-input-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.85rem;
    }

    /* Filter Pills */
    .filter-pills {
        display: flex;
        gap: 6px;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
        font-size: 0.78rem;
    }
    .filter-btn {
        border: none;
        background: transparent;
        color: #64748b;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 7px;
        cursor: pointer;
        transition: all 0.15s;
    }
    .filter-btn.active {
        background: #fff;
        color: #4f46e5;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    /* Desktop Table */
    .edu-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .edu-table thead th {
        background: #1e293b; color: #fff;
        font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em;
        padding: 14px 20px; border: none; white-space: nowrap;
    }
    .edu-table tbody td { padding: 14px 20px; vertical-align: middle; border-bottom: 1px solid #f8fafc; color: #475569; font-size: 0.875rem; }
    .edu-table tbody tr:last-child td { border-bottom: none; }
    .edu-table tbody tr:hover td { background: #fafbff; }

    /* Badges & Pills */
    .emp-id {
        background: #eef2ff; color: #4f46e5;
        font-weight: 700; font-size: 0.78rem;
        padding: 3px 10px; border-radius: 6px;
        font-family: monospace; letter-spacing: 0.5px;
    }
    .role-badge {
        background: #f1f5f9; color: #475569;
        font-weight: 600; font-size: 0.72rem;
        padding: 3px 9px; border-radius: 6px;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-weight: 700; font-size: 0.72rem;
        padding: 4px 10px; border-radius: 20px;
    }
    .status-badge.active { background: #dcfce7; color: #16a34a; }
    .status-badge.inactive { background: #fee2e2; color: #ef4444; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    /* Desktop Action Button */
    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 8px; border: none;
        background: #f8fafc; color: #64748b; transition: all 0.15s;
        text-decoration: none !important;
    }
    .action-btn:hover { background: #eef2ff; color: #4f46e5; }
    .action-btn.danger:hover { background: #fef2f2; color: #ef4444; }

    /* ========================================================
       MOBILE RESPONSIVE CARD VIEW (< 768px)
       ======================================================== */
    .emp-mobile-list {
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .emp-mobile-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1.5px solid #f1f5f9;
        padding: 16px;
        box-shadow: 0 4px 16px rgba(15,23,42,0.04);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        position: relative;
    }
    .emp-mobile-card:active {
        transform: scale(0.99);
    }
    .emp-m-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 12px;
    }
    .emp-m-avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }
    .emp-m-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        object-fit: cover;
        border: 2px solid #e0e7ff;
        background: #f8fafc;
    }
    .emp-m-online-dot {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        border: 2px solid #fff;
    }
    .emp-m-online-dot.active { background: #22c55e; }
    .emp-m-online-dot.inactive { background: #ef4444; }

    .emp-m-title-area {
        flex-grow: 1;
        min-width: 0;
    }
    .emp-m-name {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 0.98rem;
        color: #1e293b;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .emp-m-designation {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .emp-m-top-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    /* Grid for Mobile Details */
    .emp-m-details-grid {
        background: #f8fafc;
        border-radius: 12px;
        padding: 10px 12px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px 12px;
        margin-bottom: 12px;
        border: 1px solid #f1f5f9;
    }
    .emp-m-detail-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .emp-m-detail-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .emp-m-detail-val {
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
        word-break: break-all;
    }
    .emp-m-detail-val a {
        color: #4f46e5;
        text-decoration: none;
    }

    /* Mobile Action Buttons */
    /* Three-dot dropdown button (Mobile) */
    .emp-m-dropdown {
        flex-shrink: 0;
        margin-left: auto;
    }
    .btn-m-dots {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-m-dots:hover, .btn-m-dots:focus, .btn-m-dots[aria-expanded="true"] {
        background: #eef2ff;
        color: #4f46e5;
        border-color: #c7d2fe;
    }
    .emp-actions-menu {
        border-radius: 14px;
        padding: 6px;
        min-width: 160px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.14), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
        border: 1px solid #f1f5f9 !important;
        z-index: 1050;
    }
    .emp-actions-menu .dropdown-item {
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.15s;
    }
    .emp-actions-menu .dropdown-item:hover {
        background: #f8fafc;
    }
    .emp-actions-menu .dropdown-item.text-danger:hover {
        background: #fef2f2;
        color: #dc2626 !important;
    }

    /* Empty state */
    .emp-empty-state {
        text-align: center;
        padding: 45px 20px;
    }

    @media (max-width: 576px) {
        .page-header {
            flex-direction: column;
            align-items: stretch !important;
            gap: 14px;
        }
        .btn-edu-primary {
            width: 100%;
        }
        .emp-m-details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content">

    {{-- Breadcrumb --}}
    <ul class="edu-breadcrumb">
        <li><a href="{{ route('super.dashboard') }}"><i class="fa-solid fa-house me-1"></i> Dashboard</a></li>
        <li><span class="sep">/</span></li>
        <li class="active">Employee Management</li>
    </ul>

    {{-- Page Header --}}
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2><i class="fa-solid fa-users me-2" style="color:#4f46e5;"></i> System Employees</h2>
            <p>Manage all administrative staff, representative profiles, and access.</p>
        </div>
        @can('employee.create')
        <a href="{{ route('super.employees.create') }}" class="btn-edu-primary">
            <i class="fa-solid fa-user-plus"></i> Add Employee
        </a>
        @endcan
    </div>

    {{-- Quick Stats Bar --}}
    @php
        $totalCount    = $employees->count();
        $activeCount   = $employees->filter(fn($e) => ($e->employee->status ?? '') === 'active')->count();
        $inactiveCount = $totalCount - $activeCount;
    @endphp
    <div class="emp-stats-grid">
        <div class="emp-stat-card">
            <div class="emp-stat-icon" style="background:#eef2ff; color:#4f46e5;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="emp-stat-val">{{ $totalCount }}</div>
                <div class="emp-stat-lbl">Total Staff</div>
            </div>
        </div>
        <div class="emp-stat-card">
            <div class="emp-stat-icon" style="background:#dcfce7; color:#16a34a;">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <div class="emp-stat-val">{{ $activeCount }}</div>
                <div class="emp-stat-lbl">Active</div>
            </div>
        </div>
        <div class="emp-stat-card">
            <div class="emp-stat-icon" style="background:#fee2e2; color:#ef4444;">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div>
                <div class="emp-stat-val">{{ $inactiveCount }}</div>
                <div class="emp-stat-lbl">Inactive</div>
            </div>
        </div>
    </div>

    {{-- Main Panel --}}
    <div class="edu-panel">
        <div class="edu-panel-header">
            <div class="d-flex align-items-center gap-2">
                <h6 class="edu-panel-title">Employee List</h6>
                <span class="badge bg-light text-dark border px-2 py-1" id="empCounterBadge" style="font-size: 0.75rem;">
                    {{ $totalCount }}
                </span>
            </div>

            {{-- Search & Filters --}}
            <div class="search-filter-wrapper">
                <div class="search-input-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="empSearchInput" placeholder="খুঁজুন (নাম, আইডি, পদবী, ফোন)..." autocomplete="off">
                </div>
                <div class="filter-pills">
                    <button type="button" class="filter-btn active" data-filter="all">All</button>
                    <button type="button" class="filter-btn" data-filter="active">Active</button>
                    <button type="button" class="filter-btn" data-filter="inactive">Inactive</button>
                </div>
            </div>
        </div>

        <div class="edu-panel-body">

            {{-- 1. DESKTOP VIEW: Clean Modern Table (>= 768px) --}}
            <div class="table-responsive d-none d-md-block">
                <table class="edu-table" id="empDesktopTable">
                    <thead>
                        <tr>
                            <th>Emp ID</th>
                            <th>Employee Info</th>
                            <th>Designation</th>
                            <th>Role</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $user)
                        @php
                            $isActive   = ($user->employee->status ?? '') === 'active';
                            $statusSlug = $isActive ? 'active' : 'inactive';
                            $phoneNum   = $user->employee->phone_personal ?? $user->phone ?? '';
                            $searchStr  = strtolower(($user->name ?? '').' '.($user->email ?? '').' '.($user->employee->employee_id ?? '').' '.($user->employee->designation ?? '').' '.$phoneNum);
                        @endphp
                        <tr class="emp-row" data-status="{{ $statusSlug }}" data-search="{{ $searchStr }}">
                            <td>
                                <span class="emp-id">{{ $user->employee->employee_id ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="position:relative;">
                                        <img src="{{ (!empty($user->photo) && file_exists(public_path('uploads/employees/'.$user->photo)))
                                            ? asset('uploads/employees/'.$user->photo)
                                            : asset('assets/images/profile.webp') }}"
                                            style="width:40px;height:40px;border-radius:10px;object-fit:cover;border:1.5px solid #e2e8f0;" 
                                            alt="{{ $user->name }}">
                                        <span class="status-dot {{ $statusSlug }}" 
                                              style="position:absolute;bottom:-2px;right:-2px;width:10px;height:10px;border:2px solid #fff;border-radius:50%;background:{{ $isActive ? '#22c55e' : '#ef4444' }};"></span>
                                    </div>
                                    <div>
                                        <div style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ $user->name }}</div>
                                        <div style="font-size:0.76rem;color:#94a3b8;">{{ $user->email }}</div>
                                        @if(!empty($phoneNum))
                                            <div style="font-size:0.74rem;color:#64748b;">
                                                <i class="fa-solid fa-phone" style="font-size:0.65rem;"></i> {{ $phoneNum }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight:600;color:#334155;">{{ $user->employee->designation ?? '—' }}</span>
                            </td>
                            <td>
                                @forelse($user->getRoleNames() as $role)
                                    <span class="role-badge">{{ $role }}</span>
                                @empty
                                    <span class="text-muted small">—</span>
                                @endforelse
                            </td>
                            <td style="font-weight:700;color:#1e293b;">
                                ৳ {{ number_format($user->employee->salary ?? 0) }}
                            </td>
                            <td>
                                @if($isActive)
                                    <span class="status-badge active"><span class="status-dot"></span> Active</span>
                                @else
                                    <span class="status-badge inactive"><span class="status-dot"></span> Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    @can('employee.edit')
                                    <a href="{{ route('super.employees.edit', $user->id) }}" class="action-btn" title="Edit Employee">
                                        <i data-feather="edit-2" style="width:15px;height:15px;"></i>
                                    </a>
                                    @endcan
                                    @can('employee.delete')
                                    <a href="{{ route('super.employees.destroy', $user->id) }}" class="action-btn danger delete-employee" title="Delete Employee">
                                        <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="desktopInitialEmpty">
                            <td colspan="7" class="emp-empty-state">
                                <i class="fa-solid fa-users-slash fa-2x mb-2 d-block" style="color:#cbd5e1;"></i>
                                <span style="color:#94a3b8;font-size:0.875rem;">No employees found in the system.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 2. MOBILE RESPONSIVE CARD VIEW (< 768px) --}}
            <div class="emp-mobile-list d-block d-md-none" id="empMobileContainer">
                @forelse($employees as $user)
                @php
                    $isActive   = ($user->employee->status ?? '') === 'active';
                    $statusSlug = $isActive ? 'active' : 'inactive';
                    $phoneNum   = $user->employee->phone_personal ?? $user->phone ?? '';
                    $searchStr  = strtolower(($user->name ?? '').' '.($user->email ?? '').' '.($user->employee->employee_id ?? '').' '.($user->employee->designation ?? '').' '.$phoneNum);
                @endphp
                <div class="emp-mobile-card" data-status="{{ $statusSlug }}" data-search="{{ $searchStr }}">
                    {{-- Card Header --}}
                    <div class="emp-m-header">
                        <div class="emp-m-avatar-wrap">
                            <img src="{{ (!empty($user->photo) && file_exists(public_path('uploads/employees/'.$user->photo)))
                                ? asset('uploads/employees/'.$user->photo)
                                : asset('assets/images/profile.webp') }}"
                                class="emp-m-avatar" alt="{{ $user->name }}">
                            <span class="emp-m-online-dot {{ $statusSlug }}"></span>
                        </div>
                        <div class="emp-m-title-area">
                            <div class="emp-m-name">{{ $user->name }}</div>
                            <div class="emp-m-designation">{{ $user->employee->designation ?? 'Administrative Staff' }}</div>
                            <div class="emp-m-top-meta">
                                <span class="emp-id">{{ $user->employee->employee_id ?? 'N/A' }}</span>
                                @if($isActive)
                                    <span class="status-badge active"><span class="status-dot"></span> Active</span>
                                @else
                                    <span class="status-badge inactive"><span class="status-dot"></span> Inactive</span>
                                @endif
                                @foreach($user->getRoleNames() as $role)
                                    <span class="role-badge">{{ $role }}</span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Three Dot Action Dropdown Menu --}}
                        <div class="dropdown emp-m-dropdown">
                            <button type="button" class="btn-m-dots" data-bs-toggle="dropdown" aria-expanded="false" title="Menu">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 emp-actions-menu">
                                @can('employee.edit')
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-dark" href="{{ route('super.employees.edit', $user->id) }}">
                                        <i class="fa-solid fa-pen-to-square text-primary" style="width:16px;"></i>
                                        <span>এডিট করুন</span>
                                    </a>
                                </li>
                                @endcan
                                @can('employee.delete')
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger delete-employee" href="{{ route('super.employees.destroy', $user->id) }}">
                                        <i class="fa-solid fa-trash-can" style="width:16px;"></i>
                                        <span>ডিলিট করুন</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </div>

                    {{-- Card Details Grid --}}
                    <div class="emp-m-details-grid mb-0">
                        <div class="emp-m-detail-item">
                            <span class="emp-m-detail-label">
                                <i class="fa-solid fa-sack-dollar text-primary"></i> বেতন / Salary
                            </span>
                            <span class="emp-m-detail-val text-dark fw-bold">
                                ৳ {{ number_format($user->employee->salary ?? 0) }}
                            </span>
                        </div>

                        <div class="emp-m-detail-item">
                            <span class="emp-m-detail-label">
                                <i class="fa-solid fa-phone text-success"></i> মোবাইল
                            </span>
                            <span class="emp-m-detail-val">
                                @if(!empty($phoneNum))
                                    <a href="tel:{{ $phoneNum }}">{{ $phoneNum }}</a>
                                @else
                                    <span class="text-muted">উল্লেখ নেই</span>
                                @endif
                            </span>
                        </div>

                        <div class="emp-m-detail-item" style="grid-column: 1 / -1;">
                            <span class="emp-m-detail-label">
                                <i class="fa-solid fa-envelope text-indigo"></i> ইমেইল
                            </span>
                            <span class="emp-m-detail-val">
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="emp-empty-state">
                    <i class="fa-solid fa-users-slash fa-2x mb-2 d-block" style="color:#cbd5e1;"></i>
                    <span style="color:#94a3b8;font-size:0.875rem;">No employees found.</span>
                </div>
                @endforelse
            </div>

            {{-- Dynamic Empty Search Result Message --}}
            <div id="noMatchMessage" class="emp-empty-state d-none">
                <i class="fa-solid fa-filter-circle-xmark fa-2x mb-2 d-block" style="color:#cbd5e1;"></i>
                <h6 class="fw-bold text-dark mb-1">কোনো তথ্য পাওয়া যায়নি</h6>
                <span style="color:#94a3b8;font-size:0.85rem;">অন্য কোনো নাম বা আইডি দিয়ে পুনরায় সার্চ করুন।</span>
            </div>

        </div>
    </div>

</div>
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        // Delete Confirmation
        $(document).on('click', '.delete-employee, #deleteEmployee', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Delete Employee?',
                text: "This will permanently remove the employee and their system records.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                borderRadius: '16px'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('<form>', {
                        'method': 'POST',
                        'action': link
                    });
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': '{{ csrf_token() }}'
                    }));
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_method',
                        'value': 'DELETE'
                    }));
                    $('body').append(form);
                    form.submit();
                }
            });
        });

        // Instant Realtime Search & Filter Functionality
        let currentFilter = 'all';

        function filterEmployees() {
            const query = $('#empSearchInput').val().toLowerCase().trim();
            let visibleCount = 0;

            // Desktop rows
            $('#empDesktopTable tbody tr.emp-row').each(function() {
                const rowStatus = $(this).data('status');
                const rowSearch = $(this).data('search');

                const matchesStatus = (currentFilter === 'all' || rowStatus === currentFilter);
                const matchesQuery  = (query === '' || rowSearch.indexOf(query) !== -1);

                if (matchesStatus && matchesQuery) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            // Mobile cards
            $('#empMobileContainer .emp-mobile-card').each(function() {
                const cardStatus = $(this).data('status');
                const cardSearch = $(this).data('search');

                const matchesStatus = (currentFilter === 'all' || cardStatus === currentFilter);
                const matchesQuery  = (query === '' || cardSearch.indexOf(query) !== -1);

                if (matchesStatus && matchesQuery) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Update counter badge
            $('#empCounterBadge').text(visibleCount);

            // Toggle empty message
            if (visibleCount === 0 && (query !== '' || currentFilter !== 'all')) {
                $('#noMatchMessage').removeClass('d-none');
            } else {
                $('#noMatchMessage').addClass('d-none');
            }
        }

        $('#empSearchInput').on('input', filterEmployees);

        $('.filter-btn').on('click', function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            currentFilter = $(this).data('filter');
            filterEmployees();
        });

        // Initialize Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Toasts
        @if(session('success'))
            Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true })
                .fire({ icon: 'success', title: "{{ session('success') }}" });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}" });
        @endif
    });
</script>
@endsection