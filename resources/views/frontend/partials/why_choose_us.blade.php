@php
    // ডাটাবেজ থেকে কন্টেন্ট ডিকোড করা
    $section = \App\Models\FrontendSection::where('key', 'why_choose_us')->first();
    $content = json_decode($section->content ?? '{}', true);
@endphp

<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="{{ asset($content['image'] ?? 'frontend/img/hero.jpg') }}" 
                     class="img-fluid rounded-4 shadow floating-animation" 
                     alt="Features">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">
                    {!! $content['title'] ?? 'Why Choose <span class="text-primary">EduCorexa</span> ERP?' !!}
                </h2>
                <p class="text-muted mb-4">
                    {{ $content['description'] ?? 'আমরা শুধুমাত্র একটি সফটওয়্যার দিই না, আমরা দিচ্ছি একটি পূর্ণাঙ্গ এডুকেশন ইকোসিস্টেম।' }}
                </p>
                
                <div class="d-flex mb-3">
                    <i class="bi bi-patch-check-fill text-success fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $content['point1_title'] ?? '100% Secure & Reliable' }}</h6>
                        <p class="small text-muted">{{ $content['point1_desc'] ?? 'আপনার ডাটা আমাদের কাছে একদম নিরাপদ।' }}</p>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <i class="bi bi-patch-check-fill text-success fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $content['point2_title'] ?? 'User Friendly Interface' }}</h6>
                        <p class="small text-muted">{{ $content['point2_desc'] ?? 'সহজ ইউজার ইন্টারফেস, যা যে কেউ ব্যবহার করতে পারবে।' }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ $content['btn_link'] ?? '#contact' }}" class="btn btn-primary px-4 py-2">
                        {{ $content['btn_text'] ?? 'Read More' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>