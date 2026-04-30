@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super.testimonials.index') }}">Testimonials</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Testimonial</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Testimonial</h6>
                    <form action="{{ route('super.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Reviewer Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Designation (Optional)</label>
                                <input type="text" name="designation" class="form-control" value="{{ old('designation', $testimonial->designation) }}" placeholder="e.g. Principal">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Institution Name (Optional)</label>
                                <input type="text" name="institution_name" class="form-control" value="{{ old('institution_name', $testimonial->institution_name) }}" placeholder="e.g. Dhaka High School">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>
                                <select name="rating" class="form-select" required>
                                    <option value="5" {{ $testimonial->rating == 5 ? 'selected' : '' }}>5 Stars</option>
                                    <option value="4" {{ $testimonial->rating == 4 ? 'selected' : '' }}>4 Stars</option>
                                    <option value="3" {{ $testimonial->rating == 3 ? 'selected' : '' }}>3 Stars</option>
                                    <option value="2" {{ $testimonial->rating == 2 ? 'selected' : '' }}>2 Stars</option>
                                    <option value="1" {{ $testimonial->rating == 1 ? 'selected' : '' }}>1 Star</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="4" required>{{ old('message', $testimonial->message) }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Photo (Optional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                @if($testimonial->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($testimonial->image) }}" alt="current image" class="img-thumbnail" style="max-height: 80px;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" name="is_active" id="isActive" {{ $testimonial->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isActive">Is Active</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary px-4">Update Testimonial</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
