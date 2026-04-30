@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super.subscription-packages.index') }}">Subscription Packages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Package</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Subscription Package</h6>
                    <form action="{{ route('super.subscription-packages.update', $subscriptionPackage->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Package Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $subscriptionPackage->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration <span class="text-danger">*</span></label>
                                <select name="duration" class="form-select" required>
                                    <option value="monthly" {{ old('duration', $subscriptionPackage->duration) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ old('duration', $subscriptionPackage->duration) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $subscriptionPackage->price) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Student Limit</label>
                                <input type="number" name="student_limit" class="form-control" value="{{ old('student_limit', $subscriptionPackage->student_limit) }}" placeholder="Leave empty for unlimited">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Teacher Limit</label>
                                <input type="number" name="teacher_limit" class="form-control" value="{{ old('teacher_limit', $subscriptionPackage->teacher_limit) }}" placeholder="Leave empty for unlimited">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2">{{ old('description', $subscriptionPackage->description) }}</textarea>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Features (One per line)</label>
                                @php
                                    $featuresText = is_array($subscriptionPackage->features) ? implode("\n", $subscriptionPackage->features) : '';
                                @endphp
                                <textarea name="features_list" class="form-control" rows="5" placeholder="Feature 1&#10;Feature 2">{{ old('features_list', $featuresText) }}</textarea>
                                <small class="text-muted">Enter each feature on a new line.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_popular" id="isPopular" {{ old('is_popular', $subscriptionPackage->is_popular) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isPopular">Mark as Most Popular</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_active" id="isActive" {{ old('is_active', $subscriptionPackage->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isActive">Is Active</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary px-4">Update Package</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
