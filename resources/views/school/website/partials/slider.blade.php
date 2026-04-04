<div id="heroSlider" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="1"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active" style="background: linear-gradient(45deg, rgba(0,0,0,0.7), rgba(0,208,132,0.3)), url('https://images.unsplash.com/photo-1523050853063-bd388f9c7d13?q=80&w=2070') center/cover;">
            <div class="container d-flex align-items-center justify-content-center text-center text-white min-vh-100">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">আধুনিক ডিজিটাল স্কুল ম্যানেজমেন্ট সিস্টেম</h1>
                        <p class="lead mb-5 fs-4 animate__animated animate__fadeInUp">আপনার স্কুলের প্রতিটি কাজকে করুন আরও সহজ, দ্রুত এবং নির্ভুল। আজই যোগ দিন স্টকোর (Stocker) পরিবারে।</p>
                        <div class="d-flex justify-content-center gap-3 animate__animated animate__zoomIn">
                            <a href="{{ route('admission.create', ['tenant' => app('currentSchool')->slug]) }}" class="btn btn-lg rounded-pill px-5 py-3 fw-bold" style="background-color: #00D084; border-color: #00D084; color: white;">Get Admission</a>
                            <a href="#features" class="btn btn-lg btn-outline-light rounded-pill px-5 py-3 fw-bold">Explore Features</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-item" style="background: linear-gradient(45deg, rgba(0,0,0,0.7), rgba(0,208,132,0.3)), url('https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2070') center/cover;">
            <div class="container d-flex align-items-center justify-content-center text-center text-white min-vh-100">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <h1 class="display-3 fw-bold mb-4">স্বয়ংক্রিয় সাবডোমেইন এবং ডাটাবেস</h1>
                        <p class="lead mb-5 fs-4">প্রতিটি স্কুলের জন্য আলাদা সাবডোমেইন এবং সুরক্ষিত ডাটাবেস। কোনো টেকনিক্যাল জ্ঞান ছাড়াই আপনার স্কুল ব্র্যান্ডকে নিয়ে যান অনলাইনে।</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admission.create', ['tenant' => app('currentSchool')->slug]) }}" class="btn btn-lg rounded-pill px-5 py-3 fw-bold" style="background-color: #00D084; border-color: #00D084; color: white;">Get Admission</a>
                            <a href="#pricing" class="btn btn-lg btn-outline-light rounded-pill px-5 py-3 fw-bold">View Pricing</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon p-4 rounded-circle bg-dark bg-opacity-25" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon p-4 rounded-circle bg-dark bg-opacity-25" aria-hidden="true"></span>
    </button>
</div>