<!-- Footer Start -->
<div class="container-fluid bg-navy text-white footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-3">
                <div class="site-logo mb-3">
                    @if(isset($setting) && isset($setting->logo_wide) && $setting->logo_wide)
                        <img src="{{$setting->logo_wide }}" alt="Site Logo" style="max-width: 150px; max-height: 50px; object-fit: contain;">
                    @else
                        <div style="width:150px; height:50px; background:#f8fafc; display:flex; align-items:center; justify-content:center; border-radius:8px;">
                            <span style="color:#cbd5e1;">No Logo</span>
                        </div>
                    @endif
                </div>
                <p class="small mb-4">{{ $setting->description ?? 'No description available.' }}</p>
            </div>

            {{-- Contact Section --}}
            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Contact Us</h5>
                <p class="small mb-2"><i class="fa fa-map-marker-alt me-3 text-gold"></i>{{ $setting->address ?? 'Address not set' }}</p>
                <p class="small mb-2"><i class="fa fa-phone-alt me-3 text-gold"></i>{{ $setting->phone ?? 'Phone not set' }}</p>
                <p class="small mb-4"><i class="fa fa-envelope me-3 text-gold"></i>{{ $setting->email ?? 'Email not set' }}</p>
                
                <div class="d-flex pt-2">
                    @if(isset($setting->twitter_url) && $setting->twitter_url)
                        <a class="btn btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $setting->twitter_url }}" target="_blank"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if(isset($setting->facebook_url) && $setting->facebook_url)
                        <a class="btn btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $setting->facebook_url }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(isset($setting->instagram_url) && $setting->instagram_url)
                        <a class="btn btn-outline-light btn-sm-square rounded-circle me-2" href="{{ $setting->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(isset($setting->linkedin_url) && $setting->linkedin_url)
                        <a class="btn btn-outline-light btn-sm-square rounded-circle" href="{{ $setting->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Quick Links</h5>
                <a class="btn btn-link text-white-50 small mb-2" href="#">About Us</a>
                <a class="btn btn-link text-white-50 small mb-2" href="#notice">Notice Board</a>
                <a class="btn btn-link text-white-50 small mb-2" href="#">Online Admission</a>
                <a class="btn btn-link text-white-50 small mb-2" href="#contact">Contact Us</a>
            </div>

            

            <div class="col-md-6 col-lg-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                        <strong>ধন্যবাদ!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('exi    sts'))
                    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                        <strong>দুঃখিত!</strong> {{ session('exists') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h5 class="text-white mb-4">Newsletter</h5>
                <p class="small mb-4">{{ $setting->newsletter_text ?? 'Stay updated with our latest news and events.' }}</p>
                <form action="{{ route('main.newsletter.subscribe') }}" method="POST">
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
    
    {{-- Copyright Section --}}
    <div class="container px-lg-5">
        <div class="copyright border-top border-secondary py-4">
            <div class="row">
                <div class="col-md-12 text-center small">
                    &copy; {{ date('Y') }} <a class="text-gold fw-bold" href="#">{{ $setting->site_name ?? ($setting->name ?? '') }}</a>. All Rights Reserved. 
                    <span class="ms-2 opacity-50">Powered by {{ $site_setting->site_name ?? config('app.name') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<style>
    .container-fluid{
        background: linear-gradient(135deg, #95b4ec 0%, #4f7dce 100%);
        font-family: 'Poppins', sans-serif;
    }

    .site-title {
        font-size: 1.75rem;
        font-weight: 600;
    }
    .bg-navy { background-color: #002147 !important; }
    .text-navy { color: #002147 !important; }
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

    .btn-sm-square {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>