@extends('app-layouts.frontend')

@section('content')
<!-- Header / Hero Section -->
<section class="py-5 text-white position-relative overflow-hidden" style="margin-top: 70px; background: linear-gradient(135deg, #0b1324 0%, #1a233a 100%);">
    <div class="container py-5 position-relative z-index-2">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3 fw-bold animate-fade-in">
                    {{ $blog->category->name ?? 'General' }}
                </div>
                <h1 class="display-4 fw-bolder mb-3 tracking-tight text-white leading-tight">
                    {{ $blog->title }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('main.home') }}" class="text-white-50 text-decoration-none hover-white">হোম</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('main.blogs') }}" class="text-white-50 text-decoration-none hover-white">ব্লগ</a></li>
                        <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">বিস্তারিত</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="position-absolute top-0 start-0 bg-primary opacity-10 rounded-circle blur-3xl" style="width: 400px; height: 400px; transform: translate(-30%, -30%);"></div>
    <div class="position-absolute bottom-0 end-0 bg-info opacity-10 rounded-circle blur-3xl" style="width: 300px; height: 300px; transform: translate(30%, 30%);"></div>
</section>

<!-- Blog Content Section -->
<section class="py-5 bg-white">
    <div class="container py-lg-4">
        <div class="row g-5">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="pe-lg-3">
                    
                    <!-- Blog Image -->
                    <div class="blog-featured-image-box shadow-lg rounded-4 overflow-hidden mb-4 border border-light">
                        @if($blog->image)
                            <img src="{{ Str::startsWith($blog->image, ['http://','https://']) ? $blog->image : asset($blog->image) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="img-fluid w-100 object-cover" 
                                 style="max-height: 450px; width: 100%;">
                        @else
                            <div class="w-full bg-slate-100 flex items-center justify-center text-slate-400 py-5 text-center" style="min-height: 300px;">
                                <span class="material-symbols-outlined text-6xl d-block mb-2">image</span>
                                <span>কোনো ছবি নেই</span>
                            </div>
                        @endif
                    </div>

                    <!-- Meta details -->
                    <div class="d-flex flex-wrap align-items-center gap-4 text-slate-500 text-sm border-b border-slate-100 pb-3 mb-4">
                        <span class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">person</span>
                            <span>লেখক: <strong>{{ $blog->author }}</strong></span>
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">calendar_month</span>
                            <span>তারিখ: <strong>{{ $blog->created_at->format('d M, Y') }}</strong></span>
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">label</span>
                            <span>ক্যাটাগরি: <strong>{{ $blog->category->name ?? 'General' }}</strong></span>
                        </span>
                    </div>

                    <!-- Main Text Content -->
                    <div class="blog-full-content text-slate-800 font-body-md fs-5 lh-lg mb-5" style="text-align: justify;">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    <!-- Back Button -->
                    <div class="pt-4 border-t border-slate-100">
                        <a href="{{ route('main.home') }}#blog" class="btn btn-outline-primary btn-lg rounded-pill px-4 py-2.5 d-inline-flex align-items-center gap-2 shadow-sm transition-all duration-300 hover-translate-x-left">
                            <span class="material-symbols-outlined text-base">arrow_back</span>
                            <span>ফিরে যান</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar / Related Blogs -->
            <div class="col-lg-4">
                <div class="blog-sidebar ps-lg-3">
                    
                    @php
                        $recentBlogs = \App\Models\Blog::where('status', 1)
                                                      ->where('id', '!=', $blog->id)
                                                      ->latest()
                                                      ->take(4)
                                                      ->get();
                    @endphp

                    @if($recentBlogs->count() > 0)
                        <!-- Recent Blogs Widget -->
                        <div class="card border-0 rounded-4 shadow-sm p-4 bg-light mb-4">
                            <h4 class="fw-bold text-dark mb-4 pb-2 d-inline-block" style="border-bottom: 2px solid #6571ff;">অন্যান্য ব্লগ</h4>
                            <div class="d-flex flex-column gap-4">
                                @foreach($recentBlogs as $recent)
                                    <div class="d-flex gap-3 align-items-start group-sidebar-item">
                                        <div class="shrink-0 rounded-3 overflow-hidden shadow-sm" style="width: 80px; height: 80px;">
                                            @if($recent->image)
                                                <img src="{{ Str::startsWith($recent->image, ['http://','https://']) ? $recent->image : asset($recent->image) }}" 
                                                     alt="" 
                                                     class="w-100 h-100 object-cover">
                                            @else
                                                <div class="w-100 h-100 bg-slate-200 d-flex align-items-center justify-center text-slate-400">
                                                    <span class="material-symbols-outlined text-sm">image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <span class="text-primary x-small fw-bold uppercase d-block mb-1">{{ $recent->category->name ?? 'General' }}</span>
                                            <h5 class="font-headline-sm text-sm mb-1 line-clamp-2 leading-tight">
                                                <a href="{{ route('main.blog.details', $recent->slug) }}" class="text-dark text-decoration-none hover-primary fw-semibold">
                                                    {{ $recent->title }}
                                                </a>
                                            </h5>
                                            <span class="text-muted x-small d-block">{{ $recent->created_at->format('d M, Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Need Help / School ERP Promo Widget -->
                    <div class="card border-0 rounded-4 shadow-sm p-4 text-white overflow-hidden position-relative" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
                        <div class="position-relative z-index-2">
                            <h4 class="fw-bold mb-3">স্মার্ট স্কুল ম্যানেজমেন্ট সিস্টেম</h4>
                            <p class="small text-white-80 text-opacity-90 mb-4 leading-relaxed">
                                আপনার শিক্ষা প্রতিষ্ঠানকে আধুনিক ও ডিজিটাল করতে আজই যুক্ত হোন আমাদের সাথে। পরিচালনা করুন ভর্তি, ফি, হাজিরা এবং ফলাফল এক ক্লিকে।
                            </p>
                            <a href="{{ route('main.home') }}#pricing" class="btn btn-white bg-white text-primary rounded-pill px-4 py-2 fw-bold text-sm shadow-sm transition-all hover:bg-light">
                                প্যাকেজসমূহ দেখুন
                            </a>
                        </div>
                        <div class="position-absolute bottom-0 end-0 opacity-10 translate-middle-x" style="font-size: 150px; line-height: 0;">
                            <span class="material-symbols-outlined" style="font-size: inherit;">school</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
    /* Styling elements matching main theme */
    .bg-primary-soft { background-color: rgba(101, 113, 255, 0.1); }
    .text-primary { color: #6571ff !important; }
    .text-white-50 { color: rgba(255, 255, 255, 0.5) !important; }
    .hover-white:hover { color: #fff !important; }
    .blur-3xl { filter: blur(60px); }
    .z-index-2 { z-index: 2; }
    .x-small { font-size: 0.75rem; }
    
    .blog-featured-image-box img {
        transition: transform 0.5s ease;
    }
    .blog-featured-image-box:hover img {
        transform: scale(1.02);
    }

    .hover-primary:hover {
        color: #6571ff !important;
        transition: color 0.2s ease;
    }

    /* Back button micro-animation */
    .hover-translate-x-left:hover .material-symbols-outlined {
        transform: translateX(-4px);
    }
    .hover-translate-x-left .material-symbols-outlined {
        transition: transform 0.2s ease;
    }

    /* Sidebar hover effect */
    .group-sidebar-item img {
        transition: transform 0.3s ease;
    }
    .group-sidebar-item:hover img {
        transform: scale(1.08);
    }
</style>
