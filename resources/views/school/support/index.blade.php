@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ── Page Hero Banner ──────────────────────────────── */
        .supp-hero-card {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 60%, #a21caf 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(79, 70, 229, 0.3);
        }
        .supp-hero-card::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .supp-hero-card::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 30%;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .supp-hero-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .supp-hero-sub {
            color: rgba(255,255,255,0.78);
            font-size: 0.87rem;
            margin: 0;
        }
        .supp-hero-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            background: rgba(255,255,255,0.18);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            color: #fff;
            flex-shrink: 0;
            backdrop-filter: blur(4px);
        }
        .btn-hero-primary {
            background: #fff;
            color: #4f46e5;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 8px 18px;
            border-radius: 10px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .btn-hero-primary:hover {
            background: #f0f0ff;
            color: #3730a3;
            transform: translateY(-1px);
        }

        /* ── Stats Bar ──────────────────────────────────────── */
        .supp-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 22px;
        }
        .supp-stat-card {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            backdrop-filter: blur(8px);
        }
        .supp-stat-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.22);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            color: #fff;
            flex-shrink: 0;
        }
        .supp-stat-val {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }
        .supp-stat-lbl {
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.82);
            font-weight: 500;
        }

        /* ── Data Table Card ────────────────────────────────── */
        .supp-table-card {
            background: #ffffff;
            border: 1.5px solid #e8edf4;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
        }
        .supp-table-header {
            padding: 16px 24px;
            border-bottom: 1.5px solid #f1f5f9;
            background: #fafbfd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .supp-table-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: #eff6ff;
            color: #3b82f6;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.95rem;
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
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }
        .btn-view-chat:hover { color: #fff; opacity: 0.88; transform: translateY(-1px); }

        /* ── Empty State ────────────────────────────────────── */
        .supp-empty {
            padding: 60px 24px;
            text-align: center;
        }
        .supp-empty-icon {
            width: 80px; height: 80px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            color: #cbd5e1;
            margin: 0 auto 20px;
        }

        /* ── Responsive ─────────────────────────────────────── */
        @media (max-width: 767px) {
            .supp-stats-bar { grid-template-columns: 1fr 1fr; gap: 10px; }
            .supp-stat-val  { font-size: 1.2rem; }
            .supp-hero-title { font-size: 1.2rem; }
            .supp-hero-card { padding: 20px 18px; }
        }
        @media (max-width: 479px) {
            .supp-stats-bar { grid-template-columns: 1fr; }
        }

        [data-bs-theme="dark"] .supp-table-card,
        body.dark-mode .supp-table-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .supp-table-header,
        body.dark-mode .supp-table-header {
            background: #0d1830 !important;
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .supp-tbody td,
        body.dark-mode .supp-tbody td { color: #94a3b8; }
        [data-bs-theme="dark"] .supp-tbody tr:hover,
        body.dark-mode .supp-tbody tr:hover { background: #111c35 !important; }
        [data-bs-theme="dark"] .supp-thead th,
        body.dark-mode .supp-thead th { background: #0d1830 !important; color: #64748b; }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- ════ HERO HEADER BANNER ════ --}}
        <div class="supp-hero-card mb-4">
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

            {{-- Stats Bar --}}
            <div class="supp-stats-bar" style="position: relative; z-index: 1;">
                <div class="supp-stat-card">
                    <div class="supp-stat-icon">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <div>
                        <div class="supp-stat-val">{{ $totalTickets }}</div>
                        <div class="supp-stat-lbl">{{ __('Total Tickets') }}</div>
                    </div>
                </div>
                <div class="supp-stat-card">
                    <div class="supp-stat-icon" style="background: rgba(251,191,36,0.35);">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div>
                        <div class="supp-stat-val">{{ $openTickets }}</div>
                        <div class="supp-stat-lbl">{{ __('Open / Pending') }}</div>
                    </div>
                </div>
                <div class="supp-stat-card">
                    <div class="supp-stat-icon" style="background: rgba(16,185,129,0.35);">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="supp-stat-val">{{ $resolvedTickets }}</div>
                        <div class="supp-stat-lbl">{{ __('Resolved') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════ TICKETS TABLE CARD ════ --}}
        <div class="supp-table-card">
            <div class="supp-table-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="supp-table-icon">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ __('Support Ticket Requests') }}</h6>
                        <small class="text-muted">{{ __('All communication threads with system administration') }}</small>
                    </div>
                </div>
                <span class="badge rounded-pill px-3 py-2 fw-bold"
                      style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 0.75rem;">
                    {{ $totalTickets }} {{ __('Tickets') }}
                </span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="supp-thead">
                        <tr>
                            <th class="ps-4" style="width: 130px;">{{ __('Ticket ID') }}</th>
                            <th>{{ __('Subject & Issue') }}</th>
                            <th>{{ __('Priority') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th class="text-center pe-4" style="width: 120px;">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="supp-tbody">
                        @forelse($tickets as $ticket)
                        <tr>
                            <td class="ps-4">
                                <span class="bdg bdg-closed">
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
                                <div style="font-size: 0.8rem; color: #64748b;">{{ $ticket->created_at->format('d M, Y') }}</div>
                                <div style="font-size: 0.72rem; color: #94a3b8;">{{ $ticket->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('school.support.show', ['tenant' => $tenant, 'id' => $ticket->id]) }}"
                                   class="btn-view-chat">
                                    <i class="fa-regular fa-comment-dots"></i> {{ __('View') }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-0">
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

            @if($tickets->hasPages())
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $tickets->links('pagination::bootstrap-4') }}
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
