@extends('layouts.main')

@section('customCSS')
{{-- SweetAlert CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .bg-light-primary { background-color: #e3f2fd; color: #0d6efd; }
</style>
@endsection

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Employee Management</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title mb-0">All System Employees</h6>
                        @can('employee.create')
                        <a href="{{ route('super.employees.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                            Add Employee
                        </a>
                        @endcan
                    </div>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Info</th>
                                    <th>Designation</th>
                                    <th>Role</th>
                                    <th>Salary</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $user)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $user->employee->employee_id ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ (!empty($user->photo) && file_exists(public_path('uploads/employees/'.$user->photo))) 
                                                ? asset('uploads/employees/'.$user->photo) 
                                                : asset('assets/images/profile.webp') }}" 
                                                class="wd-35 ht-35 rounded-circle me-2" alt="profile">
                                            <div>
                                                <p class="mb-0 fw-bold">{{ $user->name }}</p>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->employee->designation ?? 'N/A' }}</td>
                                    <td>
                                        @foreach($user->getRoleNames() as $role)
                                            <span class="badge bg-light-primary text-primary">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td>৳ {{ number_format($user->employee->salary ?? 0) }}</td>
                                    <td>
                                        <span class="badge {{ ($user->employee->status ?? '') == 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($user->employee->status ?? 'Inactive') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="more-horizontal" class="text-muted"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @can('employee.edit')
                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('super.employees.edit', $user->id) }}">
                                                    <i data-feather="edit-2" class="icon-sm me-2"></i> Edit
                                                </a>
                                                @endcan
                                                
                                                @can('employee.delete')
                                                {{-- এখানে id="delete" ব্যবহার করা হয়েছে যা নিচের JS এর সাথে কানেক্টেড --}}
                                                <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('super.employees.destroy', $user->id) }}" id="deleteEmployee">
                                                    <i data-feather="trash" class="icon-sm me-2"></i> Delete
                                                </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
{{-- SweetAlert JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function() {
        // ডিলিট কনফার্মেশন অ্যালার্ট
        $(document).on('click', '#deleteEmployee', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");

            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this employee and their records?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ডিলিট করার জন্য একটি ফর্ম সাবমিট করা সবচেয়ে ভালো প্র্যাকটিস
                    // কিন্তু আপনি যদি GET রাউট ব্যবহার করেন তবে নিচের লাইনটি কাজ করবে:
                    window.location.href = link;
                }
            })
        });

        // সাকসেস মেসেজ অ্যালার্ট (কন্ট্রোলার থেকে আসা)
        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
            });
        @endif
    });
</script>
@endsection