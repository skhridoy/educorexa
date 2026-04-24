<section id="testimonials" class="py-5 bg-white overflow-hidden">
    <div class="container py-lg-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase mb-2 small" style="letter-spacing: 2px;">Testimonials</h6>
            <h2 class="fw-bold text-dark">What School Leaders Say</h2>
            <p class="text-muted small mx-auto" style="max-width: 500px;">আমাদের ওপর আস্থা রেখেছেন দেশের অসংখ্য শিক্ষা প্রতিষ্ঠান।</p>
        </div>

        <div class="swiper testimonialSwiper pb-5">
            <div class="swiper-wrapper">
                
                <div class="swiper-slide p-2">
                    <div class="testimonial-card p-4 rounded-4 border-0 shadow-sm h-100 bg-light">
                        <div class="stars mb-3 text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted small mb-4 fst-italic">"EduCorexa ব্যবহার করার পর আমাদের স্কুলের ফি কালেকশন অনেক সহজ হয়ে গেছে। এখন সবকিছু অটোমেটিক হয়।"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 45px; height: 45px; flex-shrink: 0;">A</div>
                            <div>
                                <h6 class="fw-bold mb-0 small">Abdullah Al Mamun</h6>
                                <small class="text-muted x-small">Principal, ABC School</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide p-2">
                    <div class="testimonial-card p-4 rounded-4 border-0 shadow-sm h-100 bg-light">
                        <div class="stars mb-3 text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted small mb-4 fst-italic">"সফটওয়্যারটির ইন্টারফেস খুবই ইউজার ফ্রেন্ডলি। আমাদের শিক্ষকরা খুব দ্রুত এটি চালানো শিখে নিয়েছেন।"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 45px; height: 45px; flex-shrink: 0;">S</div>
                            <div>
                                <h6 class="fw-bold mb-0 small">Sharmin Akter</h6>
                                <small class="text-muted x-small">Admin Head, City Academy</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide p-2">
                    <div class="testimonial-card p-4 rounded-4 border-0 shadow-sm h-100 bg-light">
                        <div class="stars mb-3 text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted small mb-4 fst-italic">"সাপোর্ট টিম খুবই প্রফেশনাল। যেকোনো সমস্যায় নক দিলেই দ্রুত সমাধান পাওয়া যায়। দারুণ সলিউশন।"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 45px; height: 45px; flex-shrink: 0;">K</div>
                            <div>
                                <h6 class="fw-bold mb-0 small">Kamrul Hasan</h6>
                                <small class="text-muted x-small">Director, Model School</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide p-2">
                    <div class="testimonial-card p-4 rounded-4 border-0 shadow-sm h-100 bg-light">
                        <div class="stars mb-3 text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted small mb-4 fst-italic">"অনলাইন এক্সাম এবং রেজাল্ট পাবলিশিং ফিচারটি আমাদের অনেক সময় বাঁচিয়ে দিচ্ছে। খুবই কার্যকর।"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 45px; height: 45px; flex-shrink: 0;">R</div>
                            <div>
                                <h6 class="fw-bold mb-0 small">Rakibul Islam</h6>
                                <small class="text-muted x-small">Secretary, Ideal School</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<style>
    .testimonial-card { transition: 0.3s; border: 1px solid transparent !important; }
    .testimonial-card:hover { background: #fff !important; border-color: #6571ff !important; box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }
    .x-small { font-size: 0.7rem; }
    
    /* Swiper Pagination Style */
    .swiper-pagination-bullet-active { background: #6571ff !important; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper(".testimonialSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    });
</script>