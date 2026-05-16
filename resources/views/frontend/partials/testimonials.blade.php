<section id="testimonials" class="py-5 bg-white overflow-hidden">
    <div class="container py-lg-5">
        <div class="text-center mb-5">
            <h6 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-3 text-primary">Testimonials</h6>
            <h2 class="">What School Leaders Say</h2>
            <p class="text-muted small mx-auto" style="max-width: 500px;">আমাদের ওপর আস্থা রেখেছেন দেশের অসংখ্য শিক্ষা প্রতিষ্ঠান।</p>
        </div>

        <div class="swiper testimonialSwiper pb-5">
            <div class="swiper-wrapper">
                @if(isset($testimonials) && $testimonials->count() > 0)
                    @foreach($testimonials as $testimonial)
                    <div class="swiper-slide p-2">
                        <div class="testimonial-card p-4 rounded-4 border-0 shadow-sm h-100 bg-light">
                            <div class="stars mb-3 text-warning small">
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star-fill {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                                @endfor
                            </div>
                            <p class="text-muted small mb-4 fst-italic">"{{ $testimonial->message }}"</p>
                            <div class="d-flex align-items-center">
                                @php
                                    $imageUrl = null;
                                    if ($testimonial->user_id && $testimonial->user && $testimonial->user->photo) {
                                        $imageUrl = asset($testimonial->user->photo);
                                    } elseif ($testimonial->image) {
                                        $imageUrl = asset($testimonial->image);
                                    } else {
                                        $imageUrl = asset('assets/images/profile.webp');
                                    }
                                @endphp
                                <img src="{{ $imageUrl }}" 
                                     onerror="this.src='{{ asset('assets/images/profile.webp') }}'"
                                     alt="{{ $testimonial->name }}" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover; flex-shrink: 0;">
                                <div>
                                    <h6 class="fw-bold mb-0 small">{{ $testimonial->name }}</h6>
                                    <small class="text-muted x-small">
                                        {{ $testimonial->designation }}
                                        @if($testimonial->designation && $testimonial->institution_name) , @endif
                                        {{ $testimonial->institution_name }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="swiper-slide p-2">
                        <div class="testimonial-card p-4 rounded-4 border-0 shadow-sm h-100 bg-light text-center py-5">
                            <p class="text-muted fst-italic mb-0">No testimonials available yet.</p>
                        </div>
                    </div>
                @endif

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