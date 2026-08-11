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
                <h1 class="page-title"><i class="fa-solid fa-book-open me-2"></i> Subjects Management</h1>
                <p class="page-subtitle">Create and manage institutional subjects, course codes, and types.</p>
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
                        <i class="fa-solid fa-plus me-2"></i> Create Subject
                    </h5>
                    <form action="{{ route('subjects.store', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Mathematics, English" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold">Subject Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g., MATH101, ENG101">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">Subject Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="" selected>Select Type</option>
                                <option value="theory">Theory</option>
                                <option value="practical">Practical</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Optional notes..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold">
                            <i class="fa-solid fa-check me-1"></i> Create Subject
                        </button>
                    </form>
                </div>
            </div>

            {{-- Subjects List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header d-flex align-items-center justify-content-between p-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-indigo-600"></i> All Subjects</h5>
                        <span class="badge bg-light text-muted border px-3 py-1" style="border-radius:10px;">
                            {{ count($subjects) }} Subjects
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3">Subject</th>
                                    <th class="py-3 px-3 text-center">Code</th>
                                    <th class="py-3 px-3 text-center">Type</th>
                                    <th class="py-3 px-3">Description</th>
                                    <th class="py-3 px-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                <tr>
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <i class="fa-solid fa-book"></i>
                                            </div>
                                            <span class="fw-bold text-dark text-capitalize" style="font-size:0.88rem;">{{ $subject->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge bg-light text-primary border px-2 py-1" style="border-radius:8px; font-size:0.78rem;">
                                            {{ $subject->code ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center px-3">
                                        @if($subject->type == 'practical')
                                            <span class="badge-pending" style="text-transform:capitalize;">
                                                <i class="fa-solid fa-flask me-1"></i>Practical
                                            </span>
                                        @else
                                            <span class="badge-completed" style="text-transform:capitalize;">
                                                <i class="fa-solid fa-pen-nib me-1"></i>{{ $subject->type ?? 'Theory' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3">
                                        <small class="text-muted">{{ \Str::limit($subject->description, 28) ?: '—' }}</small>
                                    </td>
                                    <td class="px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('subjects.edit', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" class="btn btn-action btn-sm btn-outline-warning" title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('subjects.destroy', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" method="POST" class="d-inline">
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
                                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
                                        No subjects found.
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
            text: "Do you want to delete this subject?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#4f46e5',
        });
    @endif
    @if(session('success'))
        Swal.fire({
            icon: '{{ session('type', 'success') }}',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection