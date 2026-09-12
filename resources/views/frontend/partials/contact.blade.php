@php
    // ডাটাবেজ থেকে কন্টাক্ট সেকশনের ডাটা আনা
    $section = \App\Models\FrontendSection::where('key', 'contact')->first();
    $content = json_decode($section->content ?? '{}', true);
@endphp

<section id="contact" class="py-5 bg-light">
    <div class="container py-lg-5">
        <div class="row g-5 align-items-center">
            {{-- বাম পাশের কন্টাক্ট ইনফো --}}
            <div class="col-lg-5">
                <div class="contact-info-card">
                    <h6 class="text-primary fw-bold text-uppercase mb-3 small" style="letter-spacing: 2px;">
                        {{ $content['subtitle'] ?? 'Contact Us' }}
                    </h6>
                    <h2 class="fw-bold text-dark mb-4">
                        {!! $content['title'] ?? 'Ready to Transform Your <span class="text-primary">Institution?</span>' !!}
                    </h2>
                    <p class="text-muted mb-4">
                        {{ $content['description'] ?? 'আমাদের প্রতিনিধির সাথে বিস্তারিত জানতে ফর্মটি পূরণ করুন।' }}
                    </p>

                    {{-- অফিস লোকেশন --}}
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box bg-white shadow-sm rounded-3 p-3 me-3 text-primary">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Our Office</h6>
                            <p class="text-muted small mb-0">{{ $content['address'] ?? 'Dhaka, Bangladesh' }}</p>
                        </div>
                    </div>

                    {{-- ফোন নম্বর --}}
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box bg-white shadow-sm rounded-3 p-3 me-3 text-primary">
                            <i class="bi bi-telephone-plus-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Direct Call</h6>
                            <p class="text-muted small mb-0">{{ $content['phone'] ?? '+880 1234 567890' }}</p>
                        </div>
                    </div>

                    {{-- ইমেইল --}}
                    <div class="d-flex align-items-start">
                        <div class="icon-box bg-white shadow-sm rounded-3 p-3 me-3 text-primary">
                            <i class="bi bi-envelope-check-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email Address</h6>
                            <p class="text-muted small mb-0">{{ $content['email'] ?? 'support@educorexa.com' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ডান পাশের ফর্ম সেকশন --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-lg-5">
                    {{-- ফর্মটি আপনার লিড কালেকশন রাউটে হিট করবে --}}
                    {{-- Alerts --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i><strong>ধন্যবাদ!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>ত্রুটি!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i><strong>অনুগ্রহ করে ভুলগুলো সংশোধন করুন:</strong>
                            <ul class="mb-0 mt-1 ps-3 small">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @php
                        $captcha_n1 = rand(2, 9);
                        $captcha_n2 = rand(1, 9);
                        $captcha_token = encrypt(($captcha_n1 + $captcha_n2) . '|' . time());
                    @endphp

                    <form action="{{ route('contact.store') }}" method="POST" id="mainContactForm">
                        @csrf
                        {{-- Honeypot field to trap spam bots --}}
                        <div style="display:none !important;" aria-hidden="true">
                            <input type="text" name="b_field" value="" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">আপনার নাম <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control bg-light border-0 py-3 px-4 rounded-3 @error('name') is-invalid @enderror" placeholder="Full Name" required>
                                @error('name')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">মোবাইল নাম্বার <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" 
                                       class="form-control bg-light border-0 py-3 px-4 rounded-3 @error('phone') is-invalid @enderror" 
                                       placeholder="017XXXXXXXX" 
                                       pattern="^(?:\+?8801|8801|01)[3-9][0-9]{8}$"
                                       title="অনুগ্রহ করে সঠিক ১১ ডিজিটের মোবাইল নম্বর লিখুন (যেমন: 017XXXXXXXX)"
                                       maxlength="14" 
                                       required
                                       oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                                <div class="form-text text-muted small" style="font-size: 0.75rem;">
                                    ১১ ডিজিটের সঠিক নম্বর দিন (যেমন: 017XXXXXXXX)
                                </div>
                                @error('phone')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- School Name --}}
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-dark">প্রতিষ্ঠানের নাম (যদি থাকে)</label>
                                <input type="text" name="school_name" value="{{ old('school_name') }}" class="form-control bg-light border-0 py-3 px-4 rounded-3" placeholder="School/College Name">
                            </div>

                            {{-- Message --}}
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-dark">আপনি কী জানতে চান?</label>
                                <textarea name="message" class="form-control bg-light border-0 py-3 px-4 rounded-3" rows="3" placeholder="Tell us more...">{{ old('message') }}</textarea>
                            </div>

                            {{-- Human Verification (Captcha) --}}
                            <div class="col-12">
                                <div class="p-3 rounded-3 border" style="background:#f8fafc; border: 1.5px solid #e2e8f0 !important;">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:36px; height:36px; border-radius:10px; background:#e0e7ff; color:#4f46e5; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                                <i class="bi bi-shield-check" style="font-size: 1.15rem;"></i>
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-dark mb-0 d-block">
                                                    হিউম্যান ভেরিফিকেশন <span class="text-danger">*</span>
                                                </label>
                                                <span class="text-muted small" style="font-size: 0.78rem;">রোবট রোধে যোগফলটি লিখুন:</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 ms-auto ms-sm-0">
                                            <div class="px-3 py-2 rounded-3 fw-bold border shadow-sm text-primary" style="background:#ffffff; font-size:1.15rem; letter-spacing:1.5px; border-color:#cbd5e1 !important; user-select:none;">
                                                {{ $captcha_n1 }} + {{ $captcha_n2 }} = ?
                                            </div>
                                            <input type="hidden" name="captcha_token" value="{{ $captcha_token }}">
                                            <input type="number" name="captcha_answer" 
                                                   class="form-control bg-white border py-2 px-3 rounded-3 text-center fw-bold @error('captcha_answer') is-invalid @enderror" 
                                                   style="width: 85px; font-size: 1rem; border-color: #cbd5e1 !important;" 
                                                   placeholder="উত্তর" 
                                                   required 
                                                   min="0" 
                                                   max="99">
                                        </div>
                                    </div>
                                    @error('captcha_answer')
                                        <span class="text-danger small mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit button --}}
                            <div class="col-md-12">
                                <button type="submit" id="contactSubmitBtn" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg-hover mt-2">
                                    Request a Call Back <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <p class="text-center text-muted x-small mt-4 mb-0">
                        <i class="bi bi-shield-lock me-1 text-success"></i> আপনার তথ্য সম্পূর্ণ সুরক্ষিত এবং এনক্রিপ্ট করা।
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* আইকন এবং হোভার ইফেক্ট */
    .icon-box {
        width: 60px; height: 60px;
        display: flex; align-items: center; justify-content: center;
        transition: 0.3s;
    }
    .contact-info-card .icon-box:hover {
        background: #6571ff !important;
        color: #fff !important;
        transform: translateY(-5px);
    }
    .form-control:focus {
        background: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(101, 113, 255, 0.1);
        border: 1px solid #6571ff !important;
    }
    .shadow-lg-hover { transition: 0.3s; }
    .shadow-lg-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 1rem 3rem rgba(101, 113, 255, 0.2) !important;
    }
    .x-small { font-size: 0.75rem; }

    @media (max-width: 991px) {
        #contact { text-align: center; }
        .icon-box { margin: 0 auto 15px !important; }
        .align-items-start { align-items: center !important; flex-direction: column; }
    }
</style>