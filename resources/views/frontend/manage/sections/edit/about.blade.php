@extends('layouts.main')

@section('customCSS')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
  <style>
    .img-container img { max-width: 100%; }
    #imagePreview { max-width: 300px; cursor: pointer; border: 2px dashed #ddd; padding: 10px; border-radius: 10px; }
  </style>
@endsection

@section('content')
<div class="page-content">

    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Edit About Us Section</h6>
            <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                @csrf
                <div class="row">
                    {{-- ইমেজ আপলোড --}}
                    <div class="col-md-12 mb-4 text-center">
                        <label class="form-label d-block fw-bold">Section Image</label>
                        <input type="file" id="imageInput" class="form-control mb-2" accept="image/*">
                        <input type="hidden" name="image" id="croppedImageData">
                        <img id="imagePreview" src="{{ asset($content['image'] ?? 'frontend/img/about-vision.jpg') }}" class="img-thumbnail shadow-sm">
                    </div>
    
                    {{-- টেক্সট কন্টেন্ট --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Badge Text</label>
                        <input type="text" name="badge_text" class="form-control" value="{{ $content['badge_text'] ?? 'WHO WE ARE' }}">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Main Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $content['title'] ?? '' }}">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $content['description'] ?? '' }}</textarea>
                    </div>
    
                    <hr>
                    <h5 class="mb-3">Floating Badges & Features</h5>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Years of Experience</label>
                        <input type="text" name="exp_year" class="form-control" value="{{ $content['exp_year'] ?? '' }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Support Hours</label>
                        <input type="text" name="support_time" class="form-control" value="{{ $content['support_time'] ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $content['phone'] ?? '' }}">
                    </div>
    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Feature 1 Title</label>
                        <input type="text" name="f1_title" class="form-control" value="{{ $content['f1_title'] ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Feature 2 Title</label>
                        <input type="text" name="f2_title" class="form-control" value="{{ $content['f2_title'] ?? '' }}">
                    </div>
    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary px-5">Update About Section</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ক্রপার মোডাল আগের মতোই থাকবে --}}
@include('frontend.partials.cropper_modal') 
@endsection