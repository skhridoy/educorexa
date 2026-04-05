<div class="container-xxl position-relative p-0" id="home">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="{{ url('/') }}" class="navbar-brand p-0 d-flex align-items-center">
            @if($school && $school->logo)
                <img src="{{ asset($school->logo) }}" alt="Logo" class="school-logo me-2">
            @endif
            
            <h3 class="m-0 school-name">
                {{ $school->name ?? 'Edu Corexa' }}
            </h3>
        </a>
        <button class="navbar-toggler rounded-pill collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-expanded="false">
            <span class="fa fa-bars"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto py-0">
                <a href="#home" class="nav-item nav-link active">Home</a>
                {{-- এখানে optional() ব্যবহার করা হয়েছে যেন $school না থাকলেও এরর না দেয় --}}
                <a href="{{ $school ? route('school.about', ['tenant' => $school->slug]) : '#' }}" class="nav-item nav-link">About Us</a>
                <a href="#features" class="nav-item nav-link">Notice Board</a>
                <a href="#overview" class="nav-item nav-link">Academic</a>
                <a href="#contact" class="nav-item nav-link">Contact</a>
            </div>

            @auth
                @php
                    $user = auth()->user();
                    // যদি ইউজার লগইন থাকে, তবে তার স্কুল থেকেই স্লাগ নেওয়া ভালো
                    $tenant = $user->school->slug ?? ($school->slug ?? '');
                        
                    $dashboardRoute = match($user->role) {
                        'student' => route('student.dashboard', ['tenant' => $tenant]),
                        'teacher' => route('teacher.dashboard', ['tenant' => $tenant]),
                        'school_admin' => route('school.dashboard', ['tenant' => $tenant]),
                        default => '#'
                    };
                @endphp
                <a href="{{ $dashboardRoute }}" class="btn btn-light rounded-pill py-2 px-4 d-lg-block">Dashboard</a>
            @else
                {{-- লগইন বাটনের ক্ষেত্রেও একটি চেক বসানো হয়েছে --}}
                @if($school)
                    <a href="{{ route('school.login.form', ['tenant' => $school->slug]) }}" class="btn btn-light rounded-pill py-2 px-4 d-lg-block">Login</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light rounded-pill py-2 px-4 d-lg-block">Login</a>
                @endif
            @endauth
        </div>
    </nav>
</div>