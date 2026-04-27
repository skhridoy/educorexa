@extends('layouts.main')

@section('customCSS')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
  <style>
    .img-container img { max-width: 100%; }
    #imagePreview { max-width: 200px; transition: 0.3s; }
    #imagePreview:hover { opacity: 0.8; cursor: pointer; }
  </style>
@endsection

@section('content')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('manage.frontend.index') }}">Frontend</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Hero Section</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Hero Content</h6>
                    
                    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Hero Image</label>
                                <input type="file" id="imageInput" class="form-control mb-2" accept="image/*">
                                <input type="hidden" name="image" id="croppedImageData">
                                
                                <div class="mt-2">
                                    <img id="imagePreview" src="{{ asset($content['image'] ?? 'frontend/img/hero.png') }}" class="img-thumbnail shadow-sm">
                                    <p class="text-muted small mt-1">ক্লিক করে নতুন ছবি আপলোড করুন।</p>
                                </div>
                            </div>
    
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Subtitle (Small Top Text)</label>
                                <input type="text" name="subtitle" class="form-control" value="{{ $content['subtitle'] ?? 'Smart School ERP Solution' }}">
                            </div>
    
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $content['title'] ?? 'The Most Reliable ERP Software' }}">
                            </div>
    
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Main Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ $content['description'] ?? '' }}</textarea>
                            </div>
    
                            <hr>
                            <h5>Buttons & Stats</h5>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Primary Btn Text</label>
                                <input type="text" name="btn1_text" class="form-control" value="{{ $content['btn1_text'] ?? 'Get Started Free' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Primary Btn Link</label>
                                <input type="text" name="btn1_link" class="form-control" value="{{ $content['btn1_link'] ?? '#' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Secondary Btn Text</label>
                                <input type="text" name="btn2_text" class="form-control" value="{{ $content['btn2_text'] ?? 'Book a Demo' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Secondary Btn Link</label>
                                <input type="text" name="btn2_link" class="form-control" value="{{ $content['btn2_link'] ?? '#' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Stats 1 (Schools)</label>
                                <input type="text" name="stat1_val" class="form-control" value="{{ $content['stat1_val'] ?? '500+' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Stats 2 (Support)</label>
                                <input type="text" name="stat2_val" class="form-control" value="{{ $content['stat2_val'] ?? '24/7' }}">
                            </div>
                        </div>
    
                        <button type="submit" class="btn btn-primary">Update Hero Section</button>
                        <a href="{{ route('manage.frontend.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
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

{{-- আপনার লেআউটে @stack('customJs') আছে, লজিক এখানে দিন --}}
@push('customJs')
<script>
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const cropperImage = document.getElementById('cropperImage');
    const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
    const croppedImageData = document.getElementById('croppedImageData');
    const imagePreview = document.getElementById('imagePreview');

    // ইমেজ সিলেক্ট করলে মোডাল ওপেন হবে
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

    // মোডাল পুরোপুরি ওপেন হলে ক্রপার শুরু হবে
    document.getElementById('cropperModal').addEventListener('shown.bs.modal', function () {
        cropper = new Cropper(cropperImage, {
            aspectRatio: 600 / 500,
            viewMode: 1,
        });
    });

    // মোডাল বন্ধ হলে ক্রপার ধ্বংস হবে
    document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function () {
        if(cropper) {
            cropper.destroy();
        }
        imageInput.value = ''; 
    });

    // ক্রপ বাটনে ক্লিক করলে ডাটা সেভ হবে
    document.getElementById('cropButton').addEventListener('click', function () {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 800,
            height: 666,
        });
        
        const base64 = canvas.toDataURL('image/png');
        imagePreview.src = base64;
        croppedImageData.value = base64; // এই ভ্যালুটিই কন্ট্রোলারে যাবে
        cropperModal.hide();
    });
</script>
@endpush