@extends('layouts.main')

@section('customCSS')
<style>
    /* ফোনের আইকন পজিশন ঠিক করা */
    .phone-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        display: none;
        z-index: 5;
    }
    .phone-valid { color: #28a745; }
    .phone-invalid { color: #dc3545; }
    
    /* স্পিন বাটন হাইড করা */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance: textfield; }
</style>
@endsection

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add School</li>
        </ol>
    </nav>

    <form action="{{ route('super.schools.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- School Information --}}
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-primary"><i data-feather="home" class="icon-sm me-2"></i>School Information</h6>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="schoolNameId">School Name <span class="text-danger">*</span></label>
                            <input type="text" name="school_name" id="schoolNameId" 
                                   class="form-control @error('school_name') is-invalid @enderror" 
                                   placeholder="e.g. Dhaka Model High School" value="{{ old('school_name') }}">
                            @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="slugId">School Domain (Subdomain) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="slug" id="slugId" 
                                       class="form-control @error('slug') is-invalid @enderror" 
                                       placeholder="abcschool" value="{{ old('slug') }}" required>
                                <span class="input-group-text bg-light fw-bold text-muted">{{ $mainDomain }}</span>
                            </div>
                            <small class="text-muted">Use only lowercase letters and numbers (no spaces).</small>
                            @error('slug') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Admin Information --}}
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-primary"><i data-feather="user" class="icon-sm me-2"></i>Admin Information</h6>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="adminNameId">Admin Name <span class="text-danger">*</span></label>
                            <input type="text" name="admin_name" id="adminNameId" 
                                   class="form-control @error('admin_name') is-invalid @enderror" 
                                   placeholder="Full Name" value="{{ old('admin_name') }}">
                            @error('admin_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="adminEmailId">Admin Email <span class="text-danger">*</span></label>
                            <input type="email" name="admin_email" id="adminEmailId" 
                                   class="form-control @error('admin_email') is-invalid @enderror" 
                                   placeholder="admin@school.com" value="{{ old('admin_email') }}">
                            @error('admin_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" name="admin_mobile" id="numberId" 
                                       class="form-control pe-5 @error('admin_mobile') is-invalid @enderror" 
                                       placeholder="01XXXXXXXXX" maxlength="11" 
                                       oninput="validatePhone(this)" value="{{ old('admin_mobile') }}">
                                <span id="phoneIcon" class="phone-icon"></span>
                            </div>
                            @error('admin_mobile') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="adminPasswordId">Admin Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="admin_password" id="adminPasswordId" 
                                       class="form-control @error('admin_password') is-invalid @enderror" 
                                       placeholder="Minimum 8 characters">
                                <button class="btn btn-outline-secondary" type="button" id="togglePass">
                                    <i data-feather="eye" class="icon-sm"></i>
                                </button>
                            </div>
                            @error('admin_password') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                    <i data-feather="plus-circle" class="icon-sm me-1"></i> Create School & Domain
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('customJs')
{{-- SweetAlert Messages --}}
@if(session('success') || session('error') || session('duplicate'))
<script>
    Swal.fire({
        icon: "{{ session('success') ? 'success' : 'error' }}",
        title: "{{ session('success') ? 'Success!' : (session('duplicate') ? 'Duplicate Entry!' : 'Error!') }}",
        text: "{{ session('success') ?? session('error') ?? session('duplicate') }}",
    });
</script>
@endif

<script>
    // ১. অটোমেটিক স্লাগ (Domain) জেনারেশন
    document.getElementById('schoolNameId').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase()
                       .replace(/[^a-z0-9]/g, '') // স্পেস এবং স্পেশাল ক্যারেক্টার রিমুভ
                       .substring(0, 20); // ম্যাক্স লেন্থ ২০
        document.getElementById('slugId').value = slug;
    });

    // ২. পাসওয়ার্ড টগল
    document.getElementById('togglePass').addEventListener('click', function() {
        const passInput = document.getElementById('adminPasswordId');
        const icon = this.querySelector('i');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.setAttribute('data-feather', 'eye-off');
        } else {
            passInput.type = 'password';
            icon.setAttribute('data-feather', 'eye');
        }
        feather.replace();
    });

    // ৩. ফোন ভ্যালিডেশন
    function validatePhone(input){
        let icon = document.getElementById('phoneIcon');
        input.value = input.value.replace(/[^0-9]/g,'');
        let isValid = /^01[0-9]{9}$/.test(input.value);

        if(isValid){
            icon.style.display = 'block';
            icon.innerHTML = '✔';
            icon.className = 'phone-icon phone-valid';
        } else if(input.value.length > 0){
            icon.style.display = 'block';
            icon.innerHTML = '✖';
            icon.className = 'phone-icon phone-invalid';
        } else {
            icon.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if(typeof feather !== 'undefined') feather.replace();
    });
</script>
@endsection