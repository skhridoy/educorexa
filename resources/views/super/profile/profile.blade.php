@extends('layouts.main')

@section('customCSS')
@endsection

@section('content')
<div class="page-content">
    <div class="row profile-body">
        <div class="col-md-4 left-wrapper my-4">
            <div class="card rounded">
                <div class="card-body text-center">
                    <img class="wd-100 rounded-circle mb-3" 
                         src="{{ (!empty($profileData->photo)) ? url('uploads/super_admin/'.$profileData->photo) : url('upload/no_image.jpg') }}" 
                         alt="profile">
                    <h4 class="text-dark">{{ $profileData->name }}</h4>
                    <p class="text-muted">Super Admin</p>
                </div>
            </div>
        </div>

        <div class="col-md-8 middle-wrapper">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Update Super Admin Profile</h6>
                    <form method="POST" action="{{ route('super.profile.store') }}" class="forms-sample">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $profileData->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $profileData->email }}">
                        </div>

                        {{-- ইমেজ ইনপুট এবং ক্রপার এরিয়া --}}
                        <div class="mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" id="imageInput" class="form-control" accept="image/*">
                            <input type="hidden" name="cropped_image" id="croppedImage">
                            
                            <div class="mt-3" id="finalPreviewContainer" style="{{ !empty($profileData->photo) ? '' : 'display: none;' }}">
                                <label class="d-block mb-1">Preview:</label>
                                <img id="finalPreview" 
                                     src="{{ (!empty($profileData->photo)) ? url('uploads/super_admin/'.$profileData->photo) : '' }}" 
                                     width="120" class="rounded-circle img-thumbnail">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ক্রপার মোডাল --}}
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop your image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="imageToCrop" src="" style="max-width: 60%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                <button type="button" id="cropAndSave" class="btn btn-primary">Crop & Apply</button>
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
            aspectRatio: 1, // প্রোফাইল পিকচারের জন্য ১:১ রেশিও
            viewMode: 1,
            autoCropArea: 1,
        });
    });

    document.getElementById('cropAndSave').addEventListener('click', function () {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 200,
                height: 200,
            });
            
            // WebP ফরম্যাটে ডাটা বের করা
            const base64Data = canvas.toDataURL('image/webp', 0.9);
            croppedImageInput.value = base64Data;
            
            finalPreview.src = base64Data;
            finalPreviewContainer.style.display = 'block';
            cropperModal.hide();
        }
    });

    document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function () {
        if (!croppedImageInput.value) { imageInput.value = ""; }
    });
</script>
@endsection