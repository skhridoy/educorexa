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
        <li class="active">Add Blog Post</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-plus-circle me-2" style="color:#4f46e5;"></i> Add Blog Post</h2>
            <p class="edu-page-sub">Create and publish educational content, tips, or news.</p>
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
            <h6 class="edu-panel-ttl">Blog Content</h6>
        </div>
        <div class="edu-panel-bd">
            <form action="{{ route('super.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-8">
                        <label class="edu-label">Blog Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control edu-input" placeholder="Enter post title" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="edu-label">Category <span class="text-danger">*</span></label>
                        <select name="blog_category_id" class="form-control edu-input" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="edu-label">Author Name</label>
                        <input type="text" name="author" class="form-control edu-input" placeholder="e.g. Admin or Teacher Name" value="{{ old('author', 'Admin') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="edu-label">Blog Image</label>
                        <input type="file" name="image" class="form-control edu-input" accept="image/*">
                        <p style="font-size:0.75rem; color:#94a3b8; margin-top:8px;">Recommended size: 800x500px</p>
                    </div>

                    <div class="col-12">
                        <label class="edu-label">Blog Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control edu-input" rows="8" placeholder="Write full blog post contents here..." required>{{ old('content') }}</textarea>
                    </div>

                    <div class="col-12 d-flex align-items-center">
                        <div class="form-check form-switch" style="display:flex; align-items:center; gap:10px;">
                            <input class="form-check-input" type="checkbox" name="status" id="isStatus" style="width:40px; height:20px; cursor:pointer;" checked>
                            <label class="form-check-label" for="isStatus" style="font-weight:700; color:#1e293b; cursor:pointer;">Publish Immediately</label>
                        </div>
                    </div>

                    <div class="col-12 edu-divider"></div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('super.blogs.index') }}" class="btn-edu btn-edu-light" style="padding:12px 30px;">Cancel</a>
                        <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 40px;">
                            <i data-feather="check-circle" style="width:16px; margin-right:5px;"></i> Save Blog Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
