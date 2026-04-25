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
                    <form action="#" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">আপনার নাম</label>
                                <input type="text" name="name" class="form-control bg-light border-0 py-3 px-4 rounded-3" placeholder="Full Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">মোবাইল নাম্বার</label>
                                <input type="tel" name="phone" class="form-control bg-light border-0 py-3 px-4 rounded-3" placeholder="017XXXXXXXX" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-dark">প্রতিষ্ঠানের নাম (যদি থাকে)</label>
                                <input type="text" name="school_name" class="form-control bg-light border-0 py-3 px-4 rounded-3" placeholder="School/College Name">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-dark">আপনি কী জানতে চান?</label>
                                <textarea name="message" class="form-control bg-light border-0 py-3 px-4 rounded-3" rows="4" placeholder="Tell us more..."></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg-hover mt-3">
                                    Request a Call Back <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <p class="text-center text-muted x-small mt-4 mb-0">
                        <i class="bi bi-info-circle me-1"></i> আপনার তথ্য আমাদের কাছে সম্পূর্ণ নিরাপদ।
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