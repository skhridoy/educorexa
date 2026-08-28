@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        input{
            min-width: 50px;
            }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .phone-icon{
            position: absolute;
            right: 12px;
            top: 38px;
            font-size: 18px;
            display: none;
        }

        .phone-valid{
            color: #28a745; /* green */
        }

        .phone-invalid{
            color: #dc3545; /* red */
        }
    </style>
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-box">
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                    <div>
                        <h1 class="page-title">Update Teacher</h1>
                        <p class="page-subtitle">Update information for {{ $teacher->name }}</p>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-outline-secondary shadow-sm rounded-pill px-4">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-file-invoice me-2 text-primary"></i>Teacher Information Form</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('teachers.update', ['teacher' => $teacher->id, 'tenant' => auth()->user()?->school?->slug]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4 mb-4">
                        {{-- Personal Details Section --}}
                        <div class="col-12">
                            <h6 class="text-primary fw-bold text-uppercase small mb-3 border-bottom pb-2">Personal Details</h6>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-3" 
                                       placeholder="Enter teacher's name" value="{{ old('name', $teacher->name) }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Primary Subject <span class="text-danger">*</span></label>
                                <select class="form-select rounded-3" name="subject_id" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id', $teacher->subject_id) == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->code ? $subject->code . ' - ' : '' }}{{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Father's Name</label>
                                <input type="text" name="father_name" class="form-control rounded-3" 
                                       placeholder="Father's name" value="{{ old('father_name', $teacher->father_name) }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Mother's Name</label>
                                <input type="text" name="mother_name" class="form-control rounded-3" 
                                       placeholder="Mother's name" value="{{ old('mother_name', $teacher->mother_name) }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">NID Number</label>
                                <input type="text" name="nid" class="form-control rounded-3" 
                                       placeholder="NID number" value="{{ old('nid', $teacher->nid) }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth" class="form-control rounded-3" 
                                       value="{{ old('date_of_birth', $teacher->date_of_birth) }}" required>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Gender <span class="text-danger">*</span></label>
                                <select class="form-select rounded-3" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $teacher->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Blood Group</label>
                                <select class="form-select rounded-3" name="blood_group">
                                    <option value="">Select Blood Group</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                        <option value="{{ $bg }}" {{ old('blood_group', $teacher->blood_group) == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Contact & Professional Section --}}
                        <div class="col-12 mt-4">
                            <h6 class="text-success fw-bold text-uppercase small mb-3 border-bottom pb-2">Contact & Professional Details</h6>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control rounded-3" 
                                       value="{{ old('phone', $teacher->phone) }}" required>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control rounded-3" 
                                       value="{{ old('email', $teacher->email) }}" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Qualification</label>
                                <input type="text" name="qualification" class="form-control rounded-3" 
                                       placeholder="e.g. M.A, B.Sc" value="{{ old('qualification', $teacher->qualification) }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Joining Date</label>
                                <input type="date" name="joining_date" class="form-control rounded-3" 
                                       value="{{ old('joining_date', $teacher->joining_date) }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Present Address</label>
                                <textarea name="address" class="form-control rounded-3" rows="2" 
                                          placeholder="Enter full address">{{ old('address', $teacher->address) }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Profile Photo</label>
                                <div class="d-flex align-items-center gap-3">
                                    @if($teacher->photo)
                                        <img src="{{ asset($teacher->photo) }}" class="rounded-3 border" style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                    <input type="file" name="photo" class="form-control rounded-3">
                                </div>
                                <small class="text-muted">Leave empty to keep current photo.</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex gap-2">
                        <button type="submit" class="btn btn-primary-modern px-5">
                            <i class="fa-solid fa-save me-2"></i> Update
                        </button>
                        <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-light rounded-pill px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
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