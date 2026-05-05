@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    .star-rating { display:flex; gap:10px; flex-direction:row-reverse; justify-content:flex-end; }
    .star-rating input { display:none; }
    .star-rating label { font-size:24px; color:#cbd5e1; cursor:pointer; transition:color 0.2s; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color:#fbbf24; }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.testimonials.index') }}">Testimonials</a></li>
        <li><span>/</span></li>
        <li class="active">Edit Testimonial</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-pen-to-square me-2" style="color:#4f46e5;"></i> Edit Testimonial</h2>
            <p class="edu-page-sub">Update reviewer details, rating, or message for this success story.</p>
        </div>
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">Testimonial Content</h6>
        </div>
        <div class="edu-panel-bd">
            <form action="{{ route('super.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="edu-label">Reviewer Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control edu-input" value="{{ old('name', $testimonial->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Designation / Role</label>
                        <input type="text" name="designation" class="form-control edu-input" value="{{ old('designation', $testimonial->designation) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Institution / School Name</label>
                        <input type="text" name="institution_name" class="form-control edu-input" value="{{ old('institution_name', $testimonial->institution_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Star Rating <span class="text-danger">*</span></label>
                        <div class="star-rating">
                            @for($i=5; $i>=1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $testimonial->rating == $i ? 'checked' : '' }}>
                                <label for="star{{ $i }}" title="{{ $i }} stars"><i class="fa-solid fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="edu-label">Testimonial Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control edu-input" rows="5" required>{{ old('message', $testimonial->message) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="edu-label">Reviewer Photo</label>
                        <div class="d-flex align-items-center gap-3">
                            @if($testimonial->image)
                                <img src="{{ asset($testimonial->image) }}" style="width:60px; height:60px; border-radius:12px; object-fit:cover; border:2px solid #eef2ff;">
                            @endif
                            <input type="file" name="image" class="form-control edu-input" accept="image/*">
                        </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check form-switch" style="display:flex; align-items:center; gap:10px;">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" style="width:40px; height:20px; cursor:pointer;" {{ $testimonial->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive" style="font-weight:700; color:#1e293b; cursor:pointer;">Active Testimonial</label>
                        </div>
                    </div>

                    <div class="col-12 edu-divider"></div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('super.testimonials.index') }}" class="btn-edu btn-edu-light" style="padding:12px 30px;">Cancel</a>
                        <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 40px;">
                            <i data-feather="refresh-cw" style="width:16px; margin-right:5px;"></i> Update Testimonial
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
