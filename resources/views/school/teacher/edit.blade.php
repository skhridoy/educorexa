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
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Update Teacher</h6>
                        <p class="card-description">Fill in the details below to update the teacher's information.</p>
                        <form method="POST" action="{{ route('teachers.update', ['teacher' => $teacher->id, 'tenant' => auth()->user()?->school?->slug]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name <span class="text-warning mx-1">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            id="name" placeholder="Enter teacher's name" value="{{ old('name', $teacher->name) }}">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="subject_id" class="form-label">Subject <span class="text-warning mx-1">*</span></label>
                                        <select class="form-select" id="subject_id" name="subject_id" required>
                                            <option value="">Select Subject</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" class="text-capitalize" {{ old('subject_id', $teacher->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                            @endforeach
                                            @error('subject_id')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="father_name" class="form-label">Father Name</label>
                                        <input type="text" name="father_name" class="form-control"
                                            id="father_name" placeholder="Enter teacher's father name" value="{{ old('father_name', $teacher->father_name) }}">
                                        @error('father_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="mother_name" class="form-label">Mother Name</label>
                                        <input type="text" name="mother_name" class="form-control"
                                            id="mother_name" placeholder="Enter teacher's mother name" value="{{ old('mother_name', $teacher->mother_name) }}">
                                        @error('mother_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="nid" class="form-label">Nid Number</label>
                                        <input type="text" name="nid" class="form-control"
                                            id="nid" placeholder="Enter teacher's Nid number" value="{{ old('nid', $teacher->nid) }}">
                                    </div>
                                </div>
                          
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-warning mx-1">*</span></label>
                                        <input type="date" name="date_of_birth" class="form-control"
                                            id="date_of_birth" placeholder="Enter teacher's date of birth" value="{{ old('date_of_birth', $teacher->date_of_birth) }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Gender <span class="text-warning mx-1">*</span></label>
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $teacher->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone <span class="text-warning mx-1">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $teacher->phone) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <select class="form-select" id="blood_group" name="blood_group">
                                            <option value="">Select Blood Group</option>
                                            <option value="A+" {{ old('blood_group', $teacher->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_group', $teacher->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_group', $teacher->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_group', $teacher->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_group', $teacher->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_group', $teacher->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ old('blood_group', $teacher->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_group', $teacher->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="joining_date" class="form-label">Joining Date</label>
                                        <input type="date" name="joining_date" class="form-control"
                                            id="joining_date" placeholder="Enter teacher's joining date" value="{{ old('joining_date', $teacher->joining_date) }}">
                                        @error('joining_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="qualification" class="form-label">Qualification</label>
                                        <input type="text" name="qualification" class="form-control"
                                            id="qualification" placeholder="Enter teacher's qualification" value="{{ old('qualification', $teacher->qualification) }}">
                                        @error('qualification')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            id="address" placeholder="Enter teacher's address" value="{{ old('address', $teacher->address) }}">
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email <span class="text-warning mx-1">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            id="email" placeholder="Enter teacher's email" value="{{ old('email', $teacher->email) }}">
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="photo" class="form-label">Photo <span class="text-warning mx-1">*</span></label>
                                        <input type="file" class="form-control" id="photo" name="photo" value="{{ old('photo') }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Teacher</button>
                            <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
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