@extends('layouts.main')

@section('customCSS')
<style>
    /* মেইন কার্ড স্টাইল */
    .card {
        border-radius: 10px;
        border: none;
    }
    
    /* পারমিশন কন্টেইনার স্টাইল */
    .permission-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    /* প্রতিটি পারমিশন গ্রুপ কার্ড */
    .permission-group-card {
        background-color: #fff;
        border: 1px solid #e8ebf1;
        border-radius: 8px;
        transition: all 0.3s ease;
        height: 100%;
    }
    .permission-group-card:hover {
        border-color: #6571ff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .permission-group-header {
        background-color: #f1f3f7;
        padding: 10px 15px;
        border-bottom: 1px solid #e8ebf1;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .permission-group-title {
        font-weight: 700;
        color: #6571ff;
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    .permission-group-body {
        padding: 15px;
    }

    /* চেক বক্স এবং লেবেল স্টাইল */
    .form-check-input {
        cursor: pointer;
    }
    .form-check-label {
        cursor: pointer;
        color: #495057;
        font-size: 0.85rem;
        transition: color 0.2s ease;
        text-transform: capitalize; /* অটোমেটিক নাম সুন্দর করবে */
    }
    .form-check-input:checked + .form-check-label {
        color: #6571ff;
        font-weight: 500;
    }

    /* সিলেক্ট অল এবং অ্যাকশন বাটন */
    .action-header {
        border-bottom: 1px solid #e8ebf1;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }
    /* রেসপন্সিভ প্যাডিং এবং ফন্ট অ্যাডজাস্টমেন্ট */
    @media (max-width: 768px) {
        .page-content { padding: 15px; }
        .permission-group-title { font-size: 0.75rem; }
        .form-check-label { font-size: 0.8rem; }
    }

    /* কার্ডের উচ্চতা সমান রাখা */
    .permission-group-card {
        display: flex;
        flex-direction: column;
    }
    
    .permission-group-body {
        flex-grow: 1;
    }

    /* লম্বা পারমিশন নাম হ্যান্ডেল করা */
    .permission-label {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        max-width: 100%;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    {{-- Breadcrumb --}}
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Role</li>
        </ol>
    </nav>

    <form action="{{ route('super.roles.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- বাম পাশ: Role বেসিক ইনফরমেশন --}}
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">Role Information</h6>
                            <a href="{{ route('super.roles.index') }}" class="btn btn-sm btn-outline-secondary btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="arrow-left"></i> Back
                            </a>
                        </div>
                        <hr class="mb-4">
                        
                        <div class="row">
                            {{-- Role Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="roleNameId" class="form-label text-dark fw-bold">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control border-secondary shadow-none @error('name') is-invalid @enderror" 
                                       id="roleNameId" placeholder="e.g. Accountant, HR Manager" value="{{ old('name') }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Role Type --}}
                            <div class="col-md-6 mb-3">
                                <label for="roleTypeId" class="form-label text-dark fw-bold">Role Type <span class="text-danger">*</span></label>
                                <select name="role_type" class="form-select border-secondary shadow-none @error('role_type') is-invalid @enderror" id="roleTypeId">
                                    <option value="">-- Choose Role Type --</option>
                                    <option value="school_admin" {{ old('role_type') == 'school_admin' ? 'selected' : '' }}>School Admin</option>
                                    <option value="employee" {{ old('role_type') == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="teacher" {{ old('role_type') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="student" {{ old('role_type') == 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                                @error('role_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted mt-1 d-block">This defines which system modules this role can access.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Permissions Section (পুরো উইডথ জুড়ে) --}}
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">Assign Permissions</h6>
                            <p class="text-muted mb-0 small">Select permissions for this role from different modules.</p>
                        </div>
                        <hr class="mb-3">
                        
                        <div class="action-header d-flex justify-content-end align-items-center">
                            <div class="form-check form-switch me-3">
                                <input type="checkbox" class="form-check-input form-check-input-lg" id="checkAll">
                                <label class="form-check-label fw-bold text-primary small" for="checkAll">SELECT ALL PERMISSIONS</label>
                            </div>
                        </div>

                        {{-- পারমিশন গ্রুপিং (Responsive & Equal Height) --}}
                        <div class="permission-section">
                            {{-- row-cols-1: মোবাইলে ১টি, row-cols-md-2: ট্যাবে ২টি, row-cols-xl-3: বড় স্ক্রিনে ৩টি কার্ড দেখাবে --}}
                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                                @foreach($permissions->groupBy('group_name') as $group => $groupPermissions)
                                    <div class="col">
                                        <div class="permission-group-card h-100 shadow-sm border"> {{-- h-100 কার্ডগুলোকে সমান বড় রাখবে --}}
                                            <div class="permission-group-header bg-soft-info p-3 border-bottom d-flex justify-content-between align-items-center">
                                                <h6 class="permission-group-title text-uppercase mb-0" style="font-size: 0.8rem;">
                                                    <i data-feather="layers" class="icon-sm me-1"></i> {{ $group }}
                                                </h6>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input select-group" id="group_{{ Str::slug($group) }}">
                                                    <label class="form-check-label small text-primary fw-bold" for="group_{{ Str::slug($group) }}">Select All</label>
                                                </div>
                                            </div>
                                            <div class="permission-group-body p-3">
                                                <div class="row g-2">
                                                    @foreach($groupPermissions as $permission)
                                                    <div class="col-12 col-sm-6"> {{-- ছোট মোবাইলেও নামগুলো যাতে সুন্দর দেখায় --}}
                                                        <div class="form-check custom-check">
                                                            <input class="form-check-input permission-checkbox" 
                                                                type="checkbox" 
                                                                name="permissions[]" 
                                                                value="{{ $permission->name }}" 
                                                                id="perm_{{ $permission->id }}">
                                                            <label class="form-check-label permission-label small" for="perm_{{ $permission->id }}" data-perm-name="{{ $permission->name }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @error('permissions') <p class="text-danger small mt-2 fw-bold text-center border p-2 rounded bg-light">{{ $message }}</p> @enderror

                        {{-- সাবমিট বাটন --}}
                        <div class="mt-5 d-flex flex-wrap justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow mb-2">
                                <i data-feather="save" class="icon-md me-2"></i> Confirm & Create Role
                            </button>
                            <a href="{{ route('super.roles.index') }}" class="btn btn-secondary btn-lg ms-sm-3 mb-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // --- JS অটোমেশন: পারমিশন নামগুলোকে সুন্দর করা ---
        document.querySelectorAll('.permission-label').forEach(label => {
            const rawName = label.getAttribute('data-perm-name');
            // হাইফেন বা ডট সরিয়ে বড় হাতের অক্ষরে পরিবর্তন
            const cleanName = rawName
                .replace(/[.-]/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase());
            label.textContent = cleanName;
        });

        const checkAll = document.querySelector('#checkAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        const groupCheckboxes = document.querySelectorAll('.select-group');

        // --- ১. SELECT ALL logic ---
        checkAll.addEventListener('change', function() {
            // সব পারমিশন চেক বক্স
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
            // সব গ্রুপ চেক বক্স
            groupCheckboxes.forEach(groupCb => groupCb.checked = checkAll.checked);
        });

        // --- ২. Individual checkbox change logic (SELECT ALL আপডেট করার জন্য) ---
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allPermissionsChecked = Array.from(checkboxes).every(c => c.checked);
                checkAll.checked = allPermissionsChecked;

                // গ্রুপ চেক বক্স আপডেট করার লজিক
                const container = this.closest('.permission-group-card');
                const groupCb = container.querySelector('.select-group');
                const childCheckboxes = container.querySelectorAll('.permission-checkbox');
                const allChildChecked = Array.from(childCheckboxes).every(c => c.checked);
                groupCb.checked = allChildChecked;
            });
        });

        // --- ৩. Group Select logic ---
        groupCheckboxes.forEach(groupCb => {
            groupCb.addEventListener('change', function() {
                // এই কার্ডের ভেতরের সব চেক বক্স খুঁজে বের করা
                const container = this.closest('.permission-group-card');
                const childCheckboxes = container.querySelectorAll('.permission-checkbox');
                childCheckboxes.forEach(cb => cb.checked = groupCb.checked);

                // মেইন SELECT ALL আপডেট করার লজিক
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                checkAll.checked = allChecked;
            });
        });
    });
</script>
@endsection