@php
    use App\Models\FrontendSection;
    use App\Models\Blog;

    $section = FrontendSection::where('key', 'blogs')->first();
    $blogsContent = [];
    if($section) {
        $blogsContent = json_decode($section->content, true) ?? [];
    }

    $badge = $blogsContent['badge_text'] ?? 'আমাদের ব্লগ ও খবর';
    $title = $blogsContent['title'] ?? 'সর্বশেষ আপডেট ও শিক্ষামূলক প্রবন্ধ';
    $description = $blogsContent['description'] ?? 'আমাদের প্রতিষ্ঠানের সর্বশেষ খবর, ঘটনা এবং শিক্ষামূলক ব্লগ পোস্টগুলো এখানে পড়ুন।';
    
    // Fetch active blogs
    $blogs = Blog::where('status', 1)->latest()->get();
@endphp

@if($section && $section->status && $blogs->count() > 0)
<!-- Blogs Section -->
<section id="blog" class="py-20 md:py-32 px-4 md:px-8 bg-gradient-to-b from-white to-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto space-y-16">
        
        <!-- Header -->
        <div class="text-center space-y-4 max-w-3xl mx-auto">
            <span class="px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider rounded-full inline-block">
                {{ $badge }}
            </span>
            <h2 class="font-headline-lg text-headline-lg text-slate-900 tracking-tight leading-tight">
                {!! $title !!}
            </h2>
            <p class="font-body-md text-slate-600 max-w-xl mx-auto">
                {{ $description }}
            </p>
        </div>

        <!-- Swiper Container -->
        <div class="swiper blogSwiper pb-12">
            <div class="swiper-wrapper">
                @foreach($blogs as $blog)
                <div class="swiper-slide p-2">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-[390px] overflow-hidden group">
                        
                        <!-- Blog Image & Category -->
                        <div class="relative h-40 overflow-hidden shrink-0">
                            @if($blog->image)
                                <img src="{{ Str::startsWith($blog->image, ['http://','https://']) ? $blog->image : asset($blog->image) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <span class="material-symbols-outlined text-5xl">image</span>
                                </div>
                            @endif
                            <span class="absolute top-4 left-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-md shadow-md">
                                {{ $blog->category->name ?? 'General' }}
                            </span>
                        </div>

                        <!-- Blog Content -->
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <div class="space-y-2">
                                <!-- Meta -->
                                <div class="flex items-center justify-between text-slate-500 text-[11px]">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-primary">person</span>
                                        {{ $blog->author }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-primary">calendar_month</span>
                                        {{ $blog->created_at->format('d M, Y') }}
                                    </span>
                                </div>
                                
                                <!-- Title -->
                                <h3 class="font-headline-md text-sm font-semibold text-slate-900 group-hover:text-primary transition-colors line-clamp-2 leading-snug">
                                    {{ $blog->title }}
                                </h3>
                                
                                <!-- Excerpt -->
                                <p class="text-slate-600 font-body-md text-xs line-clamp-2 leading-relaxed">
                                    {{ Str::limit(strip_tags($blog->content), 85) }}
                                </p>
                            </div>

                            <!-- Read More Button -->
                            <div class="pt-4 border-t border-slate-100">
                                <a href="{{ route('main.blog.details', $blog->slug) }}" 
                                   class="text-primary hover:text-[#004d85] font-bold text-sm flex items-center gap-1 transition-colors w-full justify-between group/btn">
                                    <span>বিস্তারিত পড়ুন</span>
                                    <span class="material-symbols-outlined transition-transform duration-300 group-hover/btn:translate-x-1 text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="swiper-pagination mt-4"></div>
        </div>

    </div>
</section>



<style>
    /* Swiper Styling */
    .blogSwiper .swiper-pagination-bullet-active {
        background: #4648d4 !important;
        width: 24px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var blogSwiper = new Swiper(".blogSwiper", {
            slidesPerView: 1,
            spaceBetween: 16,
            loop: false,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        });
    });
</script>
@endif
