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
                                <th class="ps-4">Fee Head</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th class="text-center pe-4">Collection</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unpaidFees as $fee)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $fee->feeHead->name }}</div>
                                    <div class="text-muted small italic">Academic Fee Record</div>
                                </td>
                                <td><span class="badge bg-soft-primary text-primary px-3">{{ $fee->month }}</span></td>
                                <td class="fw-bold text-dark" style="font-size: 1.05rem;">৳ {{ number_format($fee->amount, 2) }}</td>
                                <td class="pe-4">
                                    <form action="{{ route('payment.collect', ['tenant' => auth()->user()->school->slug, 'id' => $fee->id]) }}"
                                          method="POST" id="payment-form-{{ $fee->id }}">
                                        @csrf
                                        <div class="input-group input-group-sm justify-content-center">
                                            <select name="payment_method" class="form-select fw-bold bg-light" style="max-width: 100px; border-radius: 8px 0 0 8px;">
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
                                        <i class="fa-solid fa-circle-check fa-3x text-success mb-3 opacity-50"></i>
                                        <h5 class="text-success fw-bold">All dues are cleared!</h5>
                                        <p class="text-muted small mb-0">No pending fees found for this student.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Payment History --}}
            @if($paidFees->count() > 0)
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
                                <th>Month</th>
                                <th>Method</th>
                                <th>Date</th>
                                <th class="text-center pe-4">Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paidFees as $paid)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $paid->feeHead->name }}</td>
                                <td>{{ $paid->month }}</td>
                                <td>
                                    <span class="badge bg-soft-secondary text-secondary text-uppercase px-2" style="font-size:0.7rem;">
                                        {{ $paid->payment_method }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $paid->updated_at->format('d M, Y') }}</td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('payment.receipt', ['tenant' => auth()->user()->school->slug, 'id' => $paid->id]) }}"
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