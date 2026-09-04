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

        /* Hero Search Field */
        .search-input-premium {
            background: rgba(255,255,255,0.18) !important;
            border: 1.5px solid rgba(255,255,255,0.35) !important;
            border-radius: 12px !important;
            color: #fff !important;
            padding: 12px 20px !important;
            font-size: 15px !important;
            font-weight: 500;
            backdrop-filter: blur(8px);
            transition: all .2s;
        }
        .search-input-premium::placeholder { color: rgba(255,255,255,0.7) !important; }
        .search-input-premium:focus {
            background: rgba(255,255,255,0.25) !important;
            border-color: rgba(255,255,255,0.7) !important;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.2) !important;
            outline: none;
        }
        .btn-search-hero {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(8px);
            color: #fff;
            border: 1.5px solid rgba(255,255,255,0.4);
            border-radius: 12px;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-search-hero:hover {
            background: rgba(255,255,255,0.35);
            color: #fff;
            transform: translateY(-1px);
        }

        /* Student Profile Card */
        .student-profile-premium {
            border-radius: 20px;
            overflow: hidden;
            border: 1.5px solid #e2e8f0;
            box-shadow: var(--card-shadow);
        }
        .profile-hero-bg {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 24px 20px;
            text-align: center;
            position: relative;
        }
        .profile-avatar-ring {
            width: 86px; height: 86px; border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.5);
            box-shadow: 0 0 0 4px rgba(79,70,229,0.35);
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; }
        .info-value { font-size: 13px; font-weight: 700; color: #1e293b; text-align: right; }

        /* Action & Fee Styles */
        .fee-checkbox-custom {
            width: 18px; height: 18px; border-radius: 6px !important;
            border: 2px solid #cbd5e1 !important; cursor: pointer;
        }
        .fee-checkbox-custom:checked { background-color: #4f46e5 !important; border-color: #4f46e5 !important; }

        .total-amount-display {
            font-size: 24px; font-weight: 800; color: #ef4444; font-variant-numeric: tabular-nums;
        }
        .select-method {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 9px 14px !important;
            font-size: 13px; font-weight: 600;
            background: #fff;
        }
        .btn-collect {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; border: none; border-radius: 12px;
            padding: 10px 24px; font-size: 14px; font-weight: 700;
            box-shadow: 0 4px 14px rgba(16,185,129,0.35);
            transition: all .25s; cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-collect:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(16,185,129,0.45); color:#fff; }

        .receipt-badge {
            background: #f0fdf4;
            color: #16a34a !important;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex; align-items: center; justify-content: center; gap: 5px;
            text-decoration: none;
            transition: all .2s;
        }
        .receipt-badge:hover {
            background: #16a34a;
            color: #fff !important;
            transform: translateY(-1px);
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
         HERO SEARCH & HEADER CARD (Matches Exam Page Header Exactly)
    ══════════════════════════════════════════════════════════════ --}}
    <div class="page-header-card">
        <div class="page-header-content">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon">
                        <i class="fa-solid fa-hand-holding-dollar text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ __('Fee Collection (ফি সংগ্রহ ও রসিদ প্রদান)') }}</h4>
                        <p class="page-subtitle mb-0">
                            {{ __('Search student by ID, select pending dues, apply on-the-spot discount & print receipts') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-secondary">
                        <i class="fa-solid fa-tags"></i> {{ __('Fee Concessions') }}
                    </a>
                    <a href="{{ route('student-fees.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-primary">
                        <i class="fa-solid fa-bolt"></i> {{ __('Generate Bills') }}
                    </a>
                </div>
            </div>

            {{-- Quick Search Form inside Hero Header --}}
            <form action="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET" class="mt-3">
                <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-3">
                    <div class="flex-grow-1 position-relative">
                        <i class="fa-solid fa-id-card position-absolute" style="left:16px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.7);font-size:16px;"></i>
                        <input type="text" name="student_id" class="form-control search-input-premium ps-5"
                               placeholder="{{ __('Enter Student ID (e.g. STD-26011001)') }}"
                               value="{{ request('student_id') }}" required>
                    </div>
                    <button type="submit" class="btn-search-hero">
                        <i class="fa-solid fa-magnifying-glass"></i> {{ __('Find Student') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($student)
    <div class="row g-3 g-lg-4">

        {{-- ── Student Profile Card ── --}}
        <div class="col-lg-4">
            <div class="student-profile-premium card h-100">
                <div class="profile-hero-bg">
                    <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"
                         alt="{{ $student->name }}" class="profile-avatar-ring mb-3">
                    <h5 class="text-white fw-bold mb-1 fs-16">{{ $student->name }}</h5>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <span style="background:rgba(79,70,229,0.4);color:#c4b5fd;font-size:11px;font-weight:700;padding:3px 12px;border-radius:50px;border:1px solid rgba(79,70,229,0.4);">
                            <i class="fa-solid fa-id-badge me-1 opacity-75"></i>{{ $student->student_id }}
                        </span>
                        @if($student->status == 'active')
                        <span style="background:rgba(16,185,129,0.3);color:#6ee7b7;font-size:11px;font-weight:700;padding:3px 12px;border-radius:50px;border:1px solid rgba(16,185,129,0.4);">
                            <i class="fa-solid fa-circle me-1" style="font-size:7px;"></i>Active
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-body px-3 px-sm-4 py-3">
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-graduation-cap me-2" style="color:#4f46e5;"></i>{{ __('Class') }}</span>
                        <span class="info-value">{{ $student->class->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-layer-group me-2" style="color:#7c3aed;"></i>{{ __('Section') }}</span>
                        <span class="info-value">{{ $student->section->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-hashtag me-2" style="color:#0ea5e9;"></i>{{ __('Roll') }}</span>
                        <span class="info-value" style="color:#4f46e5;">{{ $student->roll ?? 'N/A' }}</span>
                    </div>
                    @if($student->fathers_name)
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-user-shield me-2" style="color:#10b981;"></i>{{ __('Guardian') }}</span>
                        <span class="info-value">{{ $student->fathers_name }}</span>
                    </div>
                    @endif
                    @if($student->contact_number)
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-phone me-2" style="color:#f59e0b;"></i>{{ __('Phone') }}</span>
                        <span class="info-value">{{ $student->contact_number }}</span>
                    </div>
                    @endif
                </div>
                <div class="px-3 px-sm-4 pb-3 pb-sm-4">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div style="background:linear-gradient(135deg,#fff1f2,#ffe4e6);border-radius:12px;padding:12px;text-align:center;">
                                <div style="font-size:20px;font-weight:800;color:#ef4444;">{{ $unpaidFees->count() }}</div>
                                <div style="font-size:10px;color:#f87171;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">{{ __('Pending') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-radius:12px;padding:12px;text-align:center;">
                                <div style="font-size:20px;font-weight:800;color:#10b981;">{{ $paidFeesGroups ? $paidFeesGroups->count() : 0 }}</div>
                                <div style="font-size:10px;color:#6ee7b7;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">{{ __('Receipts') }}</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug, 'student_id' => $student->student_id]) }}" 
                       class="btn btn-outline-primary btn-sm w-100 fw-bold py-2 rounded-3">
                        <i class="fa-solid fa-tags me-1"></i> {{ __('মাইনাস ফি / Concession সেট করুন') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Right Panel: Collection Table & History ── --}}
        <div class="col-lg-8">

            {{-- Pending Fees Collection Card --}}
            <div class="data-table-card mb-4">
                <form action="{{ route('payment.collectMultiple', ['tenant' => auth()->user()->school->slug]) }}" method="POST" id="bulk-payment-form">
                    @csrf
                    <div class="data-table-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="form-card-icon" style="background: #fef2f2; color: #ef4444; width: 34px; height: 34px;">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ __('Pending Fees & Vouchers') }}</h6>
                                <small class="text-muted">{{ __('Select fee items to collect payment') }}</small>
                            </div>
                        </div>
                        <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-1 rounded-pill" style="font-size: 11.5px;">
                            {{ $unpaidFees->count() }} {{ __('Items Due') }}
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table modern-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4" style="width:44px;">
                                        <input class="form-check-input fee-checkbox-custom" type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                                    </th>
                                    <th>{{ __('Fee Head') }}</th>
                                    <th>{{ __('Month / Period') }}</th>
                                    <th class="text-end pe-4">{{ __('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($unpaidFees as $fee)
                                <tr>
                                    <td class="ps-4">
                                        <input class="form-check-input fee-checkbox-custom fee-checkbox" type="checkbox" name="fee_ids[]" value="{{ $fee->id }}" onclick="updateTotal()">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark fs-13">{{ $fee->feeHead->name }}</div>
                                        @if(($fee->discount_amount && $fee->discount_amount > 0) || ($fee->original_amount && $fee->original_amount > $fee->amount))
                                            <span class="badge bg-warning-subtle text-dark border px-2 py-0" style="font-size:10px;">
                                                <i class="fa-solid fa-tag me-1 text-warning"></i>পূর্ব নির্ধারিত ছাড়: ৳ {{ number_format($fee->discount_amount, 2) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill" style="font-size: 11px;">
                                            {{ $fee->month }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-danger fs-14" data-amount="{{ $fee->amount }}">
                                        @if($fee->original_amount && $fee->original_amount > $fee->amount)
                                            <small class="text-decoration-line-through text-muted me-1 fs-11">৳{{ number_format($fee->original_amount, 2) }}</small>
                                        @endif
                                        ৳ {{ number_format($fee->amount, 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div style="width:54px;height:54px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                            <i class="fa-solid fa-circle-check fs-4 text-success"></i>
                                        </div>
                                        <h6 class="fw-bold text-success mb-1">{{ __('All Dues Cleared!') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('No pending fees found for this student.') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Collection & Live Discount Controls Footer --}}
                    @if($unpaidFees->count() > 0)
                    <div class="p-3 bg-light border-top" style="border-color: #f1f5f9 !important;">
                        {{-- Discount Input Controls --}}
                        <div class="row g-3 align-items-center mb-3 p-3 bg-white rounded-3 border" style="border-color: #e2e8f0 !important;">
                            <div class="col-md-5">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fa-solid fa-percent text-primary me-1"></i>{{ __('কালেকশন ডিস্কাউন্ট / ছাড় (% বা ৳)') }}
                                </label>
                                <div class="input-group input-group-sm">
                                    <select name="discount_type" id="discount_type" class="form-select form-select-sm form-control-modern" style="max-width:110px;" onchange="updateTotal()">
                                        <option value="percent">% Percent</option>
                                        <option value="fixed">৳ Fixed</option>
                                    </select>
                                    <input type="number" step="0.01" min="0" name="discount_value" id="discount_value" 
                                           class="form-control form-control-sm form-control-modern" placeholder="e.g. 10" 
                                           oninput="updateTotal()">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label text-muted small fw-bold mb-1">{{ __('ছাড়ের বিবরণ / নোট (ঐচ্ছিক)') }}</label>
                                <input type="text" name="discount_note" class="form-control form-control-sm form-control-modern" placeholder="e.g. বিশেষ বিবেচনায় ১০% ছাড় প্রদান করা হলো">
                            </div>
                        </div>

                        {{-- Calculation & Action Bar --}}
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <div class="d-flex align-items-center gap-3 fs-13">
                                    <div>
                                        <span class="text-muted">{{ __('মোট ফি:') }}</span> 
                                        <strong class="text-dark">৳ <span id="gross-total-display">0.00</span></strong>
                                    </div>
                                    <div id="discount-breakdown-display" style="display:none;">
                                        <span class="text-danger fw-bold">{{ __('ছাড়:') }}</span> 
                                        <strong class="text-danger">- ৳ <span id="discount-amount-display">0.00</span> (<span id="discount-percent-display">0</span>%)</strong>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <span class="text-muted small fw-bold text-uppercase">{{ __('Net Payable') }}:</span>
                                    <span class="total-amount-display fs-4">৳ <span id="selected-total">0.00</span></span>
                                </div>
                            </div>

                            <div class="payment-footer-actions d-flex align-items-center gap-2 flex-wrap">
                                <select name="payment_method" class="form-select select-method form-control-modern">
                                    <option value="cash">💵 Cash</option>
                                    <option value="bkash">📱 bKash</option>
                                    <option value="nagad">📱 Nagad</option>
                                </select>
                                <button type="button" class="btn-collect" onclick="handleBulkPaymentClick(event)">
                                    <i class="fa-solid fa-check"></i>
                                    {{ __('Collect Payment') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>

            {{-- Payment History Card --}}
            @if($paidFeesGroups && $paidFeesGroups->count() > 0)
            <div class="data-table-card">
                <div class="data-table-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #f0fdf4; color: #16a34a; width: 34px; height: 34px;">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ __('Payment & Receipt History') }}</h6>
                            <small class="text-muted">{{ $paidFeesGroups->count() }} {{ __('receipt(s) available') }}</small>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table modern-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">{{ __('Description') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Method') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th class="text-center pe-4" style="width: 130px;">{{ __('Receipt') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paidFeesGroups as $receiptNo => $feesGroup)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark fs-13">{{ Str::limit($feesGroup->pluck('feeHead.name')->implode(', '), 30) }}</div>
                                    <small class="text-muted fs-11">{{ $feesGroup->pluck('month')->unique()->implode(', ') }}</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-success fs-14">৳ {{ number_format($feesGroup->sum('amount'), 2) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill" style="font-size: 11px; text-transform: uppercase;">
                                        {{ $feesGroup->first()->payment_method }}
                                    </span>
                                </td>
                                <td class="text-muted fs-12">{{ $feesGroup->first()->updated_at->format('d M, Y') }}</td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('payment.receiptMultiple', ['tenant' => auth()->user()->school->slug, 'receipt_no' => $receiptNo]) }}"
                                       class="receipt-badge">
                                        <i class="fa-solid fa-print"></i> {{ __('Receipt') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
    @else
    {{-- Empty State when no student is searched yet --}}
    <div class="data-table-card text-center py-5">
        <div class="py-4">
            <div style="width:72px;height:72px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fa-solid fa-user-check fs-2 text-primary"></i>
            </div>
            <h5 class="fw-bold text-dark">{{ __('Search Student to Start Fee Collection') }}</h5>
            <p class="text-muted small mb-0" style="max-width: 420px; margin: 0 auto;">
                {{ __('Enter a student ID in the search box above to view pending fees, apply discounts, and generate instant printable receipts.') }}
            </p>
        </div>
    </div>
    @endif

</div>
@endsection

@section('customJs')
<script>
    function toggleSelectAll(source) {
        document.querySelectorAll('.fee-checkbox').forEach(cb => cb.checked = source.checked);
        updateTotal();
    }

    function updateTotal() {
        let grossTotal = 0;
        document.querySelectorAll('.fee-checkbox:checked').forEach(cb => {
            grossTotal += parseFloat(cb.closest('tr').querySelector('td[data-amount]').getAttribute('data-amount')) || 0;
        });

        let grossElem = document.getElementById('gross-total-display');
        if (grossElem) grossElem.innerText = grossTotal.toFixed(2);

        let discountType = document.getElementById('discount_type') ? document.getElementById('discount_type').value : 'percent';
        let discountValue = document.getElementById('discount_value') ? (parseFloat(document.getElementById('discount_value').value) || 0) : 0;

        let discountAmount = 0;
        let discountPercent = 0;

        if (discountValue > 0 && grossTotal > 0) {
            if (discountType === 'percent') {
                discountPercent = Math.min(100, discountValue);
                discountAmount = (grossTotal * discountPercent) / 100;
            } else {
                discountAmount = Math.min(grossTotal, discountValue);
                discountPercent = (discountAmount / grossTotal) * 100;
            }
        }

        let netTotal = Math.max(0, grossTotal - discountAmount);

        let discountBox = document.getElementById('discount-breakdown-display');
        if (discountBox) {
            if (discountAmount > 0) {
                discountBox.style.display = 'block';
                document.getElementById('discount-amount-display').innerText = discountAmount.toFixed(2);
                document.getElementById('discount-percent-display').innerText = discountPercent.toFixed(1);
            } else {
                discountBox.style.display = 'none';
            }
        }

        let selectedTotalElem = document.getElementById('selected-total');
        if (selectedTotalElem) {
            selectedTotalElem.innerText = netTotal.toFixed(2);
        }
    }

    function handleBulkPaymentClick(event) {
        event.preventDefault();
        let selectedCount = document.querySelectorAll('.fee-checkbox:checked').length;
        if (selectedCount === 0) {
            Swal.fire('Please Select', 'Please select at least one fee to collect!', 'warning');
            return;
        }
        let totalAmt = document.getElementById('selected-total').innerText;
        let discountBox = document.getElementById('discount-breakdown-display');
        let hasDiscount = discountBox && discountBox.style.display !== 'none';
        let discountText = hasDiscount ? `<div style="font-size:13px;color:#ef4444;margin-bottom:4px;">(ছাড় অন্তর্ভুক্ত রয়েছে)</div>` : '';

        Swal.fire({
            title: 'Confirm Payment',
            html: `<div style="font-size:15px;color:#475569;margin:8px 0">
                    ${discountText}
                    Received total <strong style="color:#10b981;font-size:20px;">৳ ${totalAmt}</strong> for <strong>${selectedCount}</strong> fee item(s)?
                   </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#ef4444',
            confirmButtonText: '<i class="fa-solid fa-check me-1"></i> Yes, Received',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'rounded-pill px-4 py-2',
                cancelButton: 'rounded-pill px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-payment-form').submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: '{{ session('type', 'success') }}',
        title: '{{ session('type') == 'success' ? 'Collected!' : 'Failed!' }}',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false,
        timerProgressBar: true
    }).then(() => {
        @if(session('print_receipt_url'))
            window.open('{{ session('print_receipt_url') }}', '_blank');
        @endif
    });
    @endif
</script>
@endsection
