@extends('layouts.main')

@section('content')

<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('manage.frontend.index') }}">Frontend</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Contact Us</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit "Contact Us" Section</h6>
                    
                    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- হেডার ইনফরমেশন --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Subtitle</label>
                                <input type="text" name="subtitle" class="form-control" value="{{ $content['subtitle'] ?? 'Contact Us' }}">
                            </div>
    
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Main Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $content['title'] ?? '' }}">
                                <small class="text-muted">কালার করতে চাইলে: <code>&lt;span class="text-primary"&gt;Institution?&lt;/span&gt;</code> ব্যবহার করুন।</small>
                            </div>
    
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="2">{{ $content['description'] ?? '' }}</textarea>
                            </div>
    
                            <hr class="my-4">
                            <h5>Contact Information</h5>
    
                            {{-- অফিস অ্যাড্রেস --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Office Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="address" class="form-control" value="{{ $content['address'] ?? '' }}" placeholder="Dhaka, Bangladesh">
                                </div>
                            </div>
    
                            {{-- ফোন নম্বর --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="phone" class="form-control" value="{{ $content['phone'] ?? '' }}" placeholder="+880 1234 567890">
                                </div>
                            </div>
    
                            {{-- ইমেইল --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" value="{{ $content['email'] ?? '' }}" placeholder="support@educorexa.com">
                                </div>
                            </div>
                        </div>
    
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="link-icon me-2" data-feather="save"></i> Update Contact Section
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    // NobleUI এর ফেদার আইকন রেন্ডার করার জন্য
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>
@endpush