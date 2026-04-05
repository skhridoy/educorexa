@extends('layouts.school')

@section('customCss')
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
            <nav class="col-md-6 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('school.dashboard', ['tenant' => auth()->user()->school->slug]) }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Create</li>
                </ol>
            </nav>
            
            <div class="my-2 text-end">
                
                <a href="{{ route('students.downloadTemplate', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-outline-primary btn-sm">
                    Download Excel
                </a>
                <a href="{{ route('students.importForm', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-primary btn-sm">Import Students</a>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Add New Student</h6>
                        <p class="card-description">Fill in the details below to add a new student to your school.</p>
                        <form method="POST" action="{{ route('students.store', ['tenant' => auth()->user()->school->slug]) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <h4 class="form-title mt-2 text-12">Academic Information</h4>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name <span class="text-warning mx-1">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            id="name" placeholder="Enter student's name">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="class_id" class="form-label">Class <span class="text-warning mx-1">*</span></label>
                                        <select class="form-select" id="class_id" name="class_id" required>
                                            <option value="">Select Class</option>
                                            
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" class="text-capitalize">{{ $class->name }}</option>
                                            @endforeach
                                            @error('class_id')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="section_id" class="form-label">Section <span class="text-warning mx-1">*</span></label>
                                        <select class="form-select" id="section_id" name="section_id" required>
                                            <option value="">Select Section</option>
                                            
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" class="text-capitalize">{{ $section->name }}</option>
                                            @endforeach
                                            @error('class_id')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="previous_school" class="form-label">Previous School </label>
                                        <input type="text" class="form-control" id="previous_school" name="previous_school" placeholder="Enter previous school name">
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="previous_class" class="form-label">Previous Class</label>
                                        <input type="text" name="previous_class" class="form-control"
                                            id="previous_class" placeholder="Enter student's previous class">
                                        @error('previous_class')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="admission_date" class="form-label">Admission Date</label>
                                        <input type="date" name="admission_date" class="form-control"
                                            id="admission_date" placeholder="Enter student's admission date">
                                        @error('admission_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="form-title mt-2 text-12">Personal Information</h4>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="father_name" class="form-label">Father Name</label>
                                        <input type="text" name="father_name" class="form-control"
                                            id="father_name" placeholder="Enter teacher's father name">
                                        @error('father_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="mother_name" class="form-label">Mother Name</label>
                                        <input type="text" name="mother_name" class="form-control"
                                            id="mother_name" placeholder="Enter teacher's mother name">
                                        @error('mother_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="father_nid" class="form-label">Father's NID</label>
                                        <input type="text" name="father_nid" class="form-control"
                                            id="father_nid" placeholder="Enter father's Nid number">
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="mother_nid" class="form-label">Mother's NID</label>
                                        <input type="text" name="mother_nid" class="form-control"
                                            id="mother_nid" placeholder="Enter mother's Nid number">
                                    </div>
                                </div>
                            
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="student_nid" class="form-label">Student NID/Birth <span class="text-warning mx-1">*</span></label>
                                        <input type="text" name="student_birth_nid" class="form-control"
                                            id="student_birth_nid" placeholder="Enter student's Nid number">
                                        @error('student_birth_nid')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label class="form-label">Date of Birth <span class="text-warning mx-1">*</span></label>
                                    <div class="input-group">
                                        <select name="dob_day" class="form-select" required>
                                            <option value="">Day</option>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}">{{ $i }}</option>
                                            @endfor
                                        </select>

                                        <select name="dob_month" class="form-select" required>
                                            <option value="">Month</option>
                                            @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $index => $month)
                                                <option value="{{ sprintf('%02d', $index + 1) }}">{{ $month }}</option>
                                            @endforeach
                                        </select>

                                        <select name="dob_year" class="form-select" required>
                                            <option value="">Year</option>
                                            @php
                                                $currentYear = date('Y');
                                                $startYear = $currentYear - 80; // ৮০ বছর আগের পর্যন্ত
                                            @endphp
                                            @for ($i = $currentYear; $i >= $startYear; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    @error('date_of_birth')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Gender <span class="text-warning mx-1">*</span></label>
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="religion" class="form-label">Religion <span class="text-warning mx-1">*</span></label>
                                        <select class="form-select" id="religion" name="religion">
                                            <option value="">Select Religion</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Hinduism">Hinduism</option>
                                            <option value="Christian">Christian</option>
                                            <option value="Buddhist">Buddhist</option>
                                        </select>
                                        @error('religion')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone <span class="text-warning mx-1">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter 11 digit phone number">
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <select class="form-select" id="blood_group" name="blood_group">
                                            <option value="">Select Blood Group</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            id="address" placeholder="Enter student's address">
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="form-title mt-2 text-12">Account Information</h4>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email <span class="text-warning mx-1">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            id="email" placeholder="Enter teacher's email">
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password <span class="text-warning mx-1">*</span></label>
                                        <input type="password" name="password" class="form-control"
                                            id="password" placeholder="Enter password">
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-warning mx-1">*</span></label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="password_confirmation" placeholder="Confirm password">
                                        @error('password_confirmation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="photo" class="form-label">Photo <span class="text-warning mx-1">*</span></label>
                                        <input type="file" class="form-control" id="photo" name="photo">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
<script>
    // Add any custom JavaScript for the teacher creation page here
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