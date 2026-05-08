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
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-box">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <h1 class="page-title">Teacher Profile</h1>
                        <p class="page-subtitle">Detailed information for {{ $teacher->name }}</p>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('teachers.edit', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" class="btn btn-warning shadow-sm rounded-pill px-4">
                    <i class="fa-regular fa-pen-to-square me-2"></i> Edit Profile
                </a>
                <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-outline-secondary shadow-sm rounded-pill px-4 ms-2">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column: Profile Card --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="text-center p-5" style="background: linear-gradient(135deg, var(--card-bg) 0%, rgba(0,0,0,0.02) 100%);">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ $teacher->photo ? asset($teacher->photo) : asset('assets/images/profile.webp') }}" 
                                 alt="{{ $teacher->name }}" 
                                 class="rounded-circle border border-4 border-white shadow-sm" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-4 border-white rounded-circle"></span>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">{{ $teacher->name }}</h4>
                        <p class="text-muted mb-3">{{ $teacher->designation ?? 'Teacher' }}</p>
                        <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-0">
                            ID: {{ $teacher->teacher_id }}
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box-sm bg-light text-primary me-3">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Department / Subject</small>
                                <span class="fw-bold">{{ $teacher->subject->name }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box-sm bg-light text-success me-3">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Contact Number</small>
                                <span class="fw-bold">{{ $teacher->phone }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="icon-box-sm bg-light text-danger me-3">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email Address</small>
                                <span class="fw-bold">{{ $teacher->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statistics or Quick Info --}}
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3">Quick Overview</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-light text-center">
                                <small class="text-muted d-block mb-1">Blood</small>
                                <span class="fw-bold text-danger">{{ $teacher->blood_group ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-light text-center">
                                <small class="text-muted d-block mb-1">Gender</small>
                                <span class="fw-bold text-primary text-capitalize">{{ $teacher->gender }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Detailed Info --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-info-circle me-2 text-primary"></i>Personal Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Father's Name</label>
                                    <p class="mb-0 fw-semibold">{{ $teacher->father_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Mother's Name</label>
                                    <p class="mb-0 fw-semibold">{{ $teacher->mother_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Date of Birth</label>
                                    <p class="mb-0 fw-semibold">{{ $teacher->date_of_birth }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Qualification</label>
                                    <p class="mb-0 fw-semibold text-primary">{{ $teacher->qualification }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-item p-3 bg-light rounded-3">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Present Address</label>
                                    <p class="mb-0 fw-semibold">{{ $teacher->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-briefcase me-2 text-success"></i>Employment Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Joining Date</label>
                                    <p class="mb-0 fw-semibold">{{ $teacher->joining_date }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Salary Structure</label>
                                    <p class="mb-0 fw-semibold">Standard</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-box-sm {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 1.1rem;
    }
    .info-item {
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 0.5rem;
    }
    .bg-light {
        background-color: var(--bg-light) !important;
    }
</style>
@endsection