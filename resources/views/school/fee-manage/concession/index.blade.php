@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .concession-hero {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 50%, #4f46e5 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .concession-hero::before {
            content:''; position:absolute; top:-40px; right:-40px;
            width:180px; height:180px; background:rgba(255,255,255,0.08); border-radius:50%;
        }
        .search-card-glow {
            background: #fff;
            border-radius: 16px;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(15,23,42,0.06);
            padding: 20px;
        }
        .stat-mini-card {
            border-radius: 16px;
            padding: 16px 20px;
            background: #fff;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 12px rgba(15,23,42,0.04);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-mini-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .concession-table th {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .5px;
            background: #f8fafc;
            padding: 12px 16px;
            border-bottom: 2px solid #f1f5f9;
        }
        .concession-table td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f8fafc;
            font-size: 13px;
        }
        .badge-discount-percent {
            background: #fef3c7; color: #d97706; font-weight: 700;
            padding: 4px 10px; border-radius: 50px; font-size: 11px;
        }
        .badge-discount-fixed {
            background: #fee2e2; color: #dc2626; font-weight: 700;
            padding: 4px 10px; border-radius: 50px; font-size: 11px;
        }
        .badge-discount-custom {
            background: #e0e7ff; color: #4338ca; font-weight: 700;
            padding: 4px 10px; border-radius: 50px; font-size: 11px;
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ══ HERO HEADER ══ --}}
    <div class="concession-hero">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3" style="position:relative;z-index:1;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,0.3);">
                    <i class="fa-solid fa-tags text-white" style="font-size:20px;"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1">{{ __('Student Fee Concessions (মাইনাস ফি ব্যবস্থাপনা)') }}</h4>
                    <p class="mb-0" style="color:rgba(255,255,255,0.8);font-size:13px;">
                        {{ __('Set customized fee reductions, percentage discounts, or fixed minus fees per student ID') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" 
               class="btn" style="background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);color:#fff;border:1px solid rgba(255,255,255,0.4);border-radius:12px;font-weight:600;padding:10px 20px;">
                <i class="fa-solid fa-hand-holding-dollar me-2"></i>{{ __('Go to Fee Collection') }}
            </a>
        </div>
    </div>

    {{-- ══ STATS SUMMARY ══ --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="stat-mini-card">
                <div class="stat-mini-icon" style="background:#eff6ff;color:#2563eb;">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;">{{ __('Discounted Students') }}</div>
                    <div style="font-size:22px;font-weight:800;color:#1e293b;">{{ $totalDiscountedStudents }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="stat-mini-card">
                <div class="stat-mini-icon" style="background:#fef3c7;color:#d97706;">
                    <i class="fa-solid fa-percent"></i>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;">{{ __('Active Concessions') }}</div>
                    <div style="font-size:22px;font-weight:800;color:#1e293b;">{{ $activeConcessionsCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="stat-mini-card">
                <div class="stat-mini-icon" style="background:#f0fdf4;color:#16a34a;">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;font-weight:600;text-transform:uppercase;">{{ __('Total Discount Given (All-time)') }}</div>
                    <div style="font-size:22px;font-weight:800;color:#16a34a;">৳ {{ number_format($totalDiscountAmountGiven, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ SEARCH & CONCESSION SETUP ══ --}}
    <div class="row g-4 mb-4">
        {{-- Left: Search Student --}}
        <div class="col-lg-4">
            <div class="card search-card-glow h-100">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-magnifying-glass me-2 text-primary"></i>{{ __('Select Student') }}
                </h5>
                <form action="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET" class="mb-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">{{ __('Student ID / Roll') }}</label>
                        <div class="input-group">
                            <input type="text" name="student_id" class="form-control form-control-lg" 
                                   placeholder="e.g. STD-26011001" 
                                   value="{{ request('student_id') }}" required>
                            <button class="btn btn-primary px-3" type="submit">
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>

                @if($student)
                <div style="background:#f8fafc;border-radius:14px;padding:16px;border:1px solid #e2e8f0;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}" 
                             alt="{{ $student->name }}" 
                             style="width:54px;height:54px;border-radius:50%;object-fit:cover;border:2px solid #3b82f6;">
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $student->name }}</h6>
                            <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size:11px;">{{ $student->student_id }}</span>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2" style="font-size:12.5px;">
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
                    <i class="fa-regular fa-id-card fa-3x mb-2 opacity-50"></i>
                    <p class="small mb-0">{{ __('Enter a Student ID above to configure minus fee or discount.') }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Right: Concession Form --}}
        <div class="col-lg-8">
            <div class="card search-card-glow h-100">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-sliders me-2 text-primary"></i>{{ __('Configure Minus Fee / Discount') }}
                </h5>

                @if($student)
                <form action="{{ route('student-fee-concessions.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                    <div class="table-responsive mb-3">
                        <table class="table align-middle">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th class="py-2 fw-bold text-muted small">{{ __('Fee Head') }}</th>
                                    <th class="py-2 fw-bold text-muted small">{{ __('Standard Fee') }}</th>
                                    <th class="py-2 fw-bold text-muted small" style="width:160px;">{{ __('Discount Type') }}</th>
                                    <th class="py-2 fw-bold text-muted small" style="width:120px;">{{ __('Reduction (৳ / %)') }}</th>
                                    <th class="py-2 fw-bold text-muted small text-end">{{ __('Net Fee') }}</th>
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
                                    <td>
                                        <div class="fw-bold text-dark">{{ $feeHead->name }}</div>
                                        @if($existing)
                                            <span class="badge bg-success-subtle text-success" style="font-size:10px;">{{ __('Active Concession') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold text-secondary">৳ {{ number_format($stdFee, 2) }}</span>
                                    </td>
                                    <td>
                                        <select name="concessions[{{ $feeHead->id }}][discount_type]" class="form-select form-select-sm row-discount-type" onchange="recalculateRow(this)">
                                            <option value="fixed_amount" {{ $currentType == 'fixed_amount' ? 'selected' : '' }}>৳ Fixed Minus</option>
                                            <option value="percentage" {{ $currentType == 'percentage' ? 'selected' : '' }}>% Percentage Off</option>
                                            <option value="custom_fee" {{ $currentType == 'custom_fee' ? 'selected' : '' }}>Fixed Custom Fee</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" min="0" 
                                               name="concessions[{{ $feeHead->id }}][discount_value]" 
                                               class="form-control form-control-sm row-discount-value" 
                                               value="{{ $currentVal > 0 ? $currentVal : '' }}"
                                               placeholder="0.00"
                                               oninput="recalculateRow(this)">
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-primary row-net-fee">৳ {{ number_format($stdFee, 2) }}</span>
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
                            <label class="form-label text-muted small fw-semibold">{{ __('Reason / Note (Optional)') }}</label>
                            <input type="text" name="reason" class="form-control form-control-sm" placeholder="e.g. Merit scholarship / Sibling discount / Principal approval">
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
                        <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-light btn-sm px-3">
                            {{ __('Reset') }}
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
                            <i class="fa-solid fa-floppy-disk me-1"></i> {{ __('Save Concession Settings') }}
                        </button>
                    </div>
                </form>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-user-tag fa-3x mb-3 text-secondary opacity-50"></i>
                    <h6>{{ __('Search a student on the left to set fee reductions') }}</h6>
                    <p class="small text-muted mb-0">{{ __('You can set custom minus fee, percentage discount, or flat reduced amount for Tuition, Exam, Admission and all fee heads.') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══ ACTIVE CONCESSIONS TABLE ══ --}}
    <div class="card search-card-glow">
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-list-check me-2 text-primary"></i>{{ __('Active Student Concessions List') }}
                </h5>
                <span class="text-muted small">{{ __('All students with configured minus fee / discount rates') }}</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle concession-table mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Student ID & Name') }}</th>
                        <th>{{ __('Class & Section') }}</th>
                        <th>{{ __('Fee Head') }}</th>
                        <th>{{ __('Standard Fee') }}</th>
                        <th>{{ __('Reduction Rule') }}</th>
                        <th>{{ __('Net Fee') }}</th>
                        <th>{{ __('Reason') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-end">{{ __('Action') }}</th>
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
                        <td>
                            <div class="fw-bold text-dark">{{ $concession->student->name ?? 'N/A' }}</div>
                            <span class="badge bg-light text-secondary border" style="font-size:11px;">{{ $concession->student->student_id ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $concession->student->class->name ?? 'N/A' }}</div>
                            <small class="text-muted">Sec: {{ $concession->student->section->name ?? 'N/A' }} | Roll: {{ $concession->student->roll ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">{{ $concession->feeHead->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="fw-semibold text-secondary">৳ {{ number_format($stdAmount, 2) }}</span>
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
                            <strong class="text-primary">৳ {{ number_format($calc['final_amount'], 2) }}</strong>
                        </td>
                        <td>
                            <small class="text-muted">{{ $concession->note ?? '—' }}</small>
                        </td>
                        <td>
                            @if($concession->is_active)
                                <span class="badge bg-success-subtle text-success fw-bold">{{ __('Active') }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1 align-items-center">
                                {{-- Edit Modal Button --}}
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary" 
                                        onclick="openEditConcessionModal({{ json_encode($modalData) }})" 
                                        title="{{ __('Edit Concession') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                {{-- Quick Load in Top Setup Configurator --}}
                                <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug, 'student_id' => $concession->student->student_id]) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="{{ __('Configure in Main Panel') }}">
                                    <i class="fa-solid fa-sliders"></i>
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('student-fee-concessions.destroy', ['tenant' => auth()->user()->school->slug, 'student_fee_concession' => $concession->id]) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to remove this concession?');" 
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('Delete') }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="fa-regular fa-folder-open fa-2x mb-2 opacity-50"></i>
                            <p class="mb-0">{{ __('No student fee concessions configured yet.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($concessionsList->hasPages())
        <div class="px-3 py-3 border-top">
            {{ $concessionsList->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ══ EDIT CONCESSION MODAL ══ --}}
<div class="modal fade" id="editConcessionModal" tabindex="-1" aria-labelledby="editConcessionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px; border:none; box-shadow:0 10px 40px rgba(15,23,42,0.15);">
            <div class="modal-header bg-light border-0 py-3 px-4" style="border-radius:18px 18px 0 0;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:36px;height:36px;border-radius:10px;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-dark mb-0" id="editConcessionModalLabel">{{ __('Edit Fee Concession (ফি ছাড় সম্পাদনা)') }}</h6>
                        <small class="text-muted">{{ __('Update discount rate or concession rules') }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editConcessionForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    {{-- Student & Fee Head Card --}}
                    <div class="p-3 rounded-3 mb-3 border" style="background:#f8fafc;">
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
                            <label class="form-label fw-semibold text-muted small">{{ __('Discount Type') }} <span class="text-danger">*</span></label>
                            <select name="discount_type" id="modal_discount_type" class="form-select form-select-sm" onchange="recalculateEditModal()">
                                <option value="fixed_amount">৳ Fixed Minus Amount</option>
                                <option value="percentage">% Percentage Off</option>
                                <option value="custom_fee">Fixed Custom Fee</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small">{{ __('Reduction Value (৳ / %)') }} <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="discount_value" id="modal_discount_value" 
                                   class="form-control form-control-sm" placeholder="0.00" required oninput="recalculateEditModal()">
                        </div>
                    </div>

                    {{-- Net Fee Preview Badge --}}
                    <div class="d-flex justify-content-between align-items-center p-2 mb-3 rounded-3" style="background:#eef2ff; border:1px dashed #6366f1;">
                        <span class="fw-semibold text-dark small"><i class="fa-solid fa-calculator text-primary me-1"></i>{{ __('Calculated Net Fee') }}:</span>
                        <strong class="text-primary fs-6" id="modal_net_fee_preview">৳ 0.00</strong>
                    </div>

                    {{-- Reason / Note --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">{{ __('Reason / Note') }}</label>
                        <input type="text" name="note" id="modal_note" class="form-control form-control-sm" placeholder="e.g. Merit scholarship / Sibling discount">
                    </div>

                    {{-- Status Toggle & Apply to Unpaid --}}
                    <div class="d-flex flex-column gap-2 p-2 rounded-2 bg-light">
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
                
                <div class="modal-footer border-0 bg-light py-3 px-4" style="border-radius:0 0 18px 18px;">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
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

    // Initialize all rows on load
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
