{{-- resources/views/school/categories/index.blade.php --}}
@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
                        {{-- নতুন ক্যাটেগরি তৈরি --}}
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h6 class="card-title">Create Class</h6>
                        <form action="{{ route('categories.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Primary, Secondary" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Exams Per Year</label>
                                <select name="exams_per_year" class="form-select">
                                    <option value="3">3 Exams (Primary Default)</option>
                                    <option value="2">2 Exams (Secondary/Higher Default)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Save Category</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ক্যাটেগরি লিস্ট --}}
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title">School Categories</h6>
                        <div class="table-responsive-custom">
                            <table class="table custom-mobile-table align-middle">
                                <thead class="d-none d-md-table-header-group bg-light">
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Exams/Year</th>
                                        <th>Total Classes</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $cat)
                                    <tr>
                                        <td data-label="Category Name" class="fw-bold">{{ $cat->name }}</td>
                                        <td data-label="Exams/Year" class="text-center text-md-start">
                                            <span class="badge bg-soft-primary text-primary">{{ $cat->exams_per_year }} Exams</span>
                                        </td>
                                        <td data-label="Total Classes">{{ $cat->classes_count }} Classes</td>
                                        <td data-label="Action" class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('categories.edit', ['tenant' => auth()->user()->school->slug, 'category' => $cat->id]) }}" class="btn btn-inverse-info btn-icon btn-sm">

                                                    <button class="btn btn-inverse-info btn-icon btn-sm"><i data-feather="edit"></i></button>
                                                </a>
                                                <form action="{{ route('categories.destroy', ['tenant' => auth()->user()->school->slug, 'category' => $cat->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-inverse-danger btn-icon btn-sm" onclick="confirmDelete(this)"><i data-feather="trash"></i></button>
                                                </form>
                                            </div>
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
            text: "Do you want to delete this category?",
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