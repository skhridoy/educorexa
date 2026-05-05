@extends('layouts.main')

@section('customCSS')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="page-content">

    {{-- Breadcrumb --}}
    <ul style="display:flex;align-items:center;gap:6px;list-style:none;padding:0;margin-bottom:20px;">
        <li><a href="{{ route('super.dashboard') }}" style="color:#4f46e5;font-size:0.8rem;font-weight:500;text-decoration:none;">Dashboard</a></li>
        <li style="color:#cbd5e1;font-size:0.8rem;">/</li>
        <li><a href="{{ route('super.employees.index') }}" style="color:#4f46e5;font-size:0.8rem;font-weight:500;text-decoration:none;">Employees</a></li>
        <li style="color:#cbd5e1;font-size:0.8rem;">/</li>
        <li style="color:#64748b;font-size:0.8rem;font-weight:600;">Edit</li>
    </ul>

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 style="font-family:'Outfit',sans-serif;font-weight:700;color:#1e293b;margin:0;font-size:1.4rem;">
                <i class="fa-solid fa-user-pen me-2" style="color:#4f46e5;"></i> Edit Employee
            </h2>
            <p style="color:#64748b;font-size:0.875rem;margin:4px 0 0;">Updating record for <strong>{{ $employee->name }}</strong></p>
        </div>
        <a href="{{ route('super.employees.index') }}"
           style="display:inline-flex;align-items:center;gap:7px;background:#f8fafc;color:#64748b;font-weight:600;font-size:0.875rem;padding:9px 18px;border-radius:10px;border:1px solid #e2e8f0;text-decoration:none;"
           onmouseover="this.style.background='#eef2ff';this.style.color='#4f46e5'"
           onmouseout="this.style.background='#f8fafc';this.style.color='#64748b'">
            <i data-feather="arrow-left" style="width:15px;height:15px;"></i> Back to List
        </a>
    </div>

    {{-- Form Panel --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 4px 24px rgba(15,23,42,0.06);">

        {{-- Panel Header with employee info --}}
        <div style="padding:20px 28px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;gap:16px;">
            <img src="{{ (!empty($employee->photo) && file_exists(public_path('uploads/employees/'.$employee->photo)))
                ? asset('uploads/employees/'.$employee->photo)
                : asset('assets/images/profile.webp') }}"
                style="width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid #e0e7ff;" alt="{{ $employee->name }}">
            <div>
                <h6 style="font-family:'Outfit',sans-serif;font-weight:700;color:#1e293b;margin:0;font-size:1rem;">{{ $employee->name }}</h6>
                <p style="margin:0;font-size:0.78rem;color:#94a3b8;">{{ $employee->employee->designation ?? 'No designation' }} · {{ $employee->email }}</p>
            </div>
        </div>

        <div style="padding:28px;">
            @if($errors->any())
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:14px 18px;margin-bottom:20px;">
                <p style="color:#ef4444;font-weight:600;margin-bottom:6px;font-size:0.875rem;"><i class="fa-solid fa-circle-exclamation me-1"></i> Please fix the errors below:</p>
                <ul style="margin:0;padding-left:18px;color:#ef4444;font-size:0.82rem;">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('super.employees.update', $employee->id) }}" method="POST" id="editForm">
                @csrf

                {{-- Section: Account --}}
                <div style="margin-bottom:24px;">
                    <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin-bottom:12px;">Account Information</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required
                                   style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Email (Login ID) <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required
                                   style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">New Password <small style="color:#94a3b8;font-weight:400;">(leave blank to keep current)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••"
                                   style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                        </div>
                    </div>
                </div>

                <div style="border-top:1px solid #f1f5f9;margin-bottom:24px;"></div>

                {{-- Section: Employment --}}
                <div style="margin-bottom:24px;">
                    <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin-bottom:12px;">Employment Details</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" value="{{ $employee->employee->designation }}" required
                                   style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Personal Phone</label>
                            <input type="text" name="phone_personal" class="form-control" value="{{ $employee->employee->phone_personal }}"
                                   style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Assign Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required
                                    style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $employee->role == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Joining Date <span class="text-danger">*</span></label>
                            <input type="date" name="joining_date" class="form-control" value="{{ $employee->employee->joining_date }}" required
                                   style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Monthly Salary <span class="text-danger">*</span></label>
                            <input type="number" name="salary" class="form-control" value="{{ $employee->employee->salary }}" required
                                   style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required
                                    style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">
                                <option value="active"   {{ $employee->employee->status == 'active'   ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $employee->employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:0.82rem;font-weight:600;color:#374151;">Present Address</label>
                            <textarea name="address" class="form-control" rows="3"
                                      style="border-radius:10px;border-color:#e2e8f0;font-size:0.875rem;padding:10px 14px;">{{ $employee->employee->address }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div style="border-top:1px solid #f1f5f9;padding-top:20px;display:flex;gap:12px;">
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-weight:600;font-size:0.875rem;padding:11px 28px;border-radius:10px;border:none;box-shadow:0 4px 12px rgba(79,70,229,0.3);cursor:pointer;">
                        <i data-feather="check-circle" style="width:16px;height:16px;"></i> Update Employee
                    </button>
                    <a href="{{ route('super.employees.index') }}"
                       style="display:inline-flex;align-items:center;gap:8px;background:#f8fafc;color:#64748b;font-weight:600;font-size:0.875rem;padding:11px 24px;border-radius:10px;border:1px solid #e2e8f0;text-decoration:none;">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Updated!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}" });
    @endif
</script>
@endsection