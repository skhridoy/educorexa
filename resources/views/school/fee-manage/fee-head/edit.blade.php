@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Exact Exam Page Stats Bar */
        .fee-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 20px;
        }
        .fee-stat-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            backdrop-filter: blur(8px);
        }
        .fee-stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
        }
        .fee-stat-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }
        .fee-stat-lbl {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }

        /* Filter Card Toolbar */
        .fee-filter-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: var(--card-shadow);
        }
        [data-bs-theme="dark"] .fee-filter-card,
        body.dark-mode .fee-filter-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }

        /* Custom Status Badges */
        .badge-status {
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }
        .badge-monthly   { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .badge-once      { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-recurring { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }

        /* Action Buttons (Exact Exam Page Styles) */
        .btn-act {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            font-size: 0.8rem;
            text-decoration: none;
        }
        .btn-act-edit { 
            background: #eff6ff !important; 
            color: #3b82f6 !important; 
            border: 1px solid #bfdbfe !important; 
        }
        .btn-act-edit:hover { 
            background: #3b82f6 !important; 
            color: #fff !important; 
            transform: translateY(-1px);
        }
        .btn-act-del { 
            background: #fef2f2 !important; 
            color: #ef4444 !important; 
            border: 1px solid #fecaca !important; 
            cursor: pointer;
        }
        .btn-act-del:hover { 
            background: #ef4444 !important; 
            color: #fff !important; 
            transform: translateY(-1px);
        }

        /* Preset Chips */
        .preset-chip {
            background: #f1f5f9;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            padding: 4px 9px;
            font-size: 0.72rem;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .preset-chip:hover {
            background: #e0e7ff;
            border-color: #818cf8;
            color: #4338ca;
        }
        [data-bs-theme="dark"] .preset-chip,
        body.dark-mode .preset-chip {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }

        @media (max-width: 991.98px) {
            .fee-stats-bar { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 767.98px) {
            .fee-stats-bar { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .fee-stat-card { padding: 10px 12px; gap: 10px; }
            .fee-stat-icon { width: 36px; height: 36px; font-size: 1.1rem; }
            .fee-stat-val  { font-size: 1.25rem; }
            .fee-stat-lbl  { font-size: 0.7rem; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ═════════════════════════════════════════════════════════════
         HERO HEADER CARD (Matches Exam Page Header Exactly)
    ══════════════════════════════════════════════════════════════ --}}
    <div class="page-header-card">
        <div class="page-header-content">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon">
                        <i class="fa-solid fa-file-invoice-dollar text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ __('Edit Fee Head (ফি খাত সম্পাদনা)') }}</h4>
                        <p class="page-subtitle mb-0">
                            {{ __('Update the fee category title or change its billing frequency') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('fee-heads.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-secondary">
                        <i class="fa-solid fa-arrow-left"></i> {{ __('Back to Fee Heads') }}
                    </a>
                </div>
            </div>

            {{-- Exact Exam Stats Bar Component --}}
            <div class="fee-stats-bar">
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(59, 130, 246, 0.35);">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $feeHeads->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('Total Fee Heads') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(16, 185, 129, 0.35);">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $feeHeads->where('type', 'monthly')->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('Monthly Fees') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(245, 158, 11, 0.35);">
                        <i class="fa-solid fa-circle-notch"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $feeHeads->where('type', '!=', 'monthly')->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('One-time / Recurring') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         MAIN CONTENT ROW
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row g-4">
        {{-- ── Left: Edit Fee Head Form ── --}}
        <div class="col-lg-4">
            <div class="form-card sticky-top" style="top: 80px; z-index: 10;">
                <div class="form-card-header">
                    <div class="form-card-title">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6;">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        {{ __('Edit Fee Head') }}
                    </div>
                    <span class="badge bg-warning text-dark px-2 py-1 rounded-pill" style="font-size: 11px;">
                        #{{ $fee_head->id }}
                    </span>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('fee-heads.update', ['tenant' => auth()->user()->school->slug, 'fee_head' => $fee_head->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Quick Presets --}}
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold d-block mb-1">{{ __('Quick Suggestions') }}</label>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="preset-chip" onclick="setPreset('Tuition Fee (বেতন)', 'monthly')">+ Tuition Fee</span>
                                <span class="preset-chip" onclick="setPreset('Exam Fee (পরীক্ষার ফি)', 'recurring')">+ Exam Fee</span>
                                <span class="preset-chip" onclick="setPreset('Admission Fee (ভর্তি ফি)', 'once')">+ Admission</span>
                                <span class="preset-chip" onclick="setPreset('Session Fee (সেশন ফি)', 'recurring')">+ Session Fee</span>
                            </div>
                        </div>

                        {{-- Fee Head Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-dark small">{{ __('Fee Head Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-modern" id="name" name="name" 
                                   placeholder="e.g. Admission Fee" value="{{ old('name', $fee_head->name) }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Billing Frequency --}}
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold text-dark small">{{ __('Billing Frequency') }} <span class="text-danger">*</span></label>
                            <select class="form-select form-control-modern" id="type" name="type" required>
                                <option value="" disabled>{{ __('Select billing frequency') }}</option>
                                <option value="monthly" {{ old('type', $fee_head->type) == 'monthly' ? 'selected' : '' }}>📅 {{ __('Monthly (Every Month)') }}</option>
                                <option value="once" {{ old('type', $fee_head->type) == 'once' ? 'selected' : '' }}>🎯 {{ __('Once (One-time payment)') }}</option>
                                <option value="recurring" {{ old('type', $fee_head->type) == 'recurring' ? 'selected' : '' }}>🔄 {{ __('Recurring (Periodic / Termly)') }}</option>
                            </select>
                            @error('type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('fee-heads.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-light w-50 py-2 rounded-3 fw-semibold">
                                <i class="fa-solid fa-times me-1"></i> {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary-gradient w-50 py-2">
                                <i class="fa-solid fa-check me-1"></i> {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Right: Defined Fee Heads Table ── --}}
        <div class="col-lg-8">
            <div class="data-table-card">
                <div class="data-table-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6; width: 34px; height: 34px;">
                            <i class="fa-solid fa-list-ul"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ __('Defined Fee Heads') }}</h6>
                            <small class="text-muted">{{ __('All fee categories in your institution') }}</small>
                        </div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill">
                        {{ $feeHeads->count() }} {{ __('Heads Defined') }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table modern-table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 60px;">#</th>
                                <th>{{ __('Fee Head Name') }}</th>
                                <th>{{ __('Billing Frequency') }}</th>
                                <th class="text-center pe-4" style="width: 120px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeHeads as $head)
                            <tr class="{{ $head->id == $fee_head->id ? 'table-primary-subtle' : '' }}">
                                <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold text-dark fs-14">
                                        {{ $head->name }}
                                        @if($head->id == $fee_head->id)
                                            <span class="badge bg-warning text-dark ms-1" style="font-size: 10px;">{{ __('Editing') }}</span>
                                        @endif
                                    </div>
                                    <small class="text-muted fs-12">
                                        {{ __('Created:') }} {{ $head->created_at ? $head->created_at->format('d M, Y') : '—' }}
                                    </small>
                                </td>
                                <td>
                                    @if($head->type == 'monthly')
                                        <span class="badge-status badge-monthly">
                                            <i class="fa-regular fa-calendar-days"></i> {{ __('Monthly') }}
                                        </span>
                                    @elseif($head->type == 'once')
                                        <span class="badge-status badge-once">
                                            <i class="fa-solid fa-check-double"></i> {{ __('One Time') }}
                                        </span>
                                    @else
                                        <span class="badge-status badge-recurring">
                                            <i class="fa-solid fa-repeat"></i> {{ __('Recurring') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        {{-- Edit Button (Exam style) --}}
                                        <a href="{{ route('fee-heads.edit', ['tenant' => auth()->user()->school->slug, 'fee_head' => $head->id]) }}"
                                           class="btn-act btn-act-edit" title="{{ __('Edit Fee Head') }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        {{-- Delete Button (Exam style) --}}
                                        <form action="{{ route('fee-heads.destroy', ['tenant' => auth()->user()->school->slug, 'fee_head' => $head->id]) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)"
                                                    class="btn-act btn-act-del" title="{{ __('Delete Fee Head') }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fa-solid fa-file-invoice-dollar fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                                        <h6 class="fw-bold">{{ __('No Fee Heads Found') }}</h6>
                                        <p class="small text-muted">{{ __('Create your first fee category using the form on the left.') }}</p>
                                    </div>
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
@endsection

@section('customJs')
<script>
    function setPreset(name, type) {
        document.getElementById('name').value = name;
        document.getElementById('type').value = type;
    }

    function confirmDelete(button) {
        Swal.fire({
            title: '{{ __("Delete Fee Head?") }}',
            text: "{{ __('This will permanently delete this fee head and may affect fee amounts configuration!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> {{ __("Yes, Delete") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            customClass: {
                confirmButton: 'rounded-pill px-4 py-2',
                cancelButton: 'rounded-pill px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: '{{ session('type', 'success') }}',
        title: '{{ session('type') == 'success' ? "Success!" : "Notice" }}',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif
    
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}'
    });
    @endif
</script>
@endsection