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

        @media (max-width: 767.98px) {
            .fee-stats-bar { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .fee-stat-card { padding: 10px 12px; gap: 10px; }
            .fee-stat-icon { width: 36px; height: 36px; font-size: 1.1rem; }
            .fee-stat-val  { font-size: 1.25rem; }
            .fee-stat-lbl  { font-size: 0.7rem; }
        }
        @media (max-width: 575.98px) {
            .fee-stats-bar { grid-template-columns: 1fr; gap: 8px; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- ════ HERO HEADER BANNER (EXAM PAGE STYLE) ════ --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <div class="d-flex align-items-start align-items-md-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title"><i class="fa-solid fa-list-check me-2"></i>{{ __('Fee Heads Management') }}</h1>
                        <p class="mb-0 opacity-85">{{ __('Define and manage academic fee categories, billing frequencies & structures') }}</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0 flex-wrap">
                        <a href="{{ route('fee-amounts.index', ['tenant' => auth()->user()->school->slug]) }}" 
                           class="btn btn-sm btn-light fw-bold shadow-sm" style="border-radius: 8px; font-size: 0.8rem; padding: 6px 14px;">
                            <i class="fa-solid fa-layer-group me-1 text-primary"></i> {{ __('Fee Structure') }}
                        </a>
                        <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" 
                           class="btn btn-sm btn-outline-light fw-bold" style="border-radius: 8px; font-size: 0.8rem; padding: 6px 14px; background: rgba(255,255,255,0.12);">
                            <i class="fa-solid fa-tags me-1 text-warning"></i> {{ __('Fee Concessions') }}
                        </a>
                    </div>
                </div>

                {{-- Header Live Stats Bar --}}
                <div class="fee-stats-bar">
                    <div class="fee-stat-card">
                        <div class="fee-stat-icon"><i class="fa-solid fa-layer-group"></i></div>
                        <div>
                            <div class="fee-stat-val">{{ $feeHeads->count() }}</div>
                            <div class="fee-stat-lbl">{{ __('Total Fee Heads') }}</div>
                        </div>
                    </div>
                    <div class="fee-stat-card">
                        <div class="fee-stat-icon" style="background:rgba(34,197,94,0.3);"><i class="fa-regular fa-calendar-days"></i></div>
                        <div>
                            <div class="fee-stat-val">{{ $feeHeads->where('type', 'monthly')->count() }}</div>
                            <div class="fee-stat-lbl">{{ __('Monthly Fees') }}</div>
                        </div>
                    </div>
                    <div class="fee-stat-card">
                        <div class="fee-stat-icon" style="background:rgba(251,191,36,0.3);"><i class="fa-solid fa-coins"></i></div>
                        <div>
                            <div class="fee-stat-val">{{ $feeHeads->whereIn('type', ['once', 'recurring'])->count() }}</div>
                            <div class="fee-stat-lbl">{{ __('One-time & Recurring') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- ════ LEFT COLUMN: CREATE FEE HEAD FORM ════ --}}
            <div class="col-lg-4 mb-4">
                <div class="form-card h-100 shadow-sm">
                    <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                        <div class="btn-act btn-act-edit" style="width:32px; height:32px; border-radius:8px;">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <h5 class="fw-800 mb-0 text-dark" style="font-size:1rem;">{{ __('Create New Fee Head') }}</h5>
                    </div>

                    <form action="{{ route('fee-heads.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf

                        {{-- Fee Head Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-700 text-secondary small d-flex align-items-center justify-content-between">
                                <span><i class="fa-solid fa-pen text-primary me-1"></i>{{ __('Fee Head Name') }} <span class="text-danger">*</span></span>
                                <span class="text-muted" style="font-size: 0.7rem;">{{ __('Quick Suggestions:') }}</span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Tuition Fee" required>

                            {{-- Suggestion Chips --}}
                            <div class="d-flex flex-wrap gap-1 mt-2">
                                <button type="button" class="preset-chip" data-name="Tuition Fee">+ Tuition Fee</button>
                                <button type="button" class="preset-chip" data-name="Exam Fee">+ Exam Fee</button>
                                <button type="button" class="preset-chip" data-name="Admission Fee">+ Admission Fee</button>
                                <button type="button" class="preset-chip" data-name="Session Fee">+ Session Fee</button>
                                <button type="button" class="preset-chip" data-name="Transport Fee">+ Transport</button>
                                <button type="button" class="preset-chip" data-name="ICT / Computer Fee">+ ICT Fee</button>
                            </div>
                        </div>

                        {{-- Billing Frequency --}}
                        <div class="mb-4">
                            <label for="type" class="form-label fw-700 text-secondary small">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i>{{ __('Billing Frequency') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" disabled selected>{{ __('-- Select Frequency --') }}</option>
                                <option value="monthly">📅 {{ __('Monthly (Every Month)') }}</option>
                                <option value="once">🎯 {{ __('Once (One-time payment)') }}</option>
                                <option value="recurring">🔄 {{ __('Recurring (Periodic / Termly)') }}</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold shadow-sm" style="border-radius: 8px; font-size: 0.85rem;">
                            <i class="fa-solid fa-plus-circle me-1"></i> {{ __('Save Fee Head') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- ════ RIGHT COLUMN: FEE HEADS LIST ════ --}}
            <div class="col-lg-8 mb-4">
                {{-- Filter Toolbar --}}
                <div class="fee-filter-card">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-7">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" id="feeSearchInput" class="form-control border-start-0" placeholder="{{ __('Search fee head by name...') }}" onkeyup="filterFeeTable()">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <select id="feeTypeFilter" class="form-select form-select-sm" onchange="filterFeeTable()">
                                <option value="">{{ __('All Billing Types') }}</option>
                                <option value="monthly">{{ __('Monthly Only') }}</option>
                                <option value="once">{{ __('One Time Only') }}</option>
                                <option value="recurring">{{ __('Recurring Only') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Table Card --}}
                <div class="data-table-card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="feeHeadsTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">#</th>
                                    <th>{{ __('Fee Head Details') }}</th>
                                    <th class="text-center">{{ __('Billing Frequency') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th class="text-end pe-3" style="width: 100px;">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeHeads as $feeHead)
                                <tr class="fee-row" data-name="{{ strtolower($feeHead->name) }}" data-type="{{ $feeHead->type }}">
                                    <td class="text-center fw-bold text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold text-dark" style="font-size: 0.92rem;">{{ $feeHead->name }}</div>
                                        <div class="d-flex align-items-center gap-1 mt-0.5">
                                            <span class="badge bg-soft-primary text-primary" style="font-size: 0.7rem; padding: 2px 6px;">
                                                <i class="fa-solid fa-tag me-1"></i>Academic Head
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($feeHead->type == 'monthly')
                                            <span class="badge-status badge-monthly">
                                                <i class="fa-solid fa-circle" style="font-size:0.45rem;"></i> {{ __('Monthly') }}
                                            </span>
                                        @elseif($feeHead->type == 'once')
                                            <span class="badge-status badge-once">
                                                <i class="fa-solid fa-circle" style="font-size:0.45rem;"></i> {{ __('One Time') }}
                                            </span>
                                        @else
                                            <span class="badge-status badge-recurring">
                                                <i class="fa-solid fa-circle" style="font-size:0.45rem;"></i> {{ __('Recurring') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small text-muted">{{ $feeHead->created_at ? $feeHead->created_at->format('d M, Y') : '—' }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end align-items-center gap-1.5">
                                            {{-- Edit Modal Button --}}
                                            <button type="button"
                                                    class="btn-act btn-act-edit"
                                                    onclick="openEditFeeHeadModal({{ $feeHead->id }}, '{{ addslashes($feeHead->name) }}', '{{ $feeHead->type }}', '{{ route('fee-heads.update', ['tenant' => auth()->user()->school->slug, 'fee_head' => $feeHead->id]) }}')"
                                                    title="{{ __('Edit Fee Head') }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('fee-heads.destroy', ['tenant' => auth()->user()->school->slug, 'fee_head' => $feeHead->id]) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        onclick="confirmDelete(this)"
                                                        class="btn-act btn-act-del"
                                                        title="{{ __('Delete Fee Head') }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa-solid fa-folder-open fa-2x mb-2 text-secondary opacity-50"></i>
                                            <p class="mb-0">{{ __('No fee heads defined yet.') }}</p>
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
</div>

{{-- ════ EDIT FEE HEAD MODAL (EXACT EXAM MODAL STYLE) ════ --}}
<div class="modal fade" id="editFeeHeadModal" tabindex="-1" aria-labelledby="editFeeHeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow:0 20px 50px rgba(0,0,0,0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e293b, #334155); padding: 16px 20px;">
                <h5 class="modal-title fw-bold" id="editFeeHeadModalLabel">
                    <i class="fa-solid fa-pen-to-square me-2" style="color:#818cf8;"></i> {{ __('Edit Fee Head') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFeeHeadForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="modal_name" class="form-label fw-700 text-secondary small">{{ __('Fee Head Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_type" class="form-label fw-700 text-secondary small">{{ __('Billing Frequency') }} <span class="text-danger">*</span></label>
                        <select class="form-select" id="modal_type" name="type" required>
                            <option value="monthly">📅 {{ __('Monthly (Every Month)') }}</option>
                            <option value="once">🎯 {{ __('Once (One-time payment)') }}</option>
                            <option value="recurring">🔄 {{ __('Recurring (Periodic / Termly)') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">{{ __('Update Fee Head') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    // Quick Suggestion Chips
    document.querySelectorAll('.preset-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            document.getElementById('name').value = this.getAttribute('data-name');
        });
    });

    // Open Edit Modal
    function openEditFeeHeadModal(id, name, type, actionUrl) {
        document.getElementById('editFeeHeadForm').action = actionUrl;
        document.getElementById('modal_name').value = name;
        document.getElementById('modal_type').value = type;
        
        let modalElem = document.getElementById('editFeeHeadModal');
        let modal = bootstrap.Modal.getOrCreateInstance(modalElem);
        modal.show();
    }

    // Client-side quick filter
    function filterFeeTable() {
        let search = document.getElementById('feeSearchInput').value.toLowerCase();
        let type = document.getElementById('feeTypeFilter').value;
        
        document.querySelectorAll('.fee-row').forEach(row => {
            let rowName = row.getAttribute('data-name');
            let rowType = row.getAttribute('data-type');
            
            let matchSearch = !search || rowName.includes(search);
            let matchType = !type || rowType === type;
            
            row.style.display = (matchSearch && matchType) ? '' : 'none';
        });
    }

    // Delete Confirmation
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