@php
    // লুপ থেকে আসা $section এর content ডিকোড করা হচ্ছে
    $heroContent = json_decode($section->content, true);
@endphp

@if($heroContent)
    
<section class="hero-section py-5 position-relative overflow-hidden" style="padding-top: 140px !important; background: linear-gradient(180deg, var(--bg-color) 0%, #EEF2FF 100%);">
    <!-- Abstract Blobs -->
    <div class="position-absolute top-0 start-0 translate-middle rounded-circle bg-primary opacity-10" style="width: 500px; height: 500px; filter: blur(80px); z-index: 0;"></div>
    <div class="position-absolute bottom-0 end-0 translate-middle-y rounded-circle bg-info opacity-10" style="width: 400px; height: 400px; filter: blur(60px); z-index: 0;"></div>
    
    <div class="container px-lg-5 position-relative" style="z-index: 1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-center text-lg-start">
                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill mb-4 glass-card border-primary shadow-sm" style="border-color: rgba(79, 70, 229, 0.2) !important;">
                    <span class="badge bg-primary rounded-pill me-2">New</span>
                    <span class="text-primary fw-semibold small">{{ $heroContent['subtitle'] ?? 'Smart School ERP Solution' }}</span>
                </div>
                
                <h1 class="display-4 mb-4 lh-sm fw-bolder text-dark">
                    {!! $heroContent['title'] ?? 'The Most Reliable <span class="gradient-text">ERP Software</span>' !!}
                </h1>
                <p class="text-muted mb-5 fs-5 px-md-5 px-lg-0" style="max-width: 600px; line-height: 1.8;">
                    {{ $heroContent['description'] ?? 'প্রতিষ্ঠানের সব কাজ এখন হবে এক ক্লিকে।' }}
                </p>
                
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <a href="{{ $heroContent['btn1_link'] ?? '#' }}" class="btn px-5 py-3 rounded-pill fw-bold shadow-lg-hover text-white d-flex align-items-center" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border: none;">
                        {{ $heroContent['btn1_text'] ?? 'Get Started Free' }} <i class="bi bi-arrow-right-short fs-4 ms-1"></i>
                    </a>
                    <a target="_blank" href="{{ $heroContent['btn2_link'] ?? '#' }}" class="btn glass-card px-5 py-3 rounded-pill fw-bold shadow-lg-hover text-dark border-0 d-flex align-items-center">
                        <i class="bi bi-play-circle-fill text-primary fs-5 me-2"></i> {{ $heroContent['btn2_text'] ?? 'View Demo' }}
                    </a>
                </div>
                
                <div class="row mt-5 pt-4 d-none d-sm-flex">
                    <div class="col-6 col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white text-primary shadow-sm me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-buildings"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $heroContent['stat1_val'] ?? '500+' }}</h4>
                                <p class="small text-muted mb-0">Active Schools</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-5">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white text-primary shadow-sm me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $heroContent['stat2_val'] ?? '24/7' }}</h4>
                                <p class="small text-muted mb-0">Technical Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-image-wrapper position-relative">
                    <!-- Image Backdrop -->
                    <div class="position-absolute top-50 start-50 translate-middle w-100 h-100 bg-primary opacity-10 rounded-circle" style="filter: blur(40px);"></div>
                    @php
                        $heroImage = isset($heroContent['image']) ? asset($heroContent['image']) : asset('frontend/img/hero.png');
                    @endphp
                    <img src="{{ $heroImage }}" class="img-fluid animate-up-down position-relative z-1 drop-shadow-2xl" alt="EduCorexa Hero" style="filter: drop-shadow(0 20px 30px rgba(0,0,0,0.15));">
                </div>
            </div>
        </div>
    </div>
</section>
@endif