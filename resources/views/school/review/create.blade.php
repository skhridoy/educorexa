@extends('layouts.school')

@section('title', 'Submit Review')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('school.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Submit Review</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-chat-square-quote text-primary" style="font-size: 3rem;"></i>
                        <h4 class="card-title fw-bold mt-2">EduCorexa সম্পর্কে আপনার মতামত দিন</h4>
                        <p class="text-muted small">আপনার মূল্যবান মতামত আমাদের সেবার মান উন্নত করতে সাহায্য করবে।</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('school.review.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row bg-light rounded-3 p-3 mb-4 mx-0">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <label class="form-label text-muted small mb-1">Name</label>
                                <p class="fw-bold mb-0">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Institution</label>
                                <p class="fw-bold mb-0">{{ $school->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">আপনার পদবী (Designation) <span class="text-muted fw-normal small">(ঐচ্ছিক)</span></label>
                                <input type="text" name="designation" class="form-control" placeholder="যেমন: Principal, Director">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">রেটিং (Rating) <span class="text-danger">*</span></label>
                                <select name="rating" class="form-select" required>
                                    <option value="5" selected>⭐⭐⭐⭐⭐ (Excellent)</option>
                                    <option value="4">⭐⭐⭐⭐ (Good)</option>
                                    <option value="3">⭐⭐⭐ (Average)</option>
                                    <option value="2">⭐⭐ (Poor)</option>
                                    <option value="1">⭐ (Terrible)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">আপনার মতামত (Message) <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="5" placeholder="সফটওয়্যারটি ব্যবহার করে আপনার অভিজ্ঞতা শেয়ার করুন..." required></textarea>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm fw-bold">
                                <i class="bi bi-send me-2"></i> সাবমিট রিভিউ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
