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
         SEARCH & CONCESSION SETUP ROW (Premium Redesign)
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4">
        {{-- Left: Search Student --}}
        <div class="col-lg-4">
            <div class="conc-card-wrap h-100">
                <div class="conc-card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="conc-card-icon conc-icon-indigo">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <div>
                            <h6 class="conc-card-title">{{ __('Select Student') }}</h6>
                            <small class="conc-card-subtitle">{{ __('Find by Student ID or Roll') }}</small>
                        </div>
                    </div>
                </div>
                <div class="conc-card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                    <div>
                        <form action="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET" class="mb-3">
                            <div class="mb-3">
                                <label class="conc-form-label">
                                    <i class="fa-solid fa-id-badge me-1 text-primary"></i>
                                    {{ __('Student ID / Roll') }} <span class="text-danger">*</span>
                                </label>
                                <div class="conc-search-box">
                                    <div class="conc-search-prefix">
                                        <i class="fa-solid fa-search"></i>
                                    </div>
                                    <input type="text" name="student_id" class="conc-search-input" 
                                           placeholder="e.g. STD-26011001" 
                                           value="{{ request('student_id') }}" required autocomplete="off">
                                    <button class="conc-search-btn" type="submit" title="{{ __('Search Student') }}">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if($student)
                        <div class="conc-student-profile-card">
                            <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom" style="border-color: #e0e7ff !important;">
                                <img src="{{ !empty($student->photo) ? asset($student->photo) : asset('assets/images/profile.webp') }}" 
                                     alt="{{ $student->name }}" 
                                     class="conc-profile-avatar"
                                     onerror="this.onerror=null;this.src='{{ asset('assets/images/profile.webp') }}';">
                                <div style="min-width: 0;">
                                    <h6 class="fw-bold mb-1 text-dark text-truncate" style="font-size: 15px;">{{ $student->name }}</h6>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="conc-student-id-pill">{{ $student->student_id }}</span>
                                        <span class="conc-profile-status"><i class="fa-solid fa-circle-check"></i> Ready</span>
                                    </div>
                                </div>
                            </div>
                            <div class="conc-profile-grid">
                                <div class="conc-profile-info-box">
                                    <span class="conc-info-lbl"><i class="fa-solid fa-graduation-cap text-primary me-1"></i> {{ __('Class') }}</span>
                                    <span class="conc-info-val">{{ $student->class->name ?? 'N/A' }}</span>
                                </div>
                                <div class="conc-profile-info-box">
                                    <span class="conc-info-lbl"><i class="fa-solid fa-layer-group text-info me-1"></i> {{ __('Section') }}</span>
                                    <span class="conc-info-val">{{ $student->section->name ?? 'N/A' }}</span>
                                </div>
                                <div class="conc-profile-info-box">
                                    <span class="conc-info-lbl"><i class="fa-solid fa-hashtag text-warning me-1"></i> {{ __('Roll') }}</span>
                                    <span class="conc-info-val">{{ $student->roll ?? 'N/A' }}</span>
                                </div>
                                <div class="conc-profile-info-box">
                                    <span class="conc-info-lbl"><i class="fa-solid fa-phone text-success me-1"></i> {{ __('Contact') }}</span>
                                    <span class="conc-info-val">{{ $student->contact_number ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="mt-3 text-center">
                                <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" 
                                   class="conc-clear-student-link">
                                    <i class="fa-solid fa-rotate-left me-1"></i> {{ __('Change / Clear Student') }}
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="conc-search-empty-state">
                            <div class="conc-search-empty-icon">
                                <i class="fa-regular fa-id-card"></i>
                            </div>
                            <h6 class="conc-search-empty-title">{{ __('No Student Selected') }}</h6>
                            <p class="conc-search-empty-desc">{{ __('Enter a Student ID or Roll number above to fetch student details and configure discount rates.') }}</p>
                            <div class="conc-hint-badge">
                                <i class="fa-regular fa-lightbulb text-warning me-1"></i> {{ __('Quick hint: Type student ID or roll & hit Enter') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Concession Setup Form --}}
        <div class="col-lg-8">
            <div class="conc-card-wrap h-100">
                <div class="conc-card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="conc-card-icon conc-icon-sky">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <div>
                            <h6 class="conc-card-title">{{ __('Configure Minus Fee / Discount') }}</h6>
                            <small class="conc-card-subtitle">{{ __('Set customizable fee reductions and discount rates') }}</small>
                        </div>
                    </div>
                    @if($student)
                        <div class="conc-header-student-tag">
                            <i class="fa-solid fa-user-check text-success me-1"></i>
                            <span class="fw-bold">{{ $student->name }}</span>
                        </div>
                    @endif
                </div>
                <div class="conc-card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                    @if($student)
                    <form action="{{ route('student-fee-concessions.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">

                        <div class="conc-form-table-wrap mb-3">
                            <div class="table-responsive">
                                <table class="table conc-form-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-3">{{ __('Fee Head') }}</th>
                                            <th>{{ __('Standard Fee') }}</th>
                                            <th style="width:170px;">{{ __('Discount Type') }}</th>
                                            <th style="width:140px;">{{ __('Reduction (৳ / %)') }}</th>
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
                                                    <span class="conc-active-pill">
                                                        <i class="fa-solid fa-check me-1"></i>{{ __('Active') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="conc-std-pill">৳ {{ number_format($stdFee, 0) }}</span>
                                            </td>
                                            <td>
                                                <select name="concessions[{{ $feeHead->id }}][discount_type]" 
                                                        class="form-select form-select-sm conc-select-modern row-discount-type" 
                                                        onchange="recalculateRow(this)">
                                                    <option value="fixed_amount" {{ $currentType == 'fixed_amount' ? 'selected' : '' }}>৳ Fixed Minus</option>
                                                    <option value="percentage" {{ $currentType == 'percentage' ? 'selected' : '' }}>% Percentage Off</option>
                                                    <option value="custom_fee" {{ $currentType == 'custom_fee' ? 'selected' : '' }}>Fixed Custom Fee</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="1" min="0" 
                                                       name="concessions[{{ $feeHead->id }}][discount_value]" 
                                                       class="form-control form-control-sm conc-input-modern row-discount-value" 
                                                       value="{{ $currentVal > 0 ? round($currentVal) : '' }}"
                                                       placeholder="0"
                                                       oninput="recalculateRow(this)">
                                            </td>
                                            <td class="pe-3 text-end">
                                                <span class="conc-net-val row-net-fee">৳ {{ number_format($stdFee, 0) }}</span>
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
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-md-6">
                                <label class="conc-form-label mb-1">
                                    <i class="fa-solid fa-pen-nib me-1 text-primary"></i> {{ __('Reason / Note (Optional)') }}
                                </label>
                                <input type="text" name="reason" class="form-control conc-input-modern" 
                                       placeholder="e.g. Merit scholarship / Sibling discount / Principal approval">
                            </div>
                            <div class="col-md-6">
                                <div class="conc-checkbox-card mt-md-4">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="apply_to_existing_unpaid" value="1" id="applyUnpaidCheck" checked>
                                        <label class="form-check-label small fw-semibold text-dark cursor-pointer ms-1" for="applyUnpaidCheck">
                                            {{ __('Apply reduction to existing unpaid bills immediately') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center gap-2 pt-2 border-top" style="border-color: #f1f5f9 !important;">
                            <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" 
                               class="conc-btn-reset">
                                <i class="fa-solid fa-arrow-rotate-left me-1"></i> {{ __('Reset') }}
                            </a>
                            <button type="submit" class="conc-btn-save">
                                <i class="fa-solid fa-floppy-disk me-2"></i> {{ __('Save Concession Settings') }}
                            </button>
                        </div>
                    </form>
                    @else
                    {{-- Right Empty State (When no student is selected) --}}
                    <div class="conc-config-empty">
                        <div class="conc-config-empty-icon-wrap">
                            <div class="conc-config-empty-icon">
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                        </div>
                        <h6 class="conc-config-empty-title">{{ __('Search a student on the left to set fee reductions') }}</h6>
                        <p class="conc-config-empty-desc">{{ __('You can set custom minus fee, percentage discount, or flat reduced amount for Tuition, Exam, Admission and all fee heads.') }}</p>
                        
                        <div class="conc-features-grid">
                            <div class="conc-feature-pill">
                                <div class="conc-feat-icon feat-amber">
                                    <i class="fa-solid fa-percent"></i>
                                </div>
                                <div>
                                    <div class="conc-feat-title">{{ __('Percentage Off') }}</div>
                                    <div class="conc-feat-sub">{{ __('e.g. 20% or 50% discount') }}</div>
                                </div>
                            </div>
                            <div class="conc-feature-pill">
                                <div class="conc-feat-icon feat-red">
                                    <i class="fa-solid fa-minus"></i>
                                </div>
                                <div>
                                    <div class="conc-feat-title">{{ __('Fixed Minus') }}</div>
                                    <div class="conc-feat-sub">{{ __('e.g. ৳ 500 flat deduction') }}</div>
                                </div>
                            </div>
                            <div class="conc-feature-pill">
                                <div class="conc-feat-icon feat-purple">
                                    <i class="fa-solid fa-tag"></i>
                                </div>
                                <div>
                                    <div class="conc-feat-title">{{ __('Fixed Custom Fee') }}</div>
                                    <div class="conc-feat-sub">{{ __('e.g. Exact fee set to ৳ 1,000') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         ACTIVE CONCESSIONS TABLE CARD  ─ Premium Redesign
    ══════════════════════════════════════════════════════════════ --}}
    <div class="conc-table-wrap">

        {{-- Table Header --}}
        <div class="conc-table-header">
            <div class="d-flex align-items-center gap-3">
                <div class="conc-header-icon">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0" style="color:#1e293b; font-size:15px;">{{ __('Active Student Concessions List') }}</h6>
                    <small style="color:#64748b; font-size:12px;">{{ __('All students with configured minus fee / discount rates') }}</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="conc-record-badge">
                    <i class="fa-solid fa-database me-1" style="font-size:10px;"></i>
                    {{ $concessionsList->total() }} {{ __('Records') }}
                </span>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table conc-table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="min-width: 190px;">{{ __('Student') }}</th>
                        <th style="min-width: 130px;">{{ __('Class & Section') }}</th>
                        <th style="min-width: 120px;">{{ __('Fee Head') }}</th>
                        <th style="min-width: 100px;">{{ __('Standard Fee') }}</th>
                        <th style="min-width: 150px;">{{ __('Reduction Rule') }}</th>
                        <th style="min-width: 100px;">{{ __('Net Fee') }}</th>
                        <th style="min-width: 110px;">{{ __('Reason') }}</th>
                        <th style="min-width: 90px;">{{ __('Status') }}</th>
                        <th style="min-width: 80px;" class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($concessionsList as $concession)
                    @php
                        $classId   = $concession->student->class_id ?? 0;
                        $headId    = $concession->fee_head_id;
                        $stdAmount = isset($allStandardFeeAmounts[$classId . '_' . $headId]) ? (float) $allStandardFeeAmounts[$classId . '_' . $headId]->amount : 0.00;
                        $calc      = $concession->calculateFee($stdAmount);

                        $modalData = [
                            'id'             => $concession->id,
                            'student_id'     => $concession->student->student_id ?? '',
                            'student_name'   => $concession->student->name ?? '',
                            'student_photo'  => $concession->student->photo ? asset($concession->student->photo) : asset('assets/images/profile.webp'),
                            'class_name'     => $concession->student->class->name ?? '—',
                            'section_name'   => $concession->student->section->name ?? '—',
                            'roll'           => $concession->student->roll ?? '—',
                            'fee_head_id'    => $concession->fee_head_id,
                            'fee_head_name'  => $concession->feeHead->name ?? '',
                            'standard_amount'=> $stdAmount,
                            'discount_type'  => $concession->discount_type,
                            'discount_value' => $concession->discount_type == 'percentage'
                                ? $concession->discount_percent
                                : ($concession->discount_type == 'custom_fee' ? $concession->custom_amount : $concession->discount_amount),
                            'note'       => $concession->note,
                            'is_active'  => $concession->is_active,
                            'update_url' => route('student-fee-concessions.update', ['tenant' => auth()->user()->school->slug, 'student_fee_concession' => $concession->id])
                        ];

                    @endphp
                    <tr class="conc-row">

                        {{-- Student --}}
                        <td class="text-nowrap">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ !empty($concession->student->photo) ? asset($concession->student->photo) : asset('assets/images/profile.webp') }}"
                                     alt="{{ $concession->student->name ?? 'Student' }}"
                                     class="conc-avatar-img"
                                     onerror="this.onerror=null;this.src='{{ asset('assets/images/profile.webp') }}';">
                                <div style="min-width: 0;">
                                    <div class="conc-student-name">{{ $concession->student->name ?? 'N/A' }}</div>
                                    <span class="conc-student-id">{{ $concession->student->student_id ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Class & Section --}}
                        <td>
                            <div class="conc-class-name">{{ $concession->student->class->name ?? 'N/A' }}</div>
                            <div class="conc-section-info">
                                Sec: {{ $concession->student->section->name ?? 'N/A' }}
                                &bull; Roll: {{ $concession->student->roll ?? 'N/A' }}
                            </div>
                        </td>

                        {{-- Fee Head --}}
                        <td>
                            <span class="conc-fee-head">{{ $concession->feeHead->name ?? 'N/A' }}</span>
                        </td>

                        {{-- Standard Fee --}}
                        <td>
                            <span class="conc-std-fee">৳ {{ number_format($stdAmount, 0) }}</span>
                        </td>

                        {{-- Reduction Rule --}}
                        <td>
                            @if($concession->discount_type == 'percentage')
                                <span class="conc-badge conc-badge-percent">
                                    <i class="fa-solid fa-percent"></i>
                                    {{ round($concession->discount_percent) }}% Off
                                </span>
                            @elseif($concession->discount_type == 'fixed_amount')
                                <span class="conc-badge conc-badge-fixed">
                                    <i class="fa-solid fa-minus"></i>
                                    ৳ {{ number_format($concession->discount_amount, 0) }} Off
                                </span>
                            @else
                                <span class="conc-badge conc-badge-custom">
                                    <i class="fa-solid fa-tag"></i>
                                    Fixed ৳ {{ number_format($concession->custom_amount, 0) }}
                                </span>
                            @endif
                        </td>

                        {{-- Net Fee --}}
                        <td>
                            <div class="conc-net-fee">
                                <span class="conc-net-currency">৳</span>
                                {{ number_format($calc['final_amount'], 0) }}
                            </div>
                        </td>

                        {{-- Reason --}}
                        <td>
                            @if($concession->note)
                                <span class="conc-reason" title="{{ $concession->note }}">{{ $concession->note }}</span>
                            @else
                                <span class="conc-reason-empty">—</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($concession->is_active)
                                <span class="conc-status-active">
                                    <i class="fa-solid fa-circle-check"></i> Active
                                </span>
                            @else
                                <span class="conc-status-inactive">
                                    <i class="fa-solid fa-circle-xmark"></i> Inactive
                                </span>
                            @endif
                        </td>

                        {{-- Action --}}
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center gap-1">
                                <button type="button"
                                        class="conc-btn-edit"
                                        onclick="openEditConcessionModal({{ json_encode($modalData) }})"
                                        title="{{ __('Edit Concession') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('student-fee-concessions.destroy', ['tenant' => auth()->user()->school->slug, 'student_fee_concession' => $concession->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to remove this concession?');"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="conc-btn-del" title="{{ __('Delete') }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="conc-empty-state">
                                <div class="conc-empty-icon">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">{{ __('No concessions configured yet') }}</h6>
                                <p class="text-muted small mb-0">{{ __('Use the student search box above to add fee concessions.') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($concessionsList->hasPages())
        <div class="px-4 py-3 border-top d-flex justify-content-center" style="border-color:#f1f5f9 !important;">
            {{ $concessionsList->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>

    {{-- TABLE & CARD STYLES --}}
    <style>
    /* ═════════════════════════════════════════════════════════════
       UPPER TWO CARDS: SELECT STUDENT & CONFIGURE CONCESSIONS
    ══════════════════════════════════════════════════════════════ */
    .conc-card-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(79,70,229,.06);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s;
    }
    .conc-card-header {
        padding: 18px 22px;
        background: linear-gradient(135deg, #fafbff 0%, #f1f5ff 100%);
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .conc-card-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .conc-icon-indigo {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        box-shadow: 0 4px 12px rgba(79,70,229,0.25);
    }
    .conc-icon-sky {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        box-shadow: 0 4px 12px rgba(14,165,233,0.25);
    }
    .conc-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        line-height: 1.2;
    }
    .conc-card-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }
    .conc-form-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #475569;
        display: block;
        margin-bottom: 6px;
    }

    /* ── Search Input Box ── */
    .conc-search-box {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        padding: 4px 4px 4px 14px;
        transition: all .2s ease;
    }
    .conc-search-box:focus-within {
        background: #fff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79,70,229,0.12);
    }
    .conc-search-prefix {
        color: #94a3b8;
        font-size: 14px;
        margin-right: 10px;
        display: flex;
        align-items: center;
    }
    .conc-search-input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        min-width: 0;
    }
    .conc-search-input::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }
    .conc-search-btn {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all .2s ease;
        box-shadow: 0 2px 8px rgba(79,70,229,0.25);
    }
    .conc-search-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(79,70,229,0.35);
        color: #fff;
    }

    /* ── Left Student Profile Card ── */
    .conc-student-profile-card {
        background: linear-gradient(135deg, #f8faff 0%, #eef2ff 100%);
        border: 1px solid #c7d2fe;
        border-radius: 16px;
        padding: 16px;
        margin-top: 14px;
    }
    .conc-profile-avatar {
        width: 50px; height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2.5px solid #fff;
        box-shadow: 0 4px 12px rgba(79,70,229,0.18);
        flex-shrink: 0;
    }
    .conc-student-id-pill {
        background: #4f46e5;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 20px;
        letter-spacing: 0.3px;
    }
    .conc-profile-status {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #86efac;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    .conc-profile-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    .conc-profile-info-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 10px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .conc-info-lbl {
        font-size: 10.5px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
    }
    .conc-info-val {
        font-size: 12.5px;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .conc-clear-student-link {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        transition: color .15s;
    }
    .conc-clear-student-link:hover {
        color: #ef4444;
    }

    /* ── Left Card Empty State ── */
    .conc-search-empty-state {
        text-align: center;
        padding: 36px 16px;
    }
    .conc-search-empty-icon {
        width: 68px; height: 68px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4f46e5;
        font-size: 28px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        border: 2px dashed #c7d2fe;
    }
    .conc-search-empty-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .conc-search-empty-desc {
        font-size: 12px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 14px;
    }
    .conc-hint-badge {
        display: inline-flex;
        align-items: center;
        font-size: 11px;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 5px 12px;
        border-radius: 20px;
    }

    /* ── Right Card Header Student Tag ── */
    .conc-header-student-tag {
        background: #eef2ff;
        color: #4f46e5;
        border: 1px solid #c7d2fe;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
    }

    /* ── Right Card Table & Form ── */
    .conc-form-table-wrap {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
    }
    .conc-form-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .conc-form-table thead tr th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #64748b;
        padding: 12px 14px;
        white-space: nowrap;
    }
    .conc-form-table tbody tr td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .conc-form-table tbody tr:last-child td {
        border-bottom: none;
    }
    .conc-active-pill {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        color: #15803d;
        background: #dcfce7;
        border: 1px solid #86efac;
        padding: 1px 7px;
        border-radius: 12px;
        margin-top: 2px;
    }
    .conc-std-pill {
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 14px;
        white-space: nowrap;
    }
    .conc-select-modern {
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        color: #1e293b;
        padding: 6px 10px;
        transition: all .2s;
    }
    .conc-select-modern:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
    }
    .conc-input-modern {
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        padding: 6px 12px;
        transition: all .2s;
    }
    .conc-input-modern:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        background: #fff;
    }
    .conc-net-val {
        font-size: 14px;
        font-weight: 800;
        color: #059669;
        white-space: nowrap;
    }
    .conc-checkbox-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
    }
    .conc-btn-reset {
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all .15s;
    }
    .conc-btn-reset:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    .conc-btn-save {
        padding: 9px 22px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        border: none;
        box-shadow: 0 3px 12px rgba(79,70,229,0.25);
        transition: all .2s;
        display: inline-flex;
        align-items: center;
    }
    .conc-btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 18px rgba(79,70,229,0.35);
        color: #fff;
    }

    /* ── Right Card Empty State ── */
    .conc-config-empty {
        text-align: center;
        padding: 32px 16px;
    }
    .conc-config-empty-icon-wrap {
        display: flex;
        justify-content: center;
        margin-bottom: 14px;
    }
    .conc-config-empty-icon {
        width: 70px; height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        color: #0284c7;
        font-size: 28px;
        display: flex; align-items: center; justify-content: center;
        border: 2px dashed #7dd3fc;
    }
    .conc-config-empty-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .conc-config-empty-desc {
        font-size: 12.5px;
        color: #64748b;
        max-width: 540px;
        margin: 0 auto 24px;
        line-height: 1.5;
    }
    .conc-features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        max-width: 680px;
        margin: 0 auto;
    }
    .conc-feature-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-align: left;
        transition: all .2s;
    }
    .conc-feature-pill:hover {
        transform: translateY(-2px);
        background: #fff;
        border-color: #cbd5e1;
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
    }
    .conc-feat-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .feat-amber  { background: #fef3c7; color: #b45309; }
    .feat-red    { background: #fee2e2; color: #b91c1c; }
    .feat-purple { background: #ede9fe; color: #6d28d9; }
    .conc-feat-title {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
    }
    .conc-feat-sub {
        font-size: 10.5px;
        color: #94a3b8;
        margin-top: 2px;
    }
    @media (max-width: 767.98px) {
        .conc-features-grid { grid-template-columns: 1fr; }
    }

    /* ── Table Wrapper ── */
    .conc-table-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(79,70,229,.06);
    }

    /* ── Header ── */
    .conc-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px;
        background: linear-gradient(135deg, #fafbff 0%, #f1f5ff 100%);
        border-bottom: 1px solid #e2e8f0;
    }
    .conc-header-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #4f46e5, #818cf8);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .conc-record-badge {
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4f46e5;
        font-weight: 700;
        font-size: 12px;
        padding: 6px 14px;
        border-radius: 20px;
        border: 1px solid #c7d2fe;
    }

    /* ── Table Base ── */
    .conc-table {
        width: 100%;
        min-width: 980px;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* ── Thead ── */
    .conc-table thead tr th {
        padding: 13px 14px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .conc-table thead tr th:first-child { padding-left: 24px; }
    .conc-table thead tr th:last-child  { padding-right: 24px; }

    /* ── Body Rows ── */
    .conc-row td {
        padding: 14px 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        transition: background .15s;
    }
    .conc-row td:first-child { padding-left: 24px; }
    .conc-row td:last-child  { padding-right: 24px; }
    .conc-row:last-child td  { border-bottom: none; }
    .conc-row:hover td       { background: #f8faff; }

    /* ── Student Avatar ── */
    .conc-avatar-img {
        width: 38px; height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e0e7ff;
        flex-shrink: 0;
    }
    .conc-avatar-init {
        width: 38px; height: 38px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        font-weight: 800;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: 0;
    }
    .conc-student-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
        white-space: nowrap;
    }
    .conc-student-id {
        display: inline-block;
        margin-top: 3px;
        font-size: 10.5px;
        font-weight: 600;
        color: #4f46e5;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
        border-radius: 20px;
        padding: 1px 9px;
        white-space: nowrap;
        letter-spacing: 0.3px;
    }

    /* ── Class / Section ── */
    .conc-class-name   { font-size: 13px; font-weight: 700; color: #1e293b; white-space: nowrap; }
    .conc-section-info { font-size: 11px; color: #94a3b8; margin-top: 2px; white-space: nowrap; }

    /* ── Fee Head ── */
    .conc-fee-head {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        white-space: nowrap;
    }

    /* ── Standard Fee ── */
    .conc-std-fee {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
    }

    /* ── Discount Badges ── */
    .conc-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 700;
        padding: 5px 11px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .conc-badge-percent {
        background: linear-gradient(135deg, #fef9c3, #fef3c7);
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .conc-badge-fixed {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #b91c1c;
        border: 1px solid #fca5a5;
    }
    .conc-badge-custom {
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        color: #5b21b6;
        border: 1px solid #c4b5fd;
    }

    /* ── Net Fee ── */
    .conc-net-fee {
        display: inline-flex;
        align-items: baseline;
        gap: 2px;
        font-size: 14px;
        font-weight: 800;
        color: #059669;
    }
    .conc-net-currency {
        font-size: 11px;
        font-weight: 700;
        color: #10b981;
    }

    /* ── Reason ── */
    .conc-reason {
        font-size: 12px;
        color: #475569;
        max-width: 120px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .conc-reason-empty { color: #cbd5e1; font-size: 13px; }

    /* ── Status Pills ── */
    .conc-status-active, .conc-status-inactive {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .conc-status-active {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #15803d;
        border: 1px solid #86efac;
        box-shadow: 0 0 8px rgba(34,197,94,.15);
    }
    .conc-status-inactive {
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
    }

    /* ── Action Buttons ── */
    .conc-btn-edit, .conc-btn-del {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all .2s;
    }
    .conc-btn-edit {
        background: #eff6ff;
        color: #3b82f6;
        border: 1px solid #bfdbfe;
    }
    .conc-btn-edit:hover {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(59,130,246,.3);
    }
    .conc-btn-del {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
    }
    .conc-btn-del:hover {
        background: #ef4444;
        color: #fff;
        border-color: #ef4444;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(239,68,68,.3);
    }

    /* ── Empty State ── */
    .conc-empty-state { padding: 20px 0; }
    .conc-empty-icon {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 26px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
    }

    /* ── Dark mode ── */
    body.dark-mode .conc-card-wrap { background: #0c1427; border-color: #1a253b; }
    body.dark-mode .conc-card-header { background: linear-gradient(135deg,#0c1427,#111d35); border-color: #1a253b; }
    body.dark-mode .conc-card-title { color: #f1f5f9; }
    body.dark-mode .conc-search-box { background: #0f1c35; border-color: #243452; }
    body.dark-mode .conc-search-input { color: #f1f5f9; }
    body.dark-mode .conc-search-empty-icon { background: #111d35; border-color: #243452; }
    body.dark-mode .conc-search-empty-title { color: #f1f5f9; }
    body.dark-mode .conc-config-empty-title { color: #f1f5f9; }
    body.dark-mode .conc-form-table-wrap { background: #0c1427; border-color: #1a253b; }
    body.dark-mode .conc-form-table thead tr th { background: #0d1630; border-color: #1a253b; color: #64748b; }
    body.dark-mode .conc-form-table tbody tr td { border-color: #1a253b; }
    body.dark-mode .conc-select-modern, body.dark-mode .conc-input-modern { background: #0f1c35; border-color: #243452; color: #f1f5f9; }
    body.dark-mode .conc-feature-pill { background: #0f1c35; border-color: #1a253b; }
    body.dark-mode .conc-feat-title { color: #f1f5f9; }
    body.dark-mode .conc-table-wrap { background: #0c1427; border-color: #1a253b; }
    body.dark-mode .conc-table-header { background: linear-gradient(135deg,#0c1427,#111d35); border-color: #1a253b; }
    body.dark-mode .conc-table thead tr th { background: #0d1630; color: #64748b; border-color: #1a253b; }
    body.dark-mode .conc-row td { border-color: #1a253b; }
    body.dark-mode .conc-row:hover td { background: #0f1c35; }
    body.dark-mode .conc-student-name, body.dark-mode .conc-class-name, body.dark-mode .conc-fee-head { color: #e2e8f0; }
    </style>


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
                            <input type="number" step="1" min="0" name="discount_value" id="modal_discount_value" 
                                   class="form-control form-control-modern" placeholder="0" required oninput="recalculateEditModal()">
                        </div>
                    </div>

                    {{-- Net Fee Preview Badge --}}
                    <div class="d-flex justify-content-between align-items-center p-3 mb-3 rounded-3 bg-white border" style="border-color: #cbd5e1 !important;">
                        <span class="fw-semibold text-dark small"><i class="fa-solid fa-calculator text-primary me-1"></i>{{ __('Calculated Net Fee') }}:</span>
                        <strong class="text-primary fs-5" id="modal_net_fee_preview">৳ 0</strong>
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
        
        row.querySelector('.row-net-fee').innerText = '৳ ' + Math.round(net);
    }

    function openEditConcessionModal(data) {
        document.getElementById('editConcessionForm').action = data.update_url;
        document.getElementById('modal_student_photo').src = data.student_photo;
        document.getElementById('modal_student_name').innerText = data.student_name;
        document.getElementById('modal_student_id').innerText = data.student_id;
        document.getElementById('modal_student_details').innerText = `Class: ${data.class_name} | Sec: ${data.section_name} | Roll: ${data.roll}`;
        document.getElementById('modal_fee_head_name').innerText = data.fee_head_name;
        document.getElementById('modal_standard_amount').innerText = '৳ ' + Math.round(parseFloat(data.standard_amount) || 0);
        document.getElementById('modal_standard_raw').value = data.standard_amount;
        
        document.getElementById('modal_discount_type').value = data.discount_type;
        document.getElementById('modal_discount_value').value = data.discount_value ? Math.round(data.discount_value) : '';
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

        document.getElementById('modal_net_fee_preview').innerText = '৳ ' + Math.round(net);
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
