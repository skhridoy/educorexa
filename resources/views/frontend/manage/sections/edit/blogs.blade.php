@extends('layouts.main')

@section('content')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('manage.frontend.index') }}">Frontend</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Blog Slider Section</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Homepage Blog Slider Section Settings</h6>
                    
                    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- মেটা তথ্য --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Badge Text (ছোট ক্যাটাগরি লেখা)</label>
                                <input type="text" name="badge_text" class="form-control" value="{{ $content['badge_text'] ?? 'আমাদের ব্লগ ও খবর' }}">
                            </div>
    
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Section Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $content['title'] ?? 'সর্বশেষ আপডেট ও শিক্ষামূলক প্রবন্ধ' }}">
                            </div>
    
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Section Description / Subtitle</label>
                                <textarea name="description" class="form-control" rows="3">{{ $content['description'] ?? 'আমাদের প্রতিষ্ঠানের সর্বশেষ খবর, ঘটনা এবং শিক্ষামূলক ব্লগ পোস্টগুলো এখানে পড়ুন।' }}</textarea>
                            </div>
                        </div>

                        {{-- ব্লগ ম্যানেজমেন্ট CTA --}}
                        <div class="alert alert-info border border-info-subtle rounded-3 p-4 my-4 d-flex align-items-start gap-3">
                            <div class="bg-info-subtle text-info p-2 rounded-2 flex-shrink-0">
                                <i data-feather="info" class="align-middle" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-1 text-info-emphasis" style="font-weight: 700;">ব্লগ পোস্ট পরিচালনা নির্দেশিকা</h5>
                                <p class="mb-3 text-secondary" style="font-size: 0.9rem; line-height: 1.5;">
                                    এই পেজটি শুধুমাত্র হোম পেজে ব্লগ স্লাইডার সেকশনের শিরোনাম এবং ছোট বর্ণনা পরিবর্তন করার জন্য। 
                                    নতুন ব্লগ পোস্ট তৈরি করা, বর্তমান পোস্ট এডিট করা অথবা কোনো ব্লগ পোস্ট ডিলিট করার জন্য ডেডিকেটেড **"Manage Blogs"** পেজে যেতে হবে।
                                </p>
                                <a href="{{ route('super.blogs.index') }}" class="btn btn-info text-white font-weight-bold d-inline-flex align-items-center gap-1">
                                    <i data-feather="file-text" style="width: 16px; height: 16px;"></i> ব্লগ পোস্টগুলো পরিচালনা করুন
                                </a>
                            </div>
                        </div>
    
                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">Update Section Settings</button>
                            <a href="{{ route('manage.frontend.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    $(function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endpush
