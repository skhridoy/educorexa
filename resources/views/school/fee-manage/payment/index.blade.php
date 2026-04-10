@extends('layouts.school')

@section('content')
<div class="page-content">
    {{-- Search Section --}}
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Collect Student Payment</h6>
                    <form action="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET" class="row g-3">
                        <div class="col-md-8">
                            <input type="text" name="student_id" class="form-control" placeholder="Enter Student ID (e.g. STD-26011001)" value="{{ request('student_id') }}" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Search Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($student)
    <div class="row">
        {{-- Student Info Card --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($student->photo)
                        <img style="border: 2px solid gold" src="{{ asset($student->photo) }}" alt="image" class="wd-100 ht-100 rounded-circle mb-3">
                    @else
                        <img style="border: 2px solid gold" src="{{ asset('assets/images/profile.webp') }}" alt="image" class="wd-100 ht-100 rounded-circle mb-3">
                    @endif
                    <h5 class="mb-1">{{ $student->name }}</h5>
                    <p class="text-muted mb-3">{{ $student->student_id }}</p>
                    <div class="text-start border-top pt-3">
                        <p><strong>Class:</strong> {{ $student->class->name }}</p>
                        <p><strong>Section:</strong> {{ $student->section->name }}</p>
                        <p><strong>Father:</strong> {{ $student->fathers_name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- 1. Unpaid Fees List (বকেয়া তালিকা) --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title text-danger">Pending Fees (বকেয়া তালিকা)</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Fee Name</th>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($unpaidFees as $fee)
                                <tr>
                                    <td>{{ $fee->feeHead->name }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $fee->month }}</span></td>
                                    <td>৳ {{ number_format($fee->amount, 2) }}</td>
                                    <td>
                                        <form action="{{ route('payment.collect', ['tenant' => auth()->user()->school->slug, 'id' => $fee->id]) }}" 
                                            method="POST" id="payment-form-{{ $fee->id }}">
                                            @csrf
                                            <div class="d-flex gap-2">
                                                <select name="payment_method" class="form-select form-select-sm" style="width: 100px;">
                                                    <option value="cash">Cash</option>
                                                    <option value="bkash">bKash</option>
                                                    <option value="nagad">Nagad</option>
                                                    <option value="bank">Bank</option>
                                                </select>
                                                
                                                <button type="button" 
                                                        class="btn btn-success btn-sm px-3" 
                                                        onclick="handlePaymentClick(event, {{ $fee->id }}, '{{ $fee->feeHead->name }}')">
                                                    Collect
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-success py-3">No pending fees found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
            @if($paidFees->count() > 0)
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-success">Recent Payments (পরিশোধিত তালিকা)</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Fee Name</th>
                                    <th>Month</th>
                                    <th>Method</th>
                                    <th>Collected By</th>
                                    <th>Paid Date</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paidFees as $paid)
                                <tr>
                                    <td>{{ $paid->feeHead->name }}</td>
                                    <td>{{ $paid->month }}</td>
                                    <td>{{ $paid->payment_method }}</td>
                                    <td>{{ $paid->collector_name }}</td>
                                    <td>{{ $paid->updated_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('payment.receipt', ['tenant' => auth()->user()->school->slug, 'id' => $paid->id]) }}" 
                                           class="btn btn-outline-info btn-xs">
                                            <i class="fa fa-download me-1"></i> Print PDF
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
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'হ্যাঁ, পেয়েছি',
            cancelButtonText: 'বাতিল',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('payment-form-' + feeId).submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 1500,
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