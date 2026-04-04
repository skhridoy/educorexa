@extends('layouts.school')
@section('customCSS')
    <style>
        .bg-soft-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .table td {
            vertical-align: middle;
            padding: 10px 15px;
        }
    </style>
@endsection
@section('content')

    <div class="page-content">
        <div class="row">
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary"><i class="bi bi-building"></i> স্কুল সেটিংস আপডেট করুন</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.school.info-update', ['tenant' => auth()->user()->school->slug]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">School's Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $school->name }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">EIN Number</label>
                        <input type="text" name="ein_number" class="form-control" value="{{ $school->ein_number }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">EMIS Code</label>
                        <input type="text" name="emis_code" class="form-control" value="{{ $school->emis_code }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $school->email }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ $school->phone }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">School Logo</label>
                        <input type="file" name="logo" class="form-control">
                        @if($school->logo)
                            <img src="{{ asset($school->logo) }}" class="mt-2 border" width="80">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Favicon (32x32)</label>
                        <input type="file" name="favicon" class="form-control">
                        @if($school->favicon)
                            <img src="{{ asset($school->favicon) }}" class="mt-2 border" width="32">
                        @endif
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">ঠিকানা</label>
                        <textarea name="address" class="form-control" rows="3">{{ $school->address }}</textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle"></i> তথ্য আপডেট করুন
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
@endsection