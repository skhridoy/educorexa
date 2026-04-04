@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="position-relative">
                    <figure class="overflow-hidden mb-0 d-flex justify-content-center" style="height: 150px; background: #727cf5;">
                    </figure>
                    <div class="d-flex justify-content-between align-items-center position-absolute top-100 start-0 mt-n4 ms-4 w-100 px-3">

                        <img class="wd-100 ht-100 rounded-circle border border-white" 
                            src="{{ asset(
                                $user->photo ?: 
                                ($user->role == 'teacher' && $user->teacher ? $user->teacher->photo : 
                                ($user->role == 'student' && $user->student ? $user->student->photo : 'main/img/default-photo.png'))
                            ) }}" 
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
                    <form action="{{ route('user.profile.update', auth()->user()->school->slug) }}" method="POST" enctype="multipart/form-data">
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
                            <input type="file" name="photo" class="form-control">
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
                                    <input type="url" name="facebook" class="form-control" value="{{ $socialData->facebook ?? '' }}" placeholder="https://facebook.com/...">
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
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Change Password</h6>
                    <form action="{{ route('user.password.update', auth()->user()->school->slug) }}" method="POST">
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
@endsection

@section('customJs')
    <script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        // সাকসেস মেসেজ (প্রোফাইল আপডেট বা পাসওয়ার্ড চেঞ্জ হলে)
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        // এরর মেসেজ (পাসওয়ার্ড না মিললে বা অন্য কোনো ভুল হলে)
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // ভ্যালিডেশন এরর (ফর্মের কোনো রিকোয়ারমেন্ট পূরণ না হলে)
        @if($errors->any())
            @foreach($errors->all() as $error)
                Toast.fire({
                    icon: 'warning',
                    title: '{{ $error }}'
                });
            @endforeach
        @endif
    });
</script>
@endsection