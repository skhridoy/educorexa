@extends('layouts.school')

@section('customCSS')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

@endsection
@section('content')
{{-- Cropper CSS --}}

<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Overview</h6>
                    <form action="{{ route('overview.update', ['tenant' => auth()->user()->school->slug, 'overview' => $overview->id]) }}" method="POST">
                        @csrf 
                        @method('PUT')
                        
                        <div class="row">
                            {{-- বাম পাশে বর্তমান ইমেজ --}}
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label d-block">Current Image</label>
                                    <img src="{{ asset($overview->image) }}" class="img-thumbnail w-100" id="currentImageDisplay">
                                </div>
                            </div>

                            {{-- ডান পাশে ইনপুট ফিল্ডস --}}
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $overview->title }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3" required>{{ $overview->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Features (Comma Separated)</label>
                                    <textarea name="features" class="form-control" placeholder="Feature 1, Feature 2">{{ $overview->features }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-primary">Change Image (Optional)</label>
                                    <input type="file" id="imageInput" class="form-control" accept="image/*">
                                    {{-- ক্রপ করা ডাটা এই ইনপুটে যাবে --}}
                                    <input type="hidden" name="cropped_image" id="croppedImage">
                                    
                                    <div class="mt-3" id="finalPreviewContainer" style="display: none;">
                                        <label class="d-block mb-1 text-success">New Cropped Preview:</label>
                                        <img id="finalPreview" src="" width="200" class="img-thumbnail border-success">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Update Overview</button>
                            <a href="{{ route('overview.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cropping Modal --}}
<div class="modal fade" id="cropperModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Crop New Image</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="imageToCrop" src="" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="cropAndSave" class="btn btn-primary">Apply Crop</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const imageToCrop = document.getElementById('imageToCrop');
    const croppedImageInput = document.getElementById('croppedImage');
    const finalPreview = document.getElementById('finalPreview');
    const finalPreviewContainer = document.getElementById('finalPreviewContainer');
    const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

    imageInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function (event) {
                imageToCrop.src = event.target.result;
                cropperModal.show();
            };
            reader.readAsDataURL(files[0]);
        }
    });

    document.getElementById('cropperModal').addEventListener('shown.bs.modal', function () {
        if (cropper) { cropper.destroy(); }
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 800 / 600,
            viewMode: 1,
            autoCropArea: 1,
        });
    });

    document.getElementById('cropAndSave').addEventListener('click', function () {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({ width: 800, height: 600 });
            const base64Data = canvas.toDataURL('image/jpeg', 0.9);
            croppedImageInput.value = base64Data;
            finalPreview.src = base64Data;
            finalPreviewContainer.style.display = 'block';
            cropperModal.hide();
        }
    });
</script>
@endsection