@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('customJs')
<script>
    function loadUnpaidFees(url = null) {
        let fetchUrl = url || '{{ route("school.unpaid.ajax") }}';
        let month = $('#feeMonthFilter').val();
        
        // If it's the base URL, append month
        if (!url) {
            fetchUrl += '?month=' + month;
        } else {
            // URL from pagination might already have month, or we can append it if missing
            let urlObj = new URL(fetchUrl, window.location.origin);
            urlObj.searchParams.set('month', month);
            fetchUrl = urlObj.toString();
        }

        $('#unpaidListContainer').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>');
        
        $.ajax({
            url: fetchUrl,
            type: 'GET',
            success: function(res) {
                if (res.html) {
                    $('#unpaidListContainer').html(res.html);
                }
            },
            error: function() {
                $('#unpaidListContainer').html('<div class="text-center text-danger py-3">Failed to load data.</div>');
            }
        });
    }

    $(document).ready(function() {
        loadUnpaidFees();

        $('#feeMonthFilter').change(function() {
            loadUnpaidFees();
        });

        $(document).on('click', '#unpaidPaginationLinks a', function(e) {
            e.preventDefault();
            loadUnpaidFees($(this).attr('href'));
        });

        $(document).on('click', '.btn-send-reminder', function() {
            let btn = $(this);
            let id = btn.data('id');
            let originalIcon = btn.html();
            
            btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').prop('disabled', true);
            
            let url = '{{ route("school.unpaid.remind", ["tenant" => app("currentSchool")->slug, "id" => ":id"]) }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    btn.html(originalIcon).prop('disabled', false);
                    if(res.success) {
                        if(typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                                timer: 3000,
                                showConfirmButton: false
                            });
                        } else {
                            alert(res.message);
                        }
                    } else {
                        if(typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: res.message
                            });
                        } else {
                            alert(res.message);
                        }
                    }
                },
                error: function(xhr) {
                    btn.html(originalIcon).prop('disabled', false);
                    let errorMsg = 'Failed to send reminder. Please try again.';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    if(typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMsg
                        });
                    } else {
                        alert(errorMsg);
                    }
                }
            });
        });

        // Monthly Collection Chart (Using Chart.js for stability)
        if ($('#monthlyCollectionChart').length > 0 && typeof Chart !== 'undefined') {
            const ctx = document.getElementById('monthlyCollectionChart').getContext('2d');
            
            // Create Gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($lastSixMonths ?? []),
                    datasets: [{
                        label: 'Collection',
                        data: @json($monthlyChartData ?? []),
                        borderColor: '#4f46e5',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' ৳' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                            ticks: { 
                                callback: function(value) {
                                    return '৳' + (value >= 1000 ? (value/1000) + 'k' : value);
                                }
                            }
                        },
                        x: { 
                            grid: { display: false, drawBorder: false },
                            ticks: {
                                callback: function(val, index) {
                                    let label = this.getLabelForValue(val);
                                    return label.split('-')[0]; // Only month name
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
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
        <div class="welcome-card mb-4 p-4 p-md-5">
            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="greet-icon-box d-none d-sm-flex">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor == '#3b82f6' ? '#60a5fa' : $greetColor }}"></i>
                        </div>
                        <h2 class="mb-0 fw-bold">
                            {{ $greeting }}, {{ auth()->user()->name }}!
                        </h2>
                    </div>
                    <p class="mb-0 opacity-75 fs-6 fs-md-5" style="max-width:600px;">
                        EduCorexa: আপনার স্কুলের গুরুত্বপূর্ণ তথ্যসমূহ এক নজরে দেখে নিন।
                    </p>
                    <div class="mt-4 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <span class="badge bg-opacity-10 border border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-calendar-days me-1"></i> {{ now()->format('d M Y') }}
                        </span>
                        <span class="badge bg-opacity-10 border  border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-clock me-1"></i> {{ now()->format('h:i A') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <i class="fa-solid fa-graduation-cap text-dark opacity-10" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="row g-4 mb-4">

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f0fdf4; color:#16a34a;">
                            <i class="fa-solid fa-sack-dollar"></i>
                        </div>
                        <span class="stat-badge" style="background:#dcfce7;color:#16a34a;">Collected</span>
                    </div>
                    <div class="stat-label">Total Earning</div>
                    <div class="stat-value">৳{{ number_format($totalCollected, 0) }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#fff7ed; color:#ea580c;">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <span class="stat-badge" style="background:#ffedd5;color:#9a3412;">Receivable</span>
                    </div>
                    <div class="stat-label">Total Expected</div>
                    <div class="stat-value">৳{{ number_format($totalExpected, 0) }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#eff6ff; color:#3b82f6;">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <span class="stat-badge" style="background:#dcfce7;color:#16a34a;">Active</span>
                    </div>
                    <div class="stat-label">Total Students</div>
                    <div class="stat-value">{{ $totalStudents }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#fef3c7; color:#d97706;">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <span class="stat-badge" style="background:#fef3c7;color:#d97706;">Staff</span>
                    </div>
                    <div class="stat-label">Total Teachers</div>
                    <div class="stat-value">{{ $totalTeachers }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f0fdf4; color:#16a34a;">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <span class="stat-badge" style="background:#dcfce7;color:#16a34a;">Available</span>
                    </div>
                    <div class="stat-label">Classes</div>
                    <div class="stat-value">{{ $classesCount ?? 0 }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f5f3ff; color:#7c3aed;">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <span class="stat-badge" style="background:#e0e7ff;color:#4338ca;">Attendance</span>
                    </div>
                    <div class="stat-label">Present Today</div>
                    <div class="stat-value">{{ $presentCount ?? 0 }}</div>
                </div>
            </div>

        </div>

        {{-- ===== BENTO GRID: Quick Actions + Activity Feed ===== --}}
        <div class="row g-4 mb-4">

            {{-- Quick Actions --}}
            <div class="col-md-4">
                <div class="quick-actions-card">
                    <h5 class="mb-1 fw-bold" style="font-family:'Outfit',sans-serif;">Quick Actions</h5>
                    <p class="mb-4" style="font-size:0.85rem;">Execute common tasks instantly.</p>

                    <a href="{{ route('students.create') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-plus"></i> Add New Student
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('teachers.create') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-person-chalkboard"></i> Add New Teacher
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('attendances.index') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-clipboard-check"></i> Mark Attendance
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('exams.index') ?? '#' }}" class="quick-action-btn mb-0">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-pen"></i> Manage Exams
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="col-md-8">
                <div class="activity-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif;">Recent Attendance Logs</h5>
                    </div>
                    <div class="d-flex flex-column gap-4">
                        @forelse($attendanceLogs ?? [] as $log)
                        <div class="activity-item">
                            <div class="activity-avatar">
                                <div class="avatar-icon" style="background:#eef2ff;color:#4f46e5;">
                                    {{-- যেহেতু পুরো ক্লাসের হাজিরা শেষ, তাই এখানে একটি 'ইউজার-টাই' বা 'বুক' আইকন সুন্দর দেখাবে --}}
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <div class="activity-badge" style="background:#22c55e;">
                                    <i class="fa-solid fa-check" style="color:#fff;font-size:8px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0" style="font-weight:700;font-size:0.9rem;">
                                        {{ $log->teacher->name ?? 'Unknown Teacher' }}
                                        <span style="font-weight:400;color:#64748b;"> - {{ $log->class->name ?? 'N/A' }}</span>
                                    </p>
                                    {{-- গ্রুপের শেষ হাজিরার সময়টি দেখাবে --}}
                                    <span style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;margin-left:12px;">
                                        {{ \Carbon\Carbon::parse($log->last_marked)->format('h:i A') }}
                                    </span>
                                </div>
                                <p class="mb-0 mt-1" style="font-size:0.8rem;color:#94a3b8;">
                                    <i class="fa-solid fa-circle-check text-success" style="font-size:10px;"></i>
                                    Attendance Completed for <strong>{{ $log->section->name ?? 'All Sections' }}</strong>
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fa-solid fa-inbox fa-2x mb-2" style="color:#cbd5e1;"></i>
                            <p class="text-muted mb-0">No attendance marked yet today.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== BOTTOM ROW: Attendance Activity Chart ===== --}}
        <div class="row g-4">

            
            {{-- Attendance Table --}}
            <div class="col-md-8">
                <div class="schools-panel">
                    <div class="panel-header">
                        <h6 class="panel-title">Today's Attendance Summary</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table edu-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Class & Section</th>
                                    <th class="text-center">Status</th>
                                    <th>Marked By</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceLogs ?? [] as $key => $log)
                                <tr>
                                    <td class="stat-index">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="item-icon d-none d-sm-flex"><i class="fa-solid fa-chalkboard"></i></div>
                                            <div class="text-start">
                                                <div class="item-name text-truncate" style="max-width:120px;">{{ $log->class->name ?? 'N/A' }}</div>
                                                <div class="item-date">Section: {{ $log->section->name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($log->status == 'present')
                                            <span class="badge-edu badge-present">✓ Present</span>
                                        @else
                                            <span class="badge-edu badge-absent">✗ Absent</span>
                                        @endif
                                    </td>
                                    <td class="teacher-name">
                                        {{ $log->teacher->name ?? 'Admin' }}
                                    </td>
                                    <td class="time-stamp">
                                        {{ $log->last_marked ? \Carbon\Carbon::parse($log->last_marked)->format('h:i A') : 'N/A' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="opacity-25 mb-2">
                                            <i class="fa-solid fa-clipboard-question fa-3x"></i>
                                        </div>
                                        <p class="text-muted">No attendance activity recorded for today.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($attendanceLogs->hasPages())
                    <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="small text-muted">
                            Showing {{ $attendanceLogs->firstItem() }} to {{ $attendanceLogs->lastItem() }} of {{ $attendanceLogs->total() }} results
                        </div>
                        <div class="attendance-pagination">
                            {!! $attendanceLogs->appends(['attendance_page' => request('attendance_page')])->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Attendance Chart (Dynamic Bars) --}}
            <div class="col-md-4 d-flex flex-column gap-4">
                <div class="attendance-card flex-grow-1">
                    <div style="position:relative;z-index:1;">
                        <h6 class="fw-bold mb-0 text-dark" style="font-family:'Outfit',sans-serif;">Attendance This Week</h6>
                        <p class="text-muted" style="font-size:0.75rem;margin-bottom:20px;">Daily attendance percentage</p>
                        
                        <div class="bar-chart">
                            @php
                                $currentDay = date('D');
                                // $weekDays কন্ট্রোলার থেকে আসছে
                            @endphp

                            @foreach($weekDays as $day)
                                @php
                                    // কন্ট্রোলার থেকে আসা $weeklyStats অ্যারে থেকে ডাটা নেয়া
                                    $percentage = $weeklyStats[$day] ?? 0; 
                                    $isActive = ($day == $currentDay);
                                @endphp
                                <div class="bar {{ $isActive ? 'active' : '' }}" 
                                    style="height: {{ $percentage }}%;" 
                                    data-bs-toggle="tooltip" 
                                    title="{{ $day }}: {{ $percentage }}%">
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mt-2 text-muted" style="font-size:0.7rem;">
                            @foreach($weekDays as $day)
                                <span class="{{ $day == $currentDay ? 'text-dark fw-bold' : '' }}">{{ $day }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== FINANCIAL INSIGHTS: Class-wise & Monthly Collection ===== --}}
        <div class="row g-4 mb-4">
            {{-- Class-wise Collection --}}
            <div class="col-md-5">
                <div class="activity-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif;">Class-wise Collection</h5>
                        <span class="badge bg-soft-success text-success px-2 py-1 rounded-pill small">This Month</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                @forelse($classWiseCollection ?? [] as $collection)
                                <tr>
                                    <td class="ps-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-icon small" style="background:#f0fdf4;color:#16a34a; width:30px; height:30px; font-size:0.8rem;">
                                                <i class="fa-solid fa-graduation-cap"></i>
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size:0.9rem;">{{ $collection->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-0">
                                        <div class="fw-bold text-success">৳{{ number_format($collection->total_collected) }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-muted small">No data available for this month.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Monthly Collection Graph --}}
            <div class="col-md-7">
                <div class="activity-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif;">Monthly Collection Trend</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon-custom btn-soft-secondary" type="button" id="financialDropdown" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-download me-2"></i>Export Data</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="chart-container" style="position: relative; height:250px; width:100%">
                        <canvas id="monthlyCollectionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== BOTTOM ROW: Unpaid Fees & Recent Payments ===== --}}
        <div class="row g-4 mt-2">
            
            {{-- Unpaid Student Fees --}}
            <div class="col-md-8">
                <div class="schools-panel h-100">
                    <div class="panel-header d-flex flex-wrap justify-content-between align-items-center">
                        <h6 class="panel-title mb-0">Unpaid Student Fees</h6>
                        <div class="d-flex gap-2 mt-2 mt-sm-0">
                            <select id="feeMonthFilter" class="form-select form-select-sm" style="width: auto;">
                                @php
                                    $months = [];
                                    for ($i = 0; $i < 6; $i++) {
                                        $m = now()->subMonths($i)->format('F-Y');
                                        $months[] = $m;
                                    }
                                @endphp
                                @foreach($months as $m)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-primary" onclick="loadUnpaidFees()">
                                <i class="fa-solid fa-arrows-rotate"></i>
                            </button>
                        </div>
                    </div>
                    <div id="unpaidListContainer" class="p-3 position-relative" style="min-height: 200px;">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Payments (Feed Style) --}}
            <div class="col-md-4">
                <div class="activity-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif; font-size:1rem;">Recent Payments</h5>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @forelse($recentPayments ?? [] as $payment)
                        <div class="activity-item">
                            <div class="activity-avatar">
                                <div class="avatar-icon" style="background:#dcfce7;color:#16a34a;">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                                <div class="activity-badge" style="background:#22c55e;">
                                    <i class="fa-solid fa-check" style="color:#fff;font-size:8px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0" style="font-weight:700;font-size:0.85rem;">
                                        {{ $payment->student->name ?? 'Student' }}
                                    </p>
                                    <span style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;">
                                        {{ $payment->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="mb-0" style="font-size:0.8rem;color:#64748b;">
                                    ৳{{ number_format($payment->amount) }} - {{ $payment->feeHead->name ?? 'General Fee' }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fa-solid fa-receipt fa-2x mb-2" style="color:#cbd5e1;"></i>
                            <p class="text-muted mb-0" style="font-size:0.8rem;">No recent payments recorded.</p>
                        </div>
                        @endforelse
                    </div>
                    @if(count($recentPayments ?? []) > 0)
                    <div class="mt-4 text-center">
                        <a href="{{ route('student-fees.index') ?? '#' }}" class="btn btn-sm btn-outline-primary w-100">View All Payments</a>
                    </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
