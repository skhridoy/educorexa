@extends('layouts.main')

@section('customCSS')
    @include('layouts._shared_styles')
    @include('layouts._section_edit_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
@endsection

@section('content')
<div class="page-content">

    {{-- Breadcrumb --}}
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') ?? '#' }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('manage.frontend.index') }}">Frontend Sections</a></li>
        <li><span>/</span></li>
        <li class="active">Hero Section</li>
    </ul>

    {{-- Page Header --}}
    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon">
                <i class="bi bi-display"></i>
            </div>
            <div>
                <h2 class="se-header__title">Hero Section Edit</h2>
                <p class="se-header__sub">ওয়েবসাইটের প্রথম ব্যানার সেকশন কাস্টমাইজ করুন</p>
            </div>
        </div>
        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="fms-alert fms-alert--success mb-3">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- ===== LEFT COLUMN ===== --}}
            <div class="col-lg-8">

                {{-- Hero Content Card --}}
                <div class="se-card">
                    <div class="se-card__head">
                        <span class="se-card__head-dot"></span>
                        <h6 class="se-card__head-title">Hero Content</h6>
                        <span class="se-card__head-badge">Main Section</span>
                    </div>
                    <div class="se-card__body">

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="se-label">Main Title <span>*</span></label>
                                <input type="text" name="title" class="se-input"
                                       value="{{ $content['title'] ?? 'সবচেয়ে আধুনিক শিক্ষা ব্যবস্থাপনা সফটওয়্যার' }}"
                                       placeholder="Hero section এর প্রধান শিরোনাম">
                                <span class="se-hint">এটি hero section এ বড় করে দেখাবে</span>
                            </div>
                            <div class="col-md-12">
                                <label class="se-label">Sub Title / Badge Text</label>
                                <input type="text" name="subtitle" class="se-input"
                                       value="{{ $content['subtitle'] ?? 'Smart School ERP Solution' }}"
                                       placeholder="উপরের ছোট badge text">
                                <span class="se-hint">Badge এ দেখানো হবে, ছোট রাখুন</span>
                            </div>
                            <div class="col-md-12">
                                <label class="se-label">Description</label>
                                <textarea name="description" class="se-textarea" rows="4"
                                          placeholder="Hero section এর বিবরণ...">{{ $content['description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        {{-- Buttons Section --}}
                        <div class="se-section-label">
                            <span class="se-section-label__text">CTA Buttons & Links</span>
                            <div class="se-section-label__line"></div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="se-label">Primary Button Text</label>
                                <input type="text" name="btn1_text" class="se-input"
                                       value="{{ $content['btn1_text'] ?? 'বিনামূল্যে শুরু করুন' }}"
                                       placeholder="e.g. বিনামূল্যে শুরু করুন">
                            </div>
                            <div class="col-sm-6">
                                <label class="se-label">Primary Button Link <span>*</span></label>
                                <input type="url" name="btn1_link" class="se-input"
                                       value="{{ $content['btn1_link'] ?? '' }}"
                                       placeholder="https://example.com/register">
                                <span class="se-hint">রেজিস্ট্রেশন বা সাইনআপ লিঙ্ক</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="se-label">Secondary Button Text</label>
                                <input type="text" name="btn2_text" class="se-input"
                                       value="{{ $content['btn2_text'] ?? 'ডেমো দেখুন' }}"
                                       placeholder="e.g. ডেমো দেখুন">
                            </div>
                            <div class="col-sm-6">
                                <label class="se-label">Secondary Button Link</label>
                                <input type="text" name="btn2_link" class="se-input"
                                       value="{{ $content['btn2_link'] ?? '#' }}"
                                       placeholder="https://youtube.com/watch?v=...">
                                <span class="se-hint">ভিডিও বা ডেমো লিঙ্ক দিন</span>
                            </div>
                        </div>

                        {{-- Stats Section --}}
                        <div class="se-section-label">
                            <span class="se-section-label__text">Stats / Numbers</span>
                            <div class="se-section-label__line"></div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <label class="se-label">Stat 1 Value</label>
                                <input type="text" name="stat1_val" class="se-input"
                                       value="{{ $content['stat1_val'] ?? '৫০০+' }}"
                                       placeholder="e.g. ৫০০+">
                            </div>
                            <div class="col-sm-4">
                                <label class="se-label">Stat 1 Label</label>
                                <input type="text" name="stat1_label" class="se-input"
                                       value="{{ $content['stat1_label'] ?? 'স্কুল' }}"
                                       placeholder="e.g. স্কুল">
                            </div>
                            <div class="col-sm-4">
                                <label class="se-label">Stat 2 Value</label>
                                <input type="text" name="stat2_val" class="se-input"
                                       value="{{ $content['stat2_val'] ?? '২৪/৭' }}"
                                       placeholder="e.g. ২৪/৭">
                            </div>
                        </div>
                    </div>

                    {{-- Action bar --}}
                    <div class="se-action-bar">
                        <button type="submit" class="se-btn se-btn--primary">
                            <i class="bi bi-floppy-fill"></i> Save Changes
                        </button>
                        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary">
                            <i class="bi bi-x-lg"></i> Cancel
                        </a>
                    </div>
                </div>

            </div>

            {{-- ===== RIGHT COLUMN — Image Upload ===== --}}
            <div class="col-lg-4">
                <div class="se-card">
                    <div class="se-card__head">
                        <span class="se-card__head-dot"></span>
                        <h6 class="se-card__head-title">Dashboard Image</h6>
                    </div>
                    <div class="se-card__body">
                        <input type="hidden" name="image" id="croppedImageData">

                        {{-- Image upload clickable box --}}
                        <div class="se-img-box" onclick="document.getElementById('imageInput').click()">
                            <img id="imagePreview"
                                 src="{{ asset($content['image'] ?? 'frontend/images/hero-dashboard.jpg') }}"
                                 alt="Hero Image Preview"
                                 class="se-img-box__preview">
                            <div class="se-img-box__label">
                                <i class="bi bi-cloud-upload"></i> ছবি আপলোড করুন
                            </div>
                            <p class="se-img-box__hint">ক্লিক করে নতুন ছবি নির্বাচন করুন (Crop করা যাবে)</p>
                        </div>
                        <input type="file" name="image" class="form-control edu-input mt-2" accept="image/*" id="imageInput">

                        <div class="mt-3 p-3 rounded-3" style="background:#f0f7ff; border:1px solid rgba(0,97,168,0.12);">
                            <p class="mb-1" style="font-size:12px; font-weight:700; color:#0061A8;">
                                <i class="bi bi-info-circle me-1"></i> Image Guide
                            </p>
                            <ul style="font-size:11.5px; color:#64748b; padding-left:16px; margin:0;">
                                <li>Recommended: 700 × 496 px</li>
                                <li>Format: PNG, JPG, WebP</li>
                                <li>আপলোডের পর Crop করার সুযোগ পাবেন</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Preview tip --}}
                <div class="se-card" style="border-color: rgba(34,197,94,0.2); background: #f0fdf4;">
                    <div class="se-card__body" style="padding: 16px 20px;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                            <i class="bi bi-eye-fill" style="color:#16a34a; font-size:18px;"></i>
                            <span style="font-size:13px; font-weight:700; color:#166534;">Live Preview</span>
                        </div>
                        <p style="font-size:12px; color:#15803d; margin:0;">
                            সেভ করার পর ওয়েবসাইটের হোমপেজ রিফ্রেশ করে দেখুন।
                        </p>
                        <a href="{{ url('/') }}" target="_blank"
                           style="display:inline-flex;align-items:center;gap:5px;margin-top:10px;font-size:12px;font-weight:700;color:#0061A8;text-decoration:none;">
                            <i class="bi bi-box-arrow-up-right"></i> হোমপেজ দেখুন
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>

{{-- Cropper Modal --}}
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; overflow:hidden;">
            <div class="modal-header" style="background:#f8fbff; border-bottom:1px solid #e8f3fb;">
                <h5 class="modal-title" style="font-family:'Poppins',sans-serif;font-weight:700;">
                    <i class="bi bi-crop me-2" style="color:#0061A8;"></i>Crop Image
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="background:#f8fbff;">
                <div class="img-container" style="max-height:450px; overflow:hidden;">
                    <img id="cropperImage" src="" style="max-width:100%;">
                </div>
            </div>
            <div class="modal-footer" style="background:#f8fbff; border-top:1px solid #e8f3fb;">
                <button type="button" class="se-btn se-btn--secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Cancel
                </button>
                <button type="button" class="se-btn se-btn--primary" id="cropButton">
                    <i class="bi bi-check2-circle"></i> Crop & Apply
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush

@push('customJs')
<script>
let cropper;
const imageInput    = document.getElementById('imageInput');
const cropperImage  = document.getElementById('cropperImage');
const cropperModal  = new bootstrap.Modal(document.getElementById('cropperModal'));
const croppedData   = document.getElementById('croppedImageData');
const imagePreview  = document.getElementById('imagePreview');

imageInput.addEventListener('change', function(e) {
    const files = e.target.files;
    if (files && files.length > 0) {
        const reader = new FileReader();
        reader.onload = function(event) {
            cropperImage.src = event.target.result;
            cropperModal.show();
        };
        reader.readAsDataURL(files[0]);
    }
});

document.getElementById('cropperModal').addEventListener('shown.bs.modal', function() {
    cropper = new Cropper(cropperImage, { aspectRatio: 700 / 496, viewMode: 1 });
});

document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function() {
    if (cropper) { cropper.destroy(); cropper = null; }
    imageInput.value = '';
});

document.getElementById('cropButton').addEventListener('click', function() {
    if (!cropper) return;
    const canvas = cropper.getCroppedCanvas({ width: 700, height: 496 });
    const base64 = canvas.toDataURL('image/png');
    imagePreview.src = base64;
    croppedData.value = base64;
    cropperModal.hide();
});
</script>
@endpush