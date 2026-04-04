@extends('layouts.school')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Footer Settings</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Update Footer Information</h6>
                    <form action="{{ route('footer.update', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- কলাম ১: স্কুলের মূল তথ্য (School Table) --}}
                            <div class="col-sm-6">
                                <h5 class="mb-3 text-primary">Basic Contact Info</h5>
                                <div class="mb-3">
                                    <label class="form-label">School Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $school->address }}" placeholder="e.g. 123 Street, Dhaka">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $school->phone }}" placeholder="+880 1XXX-XXXXXX">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Official Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $school->email }}" placeholder="info@school.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Newsletter Description</label>
                                    <textarea name="newsletter_text" class="form-control" rows="4">{{ $school->footerSetting?->newsletter_text }}</textarea>
                                </div>
                            </div>

                            {{-- কলাম ২: সোশ্যাল লিঙ্ক (FooterSettings Table) --}}
                            <div class="col-sm-6">
                                <h5 class="mb-3 text-info">Social Media Links</h5>
                                <div class="mb-3">
                                    <label class="form-label">Facebook URL</label>
                                    <input type="url" name="facebook" class="form-control" value="{{ $school->footerSetting?->facebook }}" placeholder="https://facebook.com/your-school">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Twitter (X) URL</label>
                                    <input type="url" name="twitter" class="form-control" value="{{ $school->footerSetting?->twitter }}" placeholder="https://twitter.com/your-school">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Instagram URL</label>
                                    <input type="url" name="instagram" class="form-control" value="{{ $school->footerSetting?->instagram }}" placeholder="https://instagram.com/your-school">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">LinkedIn URL</label>
                                    <input type="url" name="linkedin" class="form-control" value="{{ $school->footerSetting?->linkedin }}" placeholder="https://linkedin.com/school/your-school">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Copyright Text</label>
                                    <input type="text" name="copyright_text" class="form-control" value="{{ $school->footerSetting?->copyright_text }}" placeholder="e.g. All Rights Reserved.">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Save Footer Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection