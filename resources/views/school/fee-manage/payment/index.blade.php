@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-money-bill-transfer me-2"></i> Student Payment</h1>
                <p style="margin: 0; opacity: 0.85;">Efficiently collect fees and track payment history</p>
            </div>
        </div>

        {{-- Search Section --}}
        <div class="search-container">
            <form action="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-9">
                        <div class="input-group input-group-lg" style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                            <span class="input-group-text border-0 bg-white px-4"><i class="fa-solid fa-id-card text-muted"></i></span>
                            <input type="text" name="student_id" class="form-control border-0 py-3" 
                                   placeholder="Enter Student ID (e.g. STD-26011001)" 
                                   value="{{ request('student_id') }}" required style="box-shadow: none; font-size: 1rem;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary-gradient btn-lg w-100 py-3" style="border-radius: 12px; font-weight: 700;">
                            <i class="fa-solid fa-magnifying-glass me-2"></i> Find Student
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($student)
        <div class="row">
            {{-- Student Info Card --}}
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                    <div class="student-profile-header">
                        <div class="student-img-wrapper">
                            <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"
                                 alt="Student" class="student-img">
                        </div>
                        <h4 class="text-white fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">{{ $student->name }}</h4>
                        <span class="student-id-badge">{{ $student->student_id }}</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="info-list-item">
                            <span class="info-label"><i class="fa-solid fa-graduation-cap me-2 text-primary opacity-50"></i> Class</span>
                            <span class="info-value">{{ $student->class->name }}</span>
                        </div>
                        <div class="info-list-item">
                            <span class="info-label"><i class="fa-solid fa-layer-group me-2 text-primary opacity-50"></i> Section</span>
                            <span class="info-value">{{ $student->section->name }}</span>
                        </div>
                        <div class="info-list-item">
                            <span class="info-label"><i class="fa-solid fa-hashtag me-2 text-primary opacity-50"></i> Roll No</span>
                            <span class="info-value text-primary">{{ $student->roll ?? 'N/A' }}</span>
                        </div>
                        <div class="info-list-item">
                            <span class="info-label"><i class="fa-solid fa-user-shield me-2 text-primary opacity-50"></i> Guardian</span>
                            <span class="info-value">{{ $student->fathers_name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                {{-- Pending Fees List --}}
                <div class="card pending-card border-0 shadow-sm mb-4">
                    <div class="pending-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-danger">
                            <i class="fa-solid fa-clock-rotate-left me-2"></i> Pending Fees (বকেয়া তালিকা)
                        </h6>
                        <span class="badge rounded-pill bg-danger px-3">{{ $unpaidFees->count() }} Items</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table data-table mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Fee Head</th>
                                        <th>Month</th>
                                        <th>Amount</th>
                                        <th class="text-center">Collection Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unpaidFees as $fee)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $fee->feeHead->name }}</div>
                                            <div class="text-muted small">Academic Fee</div>
                                        </td>
                                        <td><span class="badge bg-soft-primary text-primary fw-bold">{{ $fee->month }}</span></td>
                                        <td class="fw-bold text-dark" style="font-size: 1.05rem;">৳ {{ number_format($fee->amount, 2) }}</td>
                                        <td>
                                            <form action="{{ route('payment.collect', ['tenant' => auth()->user()->school->slug, 'id' => $fee->id]) }}"
                                                  method="POST" id="payment-form-{{ $fee->id }}">
                                                @csrf
                                                <div class="input-group input-group-sm justify-content-center">
                                                    <select name="payment_method" class="form-select border-0 bg-light fw-bold" style="max-width: 100px; border-radius: 8px 0 0 8px;">
                                                        <option value="cash">Cash</option>
                                                        <option value="bkash">bKash</option>
                                                        <option value="nagad">Nagad</option>
                                                    </select>
                                                    <button type="button" class="btn btn-success px-3 fw-bold" style="border-radius: 0 8px 8px 0;"
                                                            onclick="handlePaymentClick(event, {{ $fee->id }}, '{{ $fee->feeHead->name }}')">
                                                        Collect
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="py-3">
                                                <i class="fa-solid fa-circle-check fa-3x text-success mb-3"></i>
                                                <h5 class="text-success fw-bold">All dues are cleared!</h5>
                                                <p class="text-muted small">No pending fees found for this student.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Payment History --}}
                @if($paidFees->count() > 0)
                <div class="card history-card border-0 shadow-sm">
                    <div class="history-header">
                        <h6 class="mb-0 fw-bold text-success">
                            <i class="fa-solid fa-receipt me-2"></i> Payment History (পরিশোধিত)
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Description</th>
                                        <th>Month</th>
                                        <th>Method</th>
                                        <th>Date</th>
                                        <th class="text-center">Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paidFees as $paid)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $paid->feeHead->name }}</td>
                                        <td>{{ $paid->month }}</td>
                                        <td><span class="method-badge">{{ $paid->payment_method }}</span></td>
                                        <td class="text-muted">{{ $paid->updated_at->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('payment.receipt', ['tenant' => auth()->user()->school->slug, 'id' => $paid->id]) }}"
                                               class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Print Receipt">
                                                <i class="fa-solid fa-print me-1"></i> Receipt
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('customJs')
<script>
    function handlePaymentClick(event, feeId, feeName) {
        event.preventDefault();
        Swal.fire({
            title: 'টাকা জমা নিশ্চিত করুন',
            text: feeName + " বাবদ টাকা কি বুঝে পেয়েছেন?",
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
                document.getElementById('payment-form-' + feeId).submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Collected!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false,
        timerProgressBar: true
    });
    @endif
</script>
@endsection