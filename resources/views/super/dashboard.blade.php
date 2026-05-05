@extends('layouts.main')

@section('customCSS')
<style>
    /* ===== Dashboard Specific Styles ===== */
    .edu-stat-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0px 4px 20px rgba(15, 23, 42, 0.05);
        transition: border-color 0.2s ease, transform 0.2s ease;
    }
    .edu-stat-card:hover {
        border-color: #c7d2fe;
        transform: translateY(-2px);
    }
    @media (max-width: 576px) {
        .edu-stat-card { padding: 16px; }
        .edu-stat-card .stat-value { font-size: 1.4rem; }
        .edu-stat-card .icon-wrap { width: 38px; height: 38px; font-size: 1rem; }
    }
    .edu-stat-card .icon-wrap {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem;
        transition: transform 0.2s ease;
    }
    .edu-stat-card:hover .icon-wrap { transform: scale(1.1); }
    .edu-stat-card .stat-badge {
        font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 20px;
    }
    .edu-stat-card .stat-label {
        font-size: 10px; letter-spacing: 0.08em; text-transform: uppercase;
        font-weight: 700; color: #64748b; margin-bottom: 4px;
    }
    .edu-stat-card .stat-value {
        font-size: 1.75rem; font-weight: 700; color: #1e293b; line-height: 1;
    }

    /* Quick Actions gradient card */
    .quick-actions-card {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 16px; padding: 32px; color: #ffffff;
        min-height: 100%;
    }
    .quick-action-btn {
        width: 100%; display: flex; align-items: center; justify-content: space-between;
        padding: 14px 16px; background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;
        color: #ffffff; font-weight: 600; font-size: 0.875rem;
        transition: background 0.2s ease; text-decoration: none; margin-bottom: 10px;
    }
    .quick-action-btn:hover { background: rgba(255,255,255,0.2); color: #ffffff; }
    .quick-action-btn i { font-size: 1rem; opacity: 0.7; }
    .quick-action-btn .arrow { opacity: 0; transition: opacity 0.2s, transform 0.2s; }
    .quick-action-btn:hover .arrow { opacity: 1; transform: translateX(4px); }

    /* Activity Feed */
    .activity-card {
        background: #ffffff; border: 1px solid #f1f5f9; border-radius: 16px;
        padding: 32px; box-shadow: 0px 4px 20px rgba(15,23,42,0.05);
    }
    .activity-item { display: flex; gap: 16px; }
    .activity-avatar { position: relative; flex-shrink: 0; }
    .activity-avatar img, .activity-avatar .avatar-icon {
        width: 40px; height: 40px; border-radius: 50%; object-fit: cover;
    }
    .activity-avatar .avatar-icon {
        display: flex; align-items: center; justify-content: center;
        background: #fef3c7; color: #d97706; font-size: 1rem;
    }
    .activity-badge {
        position: absolute; bottom: -2px; right: -2px;
        width: 18px; height: 18px; border-radius: 50%; border: 2px solid #fff;
        display: flex; align-items: center; justify-content: center; font-size: 9px;
    }

    /* Events panel */
    .event-item {
        padding: 16px; border-radius: 14px; border-left: 5px solid transparent;
        transition: all 0.2s ease; cursor: pointer; background: #fff;
        border: 1px solid #f1f5f9; border-left-width: 5px;
    }
    .event-item:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .event-item.blue  { border-left-color: #3b82f6; background: #f0f7ff; }
    .event-item.purple{ border-left-color: #8b5cf6; background: #f5f3ff; }
    .event-item.green { border-left-color: #22c55e; background: #f0fdf4; }
    .event-time { font-size: 0.7rem; font-weight: 700; color: #64748b; margin-bottom: 4px; display: flex; align-items: center; gap: 4px; }

    /* Attendance bar chart */
    .attendance-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        border-radius: 16px; padding: 24px; color: #fff; position: relative; overflow: hidden;
    }
    .attendance-card::before {
        content: ''; position: absolute; top: -40px; right: -40px;
        width: 120px; height: 120px; border-radius: 50%;
        background: rgba(99,102,241,0.2); filter: blur(40px);
    }
    .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 80px; position: relative; z-index: 1; }
    .bar { flex: 1; border-radius: 4px 4px 0 0; background: rgba(255,255,255,0.15); transition: background 0.2s; }
    .bar.active { background: #6366f1; box-shadow: 0 0 15px rgba(99,102,241,0.5); }
    .bar:hover { background: rgba(255,255,255,0.3); }

    /* Recent Schools Table */
    .schools-panel { background: #fff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0px 4px 20px rgba(15,23,42,0.05); }
    .panel-header { padding: 24px 28px; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center; }
    .panel-title { font-size: 1.05rem; font-weight: 700; color: #1e293b; margin: 0; }
    .edu-table thead th { background: #1e293b; color: #fff; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 14px 16px; border: none; }
    .edu-table thead th:first-child { border-radius: 8px 0 0 8px; }
    .edu-table thead th:last-child  { border-radius: 0 8px 8px 0; }
    .edu-table tbody td { padding: 14px 16px; vertical-align: middle; border-bottom: 1px solid #f8fafc; color: #475569; }
    .edu-table tbody tr:last-child td { border-bottom: none; }
    .edu-table tbody tr:hover td { background: #fafbff; }
    .school-name { font-weight: 700; color: #1e293b; font-size: 0.9rem; }
    .school-date { font-size: 0.75rem; color: #94a3b8; }
    .school-icon { width: 36px; height: 36px; background: #eef2ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4f46e5; font-size: 0.9rem; flex-shrink: 0; }
    .slug-code { background: #eef2ff; color: #4f46e5; font-size: 0.75rem; padding: 3px 8px; border-radius: 6px; font-family: monospace; }
    .badge-active   { background: #dcfce7; color: #16a34a; font-weight: 700; font-size: 0.7rem; padding: 4px 10px; border-radius: 20px; }
    .badge-inactive { background: #f1f5f9; color: #64748b; font-weight: 700; font-size: 0.7rem; padding: 4px 10px; border-radius: 20px; }

    /* Mobile Table Overrides */
    @media (max-width: 768px) {
        .edu-table thead { display: none; }
        .edu-table tbody tr { display: block; padding: 15px; border-bottom: 8px solid #f8fafc; }
        .edu-table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border: none; text-align: right; width: 100%; }
        .edu-table tbody td::before { content: attr(data-label); font-weight: 700; font-size: 10px; text-transform: uppercase; color: #94a3b8; text-align: left; }
        .edu-table tbody td:last-child { justify-content: center; border-top: 1px solid #f1f5f9; margin-top: 10px; padding-top: 15px; }
        .edu-table tbody td:last-child::before { display: none; }
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
        <div class="welcome-card mb-5 p-4 p-md-5 position-relative overflow-hidden" style="border-radius:24px; background:linear-gradient(135deg, #1e293b, #334155); color:white; box-shadow: 0 10px 30px rgba(15,23,42,0.15);">
            <!-- Abstract background shapes -->
            <div style="position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
            <div style="position:absolute; bottom:-30px; left:10%; width:100px; height:100px; background:rgba(79,70,229,0.1); border-radius:50%; filter:blur(20px);"></div>
            
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
                    <p class="mb-0 opacity-75" style="font-size:1rem; max-width:500px;">
                        Welcome back to the EduCorexa Command Center. Here's a real-time overview of your platform's performance today.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <a href="{{ route('manage.schools.all') }}" class="btn-edu btn-edu-primary shadow-lg border-0 px-4 py-3" style="border-radius:14px; font-size:0.95rem; background:white; color:#1e293b !important;">
                        <i class="fa-solid fa-school me-2 text-primary"></i>
                        View All Schools
                        <i class="fa-solid fa-arrow-right ms-2 opacity-50"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="row g-4 mb-4">

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#eff6ff; color:#3b82f6;">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <span class="stat-badge" style="background:#dcfce7;color:#16a34a;">Live</span>
                    </div>
                    <div class="stat-label">Total Schools</div>
                    <div class="stat-value">{{ $totalSchools }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#fef3c7; color:#d97706;">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <span class="stat-badge" style="background:#fef3c7;color:#d97706;">Pending</span>
                    </div>
                    <div class="stat-label">Pending Requests</div>
                    <div class="stat-value">{{ $pendingSchools }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f0fdf4; color:#16a34a;">
                            <i class="fa-solid fa-sack-dollar"></i>
                        </div>
                        <span class="stat-badge" style="background:#dcfce7;color:#16a34a;">+4.2%</span>
                    </div>
                    <div class="stat-label">Monthly Revenue</div>
                    <div class="stat-value">৳ 0</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f5f3ff; color:#7c3aed;">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <span class="stat-badge" style="background:#e0e7ff;color:#4338ca;">Active</span>
                    </div>
                    <div class="stat-label">System Users</div>
                    <div class="stat-value" style="font-size:1.4rem;color:#16a34a;">Online</div>
                </div>
            </div>

        </div>

        {{-- ===== BENTO GRID: Quick Actions + Activity Feed ===== --}}
        <div class="row g-4 mb-4">

            {{-- Quick Actions --}}
            <div class="col-md-4">
                <div class="quick-actions-card">
                    <h5 class="mb-1 fw-bold" style="font-family:'Outfit',sans-serif;">Quick Actions</h5>
                    <p class="mb-4" style="color:rgba(255,255,255,0.6);font-size:0.85rem;">Execute common tasks instantly.</p>

                    <a href="{{ route('manage.schools.create') }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-plus-circle"></i> Add New School
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('manage.schools.pending') }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-clock"></i> Review Pending
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('settings.edit') }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sliders"></i> System Settings
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    @can('super.roles.manage')
                    <a href="{{ route('super.roles.index') }}" class="quick-action-btn mb-0">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-shield-halved"></i> Manage Roles
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    @endcan
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="col-md-8">
                <div class="activity-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif;color:#1e293b;">Recent Activity</h5>
                        <a href="{{ route('manage.schools.all') }}" class="badge-indigo" style="text-decoration:none; font-size:0.75rem;">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    <div class="d-flex flex-column gap-4">
                        @forelse($recentSchools->take(3) as $school)
                        <div class="activity-item">
                            <div class="activity-avatar">
                                <div class="avatar-icon" style="background:#eef2ff;color:#4f46e5;">
                                    <i class="fa-solid fa-school"></i>
                                </div>
                                <div class="activity-badge" style="background:{{ $school->is_active ? '#22c55e' : '#94a3b8' }};">
                                    <i class="fa-solid fa-circle" style="color:#fff;font-size:6px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0" style="font-weight:700;color:#1e293b;font-size:0.9rem;">
                                        {{ $school->name }}
                                        <span style="font-weight:400;color:#64748b;">registered on the platform</span>
                                    </p>
                                    <span style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;margin-left:12px;">{{ $school->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mb-0 mt-1" style="font-size:0.8rem;color:#94a3b8;">
                                    {{ $school->slug }} •
                                    @if($school->is_active) <span style="color:#16a34a;">Active</span>
                                    @else <span style="color:#64748b;">Inactive</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fa-solid fa-inbox fa-2x mb-2" style="color:#cbd5e1;"></i>
                            <p class="text-muted mb-0">No recent activity</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== BOTTOM ROW: Recent Schools Table + Side Panels ===== --}}
        <div class="row g-4">

            {{-- Schools Table --}}
            <div class="col-md-8">
                <div class="schools-panel">
                    <div class="panel-header">
                        <h6 class="panel-title">Recent School Registrations</h6>
                        <a href="{{ route('manage.schools.all') }}" class="badge-indigo" style="text-decoration:none; font-size:0.75rem;">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table edu-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>School</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSchools as $key => $school)
                                <tr>
                                    <td data-label="#" style="color:#94a3b8;font-weight:600;">{{ $key + 1 }}</td>
                                    <td data-label="School">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="school-icon d-none d-sm-flex"><i class="fa-solid fa-school"></i></div>
                                            <div class="text-start text-sm-start">
                                                <div class="school-name text-truncate" style="max-width:180px;">{{ $school->name }}</div>
                                                <div class="school-date">{{ $school->created_at->format('d M, Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Slug"><span class="slug-code">{{ $school->slug }}</span></td>
                                    <td data-label="Status">
                                        @if($school->is_active)
                                            <span class="badge-active">Active</span>
                                        @else
                                            <span class="badge-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('manage.schools.all') }}" class="btn-edu btn-edu-light" 
                                           style="padding: 6px 12px; font-size: 0.75rem; border-radius: 8px;">
                                            <i class="fa-solid fa-eye me-1"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fa-solid fa-inbox fa-2x mb-3 d-block" style="color:#e2e8f0;"></i>
                                        <span class="text-muted">No registrations found.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Side Panels --}}
            <div class="col-md-4 d-flex flex-column gap-4">

                {{-- Upcoming Events --}}
                <div class="schools-panel p-0">
                    <div class="panel-header">
                        <h6 class="panel-title">Upcoming Events</h6>
                        <div class="d-flex align-items-center justify-content-center"
                             data-bs-toggle="modal" data-bs-target="#createEventModal"
                             style="width:30px;height:30px;background:#eef2ff;border-radius:50%;color:#4f46e5;cursor:pointer;">
                            <i class="fa-solid fa-plus" style="font-size:0.75rem;"></i>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column gap-2">
                        @forelse($upcomingEvents as $event)
                        <div class="event-item {{ $event->color }}" onclick="window.location='{{ route('super.events.edit', $event->id) }}'">
                            <div class="event-time">
                                <i class="fa-regular fa-clock"></i>
                                {{ $event->event_date->format('d M') }} • {{ $event->event_time ? date('h:i A', strtotime($event->event_time)) : 'All Day' }}
                            </div>
                            <div style="font-weight:700;color:#1e293b;font-size:0.9rem;">{{ $event->title }}</div>
                            @if($event->location)
                            <div style="font-size:0.75rem;color:#64748b;margin-top:4px;display:flex;align-items:center;gap:4px;">
                                <i class="fa-solid fa-location-dot" style="font-size:0.7rem;color:#ef4444;"></i> {{ $event->location }}
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fa-solid fa-calendar-day fa-2x mb-2" style="color:#cbd5e1;"></i>
                            <p class="text-muted mb-0" style="font-size:0.85rem;">No upcoming events</p>
                        </div>
                        @endforelse
                    </div>
                    @if($upcomingEvents->count() > 0)
                    <div class="px-3 pb-3">
                        <a href="{{ route('super.events.index') }}" class="btn-edu btn-edu-light w-100" style="font-size:0.75rem;">Manage All Events</a>
                    </div>
                    @endif
                </div>

                {{-- Weekly Attendance Chart --}}
                <div class="attendance-card flex-grow-1">
                    <div style="position:relative;z-index:1;">
                        <h6 class="fw-bold mb-0" style="font-family:'Outfit',sans-serif;">Platform Activity</h6>
                        <p style="color:rgba(255,255,255,0.5);font-size:0.75rem;margin-bottom:20px;">Schools active this week</p>
                        <div class="bar-chart">
                            <div class="bar" style="height:55%;"></div>
                            <div class="bar" style="height:75%;"></div>
                            <div class="bar" style="height:60%;"></div>
                            <div class="bar" style="height:90%;"></div>
                            <div class="bar" style="height:70%;"></div>
                            <div class="bar active" style="height:95%;"></div>
                            <div class="bar" style="height:40%;"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2" style="color:rgba(255,255,255,0.4);font-size:0.7rem;">
                            <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Quick Add Event Modal --}}
<div class="modal fade" id="createEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius:20px;">
            <div class="modal-header p-4" style="border-bottom:1px solid #f1f5f9;">
                <h5 class="modal-title fw-bold" style="font-family:'Outfit',sans-serif;">Add New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('super.events.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Event Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Science Fair 2026" required
                               style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold text-muted small">Date</label>
                            <input type="date" name="event_date" class="form-control" required
                                   style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-muted small">Time (Optional)</label>
                            <input type="time" name="event_time" class="form-control"
                                   style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Location</label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. Main Auditorium"
                               style="border-radius:12px; padding:12px; border:1px solid #e2e8f0; background:#f8fafc;">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold text-muted small">Theme Color</label>
                        <div class="d-flex gap-3 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="color" value="blue" id="colorBlue" checked>
                                <label class="form-check-label d-flex align-items-center gap-1" for="colorBlue">
                                    <div style="width:12px;height:12px;border-radius:4px;background:#eff6ff;border:1px solid #3b82f6;"></div> Blue
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="color" value="purple" id="colorPurple">
                                <label class="form-check-label d-flex align-items-center gap-1" for="colorPurple">
                                    <div style="width:12px;height:12px;border-radius:4px;background:#f5f3ff;border:1px solid #8b5cf6;"></div> Purple
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="color" value="green" id="colorGreen">
                                <label class="form-check-label d-flex align-items-center gap-1" for="colorGreen">
                                    <div style="width:12px;height:12px;border-radius:4px;background:#f0fdf4;border:1px solid #22c55e;"></div> Green
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-4 pt-0 border-0">
                    <button type="button" class="btn-edu btn-edu-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-edu btn-edu-primary px-4">Create Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection