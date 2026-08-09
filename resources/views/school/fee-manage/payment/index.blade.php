@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ── Search Hero ── */
        .payment-search-hero {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #a855f7 100%);
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .payment-search-hero::before {
            content:''; position:absolute; top:-50px; right:-50px;
            width:200px; height:200px; background:rgba(255,255,255,0.06); border-radius:50%;
        }
        .payment-search-hero::after {
            content:''; position:absolute; bottom:-60px; left:-30px;
            width:160px; height:160px; background:rgba(255,255,255,0.04); border-radius:50%;
        }
        .search-input-premium {
            background: rgba(255,255,255,0.15) !important;
            border: 1.5px solid rgba(255,255,255,0.3) !important;
            border-radius: 12px !important;
            color: #fff !important;
            padding: 12px 20px !important;
            font-size: 15px !important;
            font-weight: 500;
            backdrop-filter: blur(8px);
            transition: all .2s;
        }
        .search-input-premium::placeholder { color: rgba(255,255,255,0.6) !important; }
        .search-input-premium:focus {
            background: rgba(255,255,255,0.22) !important;
            border-color: rgba(255,255,255,0.6) !important;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.15) !important;
            color: #fff !important;
            outline: none;
        }
        /* ── Student Profile Card ── */
        .student-profile-premium {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 8px 30px rgba(15,23,42,0.10);
        }
        .profile-hero-bg {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 28px 20px 22px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .profile-hero-bg::before {
            content:''; position:absolute; top:-30px; right:-30px;
            width:120px; height:120px; background:rgba(79,70,229,0.15); border-radius:50%;
        }
        .profile-avatar-ring {
            width: 90px; height: 90px; border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.4);
            box-shadow: 0 0 0 4px rgba(79,70,229,0.3);
            position: relative; z-index: 1;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; }
        .info-value { font-size: 13px; font-weight: 700; color: #1e293b; }
        /* ── Fee Table ── */
        .fee-table-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 4px 20px rgba(15,23,42,0.07);
            overflow: hidden;
        }
        .fee-section-header {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .fee-header-pending { background: linear-gradient(90deg, #fff1f2, #ffe4e6); }
        .fee-header-paid    { background: linear-gradient(90deg, #f0fdf4, #dcfce7); }
        .fee-row-hover:hover { background: #fafbff !important; }
        .fee-checkbox-custom {
            width: 16px; height: 16px; border-radius: 5px !important;
            border: 2px solid #cbd5e1 !important; cursor: pointer;
        }
        .fee-checkbox-custom:checked { background-color: #4f46e5 !important; border-color: #4f46e5 !important; }
        /* ── Total Footer ── */
        .payment-footer {
            background: #f8fafc;
            border-top: 1.5px solid #f1f5f9;
            padding: 14px 24px;
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;
        }
        .total-amount-display {
            font-size: 22px; font-weight: 800; color: #ef4444; font-variant-numeric: tabular-nums;
        }
        .select-method {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 8px 14px !important;
            font-size: 13px; font-weight: 600;
            background: #fff;
        }
        .btn-collect {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; border: none; border-radius: 12px;
            padding: 10px 28px; font-size: 14px; font-weight: 700;
            box-shadow: 0 4px 14px rgba(16,185,129,0.35);
            transition: all .25s; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-collect:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(16,185,129,0.45); color:#fff; }
        /* ── History ── */
        .receipt-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; border: none; border-radius: 8px;
            padding: 5px 14px; font-size: 12px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 5px;
            text-decoration: none; transition: all .2s;
        }
        .receipt-badge:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16,185,129,0.3); color:#fff; }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ══ SEARCH HERO ══ --}}
    <div class="payment-search-hero">
        <div style="position:relative;z-index:1;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,0.3);">
                    <i class="fa-solid fa-hand-holding-dollar text-white" style="font-size:18px;"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0" style="text-shadow:0 1px 4px rgba(0,0,0,0.2);">Fee Collection</h4>
                    <p class="mb-0" style="color:rgba(255,255,255,0.7);font-size:13px;">Search student by ID to collect payments</p>
                </div>
                <div class="ms-auto d-none d-md-block">
                    <span style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);color:#fff;font-size:12px;font-weight:600;padding:6px 16px;border-radius:50px;border:1px solid rgba(255,255,255,0.25);">
                        <i class="fa-regular fa-calendar-days me-1"></i>{{ now()->format('d M, Y') }}
                    </span>
                </div>
            </div>
            <form action="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET">
                <div class="d-flex gap-3">
                    <div class="flex-grow-1 position-relative">
                        <i class="fa-solid fa-id-card position-absolute" style="left:16px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.6);font-size:16px;"></i>
                        <input type="text" name="student_id" class="form-control search-input-premium ps-5"
                               placeholder="Enter Student ID (e.g. STD-26011001)"
                               value="{{ request('student_id') }}" required>
                    </div>
                    <button type="submit"
                            style="background:rgba(255,255,255,0.22);backdrop-filter:blur(8px);color:#fff;border:1.5px solid rgba(255,255,255,0.4);border-radius:12px;padding:10px 28px;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;white-space:nowrap;display:flex;align-items:center;gap:8px;"
                            onmouseover="this.style.background='rgba(255,255,255,0.32)'" onmouseout="this.style.background='rgba(255,255,255,0.22)'">
                        <i class="fa-solid fa-magnifying-glass"></i> Find Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($student)
    <div class="row g-4">

        {{-- ── Student Profile Card ── --}}
        <div class="col-lg-4">
            <div class="student-profile-premium card h-100">
                {{-- Profile Hero --}}
                <div class="profile-hero-bg">
                    <div style="position:relative;z-index:1;">
                        <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"
                             alt="{{ $student->name }}" class="profile-avatar-ring mb-3">
                        <h5 class="text-white fw-bold mb-1">{{ $student->name }}</h5>
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
                </div>
                {{-- Info List --}}
                <div class="card-body px-4 py-3">
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-graduation-cap me-2" style="color:#4f46e5;"></i>Class</span>
                        <span class="info-value">{{ $student->class->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-layer-group me-2" style="color:#7c3aed;"></i>Section</span>
                        <span class="info-value">{{ $student->section->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-hashtag me-2" style="color:#0ea5e9;"></i>Roll No</span>
                        <span class="info-value" style="color:#4f46e5;">{{ $student->roll ?? 'N/A' }}</span>
                    </div>
                    @if($student->fathers_name)
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-user-shield me-2" style="color:#10b981;"></i>Guardian</span>
                        <span class="info-value">{{ $student->fathers_name }}</span>
                    </div>
                    @endif
                    @if($student->contact_number)
                    <div class="info-row">
                        <span class="info-label"><i class="fa-solid fa-phone me-2" style="color:#f59e0b;"></i>Phone</span>
                        <span class="info-value">{{ $student->contact_number }}</span>
                    </div>
                    @endif
                </div>
                {{-- Summary Stats --}}
                <div class="px-4 pb-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <div style="background:linear-gradient(135deg,#fff1f2,#ffe4e6);border-radius:12px;padding:12px;text-align:center;">
                                <div style="font-size:20px;font-weight:800;color:#ef4444;">{{ $unpaidFees->count() }}</div>
                                <div style="font-size:10px;color:#f87171;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Pending</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-radius:12px;padding:12px;text-align:center;">
                                <div style="font-size:20px;font-weight:800;color:#10b981;">{{ $paidFeesGroups ? $paidFeesGroups->count() : 0 }}</div>
                                <div style="font-size:10px;color:#6ee7b7;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Receipts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Right Panel ── --}}
        <div class="col-lg-8">

            {{-- Pending Fees --}}
            <div class="fee-table-card card mb-4">
                <form action="{{ route('payment.collectMultiple', ['tenant' => auth()->user()->school->slug]) }}" method="POST" id="bulk-payment-form">
                    @csrf
                    {{-- Section Header --}}
                    <div class="fee-section-header fee-header-pending">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-clock-rotate-left text-white" style="font-size:14px;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark" style="font-size:14px;">Pending Fees</div>
                                <div style="font-size:11px;color:#94a3b8;">Select fees to collect payment</div>
                            </div>
                        </div>
                        <span style="background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:12px;font-weight:700;padding:4px 14px;border-radius:50px;">
                            {{ $unpaidFees->count() }} Items
                        </span>
                    </div>

                    {{-- Fee Table --}}
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" style="font-size:13px;">
                            <thead style="background:#fafbfc;border-bottom:2px solid #f1f5f9;">
                                <tr>
                                    <th class="ps-4 py-3" style="width:44px;">
                                        <input class="form-check-input fee-checkbox-custom" type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                                    </th>
                                    <th class="py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;">Fee Head</th>
                                    <th class="py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;">Month</th>
                                    <th class="py-3 fw-bold text-uppercase text-end pe-4" style="font-size:11px;color:#64748b;letter-spacing:.5px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($unpaidFees as $fee)
                                <tr class="fee-row-hover" style="border-bottom:1px solid #f8fafc;">
                                    <td class="ps-4">
                                        <input class="form-check-input fee-checkbox-custom fee-checkbox" type="checkbox" name="fee_ids[]" value="{{ $fee->id }}" onclick="updateTotal()">
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-semibold text-dark">{{ $fee->feeHead->name }}</div>
                                        <div style="font-size:11px;color:#94a3b8;">Academic Fee Record</div>
                                    </td>
                                    <td>
                                        <span style="background:#eef2ff;color:#4f46e5;font-size:11px;font-weight:700;padding:3px 10px;border-radius:50px;">{{ $fee->month }}</span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold" style="color:#ef4444;font-size:14px;" data-amount="{{ $fee->amount }}">
                                        ৳ {{ number_format($fee->amount, 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div style="width:64px;height:64px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                            <i class="fa-solid fa-circle-check" style="font-size:28px;color:#10b981;"></i>
                                        </div>
                                        <h6 class="fw-bold text-success mb-1">All Dues Cleared!</h6>
                                        <p class="text-muted small mb-0">No pending fees found for this student.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Payment Footer --}}
                    @if($unpaidFees->count() > 0)
                    <div class="payment-footer">
                        <div>
                            <div style="font-size:12px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Total Selected</div>
                            <div class="total-amount-display">৳ <span id="selected-total">0.00</span></div>
                        </div>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <select name="payment_method" class="form-select select-method" style="width:auto;">
                                <option value="cash">💵 Cash</option>
                                <option value="bkash">📱 bKash</option>
                                <option value="nagad">📱 Nagad</option>
                            </select>
                            <button type="button" class="btn-collect" onclick="handleBulkPaymentClick(event)">
                                <span style="width:22px;height:22px;background:rgba(255,255,255,0.22);border-radius:6px;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="fa-solid fa-check" style="font-size:11px;"></i>
                                </span>
                                Collect Payment
                            </button>
                        </div>
                    </div>
                    @endif
                </form>
            </div>

            {{-- Payment History --}}
            @if($paidFeesGroups && $paidFeesGroups->count() > 0)
            <div class="fee-table-card card">
                <div class="fee-section-header fee-header-paid">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-receipt text-white" style="font-size:14px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size:14px;">Payment History</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $paidFeesGroups->count() }} receipt(s) found</div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="font-size:13px;">
                        <thead style="background:#fafbfc;border-bottom:2px solid #f1f5f9;">
                            <tr>
                                <th class="ps-4 py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;">Description</th>
                                <th class="py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;">Amount</th>
                                <th class="py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;">Method</th>
                                <th class="py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;">Date</th>
                                <th class="py-3 fw-bold text-uppercase text-center pe-4" style="font-size:11px;color:#64748b;letter-spacing:.5px;">Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paidFeesGroups as $receiptNo => $feesGroup)
                            <tr style="border-bottom:1px solid #f8fafc;">
                                <td class="ps-4 py-3">
                                    <div class="fw-semibold text-dark">{{ Str::limit($feesGroup->pluck('feeHead.name')->implode(', '), 30) }}</div>
                                    <div style="font-size:11px;color:#94a3b8;">{{ $feesGroup->pluck('month')->unique()->implode(', ') }}</div>
                                </td>
                                <td>
                                    <span class="fw-bold" style="color:#10b981;font-size:14px;">৳ {{ number_format($feesGroup->sum('amount'), 2) }}</span>
                                </td>
                                <td>
                                    <span style="background:#f0fdf4;color:#059669;font-size:11px;font-weight:700;padding:3px 10px;border-radius:50px;text-transform:uppercase;">
                                        {{ $feesGroup->first()->payment_method }}
                                    </span>
                                </td>
                                <td style="color:#64748b;font-size:12px;">{{ $feesGroup->first()->updated_at->format('d M, Y') }}</td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('payment.receiptMultiple', ['tenant' => auth()->user()->school->slug, 'receipt_no' => $receiptNo]) }}"
                                       class="receipt-badge">
                                        <i class="fa-solid fa-print" style="font-size:11px;"></i> Receipt
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
        let total = 0;
        document.querySelectorAll('.fee-checkbox:checked').forEach(cb => {
            total += parseFloat(cb.closest('tr').querySelector('td[data-amount]').getAttribute('data-amount'));
        });
        document.getElementById('selected-total').innerText = total.toFixed(2);
    }

    function handleBulkPaymentClick(event) {
        event.preventDefault();
        let selectedCount = document.querySelectorAll('.fee-checkbox:checked').length;
        if (selectedCount === 0) {
            Swal.fire('Please Select', 'Please select at least one fee to collect!', 'warning');
            return;
        }
        let totalAmt = document.getElementById('selected-total').innerText;
        Swal.fire({
            title: 'Confirm Payment',
            html: `<div style="font-size:15px;color:#475569;margin:8px 0">Received total <strong style="color:#10b981;font-size:18px;">৳ ${totalAmt}</strong> for <strong>${selectedCount}</strong> fee(s)?</div>`,
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
        timer: 2000,
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
