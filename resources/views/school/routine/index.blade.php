@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-box">
                        <i class="fa-solid fa-table-list"></i>
                    </div>
                    <div>
                        <h1 class="page-title">Weekly Routine Chart</h1>
                        <p class="page-subtitle">Institutional class schedule in table format</p>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('routine.create') }}" class="btn btn-warning shadow-sm rounded-pill px-4">
                    <i class="fa fa-plus me-1"></i> Add New Routine
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Table Chart --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table routine-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 150px;">Day</th>
                            <th>Class Schedule Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                            $currentDay = date('l');
                        @endphp
                        @foreach($days as $day)
                            <tr class="{{ strtolower($day) == strtolower($currentDay) ? 'today-row' : '' }}">
                                <td class="day-name-cell">
                                    <div class="day-badge">
                                        {{ $day }}
                                        @if(strtolower($day) == strtolower($currentDay))
                                            <span class="dot-indicator"></span>
                                        @endif
                                    </div>
                                </td>
                                <td class="schedule-items-cell">
                                    <div class="d-flex flex-wrap gap-3">
                                        @forelse($routines[$day] ?? [] as $routine)
                                            <div class="routine-item-box">
                                                <div class="item-header">
                                                    <span class="time">{{ \Carbon\Carbon::parse($routine->start_time)->format('h:i A') }}</span>
                                                    <div class="actions">
                                                        <a href="{{ route('routine.edit', ['routine' => $routine->id, 'tenant' => auth()->user()->school->slug]) }}" class="text-primary me-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                                        <form action="{{ route('routine.destroy', ['routine' => $routine->id, 'tenant' => auth()->user()->school->slug]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link p-0 text-danger border-0"><i class="fa-solid fa-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="item-body">
                                                    <div class="subject">{{ $routine->subject->name ?? 'N/A' }}</div>
                                                    <div class="meta">
                                                        <span><i class="fa-solid fa-graduation-cap"></i> {{ $routine->class->name ?? 'N/A' }} ({{ $routine->section->name ?? 'N/A' }})</span>
                                                        <span><i class="fa-solid fa-user-tie"></i> {{ $routine->teacher->name ?? 'N/A' }}</span>
                                                        @if($routine->room_number)
                                                            <span><i class="fa-solid fa-door-open"></i> Room: {{ $routine->room_number }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-muted small py-2">No classes scheduled for {{ $day }}</div>
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

<style>
    .routine-table thead th {
        background: #1e293b;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        padding: 15px 25px;
        border: none;
    }
    .day-name-cell {
        vertical-align: top;
        padding: 25px !important;
        background: #f8fafc;
        border-right: 1px solid #e2e8f0;
    }
    .day-badge {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        color: #1e293b;
        font-size: 1.1rem;
        position: relative;
        display: inline-block;
    }
    .today-row .day-name-cell {
        background: rgba(79, 70, 229, 0.05);
    }
    .today-row .day-badge {
        color: #4f46e5;
    }
    .dot-indicator {
        position: absolute;
        top: -5px;
        right: -15px;
        width: 8px;
        height: 8px;
        background: #4f46e5;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(79, 70, 229, 0.5);
    }
    .schedule-items-cell {
        padding: 20px 25px !important;
    }
    .routine-item-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        width: 260px;
        overflow: hidden;
        transition: all 0.2s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .routine-item-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #4f46e5;
    }
    .item-header {
        background: #f8fafc;
        padding: 8px 12px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .item-header .time {
        font-size: 10px;
        font-weight: 800;
        color: #4f46e5;
        text-transform: uppercase;
    }
    .item-header .actions i {
        font-size: 12px;
    }
    .item-body {
        padding: 12px;
    }
    .item-body .subject {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    .item-body .meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .item-body .meta span {
        font-size: 11px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .item-body .meta i {
        width: 12px;
        opacity: 0.7;
    }
    .today-row {
        border-left: 4px solid #4f46e5;
    }
</style>
@endsection
