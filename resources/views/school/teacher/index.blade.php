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
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-box">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <div>
                        <h1 class="page-title">Teachers Management</h1>
                        <p class="page-subtitle">Manage and view all teachers in your school</p>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('teachers.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-primary-modern">
                    <i class="fa-solid fa-plus me-2"></i> Add Teacher
                </a>
            </div>
        </div>

        {{-- Search & Filter Section --}}
        <div class="search-card mb-4">
            <form action="" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="filter-label">Search Teacher</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" 
                                   placeholder="Name, ID, Email or Phone..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Subject</label>
                        <select name="subject_id" class="form-select">
                            <option value="">All Subjects</option>
                            @foreach($subjects ?? [] as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Sort By</label>
                        <select name="sort" class="form-select">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3">
                            <i class="fa-solid fa-filter me-2"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Data Table Card --}}
        <div class="data-table-card">
            <div class="table-header px-4 py-3 border-bottom">
                <h5 class="table-title mb-0"><i class="fa-solid fa-list me-2"></i> Teacher Directory</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                    {{ method_exists($teachers, 'total') ? $teachers->total() : count($teachers) }} Total
                </span>
            </div>

            <div class="table-responsive">
                <table class="table edu-table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Teacher Info</th>
                            <th>ID & Subject</th>
                            <th>Contact Info</th>
                            <th>Qualification</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $teacher->photo ? asset($teacher->photo) : asset('assets/images/profile.webp') }}" 
                                         alt="{{ $teacher->name }}" class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $teacher->name }}</div>
                                        <div class="small text-muted">{{ $teacher->designation ?? 'Teacher' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="badge bg-light text-dark mb-1">{{ $teacher->teacher_id }}</div>
                                <div class="small fw-semibold text-primary">{{ $teacher->subject?->name ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="small"><i class="fa-regular fa-envelope me-1 opacity-50"></i> {{ $teacher->email }}</div>
                                <div class="small"><i class="fa-solid fa-phone me-1 opacity-50"></i> {{ $teacher->phone }}</div>
                            </td>
                            <td>
                                <span class="small">{{ $teacher->qualification }}</span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('teachers.show', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" 
                                       class="btn btn-icon-sm btn-outline-primary" title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('teachers.edit', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" 
                                       class="btn btn-icon-sm btn-outline-warning" title="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('teachers.destroy', ['tenant' => auth()->user()?->school?->slug,'teacher' => $teacher->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="btn btn-icon-sm btn-outline-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fa-solid fa-chalkboard-user fa-4x mb-3 opacity-10"></i>
                                    <p class="text-muted fs-5">No teachers found in the records.</p>
                                    <a href="{{ route('teachers.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-primary mt-2">
                                        <i class="fa-solid fa-plus me-2"></i> Add Your First Teacher
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($teachers, 'links'))
                <div class="px-4 py-3 border-top">
                    {{ $teachers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    // Delete Confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this teacher?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // Success Message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    @endif

    // Error Message
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    @endif

    // Feather Icons Initialization
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') {
            feather.replace({ width: '18', height: '18' });
        }
    });
</script>
@endsection