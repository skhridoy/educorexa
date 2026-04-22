@extends('layouts.main')

@section('customCSS')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
@endsection

@section('content')
<div class="page-content">
    <div class="row profile-body">
        <div class="col-md-4 left-wrapper my-4">
            <div class="card rounded">
                <div class="card-body text-center">
                    @php
                        // রোল অনুযায়ী ইমেজ পাথ সেট করা
                        $folder = ($profileData->role === 'super_admin') ? 'super_admin' : 'employees';
                        $imagePath = (!empty($profileData->photo)) ? url('uploads/'.$folder.'/'.$profileData->photo) : url('upload/no_image.jpg');
                    @endphp
                    
                    <img class="wd-100 rounded-circle mb-3" 
                         src="{{ $imagePath }}" 
                         alt="profile">
                    <h4 class="text-dark">{{ $profileData->name }}</h4>
                    <p class="text-muted">{{ ($profileData->role === 'super_admin') ? 'Super Admin' : ($profileData->employee->designation ?? 'Employee') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8 middle-wrapper my-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Update {{ ($profileData->role === 'super_admin') ? 'Super Admin' : 'Employee' }} Profile</h6>
                    
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
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $profileData->phone }}">
                        </div>

                        {{-- যদি এমপ্লয়ি হয় তবে ডেজিগনেশন এবং এড্রেস দেখাবে --}}
                        @if($profileData->role !== 'super_admin' && $profileData->employee)
                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control" value="{{ $profileData->employee->designation }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3">{{ $profileData->employee->address }}</textarea>
                        </div>
                        @endif

                        {{-- ইমেজ ইনপুট এবং ক্রপার এরিয়া --}}
                        <div class="mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" id="imageInput" class="form-control" accept="image/*">
                            <input type="hidden" name="cropped_image" id="croppedImage">
                            
                            <div class="mt-3" id="finalPreviewContainer" style="{{ !empty($profileData->photo) ? '' : 'display: none;' }}">
                                <label class="d-block mb-1">Preview:</label>
                                <img id="finalPreview" 
                                     src="{{ $imagePath }}" 
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

{{-- ক্রপার মোডাল আগের মতোই থাকবে --}}
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop your image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="img-container">
                    <img id="imageToCrop" src="" style="max-width: 100%;">
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
{{-- JS কোড আপনার আগের মতোই থাকবে, কোনো পরিবর্তনের প্রয়োজন নেই --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    // ... আপনার আগের দেওয়া জাভাস্ক্রিপ্ট কোডটি এখানে দিন ...
</script>
@endsection