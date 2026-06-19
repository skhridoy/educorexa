@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    {{-- Modern Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="font-family:'Outfit', sans-serif;">Fee Collection</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('school.dashboard', ['tenant' => auth()->user()->school->slug]) }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Payment</li>
                </ol>
            </nav>
        </div>
        <div class="header-actions">
            <span class="badge bg-soft-primary text-primary py-2 px-3 fw-bold">
                <i class="fa-solid fa-calendar-day me-1"></i> {{ now()->format('d M, Y') }}
            </span>
        </div>
    </div>

    {{-- Search Section --}}
    <div class="schools-panel mb-4">
        <div class="p-4">
            <form action="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-9">
                        <div class="input-group input-group-lg search-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-id-card text-muted"></i></span>
                            <input type="text" name="student_id" class="form-control border-start-0 ps-0" 
                                   placeholder="Enter Student ID (e.g. STD-26011001)" 
                                   value="{{ request('student_id') }}" required style="font-size: 1.1rem; height: 55px;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 h-100 py-3 fw-bold shadow-sm">
                            <i class="fa-solid fa-magnifying-glass me-2"></i> Find Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($student)
    <div class="row g-4">
        {{-- Student Profile --}}
        <div class="col-lg-4">
            <div class="schools-panel h-100 overflow-hidden">
                <div class="bg-dark p-4 text-center">
                    <div class="mb-3">
                        <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"
                             alt="Student" class="rounded-circle border border-4 border-white shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <h5 class="text-white fw-bold mb-1">{{ $student->name }}</h5>
                    <div class="badge bg-soft-warning text-warning px-3 py-1">{{ $student->student_id }}</div>
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted small fw-bold text-uppercase"><i class="fa-solid fa-graduation-cap me-2 text-primary opacity-50"></i> Class</span>
                        <span class="fw-bold">{{ $student->class->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted small fw-bold text-uppercase"><i class="fa-solid fa-layer-group me-2 text-primary opacity-50"></i> Section</span>
                        <span class="fw-bold">{{ $student->section->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted small fw-bold text-uppercase"><i class="fa-solid fa-hashtag me-2 text-primary opacity-50"></i> Roll No</span>
                        <span class="text-primary fw-bold">{{ $student->roll ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0 pb-2">
                        <span class="text-muted small fw-bold text-uppercase"><i class="fa-solid fa-user-shield me-2 text-primary opacity-50"></i> Guardian</span>
                        <span class="fw-bold">{{ $student->fathers_name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            {{-- Pending Fees List --}}
            <div class="schools-panel mb-4">
                <form action="{{ route('payment.collectMultiple', ['tenant' => auth()->user()->school->slug]) }}" method="POST" id="bulk-payment-form">
                    @csrf
                    <div class="panel-header d-flex justify-content-between align-items-center bg-soft-danger border-danger-subtle">
                        <h6 class="panel-title mb-0 text-danger">
                            <i class="fa-solid fa-clock-rotate-left me-2"></i> Pending Fees (বকেয়া তালিকা)
                        </h6>
                        <span class="badge rounded-pill bg-danger px-3">{{ $unpaidFees->count() }} Items</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4" style="width: 40px;">
                                        <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                                    </th>
                                    <th>Fee Head</th>
                                    <th>Month</th>
                                    <th class="pe-4 text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($unpaidFees as $fee)
                                <tr>
                                    <td class="ps-4">
                                        <input class="form-check-input fee-checkbox" type="checkbox" name="fee_ids[]" value="{{ $fee->id }}" onclick="updateTotal()">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $fee->feeHead->name }}</div>
                                        <div class="text-muted small italic">Academic Fee Record</div>
                                    </td>
                                    <td><span class="badge bg-soft-primary text-primary px-3">{{ $fee->month }}</span></td>
                                    <td class="fw-bold text-dark text-end pe-4" style="font-size: 1.05rem;" data-amount="{{ $fee->amount }}">৳ {{ number_format($fee->amount, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-3">
                                            <i class="fa-solid fa-circle-check fa-3x text-success mb-3 opacity-50"></i>
                                            <h5 class="text-success fw-bold">All dues are cleared!</h5>
                                            <p class="text-muted small mb-0">No pending fees found for this student.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($unpaidFees->count() > 0)
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="2" class="ps-4 fw-bold text-dark">
                                        Total Selected: <span id="selected-total" class="text-danger">৳ 0.00</span>
                                    </td>
                                    <td colspan="2" class="pe-4 text-end">
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <select name="payment_method" class="form-select fw-bold bg-white" style="max-width: 130px; border-radius: 8px;">
                                                <option value="cash">Cash</option>
                                                <option value="bkash">bKash</option>
                                                <option value="nagad">Nagad</option>
                                            </select>
                                            <button type="button" class="btn btn-success px-4 fw-bold" style="border-radius: 8px;" onclick="handleBulkPaymentClick(event)">
                                                <i class="fa-solid fa-check-circle me-1"></i> Collect Selected
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </form>
            </div>

            {{-- Payment History --}}
            @if($paidFeesGroups && $paidFeesGroups->count() > 0)
            <div class="schools-panel">
                <div class="panel-header bg-soft-success border-success-subtle">
                    <h6 class="panel-title mb-0 text-success">
                        <i class="fa-solid fa-receipt me-2"></i> Payment History (পরিশোধিত)
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Description</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Date</th>
                                <th class="text-center pe-4">Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paidFeesGroups as $receiptNo => $feesGroup)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">
                                    <span title="{{ $feesGroup->pluck('feeHead.name')->implode(', ') }}">
                                        {{ Str::limit($feesGroup->pluck('feeHead.name')->implode(', '), 30) }}
                                    </span>
                                    <div class="text-muted small">Months: {{ $feesGroup->pluck('month')->unique()->implode(', ') }}</div>
                                </td>
                                <td class="fw-bold text-success">৳ {{ number_format($feesGroup->sum('amount'), 2) }}</td>
                                <td>
                                    <span class="badge bg-soft-secondary text-secondary text-uppercase px-2" style="font-size:0.7rem;">
                                        {{ $feesGroup->first()->payment_method }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $feesGroup->first()->updated_at->format('d M, Y') }}</td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('payment.receiptMultiple', ['tenant' => auth()->user()->school->slug, 'receipt_no' => $receiptNo]) }}"
                                       class="btn-icon-custom btn-action-view w-auto px-3 rounded-pill" style="height: 30px; font-size: 0.8rem;" title="Print Receipt">
                                        <i class="fa-solid fa-print me-1"></i> Receipt
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
        checkboxes = document.getElementsByClassName('fee-checkbox');
        for(var i=0, n=checkboxes.length; i<n; i++) {
            checkboxes[i].checked = source.checked;
        }
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        let checkboxes = document.querySelectorAll('.fee-checkbox:checked');
        checkboxes.forEach(function(checkbox) {
            let amount = parseFloat(checkbox.closest('tr').querySelector('td[data-amount]').getAttribute('data-amount'));
            total += amount;
        });
        document.getElementById('selected-total').innerText = '৳ ' + total.toFixed(2);
    }

    function handleBulkPaymentClick(event) {
        event.preventDefault();
        let selectedCount = document.querySelectorAll('.fee-checkbox:checked').length;
        
        if (selectedCount === 0) {
            Swal.fire('Error', 'দয়া করে অন্তত একটি ফি সিলেক্ট করুন!', 'error');
            return;
        }

        Swal.fire({
            title: 'টাকা জমা নিশ্চিত করুন',
            text: selectedCount + " টি ফি বাবদ টাকা কি বুঝে পেয়েছেন?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'হ্যাঁ, পেয়েছি',
            cancelButtonText: 'বাতিল',
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