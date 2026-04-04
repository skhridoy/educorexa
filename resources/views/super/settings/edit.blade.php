@extends('layouts.main') {{-- NobleUI এর মাস্টার লেআউট --}}

@section('content')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Site Settings</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">General Site Settings</h6>
                    <p class="text-muted mb-3">এখানে আপনার মেইন ডোমেইন (Educorexa.com) এর লোগো এবং ইনফরমেশন আপডেট করুন।</p>

                    @if(session('success'))
                        <div class="alert alert-fill-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('super.settings.update') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site Name</label>
                                <input type="text" name="site_name" class="form-control" value="{{ $setting->site_name ?? 'EduCorexa' }}" placeholder="Enter Site Name">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $setting->email ?? '' }}" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ $setting->phone ?? '' }}" placeholder="Enter Phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $setting->address ?? '' }}" placeholder="Enter Address">
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-4 text-primary">Branding & Logos</h6>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Wide Logo (Header)</label>
                                <input type="file" name="logo_wide" class="form-control mb-2" onchange="previewImage(this, 'wide_preview')">
                                <div class="bg-light p-2 text-center rounded">
                                    <img id="wide_preview" src="{{ $setting && $setting->logo_wide ? asset($setting->logo_wide) : asset('frontend/img/placeholder-wide.png') }}" style="max-width: 100%; height: 50px;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Square Logo</label>
                                <input type="file" name="logo_square" class="form-control mb-2" onchange="previewImage(this, 'square_preview')">
                                <div class="bg-light p-2 text-center rounded">
                                    <img id="square_preview" src="{{ $setting && $setting->logo_square ? asset('storage/'.$setting->logo_square) : asset('frontend/img/placeholder-square.png') }}" style="width: 80px; height: 80px;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Favicon</label>
                                <input type="file" name="favicon" class="form-control mb-2" onchange="previewImage(this, 'favicon_preview')">
                                <div class="bg-light p-2 text-center rounded">
                                    <img id="favicon_preview" src="{{ $setting && $setting->favicon ? asset('storage/'.$setting->favicon) : asset('frontend/img/favicon.ico') }}" style="width: 32px; height: 32px;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Footer Text / Copyright</label>
                            <textarea name="footer_text" class="form-control" rows="3">{{ $setting->footer_text ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ইমেজ প্রিভিউ করার জন্য স্ক্রিপ্ট --}}
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection