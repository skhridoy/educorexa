@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-sitemap me-2"></i> {{ __('Sub-Categories') }}</h1>
                <p class="page-subtitle">{{ __('Manage groups, departments, and streams under main school categories.') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Add Sub-Category Form Column --}}
            <div class="col-lg-4">
                <div class="form-card">
                    <h5 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-plus me-2"></i> {{ __('Add Sub-Category') }}
                    </h5>
                    <form action="{{ route('sub-categories.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ __('Select Main Category') }} <span class="text-danger">*</span></label>
                            <select name="school_category_id" class="form-select" required>
                                <option value="">{{ __('Choose Category...') }}</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ __('Sub-Category Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Science, Arts, Commerce" required>
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold">
                            <i class="fa-solid fa-check me-1"></i> {{ __('Save Sub-Category') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Sub-Category List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header d-flex align-items-center justify-content-between p-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-indigo-600"></i> {{ __('Sub-Categories List') }}</h5>
                        <span class="badge bg-light text-muted border px-3 py-1" style="border-radius:10px;">
                            {{ count($subCategories) }} {{ __('Items') }}
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3"># {{ __('ID') }}</th>
                                    <th class="py-3 px-3">{{ __('Sub-Category') }}</th>
                                    <th class="py-3 px-3 text-center">{{ __('Main Category') }}</th>
                                    <th class="py-3 px-3 text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subCategories as $sub)
                                <tr>
                                    <td class="px-3 fw-bold text-muted" style="font-size:0.82rem;">#{{ $sub->id }}</td>
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-weight:700;font-size:0.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                {{ strtoupper(substr($sub->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size:0.88rem;">{{ $sub->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge-completed">
                                            <i class="fa-solid fa-layer-group me-1"></i>{{ $sub->mainCategory->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-3 text-end">
                                        <button class="btn btn-action btn-sm btn-outline-danger" title="{{ __('Delete') }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                        {{ __('No Sub-categories found.') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection