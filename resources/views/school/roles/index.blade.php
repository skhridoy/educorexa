@extends('layouts.school')

@section('customCSS')
<style>
    :root {
        --edu-primary: #4f46e5;
        --edu-primary-light: #eef2ff;
        --edu-secondary: #64748b;
        --edu-bg: #f8fafc;
        --edu-card-bg: #ffffff;
    }

    .edu-header-glass {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        margin: -24px -24px 30px -24px;
        padding: 30px 40px;
    }

    .edu-bc {
        display: flex;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 0 0 12px 0;
        gap: 8px;
    }
    .edu-bc li { font-size: 0.8rem; color: var(--edu-secondary); }
    .edu-bc li a { color: var(--edu-primary); text-decoration: none; font-weight: 500; transition: color 0.2s; }
    .edu-bc li a:hover { color: #4338ca; }
    .edu-bc li.active { font-weight: 600; color: #1e293b; }
    .edu-bc li:not(:last-child)::after { content: "›"; margin-left: 8px; color: #94a3b8; font-size: 1.1rem; }

    .edu-stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .edu-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .role-card { 
        background: white; 
        border-radius: 24px; 
        border: 1px solid #f1f5f9; 
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04); 
        overflow: hidden;
    }
    
    .edu-table thead th {
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 24px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .edu-table tbody tr { transition: all 0.2s ease; cursor: default; }
    .edu-table tbody tr:hover { background-color: #fcfdff; }
    .edu-table td { padding: 20px 24px; vertical-align: middle; border-bottom: 1px solid #f8fafc; }

    .role-badge { 
        padding: 6px 14px; 
        border-radius: 99px; 
        font-size: 0.7rem; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.025em;
    }
    .badge-staff { background: #eff6ff; color: #2563eb; }
    .badge-teacher { background: #fdf2f8; color: #db2777; }
    .badge-student { background: #ecfdf5; color: #059669; }
    .badge-system { background: #f1f5f9; color: #475569; font-style: italic; border: 1px solid #e2e8f0; }

    .perm-badge {
        background: #f5f3ff;
        color: #6d28d9;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.75rem;
        border: 1px solid #ddd6fe;
    }
    
    .action-btn { 
        width: 38px; 
        height: 38px; 
        border-radius: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        transition: all 0.2s; 
        border: 1px solid #e2e8f0; 
        background: white; 
        color: #64748b; 
        text-decoration: none;
    }
    .action-btn:hover { 
        background: var(--edu-primary); 
        color: white; 
        border-color: var(--edu-primary); 
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }
    .action-btn.delete:hover { 
        background: #ef4444; 
        border-color: #ef4444;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    .btn-edu-primary {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }
    .btn-edu-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
        color: white;
    }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon { 
        width: 100px; 
        height: 100px; 
        background: #f5f3ff; 
        color: #4f46e5; 
        border-radius: 30px; 
        display: flex; 
        align-items:center; 
        justify-content:center; 
        margin: 0 auto 24px; 
        font-size: 40px; 
        transform: rotate(-10deg);
    }
</style>
@endsection

@section('content')
<div class="page-content">
    {{-- Glassmorphism Header --}}
    <div class="edu-header-glass">
        <div class="container-fluid">
            <ul class="edu-bc">
                <li><a href="{{ route('school.dashboard', ['tenant' => $tenant]) }}">{{ __('Dashboard') }}</a></li>
                <li class="active">{{ __('Roles & Permissions') }}</li>
            </ul>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 style="font-weight: 800; color: #1e293b; letter-spacing: -0.03em; margin: 0;">
                        <span style="background: linear-gradient(135deg, #4f46e5, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ __('Access Control') }}</span> {{ __('Center') }}
                    </h2>
                    <p style="color: #64748b; margin-top: 4px; font-size: 0.95rem;">{{ __('Configure institutional roles, hierarchical permissions, and security scope.') }}</p>
                </div>
                <a href="{{ route('school.roles.create', ['tenant' => $tenant]) }}" class="btn-edu-primary">
                    <i data-feather="plus-circle" style="width:20px;"></i>
                    <span>{{ __('Define New Role') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- Summary Stats Row --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="edu-stat-card">
                    <div class="edu-stat-icon" style="background: #e0e7ff; color: #4338ca;">
                        <i data-feather="shield"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">{{ __('Total Defined Roles') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">{{ $roles->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="edu-stat-card">
                    <div class="edu-stat-icon" style="background: #ecfdf5; color: #059669;">
                        <i data-feather="users"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">{{ __('Protected Systems') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">{{ $roles->whereNull('school_id')->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="edu-stat-card">
                    <div class="edu-stat-icon" style="background: #fff7ed; color: #c2410c;">
                        <i data-feather="lock"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">{{ __('Institutional Scope') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">{{ __('Global') }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-edu-success d-flex align-items-center mb-4 border-0 shadow-sm" style="background:#ecfdf5; color:#065f46; border-radius:16px; padding: 16px 24px;">
                <i data-feather="check-circle" class="me-3" style="width:20px;"></i>
                <div class="fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Main Table Section --}}
        <div class="role-card">
            <div class="table-responsive">
                <table class="table edu-table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">{{ __('Identity & Origin') }}</th>
                            <th>{{ __('Active Capabilities') }}</th>
                            <th>{{ __('Target Group') }}</th>
                            <th class="pe-4 text-end">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($roles as $role)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="me-3" style="background: linear-gradient(135deg, #f5f3ff, #ede9fe); color:#4f46e5; border-radius: 14px; width: 48px; height: 48px; display: flex; align-items:center; justify-content:center; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                                        <i data-feather="user-check" style="width:22px;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 1rem;">{{ $role->display_name ?? $role->name }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ __('Created:') }} {{ $role->created_at->format('d M, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="perm-badge">{{ $role->permissions->count() }}</span>
                                    <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">{{ __('Permissions mapped') }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $typeClass = match($role->role_type) {
                                        'teacher' => 'badge-teacher',
                                        'student' => 'badge-student',
                                        default => 'badge-staff'
                                    };
                                @endphp
                                <span class="role-badge {{ $typeClass }}">
                                    {{ ucwords(str_replace('_', ' ', $role->role_type ?? 'Staff')) }}
                                </span>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    @if($role->school_id == $school->id)
                                        <a href="{{ route('school.roles.edit', ['tenant' => $tenant, 'role' => $role->id]) }}" class="action-btn" title="Modify Configuration">
                                            <i data-feather="edit-3" style="width:16px;"></i>
                                        </a>
                                        <form action="{{ route('school.roles.destroy', ['tenant' => $tenant, 'role' => $role->id]) }}" method="POST" onsubmit="return confirm('{{ __('Attention: Deleting this role will affect all assigned staff. Continue?') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Terminate Role">
                                                <i data-feather="trash-2" style="width:16px;"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="role-badge badge-system">{{ __('Protected Default') }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon"><i data-feather="shield-off"></i></div>
                                    <h4 style="font-weight: 800; color: #1e293b;">{{ __('No Roles Defined') }}</h4>
                                    <p class="text-muted mx-auto" style="max-width: 400px;">{{ __('Start by defining access levels for your staff and faculty members to manage institutional workflow.') }}</p>
                                    <a href="{{ route('school.roles.create', ['tenant' => $tenant]) }}" class="btn-edu-primary mt-4">
                                        <i data-feather="plus"></i>
                                        <span>{{ __('Create First Role') }}</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
