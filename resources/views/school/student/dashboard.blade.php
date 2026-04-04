@extends('layouts.school') {{-- আপনার মেইন লেআউট --}}

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $hour = date('H');
            if ($hour >= 5 && $hour < 12) {
                $greeting = "Good Morning";
                $icon = "sun";
            } elseif ($hour >= 12 && $hour < 17) {
                $greeting = "Good Afternoon";
                $icon = "sunrise";
            } elseif ($hour >= 17 && $hour < 21) {
                $greeting = "Good Evening";
                $icon = "sunset";
            } else {
                $greeting = "Good Night";
                $icon = "moon";
            }
        @endphp

        <div class="d-flex align-items-center mb-4">
            <div class="me-3">
                <i data-feather="{{ $icon }}" class="text-warning" style="width: 30px; height: 30px;"></i>
            </div>
            <div>
                <h4 class="mb-0">{{ $greeting }}, {{ auth()->user()->name }}!</h4>
                <p class="text-muted mb-0">Class : {{ $student->class->name }} | Section : {{ $student->section->name }} | Roll : {{ $student->roll }} | Student ID : {{ $student->student_id }}</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            
            <div class="col-md-4 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div style="width: 55px; height: 55px; background-color: rgba(13, 110, 253, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa-solid fa-user-check fs-3 text-primary"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">This Month's Attendance</p>
                                <h3 class="mb-0 fw-bold">{{ $attendancePercentage }}%</h3>
                                <small class="text-muted">{{ $presentDays }}/{{ $totalDays }} days present</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div style="width: 55px; height: 55px; background-color: rgba(220, 53, 69, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa-solid fa-file-invoice-dollar fs-3 text-danger"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Total Due Fee</p>
                                <h3 class="mb-0 fw-bold text-danger">৳ {{ number_format($totalDue) }}</h3>
                                <small class="text-muted">{{ $unpaidFees->count() }}, unpaid fees</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div style="width: 55px; height: 55px; background-color: rgba(25, 135, 84, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa-solid fa-book-open fs-3 text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Upcoming Assignments</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $diaries->count() }} Assignments</h3>
                                <small class="text-muted">Home Work & Class Work</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0 text-dark"><i class="fas fa-book-open me-2 text-primary"></i>আজকের ডায়েরি / বাড়ির কাজ</h5>
                    </div>
                    <div class="card-body">
                        @forelse($diaries as $diary)
                            <div class="p-3 mb-3 border-start border-4 border-primary rounded shadow-sm">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1 text-primary">{{ $diary->subject->name }}</h6>
                                    <small class="text-muted"><i class="far fa-user me-1"></i> {{ $diary->teacher->name ?? 'শিক্ষক' }}</small>
                                </div>
                                <p class="mb-0 text-secondary">{{ $diary->lesson_description }}</p>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-50">
                                <p class="text-muted">আজকের জন্য কোনো বাড়ির কাজ দেওয়া হয়নি।</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
    
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header py-3">
                        <h5 class="mb-0 text-dark"><i class="fas fa-file-invoice-dollar me-2 text-danger"></i>Unpaid Fee's List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Fee Name</th>
                                        <th class="text-end pe-3">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unpaidFees as $fee)
                                        <tr>
                                            <td class="ps-3">
                                                <span class="d-block fw-bold">{{ $fee->feeHead->name }}</span>
                                                <small class="text-muted">{{ $fee->month }}</small>
                                            </td>
                                            <td class="text-end pe-3 text-danger fw-bold">৳{{ number_format($fee->amount, 0) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-4 text-success">আপনার কোনো বকেয়া নেই!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($totalDue > 0)
                    <div class="card-footerborder-0 py-3 px-3">
                        <a href="#" class="btn btn-danger w-100 shadow-sm">Pay Now</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection