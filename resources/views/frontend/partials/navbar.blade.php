<div class="container-xxl position-relative p-0" id="home">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="/" class="navbar-brand p-0">
            @if($setting && $setting->logo_wide)
                <img src="{{ asset($setting->logo_wide) }}" alt="{{ $setting->site_name }}">
            @else
                <h1 class="m-0 text-primary">{{ $setting->site_name ?? 'EduCorexa' }}</h1>
            @endif
        </a>
        <button class="navbar-toggler rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto py-0">
                <a href="#home" class="nav-item nav-link active">Home</a>
                <a href="#about" class="nav-item nav-link">About</a>
                <a href="#features" class="nav-item nav-link">Features</a>
                <a href="#pricing" class="nav-item nav-link">Pricing</a>
                <a href="#contact" class="nav-item nav-link">Contact</a>
            </div>
            <a href="{{ route('school.register.form') }}" class="btn btn-light rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Register School</a>
        </div>
    </nav>
</div>