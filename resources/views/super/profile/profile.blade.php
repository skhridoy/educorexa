@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="row profile-body">
        <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <img class="wd-100 rounded-circle" 
                                 src="{{ (!empty($profileData->photo)) ? url('upload/super_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" 
                                 alt="profile">
                            <span class="h4 ms-3 text-dark">{{ $profileData->name }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Role:</label>
                        <p class="text-muted">Super Admin</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{ $profileData->email }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                        <p class="text-muted">{{ $profileData->phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Update Super Admin Profile</h6>
                    <form method="POST" action="{{ route('super.profile.store') }}" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $profileData->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $profileData->email }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $profileData->phone }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" id="image">
                        </div>
                        <div class="mb-3">
                            <img id="showImage" class="wd-80 rounded-circle" 
                                 src="{{ (!empty($profileData->photo)) ? url('upload/super_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="">
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection