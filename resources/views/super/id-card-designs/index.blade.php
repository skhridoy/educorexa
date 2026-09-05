@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    /* ── Hero Banner ── */
    .hero-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        border-radius: 20px;
        padding: 28px 32px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(49, 46, 129, 0.2);
    }
    .hero-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(129, 140, 248, 0.25) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    /* ── Stat Counters ── */
    .stat-pill-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .stat-pill-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }
    .stat-pill-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    /* ── Design Card ── */
    .design-item-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }
    .design-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.09);
        border-color: #cbd5e1;
    }
    .design-item-card.is-inactive {
        opacity: 0.72;
    }

    /* ── Realistic Card Stage ── */
    .card-stage {
        background: linear-gradient(135deg, #f8fafc 0%, #eef2f6 100%);
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        border-bottom: 1px solid #eef2f6;
        min-height: 230px;
    }
    .stage-flip-ctrl {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        padding: 2px 8px;
        font-size: 11px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s;
    }
    .stage-flip-ctrl:hover {
        background: #4f46e5;
        color: #ffffff;
        border-color: #4f46e5;
    }

    /* ── Mini ID Card (CR80 Scale Ratio) ── */
    .mini-card-container {
        width: 130px;
        height: 195px;
        background: #ffffff;
        border-radius: 9px;
        box-shadow: 0 10px 24px rgba(0,0,0,0.12), 0 2px 6px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 0.5px solid #d1d5db;
        transition: transform 0.25s ease;
    }
    .mini-card-container:hover {
        transform: scale(1.04);
    }
    .mini-card-gloss {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0) 50%);
        pointer-events: none;
        z-index: 5;
    }

    /* Front side layers */
    .mini-card-header {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 62px;
        z-index: 1;
        overflow: hidden;
    }
    .mini-card-header img {
        width: 100%;
        height: 100%;
        object-fit: fill;
        display: block;
    }
    .mini-school-txt {
        position: absolute;
        top: 6px;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 7.5px;
        font-weight: 800;
        color: #ffffff;
        z-index: 2;
        letter-spacing: 0.3px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        padding: 0 4px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .mini-avatar-wrap {
        position: relative;
        z-index: 2;
        margin-top: 36px;
        width: 36px;
        height: 46px;
        border-radius: 5px;
        background: #f1f5f9;
        border: 2px solid;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 13px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .mini-card-name {
        margin-top: 5px;
        font-size: 8.5px;
        font-weight: 800;
        color: #1e293b;
        text-align: center;
        line-height: 1.1;
        max-width: 90%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .mini-card-badge {
        margin-top: 3px;
        font-size: 6.5px;
        color: #fff;
        padding: 1px 6px;
        border-radius: 6px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .mini-card-details {
        margin-top: 4px;
        width: 84%;
        display: flex;
        flex-direction: column;
        gap: 1.5px;
    }
    .mini-detail-row {
        display: flex;
        justify-content: space-between;
        font-size: 6px;
        line-height: 1.2;
    }
    .mini-detail-lbl {
        font-weight: 700;
    }
    .mini-detail-val {
        color: #475569;
        font-weight: 600;
    }
    .mini-bottom-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 5px;
        z-index: 2;
    }
    .mini-bottom-bar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Back side layers */
    .mini-back-view {
        display: none;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background: #ffffff;
        z-index: 3;
        flex-direction: column;
        align-items: center;
        padding: 14px 8px 8px 8px;
    }
    .mini-back-header {
        font-size: 6.5px;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 3px;
        text-align: center;
        width: 90%;
        letter-spacing: 0.2px;
    }
    .mini-back-terms {
        font-size: 5.5px;
        color: #64748b;
        line-height: 1.25;
        margin-top: 6px;
        text-align: center;
    }
    .mini-back-qr {
        margin-top: auto;
        margin-bottom: 10px;
        width: 32px;
        height: 32px;
        background: #ffffff;
        border: 0.5px solid #cbd5e1;
        padding: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    /* ── Color Swatch Row ── */
    .color-swatch-row {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .swatch-item {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #ffffff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.15);
        cursor: pointer;
        position: relative;
        transition: transform 0.15s;
    }
    .swatch-item:hover {
        transform: scale(1.2);
        z-index: 2;
    }

    /* ── Filter / Search Bar ── */
    .filter-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 12px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .search-wrap {
        position: relative;
        min-width: 260px;
    }
    .search-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }
    .search-wrap input {
        padding: 8px 12px 8px 36px !important;
        font-size: 13px !important;
        border-radius: 10px !important;
        background: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
    }
    .search-wrap input:focus {
        background: #fff !important;
        border-color: #6366f1 !important;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">ID Card Designs</li>
    </ul>

    {{-- ── Hero Banner ── --}}
    <div class="hero-banner">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="hero-chip">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span>Template Design Studio</span>
                </div>
                <h2 class="fw-bold mb-1" style="font-family:'Outfit',sans-serif; font-size:1.65rem;">
                    Student ID Card Templates
                </h2>
                <p class="text-white-50 mb-0 small" style="max-width: 540px;">
                    Create, upload header shapes, and configure vibrant color palettes. School admins can pick from these live templates to generate and download student ID cards.
                </p>
            </div>
            <div>
                <a href="{{ route('super.id-card-designs.create') }}" class="btn btn-light px-4 py-2.5 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="color:#312e81;">
                    <i class="fa-solid fa-circle-plus text-primary"></i>
                    <span>Add New Template</span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert" style="background:#f0fdf4; border-left:4px solid #22c55e !important;">
            <div class="d-flex align-items-center gap-2 text-success fw-bold">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ── Stats Counter Row ── --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="stat-pill-card">
                <div class="stat-pill-icon bg-indigo-subtle text-primary" style="background:#eef2ff; color:#4f46e5;">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">{{ $designs->count() }}</h4>
                    <span class="text-muted small">Total Templates</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-pill-card">
                <div class="stat-pill-icon" style="background:#dcfce7; color:#16a34a;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">{{ $designs->where('is_active', true)->count() }}</h4>
                    <span class="text-muted small">Active in Schools</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-pill-card">
                <div class="stat-pill-icon" style="background:#fef3c7; color:#d97706;">
                    <i class="fa-solid fa-shapes"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">{{ $designs->whereNotNull('header_shape')->count() }}</h4>
                    <span class="text-muted small">Custom Shapes</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-pill-card">
                <div class="stat-pill-icon" style="background:#f1f5f9; color:#64748b;">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">5 Color Studio</h4>
                    <span class="text-muted small">Dynamic Palettes</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Search & Filter Bar ── --}}
    <div class="filter-card">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="templateSearchInput" class="form-control" placeholder="Search by template name or slug...">
            </div>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary active filter-btn" data-status="all">All ({{ $designs->count() }})</button>
                <button type="button" class="btn btn-outline-secondary filter-btn" data-status="active">Active ({{ $designs->where('is_active', true)->count() }})</button>
                <button type="button" class="btn btn-outline-secondary filter-btn" data-status="inactive">Inactive ({{ $designs->where('is_active', false)->count() }})</button>
            </div>
        </div>
        <div class="text-muted small">
            Tip: Click <strong>Flip</strong> on any card to inspect Front / Back sides.
        </div>
    </div>

    {{-- ── Design Cards Grid ── --}}
    <div class="row g-4" id="designsGrid">
        @forelse($designs as $design)
        <div class="col-sm-6 col-lg-4 col-xl-3 template-item-col" 
             data-name="{{ strtolower($design->name) }}" 
             data-slug="{{ strtolower($design->slug) }}" 
             data-status="{{ $design->is_active ? 'active' : 'inactive' }}">
            <div class="design-item-card h-100 {{ !$design->is_active ? 'is-inactive' : '' }}">
                
                {{-- Card Visual Stage --}}
                <div class="card-stage">
                    <button type="button" class="stage-flip-ctrl" onclick="toggleMiniCardFlip({{ $design->id }})" title="Flip to Back / Front">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span id="flipLabel{{ $design->id }}">Back</span>
                    </button>

                    <div class="mini-card-container" id="miniCardContainer{{ $design->id }}">
                        <div class="mini-card-gloss"></div>

                        {{-- FRONT VIEW --}}
                        <div class="mini-card-header" style="background-color: {{ $design->primary_color }};">
                            @if($design->header_shape && file_exists(public_path($design->header_shape)))
                                <img src="{{ asset($design->header_shape) }}" alt="Shape">
                            @endif
                        </div>
                        <div class="mini-school-txt">IDEAL MODEL SCHOOL</div>

                        <div class="mini-avatar-wrap" style="border-color: {{ $design->photo_border_color }};">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <div class="mini-card-name">Arif Hossain</div>
                        <div class="mini-card-badge" style="background: {{ $design->badge_color }};">STUDENT</div>

                        <div class="mini-card-details">
                            <div class="mini-detail-row">
                                <span class="mini-detail-lbl" style="color: {{ $design->label_color }};">Class</span>
                                <span class="mini-detail-val">: Class 8</span>
                            </div>
                            <div class="mini-detail-row">
                                <span class="mini-detail-lbl" style="color: {{ $design->label_color }};">Roll</span>
                                <span class="mini-detail-val">: 12</span>
                            </div>
                            <div class="mini-detail-row">
                                <span class="mini-detail-lbl" style="color: {{ $design->label_color }};">Blood</span>
                                <span class="mini-detail-val">: B+</span>
                            </div>
                        </div>

                        @if($design->gradient_bar && file_exists(public_path($design->gradient_bar)))
                            <div class="mini-bottom-bar">
                                <img src="{{ asset($design->gradient_bar) }}" alt="Bar">
                            </div>
                        @else
                            <div class="mini-bottom-bar" style="background: {{ $design->primary_color }};"></div>
                        @endif

                        {{-- BACK VIEW --}}
                        <div class="mini-back-view" id="miniBackView{{ $design->id }}">
                            <div class="mini-bottom-bar" style="top:0; height:5px; background: {{ $design->primary_color }};"></div>
                            <div class="mini-back-header" style="background: {{ $design->back_header_bg }}; color: {{ $design->back_header_text }}; margin-top:2px;">
                                TERMS & CONDITIONS
                            </div>
                            <div class="mini-back-terms">
                                • Property of School<br>
                                • Return if found<br>
                                • Session: 2026
                            </div>
                            <div class="mini-back-qr" style="color: {{ $design->primary_color }};">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>
                            <div class="mini-bottom-bar" style="background: {{ $design->primary_color }};"></div>
                        </div>
                    </div>
                </div>

                {{-- Template Metadata --}}
                <div class="p-3.5 flex-grow-1" style="padding: 16px;">
                    <div class="d-flex justify-content-between align-items-start mb-1.5">
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ $design->name }}</h6>
                        @if($design->is_active)
                            <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill" style="font-size:10px;">
                                <i class="fa-solid fa-circle-check me-1"></i>Active
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary fw-bold px-2 py-1 rounded-pill" style="font-size:10px;">
                                Inactive
                            </span>
                        @endif
                    </div>

                    <div class="text-muted small mb-2.5 font-monospace" style="font-size: 11px;">
                        <i class="fa-solid fa-link me-1 opacity-50"></i>{{ $design->slug }}
                    </div>

                    {{-- Palette Swatches --}}
                    <div class="mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="text-muted" style="font-size: 11px; font-weight:600;">Color Palette:</span>
                            <span class="font-monospace text-muted" style="font-size: 10px;">{{ $design->primary_color }}</span>
                        </div>
                        <div class="color-swatch-row">
                            <span class="swatch-item" style="background: {{ $design->primary_color }};" title="Primary: {{ $design->primary_color }}" data-bs-toggle="tooltip"></span>
                            <span class="swatch-item" style="background: {{ $design->badge_color }};" title="Badge: {{ $design->badge_color }}" data-bs-toggle="tooltip"></span>
                            <span class="swatch-item" style="background: {{ $design->label_color }};" title="Label: {{ $design->label_color }}" data-bs-toggle="tooltip"></span>
                            <span class="swatch-item" style="background: {{ $design->photo_border_color }};" title="Photo Border: {{ $design->photo_border_color }}" data-bs-toggle="tooltip"></span>
                            <span class="swatch-item" style="background: {{ $design->back_header_bg }};" title="Back Header: {{ $design->back_header_bg }}" data-bs-toggle="tooltip"></span>
                        </div>
                    </div>

                    {{-- Asset Status Badges --}}
                    <div class="d-flex align-items-center gap-1.5 flex-wrap mt-2.5 pt-2 border-top">
                        @if($design->header_shape)
                            <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 10px;">
                                <i class="fa-solid fa-shapes text-primary me-1"></i>Shape File
                            </span>
                        @else
                            <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 10px;">
                                Color Fill
                            </span>
                        @endif

                        @if($design->gradient_bar)
                            <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 10px;">
                                <i class="fa-solid fa-grip-lines text-indigo me-1"></i>Bottom Bar
                            </span>
                        @endif

                        <span class="badge bg-light text-secondary border ms-auto" style="font-size: 10px;">
                            Order: {{ $design->sort_order }}
                        </span>
                    </div>
                </div>

                {{-- Action Bar --}}
                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-1">
                        <a href="{{ route('super.id-card-designs.edit', $design->id) }}" class="btn btn-sm btn-outline-primary px-2.5 py-1.5 rounded-3 fw-semibold d-inline-flex align-items-center gap-1" title="Edit Template">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i>
                            <span style="font-size: 11.5px;">Edit</span>
                        </a>

                        <form action="{{ route('super.id-card-designs.destroy', $design->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete template \'{{ $design->name }}\'? This will remove the shape files and remove it from school ID card selectors.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1.5 rounded-3" title="Delete Template">
                                <i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
                            </button>
                        </form>
                    </div>

                    <form action="{{ route('super.id-card-designs.toggle', $design->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if($design->is_active)
                            <button type="submit" class="btn btn-sm btn-success px-2.5 py-1.5 rounded-pill fw-bold text-white d-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 11px;" title="Click to Deactivate">
                                <i class="fa-solid fa-toggle-on"></i>
                                <span>Active</span>
                            </button>
                        @else
                            <button type="submit" class="btn btn-sm btn-secondary px-2.5 py-1.5 rounded-pill fw-bold text-white d-inline-flex align-items-center gap-1" style="font-size: 11px;" title="Click to Activate">
                                <i class="fa-solid fa-toggle-off"></i>
                                <span>Inactive</span>
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="edu-empty text-center py-5">
                <i class="fa-solid fa-id-card fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold text-dark">No Templates Found</h5>
                <p class="text-muted">Get started by creating your first ID card design with custom shape & color scheme.</p>
                <a href="{{ route('super.id-card-designs.create') }}" class="btn-edu btn-edu-primary mt-2">
                    <i class="fa-solid fa-plus me-1"></i> Add First Template
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

@section('customJS')
<script>
    // Flip mini card preview
    function toggleMiniCardFlip(id) {
        const backView = document.getElementById('miniBackView' + id);
        const label = document.getElementById('flipLabel' + id);
        if (backView.style.display === 'flex') {
            backView.style.display = 'none';
            label.textContent = 'Back';
        } else {
            backView.style.display = 'flex';
            label.textContent = 'Front';
        }
    }

    // Search and filter
    $(document).ready(function() {
        // Init bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        function applyFilter() {
            const query = $('#templateSearchInput').val().toLowerCase().trim();
            const status = $('.filter-btn.active').data('status');

            $('.template-item-col').each(function() {
                const name = $(this).data('name') || '';
                const slug = $(this).data('slug') || '';
                const itemStatus = $(this).data('status');

                const matchesQuery = !query || name.includes(query) || slug.includes(query);
                const matchesStatus = (status === 'all') || (itemStatus === status);

                if (matchesQuery && matchesStatus) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        $('#templateSearchInput').on('keyup', applyFilter);

        $('.filter-btn').on('click', function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            applyFilter();
        });
    });
</script>
@endsection
