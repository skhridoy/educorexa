@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.blogs.index') }}">Blogs</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.blog-categories.index') }}">Categories</a></li>
        <li><span>/</span></li>
        <li class="active">Edit Category</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-pen-to-square me-2" style="color:#4f46e5;"></i> Edit Blog Category</h2>
            <p class="edu-page-sub">Update category name or publication status.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">Category Details</h6>
        </div>
        <div class="edu-panel-bd">
            <form action="{{ route('super.blog-categories.update', $blogCategory->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="edu-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="categoryName" class="form-control edu-input" placeholder="Enter category name" value="{{ old('name', $blogCategory->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="edu-label">Slug <span class="text-muted" style="font-size:12px;">(Auto-generated, editable)</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:#f1f5f9; border-color:#e2e8f0; color:#64748b; font-size:13px;">/category/</span>
                            <input type="text" name="slug" id="categorySlug" class="form-control edu-input" placeholder="auto-generated-slug" value="{{ old('slug', $blogCategory->slug) }}">
                        </div>
                        <small class="text-muted" style="font-size:11px;">Leave empty to auto-generate from name.</small>
                    </div>

                    <div class="col-12 d-flex align-items-center">
                        <div class="form-check form-switch" style="display:flex; align-items:center; gap:10px;">
                            <input class="form-check-input" type="checkbox" name="status" id="isStatus" style="width:40px; height:20px; cursor:pointer;" {{ $blogCategory->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="isStatus" style="font-weight:700; color:#1e293b; cursor:pointer;">Active</label>
                        </div>
                    </div>

                    <div class="col-12 edu-divider"></div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('super.blog-categories.index') }}" class="btn-edu btn-edu-light" style="padding:12px 30px;">Cancel</a>
                        <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 40px;">
                            <i data-feather="check-circle" style="width:16px; margin-right:5px;"></i> Update Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJS')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('categoryName');
        const slugInput = document.getElementById('categorySlug');
        let manualSlug = slugInput.value.length > 0;

        slugInput.addEventListener('input', function() {
            manualSlug = this.value.length > 0;
        });

        nameInput.addEventListener('input', function() {
            if (!manualSlug) {
                let slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s\-\u0980-\u09FF]/g, '')
                    .replace(/[\s]+/g, '-')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
                slugInput.value = slug;
            }
        });
    });
</script>
@endsection
