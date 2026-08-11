@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .routine-day-row {
            transition: all 0.2s ease;
        }
        .routine-day-row.today-row {
            background-color: rgba(99, 102, 241, 0.05);
        }
        .routine-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 14px;
            min-width: 220px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            transition: all 0.2s;
            position: relative;
        }
        .routine-item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
            border-color: #6366f1;
        }
        .routine-time-badge {
            font-size: 0.72rem;
            font-weight: 700;
            color: #4f46e5;
            background: #eef2ff;
            padding: 3px 8px;
            border-radius: 6px;
        }
        .routine-subject-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f172a;
            margin: 6px 0 4px 0;
        }
        .routine-meta-item {
            font-size: 0.73rem;
            color: #64748b;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Dark Mode for Routine Cards */
        [data-bs-theme="dark"] .routine-item-card,
        body.dark-mode .routine-item-card {
            background: #0f1a2e !important;
            border-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .routine-item-card:hover,
        body.dark-mode .routine-item-card:hover {
            border-color: #6366f1 !important;
        }
        [data-bs-theme="dark"] .routine-subject-title,
        body.dark-mode .routine-subject-title {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .routine-meta-item,
        body.dark-mode .routine-meta-item {
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .routine-time-badge,
        body.dark-mode .routine-time-badge {
            background: rgba(99, 102, 241, 0.2) !important;
            color: #a5b4fc !important;
        }
        [data-bs-theme="dark"] .routine-day-row.today-row,
        body.dark-mode .routine-day-row.today-row {
            background-color: rgba(99, 102, 241, 0.12) !important;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="page-header-content">
                    <h1 class="page-title"><i class="fa-solid fa-calendar-week me-2"></i> Weekly Routine Chart</h1>
                    <p class="page-subtitle">Institutional class schedule organized by weekly days.</p>
                </div>
                <div>
                    <a href="{{ route('routine.create') }}" class="btn btn-warning fw-bold px-4 py-2" style="border-radius:12px;">
                        <i class="fa-solid fa-plus me-1"></i> Add New Routine
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Routine Table Card --}}
        <div class="data-table-card">
            <div class="table-responsive">
                <table class="table data-table mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 160px;" class="py-3 px-3">Day</th>
                            <th class="py-3 px-3">Class Schedule Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                            $currentDay = date('l');
                        @endphp
                        @foreach($days as $day)
                            <tr class="routine-day-row {{ strtolower($day) == strtolower($currentDay) ? 'today-row' : '' }}">
                                <td class="py-3 px-3 align-top">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.7rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            {{ substr($day, 0, 2) }}
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block" style="font-size:0.88rem;">{{ $day }}</span>
                                            @if(strtolower($day) == strtolower($currentDay))
                                                <span class="badge-completed" style="font-size:0.65rem; padding:1px 6px;">
                                                    <span class="pulse-dot pulse-dot-green"></span> Today
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        @forelse($routines[$day] ?? [] as $routine)
                                            <div class="routine-item-card">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="routine-time-badge">
                                                        <i class="fa-regular fa-clock me-1"></i>{{ \Carbon\Carbon::parse($routine->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($routine->end_time)->format('h:i A') }}
                                                    </span>
                                                    <div class="d-flex gap-1 ms-2">
                                                        <a href="{{ route('routine.edit', ['routine' => $routine->id, 'tenant' => auth()->user()->school->slug]) }}" class="text-primary me-1" title="Edit">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>
                                                        <form action="{{ route('routine.destroy', ['routine' => $routine->id, 'tenant' => auth()->user()->school->slug]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this routine?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link p-0 text-danger border-0" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="routine-subject-title">
                                                    {{ $routine->subject->name ?? 'N/A' }}
                                                </div>
                                                <div class="routine-meta-item">
                                                    <i class="fa-solid fa-graduation-cap text-indigo-600"></i>
                                                    <span>{{ $routine->class->name ?? 'N/A' }} ({{ $routine->section->name ?? 'N/A' }})</span>
                                                </div>
                                                <div class="routine-meta-item">
                                                    <i class="fa-solid fa-user-tie text-emerald-600"></i>
                                                    <span>{{ $routine->teacher->name ?? 'N/A' }}</span>
                                                </div>
                                                @if($routine->room_number)
                                                    <div class="routine-meta-item">
                                                        <i class="fa-solid fa-door-open text-amber-600"></i>
                                                        <span>Room: {{ $routine->room_number }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="text-muted small py-2">
                                                <i class="fa-regular fa-circle-xmark me-1"></i>No classes scheduled for {{ $day }}
                                            </div>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
