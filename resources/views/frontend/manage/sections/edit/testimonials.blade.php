@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Edit Testimonials Section</h6>
            <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Subtitle (Badge Text)</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ $content['subtitle'] ?? 'Testimonials' }}">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Main Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $content['title'] ?? 'What School Leaders Say' }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ $content['description'] ?? 'আমাদের ওপর আস্থা রেখেছেন দেশের অসংখ্য শিক্ষা প্রতিষ্ঠান।' }}</textarea>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i> Individual testimonials are managed from the Testimonials menu.
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary px-5">Update Testimonials Section Header</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
