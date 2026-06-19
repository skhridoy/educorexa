@extends('app-layouts.frontend')

@section('content')
<section class="register-section position-relative overflow-hidden">
    <!-- Background Decor -->
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>
    
    <div class="container position-relative z-1 py-5">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-xl-10 col-lg-11">
                <div class="register-card shadow-lg rounded-5 overflow-hidden bg-white border-0 my-5">
                    <div class="row g-0">
                        
                        <!-- Left Info Panel -->
                        <div class="col-lg-5 text-white p-5 d-none d-lg-flex flex-column justify-content-center info-panel position-relative">
                            <div class="overlay"></div>
                            <div class="position-relative z-1">
                                <div class="brand-logo mb-5">
                                    <h2 class="fw-black text-white tracking-tighter italic mb-0" style="font-weight: 900; font-size: 2.2rem;">edu<span class="text-gold">corexa</span></h2>
                                </div>
                                <h3 class="fw-bold mb-3 lh-base">Launch Your Digital School Today</h3>
                                <p class="opacity-75 mb-4 pb-2" style="font-size: 15px;">Join thousands of schools streamlining their administration with our powerful ERP system.</p>
                                
                                <div class="feature-list mt-2">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-box-sm bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                            <i class="bi bi-check2 text-success fs-5"></i>
                                        </div>
                                        <span class="text-white-50 fw-medium">Automated Results & Grading</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-box-sm bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                            <i class="bi bi-check2 text-success fs-5"></i>
                                        </div>
                                        <span class="text-white-50 fw-medium">Real-time Attendance Tracking</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-box-sm bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                            <i class="bi bi-check2 text-success fs-5"></i>
                                        </div>
                                        <span class="text-white-50 fw-medium">Secure Cloud Backup</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box-sm bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                            <i class="bi bi-check2 text-success fs-5"></i>
                                        </div>
                                        <span class="text-white-50 fw-medium">Seamless Parent Communication</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Form Panel -->
                        <div class="col-lg-7 p-4 p-md-5">
                            <div class="form-wrapper pe-lg-3 ps-lg-3">
                                <div class="text-center text-lg-start mb-4 pb-2">
                                    <h3 class="fw-bold text-dark mb-2">Create Workspace</h3>
                                    <p class="text-muted small">Fill out the form below to setup your school.</p>
                                </div>

                                <!-- Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                                        <ul class="mb-0 small">
                                            @foreach($errors->all() as $error)
                                                <li><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('school.register.store') }}" class="register-form">
                                    @csrf

                                    <div class="row g-3 g-md-4">
                                        <div class="col-12">
                                            <div class="form-floating custom-floating">
                                                <input type="text" name="school_name" class="form-control" id="school_name" placeholder="ABC High School" value="{{ old('school_name') }}" required>
                                                <label for="school_name"><i class="bi bi-building me-2 text-muted"></i>School Name</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-secondary mb-1 ps-1">Login Subdomain</label>
                                            <div class="input-group custom-input-group shadow-sm">
                                                <span class="input-group-text bg-white border-end-0 text-muted px-3"><i class="bi bi-globe"></i></span>
                                                <input type="text" name="slug" id="slug" class="form-control border-start-0 border-end-0 ps-0 fw-semibold text-dark" placeholder="abcschool" value="{{ old('slug') }}" required autocomplete="off">
                                                <span class="input-group-text bg-light text-muted fw-bold border-start-0 pe-3" style="font-size: 14px;">.{{ request()->getHost() }}</span>
                                            </div>
                                            <small class="text-muted mt-2 d-block ps-1" style="font-size: 0.75rem;">Your portal will be at: <span class="text-primary fw-bold" id="preview-url">abcschool.{{ request()->getHost() }}</span></small>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating custom-floating">
                                                <input type="text" name="admin_name" class="form-control" id="admin_name" placeholder="Admin Name" value="{{ old('admin_name') }}" required>
                                                <label for="admin_name"><i class="bi bi-person-badge me-2 text-muted"></i>Admin Name</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating custom-floating">
                                                <input type="email" name="admin_email" class="form-control" id="admin_email" placeholder="Email" value="{{ old('admin_email') }}" required>
                                                <label for="admin_email"><i class="bi bi-envelope me-2 text-muted"></i>Email Address</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-floating custom-floating">
                                                <select name="package_id" class="form-select fw-semibold text-dark" id="package_id" required>
                                                    <option value="" disabled {{ old('package_id') ? '' : 'selected' }}>Choose a Package</option>
                                                    @if(isset($packages))
                                                        @foreach($packages as $package)
                                                            <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                                                {{ $package->name }} - ৳{{ number_format($package->price) }} / {{ ucfirst($package->duration) }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="package_id"><i class="bi bi-box-seam me-2 text-muted"></i>Subscription Package</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-floating custom-floating">
                                                <input type="password" name="admin_password" class="form-control" id="admin_password" placeholder="Password" required>
                                                <label for="admin_password"><i class="bi bi-shield-lock me-2 text-muted"></i>Password</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button class="btn btn-premium w-100 py-3 fw-bold rounded-3 shadow-sm d-flex justify-content-center align-items-center gap-2" type="submit" style="font-size: 16px;">
                                                Complete Registration <i class="bi bi-arrow-right-short fs-4 lh-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="mt-4 pt-2 text-center border-top">
                                    <p class="text-muted small mt-3">Already have an account? <a href="{{ route('login.form') }}" class="text-primary fw-bold text-decoration-none ms-1">Login here</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Section Background */
    .register-section {
        background-color: #f4f7fe;
        min-height: 100vh;
        padding-top: 60px;
    }
    
    .bg-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
    }
    .bg-shape-1 {
        width: 500px;
        height: 500px;
        background: rgba(101, 113, 255, 0.15);
        top: -150px;
        left: -100px;
    }
    .bg-shape-2 {
        width: 400px;
        height: 400px;
        background: rgba(249, 184, 0, 0.12);
        bottom: 5%;
        right: -100px;
    }

    /* Info Panel Gradient */
    .info-panel {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        overflow: hidden;
    }
    .info-panel .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(circle at top right, rgba(101, 113, 255, 0.25) 0%, transparent 60%);
        z-index: 0;
    }
    .text-gold { color: #F9B800 !important; }
    
    /* Inputs */
    .custom-floating .form-control, .custom-floating .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        height: calc(3.7rem + 2px);
        padding: 1rem 1.25rem;
        font-size: 14.5px;
        background-color: #fcfcfd;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #1e293b;
        font-weight: 500;
    }
    .custom-floating .form-control:focus, .custom-floating .form-select:focus {
        border-color: #6571ff;
        box-shadow: 0 0 0 4px rgba(101, 113, 255, 0.1);
        background-color: #fff;
    }
    .custom-floating label {
        padding: 1.1rem 1.25rem;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }

    /* Input Group */
    .custom-input-group {
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .custom-input-group:focus-within {
        box-shadow: 0 0 0 4px rgba(101, 113, 255, 0.1) !important;
    }
    .custom-input-group .form-control {
        border: 1px solid #e2e8f0;
        padding: 0.95rem 1rem;
        font-size: 15px;
        background-color: #fcfcfd;
        box-shadow: none !important;
        letter-spacing: 0.5px;
    }
    .custom-input-group:focus-within .form-control,
    .custom-input-group:focus-within .input-group-text {
        border-color: #6571ff;
        background-color: #fff;
    }
    .custom-input-group .input-group-text {
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.3s ease;
    }

    /* Button */
    .btn-premium {
        background: linear-gradient(135deg, #6571ff 0%, #4a54e5 100%);
        color: white;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(101, 113, 255, 0.5) !important;
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slugInput = document.getElementById('slug');
        const previewUrl = document.getElementById('preview-url');
        const host = "{{ request()->getHost() }}";
        
        slugInput.addEventListener('input', function() {
            // Remove non-alphanumeric characters
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
            const val = this.value || 'abcschool';
            previewUrl.textContent = `${val}.${host}`;
        });
    });
</script>
@endsection