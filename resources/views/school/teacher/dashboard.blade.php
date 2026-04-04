@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="container-fluid">
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
                <p class="text-muted mb-0">আপনার আজকের ক্লাসের সময়সূচী এবং ডায়েরি আপডেট চেক করুন।</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div style="width: 50px; height: 50px; background-color: rgba(25, 135, 84, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa-solid fa-hand-holding-dollar fs-4 text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">আমার কালেকশন</p>
                                <h3 class="mb-0 fw-bold">৳ {{ number_format($myTotalCollected) }}</h3>
                                <small class="text-success">আজ: ৳{{ number_format($todayCollected) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div style="width: 50px; height: 50px; background-color: rgba(13, 110, 253, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa-solid fa-users fs-4 text-primary"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">আমার শিক্ষার্থী</p>
                                <h3 class="mb-0 fw-bold">{{ $totalStudents ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div style="width: 50px; height: 50px; background-color: rgba(25, 135, 84, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa-solid fa-chalkboard fs-4 text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">আজকের ক্লাস</p>
                                <h3 class="mb-0 fw-bold">5</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div style="width: 50px; height: 50px; background-color: rgba(255, 193, 7, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa-solid fa-book fs-4 text-warning"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">বাকি ডায়েরি</p>
                                <h3 class="mb-0 fw-bold">{{ $pendingDiaries ?? 0 }}টি</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div style="width: 50px; height: 50px; background-color: rgba(220, 53, 69, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa-solid fa-envelope-open-text fs-4 text-danger"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">ছুটির আবেদন</p>
                                <h3 class="mb-0 fw-bold">{{ $leaveRequests ?? 0 }}টি</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <!-- <div class="row">
            <div class="col-md-7 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-calendar-day me-2 text-primary"></i>আজকের ক্লাস রুটিন</h6>
                        <span class="badge bg-primary-soft text-primary">{{ date('l, d M') }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">সময়</th>
                                        <th>ক্লাস ও শাখা</th>
                                        <th>বিষয়</th>
                                        <th class="text-center">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($routines ?? [] as $routine)
                                    <tr>
                                        <td class="ps-3">
                                            <span class="fw-bold text-primary">{{ $routine->start_time }}</span><br>
                                            <small class="text-muted">{{ $routine->end_time }}</small>
                                        </td>
                                        <td>
                                            <span class="d-block fw-bold">{{ $routine->class->name }}</span>
                                            <small class="text-muted">শাখা: {{ $routine->section->name }}</small>
                                        </td>
                                        <td>{{ $routine->subject->name }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">হাজিরা নিন</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">আজ আপনার কোনো নির্ধারিত ক্লাস নেই।</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-bullhorn me-2 text-danger"></i>জরুরী নোটিশ</h6>
                    </div>
                    <div class="card-body">
                        @forelse($notices ?? [] as $notice)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <div class="me-3 text-center bg-light rounded p-2" style="min-width: 60px;">
                                <h5 class="mb-0 fw-bold text-primary">{{ date('d', strtotime($notice->created_at)) }}</h5>
                                <small class="text-uppercase text-muted">{{ date('M', strtotime($notice->created_at)) }}</small>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $notice->title }}</h6>
                                <p class="text-muted text-sm mb-0">{{ Str::limit($notice->description, 60) }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fa-solid fa-comment-slash fs-1 text-light mb-3"></i>
                            <p class="text-muted">কোনো নতুন নোটিশ নেই।</p>
                        </div>
                        @endforelse
                        <a href="#" class="btn btn-light w-100 mt-2">সব নোটিশ দেখুন</a>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-md-7 mt-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-md-0">আমার ক্লাসের হাজিরা রিপোর্ট (বিগত ৭ দিন)</h6>
                            <button class="btn btn-sm btn-primary">বিস্তারিত রিপোর্ট</button>
                        </div>
                        <div class="chart-container" style="position: relative; height:300px; width:100%">
                            <canvas id="teacherAttendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mt-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center mb-3">
                                <h6 class="card-title mb-md-0">আমার সর্বশেষ ফি কালেকশনসমূহ</h6>
                                
                            </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>রোল</th>
                                        <th class="ps-3">তারিখ</th>
                                        <th>শিক্ষার্থীর নাম</th>
                                        <th>ফি'র খাত</th>
                                        <th class="text-end pe-3">পরিমাণ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentCollections as $collection)
                                    <tr>
                                        <td>{{ $collection->student->roll }}</td>
                                        <td class="ps-3">{{ $collection->created_at->format('d M, Y') }}</td>
                                        <td>{{ $collection->student->name }}</td>
                                        <td>{{ $collection->feeHead->name ?? 'জেনারেল ফি' }}</td>
                                        <td class="text-end pe-3 fw-bold text-success">৳{{ number_format($collection->amount) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">আপনি এখনও কোনো ফি কালেক্ট করেননি।</td>
                                    </tr>
                                    @endforelse
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
    const ctx = document.getElementById('teacherAttendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($lastSevenDays ?? ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri']) !!},
            datasets: [{
                label: 'উপস্থিতি (%)',
                data: {!! json_encode($attendanceStats ?? [85, 90, 88, 92, 80, 95, 89]) !!},
                borderColor: '#6571ff',
                backgroundColor: 'rgba(101, 113, 255, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 100, grid: { color: '#f3f3f3' } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endsection