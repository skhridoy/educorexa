@php
    // ডাটাবেজ থেকে কন্টেন্ট ডিকোড করা
    $section = \App\Models\FrontendSection::where('key', 'why_choose_us')->first();
    $content = json_decode($section->content ?? '{}', true);
@endphp

<section class="py-5 position-relative bg-white">
    <div class="container py-lg-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="pe-lg-5">
                    <div class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill mb-3 small fw-bold">
                        WHY CHOOSE US
                    </div>
                    <h2 class="display-6 fw-bold mb-4 lh-sm text-dark">
                        {!! str_replace('EduCorexa', '<span class="gradient-text">EduCorexa</span>', $content['title'] ?? 'Why Choose <span class="gradient-text">EduCorexa</span> ERP?') !!}
                    </h2>
                    <p class="text-muted mb-5 fs-6" style="line-height: 1.8;">
                        {{ $content['description'] ?? 'আমরা শুধুমাত্র একটি সফটওয়্যার দিই না, আমরা দিচ্ছি একটি পূর্ণাঙ্গ এডুকেশন ইকোসিস্টেম।' }}
                    </p>
                    
                    <div class="d-flex flex-column gap-4 mb-5">
                        <div class="p-4 rounded-4 bg-white shadow-sm border border-light shadow-lg-hover d-flex gap-3 align-items-start transition-all">
                            <div class="icon-circle bg-success bg-opacity-10 text-success shadow-sm flex-shrink-0" style="width: 50px; height: 50px;">
                                <i class="bi bi-shield-check fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2 text-dark">{{ $content['point1_title'] ?? '100% Secure & Reliable' }}</h5>
                                <p class="small text-muted mb-0 lh-base">{{ $content['point1_desc'] ?? 'আপনার ডাটা আমাদের কাছে একদম নিরাপদ।' }}</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-4 bg-white shadow-sm border border-light shadow-lg-hover d-flex gap-3 align-items-start transition-all">
                            <div class="icon-circle bg-primary-soft text-primary shadow-sm flex-shrink-0" style="width: 50px; height: 50px; background-color: rgba(79, 70, 229, 0.1);">
                                <i class="bi bi-laptop fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2 text-dark">{{ $content['point2_title'] ?? 'User Friendly Interface' }}</h5>
                                <p class="small text-muted mb-0 lh-base">{{ $content['point2_desc'] ?? 'সহজ ইউজার ইন্টারফেস, যা যে কেউ ব্যবহার করতে পারবে।' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="{{ $content['btn_link'] ?? '#contact' }}" class="btn px-5 py-3 rounded-pill fw-bold shadow-lg-hover text-white d-inline-flex align-items-center" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border: none;">
                            {{ $content['btn_text'] ?? 'Read More' }} <i class="bi bi-arrow-right-short fs-4 ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="position-relative p-4">
                    <!-- Background decoration -->
                    <div class="position-absolute top-50 start-50 translate-middle w-100 h-100 rounded-circle bg-info opacity-10 animate-up-down" style="filter: blur(50px); z-index: 0;"></div>
                    
                    <img src="{{ asset($content['image'] ?? 'frontend/img/hero.jpg') }}" 
                         class="img-fluid rounded-4 position-relative z-1 animate-down-up" 
                         alt="Features" style="filter: drop-shadow(0 25px 35px rgba(0,0,0,0.1));">
                         
                    <!-- Floating mini card -->
                    <div class="position-absolute bottom-0 start-0 translate-middle-x mb-5 z-2 glass-card p-3 rounded-4 shadow-lg d-none d-md-flex align-items-center gap-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">Top Rated</h6>
                            <p class="mb-0 x-small text-muted">ERP Solution</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>