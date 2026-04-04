<div class="container-fluid bg-dark text-body footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-4">
                <p class="section-title text-white h5 mb-4">Contact Info<span></span></p>
                <p><i class="fa fa-map-marker-alt me-3"></i> {{ $setting->address ?? 'Dhaka, Bangladesh' }}</p>
                <p><i class="fa fa-phone me-3"></i> {{ $setting->phone ?? '+880123456789' }}</p>
                <p><i class="fa fa-envelope me-3"></i> {{ $setting->email ?? 'support@educorexa.com' }}</p>
            </div>
            <div class="col-md-6 col-lg-4">
                <p class="section-title text-white h5 mb-4">Quick Links<span></span></p>
                <a class="btn btn-link" href="">Privacy Policy</a>
                <a class="btn btn-link" href="">Terms & Conditions</a>
            </div>
            <div class="col-md-6 col-lg-4">
                <p class="section-title text-white h5 mb-4">Newsletter<span></span></p>
                <div class="position-relative w-100 mt-3">
                    <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Your Email" style="height: 48px;">
                    <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container px-lg-5">
        <div class="copyright text-center">
            &copy; {{ date('Y') }} {{ $setting->site_name ?? 'EduCorexa' }}. {{ $setting->footer_text ?? 'All Rights Reserved.' }} | Developed by <a href="https://educorexa.com" class="border-bottom" target="_blank">EduCorexa</a>
        </div>
    </div>
</div>