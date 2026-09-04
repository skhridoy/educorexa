@php
    $footer = $school->footerSetting; 
@endphp

<div class="container-fluid bg-navy text-white footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Contact Us</h5>
                <p class="small mb-2"><i class="fa fa-map-marker-alt me-3 text-gold"></i>{{ filled($school->address) ? $school->address : 'Address not set' }}</p>
                <p class="small mb-2"><i class="fa fa-phone-alt me-3 text-gold"></i>{{ $school->phone ?? 'Phone not set' }}</p>
                <p class="small mb-4"><i class="fa fa-envelope me-3 text-gold"></i>{{ $school->email ?? 'Email not set' }}</p>
                
                <div class="d-flex pt-2">
                    @if($footer?->twitter)
                        <a class="btn btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $footer->twitter }}"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if($footer?->facebook)
                        <a class="btn btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $footer->facebook }}"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if($footer?->instagram)
                        <a class="btn btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $footer->instagram }}"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if($footer?->linkedin)
                        <a class="btn btn-outline-light btn-sm-square rounded-circle" href="{{ $footer->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Quick Links</h5>
                <a class="btn btn-link text-white-50 small mb-2" href="{{ route('school.home', ['tenant' => $school->slug]) }}">About Us</a>
                <a class="btn btn-link text-white-50 small mb-2" href="#notice">Notice Board</a>
                <a class="btn btn-link text-white-50 small mb-2" href="{{ route('admission.create', ['tenant' => $school->slug]) }}">Online Admission</a>
                <a class="btn btn-link text-white-50 small mb-2" href="#contact">Contact Us</a>
            </div>

            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Our School</h5>
                <a class="btn btn-link text-white-50 small mb-2" href="#overview">Academic Overview</a>
                <a class="btn btn-link text-white-50 small mb-2" href="#">Library & Labs</a>
                <a class="btn btn-link text-white-50 small mb-2" href="#">Co-curricular</a>
                <a class="btn btn-link text-white-50 small mb-2" href="#">Student Council</a>
            </div>

            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Newsletter</h5>
                <p class="small mb-4">{{ $footer->newsletter_text ?? 'Stay updated with our latest news and events.' }}</p>
                <form action="{{ route('newsletter.subscribe', ['tenant' => $school->slug]) }}" method="POST">
                    @csrf
                    <div class="position-relative w-100">
                        <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" 
                            type="email" name="email" placeholder="Your Email" 
                            style="height: 48px;" required>
                        <button type="submit" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2">
                            <i class="fa fa-paper-plane text-navy fs-5"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container px-lg-5">
        <div class="copyright border-top border-secondary py-4">
            <div class="row">
                <div class="col-md-12 text-center small">
                    &copy; {{ date('Y') }} <a class="text-gold fw-bold" href="#">{{ $school->name }}</a>. All Rights Reserved. 
                    <span class="ms-2 opacity-50">Powered by {{ $site_setting->site_name ?? config('app.name') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-navy { background-color: #002147 !important; }
    .text-gold { color: #F9B800 !important; }
    .footer .btn.btn-link {
        display: block;
        margin-bottom: 5px;
        padding: 0;
        text-align: left;
        color: rgba(255, 255, 255, 0.5);
        font-weight: normal;
        text-transform: capitalize;
        transition: .3s;
        text-decoration: none;
    }
    .footer .btn.btn-link:hover {
        color: #F9B800;
        letter-spacing: 1px;
        box-shadow: none;
    }
</style>