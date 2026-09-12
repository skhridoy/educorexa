@extends('layouts.main')

@section('customCSS')
@include('layouts._shared_styles')
<style>
    .event-color-indicator {
        width: 12px; height: 12px; border-radius: 4px; display: inline-block;
    }
    .badge-blue   { background: #eff6ff; color: #3b82f6; }
    .badge-purple { background: #f5f3ff; color: #8b5cf6; }
    .badge-green  { background: #f0fdf4; color: #22c55e; }
    
    .event-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .event-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }

    /* Mobile Responsive Cards */
    .event-mobile-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        padding: 16px 14px;
    }
    .event-m-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1.5px solid #f1f5f9;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        padding: 16px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .event-m-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 12px;
    }
    .event-m-avatar-wrap {
        flex-shrink: 0;
    }
    .event-m-avatar {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        border: 2px solid transparent;
    }
    .event-m-avatar.theme-blue {
        background: #eff6ff;
        color: #3b82f6;
        border-color: #dbeafe;
    }
    .event-m-avatar.theme-purple {
        background: #f5f3ff;
        color: #8b5cf6;
        border-color: #ede9fe;
    }
    .event-m-avatar.theme-green {
        background: #f0fdf4;
        color: #16a34a;
        border-color: #dcfce7;
    }
    .event-m-title-area {
        flex-grow: 1;
        min-width: 0;
    }
    .event-m-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: #1e293b;
        margin-bottom: 4px;
        line-height: 1.25;
    }
    .event-m-top-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .event-m-dropdown {
        flex-shrink: 0;
        margin-left: auto;
    }
    .btn-m-dots {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-m-dots:hover, .btn-m-dots:focus, .btn-m-dots[aria-expanded="true"] {
        background: #eef2ff;
        color: #4f46e5;
        border-color: #c7d2fe;
    }
    .event-actions-menu {
        border-radius: 14px;
        padding: 6px;
        min-width: 160px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.14), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
        border: 1px solid #f1f5f9 !important;
        z-index: 1050;
    }
    .event-actions-menu .dropdown-item {
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.15s;
    }
    .event-actions-menu .dropdown-item:hover {
        background: #f8fafc;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .status-badge.active { background: #dcfce7; color: #16a34a; }
    .status-badge.inactive { background: #fee2e2; color: #ef4444; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .event-m-desc {
        font-size: 0.82rem;
        color: #64748b;
        line-height: 1.45;
        margin-bottom: 12px;
    }
    .event-m-details-grid {
        background: #f8fafc;
        border-radius: 12px;
        padding: 10px 12px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px 12px;
        border: 1px solid #f1f5f9;
    }
    .event-m-detail-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .event-m-detail-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .event-m-detail-val {
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
    }
    .badge-active {
        background: #dcfce7;
        color: #16a34a;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .badge-inactive {
        background: #fee2e2;
        color: #ef4444;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
    }

    @media (max-width: 576px) {
        .event-header-wrap {
            flex-direction: column;
            align-items: stretch !important;
            gap: 14px;
        }
        .event-header-wrap .btn-edu {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- ===== BREADCRUMB ===== --}}
        <ul class="edu-bc">
            <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li><span>/</span></li>
            <li class="active">Platform Events</li>
        </ul>

        {{-- ===== PAGE HEADER ===== --}}
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3 event-header-wrap">
            <div>
                <h3 class="fw-bold mb-1" style="font-family:'Outfit',sans-serif; color:#1e293b;">
                    <i class="fa-solid fa-calendar-days me-2" style="color:#4f46e5;"></i> Platform Events
                </h3>
                <p class="text-muted mb-0" style="font-size:0.9rem;">Manage all scheduled activities and announcements.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('super.events.create') }}" class="btn-edu btn-edu-primary shadow-sm">
                    <i class="fa-solid fa-calendar-plus"></i> Add Event
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius:12px; background:#dcfce7; color:#166534;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @endif

        {{-- ===== EVENTS TABLE ===== --}}
        <div class="edu-panel border-0 shadow-sm">
            <div class="edu-panel-hd d-flex justify-content-between align-items-center bg-white py-3 px-4" style="border-bottom: 1px solid #f1f5f9;">
                <h6 class="mb-0 fw-bold" style="color:#1e293b;">Active Events List</h6>
                <div class="text-muted small">Total: {{ $events->count() }} events</div>
            </div>
            <div class="edu-panel-bd p-0">
                {{-- 1. Desktop & Tablet Table View (Hidden on Mobile < 768px) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table edu-table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Event Title & Description</th>
                                <th>Schedule</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $key => $event)
                            <tr class="event-card">
                                <td data-label="ID" class="fw-bold text-muted">#{{ str_pad($event->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td data-label="Event">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="event-color-indicator mt-1 badge-{{ $event->color }}"></div>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size:0.95rem;">{{ $event->title }}</div>
                                            <div class="text-muted small mt-1" style="max-width: 300px;">{{ Str::limit($event->description ?? 'No description provided.', 60) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Schedule">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark" style="font-size:0.85rem;">
                                            <i class="fa-regular fa-calendar me-1 text-primary"></i> {{ $event->event_date->format('D, d M Y') }}
                                        </span>
                                        <span class="text-muted small">
                                            <i class="fa-regular fa-clock me-1"></i> {{ $event->event_time ? date('h:i A', strtotime($event->event_time)) : 'All Day' }}
                                        </span>
                                    </div>
                                </td>
                                <td data-label="Location">
                                    @if($event->location)
                                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 border">
                                            <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $event->location }}
                                        </span>
                                    @else
                                        <span class="text-muted italic small">Not specified</span>
                                    @endif
                                </td>
                                <td data-label="Status">
                                    @if($event->is_active)
                                        <span class="badge-active">Active</span>
                                    @else
                                        <span class="badge-inactive">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('super.events.edit', $event->id) }}" class="act-btn" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-primary"></i>
                                        </a>
                                        <form action="{{ route('super.events.destroy', $event->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="act-btn del" onclick="confirmDelEvent(this)" title="Delete">
                                                <i class="fa-solid fa-trash-can text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fa-solid fa-calendar-xmark fa-4x mb-3" style="color:#e2e8f0;"></i>
                                        <h5 class="text-muted fw-bold">No Events Found</h5>
                                        <p class="text-muted small mb-4">You haven't scheduled any events yet.</p>
                                        <a href="{{ route('super.events.create') }}" class="btn-edu btn-edu-primary px-4">
                                            <i class="fa-solid fa-plus me-1"></i> Add Your First Event
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- 2. Mobile Card List (Visible only on screens < 768px) --}}
                <div class="event-mobile-list d-block d-md-none">
                    @forelse($events as $event)
                    <div class="event-m-card">
                        {{-- Top Header: Avatar, Title, Badges & Three-dot Dropdown --}}
                        <div class="event-m-header">
                            <div class="event-m-avatar-wrap">
                                <div class="event-m-avatar theme-{{ $event->color ?? 'blue' }}">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </div>
                            </div>
                            <div class="event-m-title-area">
                                <div class="event-m-title">{{ $event->title }}</div>
                                <div class="event-m-top-meta">
                                    @if($event->is_active)
                                        <span class="status-badge active"><span class="status-dot"></span> Active</span>
                                    @else
                                        <span class="status-badge inactive"><span class="status-dot"></span> Draft</span>
                                    @endif
                                    <span class="badge-id">#{{ str_pad($event->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>

                            {{-- Three-dot action dropdown menu (Mobile) --}}
                            <div class="dropdown event-m-dropdown">
                                <button type="button" class="btn-m-dots" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 event-actions-menu">
                                    <li>
                                        <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-dark" href="{{ route('super.events.edit', $event->id) }}">
                                            <i class="fa-solid fa-pen-to-square text-primary" style="width:16px;"></i>
                                            <span>এডিট করুন</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('super.events.destroy', $event->id) }}" method="POST" class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="button" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger" onclick="confirmDelEvent(this)">
                                                <i class="fa-solid fa-trash-can" style="width:16px;"></i>
                                                <span>ডিলিট করুন</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Event Description --}}
                        @if($event->description)
                            <div class="event-m-desc">
                                {{ $event->description }}
                            </div>
                        @endif

                        {{-- Details Grid --}}
                        <div class="event-m-details-grid">
                            <div class="event-m-detail-item">
                                <span class="event-m-detail-label"><i class="fa-regular fa-calendar text-primary"></i> তারিখ</span>
                                <span class="event-m-detail-val">{{ $event->event_date ? $event->event_date->format('d M, Y') : 'N/A' }}</span>
                            </div>
                            <div class="event-m-detail-item">
                                <span class="event-m-detail-label"><i class="fa-regular fa-clock text-info"></i> সময়</span>
                                <span class="event-m-detail-val">{{ $event->event_time ? date('h:i A', strtotime($event->event_time)) : 'All Day' }}</span>
                            </div>
                            <div class="event-m-detail-item" style="grid-column: span 2;">
                                <span class="event-m-detail-label"><i class="fa-solid fa-location-dot text-danger"></i> অবস্থান</span>
                                <span class="event-m-detail-val">{{ $event->location ?? 'Not specified' }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fa-solid fa-calendar-xmark fa-3x mb-3" style="color:#cbd5e1;"></i>
                        <h6 class="text-muted fw-bold">No Events Found</h6>
                        <p class="text-muted small mb-3">You haven't scheduled any events yet.</p>
                        <a href="{{ route('super.events.create') }}" class="btn-edu btn-edu-primary">
                            <i class="fa-solid fa-plus me-1"></i> Add Event
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Quick Add Event Modal (Same as Dashboard) --}}
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
                                    <div class="event-color-indicator badge-blue"></div> Blue
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="color" value="purple" id="colorPurple">
                                <label class="form-check-label d-flex align-items-center gap-1" for="colorPurple">
                                    <div class="event-color-indicator badge-purple"></div> Purple
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="color" value="green" id="colorGreen">
                                <label class="form-check-label d-flex align-items-center gap-1" for="colorGreen">
                                    <div class="event-color-indicator badge-green"></div> Green
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

@section('customJs')
<script>
function confirmDelEvent(btn) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Event?',
            text: 'This event will be permanently removed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete'
        }).then(r => { 
            if(r.isConfirmed) btn.closest('form').submit(); 
        });
    } else {
        if(confirm('Delete this event permanently?')) {
            btn.closest('form').submit();
        }
    }
}
</script>
@endsection
