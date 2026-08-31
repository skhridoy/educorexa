@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ── Subject Page Header & Layout ── */
        .subject-card-header {
            display: block !important;
            padding: 16px 20px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            background: #ffffff;
        }

        .subject-header-top {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
            margin-bottom: 12px !important;
            width: 100% !important;
        }

        .subject-filter-box {
            display: block !important;
            width: 100% !important;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 12px;
        }

        .filter-search-wrap {
            position: relative;
        }

        .filter-search-wrap .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6366f1;
            font-size: 0.85rem;
            pointer-events: none;
            z-index: 4;
        }

        .filter-input-search {
            height: 38px !important;
            padding-top: 6px !important;
            padding-bottom: 6px !important;
            padding-left: 34px !important;
            padding-right: 30px !important;
            line-height: 1.5 !important;
            font-size: 0.85rem !important;
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            background-color: #ffffff !important;
            color: #1e293b !important;
            box-shadow: none !important;
        }

        .filter-select-type {
            height: 38px !important;
            padding-top: 6px !important;
            padding-bottom: 6px !important;
            padding-left: 12px !important;
            padding-right: 34px !important;
            line-height: 1.5 !important;
            font-size: 0.85rem !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            background-color: #ffffff !important;
            color: #1e293b !important;
            cursor: pointer;
            box-shadow: none !important;
        }

        .filter-select-type option {
            color: #1e293b !important;
            background-color: #ffffff !important;
            padding: 6px 10px !important;
        }

        .filter-input-search:focus,
        .filter-select-type:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
            background-color: #ffffff !important;
            color: #1e293b !important;
        }

        .clear-search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            font-size: 14px;
            z-index: 5;
            padding: 0;
        }

        .clear-search-btn:hover {
            color: #ef4444;
        }

        .btn-filter-submit {
            height: 38px !important;
            padding: 0 16px !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
            color: #ffffff !important;
            border: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25) !important;
            transition: all 0.2s ease;
        }

        .btn-filter-submit:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            color: #ffffff !important;
        }

        .btn-filter-reset {
            height: 38px !important;
            width: 38px !important;
            min-width: 38px !important;
            padding: 0 !important;
            font-size: 0.85rem !important;
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #ef4444 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }

        .btn-filter-reset:hover {
            background: #fee2e2 !important;
            border-color: #ef4444 !important;
            color: #dc2626 !important;
        }

        /* ── Professional Data Table Styles ── */
        .subjects-pro-table {
            width: 100%;
            margin-bottom: 0;
        }

        .subjects-pro-table th {
            font-size: 0.78rem !important;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            font-weight: 700 !important;
            color: #475569 !important;
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 12px 16px !important;
            white-space: nowrap;
        }

        .subjects-pro-table td {
            padding: 12px 16px !important;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .subjects-pro-table tbody tr:hover {
            background-color: rgba(248, 250, 252, 0.8);
        }

        /* ── Clean Action Buttons (Icon Only) ── */
        .btn-icon-custom {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
        }

        .btn-action-edit {
            background: rgba(245, 158, 11, 0.12);
            color: #d97706 !important;
        }

        .btn-action-edit:hover {
            background: #f59e0b;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(245, 158, 11, 0.3);
        }

        .btn-action-delete {
            background: rgba(239, 68, 68, 0.12);
            color: #dc2626 !important;
        }

        .btn-action-delete:hover {
            background: #ef4444;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(239, 68, 68, 0.3);
        }

        /* ── Dark Mode Support ── */
        [data-bs-theme="dark"] .subject-card-header,
        body.dark-mode .subject-card-header {
            background: #0c1427 !important;
            border-color: #1e293b !important;
        }

        [data-bs-theme="dark"] .subject-filter-box,
        body.dark-mode .subject-filter-box {
            background: #0f172a;
            border-color: #1e293b;
        }

        [data-bs-theme="dark"] .filter-input-search,
        body.dark-mode .filter-input-search {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .filter-select-type,
        body.dark-mode .filter-select-type {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .filter-select-type option,
        body.dark-mode .filter-select-type option {
            color: #f8fafc !important;
            background-color: #1e293b !important;
        }

        [data-bs-theme="dark"] .subjects-pro-table th,
        body.dark-mode .subjects-pro-table th {
            background: #0f172a !important;
            color: #94a3b8 !important;
            border-color: #1e293b !important;
        }

        [data-bs-theme="dark"] .subjects-pro-table td,
        body.dark-mode .subjects-pro-table td {
            border-color: #1e293b !important;
        }

        [data-bs-theme="dark"] .subjects-pro-table tbody tr:hover,
        body.dark-mode .subjects-pro-table tbody tr:hover {
            background-color: rgba(30, 41, 59, 0.5) !important;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-3 mb-md-4">
            <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-title"><i class="fa-solid fa-book-open me-2"></i> {{ __('Subjects Management') }}</h1>
                    <p class="page-subtitle mb-0">{{ __('Create and manage institutional subjects, course codes, and types.') }}</p>
                </div>
                <div class="d-lg-none">
                    <a href="#createSubjectForm" class="btn btn-sm btn-light fw-bold shadow-sm">
                        <i class="fa-solid fa-plus me-1 text-primary"></i> {{ __('New Subject') }}
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-3 mb-md-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3 g-lg-4">
            {{-- Form Column --}}
            <div class="col-12 col-lg-4 order-2 order-lg-1" id="createSubjectForm">
                <div class="form-card mb-0">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="mb-0 fw-bold text-primary d-flex align-items-center gap-2" style="font-size: 1rem;">
                            <i class="fa-solid fa-plus-circle"></i> {{ __('Create Subject') }}
                        </h5>
                    </div>
                    <form action="{{ route('subjects.store', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">{{ __('Subject Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Mathematics, English" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold text-dark">{{ __('Subject Code') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g., MATH101, ENG101" value="{{ old('code') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold text-dark">{{ __('Subject Type') }} <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" disabled {{ old('type') ? '' : 'selected' }}>{{ __('Select Type') }}</option>
                                <option value="theory" {{ old('type') == 'theory' ? 'selected' : '' }}>{{ __('Theory - থিওরি') }}</option>
                                <option value="practical" {{ old('type') == 'practical' ? 'selected' : '' }}>{{ __('Practical - ব্যাবহারিক') }}</option>
                                <option value="theory_practical" {{ old('type') == 'theory_practical' ? 'selected' : '' }}>{{ __('Theory + Practical - থিওরি + ব্যাবহারিক') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold text-dark">{{ __('Description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="{{ __('Optional notes...') }}">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" style="background:transparent; border:1.5px solid #4f46e5; color:#4f46e5; border-radius:5px; font-size:0.78rem; font-weight:600; padding:7px 18px; width:100%; transition:all 0.2s;" onmouseover="this.style.background='rgba(79,70,229,0.08)'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-check me-1"></i> {{ __('Create Subject') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Subjects List Column --}}
            <div class="col-12 col-lg-8 order-1 order-lg-2">
                <div class="data-table-card mb-0">
                    {{-- Header Area: Line 1 (Title + Total Count), Line 2 (Filter Form) --}}
                    <div class="subject-card-header">
                        {{-- ── Line 1: Subject List Title (Left) & Total Count (Right) ── --}}
                        <div class="subject-header-top">
                            <h6 class="table-title mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="fa-solid fa-list-ul text-primary"></i> {{ __('Subject List') }}
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                @if(request()->hasAny(['search', 'type']))
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-filter me-1"></i>{{ __('Filtered') }}
                                    </span>
                                @endif
                                <span class="badge bg-primary-subtle text-primary border-0 px-3 py-1.5 fw-bold" style="border-radius: 6px; font-size: 0.78rem;">
                                    {{ __('Total:') }} {{ $totalSubjectsCount ?? $subjects->total() }} {{ __('Subjects') }}
                                </span>
                            </div>
                        </div>

                        {{-- ── Line 2: Filter Form (Full Width Underneath Line 1) ── --}}
                        <form method="GET" action="{{ route('subjects.index', ['tenant' => auth()->user()?->school?->slug]) }}" id="subjectFilterForm" class="subject-filter-box">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-sm-6 col-md-5">
                                    <div class="filter-search-wrap">
                                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                        <input type="text" 
                                               name="search" 
                                               id="searchInput"
                                               class="form-control filter-input-search" 
                                               placeholder="{{ __('Search subject or code...') }}" 
                                               value="{{ request('search') }}">
                                        @if(request('search'))
                                            <button type="button" class="clear-search-btn" onclick="document.getElementById('searchInput').value=''; document.getElementById('subjectFilterForm').submit();" title="{{ __('Clear Search') }}">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-7 col-sm-3 col-md-4">
                                    <select name="type" class="form-select filter-select-type" onchange="this.form.submit()">
                                        <option value="">{{ __('All Types') }}</option>
                                        <option value="theory" {{ request('type') == 'theory' ? 'selected' : '' }}>{{ __('Theory') }}</option>
                                        <option value="practical" {{ request('type') == 'practical' ? 'selected' : '' }}>{{ __('Practical') }}</option>
                                        <option value="theory_practical" {{ request('type') == 'theory_practical' ? 'selected' : '' }}>{{ __('Theory + Practical') }}</option>
                                    </select>
                                </div>
                                <div class="col-5 col-sm-3 col-md-3 d-flex gap-1 justify-content-end">
                                    <button type="submit" class="btn btn-filter-submit flex-grow-1" title="{{ __('Apply Filter') }}">
                                        <i class="fa-solid fa-filter"></i>
                                        <span>{{ __('Filter') }}</span>
                                    </button>
                                    @if(request()->hasAny(['search', 'type']))
                                        <a href="{{ route('subjects.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-filter-reset" title="{{ __('Clear Filters') }}">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- ── Professional Subjects Table ── --}}
                    <div class="table-responsive">
                        <table class="table subjects-pro-table align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-3">{{ __('Subject') }}</th>
                                    <th class="text-center">{{ __('Code') }}</th>
                                    <th class="text-center">{{ __('Type') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th class="text-end pe-3">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                <tr>
                                    <td class="ps-3">
                                        <span class="fw-bold text-dark text-capitalize" style="font-size: 0.9rem;">
                                            {{ $subject->name }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-primary border px-2.5 py-1" style="border-radius: 6px; font-size: 0.76rem; font-weight: 600;">
                                            {{ $subject->code ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($subject->type == 'practical')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border-0 px-2.5 py-1 fw-semibold" style="font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fa-solid fa-flask me-1"></i>{{ __('Practical') }}
                                            </span>
                                        @elseif($subject->type == 'theory_practical')
                                            <span class="badge border-0 px-2.5 py-1 fw-semibold" style="font-size: 0.75rem; border-radius: 6px; background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(234,179,8,0.12)); color: #6366f1;">
                                                <i class="fa-solid fa-pen-nib me-1"></i><i class="fa-solid fa-flask me-1"></i>{{ __('Theory + Practical') }}
                                            </span>
                                        @else
                                            <span class="badge bg-primary-subtle text-primary border-0 px-2.5 py-1 fw-semibold" style="font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fa-solid fa-pen-nib me-1"></i>{{ __('Theory') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted small" title="{{ $subject->description }}">
                                            {{ \Str::limit($subject->description, 35) ?: '—' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end gap-1.5">
                                            <a href="{{ route('subjects.edit', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" 
                                               class="btn-icon-custom btn-action-edit" 
                                               title="{{ __('Edit') }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('subjects.destroy', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" method="POST" class="d-inline m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" class="btn-icon-custom btn-action-delete" title="{{ __('Delete') }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary opacity-50"></i>
                                        <div class="fw-semibold">{{ __('No subjects found.') }}</div>
                                        <small class="text-muted">{{ __('Create a subject from the left panel.') }}</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($subjects->hasPages())
                        <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="text-muted small">
                                {{ __('Showing') }} {{ $subjects->firstItem() ?? 0 }} {{ __('to') }} {{ $subjects->lastItem() ?? 0 }} {{ __('of') }} {{ $subjects->total() }} {{ __('results') }}
                            </div>
                            <div class="ms-auto">
                                {{ $subjects->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('Do you want to delete this subject?') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: "{{ __('Yes, delete it!') }}",
            cancelButtonText: "{{ __('Cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#4f46e5',
        });
    @endif
    @if(session('success'))
        Swal.fire({
            icon: '{{ session('type', 'success') }}',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection