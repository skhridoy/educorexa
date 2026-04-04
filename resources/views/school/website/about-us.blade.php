@extends('school.website.layouts.app')

@section('customCSS')
    <style>
        /* হোম পেজের স্টাইলের সাথে মিল রেখে */
        .page-header {
            background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url({{ asset('main/img/about.jpg') }}) center center no-repeat;
            background-size: cover;
            padding: 100px 0;
            margin-bottom: 6rem;
        }
        
        .school-logo { height: 50px; width: auto; }
        .school-name { font-size: 1.75rem; font-weight: 700; }

        .about-img {
            border-radius: 20px;
            box-shadow: 0 0 45px rgba(0,0,0,.1);
        }

        .feature-box {
            transition: transform 0.3s ease;
            border-bottom: 4px solid transparent;
        }

        .feature-box:hover {
            transform: translateY(-10px);
            border-color: var(--bs-primary);
        }

        .stats-bg {
            background: var(--bs-primary);
            border-radius: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid page-header wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <h1 class="display-3 text-white mb-3 animated slideInDown">আমাদের সম্পর্কে</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">হোম</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">About</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-xxl py-6">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="about-img-container position-relative">
                        <img class="img-fluid about-img" src="{{ asset($about->image ?? 'main/img/about.jpg') }}">
                        <div class="stats-bg position-absolute bottom-0 end-0 p-4 mb-n4 me-n4 text-white d-none d-sm-block">
                            <h1 class="display-4 text-white mb-0">২৫+</h1>
                            <small>বছরের অভিজ্ঞতা</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="d-flex align-items-center mb-3">
                        <span class="bg-primary mx-2" style="width: 30px; height: 2px;"></span>
                        <h5 class="text-primary mb-0">প্রতিষ্ঠানের পরিচিতি</h5>
                    </div>
                    <h1 class="mb-4">{{ $about->title ?? 'একটি উজ্জ্বল ভবিষ্যৎ গড়ার প্রত্যয়ে আমাদের পথচলা' }}</h1>
                    <p class="mb-4 text-muted">{{ $about->description ?? 'আমাদের লক্ষ্য শুধু পাঠ্যবইয়ের শিক্ষা নয়, বরং নৈতিকতা ও আধুনিক প্রযুক্তির সমন্বয়ে প্রতিটি শিক্ষার্থীকে একজন সুনাগরিক হিসেবে গড়ে তোলা।' }}</p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>আধুনিক পাঠদান পদ্ধতি
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>অভিজ্ঞ শিক্ষক মন্ডলী
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>নিরাপদ ক্যাম্পাস
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>ডিজিটাল ল্যাব সুবিধা
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-6 bg-light">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">লক্ষ্য ও উদ্দেশ্য</h1>
                <p>আমরা বিশ্বাস করি সঠিক শিক্ষা এবং উন্নত পরিবেশই পারে একটি সমৃদ্ধ জাতি গঠন করতে।</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-box bg-white rounded shadow-sm text-center p-5">
                        <i class="fa fa-eye fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">ভিশন (Vision)</h5>
                        <p class="m-0">আধুনিক প্রযুক্তি ও নৈতিক শিক্ষার সমন্বয়ে স্মার্ট নাগরিক গড়ে তোলা।</p>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-box bg-white rounded shadow-sm text-center p-5">
                        <i class="fa fa-bullseye fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">মিশন (Mission)</h5>
                        <p class="m-0">শিক্ষার্থীদের সৃজনশীলতা ও মেধার বিকাশে একটি যুগোপযোগী পরিবেশ নিশ্চিত করা।</p>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="feature-box bg-white rounded shadow-sm text-center p-5">
                        <i class="fa fa-heart fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">আমাদের মূল্যবোধ</h5>
                        <p class="m-0">সততা, শৃঙ্খলা এবং দেশপ্রেম আমাদের প্রতিটি পদক্ষেপের মূল চালিকাশক্তি।</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- আপনি চাইলে এখানে হোম পেজের মতো Teachers section টিও @include করতে পারেন --}}
@endsection