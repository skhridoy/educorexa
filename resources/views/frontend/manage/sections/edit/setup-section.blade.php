@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Edit Setup Process Section</h6>
            <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Subtitle (Badge Text)</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ $content['subtitle'] ?? 'Easy Onboarding' }}">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Main Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $content['title'] ?? 'Get Started in 3 Simple Steps' }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ $content['description'] ?? 'মাত্র কয়েক মিনিটেই আপনার স্কুলকে ডিজিটালাইজ করুন। কোনো টেকনিক্যাল নলেজের প্রয়োজন নেই।' }}</textarea>
                    </div>

                    <h5 class="mb-3 mt-4">Step 1</h5>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="step1_title" class="form-control" value="{{ $content['step1_title'] ?? 'Register School' }}">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="step1_desc" class="form-control" value="{{ $content['step1_desc'] ?? 'আপনার প্রতিষ্ঠানের নাম, ইমেইল এবং মোবাইল নাম্বার দিয়ে রেজিস্ট্রেশন সম্পন্ন করুন।' }}">
                    </div>

                    <h5 class="mb-3 mt-4">Step 2</h5>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="step2_title" class="form-control" value="{{ $content['step2_title'] ?? 'Basic Setup' }}">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="step2_desc" class="form-control" value="{{ $content['step2_desc'] ?? 'ক্লাস, সেকশন এবং ফি স্ট্রাকচার সেটআপ করে আপনার প্যানেলটি প্রস্তুত করুন।' }}">
                    </div>

                    <h5 class="mb-3 mt-4">Step 3</h5>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="step3_title" class="form-control" value="{{ $content['step3_title'] ?? 'Go Live' }}">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="step3_desc" class="form-control" value="{{ $content['step3_desc'] ?? 'স্টুডেন্ট ডাটা আপলোড করুন এবং আপনার স্মার্ট স্কুল ম্যানেজমেন্ট এনজয় করুন।' }}">
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary px-5">Update Setup Section</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
