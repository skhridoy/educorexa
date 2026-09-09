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
        <li class="active">Why Choose Us</li>
    </ul>

    {{-- Page Header --}}
    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background: linear-gradient(135deg,#22c55e,#16a34a);">
                <i class="bi bi-patch-check-fill"></i>
            </div>
            <div>
                <h2 class="se-header__title">Why Choose Us — Edit</h2>
                <p class="se-header__sub">কেন আমরা আলাদা — এই সেকশনের কন্টেন্ট কাস্টমাইজ করুন</p>
            </div>
        </div>
        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="fms-alert fms-alert--success mb-3">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- ===== LEFT: Main content ===== --}}
            <div class="col-lg-8">

                {{-- Section content --}}
                <div class="se-card">
                    <div class="se-card__head">
                        <span class="se-card__head-dot"></span>
                        <h6 class="se-card__head-title">Section Content</h6>
                        <span class="se-card__head-badge">Main Text</span>
                    </div>
                    <div class="se-card__body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="se-label">Section Title <span>*</span></label>
                                <input type="text" name="title" class="se-input"
                                       value="{{ $content['title'] ?? 'কেন EduCorexa বেছে নেবেন?' }}"
                                       placeholder="e.g. কেন EduCorexa বেছে নেবেন?">
                            </div>
                            <div class="col-md-4">
                                <label class="se-label">Button Text</label>
                                <input type="text" name="btn_text" class="se-input"
                                       value="{{ $content['btn_text'] ?? 'আরও জানুন' }}"
                                       placeholder="e.g. আরও জানুন">
                            </div>
                            <div class="col-md-8">
                                <label class="se-label">Description</label>
                                <textarea name="description" class="se-textarea" rows="3"
                                          placeholder="Section এর বিবরণ...">{{ $content['description'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="se-label">Button Link</label>
                                <input type="text" name="btn_link" class="se-input"
                                       value="{{ $content['btn_link'] ?? '#contact' }}"
                                       placeholder="#contact">
                                <span class="se-hint">Anchor বা পেজ URL</span>
                            </div>
                        </div>

                        {{-- Points --}}
                        <div class="se-section-label">
                            <span class="se-section-label__text">Key Points (৪টি)</span>
                            <div class="se-section-label__line"></div>
                        </div>

                        @foreach([1,2,3,4] as $i)
                        <div class="wcu-point-block">
                            <div class="wcu-point-block__num">{{ $i }}</div>
                            <div class="row g-2 flex-grow-1">
                                <div class="col-sm-4">
                                    <label class="se-label">Point {{ $i }} Title</label>
                                    <input type="text" name="point{{ $i }}_title" class="se-input"
                                           value="{{ $content['point'.$i.'_title'] ?? '' }}"
                                           placeholder="শিরোনাম...">
                                </div>
                                <div class="col-sm-8">
                                    <label class="se-label">Point {{ $i }} Description</label>
                                    <input type="text" name="point{{ $i }}_desc" class="se-input"
                                           value="{{ $content['point'.$i.'_desc'] ?? '' }}"
                                           placeholder="বিবরণ...">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

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

            {{-- ===== RIGHT: Image Upload ===== --}}
            <div class="col-lg-4">
                <div class="se-card">
                    <div class="se-card__head">
                        <span class="se-card__head-dot"></span>
                        <h6 class="se-card__head-title">Section Image</h6>
                    </div>
                    <div class="se-card__body">
                        <input type="hidden" name="image" id="croppedImageData">
                        <div class="se-img-box" onclick="document.getElementById('imageInput').click()">
                            <img id="imagePreview"
                                 src="{{ asset($content['image'] ?? 'frontend/images/hero-dashboard.jpg') }}"
                                 alt="Why Choose Us Image"
                                 class="se-img-box__preview">
                            <div class="se-img-box__label">
                                <i class="bi bi-cloud-upload"></i> ছবি আপলোড করুন
                            </div>
                            <p class="se-img-box__hint">ক্লিক করে নতুন ছবি নির্বাচন করুন</p>
                        </div>
                        <input type="file" name="image" class="form-control edu-input mt-2" accept="image/*" id="imageInput">

                        <div class="mt-3 p-3 rounded-3" style="background:#f0f7ff; border:1px solid rgba(0,97,168,0.12);">
                            <p class="mb-1" style="font-size:12px; font-weight:700; color:#0061A8;">
                                <i class="bi bi-info-circle me-1"></i> Image Guide
                            </p>
                            <ul style="font-size:11.5px; color:#64748b; padding-left:16px; margin:0;">
                                <li>Recommended: 700 × 600 px</li>
                                <li>Format: PNG, JPG, WebP</li>
                                <li>আপলোডের পর Crop করা যাবে</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="se-card" style="border-color:rgba(34,197,94,0.2); background:#f0fdf4;">
                    <div class="se-card__body" style="padding:16px 20px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                            <i class="bi bi-eye-fill" style="color:#16a34a;font-size:18px;"></i>
                            <span style="font-size:13px;font-weight:700;color:#166534;">Live Preview</span>
                        </div>
                        <p style="font-size:12px;color:#15803d;margin:0;">সেভ করার পর হোমপেজ রিফ্রেশ করুন।</p>
                        <a href="{{ url('/') }}#why-choose-us" target="_blank"
                           style="display:inline-flex;align-items:center;gap:5px;margin-top:10px;font-size:12px;font-weight:700;color:#0061A8;text-decoration:none;">
                            <i class="bi bi-box-arrow-up-right"></i> Section দেখুন
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

<style>
.wcu-point-block {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 14px 16px;
    background: #f8fbff;
    border-radius: 12px;
    border: 1px solid rgba(0,97,168,0.08);
    margin-bottom: 10px;
}
.wcu-point-block__num {
    width: 28px; height: 28px;
    background: linear-gradient(135deg, #0061A8, #0080d4);
    color: #fff;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800;
    flex-shrink: 0; margin-top: 22px;
}
.wcu-point-block .flex-grow-1 { flex: 1; }
</style>
@endsection

@push('plugin-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush

@push('customJs')
<script>
var cropper;
const cropperModalEl = document.getElementById('cropperModal');
const cropperModal   = new bootstrap.Modal(cropperModalEl);
const imageInput     = document.getElementById('imageInput');
const cropperImage   = document.getElementById('cropperImage');
const croppedData    = document.getElementById('croppedImageData');
const imagePreview   = document.getElementById('imagePreview');

imageInput.addEventListener('change', function(e) {
    if (e.target.files && e.target.files.length > 0) {
        const reader = new FileReader();
        reader.onload = function(ev) { cropperImage.src = ev.target.result; cropperModal.show(); };
        reader.readAsDataURL(e.target.files[0]);
    }
});
cropperModalEl.addEventListener('shown.bs.modal', function() {
    cropper = new Cropper(cropperImage, { aspectRatio: 1.3 / 1, viewMode: 2, autoCropArea: 1 });
});
cropperModalEl.addEventListener('hidden.bs.modal', function() {
    if (cropper) { cropper.destroy(); cropper = null; }
    imageInput.value = '';
});
document.getElementById('cropButton').addEventListener('click', function() {
    if (!cropper) return;
    const canvas = cropper.getCroppedCanvas({ width: 700, height: 600, imageSmoothingQuality: 'high' });
    if (canvas) { imagePreview.src = croppedData.value = canvas.toDataURL('image/png'); cropperModal.hide(); }
});
</script>
@endpush