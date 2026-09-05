@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    .design-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
    }
    .design-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        border-color: #cbd5e1;
    }
    .design-card.inactive {
        opacity: 0.65;
    }
    .design-preview-box {
        position: relative;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 180px;
    }
    .mini-id-card {
        width: 140px;
        height: 200px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.12);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .mini-card-header {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 60px;
        z-index: 1;
    }
    .mini-card-header img {
        width: 100%;
        height: 100%;
        object-fit: fill;
    }
    .mini-avatar-box {
        position: relative;
        z-index: 2;
        margin-top: 36px;
        width: 38px;
        height: 48px;
        border-radius: 6px;
        background: #e2e8f0;
        border: 2px solid;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 14px;
    }
    .mini-card-name {
        margin-top: 6px;
        font-size: 9px;
        font-weight: 700;
        color: #1e293b;
        text-align: center;
        line-height: 1.1;
    }
    .mini-card-badge {
        margin-top: 4px;
        font-size: 7px;
        color: #fff;
        padding: 1px 6px;
        border-radius: 8px;
        font-weight: 600;
    }
    .mini-bottom-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 6px;
        z-index: 2;
    }
    .color-swatch-group {
        display: flex;
        gap: 6px;
        align-items: center;
    }
    .color-dot {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1.5px solid #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.18);
        display: inline-block;
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

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-id-card me-2" style="color:#4f46e5;"></i> ID Card Designs</h2>
            <p class="edu-page-sub">Create & upload custom header shapes, gradients, and color palettes for school student ID cards.</p>
        </div>
        <a href="{{ route('super.id-card-designs.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus me-1"></i> Add New Design
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($designs as $design)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="design-card h-100 {{ !$design->is_active ? 'inactive' : '' }}">
                {{-- Card Visual Preview --}}
                <div class="design-preview-box">
                    <div class="mini-id-card">
                        <div class="mini-card-header" style="background-color: {{ $design->primary_color }};">
                            @if($design->header_shape && file_exists(public_path($design->header_shape)))
                                <img src="{{ asset($design->header_shape) }}" alt="Shape">
                            @endif
                        </div>
                        <div class="mini-avatar-box" style="border-color: {{ $design->photo_border_color }};">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="mini-card-name">Student Name</div>
                        <div class="mini-card-badge" style="background: {{ $design->badge_color }};">STUDENT</div>
                        
                        @if($design->gradient_bar && file_exists(public_path($design->gradient_bar)))
                            <img src="{{ asset($design->gradient_bar) }}" class="mini-bottom-bar" style="height:6px; object-fit:cover;" alt="Bar">
                        @else
                            <div class="mini-bottom-bar" style="background: {{ $design->primary_color }};"></div>
                        @endif
                    </div>
                </div>

                {{-- Details --}}
                <div class="p-3 flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 fw-bold text-dark">{{ $design->name }}</h6>
                        @if($design->is_active)
                            <span class="badge bg-success" style="font-size:11px;">Active</span>
                        @else
                            <span class="badge bg-secondary" style="font-size:11px;">Inactive</span>
                        @endif
                    </div>
                    <div class="text-muted small mb-3">
                        <code>{{ $design->slug }}</code>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted small d-block mb-1">Color Palette:</span>
                        <div class="color-swatch-group">
                            <span class="color-dot" style="background-color: {{ $design->primary_color }};" title="Primary: {{ $design->primary_color }}"></span>
                            <span class="color-dot" style="background-color: {{ $design->badge_color }};" title="Badge: {{ $design->badge_color }}"></span>
                            <span class="color-dot" style="background-color: {{ $design->label_color }};" title="Label: {{ $design->label_color }}"></span>
                            <span class="color-dot" style="background-color: {{ $design->photo_border_color }};" title="Border: {{ $design->photo_border_color }}"></span>
                            <span class="color-dot" style="background-color: {{ $design->back_header_bg }};" title="Back Header: {{ $design->back_header_bg }}"></span>
                        </div>
                    </div>

                    <div class="small text-muted mt-2">
                        <span>Shape: </span>
                        @if($design->header_shape)
                            <span class="text-success"><i class="fa-solid fa-check"></i> Uploaded</span>
                        @else
                            <span class="text-muted">Color fill only</span>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-2">
                        <a href="{{ route('super.id-card-designs.edit', $design->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Design">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('super.id-card-designs.destroy', $design->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this design?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Design">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>

                    <form action="{{ route('super.id-card-designs.toggle', $design->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if($design->is_active)
                            <button type="submit" class="btn btn-sm btn-outline-success" title="Click to Deactivate">
                                <i class="fa-solid fa-toggle-on"></i> Active
                            </button>
                        @else
                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Click to Activate">
                                <i class="fa-solid fa-toggle-off"></i> Inactive
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
                <h5>No ID Card Designs Found</h5>
                <p class="text-muted">Click the button below to add your first dynamic ID card design with custom shape.</p>
                <a href="{{ route('super.id-card-designs.create') }}" class="btn-edu btn-edu-primary mt-2">
                    <i class="fa-solid fa-plus me-1"></i> Add First Design
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
