@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-calendar-days me-2"></i> Academic Years Management</h1>
                <p class="page-subtitle">Set up and manage academic year calendars and session statuses.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Form Column --}}
            <div class="col-lg-4">
                <div class="form-card">
                    <h5 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-plus me-2"></i> Create Academic Year
                    </h5>
                    <form action="{{ route('academic-year.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Academic Year Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. 2026-2027 or 2026" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold">
                            <i class="fa-solid fa-check me-1"></i> Create Session
                        </button>
                    </form>
                </div>
            </div>

            {{-- Academic Years List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header d-flex align-items-center justify-content-between p-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list-ul me-2 text-indigo-600"></i> All Academic Years</h5>
                        <span class="badge bg-light text-muted border px-3 py-1" style="border-radius:10px;">
                            {{ count($academicYears) }} Sessions
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3">Session Name</th>
                                    <th class="py-3 px-3 text-center">Start Date</th>
                                    <th class="py-3 px-3 text-center">End Date</th>
                                    <th class="py-3 px-3 text-center">Status</th>
                                    <th class="py-3 px-3 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($academicYears as $academicYear)
                                <tr>
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <i class="fa-solid fa-calendar-check"></i>
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size:0.88rem;">{{ $academicYear->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge bg-light text-secondary border px-2 py-1" style="font-size:0.78rem;">
                                            <i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($academicYear->start_date)->format('d M, Y') }}
                                        </span>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge bg-light text-secondary border px-2 py-1" style="font-size:0.78rem;">
                                            <i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($academicYear->end_date)->format('d M, Y') }}
                                        </span>
                                    </td>
                                    <td class="text-center px-3">
                                        @if($academicYear->is_active)
                                            <form action="{{ route('academic-year.toggleInactive', ['academic_year' => $academicYear->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="badge-completed border-0 cursor-pointer" title="Click to make Inactive">
                                                    <span class="pulse-dot pulse-dot-green"></span> Active
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('academic-year.toggleActive', ['academic_year' => $academicYear->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="badge-pending border-0 cursor-pointer" title="Click to make Active">
                                                    <span class="pulse-dot pulse-dot-amber"></span> Inactive
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <form action="{{ route('academic-year.destroy', ['academic_year' => $academicYear->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" class="btn btn-action btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                        No Academic Years found.
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
@endsection

@section('customJs')
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this academic year?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>
@endsection
