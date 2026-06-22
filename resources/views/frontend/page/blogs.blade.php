@extends('app-layouts.frontend')

@section('content')
<!-- Header / Hero Section -->
<section class="py-5 text-white position-relative overflow-hidden" style="margin-top: 70px; background: linear-gradient(135deg, #0b1324 0%, #1a233a 100%);">
    <div class="container py-5 position-relative z-index-2">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3 fw-bold animate-fade-in">আমাদের ব্লগ ও খবর</div>
                <h1 class="display-3 fw-bolder mb-3 tracking-tight text-white">ব্লগ ও <span class="text-primary">প্রবন্ধ</span></h1>
                <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 600px;">আমাদের শিক্ষা প্রতিষ্ঠানের সর্বশেষ খবর, ঘটনা এবং শিক্ষামূলক ব্লগ পোস্টগুলো এখানে পড়ুন।</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('main.home') }}" class="text-white-50 text-decoration-none hover-white">হোম</a></li>
                        <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">ব্লগ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="position-absolute top-0 start-0 bg-primary opacity-10 rounded-circle blur-3xl" style="width: 400px; height: 400px; transform: translate(-30%, -30%);"></div>
    <div class="position-absolute bottom-0 end-0 bg-info opacity-10 rounded-circle blur-3xl" style="width: 300px; height: 300px; transform: translate(30%, 30%);"></div>
</section>

<!-- Blogs Listing Section -->
<section class="py-5 bg-white">
    <div class="container py-lg-5">
        @if($blogs->count() > 0)
            <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
                @foreach($blogs as $blog)
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 shadow-sm hover-shadow-lg transition-all duration-300 blog-card-wrapper overflow-hidden flex flex-column">
                            
                            <!-- Blog Image & Category -->
                            <div class="position-relative overflow-hidden shrink-0" style="height: 220px;">
                                @if($blog->image)
                                    <img src="{{ Str::startsWith($blog->image, ['http://','https://']) ? $blog->image : asset($blog->image) }}" 
                                         alt="" 
                                         class="w-100 h-100 object-cover blog-card-img transition-transform duration-500">
                                @else
                                    <div class="w-100 h-100 bg-slate-100 d-flex flex-column align-items-center justify-center text-slate-400">
                                        <span class="material-symbols-outlined text-5xl mb-2">image</span>
                                        <span class="small">কোনো ছবি নেই</span>
                                    </div>
                                @endif
                                <span class="position-absolute top-3 start-3 bg-primary text-white text-xs font-bold px-3 py-1 rounded-3 shadow">
                                    {{ $blog->category->name ?? 'General' }}
                                </span>
                            </div>

                            <!-- Blog Content -->
                            <div class="card-body p-4 d-flex flex-column justify-between flex-grow-1">
                                <div class="space-y-3">
                                    <!-- Meta Information -->
                                    <div class="d-flex align-items-center justify-content-between text-slate-500 text-xs mb-2">
                                        <span class="d-flex align-items-center gap-1.5">
                                            <span class="material-symbols-outlined text-sm text-primary">person</span>
                                            <span>{{ $blog->author }}</span>
                                        </span>
                                        <span class="d-flex align-items-center gap-1.5">
                                            <span class="material-symbols-outlined text-sm text-primary">calendar_month</span>
                                            <span>{{ $blog->created_at->format('d M, Y') }}</span>
                                        </span>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h4 class="card-title fw-bold text-slate-900 line-clamp-2 hover-primary-color transition-colors" style="font-size: 1.15rem; min-height: 2.7rem; line-height: 1.4;">
                                        <a href="{{ route('main.blog.details', $blog->slug) }}" class="text-decoration-none text-slate-900 hover-primary-color">
                                            {{ $blog->title }}
                                        </a>
                                    </h4>
                                    
                                    <!-- Excerpt -->
                                    <p class="text-slate-600 text-sm line-clamp-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($blog->content), 120) }}
                                    </p>
                                </div>

                                <!-- Read More Button -->
                                <div class="pt-4 border-t border-slate-100 mt-4">
                                    <a href="{{ route('main.blog.details', $blog->slug) }}" 
                                       class="text-primary hover:text-indigo-600 font-bold text-sm d-flex align-items-center justify-content-between text-decoration-none group-btn-arrow">
                                        <span>বিস্তারিত পড়ুন</span>
                                        <span class="material-symbols-outlined transition-transform duration-300 arrow-icon text-sm">arrow_forward</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Container -->
            <div class="d-flex justify-content-center mt-5 pt-4">
                {{ $blogs->links('pagination::bootstrap-5') }}
            </div>
        @else
            <!-- No Blogs Found State -->
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-center mb-4" style="width: 100px; height: 100px;">
                    <span class="material-symbols-outlined text-muted text-5xl">article</span>
                </div>
                <h3 class="fw-bold text-dark">কোনো ব্লগ পাওয়া যায়নি</h3>
                <p class="text-muted">দয়া করে পরবর্তীতে আবার ভিজিট করুন অথবা আমাদের সাথে যোগাযোগ করুন।</p>
                <a href="{{ route('main.home') }}" class="btn btn-primary rounded-pill px-4 mt-3">হোমে ফিরে যান</a>
            </div>
        @endif
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
    
    .hover-shadow-lg:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .blog-card-wrapper {
        border: 1px solid rgba(0,0,0,0.05) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .blog-card-wrapper:hover {
        transform: translateY(-5px);
    }

    .blog-card-img {
        transition: transform 0.5s ease;
    }
    .blog-card-wrapper:hover .blog-card-img {
        transform: scale(1.05);
    }

    .hover-primary-color:hover {
        color: #6571ff !important;
    }

    /* Arrow transition */
    .group-btn-arrow:hover .arrow-icon {
        transform: translateX(5px);
    }
    .arrow-icon {
        transition: transform 0.3s ease;
    }
    
    /* Pagination Styling Customization */
    .pagination .page-item.active .page-link {
        background-color: #6571ff !important;
        border-color: #6571ff !important;
        color: #fff !important;
    }
    .pagination .page-link {
        color: #6571ff;
        border-radius: 8px;
        margin: 0 3px;
    }
    .pagination .page-link:hover {
        background-color: rgba(101, 113, 255, 0.1);
        color: #6571ff;
    }
</style>
