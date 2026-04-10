@extends('layouts.school')

@section('customCSS')
<style>
    /* মোবাইলের জন্য ক্লিন লুক */
    @media (max-width: 767px) {
        .custom-mobile-table tbody tr {
            display: block;
            background: #fff;
            border-radius: 10px;
            margin-bottom: 12px;
            border: 1px solid #f1f4f8 !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        }
        .custom-mobile-table td {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px !important;
            border: none !important;
            border-bottom: 1px solid #f8f9fb !important;
        }
        .custom-mobile-table td::before {
            content: attr(data-label);
            font-weight: bold;
            font-size: 11px;
            color: #888;
        }
    }
    .bg-soft-info { background-color: rgba(0, 204, 255, 0.1); }
</style>
@endsection
@section('content')
<div class="page-content">
    <div class="row">
                {{-- নতুন সাব-ক্যাটেগরি তৈরি --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card shadow-sm border-0 border-top border-info border-3">
                <div class="card-body">
                    <h6 class="card-title">Add Sub-Category</h6>
                    <form action="{{ route('sub-categories.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Main Category</label>
                            <select name="school_category_id" class="form-select border-info" required>
                                <option value="">Choose...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub-Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Science, Arts, Commerce" required>
                        </div>
                        <button type="submit" class="btn btn-info text-white w-100 shadow-sm">Save Sub-Category</button>
                    </form>
                </div>
            </div>
        </div>
        {{-- সাব-ক্যাটেগরি লিস্ট --}}
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body p-2 p-md-4">
                    <h6 class="card-title">Sub-Categories (Groups/Departments)</h6>
                    <div class="table-responsive-custom">
                        <table class="table custom-mobile-table align-middle">
                            <thead class="d-none d-md-table-header-group bg-light">
                                <tr>
                                    <th>Sub-Category</th>
                                    <th>Main Category</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subCategories as $sub)
                                <tr>
                                    <td data-label="Sub-Category" class="fw-bold text-primary">{{ $sub->name }}</td>
                                    <td data-label="Main Category">
                                        <span class="badge bg-soft-info text-info">{{ $sub->mainCategory->name }}</span>
                                    </td>
                                    <td data-label="Action" class="text-end">
                                        <button class="btn btn-inverse-danger btn-icon btn-sm"><i data-feather="trash"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No Sub-categories found.</td>
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