@extends('layouts.school')

@section('customCSS')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
@endsection
@section('content')
<div class="page-content">
    <div class="row">
        {{-- ক্রিয়েট ফর্ম --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add Overview</h6>
                    <form action="{{ route('overview.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Features (কমা দিয়ে লিখুন)</label>
                            <textarea name="features" class="form-control" placeholder="Feature 1, Feature 2"></textarea>
                        </div>
                        <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cropperModalLabel">ইমেজ ক্রপ করুন</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="img-container">
                                            <img id="imageToCrop" src="" style="max-width: 100%;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                                        <button type="button" id="cropAndSave" class="btn btn-primary">Crop & Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" id="imageInput" class="form-control" accept="image/*">
                            <input type="hidden" name="cropped_image" id="croppedImage">
                            
                            {{-- ক্রপ করার পর ছোট প্রিভিউ দেখানোর জন্য --}}
                            <div class="mt-2" id="finalPreviewContainer" style="display: none;">
                                <label class="d-block mb-1">Cropped Preview:</label>
                                <img id="finalPreview" src="" width="150" class="img-thumbnail">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ডাটা টেবিল --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Overview List</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($overviews as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset($item->image) }}" width="50"></td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        <a href="{{ route('overview.edit', ['tenant' => auth()->user()->school->slug, $overview = $item->id]) }}" class="btn btn-sm btn-primary badge"><i
                                                            class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('overview.destroy', ['tenant' => auth()->user()->school->slug, $overview = $item->id]) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-sm btn-danger badge"><i
                                                            class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
    
    // বুটস্ট্রাপ মোডাল ইনিশিয়ালাইজ
    const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

    imageInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function (event) {
                // মোডালের ভেতর ইমেজ সেট করা
                imageToCrop.src = event.target.result;
                
                // মোডাল ওপেন করা
                cropperModal.show();
            };
            reader.readAsDataURL(files[0]);
        }
    });

    // মোডাল ওপেন হওয়ার পর Cropper চালু করা
    document.getElementById('cropperModal').addEventListener('shown.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 800 / 600, // আপনার রেশিও
            viewMode: 1,
            autoCropArea: 1,
        });
    });

    // Crop & Apply বাটনে ক্লিক করলে
    document.getElementById('cropAndSave').addEventListener('click', function () {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 800,
                height: 600,
            });
            
            // Base64 ডাটা হিডেন ইনপুটে রাখা
            const base64Data = canvas.toDataURL('image/jpeg');
            croppedImageInput.value = base64Data;
            
            // ছোট প্রিভিউ দেখানো
            finalPreview.src = base64Data;
            finalPreviewContainer.style.display = 'block';
            
            // মোডাল বন্ধ করা
            cropperModal.hide();
        }
    });
    
    // মোডাল বন্ধ করলে ইনপুট রিসেট করা (যদি ক্রপ না করে)
    document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function () {
        if (!croppedImageInput.value) {
            imageInput.value = "";
        }
    });
</script>
<script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this notice?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',

            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    button.closest('form').submit();

                }
            })
        }
        @if(session('success'))
            Swal.fire({
                icon: '{{ session('type', 'success') }}',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 1500,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection