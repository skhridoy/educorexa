@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
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
        <div class="welcome-card mb-5 p-4 p-md-5 position-relative overflow-hidden" 
             style="border-radius:24px; background:linear-gradient(135deg, #002147 0%, #003366 100%); color:white; box-shadow: 0 10px 30px rgba(0,33,71,0.15);">
            <!-- Abstract background shapes -->
            <div style="position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
            <div style="position:absolute; bottom:-30px; left:10%; width:100px; height:100px; background:rgba(255,204,0,0.1); border-radius:50%; filter:blur(20px);"></div>
            
            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="greet-icon-box" style="width:50px; height:50px; background:rgba(255,255,255,0.1); border-radius:14px; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(10px);">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor == '#3b82f6' ? '#60a5fa' : $greetColor }}"></i>
                        </div>
                        <h2 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif; letter-spacing:-0.02em;">
                            {{ $greeting }}, {{ auth()->user()->name }}!
                        </h2>
                    </div>
                    <p class="mb-0 opacity-75 fs-5" style="max-width:600px;">
                        EduCorexa: আপনার স্কুলের আজকের গুরুত্বপূর্ণ তথ্যসমূহ এক নজরে দেখে নিন।
                    </p>
                    <div class="mt-4 d-flex gap-2">
                        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-calendar-days me-1"></i> {{ now()->format('l, d M Y') }}
                        </span>
                        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-clock me-1"></i> {{ now()->format('h:i A') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0 d-none d-md-block">
                    <i class="fa-solid fa-graduation-cap text-white opacity-10" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>

        {{-- Statistics Grid --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#eff6ff; color:#3b82f6;">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <span class="badge bg-soft-success text-success" style="font-size:10px;">Expected</span>
                    </div>
                    <div class="stat-label">Total Expected</div>
                    <div class="stat-value">৳ {{ number_format($currentTotal) }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f0fdf4; color:#16a34a;">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </div>
                        <span class="badge bg-soft-success text-success" style="font-size:10px;">Collected</span>
                    </div>
                    <div class="stat-label">Total Collected</div>
                    <div class="stat-value">৳ {{ number_format($currentCollected) }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#fef3c7; color:#d97706;">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                    </div>
                    <div class="stat-label">Total Students</div>
                    <div class="stat-value">{{ $totalStudents }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f5f3ff; color:#7c3aed;">
                            <i class="fa-solid fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                    <div class="stat-label">Total Teachers</div>
                    <div class="stat-value">{{ $totalTeachers }}</div>
                </div>
            </div>
        </div>

        {{-- Main Content Charts/Tables --}}
        <div class="row g-4 mb-4">
            {{-- Unpaid Student List --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-md-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="card-title mb-1">Unpaid Students</h5>
                                <p class="text-muted small">তালিকাটি ফিল্টার করে বকেয়া ফি চেক করুন।</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <select id="unpaidMonthFilter" class="form-select form-select-sm border-0 bg-light rounded-pill px-3" style="width: auto;">
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
                                <p class="mt-2 text-muted">তালিকা লোড হচ্ছে...</p>
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