<!-- Top Bar -->
<div class="container-fluid bg-navy px-5 d-none d-lg-block">
    <div class="row gx-0 align-items-center" style="height: 45px;">
        <div class="col-lg-8 text-start">
            <div class="d-inline-flex align-items-center me-4 text-white small">
                <i class="fa fa-phone-alt me-2"></i>{{ $school->phone ?? '+880 1XXX XXXXXX' }}
            </div>
            <div class="d-inline-flex align-items-center text-white small">
                <i class="fa fa-envelope-open me-2"></i>{{ $school->email ?? 'info@school.edu.bd' }}
            </div>
        </div>
        <div class="col-lg-4 text-end">
            <div class="d-inline-flex align-items-center">
                <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="#"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle" href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 px-4 px-lg-5">
    <div class="container-fluid d-flex justify-content-between align-items-center py-2 py-lg-0">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
            @if($school && $school->logo)
                <img src="{{ asset($school->logo) }}" alt="Logo" style="height: 45px;" class="me-2">
            @endif
            <h2 class="m-0 text-navy fw-bold school-name-text d-none d-lg-inline" style="font-size: 1.5rem;">{{ $school->name ?? 'Edu Corexa' }}</h2>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse px-4 px-lg-0" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-4 py-lg-0">
            <a href="#home" class="nav-item nav-link active">Home</a>
            <a href="{{ $school ? route('school.about', ['tenant' => $school->slug]) : '#' }}" class="nav-item nav-link">About</a>
            <a href="#notice" class="nav-item nav-link">Notice</a>
            <a href="#overview" class="nav-item nav-link">Academic</a>
            <a href="#contact" class="nav-item nav-link">Contact</a>
        </div>
        @auth
            @php
                $user = auth()->user();
                $tenant = $user->school->slug ?? ($school->slug ?? '');
                $dashboardRoute = match($user->role) {
                    'student' => route('student.dashboard', ['tenant' => $tenant]),
                    'teacher' => route('teacher.dashboard', ['tenant' => $tenant]),
                    'school_admin' => route('school.dashboard', ['tenant' => $tenant]),
                    default => '#'
                };
            @endphp
            <a href="{{ $dashboardRoute }}" class="btn btn-navy rounded-pill py-2 px-4 ms-lg-3">Dashboard</a>
        @else
            <a href="{{ $school ? route('school.login.form', ['tenant' => $school->slug]) : route('login') }}" class="btn btn-navy rounded-pill py-2 px-4 ms-lg-3">Login</a>
        @endauth
    </div>
</nav>

<style>
    .bg-navy { background-color: #002147 !important; }
    .text-navy { color: #002147 !important; }
    .btn-navy { 
        background-color: #002147; 
        color: #fff; 
        border: none;
        transition: 0.3s;
    }
    .btn-navy:hover { 
        background-color: #F9B800; 
        color: #002147; 
    }
    .navbar-light .navbar-nav .nav-link {
        color: #002147;
        font-weight: 600;
        padding: 25px 15px;
    }
    .navbar-light .navbar-nav .nav-link:hover,
    .navbar-light .navbar-nav .nav-link.active {
        color: #F9B800;
    }
    @media (max-width: 991.98px) {
        .navbar-light .navbar-nav .nav-link {
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
        }
        .navbar-brand img {
            height: 40px !important;
        }
    }
</style>