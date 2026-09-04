@extends('school.website.layouts.app')

@section('customCSS')
    <style>
        :root {
            --navy: #002147;
            --gold: #F9B800;
            --white: #FFFFFF;
            --gray-light: #F8F9FA;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Heebo', sans-serif;
            color: #444;
        }

        .text-navy { color: var(--navy); }
        .bg-navy { background-color: var(--navy) !important; }
        .bg-gold { background-color: var(--gold) !important; }

        /* Section Title */
        .section-header {
            position: relative;
            padding-bottom: 20px;
            margin-bottom: 50px;
        }
        .section-header::after {
            content: "";
            position: absolute;
            width: 80px;
            height: 3px;
            background: var(--gold);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        .section-header.text-start::after {
            left: 0;
            transform: none;
        }

        /* Pillar Boxes */
        .pillar-box {
            background: #fff;
            padding: 40px 30px;
            text-align: center;
            border-bottom: 5px solid var(--gold);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            transition: var(--transition);
            margin-top: 0;
            position: relative;
            z-index: 20;
            height: 100%;
            border-radius: 10px;
        }
        .pillar-box:hover {
            transform: translateY(-10px);
            background: var(--navy);
            color: #fff;
        }
        .pillar-box:hover h4, .pillar-box:hover p {
            color: #fff;
        }
        .pillar-box i {
            font-size: 3rem;
            color: var(--navy);
            margin-bottom: 20px;
            transition: var(--transition);
        }
        .pillar-box:hover i {
            color: var(--gold);
        }

        /* About Section */
        .about-img-wrap {
            position: relative;
            padding: 30px;
        }
        .about-img-wrap::before {
            content: "";
            position: absolute;
            width: 80%;
            height: 80%;
            background: var(--navy);
            top: 0;
            left: 0;
            z-index: -1;
            border-radius: 10px;
        }

        /* Stats Counter */
        .stats-bar {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f4f8fc 0%, #e8f1f8 55%, #fdfaf0 100%);
            padding: 72px 0;
            color: var(--navy);
        }
        .stats-bar::before,
        .stats-bar::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(249, 184, 0, .16);
            border-radius: 50%;
            pointer-events: none;
        }
        .stats-bar::before {
            width: 320px;
            height: 320px;
            top: -190px;
            right: -80px;
        }
        .stats-bar::after {
            width: 240px;
            height: 240px;
            bottom: -165px;
            left: -75px;
        }
        .stats-bar .container {
            position: relative;
            z-index: 1;
        }
        .stats-card {
            position: relative;
            height: 100%;
            padding: 28px 22px 24px;
            overflow: hidden;
            text-align: center;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(0, 33, 71, .08);
            border-radius: 18px;
            background: rgba(255, 255, 255, .9);
            box-shadow: 0 14px 32px rgba(0, 33, 71, .1);
            backdrop-filter: blur(8px);
            transition: transform .3s ease, background .3s ease, box-shadow .3s ease;
        }
        .stats-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 22%;
            right: 22%;
            height: 3px;
            background: var(--gold);
            border-radius: 0 0 8px 8px;
        }
        .stats-card:hover {
            background: #fff;
            box-shadow: 0 20px 42px rgba(0, 33, 71, .16);
            transform: translateY(-8px);
        }
        .stats-icon {
            width: 66px;
            height: 66px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 17px;
            color: var(--gold);
            font-size: 1.65rem;
            background: rgba(249, 184, 0, .15);
            border: 1px solid rgba(249, 184, 0, .35);
            border-radius: 50%;
        }
        .stats-card h2 {
            font-size: clamp(1.8rem, 3vw, 2.35rem);
            font-weight: 800;
            line-height: 1;
            letter-spacing: .02em;
            color: var(--navy) !important;
        }
        .stats-card p {
            color: #64748b;
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .08em;
        }
        @media (max-width: 575px) {
            .stats-bar { padding: 48px 0; }
            .stats-bar .row { --bs-gutter-x: .8rem; --bs-gutter-y: .8rem; }
            .stats-card { padding: 21px 10px 18px; border-radius: 14px; }
            .stats-icon { width: 50px; height: 50px; margin-bottom: 13px; font-size: 1.25rem; }
            .stats-card p { font-size: .62rem; letter-spacing: .04em; }
        }

        /* Notice & News */
        .notice-card {
            background: #fff;
            border-left: 5px solid var(--navy);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: var(--transition);
        }
        .notice-card:hover {
            border-left-color: var(--gold);
            transform: translateX(5px);
        }

        /* Latest news trigger */
        .news-trigger {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 1050;
            width: min(360px, calc(100vw - 32px));
            background: #fff;
            border: 1px solid #e6edf2;
            border-left: 4px solid var(--gold);
            border-radius: 12px;
            box-shadow: 0 14px 35px rgba(0, 33, 71, .18);
            transform: translateY(140%);
            opacity: 0;
            transition: transform .35s ease, opacity .35s ease;
        }
        .news-trigger.is-visible { transform: translateY(0); opacity: 1; }
        .news-trigger-link { display: block; padding: 15px 42px 15px 16px; color: #002147; text-decoration: none; }
        .news-trigger-link:hover { color: #002147; background: #fffdf4; }
        .news-trigger-label { display: flex; align-items: center; gap: 7px; color: #a16207; font-size: 11px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
        .news-trigger-title { display: block; margin-top: 5px; font-size: 15px; font-weight: 800; line-height: 1.35; }
        .news-trigger-date { display: block; margin-top: 5px; color: #64748b; font-size: 11px; }
        .news-trigger-close { position: absolute; top: 8px; right: 9px; width: 25px; height: 25px; padding: 0; border: 0; border-radius: 50%; background: #f1f5f9; color: #64748b; cursor: pointer; }
        .news-trigger-close:hover { background: #e2e8f0; color: #002147; }
        @media (max-width: 575px) { .news-trigger { right: 16px; bottom: 16px; } }

        /* Teachers */
        .teacher-item {
            background: #fff;
            border: 1px solid #eee;
            transition: var(--transition);
            overflow: hidden;
        }

        .teacher-item:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .teacher-item img {
            transition: var(--transition);
        }
        .teacher-item:hover img {
            transform: scale(1.1);
        }

        /* Buttons */
        .btn-gold {
            background: var(--gold);
            color: var(--navy);
            font-weight: 700;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            transition: var(--transition);
        }
        .btn-gold:hover {
            background: var(--navy);
            color: #fff;
        }
        .btn-lg-square {
            width: 55px;
            height: 55px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .premium-teacher-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 1px solid rgba(0,0,0,0.02);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .premium-teacher-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.04) 0%, rgba(139, 92, 246, 0.04) 100%);
            z-index: -1;
            border-radius: 24px 24px 0 0;
            transition: all 0.5s ease;
        }

        .premium-teacher-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.08);
            border-color: rgba(79, 70, 229, 0.1);
        }

        .premium-teacher-card:hover::before {
            height: 100%;
            opacity: 0.6;
        }

        .premium-teacher-img-wrapper {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            border-radius: 50%;
            padding: 6px;
            background: #ffffff;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            position: relative;
            z-index: 2;
            transition: transform 0.4s ease;
        }

        .premium-teacher-card:hover .premium-teacher-img-wrapper {
            transform: scale(1.05);
        }

        .premium-teacher-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(79, 70, 229, 0.05);
        }

        .premium-teacher-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            font-family: 'Outfit', sans-serif;
            transition: color 0.3s ease;
        }

        .premium-teacher-designation {
            font-size: 0.85rem;
            font-weight: 600;
            color: #4f46e5;
            background: rgba(79, 70, 229, 0.08);
            padding: 6px 16px;
            border-radius: 30px;
            display: inline-block;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .premium-social-links {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .premium-social-links a {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f1f5f9;
            color: #64748b;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 0.95rem;
            text-decoration: none;
        }

        .premium-social-links a:hover {
            background: #4f46e5;
            color: #ffffff;
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 8px 15px rgba(79, 70, 229, 0.3);
        }
 
    </style>
@endsection

@section('content')
    {{-- Hero Section --}}
    @include('school.website.partials.hero')

    {{-- Pillar Boxes --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="pillar-box">
                        <i class="fa fa-university"></i>
                        <h4 class="fw-bold mb-3">Online Admission</h4>
                        <p class="text-muted mb-4">Start your journey with us today. Our online admission process is simple and transparent.</p>
                        <a href="{{ route('admission.create', ['tenant' => $school->slug]) }}" class="btn btn-navy rounded-pill py-2 px-4">Apply Now</a>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="pillar-box">
                        <i class="fa fa-book-open"></i>
                        <h4 class="fw-bold mb-3">Academic Program</h4>
                        <p class="text-muted mb-4">We offer a wide range of academic programs designed to foster intellectual growth and skill development.</p>
                        <a href="#overview" class="btn btn-navy rounded-pill py-2 px-4">View Details</a>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="pillar-box">
                        <i class="fa fa-file-invoice"></i>
                        <h4 class="fw-bold mb-3">Public Results</h4>
                        <p class="text-muted mb-4">Easily check examination results online. Stay updated with your child's academic progress.</p>
                        <a href="{{ route('frontend.result_page', ['tenant' => $school->slug]) }}" class="btn btn-navy rounded-pill py-2 px-4">Check Result</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- About Us Section --}}
    <div class="container-xxl py-6" id="about">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow zoomIn" data-wow-delay="0.1s">
                    <div class="about-img-wrap">
                        @if($about && $about->image)
                            <img class="img-fluid rounded shadow" src="{{ asset($about->image) }}" alt="About">
                        @else
                            <img class="img-fluid rounded shadow" src="{{ asset('img/school-building.jpg') }}" alt="Default About">
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="section-header text-start">
                        <h5 class="text-navy text-uppercase fw-bold mb-2">Welcome to Our School</h5>
                        <h2 class="display-6 fw-bold mb-0">{{ $about->title ?? 'Building a Brighter Future Together' }}</h2>
                    </div>
                    <p class="mb-4">{{ $about->description ?? 'We are committed to providing a holistic education that empowers students to reach their full potential and become responsible citizens.' }}</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <h5 class="mb-3"><i class="fa fa-check text-gold me-3"></i>Modern Labs</h5>
                            <p class="small text-muted">Well-equipped science and computer labs for practical learning.</p>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="mb-3"><i class="fa fa-check text-gold me-3"></i>Expert Teachers</h5>
                            <p class="small text-muted">Highly qualified and dedicated educators committed to student success.</p>
                        </div>
                    </div>
                    <a href="#" class="btn btn-navy py-3 px-5 rounded-pill">Learn More About Us</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="container-fluid stats-bar my-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <span class="stats-icon"><i class="fa fa-users"></i></span>
                        <h2 class="text-white mb-2" data-toggle="counter-up">{{ $studentCount }}</h2>
                        <p class="text-uppercase mb-0">Total Students</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <span class="stats-icon"><i class="fa fa-user-tie"></i></span>
                        <h2 class="text-white mb-2" data-toggle="counter-up">{{ $teacherCount }}</h2>
                        <p class="text-uppercase mb-0">Expert Teachers</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <span class="stats-icon"><i class="fa fa-award"></i></span>
                        <h2 class="text-white mb-2" data-toggle="counter-up">{{ $noticeCount }}</h2>
                        <p class="text-uppercase mb-0">Published Notices</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <span class="stats-icon"><i class="fa fa-graduation-cap"></i></span>
                        <h2 class="text-white mb-2" data-toggle="counter-up">{{ $classCount }}</h2>
                        <p class="text-uppercase mb-0">Academic Classes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- News & Notice Board --}}
    <div class="container-xxl py-5" id="notice">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-header text-start">
                        <h2 class="fw-bold">Latest Notice Board</h2>
                    </div>
                    <div class="pe-lg-4">
                        @forelse($notices as $notice)
                            <div class="notice-card p-4 mb-3 d-flex align-items-center">
                                <div class="bg-navy text-white text-center rounded p-2 me-4" style="min-width: 70px;">
                                    <h4 class="mb-0 text-white fw-bold">{{ \Carbon\Carbon::parse($notice->notice_date)->format('d') }}</h4>
                                    <small class="text-uppercase">{{ \Carbon\Carbon::parse($notice->notice_date)->format('M') }}</small>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1">{{ $notice->title }}</h5>
                                    <small class="text-muted"><i class="far fa-clock me-2"></i>Published: {{ $notice->created_at->diffForHumans() }}</small>
                                </div>
                                @if($notice->file)
                                    <a href="{{ asset($notice->file) }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-circle ms-3">
                                        <i class="fa fa-file-pdf"></i>
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div class="alert alert-light border">No notices published yet.</div>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="section-header text-start">
                        <h2 class="fw-bold">Important Links</h2>
                    </div>
                    <div class="list-group list-group-flush shadow-sm rounded border">
                        <a href="{{ route('admission.create', ['tenant' => $school->slug]) }}" class="list-group-item list-group-item-action p-3 border-0 border-bottom">
                            <i class="fa fa-caret-right text-gold me-3"></i>Online Admission Form
                        </a>
                        <a href="#" class="list-group-item list-group-item-action p-3 border-0 border-bottom">
                            <i class="fa fa-caret-right text-gold me-3"></i>Academic Calendar
                        </a>
                        <a href="#" class="list-group-item list-group-item-action p-3 border-0 border-bottom">
                            <i class="fa fa-caret-right text-gold me-3"></i>Syllabus & Curriculum
                        </a>
                        <a href="#" class="list-group-item list-group-item-action p-3 border-0">
                            <i class="fa fa-caret-right text-gold me-3"></i>Class Routine
                        </a>
                    </div>
                    <div class="bg-navy rounded p-5 mt-5 text-white">
                        <h4 class="text-white mb-4">Admission Inquiry</h4>
                        <p class="small opacity-75 mb-4">Contact our admission office for any queries regarding student enrollment and fee structure.</p>
                        <h5 class="text-white mb-0"><i class="fa fa-phone-alt text-gold me-3"></i>{{ $school->phone }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($notices->isNotEmpty())
        @php $latestNotice = $notices->first(); @endphp
        <aside class="news-trigger" id="school-news-trigger" data-notice-id="{{ $latestNotice->id }}">
            <button type="button" class="news-trigger-close" aria-label="Close news alert"><i class="fa fa-times"></i></button>
            <a class="news-trigger-link" href="{{ route('frontend.notice', ['tenant' => $school->slug]) }}">
                <span class="news-trigger-label"><i class="fa fa-bell"></i> নতুন নোটিশ</span>
                <span class="news-trigger-title">{{ $latestNotice->title }}</span>
                <span class="news-trigger-date">বিস্তারিত দেখতে ক্লিক করুন</span>
            </a>
        </aside>
    @endif

    {{-- Overview Section --}}
    <div class="container-xxl py-5 bg-light" id="overview">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h2 class="fw-bold">Our Academic Highlights</h2>
            </div>
            @isset($overviews)
                @foreach($overviews as $overview)
                    <div class="row g-5 align-items-center mb-5 {{ $loop->iteration % 2 == 0 ? 'flex-row-reverse' : '' }}">
                        <div class="col-lg-6 wow zoomIn" data-wow-delay="0.1s">
                            <img class="img-fluid rounded shadow-lg" src="{{ asset($overview->image) }}" alt="Overview">
                        </div>
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                            <h3 class="fw-bold mb-4 text-navy">{{ $overview->title }}</h3>
                            <p class="mb-4">{{ $overview->description }}</p>
                            @if($overview->features)
                                <div class="row g-2">
                                    @foreach(explode(',', $overview->features) as $feature)
                                        <div class="col-sm-6">
                                            <i class="fa fa-check text-gold me-3"></i>{{ trim($feature) }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>

    {{-- Teachers Gallery --}}


    <div class="container-xxl py-5 bg-light" style="border-radius: 40px; margin-top: 3rem; margin-bottom: 3rem;">
        <div class="container py-4">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <span class="text-uppercase fw-bold" style="color: #4f46e5; letter-spacing: 2px; font-size: 0.85rem;">Dedicated Mentors</span>
                <h2 class="fw-bold mt-2 mb-3" style="font-family:'Outfit', sans-serif; font-size: 2.5rem; color: #0f172a;">Our Professional Educators</h2>
                <div style="width: 60px; height: 4px; background: #4f46e5; margin: 0 auto 20px; border-radius: 2px;"></div>
                <p class="text-muted" style="font-size: 1.05rem;">Meet our team of dedicated teachers who are committed to student-centered learning and excellence in education.</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($teachers as $teacher)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                    <div class="premium-teacher-card text-center">
                        <div class="premium-teacher-img-wrapper">
                            <img class="premium-teacher-img" 
                                 src="{{ $teacher->photo ? asset($teacher->photo) : 'https://ui-avatars.com/api/?name='.urlencode($teacher->name).'&background=002147&color=fff' }}" 
                                 alt="{{ $teacher->name }}">
                        </div>
                        <h5 class="premium-teacher-name">{{ $teacher->name }}</h5>
                        <div class="premium-teacher-designation">{{ $teacher->designation ?? 'Teacher' }}</div>
                        <div class="premium-social-links">
                            @if($teacher->facebook) <a href="{{ $teacher->facebook }}"><i class="fab fa-facebook-f"></i></a> @endif
                            @if($teacher->twitter) <a href="{{ $teacher->twitter }}"><i class="fab fa-twitter"></i></a> @endif
                            @if($teacher->linkedin) <a href="{{ $teacher->linkedin }}"><i class="fab fa-linkedin-in"></i></a> @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Contact Section --}}
    <div class="container-xxl py-5" id="contact">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-header text-start">
                        <h2 class="fw-bold">Get In Touch</h2>
                    </div>
                    <p class="mb-5">Have questions? Reach out to us. We're here to help you with any information you need about our school.</p>
                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-square bg-navy text-white rounded-circle me-4"><i class="fa fa-phone-alt"></i></div>
                        <div>
                            <h6 class="mb-1 fw-bold text-navy">Call Us</h6>
                            <span>{{ $school->phone ?? '+880 1XXX XXXXXX' }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-square bg-navy text-white rounded-circle me-4"><i class="fa fa-envelope-open"></i></div>
                        <div>
                            <h6 class="mb-1 fw-bold text-navy">Email Us</h6>
                            <span>{{ $school->email ?? 'info@school.edu.bd' }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="btn-square bg-navy text-white rounded-circle me-4"><i class="fa fa-map-marker-alt"></i></div>
                        <div>
                            <h6 class="mb-1 fw-bold text-navy">Location</h6>
                            <span>{{ $school->address ?? 'Dhaka, Bangladesh' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <style>
                        .premium-contact-form {
                            background: #ffffff;
                            border-radius: 24px;
                            box-shadow: 0 15px 40px rgba(0,0,0,0.06);
                            border: 1px solid rgba(0,0,0,0.03);
                        }
                        .premium-input {
                            background: #f8fafc !important;
                            border: 1px solid transparent !important;
                            border-radius: 12px !important;
                            box-shadow: none !important;
                            transition: all 0.3s ease;
                        }
                        .premium-input:focus {
                            background: #ffffff !important;
                            border-color: #4f46e5 !important;
                            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
                        }
                        .form-floating label {
                            color: #64748b;
                        }
                        .premium-btn {
                            background: linear-gradient(135deg, #002147 0%, #003366 100%);
                            border: none;
                            border-radius: 12px;
                            color: white;
                            transition: all 0.3s ease;
                            position: relative;
                            overflow: hidden;
                        }
                        .premium-btn:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 10px 20px rgba(0, 33, 71, 0.2);
                            color: #ffffff;
                        }
                    </style>
                    <div class="premium-contact-form p-4 p-md-5">
                        <h4 class="fw-bold mb-4 text-center" style="color: #1e293b; font-family: 'Outfit', sans-serif;">Send us a Message</h4>
                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px; background: #ecfdf5; color: #065f46;"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('school.contact.store', ['tenant' => $school->slug]) }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control premium-input" id="name" placeholder="Your Name" required>
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control premium-input" id="email" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" name="phone" class="form-control premium-input" id="phone" placeholder="Phone Number" required>
                                        <label for="phone">Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="message" class="form-control premium-input" id="message" placeholder="Message" style="height: 150px" required></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn premium-btn w-100 py-3 fw-bold text-uppercase" style="letter-spacing: 1px;" type="submit">
                                        <span>Send Message</span>
                                        <i class="fas fa-paper-plane ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        (function () {
            const trigger = document.getElementById('school-news-trigger');
            if (!trigger) return;

            const storageKey = 'school-news-seen-' + @json($school->slug);
            const noticeId = trigger.dataset.noticeId;
            const closeButton = trigger.querySelector('.news-trigger-close');

            if (window.localStorage.getItem(storageKey) !== noticeId) {
                window.setTimeout(() => trigger.classList.add('is-visible'), 700);
            }

            closeButton.addEventListener('click', function () {
                window.localStorage.setItem(storageKey, noticeId);
                trigger.classList.remove('is-visible');
            });

            trigger.querySelector('.news-trigger-link').addEventListener('click', function () {
                window.localStorage.setItem(storageKey, noticeId);
            });
        })();

    </script>
@endpush