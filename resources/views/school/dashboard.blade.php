@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Greeting Section --}}
        @php
            $hour = date('H');
            if ($hour >= 5 && $hour < 12) {
                $greeting = "Good Morning"; $icon = "sun";
            } elseif ($hour >= 12 && $hour < 17) {
                $greeting = "Good Afternoon"; $icon = "sunrise";
            } elseif ($hour >= 17 && $hour < 21) {
                $greeting = "Good Evening"; $icon = "sunset";
            } else {
                $greeting = "Good Night"; $icon = "moon";
            }
        @endphp

        <div class="d-flex align-items-center mb-4">
            <div class="me-3">
                <i data-feather="{{ $icon }}" class="text-warning" style="width: 30px; height: 30px;"></i>
            </div>
            <div>
                <h4 class="mb-0">{{ $greeting }}, {{ auth()->user()->name }}!</h4>
                <p class="text-muted">EduCorexa: আপনার স্কুলের আজকের সারসংক্ষেপ।</p>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row">


            @component('components.dash-card', [
                'title' => 'Expected (Current Month)', 
                'value' => $currentTotal, 
                'icon' => 'fa-calendar-day', 
                'color' => 'primary', 
                'currency' => '৳'
            ]) @endcomponent

            @component('components.dash-card', [
                'title' => 'Collected (Current Month)', 
                'value' => $currentCollected, 
                'icon' => 'fa-check-double', 
                'color' => 'success', 
                'currency' => '৳'
            ]) @endcomponent

            @component('components.dash-card', [
                'title' => 'Total Expected (All Time)', 
                'value' => $allTimeTotal, 
                'icon' => 'fa-file-invoice-dollar', 
                'color' => 'info', 
                'currency' => '৳'
            ]) @endcomponent

            @component('components.dash-card', [
                'title' => 'Total Collected (All Time)', 
                'value' => $allTimeCollected, 
                'icon' => 'fa-hand-holding-dollar', 
                'color' => 'warning', 
                'currency' => '৳'
            ]) @endcomponent

            @component('components.dash-card', ['title' => 'Students', 'value' => $totalStudents, 'icon' => 'fa-user', 'color' => 'info']) @endcomponent
            @component('components.dash-card', ['title' => 'Teachers', 'value' => $totalTeachers, 'icon' => 'fa-chalkboard-teacher', 'color' => 'info']) @endcomponent
        </div>

        <div class="row my-3">
            {{-- Unpaid Student List (Loaded via Ajax) --}}
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-md-0"><i class="fa-solid fa-clock-rotate-left me-2"></i>Unpaid Students</h6>
                            <select id="unpaidMonthFilter" class="form-select form-select-sm" style="width: auto;">
                                @for ($i = -3; $i < 5; $i++)
                                    @php $m = now()->addMonths($i)->format('F-Y'); @endphp
                                    <option value="{{ $m }}" {{ $m == now()->format('F-Y') ? 'selected' : '' }}>{{ $m }}</option>
                                @endfor
                            </select>
                        </div>

                        <div id="unpaidListContainer">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2">বকেয়া তালিকা লোড হচ্ছে...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Today's Attendance Pie Chart --}}
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title">Today's Attendance Overview</h6>
                        <div style="height: 250px; position: relative;">
                            <canvas id="attendancePieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 3: Class-wise Fee & Attendance Trend --}}
        <div class="row my-3">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title">Class-wise Collection</h6>
                            <div class="d-flex gap-2">
                                <select id="feeMonthFilter" class="form-select form-select-sm">
                                    @for ($m=1; $m<=12; $m++)
                                        <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div style="height:300px;">
                            <canvas id="classFeeBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title">Attendance Logs (Today)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr><th>Teacher</th><th>Class</th><th>Status</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($attendanceLogs as $log)
                                    <tr>
                                        <td>{{ Str::limit($log->teacher->name, 12) }}</td>
                                        <td>{{ $log->class->name }}</td>
                                        <td><span class="badge bg-soft-success text-success">OK</span></td>
                                    </tr>
                                    @endforeach
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
    // ১. আনপেইড লিস্ট লোড করার ফাংশন
    function loadUnpaidList(month) {
        $('#unpaidListContainer').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>');
        $.ajax({
            url: "{{ route('school.unpaid.ajax', ['tenant' => auth()->user()->school->slug]) }}",
            method: 'GET',
            data: { month: month },
            success: function(response) {
                $('#unpaidListContainer').html(response.html);
            }
        });
    }

    // ২. অ্যাটেনডেন্স পাই চার্ট (ইনিশিয়াল)
    const ctxPie = document.getElementById('attendancePieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent'],
            datasets: [{
                data: [{{ $presentCount }}, {{ $absentCount }}],
                backgroundColor: ['#10b981', '#ef4444'],
                cutout: '70%'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // ৩. ক্লাস-ভিত্তিক ফি বার চার্ট (ইনিশিয়াল)
    const ctxBar = document.getElementById('classFeeBarChart').getContext('2d');
    let classFeeBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($classNames) !!},
            datasets: [{
                label: 'Collection (৳)',
                data: {!! json_encode($classFees) !!},
                backgroundColor: '#6366f1',
                borderRadius: 5
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });

    
    // আনপেইড লিস্ট ফিল্টার
    $('#unpaidMonthFilter').on('change', function() {
        loadUnpaidList($(this).val());
    });

  
    $('#feeMonthFilter').on('change', function() {
        const monthNum = $(this).val();
        $.ajax({
            url: "{{ route('school.fee.filter', ['tenant' => auth()->user()->school->slug]) }}",
            method: 'GET',
            data: { month: monthNum },
            success: function(response) {
                // চার্টের ডাটা আপডেট
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