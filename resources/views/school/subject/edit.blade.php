@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
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
            background: rgba(79, 70, 229, 0.12);
            color: #4f46e5 !important;
        }

        .btn-action-edit:hover {
            background: #4f46e5;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(79, 70, 229, 0.3);
        }

        /* Dark mode support */
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
                    <h1 class="page-title"><i class="fa-solid fa-pen-to-square me-2"></i> {{ __('Update Subject') }}</h1>
                    <p class="page-subtitle mb-0">{{ __('Edit subject name, code, type, and details.') }}</p>
                </div>
                <div>
                    <a href="{{ route('subjects.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-light fw-bold shadow-sm">
                        <i class="fa-solid fa-arrow-left me-1 text-primary"></i> {{ __('Back to List') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3 g-lg-4">
            {{-- Form Column --}}
            <div class="col-12 col-lg-4 order-1 order-lg-1">
                <div class="form-card mb-0">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="mb-0 fw-bold text-primary d-flex align-items-center gap-2" style="font-size: 1rem;">
                            <i class="fa-solid fa-sliders"></i> {{ __('Subject Details') }}
                        </h5>
                    </div>
                    <form action="{{ route('subjects.update', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">{{ __('Subject Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Mathematics" value="{{ old('name', $subject->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold text-dark">{{ __('Subject Code') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g. MATH101" value="{{ old('code', $subject->code) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold text-dark">{{ __('Subject Type') }} <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" disabled>{{ __('Select Type') }}</option>
                                <option value="theory" {{ old('type', $subject->type) == 'theory' ? 'selected' : '' }}>{{ __('Theory - থিওরি') }}</option>
                                <option value="practical" {{ old('type', $subject->type) == 'practical' ? 'selected' : '' }}>{{ __('Practical - ব্যাবহারিক') }}</option>
                                <option value="theory_practical" {{ old('type', $subject->type) == 'theory_practical' ? 'selected' : '' }}>{{ __('Theory + Practical - থিওরি + ব্যাবহারিক') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold text-dark">{{ __('Description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="{{ __('Description') }}">{{ old('description', $subject->description) }}</textarea>
                        </div>
                        <div class="d-flex gap-2 pt-2">
                            <button type="submit" style="background:transparent; border:1.5px solid #4f46e5; color:#4f46e5; border-radius:5px; font-size:0.78rem; font-weight:600; padding:6px 14px; transition:all 0.2s;" onmouseover="this.style.background='rgba(79,70,229,0.08)'" onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-check me-1"></i> {{ __('Update Subject') }}
                            </button>
                            <a href="{{ route('subjects.index', ['tenant' => auth()->user()?->school?->slug]) }}" style="background:transparent; border:1.5px solid #94a3b8; color:#64748b; border-radius:5px; font-size:0.78rem; font-weight:600; padding:6px 14px; text-decoration:none; display:inline-flex; align-items:center; transition:all 0.2s;" onmouseover="this.style.background='rgba(148,163,184,0.08)'" onmouseout="this.style.background='transparent'">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- List Column --}}
            <div class="col-12 col-lg-8 order-2 order-lg-2">
                <div class="data-table-card mb-0">
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h6 class="table-title mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 1rem;">
                            <i class="fa-solid fa-list-ul text-primary"></i> {{ __('All Subjects') }}
                        </h6>
                        <span class="badge bg-primary-subtle text-primary border-0 px-2.5 py-1 fw-bold" style="border-radius: 6px; font-size: 0.76rem;">
                            {{ $subjects->total() }} {{ __('Total') }}
                        </span>
                    </div>

                    {{-- Professional Table --}}
                    <div class="table-responsive">
                        <table class="table subjects-pro-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3">{{ __('Subject') }}</th>
                                    <th class="text-center">{{ __('Code') }}</th>
                                    <th class="text-center">{{ __('Type') }}</th>
                                    <th class="text-end pe-3">{{ __('Status / Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $subj)
                                <tr class="{{ $subj->id == $subject->id ? 'table-active' : '' }}">
                                    <td class="ps-3">
                                        <span class="fw-bold text-dark text-capitalize" style="font-size: 0.9rem;">
                                            {{ $subj->name }}
                                        </span>
                                        @if($subj->id == $subject->id)
                                            <span class="badge bg-primary-subtle text-primary ms-1.5" style="font-size: 0.7rem;">{{ __('Editing') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-primary border px-2.5 py-1" style="border-radius: 6px; font-size: 0.76rem; font-weight: 600;">
                                            {{ $subj->code ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($subj->type == 'practical')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border-0 px-2.5 py-1 fw-semibold text-capitalize" style="font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fa-solid fa-flask me-1"></i>{{ __('Practical') }}
                                            </span>
                                        @else
                                            <span class="badge bg-primary-subtle text-primary border-0 px-2.5 py-1 fw-semibold text-capitalize" style="font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fa-solid fa-pen-nib me-1"></i>{{ $subj->type ? __($subj->type) : __('Theory') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        @if($subj->id == $subject->id)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-pen-nib me-1"></i> {{ __('Active Edit') }}
                                            </span>
                                        @else
                                            <a href="{{ route('subjects.edit', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subj->id]) }}" 
                                               class="btn-icon-custom btn-action-edit" 
                                               title="{{ __('Edit This') }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
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