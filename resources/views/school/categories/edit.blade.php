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
                <h1 class="page-title"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Category</h1>
                <p class="page-subtitle">Update category name and exam settings.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- Category Edit Form --}}
            <div class="col-lg-5">
                <div class="form-card">
                    <h5 class="mb-4 fw-bold text-primary">
                        <i class="fa-solid fa-sliders me-2"></i> Category Details
                    </h5>
                    <form action="{{ route('categories.update', ['tenant' => auth()->user()->school->slug, 'category' => $category->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Exams Per Year <span class="text-danger">*</span></label>
                            <select name="exams_per_year" class="form-select">
                                <option value="3" {{ old('exams_per_year', $category->exams_per_year) == 3 ? 'selected' : '' }}>
                                    3 Exams (Primary Default)
                                </option>
                                <option value="2" {{ old('exams_per_year', $category->exams_per_year) == 2 ? 'selected' : '' }}>
                                    2 Exams (Secondary/Higher Default)
                                </option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-2 fw-bold">
                                <i class="fa-solid fa-check me-1"></i> Update Category
                            </button>
                            <a href="{{ route('categories.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-outline-secondary py-2 px-3">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Reference List --}}
            <div class="col-lg-7 d-none d-lg-block">
                <div class="data-table-card">
                    <div class="table-header p-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-indigo-600"></i> Other Categories</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3">Category Name</th>
                                    <th class="py-3 px-3 text-center">Exams</th>
                                    <th class="py-3 px-3 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $cat)
                                <tr class="{{ $cat->id == $category->id ? 'table-active fw-bold' : '' }}">
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.7rem;display:flex;align-items:center;justify-content:center;">
                                                {{ strtoupper(substr($cat->name, 0, 1)) }}
                                            </div>
                                            <span>{{ $cat->name }}</span>
                                            @if($cat->id == $category->id)
                                                <small class="text-primary fw-bold ms-1">(Editing Now)</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center px-3">
                                        <span class="badge bg-light text-secondary border px-2 py-1" style="font-size:0.75rem;">
                                            {{ $cat->exams_per_year }} Exams
                                        </span>
                                    </td>
                                    <td class="px-3 text-end">
                                        @if($cat->id == $category->id)
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