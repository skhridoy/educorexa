@extends('school.website.layouts.app')

@section('customCSS')
    <style>
        .school-logo {
            height: 50px;
            width: auto;
        }
        .school-name {
            font-size: 1.75rem;
            font-weight: 700;
            white-space: normal; 
            line-height: 1.2;
        }
        .hero-header {
            overflow: hidden;
        }
        .carousel-item {
            transition: transform 0.6s ease-in-out;
        }
        /* ইমেজ সাইজ কন্ট্রোল করার জন্য */
        .hero-header img {
            max-height: 500px;
            object-fit: contain;
        }
      
        .teacher-item {
            transition: transform 0.3s ease;
            border-radius: 10px;
        }
        
        .teacher-item h5 {
            font-size: 1.1rem;
            color: #333;
        }

        /* সোশ্যাল বাটন ডিজাইন */
        .social-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            transition: opacity 0.3s;
        }

        .social-btn:hover {
            opacity: 0.8;
            color: #fff;
        }

        /* আইকন কালার আপনার ছবির মতো */
        .fb { background-color: #000; } /* প্রথমজন কালো, বাকিরা লাল */
        .tw { background-color: #bb0000; }
        .ln { background-color: #bb0000; }
        .inst { background-color: #bb0000; }

        /* প্রথম কার্ডের ফেসবুক আইকন কালো রাখতে চাইলে এটি কাজ করবে */
        .row > div:first-child .fb { background-color: #000; }

        /* Counter Section Design */
        .counter-section {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
            padding: 80px 0;
            color: white;
        }

        .counter-item i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .counter-val {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 5px;
            display: block;
        }

        .counter-label {
            font-size: 1.1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        /* মোবাইল ভিউতে (৯৯২ পিক্সেলের নিচে) পরিবর্তন */
        @media (max-width: 991.98px) {
            .school-name {
                font-size: 1.1rem; /* মোবাইলে নাম ছোট দেখাবে */
                max-width: 200px;  /* টেক্সট র‍্যাপ করার জন্য একটি নির্দিষ্ট উইডথ */
            }
        .school-logo {
                height: 40px; /* মোবাইলে লোগো সামান্য ছোট */
            }
        }

        /* আরও ছোট স্ক্রিন (যেমন: iPhone SE বা ছোট ফোন) */
        @media (max-width: 575.98px) {
            .school-name {
                font-size: 0.95rem;
                max-width: 150px;
            }
        }
    </style>
@endsection

@section('content')
@include('school.website.partials.hero')
</div>
    <div class="container-xxl py-6">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-item bg-light rounded text-center p-5">
                        <i class="fa fa-4x fa-graduation-cap text-primary mb-4"></i>
                        <h5 class="mb-3">মানসম্মত শিক্ষা</h5>
                        <p class="m-0">অভিজ্ঞ শিক্ষক মন্ডলী দ্বারা আধুনিক ও ডিজিটাল পদ্ধতিতে পাঠদান নিশ্চিত করা হয়।</p>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-item bg-light rounded text-center p-5">
                        <i class="fa fa-4x fa-microscope text-primary mb-4"></i>
                        <h5 class="mb-3">আধুনিক ল্যাব</h5>
                        <p class="m-0">শিক্ষার্থীদের ব্যবহারিক জ্ঞান বৃদ্ধির জন্য রয়েছে সুসজ্জিত বিজ্ঞান ও কম্পিউটার ল্যাব।</p>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="feature-item bg-light rounded text-center p-5">
                        <i class="fa fa-4x fa-book-reader text-primary mb-4"></i>
                        <h5 class="mb-3">সমৃদ্ধ লাইব্রেরি</h5>
                        <p class="m-0">হাজারো বইয়ের সংগ্রহ নিয়ে আমাদের লাইব্রেরি শিক্ষার্থীদের জ্ঞান তৃষ্ণা মিটিয়ে থাকে।</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Notice Board -->
    <div class="container-xxl py-6" id="notice">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex align-items-center mb-4">
                        <h1 class="mb-0">Notice Board</h1>
                        <span class="bg-primary mx-3" style="width: 50px; height: 2px;"></span>
                    </div>
                    
                    <div class="notice-container bg-white shadow-sm rounded p-4 border-top border-4 border-primary">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 15%">Date</th>
                                        <th>Title</th>
                                        <th style="width: 15%">Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($notices as $notice)
                                <tr>
                                    <td>
                                        <div class="bg-primary text-white text-center rounded p-1">
                                            <span class="d-block fw-bold">{{ \Carbon\Carbon::parse($notice->notice_date)->format('d') }}</span>
                                            <small>{{ \Carbon\Carbon::parse($notice->notice_date)->format('M, Y') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-1">{{ $notice->title }}</h6>
                                        <small class="text-muted">Published: {{ $notice->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if($notice->file)
                                            <a href="{{ asset($notice->file) }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm">
                                                <i class="fa fa-file-pdf"></i>
                                            </a>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">বর্তমানে কোনো নোটিশ নেই।</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="#" class="btn btn-link text-primary p-0">সকল নোটিশ দেখুন <i class="fa fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-light rounded p-4 mb-4">
                        <h5 class="mb-4 border-bottom pb-2">গুরুত্বপূর্ণ লিংক</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <a href="{{ route('admission.create', ['tenant' => $school->slug]) }}" class="text-decoration-none text-dark d-flex align-items-center" target="_blank">
                                    <i class="fa fa-chevron-right text-primary me-2 small"></i> অনলাইন ভর্তি ফরম
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" class="text-decoration-none text-dark d-flex align-items-center">
                                    <i class="fa fa-chevron-right text-primary me-2 small"></i> একাডেমিক ক্যালেন্ডার
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" class="text-decoration-none text-dark d-flex align-items-center">
                                    <i class="fa fa-chevron-right text-primary me-2 small"></i> পাঠ্যক্রম ও সিলেবাস
                                </a>
                            </li>
                            <li class="mb-0">
                                <a href="#" class="text-decoration-none text-dark d-flex align-items-center">
                                    <i class="fa fa-chevron-right text-primary me-2 small"></i> ডিজিটাল ক্লাস রুটিন
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-primary rounded p-4 text-white">
                        <h5 class="text-white mb-3">সহায়তা প্রয়োজন?</h5>
                        <p class="small mb-4">ভর্তি সংক্রান্ত বা অন্য কোনো তথ্যের জন্য আমাদের সাথে যোগাযোগ করুন।</p>
                        <div class="d-flex align-items-center">
                            <div class="btn-square bg-white text-primary rounded-circle me-3">
                                <i class="fa fa-phone-alt"></i>
                            </div>
                            <h6 class="text-white mb-0">+০১৮০০-০০০০০০</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About section -->
    <div class="container-xxl py-6" id="about">
        <div class="container">
            <div class="row g-5 flex-column-reverse flex-lg-row">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="mb-4">{{ $about->title ?? 'একটি উজ্জ্বল ভবিষ্যৎ গড়ার প্রত্যয়ে আমাদের পথচলা' }}</h1>
                    <p class="mb-4">{{ $about->description ?? 'আমাদের লক্ষ্য শুধু পাঠ্যবইয়ের শিক্ষা নয়, বরং নৈতিকতা ও আধুনিক প্রযুক্তির সমন্বয়ে প্রতিটি শিক্ষার্থীকে একজন সুনাগরিক হিসেবে গড়ে তোলা।' }}</p>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="ms-4">
                            <h5>{{ $about->feature_1_title ?? 'শৃঙ্খলামূলক পরিবেশ' }}</h5>
                            <p class="mb-0">{{ $about->feature_1_desc ?? 'শিক্ষার্থীদের জন্য নিরাপদ, মনোরম এবং কঠোর শৃঙ্খলাবদ্ধ একাডেমিক পরিবেশ।' }}</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="ms-4">
                            <h5>{{ $about->feature_2_title ?? 'সহ-শিক্ষা কার্যক্রম' }}</h5>
                            <p class="mb-0">{{ $about->feature_2_desc ?? 'খেলাধুলা, বিতর্ক প্রতিযোগিতা ও সাংস্কৃতিক অনুষ্ঠানের মাধ্যমে মেধা বিকাশের সুযোগ।' }}</p>
                        </div>
                    </div>

                    <a href="{{ $about->button_url ?? '#' }}" class="btn btn-primary py-sm-3 px-sm-5 rounded-pill mt-3">
                        {{ $about->button_text ?? 'আরও জানুন' }}
                    </a>
                </div>

                <div class="col-lg-6">
                    @if($about && $about->image)
                        <img class="img-fluid rounded wow zoomIn" data-wow-delay="0.5s" src="{{ asset($about->image) }}" alt="School Campus">
                    @else
                        <img class="img-fluid rounded wow zoomIn" data-wow-delay="0.5s" src="{{ asset('img/school-building.jpg') }}" alt="Default Campus">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Counter Section -->
     <div class="container-xxl counter-section my-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 text-center counter-item wow fadeIn" data-wow-delay="0.1s">
                    <i class="fa fa-users"></i>
                    <span class="counter-val" data-toggle="counter-up">{{ $studentCount ?? 1200 }}</span>
                    <p class="counter-label text-white mb-0">মোট শিক্ষার্থী</p>
                </div>
                
                <div class="col-md-6 col-lg-3 text-center counter-item wow fadeIn" data-wow-delay="0.3s">
                    <i class="fa fa-user-tie"></i>
                    <span class="counter-val" data-toggle="counter-up">{{ $teacherCount ?? 45 }}</span>
                    <p class="counter-label text-white mb-0">অভিজ্ঞ শিক্ষক</p>
                </div>
                
                <div class="col-md-6 col-lg-3 text-center counter-item wow fadeIn" data-wow-delay="0.5s">
                    <i class="fa fa-user-shield"></i>
                    <span class="counter-val" data-toggle="counter-up">{{ $staffCount ?? 15 }}</span>
                    <p class="counter-label text-white mb-0">সহকারী স্টাফ</p>
                </div>
                
                <div class="col-md-6 col-lg-3 text-center counter-item wow fadeIn" data-wow-delay="0.7s">
                    <i class="fa fa-award"></i>
                    <span class="counter-val" data-toggle="counter-up">100</span>
                    <p class="counter-label text-white mb-0">সাফল্যের হার (%)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Overviews Section -->
    <div class="container-xxl bg-light my-6 py-5" id="overview">
        <div class="container">
            @isset($overviews)
                @foreach($overviews as $overview)
                    <div class="row g-5 py-5 align-items-center {{ $loop->iteration % 2 == 0 ? 'flex-column-reverse flex-lg-row' : '' }}">
                        
                        {{-- বিজোড় (Odd) রো-তে ইমেজ বামে থাকবে --}}
                        @if($loop->iteration % 2 != 0)
                            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                                <img class="img-fluid rounded" src="{{ asset($overview->image) }}" alt="{{ $overview->title }}">
                            </div>
                        @endif

                        {{-- টেক্সট সেকশন --}}
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="d-flex align-items-center mb-4">
                                {{-- বেঙ্গলি বা ইংলিশ নাম্বারিং (str_pad দিয়ে ০২ ফরম্যাট) --}}
                                <h1 class="mb-0">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</h1>
                                <span class="bg-primary mx-2" style="width: 30px; height: 2px;"></span>
                                <h5 class="mb-0">{{ $overview->title }}</h5>
                            </div>
                            <p class="mb-4">{{ $overview->description }}</p>
                            
                            {{-- ফিচার লিস্ট (কমা দিয়ে সেভ করা ডাটা অ্যারেতে রূপান্তর) --}}
                            @if($overview->features)
                                @foreach(explode(',', $overview->features) as $feature)
                                    <p class="{{ $loop->last ? 'mb-0' : 'mb-2' }}">
                                        <i class="fa fa-check-circle text-primary me-3"></i>{{ trim($feature) }}
                                    </p>
                                @endforeach
                            @endif
                        </div>

                        {{-- জোড় (Even) রো-তে ইমেজ ডানে থাকবে --}}
                        @if($loop->iteration % 2 == 0)
                            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                                <img class="img-fluid rounded" src="{{ asset($overview->image) }}" alt="{{ $overview->title }}">
                            </div>
                        @endif

                    </div>
                @endforeach
            @endisset
        </div>
    </div>
    <!-- Teachers Gellery -->
    <div class="container-xxl py-3">
        <div class="container text-center">
            <h2 class="mb-5 fw-bold"><span class="text-danger">Our</span> Respectfull Teachers !</h2>
            
            <div class="row g-4 justify-content-center">
                @foreach($teachers as $teacher)
                <div class="col-lg-3 col-md-6 mb-4 ">
                    <div class="teacher-item bg-light py-4 ">
                        <div class="mb-3 d-flex justify-content-center">
                            <div class="rounded-circle overflow-hidden" style="width: 200px; height: 200px; background: #f0f0f0;">
                                <img class="img-fluid" src="{{ asset($teacher->photo) }}" alt="{{ $teacher->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>

                        <h5 class="mb-1 fw-bold text-dark">{{ $teacher->name }}</h5>
                        <p class="text-muted small mb-2" style="line-height: 1;">{{ $teacher->designation ?? ''  }} | {{ $teacher->subject->name ?? '' }}</p>
                        <p class="text-muted small mb-3" style="line-height: 1;">{{ $teacher->qualification ?? '' }}</p>
                        <div class="d-flex justify-content-center gap-2">
                            @if($teacher->facebook)
                                <a href="{{ $teacher->facebook }}" class="social-btn fb" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($teacher->twitter)
                                <a href="{{ $teacher->twitter }}" class="social-btn tw" target="_blank"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if($teacher->linkedin)
                                <a href="{{ $teacher->linkedin }}" class="social-btn ln" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if($teacher->insta)
                                <a href="{{ $teacher->insta }}" class="social-btn inst" target="_blank"><i class="fab fa-instagram"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Contact  -->
    <div class="container-xxl py-6" id="contact">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="mb-3">Get In Touch</h1>
                    <p class="mb-4">If you have any queries regarding admission or academic information, please contact our office.</p>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
                            <i class="fa fa-phone-alt"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Call Us</p>
                            <h5 class="mb-0">{{ $school->phone ?? '+880 1XXX XXXXXX' }}</h5>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Mail Us</p>
                            <h5 class="mb-0">{{ $school->email ?? 'info@school.edu.bd' }}</h5>
                        </div>
                    </div>
                    <div class="d-flex mb-0">
                        <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Location</p>
                            <h5 class="mb-0">{{ $school->address ?? 'Dhaka, Bangladesh' }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store', ['tenant' => $school->slug]) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Your Name" value="{{ old('name') }}">
                                    <label for="name">Your Name</label>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Your Email" value="{{ old('email') }}">
                                    <label for="email">Your Email(Optional)</label>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Your number" value="{{ old('phone') }}">
                                    <label for="phone">Phone Number</label>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Leave a message here" id="message" style="height: 150px">{{ old('message') }}</textarea>
                                    <label for="message">Message</label>
                                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill py-3 px-5 shadow-sm transition" type="submit">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customJs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.counterup@2.1.0/jquery.counterup.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="counter-up"]').counterUp({
            delay: 10,
            time: 2000
        });
    });
</script>
@endsection