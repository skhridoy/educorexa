@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Edit Footer Section</h6>
            <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">About Text</label>
                        <textarea name="about_text" class="form-control" rows="3">{{ $content['about_text'] ?? 'আমাদের লক্ষ্য শিক্ষা প্রতিষ্ঠানগুলোকে আধুনিক প্রযুক্তির মাধ্যমে আরও গতিশীল এবং স্মার্ট করে তোলা। একটি সমন্বিত ইআরপি সমাধান যা আপনার কাজকে করবে সহজ।' }}</textarea>
                    </div>

                    <h5 class="mb-3 mt-4">Contact Information</h5>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ $content['address'] ?? 'Dhaka, Bangladesh' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $content['phone'] ?? '+880123456789' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ $content['email'] ?? 'support@educorexa.com' }}">
                    </div>

                    <h5 class="mb-3 mt-4">Social Links</h5>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Facebook Link</label>
                        <input type="text" name="fb_link" class="form-control" value="{{ $content['fb_link'] ?? '#' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Twitter/X Link</label>
                        <input type="text" name="tw_link" class="form-control" value="{{ $content['tw_link'] ?? '#' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">LinkedIn Link</label>
                        <input type="text" name="in_link" class="form-control" value="{{ $content['in_link'] ?? '#' }}">
                    </div>

                    <h5 class="mb-3 mt-4">Copyright</h5>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Copyright Text</label>
                        <input type="text" name="copyright_text" class="form-control" value="{{ $content['copyright_text'] ?? '© 2026 EduCorexa. All Rights Reserved.' }}">
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary px-5">Update Footer Section</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
