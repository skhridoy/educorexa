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
        background-color: {{ $design->primary_color }};
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
        border: 3px solid {{ $design->photo_border_color }};
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
        background: {{ $design->badge_color }};
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
        color: {{ $design->label_color }};
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
        background: {{ $design->primary_color }};
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
    .current-asset-thumb {
        width: 100px;
        height: 40px;
        object-fit: contain;
        background: #e2e8f0;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        padding: 2px;
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
        <li class="active">Edit Design: {{ $design->name }}</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-pen-to-square me-2" style="color:#4f46e5;"></i> Edit ID Card Design</h2>
            <p class="edu-page-sub">Update custom shape, colors, and configuration for "{{ $design->name }}".</p>
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
            <form action="{{ route('super.id-card-designs.update', $design->id) }}" method="POST" enctype="multipart/form-data" id="designForm">
                @csrf
                @method('PUT')
                
                {{-- Basic Details --}}
                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd">
                        <h6 class="edu-panel-ttl"><i class="fa-solid fa-tag me-2 text-primary"></i> Basic Information</h6>
                    </div>
                    <div class="edu-panel-bd">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="edu-label">Design Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="designName" class="form-control edu-input" value="{{ old('name', $design->name) }}" required>
                            </div>
                            <div class="col-md-5">
                                <label class="edu-label">Slug</label>
                                <input type="text" class="form-control edu-input" value="{{ $design->slug }}" disabled>
                                <small class="text-muted">Slug cannot be changed once created</small>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control edu-input" value="{{ old('sort_order', $design->sort_order) }}">
                            </div>
                            <div class="col-md-6 d-flex align-items-center pt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $design->is_active) ? 'checked' : '' }}>
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
                                @if($design->header_shape && file_exists(public_path($design->header_shape)))
                                    <div class="d-flex align-items-center gap-3 mb-2 p-2 bg-light rounded">
                                        <img src="{{ asset($design->header_shape) }}" class="current-asset-thumb" alt="Current Header Shape">
                                        <div class="small">
                                            <strong>Current Shape Uploaded</strong><br>
                                            <span class="text-muted">{{ $design->header_shape }}</span>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="header_shape" id="headerShapeInput" class="form-control edu-input" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">Upload a new header shape to replace the existing one (leave empty to keep current).</small>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Bottom Gradient Bar (Optional)</label>
                                @if($design->gradient_bar && file_exists(public_path($design->gradient_bar)))
                                    <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-light rounded">
                                        <img src="{{ asset($design->gradient_bar) }}" class="current-asset-thumb" alt="Current Bar">
                                        <span class="small text-muted">Uploaded</span>
                                    </div>
                                @endif
                                <input type="file" name="gradient_bar" id="bottomBarInput" class="form-control edu-input" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">Leave empty to keep current</small>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Pattern Overlay (Optional)</label>
                                @if($design->pattern && file_exists(public_path($design->pattern)))
                                    <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-light rounded">
                                        <img src="{{ asset($design->pattern) }}" class="current-asset-thumb" alt="Current Pattern">
                                        <span class="small text-muted">Uploaded</span>
                                    </div>
                                @endif
                                <input type="file" name="pattern" class="form-control edu-input" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">Leave empty to keep current</small>
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
                                    <input type="color" id="primaryColorPick" class="color-picker-input" value="{{ old('primary_color', $design->primary_color) }}">
                                    <input type="text" name="primary_color" id="primaryColorText" class="form-control edu-input" value="{{ old('primary_color', $design->primary_color) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Student Badge Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="badgeColorPick" class="color-picker-input" value="{{ old('badge_color', $design->badge_color) }}">
                                    <input type="text" name="badge_color" id="badgeColorText" class="form-control edu-input" value="{{ old('badge_color', $design->badge_color) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Field Label Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="labelColorPick" class="color-picker-input" value="{{ old('label_color', $design->label_color) }}">
                                    <input type="text" name="label_color" id="labelColorText" class="form-control edu-input" value="{{ old('label_color', $design->label_color) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Photo Border Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="photoBorderColorPick" class="color-picker-input" value="{{ old('photo_border_color', $design->photo_border_color) }}">
                                    <input type="text" name="photo_border_color" id="photoBorderColorText" class="form-control edu-input" value="{{ old('photo_border_color', $design->photo_border_color) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Back Header Background <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="backHeaderBgPick" class="color-picker-input" value="{{ old('back_header_bg', $design->back_header_bg) }}">
                                    <input type="text" name="back_header_bg" id="backHeaderBgText" class="form-control edu-input" value="{{ old('back_header_bg', $design->back_header_bg) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Back Header Text Color <span class="text-danger">*</span></label>
                                <div class="color-input-group">
                                    <input type="color" id="backHeaderTextColorPick" class="color-picker-input" value="{{ old('back_header_text', $design->back_header_text) }}">
                                    <input type="text" name="back_header_text" id="backHeaderTextColorText" class="form-control edu-input" value="{{ old('back_header_text', $design->back_header_text) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-edu btn-edu-primary" style="padding: 12px 36px;">
                        <i class="fa-solid fa-check me-1"></i> Update Design
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
                        <div class="sim-header" id="previewSimHeader" style="background-color: {{ $design->primary_color }};">
                            <img id="previewShapeImg" 
                                 src="{{ $design->header_shape && file_exists(public_path($design->header_shape)) ? asset($design->header_shape) : '' }}" 
                                 style="{{ $design->header_shape && file_exists(public_path($design->header_shape)) ? '' : 'display:none;' }}" 
                                 alt="Shape">
                        </div>
                        <div class="sim-school-text">IDEAL MODEL SCHOOL</div>
                        
                        <div class="sim-photo-wrap" id="previewPhotoWrap" style="border-color: {{ $design->photo_border_color }};">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        
                        <div class="sim-name" id="previewStudentName">ARIF HOSSAIN</div>
                        <div class="sim-badge" id="previewBadge" style="background-color: {{ $design->badge_color }};">STUDENT</div>

                        <table class="sim-info-table">
                            <tr>
                                <td class="sim-info-label" id="previewLbl1" style="color: {{ $design->label_color }};">Class</td>
                                <td class="sim-info-val">: Class 8</td>
                            </tr>
                            <tr>
                                <td class="sim-info-label" id="previewLbl2" style="color: {{ $design->label_color }};">Roll No</td>
                                <td class="sim-info-val">: 12</td>
                            </tr>
                            <tr>
                                <td class="sim-info-label" id="previewLbl3" style="color: {{ $design->label_color }};">Blood Grp</td>
                                <td class="sim-info-val">: B+</td>
                            </tr>
                        </table>

                        <div class="sim-bottom-bar" id="previewBottomBar" style="background-color: {{ $design->primary_color }};">
                            <img id="previewBottomImg" 
                                 src="{{ $design->gradient_bar && file_exists(public_path($design->gradient_bar)) ? asset($design->gradient_bar) : '' }}" 
                                 style="{{ $design->gradient_bar && file_exists(public_path($design->gradient_bar)) ? '' : 'display:none;' }}" 
                                 alt="Bar">
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
        }
    });
</script>
@endsection
