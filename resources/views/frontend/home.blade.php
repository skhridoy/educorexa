@extends('app-layouts.frontend')

@section('content')
<div class="container-xxl bg-primary hero-header">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="text-white mb-4 animated slideInDown">{{ $site_setting->site_name ?? config('app.name') }}: The Ultimate School Management Ecosystem</h1>
                <p class="text-white pb-3 animated slideInDown">অ্যাডমিশন থেকে শুরু করে রেজাল্ট পাবলিশ—সবই হবে এখন এক ক্লিকে। আপনার স্কুলকে ডিজিটাল করতে আজই যুক্ত হোন আমাদের সাথে।</p>
                <div class="position-relative w-100 mt-3">
                    <a href="{{ route('school.register.form') }}" class="btn btn-light rounded-pill py-3 px-5 animated slideInRight">Get Started Now</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img class="img-fluid rounded animated zoomIn" src="{{ asset('frontend/img/hero.png') }}" alt="EduOrbit Dashboard">
            </div>
        </div>
    </div>
</div>
<div class="container-xxl py-6" id="features">
    <div class="container">
        <div class="mx-auto text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Advanced Features</h1>
            <p class="mb-5">একটি আদর্শ স্কুল পরিচালনার জন্য প্রয়োজনীয় সব টুলস এখন এক জায়গায়।</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="advanced-feature-item text-center rounded py-5 px-4">
                    <i class="fa fa-edit fa-3x text-primary mb-4"></i>
                    <h5 class="mb-3">Online Admission</h5>
                    <p class="m-0">অনলাইনেই ফরম পূরণ এবং স্টুডেন্ট ডাটাবেজ ম্যানেজমেন্ট।</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="advanced-feature-item text-center rounded py-5 px-4">
                    <i class="fa fa-user-check fa-3x text-primary mb-4"></i>
                    <h5 class="mb-3">Attendance System</h5>
                    <p class="m-0">শিক্ষক ও শিক্ষার্থীদের ডিজিটাল অ্যাটেনডেন্স ট্র্যাকিং।</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="advanced-feature-item text-center rounded py-5 px-4">
                    <i class="fa fa-file-invoice-dollar fa-3x text-primary mb-4"></i>
                    <h5 class="mb-3">Fee Management</h5>
                    <p class="m-0">অটোমেটেড ইনভয়েস এবং পেমেন্ট কালেকশন রিপোর্ট।</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="advanced-feature-item text-center rounded py-5 px-4">
                    <i class="fa fa-graduation-cap fa-3x text-primary mb-4"></i>
                    <h5 class="mb-3">Exam & Result</h5>
                    <p class="m-0">মার্কস এন্ট্রি থেকে অটোমেটেড মার্কশিট জেনারেশন।</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl py-6" id="about">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <img class="img-fluid rounded shadow" src="{{ asset('frontend/img/about.jpg') }}" alt="About EduOrbit">
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <h1 class="mb-4">কেন {{ config('app.name') }} ব্যবহার করবেন?</h1>
                <p class="mb-4">{{ config('app.name') }} শুধুমাত্র একটি সফটওয়্যার নয়, এটি আপনার শিক্ষা প্রতিষ্ঠানের জন্য একটি পূর্ণাঙ্গ সমাধান। আমরা ফোকাস করি আপনার প্রতিষ্ঠানের সহজ অপারেশন এবং স্বচ্ছতার ওপর।</p>
                <ul class="list-unstyled mb-4">
                    <li><i class="fa fa-check text-primary me-3"></i>User Friendly Dashboard</li>
                    <li><i class="fa fa-check text-primary me-3"></i>Real-time Data Sync</li>
                    <li><i class="fa fa-check text-primary me-3"></i>Secure Multi-school SaaS Architecture</li>
                    <li><i class="fa fa-check text-primary me-3"></i>Automatic Id Generation</li>
                    <li><i class="fa fa-check text-primary me-3"></i>24/7 Customer Support</li>
                </ul>
                <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('school.register.form') }}">Get Started</a>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl py-6" id="pricing">
    <div class="container">
        <div class="mx-auto text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Choose Your Plan</h1>
            <p class="mb-5">আপনার প্রতিষ্ঠানের প্রয়োজন অনুযায়ী বেছে নিন সেরা প্যাকেজ।</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="pricing-item rounded bg-light text-center p-5">
                    <h4 class="mb-3">Basic</h4>
                    <h1 class="display-5 mb-4">
                        <small class="align-top fw-normal" style="font-size: 22px; line-height: 45px;">$</small>10<small class="align-bottom fw-normal" style="font-size: 16px; line-height: 40px;">/ Mo</small>
                    </h1>
                    <div class="d-flex justify-content-between mb-3"><span>Up to 200 Students</span><i class="fa fa-check text-primary pt-1"></i></div>
                    <div class="d-flex justify-content-between mb-3"><span>Fee Management</span><i class="fa fa-check text-primary pt-1"></i></div>
                    <div class="d-flex justify-content-between mb-2"><span>Email Support</span><i class="fa fa-times text-danger pt-1"></i></div>
                    <a href="{{ route('school.register.form') }}" class="btn btn-primary rounded-pill py-2 px-4 mt-4">Get Started</a>
                </div>
            </div>
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="pricing-item rounded bg-dark text-white text-center p-5 shadow">
                    <h4 class="text-white mb-3">Professional</h4>
                    <h1 class="display-5 text-white mb-4">
                        <small class="align-top fw-normal" style="font-size: 22px; line-height: 45px;">$</small>25<small class="align-bottom fw-normal" style="font-size: 16px; line-height: 40px;">/ Mo</small>
                    </h1>
                    <div class="d-flex justify-content-between mb-3"><span>Unlimited Students</span><i class="fa fa-check text-primary pt-1"></i></div>
                    <div class="d-flex justify-content-between mb-3"><span>Exam & Result Management</span><i class="fa fa-check text-primary pt-1"></i></div>
                    <div class="d-flex justify-content-between mb-2"><span>Priority Support</span><i class="fa fa-check text-primary pt-1"></i></div>
                    <a href="{{ route('school.register.form') }}" class="btn btn-light rounded-pill py-2 px-4 mt-4">Get Started</a>
                </div>
            </div>
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="pricing-item rounded bg-light text-center p-5">
                    <h4 class="mb-3">Ultimate</h4>
                    <h1 class="display-5 mb-4">
                        <small class="align-top fw-normal" style="font-size: 22px; line-height: 45px;">$</small>50<small class="align-bottom fw-normal" style="font-size: 16px; line-height: 40px;">/ Mo</small>
                    </h1>
                    <div class="d-flex justify-content-between mb-3"><span>All Professional Features</span><i class="fa fa-check text-primary pt-1"></i></div>
                    <div class="d-flex justify-content-between mb-3"><span>SMS Integration</span><i class="fa fa-check text-primary pt-1"></i></div>
                    <div class="d-flex justify-content-between mb-2"><span>Custom Domain</span><i class="fa fa-check text-primary pt-1"></i></div>
                    <a href="{{ route('school.register.form') }}" class="btn btn-primary rounded-pill py-2 px-4 mt-4">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl py-6" id="contact">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-4">Any Questions?</h1>
                <p class="mb-4">আমাদের প্রতিনিধি আপনার সাথে যোগাযোগ করবে। নিচের ফর্মটি পূরণ করুন।</p>
                <div class="d-flex mb-3">
                    <div class="btn-square bg-primary rounded-circle me-3">
                        <i class="fa fa-envelope text-white"></i>
                    </div>
                    <span>{{ $site_setting->contact_email ?? 'support@educorexa.com' }}</span>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0 bg-light" id="name" placeholder="Your Name">
                                <label for="name">Your Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control border-0 bg-light" id="email" placeholder="Your Email">
                                <label for="email">Your Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control border-0 bg-light" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                <label for="message">Message</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection