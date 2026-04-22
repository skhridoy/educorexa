@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Wishing Alert Logic --}}
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

        {{-- Wishing Alert Display --}}
        <div class="d-flex align-items-center mb-4">
            <div class="me-3">
                <i data-feather="{{ $icon }}" class="text-warning" style="width: 30px; height: 30px;"></i>
            </div>
            <div>
                <h4 class="mb-0">{{ $greeting }}, {{ auth()->user()->name }}!</h4>
                <p class="text-muted">Here is what's happening with your profile today.</p>
            </div>
        </div>

        {{-- Employee Statistics Cards --}}
        <div class="row">
            {{-- Attendance Card --}}
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                            <div style="width: 55px; height: 55px; background-color: rgba(101, 113, 255, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                                <i class="fa-solid fa-user-check fs-3 text-primary"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Attendance</p>
                                <h3 class="mb-0 fw-bold text-primary">{{ $attendanceRate ?? '95' }}%</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leave Balance Card --}}
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                            <div style="width: 55px; height: 55px; background-color: rgba(255, 153, 0, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                                <i class="fa-solid fa-calendar-minus fs-3 text-warning"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Leave Balance</p>
                                <h3 class="mb-0 fw-bold text-warning">{{ $leaveBalance ?? '12' }} Days</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tasks/Projects Card --}}
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                            <div style="width: 55px; height: 55px; background-color: rgba(16, 185, 129, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                                <i class="fa-solid fa-list-check fs-3 text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Active Tasks</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $activeTasks ?? '05' }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Salary Status Card --}}
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                            <div style="width: 55px; height: 55px; background-color: rgba(239, 68, 68, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                                <i class="fa-solid fa-file-invoice-dollar fs-3 text-danger"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Last Salary</p>
                                <h3 class="mb-0 fw-bold text-danger">Paid</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Tasks & Notices --}}
        <div class="row mt-4">
            {{-- Tasks Table --}}
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title">My Recent Tasks</h6>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th class="text-center">Priority</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- এখানে আপনার ডাটাবেজ থেকে লুপ হবে --}}
                                    <tr>
                                        <td>Update Student Exam Marks</td>
                                        <td>25 April 2026</td>
                                        <td><span class="badge bg-info text-white">In Progress</span></td>
                                        <td class="text-center"><span class="badge bg-danger">High</span></td>
                                    </tr>
                                    <tr>
                                        <td>Submit Monthly Attendance Report</td>
                                        <td>30 April 2026</td>
                                        <td><span class="badge bg-warning text-white">Pending</span></td>
                                        <td class="text-center"><span class="badge bg-primary">Medium</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Notices Side Card --}}
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title">Notice Board</h6>
                        <div class="mt-3">
                            <div class="d-flex border-bottom pb-3 mb-3">
                                <div class="me-3">
                                    <div class="bg-light-primary text-primary rounded p-2">
                                        <i data-feather="bell" class="icon-md"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="fw-bold mb-0">Eid-ul-Fitr Holiday</p>
                                    <small class="text-muted">Office will remain closed from 28th April...</small>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="bg-light-warning text-warning rounded p-2">
                                        <i data-feather="info" class="icon-md"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="fw-bold mb-0">Meeting at 3:00 PM</p>
                                    <small class="text-muted">All teachers must attend the monthly meeting.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection