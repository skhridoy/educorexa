@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="mb-sm-0">Class Time Table</h4>
                    <div class="page-title-right">
                        <a href="{{ route('routine.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i> Add New Routine
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-dark fw-bold">
                                    <tr>
                                        <th>Day</th>
                                        <th>Class (Section)</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Time</th>
                                        <th>Room</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($routines as $routine)
                                        <tr>
                                            <td class="fw-bold text-primary">{{ $routine->day }}</td>
                                            <td>
                                                <span class="badge bg-soft-info text-info">{{ $routine->class->name ?? 'N/A' }}</span>
                                                <small class="text-muted">({{ $routine->section->name ?? 'N/A' }})</small>
                                            </td>
                                            <td>{{ $routine->subject->name ?? 'N/A' }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $routine->teacher->photo ? asset($routine->teacher->photo) : asset('assets/images/profile.webp') }}" 
                                                         onerror="this.src='{{ asset('assets/images/profile.webp') }}'"
                                                         class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                                    <span>{{ $routine->teacher->name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted small">
                                                    <i class="far fa-clock me-1 text-warning"></i>
                                                    {{ \Carbon\Carbon::parse($routine->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($routine->end_time)->format('h:i A') }}
                                                </span>
                                            </td>
                                            <td>{{ $routine->room_number ?? '-' }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('routine.edit', $routine->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('routine.destroy', $routine->id) }}" method="POST" onsubmit="return confirm('Delete this routine?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fa fa-calendar-times fs-1 mb-3 d-block opacity-25"></i>
                                                No class routine found.
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
    </div>
</div>

<style>
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .text-info { color: #0dcaf0 !important; }
</style>
@endsection
