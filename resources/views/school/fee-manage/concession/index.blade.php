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

        /* Action Buttons (Exact Exam Page Styles) */
        .btn-act {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            font-size: 0.8rem;
            text-decoration: none;
            cursor: pointer;
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
        }
        .btn-act-del:hover { 
            background: #ef4444 !important; 
            color: #fff !important; 
            transform: translateY(-1px);
        }

        .badge-discount-percent {
            background: #fef3c7; color: #d97706; font-weight: 700;
            padding: 4px 10px; border-radius: 50px; font-size: 11px;
            border: 1px solid #fde68a;
        }
        .badge-discount-fixed {
            background: #fee2e2; color: #dc2626; font-weight: 700;
            padding: 4px 10px; border-radius: 50px; font-size: 11px;
            border: 1px solid #fca5a5;
        }
        .badge-discount-custom {
            background: #e0e7ff; color: #4338ca; font-weight: 700;
            padding: 4px 10px; border-radius: 50px; font-size: 11px;
            border: 1px solid #c7d2fe;
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
                        <i class="fa-solid fa-tags text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ __('Student Fee Concessions (মাইনাস ফি ও ছাড় ব্যবস্থাপনা)') }}</h4>
                        <p class="page-subtitle mb-0">
                            {{ __('Set customized fee reductions, percentage discounts, or fixed minus fees per student ID') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-primary">
                        <i class="fa-solid fa-hand-holding-dollar"></i> {{ __('Go to Fee Collection') }}
                    </a>
                </div>
            </div>

            {{-- Exact Exam Stats Bar Component --}}
            <div class="fee-stats-bar">
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(59, 130, 246, 0.35);">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $totalDiscountedStudents }}</div>
                        <div class="fee-stat-lbl">{{ __('Discounted Students') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(245, 158, 11, 0.35);">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $activeConcessionsCount }}</div>
                        <div class="fee-stat-lbl">{{ __('Active Concessions') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(16, 185, 129, 0.35);">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">৳ {{ number_format($totalDiscountAmountGiven, 0) }}</div>
                        <div class="fee-stat-lbl">{{ __('Total Discount Given') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         SEARCH & CONCESSION SETUP ROW
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4">
        {{-- Left: Search Student --}}
        <div class="col-lg-4">
            <div class="form-card h-100">
                <div class="form-card-header">
                    <div class="form-card-title">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        {{ __('Select Student') }}
                    </div>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET" class="mb-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">{{ __('Student ID / Roll') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="student_id" class="form-control form-control-modern" 
                                       placeholder="e.g. STD-26011001" 
                                       value="{{ request('student_id') }}" required>
                                <button class="btn btn-primary-gradient px-3" type="submit">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($student)
                    <div class="p-3 rounded-3 border bg-light" style="border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}" 
                                 alt="{{ $student->name }}" 
                                 style="width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid #3b82f6;">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $student->name }}</h6>
                                <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size:11px;">{{ $student->student_id }}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-2 fs-13">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">{{ __('Class') }}:</span>
                                <span class="fw-bold text-dark">{{ $student->class->name ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">{{ __('Section') }}:</span>
                                <span class="fw-bold text-dark">{{ $student->section->name ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">{{ __('Roll') }}:</span>
                                <span class="fw-bold text-dark">{{ $student->roll ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">{{ __('Phone') }}:</span>
                                <span class="fw-bold text-dark">{{ $student->contact_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fa-regular fa-id-card fs-1 mb-2 opacity-50 text-secondary d-block"></i>
                        <p class="small mb-0">{{ __('Enter a Student ID above to configure minus fee or discount.') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Concession Setup Form --}}
        <div class="col-lg-8">
            <div class="form-card h-100">
                <div class="form-card-header d-flex align-items-center justify-content-between">
                    <div class="form-card-title">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6;">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        {{ __('Configure Minus Fee / Discount') }}
                    </div>
                    @if($student)
                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill" style="font-size: 11px;">
                            {{ $student->name }}
                        </span>
                    @endif
                </div>
                <div class="form-card-body">
                    @if($student)
                    <form action="{{ route('student-fee-concessions.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">

                        <div class="table-responsive mb-3 border rounded-3 overflow-hidden" style="border-color: #e2e8f0 !important;">
                            <table class="table modern-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">{{ __('Fee Head') }}</th>
                                        <th>{{ __('Standard Fee') }}</th>
                                        <th style="width:160px;">{{ __('Discount Type') }}</th>
                                        <th style="width:130px;">{{ __('Reduction (৳ / %)') }}</th>
                                        <th class="pe-3 text-end">{{ __('Net Fee') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($feeHeads as $feeHead)
                                    @php
                                        $existing = $studentConcessions->get($feeHead->id);
                                        $stdFee = $standardFeeAmounts->get($feeHead->id)?->amount ?? 0;
                                        $currentType = $existing?->discount_type ?? 'fixed_amount';
                                        $currentVal = $existing?->discount_value ?? 0;
                                    @endphp
                                    <tr class="concession-row" data-standard="{{ $stdFee }}" data-head-id="{{ $feeHead->id }}">
                                        <td class="ps-3">
                                            <div class="fw-bold text-dark fs-13">{{ $feeHead->name }}</div>
                                            @if($existing)
                                                <span class="badge bg-success-subtle text-success" style="font-size:10px;">{{ __('Active Concession') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-secondary fs-13">৳ {{ number_format($stdFee, 2) }}</span>
                                        </td>
                                        <td>
                                            <select name="concessions[{{ $feeHead->id }}][discount_type]" class="form-select form-select-sm form-control-modern row-discount-type" onchange="recalculateRow(this)">
                                                <option value="fixed_amount" {{ $currentType == 'fixed_amount' ? 'selected' : '' }}>৳ Fixed Minus</option>
                                                <option value="percentage" {{ $currentType == 'percentage' ? 'selected' : '' }}>% Percentage Off</option>
                                                <option value="custom_fee" {{ $currentType == 'custom_fee' ? 'selected' : '' }}>Fixed Custom Fee</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" min="0" 
                                                   name="concessions[{{ $feeHead->id }}][discount_value]" 
                                                   class="form-control form-control-sm form-control-modern row-discount-value" 
                                                   value="{{ $currentVal > 0 ? $currentVal : '' }}"
                                                   placeholder="0.00"
                                                   oninput="recalculateRow(this)">
                                        </td>
                                        <td class="pe-3 text-end">
                                            <span class="fw-bold text-primary fs-13 row-net-fee">৳ {{ number_format($stdFee, 2) }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            {{ __('No Fee Heads found for this school.') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">{{ __('Reason / Note (Optional)') }}</label>
                                <input type="text" name="reason" class="form-control form-control-modern" placeholder="e.g. Merit scholarship / Sibling discount / Principal approval">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mt-md-4">
                                    <input class="form-check-input" type="checkbox" name="apply_to_existing_unpaid" value="1" id="applyUnpaidCheck" checked>
                                    <label class="form-check-label small fw-semibold text-dark" for="applyUnpaidCheck">
                                        {{ __('Apply reduction to existing unpaid bills immediately') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-light px-3 fw-semibold">
                                {{ __('Reset') }}
                            </a>
                            <button type="submit" class="btn btn-primary-gradient px-4 py-2">
                                <i class="fa-solid fa-floppy-disk me-1"></i> {{ __('Save Concession Settings') }}
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-user-tag fs-1 mb-3 text-secondary opacity-50 d-block"></i>
                        <h6 class="fw-bold">{{ __('Search a student on the left to set fee reductions') }}</h6>
                        <p class="small text-muted mb-0">{{ __('You can set custom minus fee, percentage discount, or flat reduced amount for Tuition, Exam, Admission and all fee heads.') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         ACTIVE CONCESSIONS TABLE CARD
    ══════════════════════════════════════════════════════════════ --}}
    <div class="data-table-card">
        <div class="data-table-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6; width: 34px; height: 34px;">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark">{{ __('Active Student Concessions List') }}</h6>
                    <small class="text-muted">{{ __('All students with configured minus fee / discount rates') }}</small>
                </div>
            </div>
            <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill">
                {{ $concessionsList->total() }} {{ __('Records') }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="table modern-table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">{{ __('Student ID & Name') }}</th>
                        <th>{{ __('Class & Section') }}</th>
                        <th>{{ __('Fee Head') }}</th>
                        <th>{{ __('Standard Fee') }}</th>
                        <th>{{ __('Reduction Rule') }}</th>
                        <th>{{ __('Net Fee') }}</th>
                        <th>{{ __('Reason') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-center pe-4" style="width: 120px;">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($concessionsList as $concession)
                    @php
                        $classId = $concession->student->class_id ?? 0;
                        $headId = $concession->fee_head_id;
                        $stdAmount = isset($allStandardFeeAmounts[$classId . '_' . $headId]) ? (float) $allStandardFeeAmounts[$classId . '_' . $headId]->amount : 0.00;
                        $calc = $concession->calculateFee($stdAmount);

                        $modalData = [
                            'id' => $concession->id,
                            'student_id' => $concession->student->student_id ?? '',
                            'student_name' => $concession->student->name ?? '',
                            'student_photo' => $concession->student->photo ? asset($concession->student->photo) : asset('assets/images/profile.webp'),
                            'class_name' => $concession->student->class->name ?? '—',
                            'section_name' => $concession->student->section->name ?? '—',
                            'roll' => $concession->student->roll ?? '—',
                            'fee_head_id' => $concession->fee_head_id,
                            'fee_head_name' => $concession->feeHead->name ?? '',
                            'standard_amount' => $stdAmount,
                            'discount_type' => $concession->discount_type,
                            'discount_value' => $concession->discount_type == 'percentage' ? $concession->discount_percent : ($concession->discount_type == 'custom_fee' ? $concession->custom_amount : $concession->discount_amount),
                            'note' => $concession->note,
                            'is_active' => $concession->is_active,
                            'update_url' => route('student-fee-concessions.update', ['tenant' => auth()->user()->school->slug, 'student_fee_concession' => $concession->id])
                        ];
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark fs-13">{{ $concession->student->name ?? 'N/A' }}</div>
                            <span class="badge bg-light text-secondary border" style="font-size:11px;">{{ $concession->student->student_id ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark fs-13">{{ $concession->student->class->name ?? 'N/A' }}</div>
                            <small class="text-muted fs-11">Sec: {{ $concession->student->section->name ?? 'N/A' }} | Roll: {{ $concession->student->roll ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <span class="fw-bold text-dark fs-13">{{ $concession->feeHead->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="fw-semibold text-secondary fs-13">৳ {{ number_format($stdAmount, 2) }}</span>
                        </td>
                        <td>
                            @if($concession->discount_type == 'percentage')
                                <span class="badge-discount-percent"><i class="fa-solid fa-percent me-1"></i>{{ $concession->discount_percent }}% Off</span>
                            @elseif($concession->discount_type == 'fixed_amount')
                                <span class="badge-discount-fixed"><i class="fa-solid fa-minus me-1"></i>৳ {{ number_format($concession->discount_amount, 2) }} Off</span>
                            @else
                                <span class="badge-discount-custom"><i class="fa-solid fa-tag me-1"></i>Fixed ৳ {{ number_format($concession->custom_amount, 2) }}</span>
                            @endif
                        </td>
                        <td>
                            <strong class="text-primary fs-13">৳ {{ number_format($calc['final_amount'], 2) }}</strong>
                        </td>
                        <td>
                            <small class="text-muted fs-12">{{ $concession->note ?? '—' }}</small>
                        </td>
                        <td>
                            @if($concession->is_active)
                                <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">{{ __('Active') }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill" style="font-size: 11px;">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center align-items-center gap-1">
                                {{-- Edit Modal Button (Exam style) --}}
                                <button type="button" 
                                        class="btn-act btn-act-edit" 
                                        onclick="openEditConcessionModal({{ json_encode($modalData) }})" 
                                        title="{{ __('Edit Concession') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                {{-- Delete Button (Exam style) --}}
                                <form action="{{ route('student-fee-concessions.destroy', ['tenant' => auth()->user()->school->slug, 'student_fee_concession' => $concession->id]) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to remove this concession?');" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-del" title="{{ __('Delete') }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fa-regular fa-folder-open fs-1 mb-2 opacity-50 text-secondary d-block"></i>
                            <h6 class="fw-bold">{{ __('No student fee concessions configured yet.') }}</h6>
                            <p class="small text-muted mb-0">{{ __('Use the student search box above to add fee concessions.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($concessionsList->hasPages())
        <div class="px-3 py-3 border-top d-flex justify-content-center">
            {{ $concessionsList->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>

</div>

{{-- ═════════════════════════════════════════════════════════════
     EDIT CONCESSION MODAL
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editConcessionModal" tabindex="-1" aria-labelledby="editConcessionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 10px 40px rgba(15,23,42,0.15); overflow: hidden;">
            <div class="modal-header bg-gradient text-white p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-pen-to-square text-white fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="editConcessionModalLabel">{{ __('Edit Fee Concession') }}</h5>
                        <small class="text-white-50">{{ __('Update discount rate or concession rules') }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editConcessionForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-light">
                    {{-- Student & Fee Head Card --}}
                    <div class="p-3 rounded-3 mb-3 border bg-white shadow-sm" style="border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img id="modal_student_photo" src="" alt="Student" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid #3b82f6;">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" id="modal_student_name"></h6>
                                <div class="d-flex gap-2 align-items-center mt-1">
                                    <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size:10px;" id="modal_student_id"></span>
                                    <small class="text-muted" id="modal_student_details"></small>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="font-size:12.5px;">
                            <div>
                                <span class="text-muted">{{ __('Fee Head') }}:</span>
                                <strong class="text-dark ms-1" id="modal_fee_head_name"></strong>
                            </div>
                            <div>
                                <span class="text-muted">{{ __('Standard Fee') }}:</span>
                                <strong class="text-secondary ms-1" id="modal_standard_amount"></strong>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="modal_standard_raw" value="0">

                    {{-- Form Fields --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">{{ __('Discount Type') }} <span class="text-danger">*</span></label>
                            <select name="discount_type" id="modal_discount_type" class="form-select form-control-modern" onchange="recalculateEditModal()">
                                <option value="fixed_amount">৳ Fixed Minus Amount</option>
                                <option value="percentage">% Percentage Off</option>
                                <option value="custom_fee">Fixed Custom Fee</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">{{ __('Reduction Value (৳ / %)') }} <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="discount_value" id="modal_discount_value" 
                                   class="form-control form-control-modern" placeholder="0.00" required oninput="recalculateEditModal()">
                        </div>
                    </div>

                    {{-- Net Fee Preview Badge --}}
                    <div class="d-flex justify-content-between align-items-center p-3 mb-3 rounded-3 bg-white border" style="border-color: #cbd5e1 !important;">
                        <span class="fw-semibold text-dark small"><i class="fa-solid fa-calculator text-primary me-1"></i>{{ __('Calculated Net Fee') }}:</span>
                        <strong class="text-primary fs-5" id="modal_net_fee_preview">৳ 0.00</strong>
                    </div>

                    {{-- Reason / Note --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">{{ __('Reason / Note') }}</label>
                        <input type="text" name="note" id="modal_note" class="form-control form-control-modern" placeholder="e.g. Merit scholarship / Sibling discount">
                    </div>

                    {{-- Status Toggle & Apply to Unpaid --}}
                    <div class="d-flex flex-column gap-2 p-3 rounded-3 bg-white border" style="border-color: #e2e8f0 !important;">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="modal_is_active" checked>
                            <label class="form-check-label small fw-semibold text-dark" for="modal_is_active">
                                {{ __('Active Concession (সক্রিয় রাখুন)') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="apply_to_existing_unpaid" value="1" id="modal_apply_unpaid" checked>
                            <label class="form-check-label small fw-semibold text-dark" for="modal_apply_unpaid">
                                {{ __('Apply to current unpaid bills immediately (বর্তমান বিলেও কার্যকর করুন)') }}
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-0 bg-light py-3 px-4">
                    <button type="button" class="btn btn-secondary px-3 rounded-3" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary-gradient px-4 py-2">
                        <i class="fa-solid fa-check me-1"></i> {{ __('Update Concession') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function recalculateRow(element) {
        let row = element.closest('.concession-row');
        let standard = parseFloat(row.getAttribute('data-standard')) || 0;
        let type = row.querySelector('.row-discount-type').value;
        let val = parseFloat(row.querySelector('.row-discount-value').value) || 0;
        
        let net = standard;
        if (val > 0) {
            if (type === 'percentage') {
                let disc = (standard * Math.min(100, val)) / 100;
                net = Math.max(0, standard - disc);
            } else if (type === 'fixed_amount') {
                net = Math.max(0, standard - val);
            } else if (type === 'custom_fee') {
                net = Math.max(0, val);
            }
        }
        
        row.querySelector('.row-net-fee').innerText = '৳ ' + net.toFixed(2);
    }

    function openEditConcessionModal(data) {
        document.getElementById('editConcessionForm').action = data.update_url;
        document.getElementById('modal_student_photo').src = data.student_photo;
        document.getElementById('modal_student_name').innerText = data.student_name;
        document.getElementById('modal_student_id').innerText = data.student_id;
        document.getElementById('modal_student_details').innerText = `Class: ${data.class_name} | Sec: ${data.section_name} | Roll: ${data.roll}`;
        document.getElementById('modal_fee_head_name').innerText = data.fee_head_name;
        document.getElementById('modal_standard_amount').innerText = '৳ ' + parseFloat(data.standard_amount).toFixed(2);
        document.getElementById('modal_standard_raw').value = data.standard_amount;
        
        document.getElementById('modal_discount_type').value = data.discount_type;
        document.getElementById('modal_discount_value').value = data.discount_value;
        document.getElementById('modal_note').value = data.note || '';
        document.getElementById('modal_is_active').checked = Boolean(data.is_active);
        document.getElementById('modal_apply_unpaid').checked = true;

        recalculateEditModal();

        let modalElem = document.getElementById('editConcessionModal');
        let modal = bootstrap.Modal.getOrCreateInstance(modalElem);
        modal.show();
    }

    function recalculateEditModal() {
        let standard = parseFloat(document.getElementById('modal_standard_raw').value) || 0;
        let type = document.getElementById('modal_discount_type').value;
        let val = parseFloat(document.getElementById('modal_discount_value').value) || 0;

        let net = standard;
        if (val > 0) {
            if (type === 'percentage') {
                let disc = (standard * Math.min(100, val)) / 100;
                net = Math.max(0, standard - disc);
            } else if (type === 'fixed_amount') {
                net = Math.max(0, standard - val);
            } else if (type === 'custom_fee') {
                net = Math.max(0, val);
            }
        }

        document.getElementById('modal_net_fee_preview').innerText = '৳ ' + net.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.concession-row').forEach(row => {
            let input = row.querySelector('.row-discount-value');
            if (input) recalculateRow(input);
        });
    });

    @if(session('success'))
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: '{{ session('type', 'success') }}',
            title: '{{ session('type') == 'success' ? 'Success!' : 'Notice' }}',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    }
    @endif
</script>
@endsection
