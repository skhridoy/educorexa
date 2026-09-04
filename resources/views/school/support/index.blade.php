@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Exact Exam Page Stats Bar */
        .fee-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 20px;
        }
        .fee-stat-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            backdrop-filter: blur(8px);
        }
        .fee-stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
        }
        .fee-stat-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }
        .fee-stat-lbl {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }

        /* Filter Card Toolbar */
        .fee-filter-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: var(--card-shadow);
        }
        [data-bs-theme="dark"] .fee-filter-card,
        body.dark-mode .fee-filter-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }

        /* Action Buttons (Exact Exam Page Styles) */
        .btn-act {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            font-size: 0.82rem;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-act-view { 
            background: #eff6ff !important; 
            color: #3b82f6 !important; 
            border: 1px solid #bfdbfe !important; 
        }
        .btn-act-view:hover { 
            background: #3b82f6 !important; 
            color: #fff !important; 
            transform: translateY(-1px);
        }

        /* Priority & Status Badges */
        .badge-status {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-transform: uppercase;
        }
        .status-open     { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .status-pending  { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
        .status-resolved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .status-closed   { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

        .priority-high   { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }
        .priority-medium { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
        .priority-low    { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

        @media (max-width: 991.98px) {
            .fee-stats-bar { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 767.98px) {
            .fee-stats-bar { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .fee-stat-card { padding: 10px 12px; gap: 10px; }
            .fee-stat-icon { width: 36px; height: 36px; font-size: 1.1rem; }
            .fee-stat-val  { font-size: 1.25rem; }
            .fee-stat-lbl  { font-size: 0.7rem; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ═════════════════════════════════════════════════════════════
         HERO HEADER CARD (Matches Exam Page Header Exactly)
    ══════════════════════════════════════════════════════════════ --}}
    <div class="page-header-card">
        <div class="page-header-content">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon">
                        <i class="fa-solid fa-headset text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ __('Support Help Desk (সহায়তা ও সাপোর্ট সেন্টার)') }}</h4>
                        <p class="page-subtitle mb-0">
                            {{ __('Need help with your school software? Create a ticket and our technical team will respond promptly') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('school.support.create', ['tenant' => $tenant]) }}" class="btn-header-primary">
                        <i class="fa-solid fa-circle-plus"></i> {{ __('Create New Ticket') }}
                    </a>
                </div>
            </div>

            {{-- Exact Exam Stats Bar Component --}}
            <div class="fee-stats-bar">
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(59, 130, 246, 0.35);">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $tickets->total() }}</div>
                        <div class="fee-stat-lbl">{{ __('Total Tickets') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(245, 158, 11, 0.35);">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $tickets->whereIn('status', ['open', 'pending'])->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('Open / In Progress') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(16, 185, 129, 0.35);">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $tickets->where('status', 'resolved')->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('Resolved Tickets') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         TICKETS DATA TABLE CARD
    ══════════════════════════════════════════════════════════════ --}}
    <div class="data-table-card">
        <div class="data-table-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6; width: 34px; height: 34px;">
                    <i class="fa-solid fa-comments"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark">{{ __('Support Ticket Requests') }}</h6>
                    <small class="text-muted">{{ __('All communication threads with system administration') }}</small>
                </div>
            </div>
            <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill">
                {{ $tickets->total() }} {{ __('Tickets') }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="table modern-table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 130px;">{{ __('Ticket ID') }}</th>
                        <th>{{ __('Subject & Issue') }}</th>
                        <th>{{ __('Priority') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th class="text-center pe-4" style="width: 140px;">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-light text-dark border px-2 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                                #{{ $ticket->ticket_id }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}" class="fw-bold text-dark fs-14 text-decoration-none">
                                    {{ $ticket->subject }}
                                </a>
                                @if(!$ticket->is_read_by_school)
                                    <span class="badge bg-danger rounded-pill px-2 py-0" style="font-size: 10px;">{{ __('New Reply') }}</span>
                                @endif
                            </div>
                            <small class="text-muted fs-11">
                                {{ __('Last update:') }} {{ $ticket->updated_at->diffForHumans() }}
                            </small>
                        </td>
                        <td>
                            <span class="badge-status priority-{{ $ticket->priority }}">
                                <i class="fa-solid fa-circle" style="font-size: 6px;"></i> {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status status-{{ $ticket->status }}">
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
                        <td class="text-muted fs-12">
                            {{ $ticket->created_at->format('d M, Y • h:i A') }}
                        </td>
                        <td class="text-center pe-4">
                            <a href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}" 
                               class="btn btn-sm btn-primary-gradient px-3 py-1 rounded-pill" style="font-size: 12px;">
                                <i class="fa-regular fa-comment-dots me-1"></i> {{ __('View Chat') }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-headset fs-1 mb-3 opacity-25 text-secondary d-block"></i>
                            <h6 class="fw-bold">{{ __('No Support Tickets Found') }}</h6>
                            <p class="small text-muted mb-3">{{ __('If you face any issues or need customization, feel free to open a ticket.') }}</p>
                            <a href="{{ route('school.support.create', ['tenant' => $tenant]) }}" class="btn btn-sm btn-primary-gradient px-4 py-2">
                                <i class="fa-solid fa-plus me-1"></i> {{ __('Create First Ticket') }}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickets->hasPages())
        <div class="p-3 border-top d-flex justify-content-center">
            {{ $tickets->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@endsection
