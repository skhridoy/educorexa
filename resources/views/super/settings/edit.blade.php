@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Site Settings</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-gears me-2" style="color:#4f46e5;"></i> General Site Settings</h2>
            <p class="edu-page-sub">Configure main platform branding, contact info, and SEO metadata.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="edu-alert-success">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">Branding & General Information</h6>
        </div>
        <div class="edu-panel-bd">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Basic Info --}}
                <div class="edu-section-label">General Information</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="edu-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control edu-input" value="{{ $setting->site_name ?? 'EduCorexa' }}" placeholder="EduCorexa">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Contact Email</label>
                        <input type="email" name="email" class="form-control edu-input" value="{{ $setting->email ?? '' }}" placeholder="hello@educorexa.com">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control edu-input" value="{{ $setting->phone ?? '' }}" placeholder="+880 1XXX-XXXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Address</label>
                        <input type="text" name="address" class="form-control edu-input" value="{{ $setting->address ?? '' }}" placeholder="Dhaka, Bangladesh">
                    </div>
                </div>

                <div class="edu-divider"></div>

                {{-- Branding --}}
                <div class="edu-section-label">Branding & Visuals</div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4 text-center">
                        <label class="edu-label mb-2 d-block">Header Logo (Wide)</label>
                        <div style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:20px; margin-bottom:12px; height:120px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            <img id="wide_preview" src="{{ $setting && $setting->logo_wide ? asset($setting->logo_wide) : asset('frontend/img/placeholder-wide.png') }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <input type="file" name="logo_wide" class="form-control edu-input" style="font-size: 0.75rem;" onchange="previewImg(this, 'wide_preview')">
                    </div>
                    <div class="col-md-4 text-center">
                        <label class="edu-label mb-2 d-block">Square Icon / Logo</label>
                        <div style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:20px; margin-bottom:12px; height:120px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            <img id="square_preview" src="{{ $setting && $setting->logo_square ? asset($setting->logo_square) : asset('frontend/img/placeholder-square.png') }}" style="width: 80px; height: 80px; object-fit: contain;">
                        </div>
                        <input type="file" name="logo_square" class="form-control edu-input" style="font-size: 0.75rem;" onchange="previewImg(this, 'square_preview')">
                    </div>
                    <div class="col-md-4 text-center">
                        <label class="edu-label mb-2 d-block">Site Favicon</label>
                        <div style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:20px; margin-bottom:12px; height:120px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            <img id="favicon_preview" src="{{ $setting && $setting->favicon ? asset($setting->favicon) : asset('frontend/img/favicon.ico') }}" style="width: 32px; height: 32px; object-fit: contain;">
                        </div>
                        <input type="file" name="favicon" class="form-control edu-input" style="font-size: 0.75rem;" onchange="previewImg(this, 'favicon_preview')">
                    </div>
                </div>

                <div class="edu-divider"></div>

                {{-- SEO --}}
                <div class="edu-section-label">SEO & Social Metadata</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="edu-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control edu-input" value="{{ $setting->meta_title ?? '' }}" placeholder="EduCorexa - Next Gen School ERP">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control edu-input" value="{{ $setting->meta_keywords ?? '' }}" placeholder="school erp, education software, bangladesh">
                    </div>
                    <div class="col-md-8">
                        <label class="edu-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control edu-input" rows="4">{{ $setting->meta_description ?? '' }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="edu-label">OG Image (Social Share Preview)</label>
                        <div style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:10px; margin-bottom:10px; height:80px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            <img id="og_preview" src="{{ $setting && $setting->og_image ? asset($setting->og_image) : asset('frontend/img/placeholder-wide.png') }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <input type="file" name="og_image" class="form-control edu-input" style="font-size: 0.75rem;" onchange="previewImg(this, 'og_preview')">
                    </div>
                </div>

                <!-- Social Links -->
                <div class="edu-section-label">Social Media Links</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="edu-label">Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control edu-input" value="{{ $setting->facebook_url ?? '' }}" placeholder="https://www.facebook.com/yourpage">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Twitter URL</label>
                        <input type="url" name="twitter_url" class="form-control edu-input" value="{{ $setting->twitter_url ?? '' }}" placeholder="https://www.twitter.com/yourprofile">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" class="form-control edu-input" value="{{ $setting->linkedin_url ?? '' }}" placeholder="https://www.linkedin.com/yourprofile">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control edu-input" value="{{ $setting->instagram_url ?? '' }}" placeholder="https://www.instagram.com/yourprofile">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="edu-label">Footer Text / Copyright Notice</label>
                    <textarea name="footer_text" class="form-control edu-input" rows="2">{{ $setting->footer_text ?? '' }}</textarea>
                </div>

                <div class="edu-divider"></div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 36px;">
                        <i data-feather="save" style="width:16px; height:16px;"></i> Save Platform Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function previewImg(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection