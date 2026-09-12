@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    /* Badges & Pills */
    .role-badge {
        background: #f1f5f9; color: #475569;
        font-weight: 600; font-size: 0.72rem;
        padding: 3px 9px; border-radius: 6px;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }
    .badge-indigo {
        background: #e0e7ff; color: #4338ca;
        font-weight: 700; font-size: 0.72rem;
        padding: 3px 9px; border-radius: 6px;
        display: inline-block;
    }
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-weight: 700; font-size: 0.72rem;
        padding: 3px 10px; border-radius: 20px;
    }
    .status-badge.active { background: #dcfce7; color: #16a34a; }
    .status-badge.inactive { background: #fee2e2; color: #ef4444; }

    /* Search bar */
    .role-search-wrap {
        position: relative;
        max-width: 320px;
        width: 100%;
    }
    .role-search-wrap input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        font-size: 0.85rem;
        background: #fff;
        transition: all 0.2s;
    }
    .role-search-wrap input:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    .role-search-wrap i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.85rem;
    }

    /* Desktop Action Button */
    .act-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 8px; border: none;
        background: #f8fafc; color: #64748b; transition: all 0.15s;
        text-decoration: none !important;
    }
    .act-btn:hover { background: #eef2ff; color: #4f46e5; }
    .act-btn.del:hover { background: #fef2f2; color: #ef4444; }

    /* ========================================================
       MOBILE RESPONSIVE CARD VIEW (< 768px)
       ======================================================== */
    .role-mobile-list {
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .role-mobile-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1.5px solid #f1f5f9;
        padding: 16px;
        box-shadow: 0 4px 16px rgba(15,23,42,0.04);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        position: relative;
    }
    .role-mobile-card:active {
        transform: scale(0.99);
    }
    .role-m-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 12px;
    }
    .role-m-avatar-wrap {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: #eef2ff;
        border: 2px solid #e0e7ff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #4f46e5;
    }
    .role-m-title-area {
        flex-grow: 1;
        min-width: 0;
    }
    .role-m-name {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        color: #1e293b;
        margin-bottom: 3px;
        line-height: 1.2;
    }
    .role-m-top-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    /* Three-dot dropdown button (Mobile) */
    .role-m-dropdown {
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
    .role-actions-menu {
        border-radius: 14px;
        padding: 6px;
        min-width: 160px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.14), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
        border: 1px solid #f1f5f9 !important;
        z-index: 1050;
    }
    .role-actions-menu .dropdown-item {
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.15s;
    }
    .role-actions-menu .dropdown-item:hover {
        background: #f8fafc;
    }
    .role-actions-menu .dropdown-item.text-danger:hover {
        background: #fef2f2;
        color: #dc2626 !important;
    }

    /* Permissions Section */
    .role-m-perm-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 10px 12px;
        border: 1px solid #f1f5f9;
    }
    .role-m-perm-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .role-perm-pill {
        background: #fff;
        color: #334155;
        font-size: 10.5px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }
    .role-perm-more {
        background: #eef2ff;
        color: #4f46e5;
        font-size: 10.5px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        border: 1px solid #c7d2fe;
        display: inline-block;
    }

    /* Empty state */
    .role-empty-state {
        text-align: center;
        padding: 45px 20px;
    }

    @media (max-width: 576px) {
        .page-header-wrap {
            flex-direction: column;
            align-items: stretch !important;
            gap: 14px;
        }
        .btn-edu-primary {
            width: 100%;
            justify-content: center;
        }
        .role-search-wrap {
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Roles Management</li>
    </ul>

    <div class="page-header-wrap d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-shield-halved me-2" style="color:#4f46e5;"></i> System Roles</h2>
            <p class="edu-page-sub">Manage user roles and their respective access permissions.</p>
        </div>
        <a href="{{ route('super.roles.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Add New Role
        </a>
    </div>

    {{-- Stats & Search Bar --}}
    <div class="row g-3 mb-4 align-items-center">
        <div class="col-12 col-sm-6 col-md-4">
            <div style="background:#fff;border-radius:14px;border:1px solid #f1f5f9;padding:16px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 2px 12px rgba(15,23,42,0.05);">
                <div style="width:44px;height:44px;border-radius:12px;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
                    <i data-feather="shield" style="width:20px;height:20px;color:#4f46e5;"></i>
                </div>
                <div>
                    <div style="font-size:0.75rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">Total Roles</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:1.5rem;font-weight:700;color:#1e293b;line-height:1;">{{ $roles->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-8 d-flex justify-content-sm-end">
            <div class="role-search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="roleSearchInput" placeholder="Search roles or permissions...">
            </div>
        </div>
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd d-flex align-items-center justify-content-between">
            <h6 class="edu-panel-ttl mb-0">All Roles</h6>
            <small class="text-muted" id="roleCountLabel">Showing {{ $roles->count() }} roles</small>
        </div>

        {{-- 1. DESKTOP VIEW (>= 768px) --}}
        <div class="table-responsive d-none d-md-block">
            <table class="edu-table">
                <thead>
                    <tr>
                        <th>Role Identity</th>
                        <th>Permissions</th>
                        <th class="text-center">Users</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="desktopRoleBody">
                    @forelse($roles as $role)
                    @php
                        $permNames = $role->permissions->pluck('name')->implode(' ');
                        $roleSearchStr = strtolower($role->name . ' ' . ($role->role_type ?? '') . ' ' . $permNames);
                    @endphp
                    <tr class="role-row" data-search="{{ $roleSearchStr }}">
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:38px;height:38px;border-radius:10px;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
                                    <i data-feather="shield" style="width:17px;height:17px;color:#4f46e5;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700;color:#1e293b;font-size:0.875rem;">
                                        {{ ucfirst($role->name) }}
                                        @if($role->name == 'super-admin')
                                            <span class="badge-indigo" style="font-size:9px;margin-left:4px;">Protected</span>
                                        @endif
                                    </div>
                                    <div style="font-size:0.72rem;color:#94a3b8;">{{ ucfirst(str_replace('_', ' ', $role->role_type ?? 'Custom')) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;flex-wrap:wrap;gap:4px;max-width:460px;">
                                @foreach($role->permissions->take(6) as $perm)
                                    <span style="background:#f1f5f9;color:#475569;font-size:10px;font-weight:600;padding:3px 8px;border-radius:20px;">
                                        {{ str_replace(['-', '.'], ' ', $perm->name) }}
                                    </span>
                                @endforeach
                                @if($role->permissions->count() > 6)
                                    <span style="background:#eef2ff;color:#4f46e5;font-size:10px;font-weight:700;padding:3px 8px;border-radius:20px;">
                                        +{{ $role->permissions->count() - 6 }} more
                                    </span>
                                @endif
                                @if($role->permissions->count() == 0)
                                    <span style="color:#94a3b8;font-size:0.8rem;font-style:italic;">No permissions</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-gray">{{ $role->users_count ?? 0 }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('super.roles.edit', $role->id) }}" class="act-btn" title="Edit Role">
                                    <i data-feather="edit-3" style="width:15px;height:15px;"></i>
                                </a>
                                @if($role->name !== 'super-admin')
                                <form action="{{ route('super.roles.destroy', $role->id) }}" method="POST" class="delete-form d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="act-btn del delete-btn" title="Delete Role">
                                        <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="edu-empty">
                            <i class="fa-solid fa-shield-slash"></i>
                            <p>No roles found. <a href="{{ route('super.roles.create') }}" style="color:#4f46e5;">Create the first role</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 2. MOBILE RESPONSIVE CARD VIEW (< 768px) --}}
        <div class="role-mobile-list d-block d-md-none" id="roleMobileContainer">
            @forelse($roles as $role)
            @php
                $permNames = $role->permissions->pluck('name')->implode(' ');
                $roleSearchStr = strtolower($role->name . ' ' . ($role->role_type ?? '') . ' ' . $permNames);
            @endphp
            <div class="role-mobile-card" data-search="{{ $roleSearchStr }}">
                {{-- Card Header --}}
                <div class="role-m-header">
                    <div class="role-m-avatar-wrap">
                        <i class="fa-solid fa-shield-halved" style="font-size:1.25rem;"></i>
                    </div>
                    <div class="role-m-title-area">
                        <div class="role-m-name">
                            {{ ucfirst($role->name) }}
                            @if($role->name == 'super-admin')
                                <span class="badge-indigo" style="font-size:9px;margin-left:4px;">Protected</span>
                            @endif
                        </div>
                        <div class="role-m-top-meta">
                            <span class="role-badge">{{ ucfirst(str_replace('_', ' ', $role->role_type ?? 'Custom')) }}</span>
                            <span class="status-badge active">
                                <i class="fa-solid fa-users" style="font-size:0.65rem;"></i>
                                {{ $role->users_count ?? 0 }} Users
                            </span>
                        </div>
                    </div>

                    {{-- Three-dot action dropdown menu (Mobile) --}}
                    <div class="dropdown role-m-dropdown">
                        <button type="button" class="btn-m-dots" data-bs-toggle="dropdown" aria-expanded="false" title="Menu">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 role-actions-menu">
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-dark" href="{{ route('super.roles.edit', $role->id) }}">
                                    <i class="fa-solid fa-pen-to-square text-primary" style="width:16px;"></i>
                                    <span>এডিট করুন</span>
                                </a>
                            </li>
                            @if($role->name !== 'super-admin')
                            <li>
                                <form action="{{ route('super.roles.destroy', $role->id) }}" method="POST" class="delete-form m-0">
                                    @csrf @method('DELETE')
                                    <button type="button" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger delete-btn">
                                        <i class="fa-solid fa-trash-can" style="width:16px;"></i>
                                        <span>ডিলিট করুন</span>
                                    </button>
                                </form>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Permissions Section in Mobile Card --}}
                <div class="role-m-perm-box">
                    <div class="role-m-perm-label">
                        <i class="fa-solid fa-key text-primary"></i> পারমিশন ({{ $role->permissions->count() }})
                    </div>
                    <div class="d-flex flex-wrap gap-1">
                        @forelse($role->permissions->take(8) as $perm)
                            <span class="role-perm-pill">
                                {{ str_replace(['-', '.'], ' ', $perm->name) }}
                            </span>
                        @empty
                            <span class="text-muted small fst-italic">কোনো পারমিশন যুক্ত নেই</span>
                        @endforelse
                        @if($role->permissions->count() > 8)
                            <span class="role-perm-more">
                                +{{ $role->permissions->count() - 8 }} more
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="role-empty-state">
                <i class="fa-solid fa-shield-slash fa-2x mb-2 d-block" style="color:#cbd5e1;"></i>
                <span style="color:#94a3b8;font-size:0.875rem;">No roles found. <a href="{{ route('super.roles.create') }}" style="color:#4f46e5;">Create the first role</a></span>
            </div>
            @endforelse
        </div>

        {{-- No results search placeholder --}}
        <div id="noSearchResults" class="text-center p-4 d-none">
            <i class="fa-solid fa-magnifying-glass fa-2x mb-2 text-muted d-block"></i>
            <span class="text-muted small">No roles matched your search query.</span>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete Confirmation with SweetAlert
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Delete Role?',
                text: 'Users with this role may lose access.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete'
            }).then(r => {
                if (r.isConfirmed) form.submit();
            });
        });
    });

    // Real-time Search Filter (Both Desktop Table & Mobile Cards)
    const searchInput = document.getElementById('roleSearchInput');
    const roleRows = document.querySelectorAll('.role-row');
    const roleCards = document.querySelectorAll('.role-mobile-card');
    const noResults = document.getElementById('noSearchResults');
    const countLabel = document.getElementById('roleCountLabel');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleDesktop = 0;
            let visibleMobile = 0;

            roleRows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                if (searchData.includes(query)) {
                    row.style.display = '';
                    visibleDesktop++;
                } else {
                    row.style.display = 'none';
                }
            });

            roleCards.forEach(card => {
                const searchData = card.getAttribute('data-search') || '';
                if (searchData.includes(query)) {
                    card.style.display = '';
                    visibleMobile++;
                } else {
                    card.style.display = 'none';
                }
            });

            const totalVisible = Math.max(visibleDesktop, visibleMobile);
            if (countLabel) {
                countLabel.textContent = `Showing ${totalVisible} roles`;
            }

            if (totalVisible === 0 && query.length > 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
            }
        });
    }

    // Re-initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

@if(session('success'))
Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:3000})
    .fire({icon:'success',title:"{{ session('success') }}"});
@endif
</script>
@endsection