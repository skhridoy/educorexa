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
                <h1 class="page-title"><i class="fa-solid fa-chalkboard-user me-2"></i> Teachers Management</h1>
                <p class="page-subtitle">Manage and view all teachers in your school</p>
            </div>
        </div>

        {{-- Data Table Card --}}
        <div class="data-table-card">
            <div class="table-header">
                <h5 class="table-title"><i class="fa-solid fa-list me-2"></i> All Teachers</h5>
                <a href="{{ route('teachers.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-primary" style="border-radius: 8px;">
                    <i class="fa-solid fa-plus me-1"></i> Add Teacher
                </a>
            </div>

            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Qualification</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                        <tr>
                            <td data-label="Photo">
                                <img src="{{ $teacher->photo ? asset($teacher->photo) : asset('assets/images/profile.webp') }}" alt="{{ $teacher->name }}" class="teacher-image">
                            </td>
                            <td data-label="ID" style="font-weight: 600;">{{ $teacher->teacher_id }}</td>
                            <td data-label="Name" style="font-weight: 600;">{{ $teacher->name }}</td>
                            <td data-label="Subject">{{ $teacher->subject?->name ?? 'N/A' }}</td>
                            <td data-label="Qualification">{{ $teacher->qualification }}</td>
                            <td data-label="Email"><small>{{ $teacher->email }}</small></td>
                            <td data-label="Phone"><small>{{ $teacher->phone }}</small></td>
                            <td data-label="Actions" class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('teachers.show', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" class="btn btn-action btn-sm btn-outline-primary" title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('teachers.edit', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" class="btn btn-action btn-sm btn-outline-warning" title="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('teachers.destroy', ['tenant' => auth()->user()?->school?->slug,'teacher' => $teacher->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="btn btn-action btn-sm btn-outline-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fa-solid fa-inbox fa-3x mb-3" style="color:#e2e8f0;"></i>
                                <p class="text-muted">No teachers found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination if exists --}}
            @if(method_exists($teachers, 'links'))
                <div class="mt-3">
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