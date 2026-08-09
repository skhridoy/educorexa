@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Responsive adjustments for the welcome card */
        @media (max-width: 768px) {
            .welcome-card {
                padding: 1.5rem !important;
                text-align: center;
            }
            .welcome-card .d-flex {
                justify-content: center;
                flex-direction: column;
            }
            .welcome-card h2 {
                font-size: 1.5rem;
            }
        }

    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $hour = date('H');
            if ($hour >= 5 && $hour < 12)      { $greeting = "Good Morning";   $faIcon = "fa-sun";     $greetColor = "#f59e0b"; }
            elseif ($hour >= 12 && $hour < 17) { $greeting = "Good Afternoon"; $faIcon = "fa-cloud-sun"; $greetColor = "#f97316"; }
            elseif ($hour >= 17 && $hour < 21) { $greeting = "Good Evening";   $faIcon = "fa-sunset";  $greetColor = "#8b5cf6"; }
            else                               { $greeting = "Good Night";     $faIcon = "fa-moon";    $greetColor = "#3b82f6"; }
        @endphp
        
        {{-- ===== WELCOME HERO CARD ===== --}}
        <div class="welcome-card mb-4 p-4 p-md-5 position-relative overflow-hidden" 
             style="border-radius:24px; background:linear-gradient(135deg, #002147 0%, #003366 100%); color:white; box-shadow: 0 10px 30px rgba(0,33,71,0.15);">
            <div style="position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
            
            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="greet-icon-box d-none d-sm-flex" style="width:50px; height:50px; background:rgba(255,255,255,0.1); border-radius:14px; align-items:center; justify-content:center; backdrop-filter:blur(10px);">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor == '#3b82f6' ? '#60a5fa' : $greetColor }}"></i>
                        </div>
                        <h2 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif;">
                            {{ $greeting }}, {{ auth()->user()->name }}!
                        </h2>
                    </div>
                    <p class="mb-0 opacity-75 fs-6 fs-md-5" style="max-width:600px;">
                        EduCorexa: আপনার স্কুলের গুরুত্বপূর্ণ তথ্যসমূহ এক নজরে দেখে নিন।
                    </p>
                    <div class="mt-4 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-calendar-days me-1"></i> {{ now()->format('d M Y') }}
                        </span>
                        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-clock me-1"></i> {{ now()->format('h:i A') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <i class="fa-solid fa-graduation-cap text-white opacity-10" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>

        {{-- Statistics Grid --}}
        <div class="row g-3 g-md-4 mb-4">
            
            <!-- Teachers Card -->
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0 shadow-sm text-center p-2 p-md-3" style="border-radius: 10px;">
                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background: #f3e8ff; color: #9333ea;">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 10px; letter-spacing: 1px;">Teachers</div>
                    <div class="h5 fw-bolder mb-0">{{ $totalTeachers }}</div>
                </div>
            </div>

            <!-- Students Card -->
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0 shadow-sm text-center p-md-3" style="border-radius: 10px;">
                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background: #fff7ed; color: #f97316;">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 10px; letter-spacing: 1px;">Students</div>
                    <div class="h5 fw-bolder mb-0">{{ $totalStudents }}</div>
                </div>
            </div>

            <!-- Collected Card -->
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0 shadow-sm text-center p-md-3" style="border-radius: 15px;">
                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background: #f0fdf4; color: #16a34a;">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 10px; letter-spacing: 1px;">Collected</div>
                    <div class="h5 fw-bolder mb-0">৳{{ number_format($currentCollected, 0) }}</div>
                </div>
            </div>

            <!-- Expected Card -->
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0 shadow-sm text-center p-2 p-md-3" style="border-radius: 15px;">
                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background: #eff6ff; color: #3b82f6;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 10px; letter-spacing: 1px;">Expected</div>
                    <div class="h5 fw-bolder mb-0">৳{{ number_format($currentTotal, 0) }}</div>
                </div>
            </div>

        </div>

        {{-- ══════ QUICK ACTIONS ══════ --}}
        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-bolt text-white" style="font-size:13px;"></i>
                </div>
                <h6 class="fw-bold text-dark mb-0" style="font-size:13px;text-transform:uppercase;letter-spacing:.6px;">Quick Actions</h6>
            </div>
            <div class="row g-3">

                {{-- Collect Payment (Highlighted) --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-3 h-100 position-relative overflow-hidden"
                       style="background:linear-gradient(135deg,#10b981 0%,#059669 100%);border-radius:16px;box-shadow:0 4px 18px rgba(16,185,129,0.35);transition:all .25s cubic-bezier(.4,0,.2,1);"
                       onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 28px rgba(16,185,129,0.5)'"
                       onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 18px rgba(16,185,129,0.35)'">
                        <div style="position:absolute;top:-15px;right:-15px;width:60px;height:60px;background:rgba(255,255,255,0.12);border-radius:50%;"></div>
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,0.22);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;backdrop-filter:blur(4px);">
                            <i class="fa-solid fa-hand-holding-dollar text-white" style="font-size:18px;"></i>
                        </div>
                        <div class="text-white fw-bold" style="font-size:12px;line-height:1.3;">Collect<br>Payment</div>
                        <div style="background:rgba(255,255,255,0.2);border-radius:50px;padding:2px 10px;margin-top:8px;display:inline-block;">
                            <span class="text-white" style="font-size:10px;font-weight:600;">Fee Collection</span>
                        </div>
                    </a>
                </div>

                {{-- Add Student --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('students.create', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-3 h-100"
                       style="background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;box-shadow:0 2px 10px rgba(0,0,0,0.05);transition:all .25s;"
                       onmouseover="this.style.borderColor='#4f46e5';this.style.boxShadow='0 4px 18px rgba(79,70,229,0.15)';this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)';this.style.transform='translateY(0)'">
                        <div style="width:44px;height:44px;border-radius:12px;background:#eef2ff;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="fa-solid fa-user-plus" style="color:#4f46e5;font-size:17px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:12px;line-height:1.3;">Add<br>Student</div>
                    </a>
                </div>

                {{-- Add Teacher --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('teachers.create', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-3 h-100"
                       style="background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;box-shadow:0 2px 10px rgba(0,0,0,0.05);transition:all .25s;"
                       onmouseover="this.style.borderColor='#7c3aed';this.style.boxShadow='0 4px 18px rgba(124,58,237,0.15)';this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)';this.style.transform='translateY(0)'">
                        <div style="width:44px;height:44px;border-radius:12px;background:#f5f3ff;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="fa-solid fa-chalkboard-user" style="color:#7c3aed;font-size:17px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:12px;line-height:1.3;">Add<br>Teacher</div>
                    </a>
                </div>

                {{-- Student List --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('students.index', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-3 h-100"
                       style="background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;box-shadow:0 2px 10px rgba(0,0,0,0.05);transition:all .25s;"
                       onmouseover="this.style.borderColor='#f59e0b';this.style.boxShadow='0 4px 18px rgba(245,158,11,0.15)';this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)';this.style.transform='translateY(0)'">
                        <div style="width:44px;height:44px;border-radius:12px;background:#fffbeb;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="fa-solid fa-users" style="color:#f59e0b;font-size:17px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:12px;line-height:1.3;">Student<br>List</div>
                    </a>
                </div>

                {{-- Attendance --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('attendance.index', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-3 h-100"
                       style="background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;box-shadow:0 2px 10px rgba(0,0,0,0.05);transition:all .25s;"
                       onmouseover="this.style.borderColor='#ec4899';this.style.boxShadow='0 4px 18px rgba(236,72,153,0.15)';this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)';this.style.transform='translateY(0)'">
                        <div style="width:44px;height:44px;border-radius:12px;background:#fdf2f8;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="fa-solid fa-clipboard-check" style="color:#ec4899;font-size:17px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:12px;line-height:1.3;">Take<br>Attendance</div>
                    </a>
                </div>

                {{-- School Settings --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('school.settings', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-3 h-100"
                       style="background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;box-shadow:0 2px 10px rgba(0,0,0,0.05);transition:all .25s;"
                       onmouseover="this.style.borderColor='#64748b';this.style.boxShadow='0 4px 18px rgba(100,116,139,0.15)';this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)';this.style.transform='translateY(0)'">
                        <div style="width:44px;height:44px;border-radius:12px;background:#f8fafc;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <i class="fa-solid fa-gear" style="color:#64748b;font-size:17px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:12px;line-height:1.3;">School<br>Settings</div>
                    </a>
                </div>

            </div>
        </div>

        {{-- Main Content Charts/Tables --}}

        <div class="row g-4 mb-4">
            {{-- Unpaid Student List --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; box-shadow: 0 8px 28px rgba(15,23,42,0.06) !important; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3" style="border-bottom: 1.5px solid #f1f5f9;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #ef4444, #dc2626); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(239,68,68,0.3);">
                                    <i class="fa-solid fa-file-invoice-dollar text-white" style="font-size: 16px;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 16px; font-family: 'Outfit', sans-serif;">Unpaid Student Fees</h5>
                                    <p class="text-muted mb-0" style="font-size: 12px;">তালিকা ফিল্টার করে বকেয়া ফি চেক করুন</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <select id="unpaidMonthFilter"
                                        class="form-select form-select-sm"
                                        style="width: 155px; min-width: 155px; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 7px 30px 7px 12px; font-size: 12.5px; font-weight: 600; color: #475569; background-color: #f8fafc; cursor: pointer; transition: all .2s;"
                                        onmouseover="this.style.borderColor='#4f46e5'"
                                        onmouseout="this.style.borderColor='#e2e8f0'">
                                    @for ($i = -3; $i < 5; $i++)
                                        @php $m = now()->addMonths($i)->format('F-Y'); @endphp
                                        <option value="{{ $m }}" {{ $m == now()->format('F-Y') ? 'selected' : '' }}>{{ $m }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div id="unpaidListContainer">
                            <div class="text-center py-5">
                                <div class="spinner-grow text-primary" role="status"></div>
                                <p class="mt-2 text-muted small">তালিকা লোড হচ্ছে...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attendance Pie Chart --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Attendance Overview</h5>
                        <div style="height: 300px; position: relative;" class="d-flex align-items-center justify-content-center">
                            <canvas id="attendancePieChart"></canvas>
                            <div class="position-absolute text-center">
                                <h2 class="fw-bolder mb-0 text-primary">{{ $presentCount }}</h2>
                                <p class="small text-muted mb-0">Present Today</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Class-wise Collection --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-md-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="card-title mb-1">Class-wise Collection</h5>
                                <p class="text-muted small">প্রতিটি ক্লাসের বর্তমান মাসের মোট সংগ্রহ।</p>
                            </div>
                            <select id="feeMonthFilter" class="form-select form-select-sm border-0 bg-light rounded-pill px-3" style="width: auto;">
                                @for ($m=1; $m<=12; $m++)
                                    <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div style="height:320px;">
                            <canvas id="classFeeBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Attendance Logs --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Attendance Logs</h5>
                        <div class="table-responsive">
                            <table class="table table-hover border-0">
                                <thead class="bg-light border-0">
                                    <tr>
                                        <th class="border-0 small fw-bold text-uppercase py-3">Teacher</th>
                                        <th class="border-0 small fw-bold text-uppercase py-3">Class</th>
                                        <th class="border-0 small fw-bold text-uppercase py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @foreach($attendanceLogs as $log)
                                    <tr class="align-middle">
                                        <td class="py-3">
                                            <div class="fw-medium">{{ Str::limit($log->teacher->name, 15) }}</div>
                                        </td>
                                        <td class="py-3 small text-muted">{{ $log->class->name }}</td>
                                        <td class="py-3">
                                            <span class="badge bg-soft-success text-success rounded-pill px-3 py-2">OK</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if($attendanceLogs->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted small">
                                            <i class="fa-solid fa-info-circle mb-2 d-block fs-4 opacity-50"></i>
                                            No logs found for today
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    function loadUnpaidList(month, page = 1) {
        $('#unpaidListContainer').html(`
            <div class="text-center py-5">
                <div class="spinner-grow text-primary" role="status"></div>
                <p class="mt-2 text-muted">বকেয়া তালিকা লোড হচ্ছে...</p>
            </div>
        `);

        $.ajax({
            url: "{{ route('school.unpaid.ajax', ['tenant' => auth()->user()->school->slug]) }}?page=" + page,
            method: 'GET',
            data: { month: month },
            success: function(response) {
                $('#unpaidListContainer').html(response.html);
                $('.unpaid-pagination-wrapper .pagination').addClass('pagination-sm justify-content-center');
            },
            error: function() {
                $('#unpaidListContainer').html('<p class="text-danger text-center">ডাটা লোড করতে সমস্যা হয়েছে!</p>');
            }
        });
    }

    $(document).on('click', '#unpaidPaginationLinks a, .pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if(url) {
            let page = url.split('page=')[1];
            let month = $('#unpaidMonthFilter').val();
            loadUnpaidList(month, page);
        }
    });

    $('#unpaidMonthFilter').on('change', function() {
        loadUnpaidList($(this).val(), 1);
    });

    // Attendance Pie Chart
    const ctxPie = document.getElementById('attendancePieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent'],
            datasets: [{
                data: [{{ $presentCount }}, {{ $absentCount }}],
                backgroundColor: ['#10b981', '#ef4444'],
                hoverBackgroundColor: ['#059669', '#dc2626'],
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // Class Fee Bar Chart
    const ctxBar = document.getElementById('classFeeBarChart').getContext('2d');
    const gradient = ctxBar.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, '#4f46e5');
    gradient.addColorStop(1, '#7c3aed');

    let classFeeBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($classNames) !!},
            datasets: [{
                label: 'Collection (৳)',
                data: {!! json_encode($classFees) !!},
                backgroundColor: gradient,
                borderRadius: 8,
                hoverBackgroundColor: '#4338ca'
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false }
                },
                x: {
                    grid: { display: false, drawBorder: false }
                }
            }
        }
    });

    $('#feeMonthFilter').on('change', function() {
        const monthNum = $(this).val();
        $.ajax({
            url: "{{ route('school.fee.filter', ['tenant' => auth()->user()->school->slug]) }}",
            method: 'GET',
            data: { month: monthNum },
            success: function(response) {
                classFeeBarChart.data.labels = response.classNames;
                classFeeBarChart.data.datasets[0].data = response.classFees;
                classFeeBarChart.update();
            }
        });
    });

    loadUnpaidList($('#unpaidMonthFilter').val());
});
</script>
@endsection