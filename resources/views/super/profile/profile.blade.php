@extends('layouts.main')

@section('customCSS')
@include('layouts._shared_styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
    .profile-card { text-align:center; padding:40px 20px; }
    .profile-avatar-wrap { position:relative; width:120px; height:120px; margin:0 auto 20px; }
    .profile-avatar { width:100%; height:100%; border-radius:50%; object-fit:cover; border:4px solid #fff; box-shadow:0 4px 12px rgba(0,0,0,0.08); }
    .profile-name { font-family:'Outfit',sans-serif; font-weight:700; color:#1e293b; font-size:1.4rem; margin-bottom:4px; }
    .profile-role { color:#4f46e5; font-weight:600; font-size:0.875rem; text-transform:uppercase; letter-spacing:0.05em; }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">My Profile</li>
    </ul>

    <div class="row g-4">
        {{-- Profile Sidebar --}}
        <div class="col-md-4">
            <div class="edu-panel">
                <div class="profile-card">
                    @php
                        $folder = ($profileData->role === 'super_admin') ? 'super_admin' : 'employees';
                        $imagePath = (!empty($profileData->photo)) ? url('uploads/'.$folder.'/'.$profileData->photo) : url('upload/no_image.jpg');
                    @endphp
                    <div class="profile-avatar-wrap">
                        <img src="{{ $imagePath }}" class="profile-avatar" alt="profile">
                    </div>
                    <h4 class="profile-name">{{ $profileData->name }}</h4>
                    <p class="profile-role">
                        {{ ($profileData->role === 'super_admin') ? 'Super Admin' : ($profileData->employee->designation ?? 'System Employee') }}
                    </p>
                    <div style="margin-top:20px; display:flex; flex-direction:column; gap:10px; text-align:left; background:#fafbff; border-radius:12px; padding:15px;">
                        <div style="display:flex; align-items:center; gap:10px; font-size:0.85rem; color:#64748b;">
                            <i data-feather="mail" style="width:14px; color:#4f46e5;"></i> {{ $profileData->email }}
                        </div>
                        <div style="display:flex; align-items:center; gap:10px; font-size:0.85rem; color:#64748b;">
                            <i data-feather="phone" style="width:14px; color:#4f46e5;"></i> {{ $profileData->phone ?? 'No phone' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Edit --}}
        <div class="col-md-8">
            <div class="edu-panel">
                <div class="edu-panel-hd">
                    <h6 class="edu-panel-ttl">Edit Personal Details</h6>
                </div>
                <div class="edu-panel-bd">
                    <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="edu-label">Full Name</label>
                                <input type="text" name="name" class="form-control edu-input" value="{{ $profileData->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Email Address</label>
                                <input type="email" name="email" class="form-control edu-input" value="{{ $profileData->email }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control edu-input" value="{{ $profileData->phone }}">
                            </div>
                            
                            @if($profileData->role !== 'super_admin' && $profileData->employee)
                            <div class="col-md-6">
                                <label class="edu-label">Designation</label>
                                <input type="text" name="designation" class="form-control edu-input" value="{{ $profileData->employee->designation }}">
                            </div>
                            <div class="col-12">
                                <label class="edu-label">Address</label>
                                <textarea name="address" class="form-control edu-input" rows="3">{{ $profileData->employee->address }}</textarea>
                            </div>
                            @endif
                        </div>

                        <div class="edu-divider"></div>

                        <div class="mb-4">
                            <label class="edu-label">Change Profile Photo</label>
                            <div style="display:flex; align-items:center; gap:20px;">
                                <div style="flex:1;">
                                    <input type="file" id="imageInput" class="form-control edu-input" accept="image/*">
                                    <p style="font-size:0.75rem; color:#94a3b8; margin-top:8px;">Recommended: Square image (min 400x400px)</p>
                                </div>
                                <div id="finalPreviewContainer" style="{{ !empty($profileData->photo) ? '' : 'display: none;' }}">
                                    <img id="finalPreview" src="{{ $imagePath }}" style="width:80px; height:80px; border-radius:12px; object-fit:cover; border:2px solid #eef2ff;">
                                </div>
                            </div>
                            <input type="hidden" name="cropped_image" id="croppedImage">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 40px;">
                                <i data-feather="check-circle" style="width:16px; height:16px;"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cropper Modal --}}
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:20px; border:none; overflow:hidden;">
            <div class="modal-header" style="background:#f8fafc; border-bottom:1px solid #f1f5f9;">
                <h5 class="modal-title" style="font-family:'Outfit',sans-serif; font-weight:700;">Crop Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background:#000; padding:0; display:flex; align-items:center; justify-content:center; min-height:400px;">
                <img id="imageToCrop" src="" style="max-width:100%;">
            </div>
            <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #f1f5f9;">
                <button type="button" class="btn-edu btn-edu-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="cropAndSave" class="btn-edu btn-edu-primary">Apply Crop</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let cropper;
        const imageInput = document.getElementById('imageInput');
        const imageToCrop = document.getElementById('imageToCrop');
        const modalElement = document.getElementById('cropperModal');
        const cropperModal = new bootstrap.Modal(modalElement);
        const croppedImageInput = document.getElementById('croppedImage');
        const finalPreview = document.getElementById('finalPreview');
        const finalPreviewContainer = document.getElementById('finalPreviewContainer');

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

        modalElement.addEventListener('shown.bs.modal', function () {
            if (cropper) cropper.destroy();
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1, 
                viewMode: 1,
                autoCropArea: 1,
                checkOrientation: false,
            });
        });

        modalElement.addEventListener('hidden.bs.modal', function () {
            if (cropper) { cropper.destroy(); cropper = null; }
            imageInput.value = "";
        });

        document.getElementById('cropAndSave').addEventListener('click', function () {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
                const base64Image = canvas.toDataURL('image/jpeg', 0.9);
                croppedImageInput.value = base64Image;
                finalPreview.src = base64Image;
                finalPreviewContainer.style.display = 'block';
                cropperModal.hide();
            }
        });
    });
</script>
@endsection