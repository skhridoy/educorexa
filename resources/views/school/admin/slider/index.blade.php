@extends('layouts.school')

@section('title', 'স্লাইডার ম্যানেজমেন্ট')

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

    .stat-card {
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(101, 113, 255, 0.05) 0%, rgba(101, 113, 255, 0.02) 100%);
        border: 1px solid rgba(101, 113, 255, 0.12);
        padding: 1.25rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .upload-preview-box {
        border: 2px dashed rgba(101, 113, 255, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        background: rgba(101, 113, 255, 0.02);
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .upload-preview-box:hover {
        border-color: #6571ff;
        background: rgba(101, 113, 255, 0.05);
    }

    .preview-img-holder {
        max-height: 180px;
        object-fit: cover;
        width: 100%;
        border-radius: 8px;
        display: none;
    }

    .slider-thumb {
        width: 120px;
        height: 68px;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .slider-thumb:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 14px rgba(0,0,0,0.18);
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

    .btn-action-edit, .btn-action-delete {
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
    }

    /* Light View High Contrast Explicit Styles */
    .btn-action-edit {
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

    .btn-action-delete {
        background-color: #fef2f2 !important;
        border: 1px solid #fecaca !important;
    }
    .btn-action-delete i, .btn-action-delete svg, .btn-action-delete * {
        color: #dc2626 !important;
        fill: #dc2626 !important;
        opacity: 1 !important;
    }
    .btn-action-delete:hover {
        background-color: #ef4444 !important;
        border-color: #ef4444 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.35);
    }
    .btn-action-delete:hover i, .btn-action-delete:hover svg, .btn-action-delete:hover * {
        color: #ffffff !important;
        fill: #ffffff !important;
    }

    /* Dark View High Contrast Styles */
    body.dark-mode .btn-action-edit {
        background-color: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border-color: rgba(245, 158, 11, 0.35);
    }

    body.dark-mode .btn-action-delete {
        background-color: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.35);
    }

    /* Full Responsiveness Media Queries */
    @media (max-width: 991.98px) {
        .page-content {
            padding: 1rem 0.5rem;
        }
        .stat-card {
            padding: 1rem;
        }
        .slider-thumb {
            width: 100px;
            height: 58px;
        }
    }

    @media (max-width: 575.98px) {
        .slider-thumb {
            width: 75px;
            height: 44px;
        }
        .btn-action-edit, .btn-action-delete {
            width: 32px;
            height: 32px;
            font-size: 1rem;
        }
        .upload-preview-box {
            padding: 1rem;
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
    {{-- Header Banner & Stats --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-primary">
                <i class="fa-solid fa-images me-2"></i> স্লাইডার ম্যানেজমেন্ট
            </h4>
            <p class="text-muted fs-14 mb-0">ওয়েবসাইটের প্রধান হিরো স্লাইডার ও ব্যানারসমূহ পরিচালনা ও সাজিয়ে রাখুন</p>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('school.dashboard', ['tenant' => auth()->user()->school->slug]) }}">ড্যাশবোর্ড</a></li>
                    <li class="breadcrumb-item active" aria-current="page">স্লাইডার</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Quick Stat Summary Row --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-4 stretch-card">
            <div class="stat-card d-flex align-items-center justify-content-between w-100">
                <div>
                    <h6 class="text-muted mb-1 fs-13">মোট স্লাইডার</h6>
                    <h3 class="fw-bold mb-0 text-primary">{{ $totalCount ?? 0 }}</h3>
                </div>
                <div class="stat-icon bg-primary text-white">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 stretch-card">
            <div class="stat-card d-flex align-items-center justify-content-between w-100">
                <div>
                    <h6 class="text-muted mb-1 fs-13">সক্রিয় স্লাইডার</h6>
                    <h3 class="fw-bold mb-0 text-success">{{ $activeCount ?? 0 }}</h3>
                </div>
                <div class="stat-icon bg-success text-white">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 stretch-card">
            <div class="stat-card d-flex align-items-center justify-content-between w-100">
                <div>
                    <h6 class="text-muted mb-1 fs-13">নিষ্ক্রিয় স্লাইডার</h6>
                    <h3 class="fw-bold mb-0 text-secondary">{{ $inactiveCount ?? 0 }}</h3>
                </div>
                <div class="stat-icon bg-secondary text-white">
                    <i class="fa-solid fa-circle-minus"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- স্লাইডার আপলোড ফর্ম (Left Column) --}}
        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card slider-card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <h6 class="card-title mb-0 fw-bold fs-16">
                            <i class="fa-solid fa-plus-circle text-primary me-2"></i>নতুন স্লাইডার যুক্ত করুন
                        </h6>
                    </div>

                    <form action="{{ route('sliders.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cropped_image" id="croppedImageInput">

                        {{-- ইমেজ আপলোড বক্স --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">ইমেজ (প্রয়োজনীয়) <span class="text-danger">*</span></label>
                            <div class="upload-preview-box" id="uploadBox" onclick="document.getElementById('sliderImageInput').click();">
                                <div id="uploadPlaceholder">
                                    <i class="fa-solid fa-cloud-arrow-up fs-2 text-primary mb-2"></i>
                                    <p class="mb-1 text-dark fw-medium">ছবি নির্বাচন করতে ক্লিক করুন</p>
                                    <small class="text-muted d-block">JPG, PNG, WEBP (কাস্টম ক্রপ করার সুবিধা সহ)</small>
                                </div>
                                <img id="imagePreview" src="#" alt="Preview" class="preview-img-holder">
                            </div>
                            <input type="file" name="image" id="sliderImageInput" class="d-none" accept="image/*" onchange="initCropperForInput(this, 'imagePreview', 'uploadPlaceholder', 'croppedImageInput')">
                            <small class="text-muted mt-1 d-block"><i class="fa-solid fa-crop-simple me-1 text-primary"></i>ছবি সিলেক্ট করলে ক্রপার পপআপ ওপেন হবে।</small>
                            @error('image') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>

                        {{-- টাইটেল --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">টাইটেল (ঐচ্ছিক)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-heading text-muted"></i></span>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="স্লাইডার শিরোনাম লিখুন" value="{{ old('title') }}">
                            </div>
                            @error('title') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>

                        {{-- সাব-টাইটেল --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">সাব-টাইটেল / বিবরণ (ঐচ্ছিক)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-align-left text-muted"></i></span>
                                <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" placeholder="স্কুলের সংক্ষিপ্ত স্লোগান বা বিবরণ" value="{{ old('subtitle') }}">
                            </div>
                            @error('subtitle') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            {{-- সিরিয়াল নম্বর --}}
                            <div class="col-6 mb-3">
                                <label class="form-label fw-medium">সিরিয়াল (Order)</label>
                                <input type="number" name="order_by" class="form-control" value="{{ old('order_by', 0) }}" min="0">
                            </div>

                            {{-- স্ট্যাটাস --}}
                            <div class="col-6 mb-3">
                                <label class="form-label fw-medium">স্ট্যাটাস</label>
                                <select name="status" class="form-select">
                                    <option value="1" selected>সক্রিয় (Active)</option>
                                    <option value="0">নিষ্ক্রিয় (Inactive)</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gradient-primary w-100 py-2 mt-2 fw-medium">
                            <i class="fa-solid fa-paper-plane me-1"></i> স্লাইডার সেভ করুন
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- স্লাইডার লিস্ট (Right Column) --}}
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card slider-card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <h6 class="card-title mb-0 fw-bold fs-16">
                            <i class="fa-solid fa-list text-primary me-2"></i>বর্তমান স্লাইডারসমূহ
                        </h6>
                        <span class="badge bg-primary rounded-pill px-3 py-2">মোট {{ count($sliders) }} টি স্লাইডার</span>
                    </div>

                    @if($sliders->isEmpty())
                        <div class="text-center py-5">
                            <i class="fa-regular fa-images fs-1 text-muted mb-3 d-block"></i>
                            <h6 class="mt-2 text-muted fw-normal">এখনো কোনো স্লাইডার যুক্ত করা হয়নি।</h6>
                            <p class="text-muted fs-12">বামপাশের ফর্ম ব্যবহার করে প্রথম স্লাইডারটি আপলোড করুন।</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60">সিরিয়াল</th>
                                        <th width="140">ছবি</th>
                                        <th>টাইটেল ও বিবরণ</th>
                                        <th width="100">স্ট্যাটাস</th>
                                        <th width="130" class="text-end">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sliders as $slider)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark fw-bold border px-2 py-1">
                                                #{{ $slider->order_by }}
                                            </span>
                                        </td>
                                        <td>
                                            <img src="{{ asset($slider->image) }}" 
                                                 alt="{{ $slider->title }}" 
                                                 class="slider-thumb"
                                                 onclick="showFullImage('{{ asset($slider->image) }}', '{{ $slider->title ?? 'Slider Image' }}')">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark mb-1">
                                                {{ $slider->title ?: 'শিরোনাম ছাড়া' }}
                                            </div>
                                            @if($slider->subtitle)
                                                <small class="text-muted d-block text-truncate" style="max-width: 280px;">
                                                    {{ $slider->subtitle }}
                                                </small>
                                            @else
                                                <small class="text-muted fst-italic">সাব-টাইটেল দেওয়া হয়নি</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($slider->status == 1)
                                                <span class="badge badge-soft-success px-2 py-1 rounded-pill">
                                                    <i class="fa-solid fa-circle fs-9 me-1"></i> সক্রিয়
                                                </span>
                                            @else
                                                <span class="badge badge-soft-secondary px-2 py-1 rounded-pill">
                                                    <i class="fa-solid fa-circle fs-9 me-1"></i> নিষ্ক্রিয়
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-2">
                                                {{-- এডিট বাটন --}}
                                                <a href="{{ route('sliders.edit', ['tenant' => auth()->user()->school->slug, 'id' => $slider->id]) }}" 
                                                   class="btn-action-edit" 
                                                   title="সম্পাদনা করুন"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                {{-- ডিলিট বাটন --}}
                                                <form action="{{ route('sliders.destroy', ['tenant' => auth()->user()->school->slug, 'id' => $slider->id]) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)" class="btn-action-delete" title="মুছে ফেলুন" data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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

{{-- Full Image View Modal --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="imageModalTitle">স্লাইডার ইমেজ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="modalFullImage" src="" class="img-fluid rounded shadow-sm" style="max-height: 500px; width: 100%; object-fit: contain;">
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

    // Modal Image Preview Zoom
    function showFullImage(src, title) {
        document.getElementById('modalFullImage').src = src;
        document.getElementById('imageModalTitle').innerText = title || 'স্লাইডার ইমেজ';
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    // Confirm Delete Alert
    function confirmDelete(button) {
        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: "এই স্লাইডারটি মুছে ফেলা হবে!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
            cancelButtonText: 'বাতিল'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'সফলতা!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection