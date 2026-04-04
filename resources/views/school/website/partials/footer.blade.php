@php
    // ইজি এক্সেসের জন্য রিলেশন লোড করে নেওয়া
    $footer = $school->footerSetting; 
@endphp

<div class="container-fluid bg-dark text-body footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row g-5">
            {{-- প্রথম কলাম: স্কুল টেবিল থেকে ডাটা আসছে --}}
            <div class="col-md-6 col-lg-3">
                <p class="section-title text-white h5 mb-4">Address<span></span></p>
                <p><i class="fa fa-map-marker-alt me-3"></i>{{ $school->address ?? 'Address not set' }}</p>
                <p><i class="fa fa-phone-alt me-3"></i>{{ $school->phone ?? 'Phone not set' }}</p>
                <p><i class="fa fa-envelope me-3"></i>{{ $school->email ?? 'Email not set' }}</p>
                
                <div class="d-flex pt-2">
                    @if($footer?->twitter)
                        <a class="btn btn-outline-light btn-social" href="{{ $footer->twitter }}"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if($footer?->facebook)
                        <a class="btn btn-outline-light btn-social" href="{{ $footer->facebook }}"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if($footer?->instagram)
                        <a class="btn btn-outline-light btn-social" href="{{ $footer->instagram }}"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if($footer?->linkedin)
                        <a class="btn btn-outline-light btn-social" href="{{ $footer->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                </div>
            </div>

            {{-- বাকি কলামগুলো (Quick Links & Community) আপনার প্রয়োজনমতো রাউট দিয়ে দিন --}}
            <div class="col-md-6 col-lg-3">
                <p class="section-title text-white h5 mb-4">Quick Link<span></span></p>
                <a class="btn btn-link" href="{{ route('school.about', ['tenant' => $school->slug]) }}">About</a>
                <a class="btn btn-link" href="#">Contact</a>
                {{-- অন্যান্য লিঙ্কগুলো এখানে দিন --}}
            </div>

            {{-- কলাম ৩: Community --}}
            <div class="col-md-6 col-lg-3">
                <p class="section-title text-white h5 mb-4">Community<span></span></p>
                <a class="btn btn-link" href="">Career</a>
                <a class="btn btn-link" href="">Leadership</a>
                <a class="btn btn-link" href="">History</a>
            </div>

            {{-- নিউজলেটার কলাম --}}
            <div class="col-md-6 col-lg-3">
                <p class="section-title text-white h5 mb-4">Newsletter<span></span></p>
                <p>{{ $footer->newsletter_text ?? 'Stay updated with our school news.' }}</p>
                <form action="{{ route('newsletter.subscribe', ['tenant' => $school->slug]) }}" method="POST">
                    @csrf
                    <div class="position-relative w-100 mt-3">
                        <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" 
                            type="email" name="email" placeholder="Your Email" 
                            style="height: 48px;" required>
                        <button type="submit" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2">
                            <i class="fa fa-paper-plane text-primary fs-4"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- কপিরাইট সেকশন --}}
    <div class="container px-lg-5">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">{{ $school->name }}</a>, All Right Reserved. 
                    Powered by <a class="border-bottom" href="{{ config('app.url') }}" target="_blank">{{ $site_setting->site_name ?? config('app.name') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>