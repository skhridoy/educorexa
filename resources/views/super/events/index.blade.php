@extends('layouts.main')

@section('customCSS')
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
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1" style="font-family:'Outfit',sans-serif; color:#1e293b;">Platform Events</h3>
                <p class="text-muted mb-0" style="font-size:0.9rem;">Manage all scheduled activities and announcements.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('super.dashboard') }}" class="btn-edu btn-edu-light">
                    <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                </a>
                <a href="{{ route('super.events.create') }}" class="btn-edu btn-edu-primary">
                    <i class="fa-solid fa-calendar-plus me-1"></i> Add Event
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
                <div class="table-responsive">
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
                                        <a href="{{ route('super.events.edit', $event->id) }}" class="btn-edu btn-edu-light p-2" style="width:32px;height:32px;" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-primary"></i>
                                        </a>
                                        <form action="{{ route('super.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event permanently?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-edu btn-edu-light p-2" style="width:32px;height:32px;" title="Delete">
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
