{{-- resources/views/school/categories/edit.blade.php --}}
@extends('layouts.school')

@section('customCSS')
    <style>
        .bg-soft-primary { background-color: rgba(114, 124, 245, 0.1); }
        @media (max-width: 767px) {
            .custom-mobile-table tbody tr { display: block; border: 1px solid #eee; margin-bottom: 10px; border-radius: 8px; }
            .custom-mobile-table td { display: flex; justify-content: space-between; padding: 10px !important; }
            .custom-mobile-table td::before { content: attr(data-label); font-weight: bold; color: #6c757d; }
        }
        /* এডিট কার্ডের জন্য আলাদা হাইলাইট */
        .card-edit-highlight { border-top: 3px solid #727cf5; }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('categories.index', ['tenant' => auth()->user()->school->slug]) }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
            </ol>
        </nav>

        <div class="row">
            {{-- ক্যাটেগরি এডিট ফর্ম --}}
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card card-edit-highlight shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Edit Category</h6>
                        <form action="{{ route('categories.update', ['tenant' => auth()->user()->school->slug, 'category' => $category->id]) }}" method="POST">
                            @csrf
                            @method('PUT') {{-- আপডেট করার জন্য PUT মেথড আবশ্যক --}}
                            
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Exams Per Year</label>
                                <select name="exams_per_year" class="form-select">
                                    <option value="3" {{ old('exams_per_year', $category->exams_per_year) == 3 ? 'selected' : '' }}>
                                        3 Exams (Primary Default)
                                    </option>
                                    <option value="2" {{ old('exams_per_year', $category->exams_per_year) == 2 ? 'selected' : '' }}>
                                        2 Exams (Secondary/Higher Default)
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">Update Category</button>
                                <a href="{{ route('categories.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-light border">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- রেফারেন্সের জন্য ক্যাটেগরি লিস্ট (ঐচ্ছিক) --}}
            <div class="col-md-8 grid-margin stretch-card d-none d-md-block">
                <div class="card shadow-sm border-0 opacity-75"> {{-- এডিট মোডে লিস্টকে কিছুটা হালকা (opacity) রাখা হয়েছে --}}
                    <div class="card-body">
                        <h6 class="card-title text-muted">Other Categories</h6>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="bg-light text-muted">
                                    <tr>
                                        <th>Name</th>
                                        <th>Exams</th>
                                        <th class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $cat)
                                    <tr class="{{ $cat->id == $category->id ? 'bg-soft-primary' : '' }}">
                                        <td class="fw-bold">
                                            {{ $cat->name }}
                                            @if($cat->id == $category->id)
                                                <small class="text-primary ms-1">(Editing Now)</small>
                                            @endif
                                        </td>
                                        <td>{{ $cat->exams_per_year }} Exams</td>
                                        <td class="text-end">
                                            @if($cat->id == $category->id)
                                                <span class="badge bg-primary">Active Edit</span>
                                            @else
                                                <span class="badge bg-light text-muted">Read Only</span>
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