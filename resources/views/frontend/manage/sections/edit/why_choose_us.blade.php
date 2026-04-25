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

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('manage.frontend.index') }}">Frontend</a></li>
            <li class="breadcrumb-item active" aria-current="page">Why Choose Us</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit "Why Choose Us" Content</h6>
                    
                    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- ইমেজ আপলোড সেকশন --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Section Image</label>
                                <input type="file" id="imageInput" class="form-control mb-2" accept="image/*">
                                <input type="hidden" name="image" id="croppedImageData">
                                
                                <div class="mt-2 text-center">
                                    <img id="imagePreview" src="{{ asset($content['image'] ?? 'frontend/img/why-choose.jpg') }}" class="img-thumbnail shadow-sm">
                                    <p class="text-muted small mt-2">ছবি পরিবর্তন করতে উপরে ক্লিক করুন।</p>
                                </div>
                            </div>
    
                            {{-- টাইটেল ও ডেসক্রিপশন --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $content['title'] ?? '' }}">
                                <small class="text-muted">কালার করতে চাইলে: <code>&lt;span class="text-primary"&gt;Text&lt;/span&gt;</code> ব্যবহার করুন।</small>
                            </div>
    
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Button Link</label>
                                <input type="text" name="btn_link" class="form-control" value="{{ $content['btn_link'] ?? '#contact' }}">
                            </div>
    
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ $content['description'] ?? '' }}</textarea>
                            </div>
    
                            <hr class="my-4">
                            <h5>Key Points</h5>
                            
                            {{-- পয়েন্ট ১ --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Point 1 Title</label>
                                <input type="text" name="point1_title" class="form-control" value="{{ $content['point1_title'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Point 1 Description</label>
                                <input type="text" name="point1_desc" class="form-control" value="{{ $content['point1_desc'] ?? '' }}">
                            </div>
    
                            {{-- পয়েন্ট ২ --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Point 2 Title</label>
                                <input type="text" name="point2_title" class="form-control" value="{{ $content['point2_title'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Point 2 Description</label>
                                <input type="text" name="point2_desc" class="form-control" value="{{ $content['point2_desc'] ?? '' }}">
                            </div>
    
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Button Text</label>
                                <input type="text" name="btn_text" class="form-control" value="{{ $content['btn_text'] ?? 'Read More' }}">
                            </div>
                        </div>
    
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary px-4">Update Section</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- ক্রপার মোডাল --}}
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Feature Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="cropperImage" src="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="cropButton">Crop & Apply</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush

@push('customJs')
<script>
    // ১. গ্লোবাল স্কোপে ভেরিয়েবল ডিক্লেয়ার করা
    var cropper;
    var cropperModalEl = document.getElementById('cropperModal');
    var cropperModal = new bootstrap.Modal(cropperModalEl);
    
    const imageInput = document.getElementById('imageInput');
    const cropperImage = document.getElementById('cropperImage');
    const croppedImageData = document.getElementById('croppedImageData');
    const imagePreview = document.getElementById('imagePreview');

    // ২. ইমেজ সিলেক্ট করা
    imageInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function (event) {
                cropperImage.src = event.target.result;
                cropperModal.show();
            };
            reader.readAsDataURL(files[0]);
        }
    });

    // ৩. মোডাল পুরোপুরি ওপেন হওয়ার পর ক্রপার শুরু করা
    cropperModalEl.addEventListener('shown.bs.modal', function () {
        cropper = new Cropper(cropperImage, {
            aspectRatio: 1.3 / 1,
            viewMode: 2,
            autoCropArea: 1,
        });
    });

    // ৪. মোডাল বন্ধ হলে ক্রপার ডেস্ট্রয় করা
    cropperModalEl.addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        imageInput.value = ''; // ইনপুট রিসেট
    });

    // ৫. ক্রপ এবং এপ্লাই বাটন (ফিক্সড ভার্সন)
    document.getElementById('cropButton').addEventListener('click', function () {
        if (!cropper) return; // ক্রপার লোড না হলে কিছু করবে না

        const canvas = cropper.getCroppedCanvas({
            width: 700,
            height: 600,
            imageSmoothingQuality: 'high',
        });
        
        if (canvas) {
            const base64 = canvas.toDataURL('image/png');
            
            // প্রিভিউ সেট করা
            imagePreview.src = base64;
            
            // হিডেন ইনপুটে ডাটা সেট করা
            croppedImageData.value = base64;
            
            // মোডাল হাইড করা
            cropperModal.hide();
        }
    });
</script>
@endpush