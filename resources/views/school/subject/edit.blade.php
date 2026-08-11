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
                <h1 class="page-title"><i class="fa-solid fa-pen-to-square me-2"></i> Update Subject</h1>
                <p class="page-subtitle">Edit subject name, code, type, and details.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- Form Column --}}
            <div class="col-lg-4">
                <div class="form-card">
                    <h5 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-sliders me-2"></i> Subject Details
                    </h5>
                    <form action="{{ route('subjects.update', ['tenant' => auth()->user()->school->slug, 'subject' => $subject->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Mathematics" value="{{ $subject->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold">Subject Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g. MATH101" value="{{ $subject->code }}">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">Subject Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="" selected>Select Type</option>
                                <option value="theory" {{ $subject->type == 'theory' ? 'selected' : '' }}>Theory</option>
                                <option value="practical" {{ $subject->type == 'practical' ? 'selected' : '' }}>Practical</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="{{ $subject->description }}">
                        </div>
                        <div class="d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-2 fw-bold">
                                <i class="fa-solid fa-check me-1"></i> Update Subject
                            </button>
                            <a href="{{ route('subjects.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-outline-secondary py-2 px-3">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- List Column --}}
            <div class="col-lg-8 d-none d-lg-block">
                <div class="data-table-card">
                    <div class="table-header p-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-indigo-600"></i> All Subjects</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3">Subject</th>
                                    <th class="py-3 px-3 text-center">Code</th>
                                    <th class="py-3 px-3 text-center">Type</th>
                                    <th class="py-3 px-3 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $subj)
                                <tr class="{{ $subj->id == $subject->id ? 'table-active fw-bold' : '' }}">
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.7rem;display:flex;align-items:center;justify-content:center;">
                                                <i class="fa-solid fa-book"></i>
                                            </div>
                                            <span class="text-capitalize">{{ $subj->name }}</span>
                                            @if($subj->id == $subject->id)
                                                <small class="text-primary fw-bold ms-1">(Editing)</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge bg-light text-primary border px-2 py-1" style="font-size:0.75rem;">
                                            {{ $subj->code ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center px-3 text-capitalize" style="font-size:0.8rem;">
                                        {{ $subj->type ?? 'Theory' }}
                                    </td>
                                    <td class="px-3 text-end">
                                        @if($subj->id == $subject->id)
                                            <span class="badge-completed"><span class="pulse-dot pulse-dot-green"></span> Active Edit</span>
                                        @else
                                            <span class="badge bg-light text-muted border px-2 py-1" style="font-size:0.72rem;">Read Only</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
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