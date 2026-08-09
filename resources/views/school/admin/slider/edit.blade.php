@extends('layouts.school')

@section('title', 'স্লাইডার এডিট করুন')

@section('customCSS')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
    .slider-card {
        border: 1px solid rgba(101, 113, 255, 0.15);
        border-radius: 12px;
        transition: all 0.3s ease;
        background: var(--card-bg, #ffffff);
    }

    .slider-card:hover {
        box-shadow: 0 8px 24px rgba(101, 113, 255, 0.12);
    }

    .edit-preview-box {
        border: 2px dashed rgba(101, 113, 255, 0.3);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        background: rgba(101, 113, 255, 0.02);
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .edit-preview-box:hover {
        border-color: #6571ff;
        background: rgba(101, 113, 255, 0.05);
    }

    .current-img-holder {
        max-height: 240px;
        object-fit: cover;
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .slider-thumb {
        width: 100px;
        height: 56px;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        cursor: pointer;
    }

    .badge-soft-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .badge-soft-secondary {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.2);
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #6571ff 0%, #4b54db 100%);
        color: #fff;
        border: none;
        box-shadow: 0 4px 12px rgba(101, 113, 255, 0.35);
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #525fe1 0%, #3a42c2 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(101, 113, 255, 0.45);
    }

    .btn-action-edit {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        outline: none;
        background-color: #fff7ed !important;
        border: 1px solid #fed7aa !important;
    }
    .btn-action-edit i, .btn-action-edit svg, .btn-action-edit * {
        color: #d97706 !important;
        fill: #d97706 !important;
        opacity: 1 !important;
    }
    .btn-action-edit:hover {
        background-color: #f59e0b !important;
        border-color: #f59e0b !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.35);
    }
    .btn-action-edit:hover i, .btn-action-edit:hover svg, .btn-action-edit:hover * {
        color: #ffffff !important;
        fill: #ffffff !important;
    }

    body.dark-mode .btn-action-edit {
        background-color: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border-color: rgba(245, 158, 11, 0.35);
    }

    /* Full Responsiveness Media Queries */
    @media (max-width: 991.98px) {
        .page-content {
            padding: 1rem 0.5rem;
        }
        .slider-thumb {
            width: 90px;
            height: 52px;
        }
    }

    @media (max-width: 575.98px) {
        .slider-thumb {
            width: 75px;
            height: 44px;
        }
        .btn-action-edit {
            width: 32px;
            height: 32px;
            font-size: 1rem;
        }
        .edit-preview-box {
            padding: 0.75rem;
        }
        .img-container {
            max-height: 300px !important;
            min-height: 220px !important;
        }
        .modal-dialog {
            margin: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content">
    {{-- Header Navigation --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-primary">
                <i class="fa-solid fa-pen-to-square me-2"></i> স্লাইডার এডিট করুন
            </h4>
            <p class="text-muted fs-14 mb-0">স্লাইডারের ছবি, টাইটেল, সাব-টাইটেল বা অবস্থান পরিবর্তন করুন</p>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
            <a href="{{ route('sliders.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-outline-primary rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> স্লাইডার তালিকায় ফিরে যান
            </a>
        </div>
    </div>

    <div class="row">
        {{-- স্লাইডার এডিট ফর্ম (Left/Center Card) --}}
        <div class="col-lg-5 grid-margin stretch-card">
            <div class="card slider-card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <h6 class="card-title mb-0 fw-bold fs-16">
                            <i class="fa-solid fa-sliders text-primary me-2"></i>স্লাইডার তথ্য আপডেট
                        </h6>
                        <span class="badge bg-light text-dark border fw-medium">ID: #{{ $slider->id }}</span>
                    </div>

                    <form action="{{ route('sliders.update', ['tenant' => auth()->user()->school->slug, 'id' => $slider->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="cropped_image" id="editCroppedImageInput">

                        {{-- ইমেজ আপলোড & প্রিভিউ --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">বর্তমান ইমেজ / নতুন ইমেজ পরিবর্তন</label>
                            <div class="edit-preview-box" id="editUploadBox" onclick="document.getElementById('editSliderImageInput').click();">
                                <img id="editImagePreview" src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" class="current-img-holder">
                                <div class="mt-2 text-primary fw-medium fs-13">
                                    <i class="fa-solid fa-crop-simple me-1"></i> নতুন ছবি নির্বাচন ও কাস্টম ক্রপ করতে ক্লিক করুন
                                </div>
                            </div>
                            <input type="file" name="image" id="editSliderImageInput" class="d-none" accept="image/*" onchange="initCropperForInput(this, 'editImagePreview', null, 'editCroppedImageInput')">
                            <small class="text-muted mt-1 d-block"><i class="fa-solid fa-circle-info me-1"></i>নতুন ছবি না দিতে চাইলে এটি খালি রাখুন।</small>
                            @error('image') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>

                        {{-- টাইটেল --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">টাইটেল (ঐচ্ছিক)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-heading text-muted"></i></span>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="স্লাইডার শিরোনাম" value="{{ old('title', $slider->title) }}">
                            </div>
                            @error('title') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>

                        {{-- সাব-টাইটেল --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">সাব-টাইটেল / বিবরণ (ঐচ্ছিক)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-align-left text-muted"></i></span>
                                <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" placeholder="স্কুলের সংক্ষিপ্ত বিবরণ" value="{{ old('subtitle', $slider->subtitle) }}">
                            </div>
                            @error('subtitle') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            {{-- সিরিয়াল নম্বর --}}
                            <div class="col-6 mb-3">
                                <label class="form-label fw-medium">সিরিয়াল (Order)</label>
                                <input type="number" name="order_by" class="form-control" value="{{ old('order_by', $slider->order_by) }}" min="0">
                            </div>

                            {{-- স্ট্যাটাস --}}
                            <div class="col-6 mb-3">
                                <label class="form-label fw-medium">স্ট্যাটাস</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ old('status', $slider->status) == 1 ? 'selected' : '' }}>সক্রিয় (Active)</option>
                                    <option value="0" {{ old('status', $slider->status) == 0 ? 'selected' : '' }}>নিষ্ক্রিয় (Inactive)</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-gradient-primary flex-grow-1 py-2 fw-medium">
                                <i class="fa-solid fa-rotate me-1"></i> স্লাইডার আপডেট করুন
                            </button>
                            <a href="{{ route('sliders.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-light border py-2 px-3">
                                বাতিল
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- স্লাইডার তালিকা রেফারেন্স (Right Column) --}}
        <div class="col-lg-7 grid-margin stretch-card">
            <div class="card slider-card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <h6 class="card-title mb-0 fw-bold fs-16">
                            <i class="fa-solid fa-images text-primary me-2"></i>অন্যান্য স্লাইডারসমূহ
                        </h6>
                        <span class="badge bg-primary rounded-pill px-3 py-2">মোট {{ count($sliders) }} টি স্লাইডার</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">সিরিয়াল</th>
                                    <th width="120">ছবি</th>
                                    <th>টাইটেল</th>
                                    <th width="90">স্ট্যাটাস</th>
                                    <th width="100" class="text-end">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $item)
                                <tr class="{{ $item->id == $slider->id ? 'table-primary-subtle' : '' }}">
                                    <td>
                                        <span class="badge bg-light text-dark fw-bold border px-2 py-1">
                                            #{{ $item->order_by }}
                                        </span>
                                    </td>
                                    <td>
                                        <img src="{{ asset($item->image) }}" 
                                             alt="{{ $item->title }}" 
                                             class="slider-thumb">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1">
                                            {{ $item->title ?: 'শিরোনাম ছাড়া' }}
                                            @if($item->id == $slider->id)
                                                <span class="badge bg-primary text-white fs-10 ms-1">সম্পাদনাধীন</span>
                                            @endif
                                        </div>
                                        <small class="text-muted text-truncate d-block" style="max-width: 200px;">
                                            {{ $item->subtitle ?: 'সাব-টাইটেল নেই' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($item->status == 1)
                                            <span class="badge badge-soft-success px-2 py-1 rounded-pill">
                                                সক্রিয়
                                            </span>
                                        @else
                                            <span class="badge badge-soft-secondary px-2 py-1 rounded-pill">
                                                নিষ্ক্রিয়
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($item->id != $slider->id)
                                            <a href="{{ route('sliders.edit', ['tenant' => auth()->user()->school->slug, 'id' => $item->id]) }}" 
                                               class="btn-action-edit"
                                               title="সম্পাদনা করুন"
                                               data-bs-toggle="tooltip">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11">বর্তমান</span>
                                        @endif
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

{{-- Cropper Modal --}}
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light py-3">
                <h5 class="modal-title fw-bold text-dark" id="cropperModalLabel">
                    <i class="fa-solid fa-crop-simple text-primary me-2"></i>ছবি ক্রপ করুন (Crop Image)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 bg-light p-2 rounded">
                    {{-- Fixed Aspect Ratio Indicator --}}
                    <div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fw-semibold fs-13">
                            <i class="fa-solid fa-lock me-1"></i> রেশিও: ১৬:৯ (ফিক্সড স্লাইডার সাইজ)
                        </span>
                    </div>

                    {{-- Tools --}}
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="rotateLeft" title="বামদিকে ঘোরান"><i class="fa-solid fa-rotate-left"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="rotateRight" title="ডানদিকে ঘোরান"><i class="fa-solid fa-rotate-right"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="zoomIn" title="জুম ইন"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="zoomOut" title="জুম আউট"><i class="fa-solid fa-magnifying-glass-minus"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="resetCropper" title="রিসেট"><i class="fa-solid fa-arrows-rotate"></i></button>
                    </div>
                </div>

                <div class="img-container" style="max-height: 480px; min-height: 350px; background: #000; overflow: hidden; border-radius: 8px;">
                    <img id="imageToCrop" src="" style="max-width: 100%; display: block; margin: 0 auto;">
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">বাতিল</button>
                <button type="button" id="cropAndApplyBtn" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-check me-1"></i> ক্রপ ও কনফার্ম করুন
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper = null;
    let currentFileInput = null;
    let currentPreviewImg = null;
    let currentPlaceholder = null;
    let currentCroppedHiddenInput = null;

    function initCropperForInput(input, previewId, placeholderId, hiddenInputId) {
        if (input.files && input.files[0]) {
            currentFileInput = input;
            currentPreviewImg = document.getElementById(previewId);
            currentPlaceholder = placeholderId ? document.getElementById(placeholderId) : null;
            currentCroppedHiddenInput = hiddenInputId ? document.getElementById(hiddenInputId) : null;

            const reader = new FileReader();
            reader.onload = function(e) {
                const imageToCrop = document.getElementById('imageToCrop');
                imageToCrop.src = e.target.result;

                const cropperModalEl = document.getElementById('cropperModal');
                const cropperModal = new bootstrap.Modal(cropperModalEl);
                cropperModal.show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('cropperModal').addEventListener('shown.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
        }
        const imageToCrop = document.getElementById('imageToCrop');
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 16 / 9, // ফিক্সড ১৬:৯ রেশিও (Slider standard)
            viewMode: 1,
            autoCropArea: 0.95,
            responsive: true,
            background: false,
            zoomable: true,
            scalable: true,
        });
    });

    // Ratio Toggle Buttons
    document.querySelectorAll('.ratio-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.ratio-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const ratio = parseFloat(this.dataset.ratio);
            if (cropper) {
                cropper.setAspectRatio(isNaN(ratio) ? NaN : ratio);
            }
        });
    });

    // Toolbar Actions
    document.getElementById('rotateLeft').addEventListener('click', () => cropper && cropper.rotate(-45));
    document.getElementById('rotateRight').addEventListener('click', () => cropper && cropper.rotate(45));
    document.getElementById('zoomIn').addEventListener('click', () => cropper && cropper.zoom(0.1));
    document.getElementById('zoomOut').addEventListener('click', () => cropper && cropper.zoom(-0.1));
    document.getElementById('resetCropper').addEventListener('click', () => cropper && cropper.reset());

    // Crop & Apply Button Click
    document.getElementById('cropAndApplyBtn').addEventListener('click', function() {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            maxWidth: 1920,
            maxHeight: 1080,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        if (!canvas) {
            Swal.fire({ icon: 'error', title: 'এরর', text: 'ছবিটি ক্রপ করতে ব্যর্থ হয়েছে।' });
            return;
        }

        const base64Data = canvas.toDataURL('image/jpeg', 0.92);

        // Store cropped base64 string into hidden input
        if (currentCroppedHiddenInput) {
            currentCroppedHiddenInput.value = base64Data;
        }

        // Also update file input via DataTransfer if supported
        canvas.toBlob(function(blob) {
            if (blob && currentFileInput && window.DataTransfer) {
                try {
                    const file = new File([blob], "cropped_slider.jpg", { type: "image/jpeg" });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    currentFileInput.files = dataTransfer.files;
                } catch(e) {
                    console.log('DataTransfer fallback used');
                }
            }

            if (currentPlaceholder) {
                currentPlaceholder.style.display = 'none';
            }
            if (currentPreviewImg) {
                currentPreviewImg.src = base64Data;
                currentPreviewImg.style.display = 'block';
            }

            const modalEl = document.getElementById('cropperModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        }, 'image/jpeg', 0.92);
    });
</script>
@endsection
