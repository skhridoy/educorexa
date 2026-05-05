@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')

<style>
    .preview { overflow: hidden; width: 160px; height: 160px; border: 1px solid #727cf5; border-radius: 50%; }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="position-relative">
                    <figure class="overflow-hidden mb-0 d-flex justify-content-center" style="height: 150px; background: #727cf5;">
                    </figure>
                    <div class="d-flex justify-content-between align-items-center position-absolute top-100 start-0 mt-n4 ms-4 w-100 px-3">
                        <img id="mainProfilePic" class="wd-100 ht-100 rounded-circle border border-white" 
                            src="{{ asset($user->photo ?: ($user->role == 'teacher' && $user->teacher ? $user->teacher->photo : ($user->role == 'student' && $user->student ? $user->student->photo : 'main/img/default-photo.png'))) }}" 
                            alt="profile">
                        <div class="ms-3 flex-grow-1 mt-4">
                            <h4 class="mb-0">{{ $user->name }}</h4>
                            <p class="text-muted">{{ strtoupper($user->role ?? 'User') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-5"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Personal Information</h6>
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email (Not Change)</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" id="imageInput" class="form-control" accept="image/*">
                            <input type="hidden" name="cropped_image" id="croppedImage">
                        </div>

                        @php
                            $socialData = ($user->role == 'teacher' && $user->teacher) ? $user->teacher : $user;
                        @endphp

                        @if($user->role == 'teacher' || $user->role == 'school_admin')
                            <div class="row mt-4">
                                <h6 class="mb-3 text-primary">Social Media Link</h6>
                                @if($user->role == 'teacher')
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Designation</label>
                                    <input type="text" name="designation" class="form-control" value="{{ $user->teacher->designation ?? '' }}">
                                </div>
                                @endif
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Facebook URL</label>
                                    <input type="url" name="facebook" class="form-control" value="{{ $socialData->facebook ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Twitter URL</label>
                                    <input type="url" name="twitter" class="form-control" value="{{ $socialData->twitter ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">LinkedIn URL</label>
                                    <input type="url" name="linkedin" class="form-control" value="{{ $socialData->linkedin ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Instagram URL</label>
                                    <input type="url" name="instagram" class="form-control" value="{{ $socialData->insta ?? '' }}">
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Change Password</h6>
                    <form action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Present password</label>
                            <input type="password" name="old_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm new password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cropper Modal --}}
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="img-container">
                            <img id="imageToCrop" src="" style="max-width: 60%;">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <p class="mb-2">Preview</p>
                        <div class="preview"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="cropAndSave" class="btn btn-primary">Crop & Apply</button>
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
        const canvas = cropper.getCroppedCanvas({ width: 200, height: 200 });
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