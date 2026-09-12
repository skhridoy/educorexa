@extends('layouts.main')

@section('customCSS')
@include('layouts._shared_styles')
<style>
    /* Page Header */
    .supp-page-hd {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 576px) {
        .supp-page-hd {
            flex-direction: column;
            align-items: stretch !important;
            gap: 14px;
        }
    }

    /* Stat Pills Bar */
    .supp-stat-bar {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
        margin-bottom: 20px;
        -webkit-overflow-scrolling: touch;
    }
    .supp-stat-pill {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 9px 16px;
        font-size: 0.82rem;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .supp-stat-pill:hover {
        border-color: #c7d2fe;
        color: #4f46e5;
        transform: translateY(-1px);
    }
    .supp-stat-pill.is-active {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.28);
    }
    .supp-stat-pill.is-active i,
    .supp-stat-pill.is-active strong {
        color: #ffffff !important;
    }
    .supp-stat-pill strong {
        color: #1e293b;
        font-size: 0.95rem;
        font-weight: 700;
    }
    .supp-stat-pill.unread-pill {
        border-color: #fecaca;
        background: #fef2f2;
    }
    .unread-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ef4444;
        display: inline-block;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(1.3); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.8; }
    }

    /* Priority & Status Badges */
    .priority-pill {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-transform: capitalize;
    }
    .priority-high { background: #fee2e2; color: #ef4444; border: 1px solid #fca5a5; }
    .priority-medium { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .priority-low { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }

    .supp-status-pill {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-transform: capitalize;
    }
    .supp-status-open { background: #e0e7ff; color: #4338ca; }
    .supp-status-pending { background: #fef3c7; color: #d97706; }
    .supp-status-resolved { background: #dcfce7; color: #16a34a; }
    .supp-status-closed { background: #f1f5f9; color: #64748b; }
    .supp-status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    /* Mobile Responsive Card Layout */
    .supp-mobile-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        padding: 16px 14px;
    }
    .supp-m-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1.5px solid #f1f5f9;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        padding: 16px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        position: relative;
    }
    .supp-m-card.is-unread {
        border-color: #c7d2fe;
        background: linear-gradient(180deg, #fafafe 0%, #ffffff 100%);
    }
    .supp-m-card.is-unread::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 4px;
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
        background: linear-gradient(180deg, #4f46e5, #818cf8);
    }
    .supp-m-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 12px;
    }
    .supp-m-avatar-wrap {
        flex-shrink: 0;
    }
    .supp-m-avatar {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #eef2ff, #c7d2fe);
        color: #4f46e5;
        font-weight: 800;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e0e7ff;
    }
    .supp-m-title-area {
        flex-grow: 1;
        min-width: 0;
    }
    .supp-m-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        color: #1e293b;
        margin-bottom: 4px;
        line-height: 1.25;
        text-decoration: none;
        display: block;
    }
    .supp-m-title:hover {
        color: #4f46e5;
    }
    .supp-m-top-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .supp-m-dropdown {
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
    .supp-actions-menu {
        border-radius: 14px;
        padding: 6px;
        min-width: 175px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.14), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
        border: 1px solid #f1f5f9 !important;
        z-index: 1050;
    }
    .supp-actions-menu .dropdown-item {
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.15s;
    }
    .supp-actions-menu .dropdown-item:hover {
        background: #f8fafc;
    }
    .supp-m-details-grid {
        background: #f8fafc;
        border-radius: 12px;
        padding: 10px 12px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px 12px;
        border: 1px solid #f1f5f9;
        margin-bottom: 12px;
    }
    .supp-m-detail-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .supp-m-detail-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .supp-m-detail-val {
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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
            <li class="active">Support Desk</li>
        </ul>

        {{-- ===== PAGE HEADER ===== --}}
        <div class="supp-page-hd">
            <div>
                <h2 class="edu-page-title">
                    <i class="fa-solid fa-headset me-2" style="color:#4f46e5;"></i> School Support Desk
                </h2>
                <p class="edu-page-sub">Manage and respond to operational & technical inquiries from school admins.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if(request()->anyFilled(['status', 'priority', 'search']))
                    <a href="{{ route('manage.support.index') }}" class="btn-edu btn-edu-light">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset Filters
                    </a>
                @endif
            </div>
        </div>

        {{-- ===== STAT PILLS BAR ===== --}}
        <div class="supp-stat-bar">
            <a href="{{ route('manage.support.index') }}" class="supp-stat-pill {{ !request('status') ? 'is-active' : '' }}">
                <i class="fa-solid fa-layer-group text-primary"></i>
                <span>All Tickets: <strong>{{ $stats['total'] }}</strong></span>
            </a>
            <a href="{{ route('manage.support.index', ['status' => 'open']) }}" class="supp-stat-pill {{ request('status') === 'open' ? 'is-active' : '' }}">
                <i class="fa-solid fa-envelope-open-text text-indigo"></i>
                <span>Open: <strong>{{ $stats['open'] }}</strong></span>
            </a>
            <a href="{{ route('manage.support.index', ['status' => 'pending']) }}" class="supp-stat-pill {{ request('status') === 'pending' ? 'is-active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left text-warning"></i>
                <span>Pending: <strong>{{ $stats['pending'] }}</strong></span>
            </a>
            <a href="{{ route('manage.support.index', ['status' => 'resolved']) }}" class="supp-stat-pill {{ request('status') === 'resolved' ? 'is-active' : '' }}">
                <i class="fa-solid fa-circle-check text-success"></i>
                <span>Resolved: <strong>{{ $stats['resolved'] }}</strong></span>
            </a>
            <a href="{{ route('manage.support.index', ['status' => 'closed']) }}" class="supp-stat-pill {{ request('status') === 'closed' ? 'is-active' : '' }}">
                <i class="fa-solid fa-folder-closed text-muted"></i>
                <span>Closed: <strong>{{ $stats['closed'] }}</strong></span>
            </a>
            @if($stats['unread'] > 0)
            <div class="supp-stat-pill unread-pill">
                <span class="unread-dot"></span>
                <span class="text-danger fw-bold"><strong>{{ $stats['unread'] }}</strong> Unread Tickets</span>
            </div>
            @endif
        </div>

        {{-- ===== SEARCH & FILTER PANEL ===== --}}
        <div class="edu-panel mb-4">
            <form method="GET" action="{{ route('manage.support.index') }}" class="p-3">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px; border-color: #e2e8f0; color: #94a3b8;">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 edu-input" placeholder="Search by Ticket ID, Subject, School, Submitter..." style="border-radius: 0 10px 10px 0 !important;">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <select name="status" class="form-select form-select-sm edu-input" onchange="this.form.submit()">
                            <option value="">Status: All Statuses</option>
                            <option value="open" @selected(request('status') === 'open')>Open</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                            <option value="resolved" @selected(request('status') === 'resolved')>Resolved</option>
                            <option value="closed" @selected(request('status') === 'closed')>Closed</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <select name="priority" class="form-select form-select-sm edu-input" onchange="this.form.submit()">
                            <option value="">Priority: All</option>
                            <option value="high" @selected(request('priority') === 'high')>High Priority</option>
                            <option value="medium" @selected(request('priority') === 'medium')>Medium Priority</option>
                            <option value="low" @selected(request('priority') === 'low')>Low Priority</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn-edu btn-edu-primary w-100 justify-content-center">
                            <i class="fa-solid fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ===== TICKETS LIST PANEL ===== --}}
        <div class="edu-panel">
            <div class="edu-panel-hd">
                <div>
                    <h6 class="edu-panel-ttl">All Support Inquiries</h6>
                    <span class="text-muted small">Showing {{ $tickets->count() }} of {{ $tickets->total() }} tickets</span>
                </div>
                <span class="badge" style="background:#eef2ff;color:#4f46e5;font-weight:700;font-size:0.75rem;padding:5px 12px;border-radius:20px;">
                    {{ $tickets->total() }} Total
                </span>
            </div>

            <div class="edu-panel-bd p-0">
                {{-- 1. Desktop & Tablet Table View (Hidden on Mobile < 768px) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table edu-table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 130px;">Ticket ID</th>
                                <th>Subject & Inquirer</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Replies</th>
                                <th>Submitted</th>
                                <th class="text-center" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                            <tr style="{{ !$ticket->is_read_by_super ? 'background: #fafafe;' : '' }}">
                                <td>
                                    <span class="badge-id">#{{ $ticket->ticket_id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-start gap-2">
                                        <div>
                                            <a href="{{ route('manage.support.show', $ticket->id) }}" class="fw-bold text-dark text-decoration-none d-flex align-items-center gap-2" style="font-size:0.92rem;">
                                                <span>{{ $ticket->subject }}</span>
                                                @if(!$ticket->is_read_by_super)
                                                    <span class="badge bg-danger text-white px-2 py-0" style="font-size:0.62rem;">NEW</span>
                                                @endif
                                            </a>
                                            <div class="text-muted small mt-1 d-flex align-items-center gap-2 flex-wrap">
                                                <span><i class="fa-solid fa-school me-1 text-primary"></i>{{ $ticket->school->name ?? 'General' }}</span>
                                                <span>•</span>
                                                <span><i class="fa-regular fa-user me-1"></i>{{ $ticket->user->name ?? 'School Admin' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="priority-pill priority-{{ $ticket->priority }}">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>
                                <td>
                                    <span class="supp-status-pill supp-status-{{ $ticket->status }}">
                                        <span class="supp-status-dot"></span>
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-light text-muted border px-2 py-1" style="font-size:0.75rem;">
                                        <i class="fa-regular fa-comment-dots me-1"></i>{{ $ticket->replies->count() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-muted small" title="{{ $ticket->created_at->format('Y-m-d H:i') }}">
                                        <i class="fa-regular fa-clock me-1"></i>{{ $ticket->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('manage.support.show', $ticket->id) }}" class="btn-edu btn-edu-outline py-1 px-3" style="font-size:0.78rem;" title="Handle Ticket">
                                            <i class="fa-solid fa-reply"></i> Handle
                                        </a>

                                        {{-- Actions Dropdown --}}
                                        <div class="dropdown">
                                            <button type="button" class="act-btn" data-bs-toggle="dropdown" aria-expanded="false" title="More Options">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 supp-actions-menu">
                                                <li>
                                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-dark" href="{{ route('manage.support.show', $ticket->id) }}">
                                                        <i class="fa-solid fa-eye text-primary" style="width:16px;"></i>
                                                        <span>টিকেট ভিউ করুন</span>
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li>
                                                    <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="status" value="resolved">
                                                        <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-success">
                                                            <i class="fa-solid fa-check-double text-success" style="width:16px;"></i>
                                                            <span>সমাধান হিসেবে চিহ্নিত</span>
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="status" value="closed">
                                                        <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-secondary">
                                                            <i class="fa-solid fa-folder-closed text-secondary" style="width:16px;"></i>
                                                            <span>ক্লোজ করুন</span>
                                                        </button>
                                                    </form>
                                                </li>
                                                @can('support.manage')
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li>
                                                    <form action="{{ route('manage.support.destroy', $ticket->id) }}" method="POST" class="m-0">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger" onclick="confirmDelTicket(this)">
                                                            <i class="fa-solid fa-trash-can" style="width:16px;"></i>
                                                            <span>ডিলিট করুন</span>
                                                        </button>
                                                    </form>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fa-solid fa-headset fa-3x mb-3" style="color:#cbd5e1;"></i>
                                        <h5 class="fw-bold text-dark">No Support Tickets Found</h5>
                                        <p class="text-muted small mb-0">All quiet on the help desk front. Good job!</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- 2. Mobile Responsive Card View (Visible only on screens < 768px) --}}
                <div class="supp-mobile-list d-block d-md-none">
                    @forelse($tickets as $ticket)
                    <div class="supp-m-card {{ !$ticket->is_read_by_super ? 'is-unread' : '' }}">
                        {{-- Top Header: Avatar, Subject, Badges & Three-dot Dropdown --}}
                        <div class="supp-m-header">
                            <div class="supp-m-avatar-wrap">
                                <div class="supp-m-avatar">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                            </div>
                            <div class="supp-m-title-area">
                                <a href="{{ route('manage.support.show', $ticket->id) }}" class="supp-m-title">
                                    {{ $ticket->subject }}
                                </a>
                                <div class="supp-m-top-meta">
                                    @if(!$ticket->is_read_by_super)
                                        <span class="badge bg-danger text-white px-2 py-0 fw-bold" style="font-size:0.62rem;">NEW</span>
                                    @endif
                                    <span class="supp-status-pill supp-status-{{ $ticket->status }}">
                                        <span class="supp-status-dot"></span>
                                        {{ $ticket->status }}
                                    </span>
                                    <span class="priority-pill priority-{{ $ticket->priority }}">
                                        {{ $ticket->priority }}
                                    </span>
                                    <span class="badge-id">#{{ $ticket->ticket_id }}</span>
                                </div>
                            </div>

                            {{-- Three-dot action dropdown menu (Mobile) --}}
                            <div class="dropdown supp-m-dropdown">
                                <button type="button" class="btn-m-dots" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 supp-actions-menu">
                                    <li>
                                        <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-dark" href="{{ route('manage.support.show', $ticket->id) }}">
                                            <i class="fa-solid fa-reply text-primary" style="width:16px;"></i>
                                            <span>টিকেট হ্যান্ডেল করুন</span>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="resolved">
                                            <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-success">
                                                <i class="fa-solid fa-check-double text-success" style="width:16px;"></i>
                                                <span>সমাধান হিসেবে চিহ্নিত</span>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="closed">
                                            <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-secondary">
                                                <i class="fa-solid fa-folder-closed text-secondary" style="width:16px;"></i>
                                                <span>ক্লোজ করুন</span>
                                            </button>
                                        </form>
                                    </li>
                                    @can('support.manage')
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form action="{{ route('manage.support.destroy', $ticket->id) }}" method="POST" class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="button" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger" onclick="confirmDelTicket(this)">
                                                <i class="fa-solid fa-trash-can" style="width:16px;"></i>
                                                <span>ডিলিট করুন</span>
                                            </button>
                                        </form>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>

                        {{-- Details Grid --}}
                        <div class="supp-m-details-grid">
                            <div class="supp-m-detail-item">
                                <span class="supp-m-detail-label"><i class="fa-solid fa-school text-primary"></i> স্কুল</span>
                                <span class="supp-m-detail-val">{{ $ticket->school->name ?? 'General' }}</span>
                            </div>
                            <div class="supp-m-detail-item">
                                <span class="supp-m-detail-label"><i class="fa-regular fa-user text-indigo"></i> প্রেরক</span>
                                <span class="supp-m-detail-val">{{ $ticket->user->name ?? 'School Admin' }}</span>
                            </div>
                            <div class="supp-m-detail-item">
                                <span class="supp-m-detail-label"><i class="fa-regular fa-clock text-warning"></i> সময়</span>
                                <span class="supp-m-detail-val">{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="supp-m-detail-item">
                                <span class="supp-m-detail-label"><i class="fa-regular fa-comment-dots text-success"></i> রিপ্লাই</span>
                                <span class="supp-m-detail-val">{{ $ticket->replies->count() }} Replies</span>
                            </div>
                        </div>

                        {{-- Handle Button --}}
                        <a href="{{ route('manage.support.show', $ticket->id) }}" class="btn-edu btn-edu-outline w-100 justify-content-center" style="font-size:0.85rem; padding: 8px 14px;">
                            <i class="fa-solid fa-reply me-1"></i> টিকেট হ্যান্ডেল করুন
                        </a>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fa-solid fa-headset fa-3x mb-3" style="color:#cbd5e1;"></i>
                        <h6 class="fw-bold text-dark">No Support Tickets Found</h6>
                        <p class="text-muted small mb-0">All quiet on the help desk front. Good job!</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($tickets->hasPages())
                <div class="p-3 border-top bg-light">
                    {{ $tickets->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@section('customJs')
<script>
function confirmDelTicket(btn) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Ticket?',
            text: 'This ticket and all its replies will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete'
        }).then(r => { 
            if(r.isConfirmed) btn.closest('form').submit(); 
        });
    } else {
        if(confirm('Delete this ticket permanently?')) {
            btn.closest('form').submit();
        }
    }
}
</script>
@endsection
