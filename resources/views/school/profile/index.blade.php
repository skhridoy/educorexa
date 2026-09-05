@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ════ Profile Cover & Header ════ */
        .profile-cover-card {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 50%, #06b6d4 100%);
            border-radius: 16px;
            padding: 20px 24px;
            color: #ffffff;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.15);
            position: relative;
            overflow: hidden;
        }
        .profile-cover-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }
        .profile-cover-card::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: 80px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        .profile-header-wrap {
            position: relative;
            z-index: 2;
        }
        .profile-avatar-outer {
            position: relative;
            display: inline-block;
        }
        .main-profile-pic {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            object-fit: cover;
            background: #ffffff;
        }
        .avatar-upload-icon {
            position: absolute;
            bottom: 0px;
            right: 0px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #4f46e5;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            border: 2px solid #ffffff;
            transition: transform 0.2s ease;
        }
        .avatar-upload-icon:hover {
            transform: scale(1.1);
        }
        .profile-display-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 2px;
            letter-spacing: -0.3px;
        }
        .profile-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .profile-meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            opacity: 0.9;
        }

        /* ════ Form Sizing & Compact Typography ════ */
        .form-card {
            padding: 18px 20px !important;
        }
        .form-card .form-label {
            font-size: 0.76rem !important;
            font-weight: 700 !important;
            margin-bottom: 4px !important;
        }
        .form-card .form-control,
        .form-card .form-select {
            font-size: 0.78rem !important;
            padding: 6px 10px !important;
            height: 36px !important;
            border-radius: 8px !important;
        }

        /* ════ Cropper & Preview ════ */
        .preview {
            overflow: hidden;
            width: 120px;
            height: 120px;
            border: 3px solid #6366f1;
            border-radius: 50%;
        }

        /* ════ Social Input Icons ════ */
        .social-input-group .input-group-text {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            border-radius: 8px 0 0 8px !important;
            min-width: 38px;
            height: 36px !important;
            font-size: 0.8rem;
            justify-content: center;
        }
        .social-input-group .form-control {
            border-radius: 0 8px 8px 0 !important;
        }

        /* ════ Security Gold Button ════ */
        .btn-security {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.78rem;
            padding: 8px 18px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .btn-security:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(217, 119, 6, 0.35);
            color: #ffffff;
        }

        /* 📱 Mobile Responsive Font Size Adjustments */
        @media (max-width: 767.98px) {
            .profile-cover-card {
                padding: 16px 16px !important;
            }
            .main-profile-pic {
                width: 70px !important;
                height: 70px !important;
            }
            .avatar-upload-icon {
                width: 24px !important;
                height: 24px !important;
                font-size: 0.65rem !important;
            }
            .profile-display-name {
                font-size: 1.05rem !important;
            }
            .profile-role-badge {
                font-size: 0.62rem !important;
                padding: 2px 8px !important;
            }
            .profile-meta-chip {
                font-size: 0.7rem !important;
            }
            .form-card .form-label {
                font-size: 0.72rem !important;
            }
            .form-card .form-control,
            .form-card .form-select {
                font-size: 0.75rem !important;
                height: 34px !important;
            }
            .form-card h5 {
                font-size: 0.88rem !important;
                margin-bottom: 12px !important;
            }
        }

        /* 🌙 Dark Mode Profile Overrides */
        [data-bs-theme="dark"] .profile-cover-card,
        body.dark-mode .profile-cover-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f1a2e 100%) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4) !important;
        }
        [data-bs-theme="dark"] .main-profile-pic,
        body.dark-mode .main-profile-pic {
            border-color: #1e2d45 !important;
            background: #0c1427 !important;
        }
        [data-bs-theme="dark"] .avatar-upload-icon,
        body.dark-mode .avatar-upload-icon {
            border-color: #0c1427 !important;
        }
        [data-bs-theme="dark"] .social-input-group .input-group-text,
        body.dark-mode .social-input-group .input-group-text {
            background-color: #0f1a2e !important;
            border-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .social-input-group .form-control,
        body.dark-mode .social-input-group .form-control {
            background-color: #0f1a2e !important;
            border-color: #1e2d45 !important;
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .modal-content,
        body.dark-mode .modal-content {
            background: #0c1427 !important;
            color: #f1f5f9 !important;
            border-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .img-container,
        body.dark-mode .img-container {
            background: #0f1a2e !important;
        }
    </style>
@endsection

@section('content')
@php
    $photoPath = $user->photo 
        ?: ($user->role == 'teacher' && $user->teacher && $user->teacher->photo ? $user->teacher->photo 
        : ($user->role == 'student' && $user->student && $user->student->photo ? $user->student->photo : null));
    $profileImg = $photoPath ? asset($photoPath) : asset('assets/images/profile.webp');
@endphp

<div class="page-content">
    <div class="container-fluid">
        {{-- Profile Header Card --}}
        <div class="profile-cover-card mb-4">
            <div class="profile-header-wrap d-flex flex-column flex-md-row align-items-center align-items-md-end gap-3 text-center text-md-start">
                <div class="profile-avatar-outer">
                    <img id="mainProfilePic" class="main-profile-pic" 
                        src="{{ $profileImg }}" 
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/profile.webp') }}';"
                        alt="profile">
                    <label for="imageInput" class="avatar-upload-icon" title="Change Photo">
                        <i class="fa-solid fa-camera"></i>
                    </label>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-1">
                        <span class="profile-role-badge">
                            <i class="fa-solid fa-shield-halved"></i> {{ strtoupper($user->role ?? 'User') }}
                        </span>
                        @if(auth()->user()?->school)
                            <span class="profile-role-badge" style="background:rgba(255,255,255,0.12);">
                                <i class="fa-solid fa-school"></i> {{ auth()->user()->school->name }}
                            </span>
                        @endif
                    </div>
                    <h2 class="profile-display-name text-white">{{ $user->name }}</h2>
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-3">
                        <span class="profile-meta-chip"><i class="fa-regular fa-envelope"></i> {{ $user->email }}</span>
                        @if($user->phone)
                            <span class="profile-meta-chip"><i class="fa-solid fa-phone"></i> {{ $user->phone }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Personal Information Form --}}
            <div class="col-lg-8">
                <div class="form-card">
                    <h5 class="fw-bold text-primary mb-4">
                        <i class="fa-solid fa-user-gear me-2"></i> Personal Information
                    </h5>
                    
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" required>
                                @error('email')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="e.g. +880 1700-000000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Profile Photo</label>
                                <input type="file" id="imageInput" class="form-control" accept="image/*">
                                <input type="hidden" name="cropped_image" id="croppedImage">
                            </div>
                        </div>

                        @php
                            $socialData = ($user->role == 'teacher' && $user->teacher) ? $user->teacher : $user;
                        @endphp

                        @if($user->role == 'teacher' || $user->role == 'school_admin')
                            <div class="border-top mt-4 pt-4">
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.95rem;">
                                    <i class="fa-solid fa-share-nodes me-2 text-indigo-600"></i> Social Presence & Info
                                </h6>
                                <div class="row g-3">
                                    @if($user->role == 'teacher')
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Designation</label>
                                        <input type="text" name="designation" class="form-control" value="{{ $user->teacher->designation ?? '' }}" placeholder="e.g. Senior Teacher">
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Facebook URL</label>
                                        <div class="input-group social-input-group">
                                            <span class="input-group-text"><i class="fa-brands fa-facebook text-primary"></i></span>
                                            <input type="url" name="facebook" class="form-control" value="{{ $socialData->facebook ?? '' }}" placeholder="https://facebook.com/username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Twitter URL</label>
                                        <div class="input-group social-input-group">
                                            <span class="input-group-text"><i class="fa-brands fa-twitter text-info"></i></span>
                                            <input type="url" name="twitter" class="form-control" value="{{ $socialData->twitter ?? '' }}" placeholder="https://twitter.com/username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">LinkedIn URL</label>
                                        <div class="input-group social-input-group">
                                            <span class="input-group-text"><i class="fa-brands fa-linkedin text-primary"></i></span>
                                            <input type="url" name="linkedin" class="form-control" value="{{ $socialData->linkedin ?? '' }}" placeholder="https://linkedin.com/in/username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Instagram URL</label>
                                        <div class="input-group social-input-group">
                                            <span class="input-group-text"><i class="fa-brands fa-instagram text-danger"></i></span>
                                            <input type="url" name="instagram" class="form-control" value="{{ $socialData->insta ?? '' }}" placeholder="https://instagram.com/username">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($user->role == 'school_admin')
                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">
                                        <i class="fa-solid fa-signature me-2 text-primary"></i> {{ __('Principal / Headmaster Signature (প্রধান শিক্ষকের ডিজিটাল স্বাক্ষর)') }}
                                    </h6>
                                    @if($user->signature && file_exists(public_path($user->signature)))
                                        <span class="badge bg-success-subtle text-success fw-bold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-circle-check me-1"></i>{{ __('স্বাক্ষর আপলোড করা আছে') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning fw-bold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ __('স্বাক্ষর সেট করা নেই') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="p-3 rounded-4 mb-3" style="background: #f8fafc; border: 1.5px dashed #cbd5e1;">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-5 text-center">
                                            <div class="signature-preview-container d-inline-flex align-items-center justify-content-center p-2 rounded-3 bg-white shadow-sm" style="width: 100%; max-width: 240px; height: 95px; border: 1px solid #e2e8f0;">
                                                <img id="signaturePreview" 
                                                     src="{{ ($user->signature && file_exists(public_path($user->signature))) ? asset($user->signature) : asset('assets/images/signature.png') }}" 
                                                     alt="Signature Preview" 
                                                     style="max-height: 75px; max-width: 210px; object-fit: contain;">
                                            </div>
                                            <small class="d-block text-muted mt-1" style="font-size: 0.72rem;">{{ __('বর্তমান স্বাক্ষরের লাইভ প্রিভিউ') }}</small>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="form-label fw-semibold small mb-1">{{ __('নতুন স্বাক্ষর নির্বাচন করুন (Upload Signature)') }}</label>
                                            <input type="file" name="signature" id="signatureFileInput" class="form-control form-control-sm mb-2" accept="image/png, image/jpeg, image/webp" style="border-radius: 8px;">
                                            <input type="hidden" name="remove_signature" id="removeSignatureInput" value="0">
                                            
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                @if($user->signature && file_exists(public_path($user->signature)))
                                                    <button type="button" id="btnRemoveSig" class="btn btn-outline-danger btn-sm py-1 px-2.5 rounded-2" style="font-size: 0.72rem;">
                                                        <i class="fa-solid fa-trash me-1"></i>{{ __('স্বাক্ষর মুছে ফেলুন') }}
                                                    </button>
                                                @endif
                                            </div>

                                            <p class="text-muted mb-0" style="font-size: 0.72rem; line-height: 1.45;">
                                                <i class="fa-solid fa-circle-info text-primary me-1"></i>
                                                {{ __('স্বচ্ছ ব্যাকগ্রাউন্ডের স্পষ্ট স্বাক্ষর (PNG/WEBP/JPG, সর্বোচ্চ ২MB) আপলোড করুন। এই স্বাক্ষরটি স্টুডেন্ট আইডি কার্ড, পরীক্ষার প্রবেশপত্র এবং মার্কশীটে স্বয়ংক্রিয়ভাবে প্রদর্শিত হবে।') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="text-end mt-4 pt-2">
                            <button type="submit" class="btn btn-primary-gradient fw-bold px-4 py-2" style="border-radius:10px; font-size:0.8rem;">
                                <i class="fa-solid fa-check me-1"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Security / Change Password Form --}}
            <div class="col-lg-4">
                <div class="form-card">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-shield-halved me-2"></i> Security Settings
                    </h5>
                    <p class="text-muted small mb-4">Update your password to keep your account protected.</p>
                    
                    <form action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="old_password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-security w-100 py-2">
                            <i class="fa-solid fa-key me-1"></i> Save New Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cropper Modal --}}
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fw-bold" style="font-family: 'Outfit', sans-serif;"><i class="fa-solid fa-crop-simple me-2 text-indigo-600"></i>Crop Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="img-container bg-light rounded" style="min-height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img id="imageToCrop" src="" style="max-width: 100%;">
                        </div>
                    </div>
                    <div class="col-md-4 text-center mt-3 mt-md-0 d-flex flex-column align-items-center justify-content-center">
                        <p class="mb-2 fw-bold small text-muted text-uppercase">Circular Preview</p>
                        <div class="preview shadow-sm mb-3"></div>
                        <p class="small text-muted mb-0">Adjust crop area for best appearance.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top p-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" style="border-radius:10px;">Cancel</button>
                <button type="button" id="cropAndSave" class="btn btn-primary-gradient px-4" style="border-radius:10px;"><i class="fa-solid fa-check me-1"></i> Crop & Apply</button>
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

        // Digital Signature preview & removal handler
        $('#signatureFileInput').on('change', function(e) {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(evt) {
                    $('#signaturePreview').attr('src', evt.target.result);
                    $('#removeSignatureInput').val('0');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        $('#btnRemoveSig').on('click', function() {
            $('#removeSignatureInput').val('1');
            $('#signatureFileInput').val('');
            $('#signaturePreview').attr('src', '{{ asset("assets/images/signature.png") }}');
            $(this).fadeOut();
        });
    });
</script>
@endsection