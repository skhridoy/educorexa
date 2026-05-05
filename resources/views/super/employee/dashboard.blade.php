@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Wishing Alert Logic --}}
        @php
            $hour = date('H');
            if ($hour >= 5 && $hour < 12) { $greeting = "Good Morning"; $faIcon = "fa-sun"; $greetColor = "#f59e0b"; }
            elseif ($hour >= 12 && $hour < 17) { $greeting = "Good Afternoon"; $faIcon = "fa-cloud-sun"; $greetColor = "#f97316"; }
            elseif ($hour >= 17 && $hour < 21) { $greeting = "Good Evening";   $faIcon = "fa-sunset";  $greetColor = "#8b5cf6"; }
            else                               { $greeting = "Good Night";     $faIcon = "fa-moon";    $greetColor = "#3b82f6"; }
        @endphp

        {{-- ===== WELCOME HERO CARD ===== --}}
        <div class="welcome-card mb-5 p-4 p-md-5 position-relative overflow-hidden" style="border-radius:24px; background:linear-gradient(135deg, #1e293b, #334155); color:white; box-shadow: 0 10px 30px rgba(15,23,42,0.15);">
            <div style="position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
            <div style="position:absolute; bottom:-30px; left:10%; width:100px; height:100px; background:rgba(79,70,229,0.1); border-radius:50%; filter:blur(20px);"></div>
            
            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="greet-icon-box" style="width:50px; height:50px; background:rgba(255,255,255,0.1); border-radius:14px; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(10px);">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor == '#3b82f6' ? '#60a5fa' : $greetColor }}"></i>
                        </div>
                        <h2 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif; letter-spacing:-0.02em;">
                            {{ $greeting }}, {{ $user->name }}!
                        </h2>
                    </div>
                    <p class="mb-0 opacity-75" style="font-size:1rem;">
                        Designation: <span class="fw-bold text-white">{{ $employee->designation ?? 'Team Member' }}</span> 
                        <span class="mx-2 opacity-50">|</span> 
                        ID: <span class="fw-bold text-white">{{ $employee->employee_id ?? 'N/A' }}</span>
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <div class="bg-white bg-opacity-10 p-3 rounded-4 d-inline-block border border-white border-opacity-10">
                        <div class="text-white opacity-50 small mb-1">Current Balance</div>
                        <div class="h4 mb-0 fw-bold">৳ {{ number_format($employee->salary ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Row --}}
        <div class="row g-4 mb-5">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-3" style="border-radius:18px;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#eef2ff;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#4f46e5;">
                            <i class="fa-solid fa-school fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold">Platform Schools</div>
                            <div class="h4 mb-0 fw-bold">{{ $totalSchools }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-3" style="border-radius:18px;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#f0fdf4;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#22c55e;">
                            <i class="fa-solid fa-user-check fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold">Attendance</div>
                            <div class="h4 mb-0 fw-bold">98%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-3" style="border-radius:18px;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#fff7ed;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#f97316;">
                            <i class="fa-solid fa-calendar-day fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold">Leave Days</div>
                            <div class="h4 mb-0 fw-bold">12</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm p-3" style="border-radius:18px;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#fdf2f8;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#db2777;">
                            <i class="fa-solid fa-tasks fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold">Active Tasks</div>
                            <div class="h4 mb-0 fw-bold">05</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Upcoming Events --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:20px;">
                    <div class="p-4 bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #f1f5f9;">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-star me-2 text-primary"></i> Platform Events</h6>
                        <a href="{{ route('super.events.index') }}" class="btn btn-sm btn-light px-3" style="border-radius:8px;">View All</a>
                    </div>
                    <div class="p-4">
                        <div class="row g-3">
                            @forelse($upcomingEvents as $event)
                            <div class="col-md-6">
                                <div class="event-item-small p-3 border rounded-4 d-flex gap-3 align-items-center transition-all" style="cursor:pointer; background:#f8fafc; border-color:#eef2ff !important;">
                                    <div class="date-box text-center p-2 rounded-3" style="min-width:55px; background:white; border:1px solid #eef2ff;">
                                        <div class="fw-bold text-primary" style="font-size:1.1rem; line-height:1;">{{ $event->event_date->format('d') }}</div>
                                        <div class="text-muted small fw-bold text-uppercase" style="font-size:0.6rem;">{{ $event->event_date->format('M') }}</div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size:0.9rem;">{{ $event->title }}</div>
                                        <div class="text-muted small"><i class="fa-solid fa-clock me-1"></i> {{ $event->event_time ? date('h:i A', strtotime($event->event_time)) : 'All Day' }}</div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/calendar.svg" alt="No events" style="width:120px; opacity:0.5;">
                                <p class="text-muted mt-3">No upcoming events scheduled.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile Sidebar --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 text-center" style="border-radius:20px; background:linear-gradient(to bottom, #ffffff, #f8fafc);">
                    <div class="mb-3">
                        @php
                            $folder = ($user && $user->role === 'super_admin') ? 'super_admin' : 'employees';
                            $userPhoto = ($user && $user->photo)
                                         ? asset('uploads/' . $folder . '/' . $user->photo)
                                         : asset('assets/images/profile.webp');
                        @endphp
                        <div class="position-relative d-inline-block">
                            <img src="{{ $userPhoto }}" 
                                 onerror="this.src='{{ asset('assets/images/profile.webp') }}'"
                                 class="rounded-circle shadow-sm p-1 bg-white" style="width:100px; height:100px; object-fit:cover;">
                            <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" style="width:18px;height:18px;"></div>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1" style="font-family:'Outfit',sans-serif;">{{ $user->name }}</h5>
                    <p class="text-muted small mb-4">{{ $employee->designation }}</p>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile') }}" class="btn-edu btn-edu-light w-100">My Profile</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-edu btn-edu-outline w-100 mt-2" style="border-color:#e2e8f0;">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .event-item-small:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: #4f46e5 !important;
    }
    .transition-all { transition: all 0.2s ease; }
</style>
@endsection