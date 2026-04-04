<div class="container-xxl bg-primary hero-header py-4 mt-3">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            
            {{-- বাম পাশের অংশ (এটি ফিক্সড থাকবে, স্লাইড হবে না) --}}
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="text-white text-capitalize mb-2 animated slideInDown">
                    {{ $sliders->first()->title ?? "Welcome to " . $school->name }}
                </h1>
                <p class="text-white pb-3 animated slideInDown">
                    {{ $sliders->first()->subtitle ?? $school->address }}
                </p>
                
                {{-- রেজাল্ট বক্সটি এখানে ফিক্সড --}}
                <div class="position-relative w-100 mt-3 animated fadeInUp">
                    <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Search Result by ID..." style="height: 58px;">
                    <button type="button" class="btn btn-primary rounded-pill py-2 px-3 shadow-none position-absolute top-0 end-0 m-2">Check Result</button>
                </div>
            </div>

            {{-- ডান পাশের অংশ (শুধুমাত্র এখানে ইমেজ স্লাইড হবে) --}}
            <div class="col-lg-6 text-center text-lg-end pt-4">
                <div id="heroImageCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @forelse($sliders as $key => $slider)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img class="img-fluid rounded animated zoomIn" 
                                     src="{{ asset($slider->image) }}" 
                                     alt="Slider Image" 
                                     style="max-height: 450px; width: 100%; object-fit: cover;">
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img class="img-fluid rounded" src="{{ asset('main/img/hero.jpg') }}" alt="Default Hero">
                            </div>
                        @endforelse
                    </div>
                    
                    {{-- যদি একাধিক স্লাইডার থাকে তবেই কন্ট্রোল দেখাবে --}}
                    @if($sliders->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroImageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroImageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>