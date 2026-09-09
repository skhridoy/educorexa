@extends('layouts.main')
@section('customCSS')
    @include('layouts._shared_styles')
    @include('layouts._section_edit_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') ?? '#' }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('manage.frontend.index') }}">Frontend Sections</a></li>
        <li><span>/</span></li>
        <li class="active">About Us</li>
    </ul>

    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background:linear-gradient(135deg,#16a34a,#22c55e);">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div>
                <h2 class="se-header__title">About Us — Edit</h2>
                <p class="se-header__sub">আমাদের সম্পর্কে সেকশনের কন্টেন্ট কাস্টমাইজ করুন</p>
            </div>
        </div>
        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="fms-alert fms-alert--success mb-3"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
        @csrf
        <div class="row g-4">

            <div class="col-lg-8">
                <div class="se-card">
                    <div class="se-card__head">
                        <span class="se-card__head-dot"></span>
                        <h6 class="se-card__head-title">Section Content</h6>
                        <span class="se-card__head-badge">About Us</span>
                    </div>
                    <div class="se-card__body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="se-label">Badge Text</label>
                                <input type="text" name="badge_text" class="se-input" value="{{ $content['badge_text'] ?? 'WHO WE ARE' }}" placeholder="e.g. WHO WE ARE">
                            </div>
                            <div class="col-md-8">
                                <label class="se-label">Main Title <span>*</span></label>
                                <input type="text" name="title" class="se-input" value="{{ $content['title'] ?? '' }}" placeholder="About section এর শিরোনাম">
                            </div>
                            <div class="col-md-12">
                                <label class="se-label">Description</label>
                                <textarea name="description" class="se-textarea" rows="4" placeholder="আমাদের সম্পর্কে বিবরণ...">{{ $content['description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="se-section-label">
                            <span class="se-section-label__text">Badges & Features</span>
                            <div class="se-section-label__line"></div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <label class="se-label">Years of Experience</label>
                                <input type="text" name="exp_year" class="se-input" value="{{ $content['exp_year'] ?? '' }}" placeholder="e.g. ৫+">
                            </div>
                            <div class="col-sm-4">
                                <label class="se-label">Support Hours</label>
                                <input type="text" name="support_time" class="se-input" value="{{ $content['support_time'] ?? '' }}" placeholder="e.g. ২৪/৭">
                            </div>
                            <div class="col-sm-4">
                                <label class="se-label">Contact Phone</label>
                                <input type="text" name="phone" class="se-input" value="{{ $content['phone'] ?? '' }}" placeholder="+880 1XXXXXXXXX">
                            </div>
                            <div class="col-sm-6">
                                <label class="se-label">Feature 1 Title</label>
                                <input type="text" name="f1_title" class="se-input" value="{{ $content['f1_title'] ?? '' }}" placeholder="Feature শিরোনাম...">
                            </div>
                            <div class="col-sm-6">
                                <label class="se-label">Feature 2 Title</label>
                                <input type="text" name="f2_title" class="se-input" value="{{ $content['f2_title'] ?? '' }}" placeholder="Feature শিরোনাম...">
                            </div>
                        </div>
                    </div>
                    <div class="se-action-bar">
                        <button type="submit" class="se-btn se-btn--primary"><i class="bi bi-floppy-fill"></i> Save Changes</button>
                        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary"><i class="bi bi-x-lg"></i> Cancel</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="se-card">
                    <div class="se-card__head">
                        <span class="se-card__head-dot"></span>
                        <h6 class="se-card__head-title">Section Image</h6>
                    </div>
                    <div class="se-card__body">
                        <input type="hidden" name="image" id="croppedImageData">
                        <div class="se-img-box" onclick="document.getElementById('imageInput').click()">
                            <img id="imagePreview" src="{{ asset($content['image'] ?? 'frontend/img/about-vision.jpg') }}" alt="About Image" class="se-img-box__preview">
                            <div class="se-img-box__label"><i class="bi bi-cloud-upload"></i> ছবি আপলোড করুন</div>
                            <p class="se-img-box__hint">ক্লিক করে নির্বাচন করুন</p>
                        </div>
                        <input type="file" name="image" class="form-control edu-input mt-2" accept="image/*" id="imageInput">
                        <div class="mt-3 p-3 rounded-3" style="background:#f0f7ff;border:1px solid rgba(0,97,168,0.12);">
                            <p class="mb-1" style="font-size:12px;font-weight:700;color:#0061A8;"><i class="bi bi-info-circle me-1"></i> Guide</p>
                            <ul style="font-size:11.5px;color:#64748b;padding-left:16px;margin:0;"><li>Recommended: 600 × 500 px</li><li>Format: PNG, JPG, WebP</li></ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header" style="background:#f8fbff;border-bottom:1px solid #e8f3fb;">
                <h5 class="modal-title" style="font-family:'Poppins',sans-serif;font-weight:700;"><i class="bi bi-crop me-2" style="color:#0061A8;"></i>Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="background:#f8fbff;"><div class="img-container" style="max-height:420px;overflow:hidden;"><img id="cropperImage" src="" style="max-width:100%;"></div></div>
            <div class="modal-footer" style="background:#f8fbff;border-top:1px solid #e8f3fb;">
                <button type="button" class="se-btn se-btn--secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cancel</button>
                <button type="button" class="se-btn se-btn--primary" id="cropButton"><i class="bi bi-check2-circle"></i> Crop & Apply</button>
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
var cropper, cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
document.getElementById('imageInput').addEventListener('change', function(e) {
    if(e.target.files.length) { var r=new FileReader(); r.onload=function(ev){document.getElementById('cropperImage').src=ev.target.result;cropperModal.show();}; r.readAsDataURL(e.target.files[0]); }
});
document.getElementById('cropperModal').addEventListener('shown.bs.modal', function() { cropper=new Cropper(document.getElementById('cropperImage'),{aspectRatio:1.2/1,viewMode:1}); });
document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function() { if(cropper){cropper.destroy();cropper=null;} document.getElementById('imageInput').value=''; });
document.getElementById('cropButton').addEventListener('click', function() { if(!cropper)return; var c=cropper.getCroppedCanvas({width:600,height:500}); document.getElementById('imagePreview').src=document.getElementById('croppedImageData').value=c.toDataURL('image/png'); cropperModal.hide(); });
</script>
@endpush