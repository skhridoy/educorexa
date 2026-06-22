@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.blogs.index') }}">Blogs</a></li>
        <li><span>/</span></li>
        <li class="active">Categories</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-list me-2" style="color:#4f46e5;"></i> Blog Categories</h2>
            <p class="edu-page-sub">Create, edit, and organize categories for your blog posts.</p>
        </div>
        <a href="{{ route('super.blog-categories.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Add Category
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="edu-panel p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="width: 100%;">
                <thead class="bg-light">
                    <tr>
                        <th style="padding: 18px 24px; font-weight:700; color:#475569; font-size:13px; text-transform:uppercase;">Name</th>
                        <th style="padding: 18px 24px; font-weight:700; color:#475569; font-size:13px; text-transform:uppercase;">Slug</th>
                        <th style="padding: 18px 24px; font-weight:700; color:#475569; font-size:13px; text-transform:uppercase;">Status</th>
                        <th style="padding: 18px 24px; font-weight:700; color:#475569; font-size:13px; text-transform:uppercase; text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 18px 24px;">
                            <span class="fw-bold text-dark" style="font-size:14px;">{{ $category->name }}</span>
                        </td>
                        <td style="padding: 18px 24px; color:#64748b; font-size:13px;">
                            <code>{{ $category->slug }}</code>
                        </td>
                        <td style="padding: 18px 24px;">
                            <form action="{{ route('super.blog-categories.toggle', $category->id) }}" method="POST">
                                @csrf @method('PATCH')
                                @if($category->status)
                                    <button type="submit" class="badge-green" style="border:none; cursor:pointer;">
                                        <i data-feather="check-circle" style="width:12px; height:12px; margin-right:4px;"></i> Active
                                    </button>
                                @else
                                    <button type="submit" class="badge-amber" style="border:none; cursor:pointer;">
                                        <i data-feather="slash" style="width:12px; height:12px; margin-right:4px;"></i> Inactive
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td style="padding: 18px 24px; text-align:right;">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('super.blog-categories.edit', $category->id) }}" class="act-btn" title="Edit" style="color:#4f46e5; background:#eef2ff;">
                                    <i data-feather="edit-2" style="width:14px; height:14px;"></i>
                                </a>
                                <form action="{{ route('super.blog-categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category? Blogs under this category will be marked uncategorized.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="act-btn del" title="Delete" style="color:#ef4444; background:#fef2f2;">
                                        <i data-feather="trash-2" style="width:14px; height:14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="edu-empty">
                                <i class="fa-solid fa-list" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                                <p>No categories found yet. Click "Add Category" to create one.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
