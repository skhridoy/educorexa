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
            if ($hour >= 5 && $hour < 12)      { $greeting = __('Good Morning');   $faIcon = "fa-sun";     $greetColor = "#f59e0b"; }
            elseif ($hour >= 12 && $hour < 17) { $greeting = __('Good Afternoon'); $faIcon = "fa-cloud-sun"; $greetColor = "#f97316"; }
            elseif ($hour >= 17 && $hour < 21) { $greeting = __('Good Evening');   $faIcon = "fa-sunset";  $greetColor = "#8b5cf6"; }
            else                               { $greeting = __('Good Night');     $faIcon = "fa-moon";    $greetColor = "#3b82f6"; }
        @endphp
        
        @php
            $authUser = auth()->user();
            $bannerUserPhoto = asset('assets/images/profile.webp');
            if ($authUser) {
                if (($authUser->role === 'super_admin' || $authUser->role === 'HR' || $authUser->role === 'Marketing') && $authUser->photo) {
                    $bannerUserPhoto = asset('uploads/super_admin/' . $authUser->photo);
                } elseif ($authUser->photo) {
                    $bannerUserPhoto = asset($authUser->photo);
                } elseif ($authUser->teacher && $authUser->teacher->photo) {
                    $bannerUserPhoto = asset($authUser->teacher->photo);
                } elseif ($authUser->student && $authUser->student->photo) {
                    $bannerUserPhoto = asset($authUser->student->photo);
                }
            }
        @endphp

        {{-- ===== WELCOME HERO CARD ===== --}}
        <div class="welcome-card mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 position-relative" style="z-index: 1;">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $bannerUserPhoto }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="welcome-user-avatar">
                    <div>
                        <h4 class="welcome-card-title">{{ $greeting }}, {{ auth()->user()->name }}</h4>
                        <p class="welcome-card-subtitle">{{ __('EduCorexa: Take a quick look at your school summary.') }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 align-self-start align-self-md-center">
                    <span class="d-none d-sm-inline-flex align-items-center gap-1 text-white text-opacity-90 fw-semibold" style="font-size: 0.76rem; background: rgba(255,255,255,0.15); padding: 7px 12px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.25);">
                        <i class="fa-regular fa-calendar-days opacity-75 me-1"></i> {{ now()->format('d M Y') }}
                    </span>
                    <a href="{{ Route::has('admin.school.info-edit') ? route('admin.school.info-edit', ['tenant' => auth()->user()->school->slug ?? '']) : '#' }}" class="btn-welcome-action">
                        {{ __("What's New!") }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Statistics Grid --}}
        <div class="row g-3 g-md-4 mb-4">
            
            <!-- Teachers Card -->
            <div class="col-6 col-md-3">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2.5">
                        <div class="icon-wrap" style="background: #f3e8ff; color: #9333ea;">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <span class="stat-badge" style="background: #f3e8ff; color: #9333ea;">Faculty</span>
                    </div>
                    <div class="stat-label">{{ __('Teachers') }}</div>
                    <div class="stat-value">{{ $totalTeachers }}</div>
                </div>
            </div>

            <!-- Students Card -->
            <div class="col-6 col-md-3">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2.5">
                        <div class="icon-wrap" style="background: #fff7ed; color: #f97316;">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <span class="stat-badge" style="background: #fff7ed; color: #f97316;">Active</span>
                    </div>
                    <div class="stat-label">{{ __('Students') }}</div>
                    <div class="stat-value">{{ $totalStudents }}</div>
                </div>
            </div>

            <!-- Collected Card -->
            <div class="col-6 col-md-3">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2.5">
                        <div class="icon-wrap" style="background: #f0fdf4; color: #16a34a;">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </div>
                        <span class="stat-badge" style="background: #f0fdf4; color: #16a34a;">Revenue</span>
                    </div>
                    <div class="stat-label">{{ __('Collected') }}</div>
                    <div class="stat-value">৳{{ number_format($currentCollected, 0) }}</div>
                </div>
            </div>

            <!-- Expected Card -->
            <div class="col-6 col-md-3">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2.5">
                        <div class="icon-wrap" style="background: #eff6ff; color: #3b82f6;">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <span class="stat-badge" style="background: #eff6ff; color: #3b82f6;">Target</span>
                    </div>
                    <div class="stat-label">{{ __('Expected') }}</div>
                    <div class="stat-value">৳{{ number_format($currentTotal, 0) }}</div>
                </div>
            </div>

        </div>

        {{-- ══════ QUICK ACTIONS ══════ --}}
        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-2.5">
                <div style="width:24px;height:24px;border-radius:5px;background:rgba(79,70,229,0.1);color:#4f46e5;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-bolt" style="font-size:11px;"></i>
                </div>
                <h6 class="fw-bold text-dark mb-0" style="font-size:12px;text-transform:uppercase;letter-spacing:.5px;">{{ __('Quick Actions') }}</h6>
            </div>
            <div class="row g-2.5 g-md-3">

                {{-- Collect Payment (Highlighted) --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-2.5 h-100 position-relative overflow-hidden"
                       style="background:transparent; border:1.5px solid #10b981; border-radius:8px; transition:all .2s;"
                       onmouseover="this.style.background='rgba(16,185,129,0.08)'"
                       onmouseout="this.style.background='transparent'">
                        <div style="width:36px;height:36px;border-radius:8px;background:rgba(16,185,129,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 6px;">
                            <i class="fa-solid fa-hand-holding-dollar" style="color:#10b981;font-size:15px;"></i>
                        </div>
                        <div class="fw-bold" style="font-size:11.5px;color:#10b981;line-height:1.3;">{{ __('Collect Payment') }}</div>
                    </a>
                </div>

                {{-- Add Student --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('students.create', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-2.5 h-100"
                       style="background:transparent;border:1.5px solid #e2e8f0;border-radius:8px;transition:all .2s;"
                       onmouseover="this.style.borderColor='#4f46e5';this.style.background='rgba(79,70,229,0.04)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.background='transparent'">
                        <div style="width:36px;height:36px;border-radius:8px;background:#eef2ff;display:flex;align-items:center;justify-content:center;margin:0 auto 6px;">
                            <i class="fa-solid fa-user-plus" style="color:#4f46e5;font-size:14px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:11.5px;line-height:1.3;">{{ __('Add Student') }}</div>
                    </a>
                </div>

                {{-- Add Teacher --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('teachers.create', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-2.5 h-100"
                       style="background:transparent;border:1.5px solid #e2e8f0;border-radius:8px;transition:all .2s;"
                       onmouseover="this.style.borderColor='#7c3aed';this.style.background='rgba(124,58,237,0.04)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.background='transparent'">
                        <div style="width:36px;height:36px;border-radius:8px;background:#f5f3ff;display:flex;align-items:center;justify-content:center;margin:0 auto 6px;">
                            <i class="fa-solid fa-chalkboard-user" style="color:#7c3aed;font-size:14px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:11.5px;line-height:1.3;">{{ __('Add Teacher') }}</div>
                    </a>
                </div>

                {{-- Student List --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('students.index', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-2.5 h-100"
                       style="background:transparent;border:1.5px solid #e2e8f0;border-radius:8px;transition:all .2s;"
                       onmouseover="this.style.borderColor='#f59e0b';this.style.background='rgba(245,158,11,0.04)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.background='transparent'">
                        <div style="width:36px;height:36px;border-radius:8px;background:#fffbeb;display:flex;align-items:center;justify-content:center;margin:0 auto 6px;">
                            <i class="fa-solid fa-users" style="color:#f59e0b;font-size:14px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:11.5px;line-height:1.3;">{{ __('Student List') }}</div>
                    </a>
                </div>

                {{-- Attendance --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('attendance.index', ['tenant' => auth()->user()->school->slug]) }}"
                       class="d-block text-decoration-none text-center p-2.5 h-100"
                       style="background:transparent;border:1.5px solid #e2e8f0;border-radius:8px;transition:all .2s;"
                       onmouseover="this.style.borderColor='#ec4899';this.style.background='rgba(236,72,153,0.04)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.background='transparent'">
                        <div style="width:36px;height:36px;border-radius:8px;background:#fdf2f8;display:flex;align-items:center;justify-content:center;margin:0 auto 6px;">
                            <i class="fa-solid fa-clipboard-check" style="color:#ec4899;font-size:14px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:11.5px;line-height:1.3;">{{ __('Take Attendance') }}</div>
                    </a>
                </div>

                {{-- School Settings --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ Route::has('admin.school.info-edit') ? route('admin.school.info-edit', ['tenant' => auth()->user()->school->slug]) : '#' }}"
                       class="d-block text-decoration-none text-center p-2.5 h-100"
                       style="background:transparent;border:1.5px solid #e2e8f0;border-radius:8px;transition:all .2s;"
                       onmouseover="this.style.borderColor='#64748b';this.style.background='rgba(100,116,139,0.04)'"
                       onmouseout="this.style.borderColor='#e2e8f0';this.style.background='transparent'">
                        <div style="width:36px;height:36px;border-radius:8px;background:#f8fafc;display:flex;align-items:center;justify-content:center;margin:0 auto 6px;">
                            <i class="fa-solid fa-gear" style="color:#64748b;font-size:14px;"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:11.5px;line-height:1.3;">{{ __('School Settings') }}</div>
                    </a>
                </div>

            </div>
        </div>

        {{-- Main Content Charts/Tables --}}

        <div class="row g-3 g-md-4 mb-4">
            {{-- Unpaid Student List --}}
            <div class="col-lg-8">
                <div class="schools-panel mb-0 h-100">
                    <div class="panel-header">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 28px; height: 28px; border-radius: 6px; background: rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-file-invoice-dollar text-danger" style="font-size: 13px;"></i>
                            </div>
                            <div>
                                <h6 class="panel-title">{{ __('Unpaid Student Fees') }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <select id="unpaidMonthFilter"
                                    class="form-select form-select-sm"
                                    style="width: 140px; border-radius: 5px; font-size: 0.76rem; font-weight: 600;">
                                @for ($i = -3; $i < 5; $i++)
                                    @php $m = now()->addMonths($i)->format('F-Y'); @endphp
                                    <option value="{{ $m }}" {{ $m == now()->format('F-Y') ? 'selected' : '' }}>{{ $m }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="p-3">
                        <div id="unpaidListContainer">
                            <div class="text-center py-5">
                                <div class="spinner-grow text-primary" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                                <p class="mt-2 text-muted small">{{ __('Loading unpaid list...') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attendance Pie Chart --}}
            <div class="col-lg-4">
                <div class="schools-panel mb-0 h-100">
                    <div class="panel-header">
                        <h6 class="panel-title"><i class="fa-solid fa-chart-pie me-2 text-primary"></i>{{ __('Attendance Overview') }}</h6>
                    </div>
                    <div class="p-3">
                        <div style="height: 260px; position: relative;" class="d-flex align-items-center justify-content-center">
                            <canvas id="attendancePieChart"></canvas>
                            <div class="position-absolute text-center">
                                <h3 class="fw-bolder mb-0 text-primary">{{ $presentCount }}</h3>
                                <p class="small text-muted mb-0" style="font-size: 0.74rem;">{{ __('Present Today') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 g-md-4">
            {{-- Class-wise Collection --}}
            <div class="col-lg-8">
                <div class="schools-panel mb-0 h-100">
                    <div class="panel-header">
                        <div>
                            <h6 class="panel-title"><i class="fa-solid fa-chart-column me-2 text-success"></i>{{ __('Class-wise Collection') }}</h6>
                        </div>
                        <select id="feeMonthFilter" class="form-select form-select-sm" style="width: auto; border-radius: 5px; font-size: 0.76rem; font-weight: 600;">
                            @for ($m=1; $m<=12; $m++)
                                <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="p-3">
                        <div style="height: 260px;">
                            <canvas id="classFeeBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Attendance Logs --}}
            <div class="col-lg-4">
                <div class="schools-panel mb-0 h-100">
                    <div class="panel-header">
                        <h6 class="panel-title"><i class="fa-solid fa-clipboard-user me-2 text-info"></i>{{ __('Attendance Logs') }}</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table edu-table align-middle mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('Teacher') }}</th>
                                    <th>{{ __('Class') }}</th>
                                    <th class="text-end">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceLogs as $log)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ Str::limit($log->teacher->name, 15) }}</div>
                                    </td>
                                    <td><span class="text-muted">{{ $log->class->name }}</span></td>
                                    <td class="text-end">
                                        <span class="badge bg-soft-success text-success px-2 py-1" style="border-radius: 5px; font-size: 0.72rem;">OK</span>
                                    </td>
                                </tr>
                                @endforeach
                                @if($attendanceLogs->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted small">
                                        <i class="fa-solid fa-info-circle mb-2 d-block fs-5 opacity-50"></i>
                                        {{ __('No logs found for today') }}
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
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    function loadUnpaidList(month, page = 1) {
        $('#unpaidListContainer').html(`
            <div class="text-center py-5">
                <div class="spinner-grow text-primary" role="status"></div>
                <p class="mt-2 text-muted">{{ __('Loading unpaid list...') }}</p>
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
            labels: ["{{ __('Present') }}", "{{ __('Absent') }}"],
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
                label: "{{ __('Collection (৳)') }}",
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