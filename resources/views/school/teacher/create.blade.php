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
                        <h6 class="card-title">Add New Teacher</h6>
                        <p class="card-description">Fill in the details below to add a new teacher to your school.</p>
                        <form method="POST" action="{{ route('teachers.store', ['tenant' => auth()->user()?->school?->slug]) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name <span class="text-warning mx-1">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            id="name" placeholder="Enter teacher's name">
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
                                                <option value="{{ $subject->id }}" class="text-capitalize">{{ $subject->name }}</option>
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
                            </div>

                            <div class="row">
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="nid" class="form-label">Nid Number</label>
                                        <input type="text" name="nid" class="form-control"
                                            id="nid" placeholder="Enter teacher's Nid number">
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
                                        <label for="phone" class="form-label">Phone <span class="text-warning mx-1">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
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
                                        <label for="joining_date" class="form-label">Joining Date</label>
                                        <input type="date" name="joining_date" class="form-control"
                                            id="joining_date" placeholder="Enter teacher's joining date">
                                        @error('joining_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="qualification" class="form-label">Qualification</label>
                                        <input type="text" name="qualification" class="form-control"
                                            id="qualification" placeholder="Enter teacher's qualification">
                                        @error('qualification')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            id="address" placeholder="Enter teacher's address">
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
                            <button type="submit" class="btn btn-primary">Add Teacher</button>
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
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this class?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',

        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                button.closest('form').submit();

            }
        })
    }
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