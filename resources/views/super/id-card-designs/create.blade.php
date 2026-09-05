@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    .color-input-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .color-picker-input {
        width: 44px;
        height: 38px;
        padding: 2px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        background: #fff;
    }
    .preview-sticky {
        position: sticky;
        top: 24px;
    }
    .preview-card-box {
        background: #f1f5f9;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 30px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    /* ID Card Simulation */
    .sim-card {
        width: 220px;
        height: 320px;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .sim-header {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 95px;
        background-color: #6a1b9a;
        z-index: 1;
        overflow: hidden;
    }
    .sim-header img {
        width: 100%;
        height: 100%;
        object-fit: fill;
        display: block;
    }
    .sim-school-text {
        position: absolute;
        top: 10px;
        left: 0;
        width: 100%;
        text-align: center;
        color: #ffffff;
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
        text-shadow: 0 1px 3px rgba(0,0,0,0.4);
    }
    .sim-photo-wrap {
        position: relative;
        z-index: 3;
        margin-top: 55px;
        width: 65px;
        height: 80px;
        border-radius: 8px;
        background: #f8fafc;
        border: 3px solid #ab47bc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 26px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        overflow: hidden;
    }
    .sim-photo-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .sim-name {
        margin-top: 8px;
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        text-align: center;
    }
    .sim-badge {
        margin-top: 4px;
        font-size: 9px;
        font-weight: 700;
        color: #ffffff;
        background: #6a1b9a;
        padding: 2px 10px;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .sim-info-table {
        margin-top: 8px;
        width: 85%;
        font-size: 9px;
        border-collapse: collapse;
    }
    .sim-info-table td {
        padding: 2px 4px;
    }
    .sim-info-label {
        font-weight: 700;
        color: #7b1fa2;
        width: 45%;
    }
    .sim-info-val {
        font-weight: 600;
        color: #334155;
    }
    .sim-bottom-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 10px;
        background: #6a1b9a;
        z-index: 2;
    }
    .sim-bottom-bar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .preset-chip {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        background: #fff;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .preset-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.id-card-designs.index') }}">ID Card Designs</a></li>
        <li><span>/</span></li>
        <li class="active">Add New Design</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-plus-circle me-2" style="color:#4f46e5;"></i> Add ID Card Design</h2>
            <p class="edu-page-sub">Upload custom header shape and configure the visual styling of student ID cards.</p>
        </div>
    </div>

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Left: Form Inputs --}}
        <div class="col-lg-7">
            <form action="{{ route('super.id-card-designs.store') }}" method="POST" enctype="multipart/form-data" id="designForm">
                @csrf
                
                {{-- Basic Details --}}
                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd">
                        <h6 class="edu-panel-ttl"><i class="fa-solid fa-tag me-2 text-primary"></i> Basic Information</h6>
                    </div>
                    <div class="edu-panel-bd">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="edu-label">Design Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="designName" class="form-control edu-input" placeholder="e.g. Royal Purple Curve" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-5">
                                <label class="edu-label">Slug (Optional)</label>
                                <input type="text" name="slug" id="designSlug" class="form-control edu-input" placeholder="e.g. royal-purple" value="{{ old('slug') }}">
                                <small class="text-muted">Auto-generated if left blank</small>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control edu-input" value="{{ old('sort_order', 0) }}">
                            </div>
                            <div class="col-md-6 d-flex align-items-center pt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="isActive">Is Active (Visible to Schools)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Shape & Images Upload --}}
                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd">
                        <h6 class="edu-panel-ttl"><i class="fa-solid fa-shapes me-2 text-primary"></i> Shape & Image Assets</h6>
                    </div>
                    <div class="edu-panel-bd">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="edu-label">Header Shape Image (PNG / JPG)</label>
                                <input type="file" name="header_shape" id="headerShapeInput" class="form-control edu-input" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">Upload your custom header shape graphic (3:1 aspect ratio or ~720x240px transparent PNG recommended). When uploaded, this shape overlays the card header!</small>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Bottom Gradient Bar (Optional)</label>
                                <input type="file" name="gradient_bar" id="bottomBarInput" class="form-control edu-input" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">Image bar placed at card bottom</small>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Pattern Overlay (Optional)</label>
                                <input type="file" name="pattern" class="form-control edu-input" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">Subtle watermark / pattern</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Color Palette --}}
                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd d-flex justify-content-between align-items-center">
                        <h6 class="edu-panel-ttl"><i class="fa-solid fa-palette me-2 text-primary"></i> Color Palette</h6>
                        <span class="text-muted small">Pick custom colors or select a preset below</span>
                    </div>
                    <div class="edu-panel-bd">
                        {{-- Presets --}}
                        <div class="mb-3">
                            <label class="edu-label mb-2">Quick Presets:</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="preset-chip" onclick="applyPreset('#6a1b9a','#6a1b9a','#7b1fa2','#ab47bc','#f3e5f5','#6a1b9a')">
                                    <span style="width:12px;height:12px;border-radius:50%;background:#6a1b9a;display:inline-block;"></span> Royal Purple
                                </button>
                                <button type="button" class="preset-chip" onclick="applyPreset('#1e3a8a','#1e3a8a','#1d4ed8','#3b82f6','#dbeafe','#1e3a8a')">
                                    <span style="width:12px;height:12px;border-radius:50%;background:#1e3a8a;display:inline-block;"></span> Deep Navy
                                </button>
                                <button type="button" class="preset-chip" onclick="applyPreset('#065f46','#065f46','#047857','#10b981','#d1fae5','#065f46')">
                                    <span style="width:12px;height:12px;border-radius:50%;background:#065f46;display:inline-block;"></span> Emerald Green
                                </button>
                                <button type="button" class="preset-chip" onclick="applyPreset('#991b1b','#991b1b','#b91c1c','#ef4444','#fee2e2','#991b1b')">
                                    <span style="width:12px;height:12px;border-radius:50%;background:#991b1b;display:inline-block;"></span> Crimson Red
                                </button>
                                <button type="button" class="preset-chip" onclick="applyPreset('#0f766e','#0f766e','#0d9488','#14b8a6','#ccfbf1','#0f766e')">
                                    <span style="width:12px;height:12px;border-radius:50%;background:#0f766e;display:inline-block;"></span> Teal Ocean
                                </button>
                                <button type="button" class="preset-chip" onclick="applyPreset('#1e293b','#1e293b','#334155','#64748b','#f1f5f9','#1e293b')">
                                    <span style="width:12px;height:12px;border-radius:50%;background:#1e293b;display:inline-block;"></span> Slate Dark
                                </button>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="edu-label">Primary Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="primaryColorPick" class="color-picker-input" value="{{ old('primary_color', '#6a1b9a') }}">
                                    <input type="text" name="primary_color" id="primaryColorText" class="form-control edu-input" value="{{ old('primary_color', '#6a1b9a') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Student Badge Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="badgeColorPick" class="color-picker-input" value="{{ old('badge_color', '#6a1b9a') }}">
                                    <input type="text" name="badge_color" id="badgeColorText" class="form-control edu-input" value="{{ old('badge_color', '#6a1b9a') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Field Label Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="labelColorPick" class="color-picker-input" value="{{ old('label_color', '#7b1fa2') }}">
                                    <input type="text" name="label_color" id="labelColorText" class="form-control edu-input" value="{{ old('label_color', '#7b1fa2') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Photo Border Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="photoBorderColorPick" class="color-picker-input" value="{{ old('photo_border_color', '#ab47bc') }}">
                                    <input type="text" name="photo_border_color" id="photoBorderColorText" class="form-control edu-input" value="{{ old('photo_border_color', '#ab47bc') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Back Header Background <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="backHeaderBgPick" class="color-picker-input" value="{{ old('back_header_bg', '#f3e5f5') }}">
                                    <input type="text" name="back_header_bg" id="backHeaderBgText" class="form-control edu-input" value="{{ old('back_header_bg', '#f3e5f5') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Back Header Text Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="backHeaderTextColorPick" class="color-picker-input" value="{{ old('back_header_text', '#6a1b9a') }}">
                                    <input type="text" name="back_header_text" id="backHeaderTextColorText" class="form-control edu-input" value="{{ old('back_header_text', '#6a1b9a') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-edu btn-edu-primary" style="padding: 12px 36px;">
                        <i class="fa-solid fa-check me-1"></i> Save Design
                    </button>
                    <a href="{{ route('super.id-card-designs.index') }}" class="btn-edu btn-edu-light" style="padding: 12px 28px;">Cancel</a>
                </div>
            </form>
        </div>

        {{-- Right: Live Interactive Card Preview --}}
        <div class="col-lg-5">
            <div class="preview-sticky">
                <div class="preview-card-box">
                    <h6 class="text-muted mb-3 fw-bold"><i class="fa-solid fa-eye me-1"></i> Live Design Preview</h6>

                    <div class="sim-card">
                        <div class="sim-header" id="previewSimHeader">
                            <img id="previewShapeImg" src="" style="display:none;" alt="Shape">
                        </div>
                        <div class="sim-school-text">IDEAL MODEL SCHOOL</div>
                        
                        <div class="sim-photo-wrap" id="previewPhotoWrap">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        
                        <div class="sim-name" id="previewStudentName">ARIF HOSSAIN</div>
                        <div class="sim-badge" id="previewBadge">STUDENT</div>

                        <table class="sim-info-table">
                            <tr>
                                <td class="sim-info-label" id="previewLbl1">Class</td>
                                <td class="sim-info-val">: Class 8</td>
                            </tr>
                            <tr>
                                <td class="sim-info-label" id="previewLbl2">Roll No</td>
                                <td class="sim-info-val">: 12</td>
                            </tr>
                            <tr>
                                <td class="sim-info-label" id="previewLbl3">Blood Grp</td>
                                <td class="sim-info-val">: B+</td>
                            </tr>
                        </table>

                        <div class="sim-bottom-bar" id="previewBottomBar">
                            <img id="previewBottomImg" src="" style="display:none;" alt="Bar">
                        </div>
                    </div>

                    <div class="text-center mt-3 text-muted small">
                        Card dimensions and elements dynamically adapt to colors and shape image.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJS')
<script>
    // Color sync helpers
    function syncColor(pickId, textId, updateCallback) {
        const picker = document.getElementById(pickId);
        const text = document.getElementById(textId);
        if (!picker || !text) return;

        picker.addEventListener('input', () => {
            text.value = picker.value;
            if (updateCallback) updateCallback(picker.value);
        });
        text.addEventListener('input', () => {
            if (/^#[0-9A-Fa-f]{6}$/.test(text.value)) {
                picker.value = text.value;
                if (updateCallback) updateCallback(text.value);
            }
        });
    }

    // Update preview elements
    function updatePrimaryColor(val) {
        document.getElementById('previewSimHeader').style.backgroundColor = val;
        document.getElementById('previewBottomBar').style.backgroundColor = val;
    }
    function updateBadgeColor(val) {
        document.getElementById('previewBadge').style.backgroundColor = val;
    }
    function updateLabelColor(val) {
        document.getElementById('previewLbl1').style.color = val;
        document.getElementById('previewLbl2').style.color = val;
        document.getElementById('previewLbl3').style.color = val;
    }
    function updatePhotoBorder(val) {
        document.getElementById('previewPhotoWrap').style.borderColor = val;
    }

    syncColor('primaryColorPick', 'primaryColorText', updatePrimaryColor);
    syncColor('badgeColorPick', 'badgeColorText', updateBadgeColor);
    syncColor('labelColorPick', 'labelColorText', updateLabelColor);
    syncColor('photoBorderColorPick', 'photoBorderColorText', updatePhotoBorder);
    syncColor('backHeaderBgPick', 'backHeaderBgText');
    syncColor('backHeaderTextColorPick', 'backHeaderTextColorText');

    // Preset helper
    function applyPreset(primary, badge, label, border, backBg, backText) {
        document.getElementById('primaryColorPick').value = primary;
        document.getElementById('primaryColorText').value = primary;
        updatePrimaryColor(primary);

        document.getElementById('badgeColorPick').value = badge;
        document.getElementById('badgeColorText').value = badge;
        updateBadgeColor(badge);

        document.getElementById('labelColorPick').value = label;
        document.getElementById('labelColorText').value = label;
        updateLabelColor(label);

        document.getElementById('photoBorderColorPick').value = border;
        document.getElementById('photoBorderColorText').value = border;
        updatePhotoBorder(border);

        document.getElementById('backHeaderBgPick').value = backBg;
        document.getElementById('backHeaderBgText').value = backBg;

        document.getElementById('backHeaderTextColorPick').value = backText;
        document.getElementById('backHeaderTextColorText').value = backText;
    }

    // Header shape preview
    document.getElementById('headerShapeInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const img = document.getElementById('previewShapeImg');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                img.src = evt.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            img.style.display = 'none';
        }
    });

    // Bottom bar preview
    document.getElementById('bottomBarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const img = document.getElementById('previewBottomImg');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                img.src = evt.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            img.style.display = 'none';
        }
    });

    // Init values
    updatePrimaryColor(document.getElementById('primaryColorText').value);
    updateBadgeColor(document.getElementById('badgeColorText').value);
    updateLabelColor(document.getElementById('labelColorText').value);
    updatePhotoBorder(document.getElementById('photoBorderColorText').value);
</script>
@endsection
