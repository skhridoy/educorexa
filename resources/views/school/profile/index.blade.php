@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .preview { overflow: hidden; width: 160px; height: 160px; border: 2px solid #D4AF37; border-radius: 50%; }
        .profile-cover {
            height: 180px;
            background: linear-gradient(135deg, #002147 0%, #003366 100%);
            border-radius: 16px 16px 0 0;
            position: relative;
            overflow: hidden;
        }
        .profile-cover::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
        }
        .profile-pic-wrapper {
            margin-top: -60px;
            padding-left: 30px;
            position: relative;
            z-index: 2;
        }
        .main-profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            object-fit: cover;
            background: #fff;
        }
        .profile-info {
            padding-top: 15px;
            padding-left: 30px;
            margin-bottom: 30px;
        }
        .profile-name {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 2px;
        }
        .profile-role {
            font-size: 0.85rem;
            font-weight: 600;
            color: #D4AF37;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Outfit', sans-serif;
        }
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: #002147;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .section-title i {
            color: #D4AF37;
        }
        .btn-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(184, 134, 11, 0.3);
            color: #fff;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden mb-4" style="border-radius: 16px;">
                    <div class="profile-cover"></div>
                    <div class="d-md-flex align-items-end">
                        <div class="profile-pic-wrapper">
                            <img id="mainProfilePic" class="main-profile-pic" 
                                src="{{ asset($user->photo ?: ($user->role == 'teacher' && $user->teacher ? $user->teacher->photo : ($user->role == 'student' && $user->student ? $user->student->photo : 'main/img/default-photo.png'))) }}" 
                                alt="profile">
                        </div>
                        <div class="profile-info flex-grow-1">
                            <h3 class="profile-name">{{ $user->name }}</h3>
                            <span class="profile-role">{{ strtoupper($user->role ?? 'User') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-card card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="section-title">
                            <i class="fa-solid fa-user-gear"></i> Personal Information
                        </h5>
                        
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" style="border-radius: 10px;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Email Address (Read Only)</label>
                                    <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly style="border-radius: 10px;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" style="border-radius: 10px;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Profile Photo</label>
                                    <input type="file" id="imageInput" class="form-control" accept="image/*" style="border-radius: 10px;">
                                    <input type="hidden" name="cropped_image" id="croppedImage">
                                </div>
                            </div>

                            @php
                                $socialData = ($user->role == 'teacher' && $user->teacher) ? $user->teacher : $user;
                            @endphp

                            @if($user->role == 'teacher' || $user->role == 'school_admin')
                                <div class="border-top mt-4 pt-4">
                                    <h6 class="section-title" style="font-size: 1rem;">
                                        <i class="fa-solid fa-share-nodes"></i> Social Presence
                                    </h6>
                                    <div class="row">
                                        @if($user->role == 'teacher')
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Designation</label>
                                            <input type="text" name="designation" class="form-control" value="{{ $user->teacher->designation ?? '' }}" style="border-radius: 10px;">
                                        </div>
                                        @endif
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Facebook URL</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="fa-brands fa-facebook text-primary"></i></span>
                                                <input type="url" name="facebook" class="form-control border-start-0" value="{{ $socialData->facebook ?? '' }}" style="border-radius: 0 10px 10px 0;">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Twitter URL</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="fa-brands fa-twitter text-info"></i></span>
                                                <input type="url" name="twitter" class="form-control border-start-0" value="{{ $socialData->twitter ?? '' }}" style="border-radius: 0 10px 10px 0;">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">LinkedIn URL</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="fa-brands fa-linkedin text-primary"></i></span>
                                                <input type="url" name="linkedin" class="form-control border-start-0" value="{{ $socialData->linkedin ?? '' }}" style="border-radius: 0 10px 10px 0;">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted text-uppercase">Instagram URL</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="fa-brands fa-instagram text-danger"></i></span>
                                                <input type="url" name="instagram" class="form-control border-start-0" value="{{ $socialData->insta ?? '' }}" style="border-radius: 0 10px 10px 0;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary-gradient px-5">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-card card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="section-title">
                            <i class="fa-solid fa-lock"></i> Security
                        </h5>
                        <p class="text-muted small mb-4">Update your password to keep your account secure.</p>
                        
                        <form action="{{ route('user.password.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Current Password</label>
                                <input type="password" name="old_password" class="form-control" style="border-radius: 10px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">New Password</label>
                                <input type="password" name="new_password" class="form-control" style="border-radius: 10px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" style="border-radius: 10px;">
                            </div>
                            <button type="submit" class="btn btn-gold w-100">Save New Password</button>
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
                <h5 class="modal-title fw-bold" style="font-family: 'Outfit', sans-serif; color: #002147;">Crop Your Photo</h5>
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
                        <p class="mb-2 fw-bold small text-muted text-uppercase">Circular Preview</p>
                        <div class="mx-auto preview shadow-sm"></div>
                        <p class="mt-3 small text-muted">Adjust the crop area to fit your face perfectly.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="cropAndSave" class="btn btn-primary-gradient rounded-pill px-4">Crop & Apply</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
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
        const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
        const base64Data = canvas.toDataURL('image/webp', 0.9);
        croppedImageInput.value = base64Data;
        document.getElementById('mainProfilePic').src = base64Data;
        cropperModal.hide();
    });

    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });

        @if(session('success'))
            Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif

        @if(session('error'))
            Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
        @endif
    });
</script>
@endsection