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
                <h1 class="page-title"><i class="fa-solid fa-pen-to-square me-2"></i> Update Section</h1>
                <p class="page-subtitle">Modify section details and description.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- Form Column --}}
            <div class="col-lg-5">
                <div class="form-card">
                    <h5 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-sliders me-2"></i> Section Details
                    </h5>
                    <form action="{{ route('sections.update', ['tenant' => auth()->user()->school->slug,'section' => $section->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Section Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $section->name) }}" placeholder="e.g. A, B, Rose" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $section->description) }}" placeholder="Enter description for this section">
                        </div>
                        <div class="d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-2 fw-bold">
                                <i class="fa-solid fa-check me-1"></i> Update Section
                            </button>
                            <a href="{{ route('sections.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-outline-secondary py-2 px-3">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sections List Column --}}
            <div class="col-lg-7 d-none d-lg-block">
                <div class="data-table-card">
                    <div class="table-header p-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-indigo-600"></i> All Sections</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3">Section Name</th>
                                    <th class="py-3 px-3">Description</th>
                                    <th class="py-3 px-3 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sections as $sec)
                                <tr class="{{ $sec->id == $section->id ? 'table-active fw-bold' : '' }}">
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-weight:700;font-size:0.7rem;display:flex;align-items:center;justify-content:center;">
                                                {{ substr($sec->name, 0, 1) }}
                                            </div>
                                            <span>Section {{ $sec->name }}</span>
                                            @if($sec->id == $section->id)
                                                <small class="text-primary fw-bold ms-1">(Editing)</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3">
                                        <small class="text-muted">{{ $sec->description ?: '—' }}</small>
                                    </td>
                                    <td class="px-3 text-end">
                                        @if($sec->id == $section->id)
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
            text: "Do you want to delete this section?",
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