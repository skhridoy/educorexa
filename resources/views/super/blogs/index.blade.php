@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Blogs</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-blog me-2" style="color:#4f46e5;"></i> Blogs</h2>
            <p class="edu-page-sub">Manage, edit, and publish blog posts and announcements.</p>
        </div>
        <a href="{{ route('super.blogs.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Add Blog Post
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        @forelse($blogs as $blog)
        <div class="col-md-6 col-lg-4">
            <div class="edu-panel h-100" style="display:flex; flex-direction:column; position:relative; {{ !$blog->status ? 'opacity:0.8;' : '' }}">
                <div class="edu-panel-bd" style="flex:1; padding: 24px;">
                    <div class="mb-3" style="position:relative; height: 180px; border-radius: 12px; overflow: hidden; background: #eef2ff;">
                        @if($blog->image)
                            <img src="{{ Str::startsWith($blog->image, ['http://','https://']) ? $blog->image : asset($blog->image) }}" 
                                 alt="blog image" 
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size: 2.5rem; background: #f1f5f9;">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                        <span style="position:absolute; top: 12px; left: 12px; background: rgba(79, 70, 229, 0.9); color: white; font-size: 11px; padding: 4px 10px; border-radius: 6px; font-weight: 700; text-transform: uppercase;">
                            {{ $blog->category->name ?? 'General' }}
                        </span>
                    </div>

                    <h5 style="font-weight:700; color:#1e293b; margin-top: 15px; margin-bottom:10px; font-size:1.1rem; line-height: 1.4;">
                        {{ Str::limit($blog->title, 55) }}
                    </h5>
                    
                    <div class="d-flex align-items-center justify-content-between mb-3 text-muted" style="font-size: 0.78rem;">
                        <span class="d-flex align-items-center gap-1">
                            <i class="fa-regular fa-user" style="color: #6366f1;"></i> By {{ $blog->author }}
                        </span>
                        <span class="d-flex align-items-center gap-1">
                            <i class="fa-regular fa-calendar" style="color: #6366f1;"></i> {{ $blog->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <p style="color:#64748b; font-size:0.85rem; line-height:1.6; margin-bottom:0;">
                        {{ Str::limit(strip_tags($blog->content), 120) }}
                    </p>
                </div>

                <div style="padding:16px 24px; background:#fafbff; border-top:1px solid #f8fafc; display:flex; justify-content:space-between; align-items:center; border-radius:0 0 16px 16px;">
                    <div class="d-flex gap-1">
                        <a href="{{ route('super.blogs.edit', $blog->id) }}" class="act-btn" title="Edit" style="color:#4f46e5; background:#eef2ff;">
                            <i data-feather="edit-2" style="width:14px; height:14px;"></i>
                        </a>
                        <form action="{{ route('super.blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog post?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="act-btn del" title="Delete" style="color:#ef4444; background:#fef2f2;">
                                <i data-feather="trash-2" style="width:14px; height:14px;"></i>
                            </button>
                        </form>
                    </div>

                    <form action="{{ route('super.blogs.toggle', $blog->id) }}" method="POST">
                        @csrf @method('PATCH')
                        @if($blog->status)
                            <button type="submit" class="badge-green" style="border:none; cursor:pointer;">
                                <i data-feather="check-circle" style="width:12px; height:12px; margin-right:4px;"></i> Published
                            </button>
                        @else
                            <button type="submit" class="badge-amber" style="border:none; cursor:pointer;">
                                <i data-feather="slash" style="width:12px; height:12px; margin-right:4px;"></i> Draft
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 edu-empty">
            <i class="fa-solid fa-blog" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
            <p>No blog posts found yet. Click "Add Blog Post" to publish one.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
