@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        .form-section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 700;
            color: #050c24;
            border-bottom: 2px solid #e8ebf1;
            font-family: 'Outfit', sans-serif;
        }
        .form-section-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 50px;
            height: 2px;
            background: #4f46e5;
        }
        .preview { overflow: hidden; width: 160px; height: 160px; border: 2px solid #4f46e5; border-radius: 8px; margin: 0 auto; }
        .img-container img { max-width: 100%; }
        #photo-preview-container {
            width: 130px;
            height: 130px;
            border-radius: 20px;
            border: 2px dashed #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #ffffff;
            margin: 0 auto;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        #photo-preview-container:hover {
            border-color: #4f46e5;
            background: #f8fafc;
            transform: translateY(-2px);
        }
        #photo-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-box shadow-lg">
                        <i class="fa-solid fa-user-pen text-white"></i>
                    </div>
                    <div>
                        <h1 class="page-title text-white">Edit Staff Profile</h1>
                        <p class="page-subtitle text-white-50">Updating information for: <span class="fw-bold text-white">{{ $staff->name }}</span></p>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('staff.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-outline-light border-0 bg-white bg-opacity-10 rounded-pill px-4 py-2">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Directory
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card glass-card border-0 shadow-lg overflow-hidden mb-5" style="border-radius: 24px;">
                    <div class="card-header bg-warning bg-opacity-10 border-0 p-4">
                        <h5 class="mb-0 fw-bold text-warning-emphasis"><i class="fa-solid fa-user-gear me-2"></i> Update Profile Information</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('staff.update', ['tenant' => auth()->user()?->school?->slug, 'staff' => $staff->id]) }}" enctype="multipart/form-data" class="modern-form">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                {{-- Photo & Basic Section --}}
                                <div class="col-12 text-center mb-4">
                                    <div class="d-inline-block position-relative">
                                        <div id="photo-preview-container" onclick="document.getElementById('imageInput').click();">
                                            <img id="mainProfilePic" src="{{ $staff->photo ? asset($staff->photo) : asset('assets/images/profile.webp') }}" alt="Preview">
                                        </div>
                                        <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                             style="width: 32px; height: 32px; cursor: pointer; border: 2px solid #fff;" onclick="document.getElementById('imageInput').click();">
                                            <i class="fa-solid fa-camera small"></i>
                                        </div>
                                    </div>
                                    <h6 class="mt-3 fw-bold text-dark mb-1">Update Staff Photo</h6>
                                    <p class="small text-muted mb-0">Member ID: #{{ str_pad($staff->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    <input type="file" class="d-none" id="imageInput" accept="image/*">
                                    <input type="hidden" name="cropped_image" id="croppedImage">
                                    @error('photo')
                                        <div class="text-danger small mt-2 fw-bold"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <h5 class="form-section-title"><i class="fa-solid fa-address-card me-2 text-primary"></i> Account Information</h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group modern-input-group">
                                        <label class="form-label text-dark fw-semibold" for="name">Full Name <span class="text-danger">*</span></label>
                                        <div class="input-group-custom shadow-sm rounded-3 overflow-hidden d-flex">
                                            <span class="input-icon bg-light px-3 d-flex align-items-center border-end"><i class="fa-regular fa-user text-primary"></i></span>
                                            <input type="text" name="name" class="form-control border-0 py-2 fs-6 bg-white" id="name" 
                                                   placeholder="Enter full name" value="{{ old('name', $staff->name) }}" required>
                                        </div>
                                        @error('name')
                                            <p class="text-danger small mt-1 animate__animated animate__headShake">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group modern-input-group">
                                        <label class="form-label text-dark fw-semibold" for="email">Work Email Address <span class="text-danger">*</span></label>
                                        <div class="input-group-custom shadow-sm rounded-3 overflow-hidden d-flex">
                                            <span class="input-icon bg-light px-3 d-flex align-items-center border-end"><i class="fa-regular fa-envelope text-primary"></i></span>
                                            <input type="email" name="email" class="form-control border-0 py-2 fs-6 bg-white" id="email" 
                                                   placeholder="staff@institution.com" value="{{ old('email', $staff->email) }}" required>
                                        </div>
                                        @error('email')
                                            <p class="text-danger small mt-1 animate__animated animate__headShake">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group modern-input-group">
                                        <label class="form-label text-dark fw-semibold" for="role_id">Designation / Role <span class="text-danger">*</span></label>
                                        <div class="input-group-custom shadow-sm rounded-3 overflow-hidden d-flex">
                                            <span class="input-icon bg-light px-3 d-flex align-items-center border-end"><i class="fa-solid fa-user-shield text-primary"></i></span>
                                            <select class="form-select border-0 py-2 fs-6 bg-white" id="role_id" name="role_id" required>
                                                <option value="" disabled>Select assigned role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ old('role_id', $staff->roles->first()?->id) == $role->id ? 'selected' : '' }}>
                                                        {{ $role->display_name ?? ucwords(str_replace(['.', '-'], ' ', $role->name)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('role_id')
                                            <p class="text-danger small mt-1 animate__animated animate__headShake">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group modern-input-group">
                                        <label class="form-label text-dark fw-semibold" for="phone">Phone Number</label>
                                        <div class="input-group-custom shadow-sm rounded-3 overflow-hidden d-flex">
                                            <span class="input-icon bg-light px-3 d-flex align-items-center border-end"><i class="fa-solid fa-mobile-screen-button text-primary"></i></span>
                                            <input type="text" name="phone" class="form-control border-0 py-2 fs-6 bg-white" id="phone" 
                                                   placeholder="01xxxxxxxxx" value="{{ old('phone', $staff->phone) }}">
                                        </div>
                                        @error('phone')
                                            <p class="text-danger small mt-1 animate__animated animate__headShake">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Security Section --}}
                                <div class="col-12 mt-4">
                                    <div class="alert alert-soft-primary d-flex align-items-center rounded-4 border-0 mb-4 p-3 shadow-sm bg-primary bg-opacity-10 text-primary">
                                        <i class="fa-solid fa-shield-halved fs-4 me-3"></i>
                                        <div>
                                            <div class="fw-bold">Security & Credentials</div>
                                            <div class="small">Leave password fields empty to keep the current login password.</div>
                                        </div>
                                    </div>
                                    <h5 class="form-section-title"><i class="fa-solid fa-lock me-2 text-primary"></i> Access Control</h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group modern-input-group">
                                        <label class="form-label text-dark fw-semibold" for="password">New Password</label>
                                        <div class="input-group-custom shadow-sm rounded-3 overflow-hidden d-flex">
                                            <span class="input-icon bg-light px-3 d-flex align-items-center border-end"><i class="fa-solid fa-key text-primary"></i></span>
                                            <input type="password" name="password" class="form-control border-0 py-2 fs-6 bg-white" id="password" 
                                                   placeholder="Minimum 8 characters">
                                        </div>
                                        @error('password')
                                            <p class="text-danger small mt-1 animate__animated animate__headShake">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group modern-input-group">
                                        <label class="form-label text-dark fw-semibold" for="password_confirmation">Confirm Password</label>
                                        <div class="input-group-custom shadow-sm rounded-3 overflow-hidden d-flex">
                                            <span class="input-icon bg-light px-3 d-flex align-items-center border-end"><i class="fa-solid fa-shield-check text-primary"></i></span>
                                            <input type="password" name="password_confirmation" class="form-control border-0 py-2 fs-6 bg-white" id="password_confirmation" 
                                                   placeholder="Retype password">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="p-4 bg-light rounded-4 border-start border-4 border-warning shadow-sm">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div>
                                                <h6 class="fw-bold mb-1">Confirm Profile Updates</h6>
                                                <p class="small text-muted mb-0">Review changes before saving. Access levels may change based on role selection.</p>
                                            </div>
                                            <div class="d-flex gap-3">
                                                <a href="{{ route('staff.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-light rounded-pill px-4">Discard</a>
                                                <button type="submit" class="btn btn-primary-gradient rounded-pill shadow">
                                                    <i class="fa-solid fa-save me-2"></i> Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cropper Modal --}}
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: #002147;">Crop Staff Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="img-container bg-light rounded" style="min-height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img id="imageToCrop" src="" style="max-width: 100%;">
                        </div>
                    </div>
                    <div class="col-md-4 text-center mt-3 mt-md-0">
                        <p class="mb-2 fw-bold small text-muted text-uppercase">Preview</p>
                        <div class="mx-auto preview shadow-sm"></div>
                        <p class="mt-3 small text-muted">Adjust the crop area to fit the profile perfectly.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="cropAndSave" class="btn btn-primary px-4 rounded-pill">Crop & Apply</button>
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
        if (cropper) cropper.destroy();
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 1,
            viewMode: 1,
            preview: '.preview'
        });
    });

    document.getElementById('cropAndSave').addEventListener('click', function () {
        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        const base64Data = canvas.toDataURL('image/webp', 0.9);
        croppedImageInput.value = base64Data;
        document.getElementById('mainProfilePic').src = base64Data;
        cropperModal.hide();
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Successful!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif
</script>
@endsection
