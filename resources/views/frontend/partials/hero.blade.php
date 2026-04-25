@php
    // লুপ থেকে আসা $section এর content ডিকোড করা হচ্ছে
    $heroContent = json_decode($section->content, true);
@endphp

@if($heroContent)
    
<section class="hero-section py-5 bg-white position-relative overflow-hidden" style="padding-top: 120px !important;">
    <div class="container px-lg-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-center text-lg-start">
                <h6 class="text-primary hero-subtitle mb-3 text-uppercase">
                    {{ $heroContent['subtitle'] ?? 'Smart School ERP Solution' }}
                </h6>
                <h1 class="display-4 text-dark mb-4 lh-sm">
                    {!! $heroContent['title'] ?? 'The Most Reliable ERP Software' !!}
                </h1>
                <p class="text-muted mb-5 fs-5 px-md-5 px-lg-0">
                    {{ $heroContent['description'] ?? 'প্রতিষ্ঠানের সব কাজ এখন হবে এক ক্লিকে।' }}
                </p>
                
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <a href="{{ $heroContent['btn1_link'] ?? '#' }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg">
                        {{ $heroContent['btn1_text'] ?? 'Get Started Free' }}
                    </a>
                    <a href="{{ $heroContent['btn2_link'] ?? '#' }}" class="btn btn-outline-dark px-5 py-3 rounded-pill fw-bold">
                        {{ $heroContent['btn2_text'] ?? 'View Demo' }}
                    </a>
                </div>
                
                <div class="row mt-5 pt-4 border-top d-none d-sm-flex">
                    <div class="col-6">
                        <h4 class="fw-bold mb-0">{{ $heroContent['stat1_val'] ?? '500+' }}</h4>
                        <p class="small text-muted">Active Schools</p>
                    </div>
                    <div class="col-6 border-start">
                        <h4 class="fw-bold mb-0">{{ $heroContent['stat2_val'] ?? '24/7' }}</h4>
                        <p class="small text-muted">Technical Support</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-image-wrapper">
                    @php
                        $heroImage = isset($heroContent['image']) ? asset($heroContent['image']) : asset('frontend/img/hero.png');
                    @endphp
                    <img src="{{ $heroImage }}" class="img-fluid animate-up-down" alt="EduCorexa Hero">
                </div>
            </div>
        </div>
    </div>
</section>
@endif