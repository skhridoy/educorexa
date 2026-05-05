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
                <p style="margin: 0; opacity: 0.85;">Create and manage subjects in your school</p>
            </div>
        </div>

        <div class="row">
            {{-- Form Column --}}
            <div class="col-lg-4 mb-4">
                <div class="form-card">
                    <h6 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-plus me-2"></i> Create Subject
                    </h6>
                    <form action="{{ route('subjects.store', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Subject Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Mathematics, English" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g., MATH101, ENG101">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Subject Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="" selected>Select Type</option>
                                <option value="theory">Theory</option>
                                <option value="practical">Practical</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Enter description (optional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100">
                            <i class="fa-solid fa-check me-1"></i> Create Subject
                        </button>
                    </form>
                </div>
            </div>

            {{-- Subjects List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header">
                        <h5 class="table-title"><i class="fa-solid fa-list me-2"></i> All Subjects</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                <tr>
                                    <td data-label="Name" style="font-weight: 600; text-transform: capitalize;">{{ $subject->name }}</td>
                                    <td data-label="Code"><span style="background: #eef2ff; color: #4f46e5; padding: 4px 8px; border-radius: 6px; font-size: 0.85rem;">{{ $subject->code }}</span></td>
                                    <td data-label="Type"><span style="text-transform: capitalize; background: #f0fdf4; color: #16a34a; padding: 4px 8px; border-radius: 6px; font-size: 0.85rem;">{{ $subject->type }}</span></td>
                                    <td data-label="Description">{{ \Str::limit($subject->description, 30) }}</td>
                                    <td data-label="Actions" class="text-center">
                                        <a href="{{ route('subjects.edit', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" class="btn btn-action btn-sm btn-outline-warning" title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('subjects.destroy', ['tenant' => auth()->user()?->school?->slug, 'subject' => $subject->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-action btn-sm btn-outline-danger" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fa-solid fa-inbox fa-3x mb-3" style="color:#e2e8f0;"></i>
                                        <p class="text-muted">No subjects found.</p>
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',

            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    button.closest('form').submit();

                }
            })
        }
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}', // প্রথম এরর মেসেজটি দেখাবে
                confirmButtonColor: '#3085d6',
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