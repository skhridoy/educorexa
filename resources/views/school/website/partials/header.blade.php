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
    <div class="container-fluid py-2 py-lg-0">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
            @if($school && $school->logo)
                <img src="{{ asset($school->logo) }}" alt="Logo" style="height: 45px;" class="me-2">
            @endif
            <h2 class="m-0 text-navy fw-bold school-name-text d-none d-lg-inline" style="font-size: 1.5rem;">{{ $school->name ?? 'Edu Corexa' }}</h2>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            @php
                $isHome = request()->routeIs('school.home');
                $homeUrl = route('school.home', ['tenant' => $school->slug]);
            @endphp
            <div class="navbar-nav ms-auto py-4 py-lg-0">
                <a href="{{ $isHome ? '#home' : $homeUrl }}" class="nav-item nav-link {{ $isHome ? 'active' : '' }}">Home</a>
                <a href="{{ $isHome ? '#about' : $homeUrl . '#about' }}" class="nav-item nav-link">About</a>
                <a href="{{ route('frontend.result_page', ['tenant' => $school->slug]) }}" class="nav-item nav-link {{ request()->routeIs('frontend.result_page') ? 'active' : '' }}">Result</a>
                <a href="{{ route('frontend.notice', ['tenant' => $school->slug]) }}" class="nav-item nav-link">Notice</a>
                <a href="{{ $isHome ? '#overview' : $homeUrl . '#overview' }}" class="nav-item nav-link">Academic</a>
                <a href="{{ $isHome ? '#contact' : $homeUrl . '#contact' }}" class="nav-item nav-link">Contact</a>
            </div>
            @auth
                @php
                    $user = auth()->user();
                    $tenant = $school->slug ?? ($user->school->slug ?? '');
                    $dashboardRoute = match($user->role) {
                        'student' => route('student.dashboard', ['tenant' => $tenant]),
                        'teacher' => route('teacher.dashboard', ['tenant' => $tenant]),
                        'school_admin' => route('school.dashboard', ['tenant' => $tenant]),
                        default => '#'
                    };
                @endphp
                <a href="{{ $dashboardRoute }}" class="btn btn-navy rounded-pill py-2 px-4 ms-lg-3 d-inline-block">Dashboard</a>
            @else
                <a href="{{ $school ? route('school.login.form', ['tenant' => $school->slug]) : '#' }}" class="btn btn-navy rounded-pill py-2 px-4 ms-lg-3 d-inline-block">Login</a>
            @endauth
        </div>
    </div>
</nav>

<style>
    .bg-navy { background-color: #002147 !important; }
    .text-navy { color: #002147 !important; }
    /* Premium Button Style */
    .btn-navy { 
        background: linear-gradient(135deg, #002147 0%, #003366 100%) !important;
        color: #fff !important; 
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 33, 71, 0.2);
        transition: all 0.3s ease !important;
        font-weight: 600;
    }
    
    .btn-navy:hover { 
        background: #F9B800 !important; 
        color: #002147 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(249, 184, 0, 0.3);
    }

    /* Navbar Link Styling */
    .navbar-light .navbar-nav .nav-link {
        color: #002147 !important;
        font-weight: 600;
        padding: 25px 15px;
        position: relative;
        transition: 0.3s;
    }
    
    .navbar-light .navbar-nav .nav-link:hover,
    .navbar-light .navbar-nav .nav-link.active {
        color: #F9B800 !important;
    }

    @media (min-width: 992px) {
        .navbar-light .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 20px;
            left: 15px;
            background-color: #F9B800;
            transition: 0.3s;
            border-radius: 10px;
        }
        .navbar-light .navbar-nav .nav-link:hover::after,
        .navbar-light .navbar-nav .nav-link.active::after {
            width: calc(100% - 30px);
        }
    }

    /* Sticky Navbar Polish */
    .sticky-top.navbar {
        box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important;
    }

    @media (max-width: 991.98px) {
        .navbar-light .navbar-nav .nav-link {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0,33,71,0.05);
        }
        .navbar-brand img {
            height: 40px !important;
        }
        .btn-navy {
            margin: 15px;
            display: block;
            text-align: center;
        }
    }
</style>