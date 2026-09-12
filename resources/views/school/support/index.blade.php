@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ── Page Hero Banner ──────────────────────────────── */
        .supp-hero-card {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 60%, #a21caf 100%);
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.25);
        }
        .supp-hero-card::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .supp-hero-card::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 30%;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .supp-hero-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 4px;
        }
        .supp-hero-sub {
            color: rgba(255,255,255,0.82);
            font-size: 0.84rem;
            margin: 0;
        }
        .supp-hero-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: rgba(255,255,255,0.18);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
            backdrop-filter: blur(4px);
        }
        .btn-hero-primary {
            background: #fff;
            color: #4f46e5;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 12px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .btn-hero-primary:hover {
            background: #f0f0ff;
            color: #3730a3;
            transform: translateY(-1px);
        }

        /* ── Interactive Stat Pills Bar ────────────────────── */
        .supp-stat-bar {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 6px;
            margin-bottom: 20px;
            -webkit-overflow-scrolling: touch;
        }
        .supp-stat-pill {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 8px 16px;
            font-size: 0.82rem;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
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
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
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
        .unread-dot {
            width: 8px; height: 8px;
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

        /* ── Search & Filter Panel ─────────────────────────── */
        .supp-filter-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px 16px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        }

        /* ── Data Table Card ────────────────────────────────── */
        .supp-table-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        }
        .supp-table-header {
            padding: 16px 22px;
            border-bottom: 1.5px solid #f1f5f9;
            background: #fafbfd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .supp-thead th {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #64748b;
            background: #f8fafc;
            padding: 12px 16px;
            border-bottom: 1.5px solid #e8edf4 !important;
            border-top: none !important;
            white-space: nowrap;
        }
        .supp-tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s;
        }
        .supp-tbody tr:last-child { border-bottom: none; }
        .supp-tbody tr:hover { background: #f8faff; }
        .supp-tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            font-size: 0.87rem;
            color: #334155;
        }

        /* ── Priority / Status Badges ───────────────────────── */
        .bdg {
            padding: 4px 11px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            letter-spacing: 0.3px;
        }
        .bdg-open     { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .bdg-pending  { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
        .bdg-resolved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .bdg-closed   { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
        .bdg-high     { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }
        .bdg-medium   { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
        .bdg-low      { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

        .btn-view-chat {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff !important;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 7px 16px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        }
        .btn-view-chat:hover { opacity: 0.92; transform: translateY(-1px); }

        /* ── Mobile Responsive Card Layout (Screens < 768px) ── */
        .supp-mobile-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 16px 12px;
        }
        .supp-m-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
            padding: 16px;
            position: relative;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .supp-m-card.is-unread {
            border-color: #c7d2fe;
            background: linear-gradient(180deg, #fafafe 0%, #ffffff 100%);
        }
        .supp-m-card.is-unread::before {
            content: '';
            position: absolute;
            top: 0; left: 0; bottom: 0;
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
            width: 44px; height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, #eef2ff, #c7d2fe);
            color: #4f46e5;
            font-size: 1.15rem;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid #e0e7ff;
        }
        .supp-m-title-area {
            flex-grow: 1;
            min-width: 0;
        }
        .supp-m-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 0.98rem;
            color: #1e293b;
            margin-bottom: 4px;
            line-height: 1.25;
            text-decoration: none;
            display: block;
        }
        .supp-m-title:hover { color: #4f46e5; }
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
            width: 34px; height: 34px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #64748b;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .btn-m-dots:hover, .btn-m-dots:focus {
            background: #eef2ff;
            color: #4f46e5;
            border-color: #c7d2fe;
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

        /* ── Empty State ────────────────────────────────────── */
        .supp-empty {
            padding: 50px 24px;
            text-align: center;
        }
        .supp-empty-icon {
            width: 72px; height: 72px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            color: #cbd5e1;
            margin: 0 auto 16px;
        }

        @media (max-width: 576px) {
            .supp-hero-card { padding: 18px 16px; }
            .supp-hero-title { font-size: 1.15rem; }
            .btn-hero-primary { width: 100%; justify-content: center; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- ════ HERO HEADER BANNER ════ --}}
        <div class="supp-hero-card">
            <div class="d-flex align-items-start align-items-md-center justify-content-between flex-wrap gap-3" style="position: relative; z-index: 1;">
                <div class="d-flex align-items-center gap-3">
                    <div class="supp-hero-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h1 class="supp-hero-title">{{ __('Support Help Desk') }}</h1>
                        <p class="supp-hero-sub">{{ __('Software issue or customization request? Open a ticket — we respond promptly.') }}</p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('school.support.create', ['tenant' => $tenant]) }}" class="btn-hero-primary">
                        <i class="fa-solid fa-circle-plus"></i> {{ __('New Ticket') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- ════ INTERACTIVE STAT PILLS BAR ════ --}}
        <div class="supp-stat-bar">
            <a href="{{ route('school.support.index', $tenant) }}" class="supp-stat-pill {{ !request('status') ? 'is-active' : '' }}">
                <i class="fa-solid fa-layer-group text-primary"></i>
                <span>{{ __('All Tickets') }}: <strong>{{ $totalTickets }}</strong></span>
            </a>
            <a href="{{ route('school.support.index', ['tenant' => $tenant, 'status' => 'open_pending']) }}" class="supp-stat-pill {{ request('status') === 'open_pending' ? 'is-active' : '' }}">
                <i class="fa-solid fa-hourglass-half text-warning"></i>
                <span>{{ __('Open / Pending') }}: <strong>{{ $openTickets }}</strong></span>
            </a>
            <a href="{{ route('school.support.index', ['tenant' => $tenant, 'status' => 'resolved']) }}" class="supp-stat-pill {{ request('status') === 'resolved' ? 'is-active' : '' }}">
                <i class="fa-solid fa-circle-check text-success"></i>
                <span>{{ __('Resolved') }}: <strong>{{ $resolvedTickets }}</strong></span>
            </a>
            <a href="{{ route('school.support.index', ['tenant' => $tenant, 'status' => 'closed']) }}" class="supp-stat-pill {{ request('status') === 'closed' ? 'is-active' : '' }}">
                <i class="fa-solid fa-folder-closed text-muted"></i>
                <span>{{ __('Closed') }}: <strong>{{ $closedTickets }}</strong></span>
            </a>
            @if($unreadReplies > 0)
            <div class="supp-stat-pill" style="border-color: #fecaca; background: #fef2f2;">
                <span class="unread-dot"></span>
                <span class="text-danger fw-bold"><strong>{{ $unreadReplies }}</strong> {{ __('Unread Replies') }}</span>
            </div>
            @endif
        </div>

        {{-- ════ SEARCH & FILTER PANEL ════ --}}
        <div class="supp-filter-card">
            <form method="GET" action="{{ route('school.support.index', $tenant) }}" class="m-0">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px; border-color: #e2e8f0; color: #94a3b8;">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="{{ __('Search by Ticket ID or Subject...') }}" style="border-radius: 0 10px 10px 0 !important; border-color: #e2e8f0;">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()" style="border-radius: 10px; border-color: #e2e8f0; height: 38px;">
                            <option value="">{{ __('Priority: All') }}</option>
                            <option value="high" @selected(request('priority') === 'high')>{{ __('High Priority') }}</option>
                            <option value="medium" @selected(request('priority') === 'medium')>{{ __('Medium Priority') }}</option>
                            <option value="low" @selected(request('priority') === 'low')>{{ __('Low Priority') }}</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold d-flex align-items-center justify-content-center gap-1" style="border-radius: 10px; height: 38px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border: none;">
                            <i class="fa-solid fa-filter"></i> {{ __('Filter') }}
                        </button>
                        @if(request()->anyFilled(['status', 'priority', 'search']))
                            <a href="{{ route('school.support.index', $tenant) }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="border-radius: 10px; height: 38px;" title="{{ __('Reset') }}">
                                <i class="fa-solid fa-rotate-left text-muted"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- ════ TICKETS LIST PANEL ════ --}}
        <div class="supp-table-card">
            <div class="supp-table-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="supp-table-icon" style="background:#eff6ff; color:#3b82f6; width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ __('Support Ticket Requests') }}</h6>
                        <small class="text-muted">{{ __('Showing') }} {{ $tickets->count() }} {{ __('of') }} {{ $tickets->total() }} {{ __('tickets') }}</small>
                    </div>
                </div>
                <span class="badge rounded-pill px-3 py-2 fw-bold"
                      style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 0.75rem;">
                    {{ $tickets->total() }} {{ __('Tickets') }}
                </span>
            </div>

            {{-- 1. Desktop & Tablet Table View (Hidden on Mobile < 768px) --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table align-middle mb-0">
                    <thead class="supp-thead">
                        <tr>
                            <th class="ps-4" style="width: 130px;">{{ __('Ticket ID') }}</th>
                            <th>{{ __('Subject & Issue') }}</th>
                            <th>{{ __('Priority') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Replies') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th class="text-center pe-4" style="width: 140px;">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="supp-tbody">
                        @forelse($tickets as $ticket)
                        <tr style="{{ !$ticket->is_read_by_school ? 'background: #fafafe;' : '' }}">
                            <td class="ps-4">
                                <span class="badge bg-light text-dark border fw-bold px-2 py-1 font-monospace" style="border-radius: 6px; font-size: 0.75rem;">
                                    #{{ $ticket->ticket_id }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <a href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}"
                                       class="fw-bold text-dark text-decoration-none"
                                       style="font-size: 0.9rem;">
                                        {{ $ticket->subject }}
                                    </a>
                                    @if(!$ticket->is_read_by_school)
                                        <span class="badge rounded-pill text-white fw-bold"
                                              style="background: #ef4444; font-size: 10px; padding: 2px 8px;">
                                            {{ __('New Reply') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-muted mt-1" style="font-size: 0.73rem;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $ticket->updated_at->diffForHumans() }}
                                </div>
                            </td>
                            <td>
                                <span class="bdg bdg-{{ $ticket->priority }}">
                                    <i class="fa-solid fa-circle" style="font-size: 6px;"></i>
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="bdg bdg-{{ $ticket->status }}">
                                    @if($ticket->status == 'open')
                                        <i class="fa-regular fa-folder-open"></i> {{ __('Open') }}
                                    @elseif($ticket->status == 'pending')
                                        <i class="fa-solid fa-clock"></i> {{ __('Pending') }}
                                    @elseif($ticket->status == 'resolved')
                                        <i class="fa-solid fa-check-double"></i> {{ __('Resolved') }}
                                    @else
                                        <i class="fa-solid fa-lock"></i> {{ __('Closed') }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-light text-muted border px-2 py-1" style="font-size:0.75rem;">
                                    <i class="fa-regular fa-comment-dots me-1"></i>{{ $ticket->replies->count() }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 0.8rem; color: #64748b;">{{ $ticket->created_at->format('d M, Y') }}</div>
                                <div style="font-size: 0.72rem; color: #94a3b8;">{{ $ticket->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}"
                                   class="btn-view-chat">
                                    <i class="fa-regular fa-comments"></i> {{ __('View Chat') }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="supp-empty">
                                    <div class="supp-empty-icon">
                                        <i class="fa-solid fa-headset"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">{{ __('No Support Tickets Found') }}</h5>
                                    <p class="text-muted mb-4" style="font-size: 0.88rem; max-width: 380px; margin: 0 auto 20px;">
                                        {{ __('If you face any issues or need customization, feel free to open a ticket. Our team is ready to help.') }}
                                    </p>
                                    <a href="{{ route('school.support.create', ['tenant' => $tenant]) }}"
                                       class="btn-hero-primary" style="display: inline-flex; background: linear-gradient(135deg,#4f46e5,#7c3aed); color: #fff;">
                                        <i class="fa-solid fa-plus"></i> {{ __('Create First Ticket') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 2. Mobile Responsive Card List (Visible only on screens < 768px) --}}
            <div class="supp-mobile-list d-block d-md-none">
                @forelse($tickets as $ticket)
                <div class="supp-m-card {{ !$ticket->is_read_by_school ? 'is-unread' : '' }}">
                    {{-- Header: Avatar, Subject, Badges & Three-dot Dropdown --}}
                    <div class="supp-m-header">
                        <div class="supp-m-avatar-wrap">
                            <div class="supp-m-avatar">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                        </div>
                        <div class="supp-m-title-area">
                            <a href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}" class="supp-m-title">
                                {{ $ticket->subject }}
                            </a>
                            <div class="supp-m-top-meta">
                                @if(!$ticket->is_read_by_school)
                                    <span class="badge bg-danger text-white px-2 py-0 fw-bold" style="font-size:0.62rem;">NEW REPLY</span>
                                @endif
                                <span class="bdg bdg-{{ $ticket->status }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                                <span class="bdg bdg-{{ $ticket->priority }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                                <span class="badge bg-light text-muted border font-monospace" style="font-size:0.7rem;">#{{ $ticket->ticket_id }}</span>
                            </div>
                        </div>

                        {{-- Three-dot action dropdown menu (Mobile) --}}
                        <div class="dropdown supp-m-dropdown">
                            <button type="button" class="btn-m-dots" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:14px; padding:6px; min-width:160px;">
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-dark" href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}">
                                        <i class="fa-solid fa-comments text-primary" style="width:16px;"></i>
                                        <span>{{ __('View Conversation') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Details Grid --}}
                    <div class="supp-m-details-grid">
                        <div class="supp-m-detail-item">
                            <span class="supp-m-detail-label"><i class="fa-regular fa-calendar text-primary"></i> {{ __('Created') }}</span>
                            <span class="supp-m-detail-val">{{ $ticket->created_at->format('d M, Y') }}</span>
                        </div>
                        <div class="supp-m-detail-item">
                            <span class="supp-m-detail-label"><i class="fa-regular fa-clock text-warning"></i> {{ __('Updated') }}</span>
                            <span class="supp-m-detail-val">{{ $ticket->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="supp-m-detail-item">
                            <span class="supp-m-detail-label"><i class="fa-solid fa-shield-halved text-info"></i> {{ __('Priority') }}</span>
                            <span class="supp-m-detail-val">{{ ucfirst($ticket->priority) }}</span>
                        </div>
                        <div class="supp-m-detail-item">
                            <span class="supp-m-detail-label"><i class="fa-regular fa-comment-dots text-success"></i> {{ __('Replies') }}</span>
                            <span class="supp-m-detail-val">{{ $ticket->replies->count() }} {{ __('Replies') }}</span>
                        </div>
                    </div>

                    {{-- View Chat Full Button --}}
                    <a href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}" class="btn-view-chat w-100 justify-content-center py-2" style="font-size:0.85rem;">
                        <i class="fa-regular fa-comments me-1"></i> {{ __('মেসেজ দেখুন / View Chat') }}
                    </a>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fa-solid fa-headset fa-3x mb-3" style="color:#cbd5e1;"></i>
                    <h6 class="fw-bold text-dark">{{ __('No Support Tickets Found') }}</h6>
                    <p class="text-muted small mb-3">{{ __('Need help? Open your first ticket.') }}</p>
                    <a href="{{ route('school.support.create', ['tenant' => $tenant]) }}" class="btn btn-primary btn-sm rounded-pill px-4" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); border: none;">
                        <i class="fa-solid fa-plus me-1"></i> {{ __('New Ticket') }}
                    </a>
                </div>
                @endforelse
            </div>

            @if($tickets->hasPages())
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $tickets->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

@section('customJs')
<script>
    @if(session('success'))
    Swal.fire({ icon: 'success', title: 'Done!', text: '{{ session("success") }}', timer: 2500, showConfirmButton: false });
    @endif
    @if(session('error'))
    Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session("error") }}' });
    @endif
</script>
@endsection
