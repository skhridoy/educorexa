@extends('layouts.main')

@section('customCSS')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .page-header { margin-bottom: 28px; }
    .page-header h2 { font-family: 'Outfit', sans-serif; font-weight: 700; color: #1e293b; margin: 0; font-size: 1.4rem; }
    .page-header p  { color: #64748b; font-size: 0.875rem; margin: 4px 0 0; }

    /* Breadcrumb */
    .edu-breadcrumb { display: flex; align-items: center; gap: 6px; margin-bottom: 20px; list-style: none; padding: 0; }
    .edu-breadcrumb li { font-size: 0.8rem; color: #94a3b8; }
    .edu-breadcrumb li a { color: #4f46e5; text-decoration: none; font-weight: 500; }
    .edu-breadcrumb li a:hover { text-decoration: underline; }
    .edu-breadcrumb li.active { color: #64748b; font-weight: 600; }
    .edu-breadcrumb .sep { color: #cbd5e1; }

    /* Panel */
    .edu-panel { background: #fff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 24px rgba(15,23,42,0.06); overflow: hidden; }
    .edu-panel-header { padding: 22px 28px; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center; }
    .edu-panel-title { font-family: 'Outfit', sans-serif; font-weight: 700; color: #1e293b; font-size: 1.05rem; margin: 0; }
    .edu-panel-body { padding: 0; }

    /* Add button */
    .btn-edu-primary {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff; font-weight: 600; font-size: 0.875rem;
        padding: 9px 18px; border-radius: 10px; border: none;
        box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        text-decoration: none; transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-edu-primary:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(79,70,229,0.4); }

    /* Table */
    .edu-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .edu-table thead th {
        background: #1e293b; color: #fff;
        font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;
        padding: 14px 20px; border: none; white-space: nowrap;
    }
    .edu-table thead th:first-child { border-radius: 0; }
    .edu-table tbody td { padding: 14px 20px; vertical-align: middle; border-bottom: 1px solid #f8fafc; color: #475569; font-size: 0.875rem; }
    .edu-table tbody tr:last-child td { border-bottom: none; }
    .edu-table tbody tr:hover td { background: #fafbff; }

    /* Avatar */
    .emp-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #e0e7ff; }
    .emp-name { font-weight: 700; color: #1e293b; font-size: 0.875rem; }
    .emp-email { font-size: 0.75rem; color: #94a3b8; }

    /* ID badge */
    .emp-id { background: #eef2ff; color: #4f46e5; font-weight: 700; font-size: 0.78rem; padding: 3px 10px; border-radius: 6px; font-family: monospace; }

    /* Role badge */
    .role-badge { background: #f0fdf4; color: #16a34a; font-weight: 700; font-size: 0.72rem; padding: 3px 9px; border-radius: 20px; }

    /* Status */
    .status-active   { background: #dcfce7; color: #16a34a; font-weight: 700; font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; }
    .status-inactive { background: #fef2f2; color: #ef4444; font-weight: 700; font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; }

    /* Action btn */
    .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; border: none; background: transparent; color: #64748b; transition: all 0.15s; text-decoration: none; }
    .action-btn:hover { background: #eef2ff; color: #4f46e5; }
    .action-btn.danger:hover { background: #fef2f2; color: #ef4444; }
</style>
@endsection

@section('content')
<div class="page-content">

    {{-- Breadcrumb --}}
    <ul class="edu-breadcrumb">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span class="sep">/</span></li>
        <li class="active">Employee Management</li>
    </ul>

    {{-- Page Header --}}
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h2><i class="fa-solid fa-users me-2" style="color:#4f46e5;"></i> System Employees</h2>
            <p>Manage all administrative staff and their system access.</p>
        </div>
        @can('employee.create')
        <a href="{{ route('super.employees.create') }}" class="btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Add Employee
        </a>
        @endcan
    </div>

    {{-- Table Panel --}}
    <div class="edu-panel">
        <div class="edu-panel-header">
            <h6 class="edu-panel-title">All System Employees</h6>
            <span style="font-size:0.8rem;color:#94a3b8;">{{ $employees->count() }} total</span>
        </div>
        <div class="edu-panel-body">
            <div class="table-responsive">
                <table class="edu-table">
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
                        <tr>
                            <td>
                                <span class="emp-id">{{ $user->employee->employee_id ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ (!empty($user->photo) && file_exists(public_path('uploads/employees/'.$user->photo)))
                                        ? asset('uploads/employees/'.$user->photo)
                                        : asset('assets/images/profile.webp') }}"
                                        class="emp-avatar" alt="{{ $user->name }}">
                                    <div>
                                        <div class="emp-name">{{ $user->name }}</div>
                                        <div class="emp-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->employee->designation ?? '—' }}</td>
                            <td>
                                @foreach($user->getRoleNames() as $role)
                                    <span class="role-badge">{{ $role }}</span>
                                @endforeach
                            </td>
                            <td style="font-weight:600;color:#1e293b;">৳ {{ number_format($user->employee->salary ?? 0) }}</td>
                            <td>
                                @if(($user->employee->status ?? '') == 'active')
                                    <span class="status-active">Active</span>
                                @else
                                    <span class="status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    @can('employee.edit')
                                    <a href="{{ route('super.employees.edit', $user->id) }}" class="action-btn" title="Edit">
                                        <i data-feather="edit-2" style="width:15px;height:15px;"></i>
                                    </a>
                                    @endcan
                                    @can('employee.delete')
                                    <a href="{{ route('super.employees.destroy', $user->id) }}" class="action-btn danger" id="deleteEmployee" title="Delete">
                                        <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fa-solid fa-users-slash fa-2x mb-3 d-block" style="color:#e2e8f0;"></i>
                                <span style="color:#94a3b8;font-size:0.875rem;">No employees found.</span>
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

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        $(document).on('click', '#deleteEmployee', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Delete Employee?',
                text: "This will permanently remove the employee and their records.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) { window.location.href = link; }
            });
        });

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