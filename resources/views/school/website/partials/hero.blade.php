<div class="container-fluid p-0 mb-5 shadow-sm" style="min-height: 600px; position: relative; z-index: 1; overflow: hidden;">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($sliders as $key => $slider)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="carousel-caption d-block">
                        <div class="container h-100">
                            <div class="row align-items-center h-100 g-5">
                                <!-- Left text -->
                                <div class="col-lg-6 text-start text-white animate__animated animate__fadeInLeft">
                                    <h6 class="text-gold text-uppercase mb-3 fw-bold" style="letter-spacing: 2px; font-size: 15px;">{{ $slider->subtitle ?? 'Welcome to Our Academy' }}</h6>
                                    <h1 class="display-4 text-white mb-4 fw-bold" style="font-family: 'Outfit', sans-serif; line-height: 1.2;">{{ $slider->title ?? $school->name }}</h1>
                                    <p class="fs-6 text-white-50 mb-4 d-none d-md-block">Experience a world-class education designed to build character, inspire intellect, and prepare outstanding global citizens.</p>
                                    
                                    <div class="mt-4 d-flex flex-wrap gap-3">
                                        <a href="{{ route('admission.create', ['tenant' => $school->slug]) }}" class="btn btn-gold py-3 px-4 fw-bold">Apply Now <i class="fas fa-arrow-right ms-2"></i></a>
                                        <a href="{{ route('frontend.result_page', ['tenant' => $school->slug]) }}" class="btn btn-outline-light py-3 px-4 fw-bold">Check Result <i class="fas fa-graduation-cap ms-2"></i></a>
                                    </div>
                                </div>
                                <!-- Right image -->
                                <div class="col-lg-6 text-center animate__animated animate__fadeInRight d-none d-lg-block">
                                    <div class="hero-image-wrapper bg-white shadow-lg p-2" style="border-radius: 30px; display: inline-block; width: 90%; transform: rotate(1.5deg); transition: 0.5s;">
                                        <img class="img-fluid w-100" src="{{ asset($slider->image) }}" alt="Slider Image" style="border-radius: 25px; height: 380px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="carousel-item active">
                    <div class="carousel-caption d-block">
                        <div class="container h-100">
                            <div class="row align-items-center h-100 g-5">
                                <!-- Left text -->
                                <div class="col-lg-6 text-start text-white animate__animated animate__fadeInLeft">
                                    <h6 class="text-gold text-uppercase mb-3 fw-bold" style="letter-spacing: 2px; font-size: 15px;">Welcome to Our School</h6>
                                    <h1 class="display-4 text-white mb-4 fw-bold" style="font-family: 'Outfit', sans-serif; line-height: 1.2;">Welcome to {{ $school->name ?? 'Our School' }}</h1>
                                    <p class="fs-6 text-white-50 mb-4 d-none d-md-block">Experience a world-class education designed to build character, inspire intellect, and prepare outstanding global citizens.</p>
                                    
                                    <div class="mt-4 d-flex flex-wrap gap-3">
                                        <a href="{{ route('admission.create', ['tenant' => $school->slug]) }}" class="btn btn-gold py-3 px-4 fw-bold">Apply Now <i class="fas fa-arrow-right ms-2"></i></a>
                                        <a href="{{ route('frontend.result_page', ['tenant' => $school->slug]) }}" class="btn btn-outline-light py-3 px-4 fw-bold">Check Result <i class="fas fa-graduation-cap ms-2"></i></a>
                                    </div>
                                </div>
                                <!-- Right image -->
                                <div class="col-lg-6 text-center animate__animated animate__fadeInRight d-none d-lg-block">
                                    <div class="hero-image-wrapper bg-white shadow-lg p-2" style="border-radius: 30px; display: inline-block; width: 90%; transform: rotate(1.5deg); transition: 0.5s;">
                                        <img class="img-fluid w-100" src="{{ asset('main/img/hero.jpg') }}" alt="Default Hero" style="border-radius: 25px; height: 380px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        @if($sliders->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1) grayscale(100) brightness(200);"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1) grayscale(100) brightness(200);"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>
</div>

<style>
    .text-gold { color: #F9B800 !important; }
    .btn-gold { 
        background-color: #F9B800; 
        color: #002147; 
        border: none;
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-gold:hover { 
        background-color: #e0a500; 
        color: #002147; 
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(249, 184, 0, 0.3);
    }
    .carousel-item {
        height: 600px;
        background: linear-gradient(135deg, #00152e 0%, #002147 100%);
    }
    .carousel-caption {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: none !important;
        z-index: 10;
        padding: 0;
    }
    .hero-image-wrapper:hover {
        transform: rotate(0deg) scale(1.02) !important;
    }
    @media (max-width: 991px) {
        .carousel-item {
            height: auto;
            min-height: 450px;
            padding: 50px 0;
        }
        .carousel-caption {
            position: relative;
            height: auto;
        }
        .display-4 {
            font-size: 2.2rem !important;
        }
    }
</style>