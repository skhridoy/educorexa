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
        <li class="active">Add Testimonial</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-plus-circle me-2" style="color:#4f46e5;"></i> Add Testimonial</h2>
            <p class="edu-page-sub">Capture success stories and feedback from our valued institutional partners.</p>
        </div>
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">Testimonial Content</h6>
        </div>
        <div class="edu-panel-bd">
            <form action="{{ route('super.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="edu-label">Reviewer Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control edu-input" placeholder="e.g. John Doe" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Designation / Role</label>
                        <input type="text" name="designation" class="form-control edu-input" placeholder="e.g. Principal / IT Coordinator" value="{{ old('designation') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Institution / School Name</label>
                        <input type="text" name="institution_name" class="form-control edu-input" placeholder="e.g. Oakridge International" value="{{ old('institution_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Star Rating <span class="text-danger">*</span></label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" checked><label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="edu-label">Testimonial Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control edu-input" rows="5" placeholder="Share the feedback here..." required>{{ old('message') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="edu-label">Reviewer Photo</label>
                        <input type="file" name="image" class="form-control edu-input" accept="image/*">
                        <p style="font-size:0.75rem; color:#94a3b8; margin-top:8px;">Recommended: Square photo (min 200x200px)</p>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check form-switch" style="display:flex; align-items:center; gap:10px;">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" style="width:40px; height:20px; cursor:pointer;" checked>
                            <label class="form-check-label" for="isActive" style="font-weight:700; color:#1e293b; cursor:pointer;">Publish Testimonial</label>
                        </div>
                    </div>

                    <div class="col-12 edu-divider"></div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('super.testimonials.index') }}" class="btn-edu btn-edu-light" style="padding:12px 30px;">Cancel</a>
                        <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 40px;">
                            <i data-feather="check-circle" style="width:16px; margin-right:5px;"></i> Save Testimonial
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
