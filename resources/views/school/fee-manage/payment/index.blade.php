@extends('layouts.school')



@section('content')

<div class="page-content">

    {{-- Search Section --}}

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h6 class="card-title text-primary d-flex align-items-center">

                        <i data-feather="search" class="me-2 icon-sm"></i> Student Payment Collection

                    </h6>

                    <form action="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" method="GET" class="row g-3">

                        <div class="col-md-9">

                            <div class="input-group">

                                <span class="input-group-text bg-light"><i data-feather="user"></i></span>

                                <input type="text" name="student_id" class="form-control form-control-lg" placeholder="Enter Student ID (e.g. STD-26011001)" value="{{ request('student_id') }}" required>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">

                                <i data-feather="filter" class="icon-sm me-1"></i> Search Student

                            </button>

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

            <div class="card border-0 shadow-sm overflow-hidden">

                <div class="card-header bg-primary py-4 text-center border-0">

                    <div class="position-relative d-inline-block">

                        <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"

                             alt="Student"

                             class="wd-100 ht-100 rounded-circle shadow-lg border border-3 border-white">

                        <span class="position-absolute bottom-0 end-0 bg-success border border-white border-2 rounded-circle p-2"></span>

                    </div>

                    <h5 class="mt-3 text-white mb-0">{{ $student->name }}</h5>

                    <span class="badge bg-soft-light text-white mt-1">{{ $student->student_id }}</span>

                </div>

                <div class="card-body pt-4">

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">

                            <span class="text-muted"><i data-feather="book-open" class="icon-sm me-2"></i> Class</span>

                            <span class="fw-bold">{{ $student->class->name }}</span>

                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">

                            <span class="text-muted"><i data-feather="layers" class="icon-sm me-2"></i> Section</span>

                            <span class="fw-bold">{{ $student->section->name }}</span>

                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">

                            <span class="text-muted"><i data-feather="hash" class="icon-sm me-2"></i> Roll No</span>

                            <span class="fw-bold text-primary">{{ $student->roll ?? 'N/A' }}</span>

                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-bottom-0">

                            <span class="text-muted"><i data-feather="phone" class="icon-sm me-2"></i> Guardian</span>

                            <span class="fw-bold">{{ $student->fathers_name }}</span>

                        </li>

                    </ul>

                </div>

            </div>

        </div>



        <div class="col-md-8">

            {{-- Pending Fees List --}}

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">

                    <h6 class="card-title text-danger mb-0">

                        <i data-feather="alert-circle" class="icon-sm me-2"></i> Pending Fees (বকেয়া তালিকা)

                    </h6>

                    <span class="badge bg-danger">{{ $unpaidFees->count() }} Items</span>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover table-striped-columns align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>Fee Details</th>

                                    <th>Month</th>

                                    <th>Amount</th>

                                    <th class="text-center">Collection Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($unpaidFees as $fee)

                                <tr>

                                    <td>

                                        <div class="fw-bold text-dark">{{ $fee->feeHead->name }}</div>

                                        <small class="text-muted">Type: Academic Fee</small>

                                    </td>

                                    <td><span class="badge bg-soft-info text-info">{{ $fee->month }}</span></td>

                                    <td class="fw-bold text-dark">৳ {{ number_format($fee->amount, 2) }}</td>

                                    <td>

                                        <form action="{{ route('payment.collect', ['tenant' => auth()->user()->school->slug, 'id' => $fee->id]) }}"

                                              method="POST" id="payment-form-{{ $fee->id }}">

                                            @csrf

                                            <div class="input-group input-group-sm justify-content-center">

                                                <select name="payment_method" class="form-select" style="max-width: 100px;">

                                                    <option value="cash">Cash</option>

                                                    <option value="bkash">bKash</option>

                                                    <option value="nagad">Nagad</option>

                                                </select>

                                                <button type="button"

                                                        class="btn btn-success px-3 shadow-sm"

                                                        onclick="handlePaymentClick(event, {{ $fee->id }}, '{{ $fee->feeHead->name }}')">

                                                    <i data-feather="check-circle" class="icon-xs me-1"></i> Collect

                                                </button>

                                            </div>

                                        </form>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center py-5">

                                        <div class="text-success fw-bold">

                                            <i data-feather="smile" class="icon-lg mb-2 d-block mx-auto"></i>

                                            All dues are cleared for this student!

                                        </div>

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>



            {{-- Recent Paid History --}}

            @if($paidFees->count() > 0)

            <div class="card border-0 shadow-sm mt-3">

                <div class="card-header bg-white border-0 py-3">

                    <h6 class="card-title text-success mb-0">

                        <i data-feather="check-square" class="icon-sm me-2"></i> Payment History (পরিশোধিত)

                    </h6>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-sm table-hover mb-0">

                            <thead class="bg-light">

                                <tr>

                                    <th class="ps-3">Description</th>

                                    <th>Month</th>

                                    <th>Method</th>

                                    <th>Date</th>

                                    <th class="text-center">Receipt</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($paidFees as $paid)

                                <tr>

                                    <td class="ps-3 fw-medium">{{ $paid->feeHead->name }}</td>

                                    <td>{{ $paid->month }}</td>

                                    <td><span class="text-uppercase small">{{ $paid->payment_method }}</span></td>

                                    <td>{{ $paid->updated_at->format('d M, Y') }}</td>

                                    <td class="text-center">

                                        <a href="{{ route('payment.receipt', ['tenant' => auth()->user()->school->slug, 'id' => $paid->id]) }}"

                                           class="btn btn-soft-primary btn-icon btn-xs" title="Download Receipt">

                                            <i data-feather="printer" class="icon-xs text-primary"></i>

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

    // Feather Icon Initialize

    document.addEventListener("DOMContentLoaded", function() {

        if (typeof feather !== 'undefined') {

            feather.replace();

        }

    });



    function handlePaymentClick(event, feeId, feeName) {

        event.preventDefault();

        Swal.fire({

            title: 'টাকা জমা নিশ্চিত করুন',

            text: feeName + " বাবদ টাকা কি বুঝে পেয়েছেন?",

            icon: 'question',

            showCancelButton: true,

            confirmButtonColor: '#10b759',

            cancelButtonColor: '#d33',

            confirmButtonText: 'হ্যাঁ, পেয়েছি',

            cancelButtonText: 'বাতিল',

            background: '#fff',

            customClass: {

                confirmButton: 'btn btn-success shadow-sm',

                cancelButton: 'btn btn-danger shadow-sm'

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

        showConfirmButton: false

    });

    @endif

</script>



<style>

    .bg-soft-light { background-color: rgba(255,255,255,0.2); }

    .bg-soft-info { background-color: rgba(0, 204, 255, 0.1); }

    .btn-soft-primary { background-color: rgba(101, 113, 255, 0.1); border: none; }

    .btn-icon { width: 30px; height: 30px; border-radius: 5px; display: inline-flex; align-items: center; justify-content: center; }

    .card { border-radius: 12px; }

    .table thead th { font-weight: 600; font-size: 11px; letter-spacing: 0.5px; border-bottom-width: 1px; }

</style>

@endsection