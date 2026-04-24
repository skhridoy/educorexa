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
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Update Student</h6>
                        <p class="card-description">Fill in the details below to update student to your school.</p>
                        <form method="POST" action="{{ route('students.update', ['tenant' => auth()->user()?->school?->slug, 'student' => $student->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <h4 class="form-title mt-2 text-12">Academic Information</h4>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name </label>
                                        <input type="text" name="name" class="form-control"
                                            id="name" placeholder="Enter student's name" value="{{ old('name', $student->name) }}">
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="class_id" class="form-label">Class </label>
                                        <select class="form-select" id="class_id" name="class_id" required>
                                            
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" class="text-capitalize" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="school_category_id" class="form-label">Category </label>
                                        <select class="form-select" id="school_category_id" name="school_category_id">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('school_category_id', $student->school_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="school_sub_category_id" class="form-label">Group </label>
                                        <select class="form-select" id="school_sub_category_id" name="school_sub_category_id">
                                            <option value="">Select Group</option>
                                            @foreach($groups as $group)
                                                {{-- শুধুমাত্র বর্তমান ক্যাটাগরির গ্রুপগুলো দেখাবে --}}
                                                @if($group->school_category_id == $student->school_category_id)
                                                    <option value="{{ $group->id }}" {{ old('school_sub_category_id', $student->school_sub_category_id) == $group->id ? 'selected' : '' }}>
                                                        {{ $group->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="section_id" class="form-label">Section </label>
                                        <select class="form-select" id="section_id" name="section_id" required>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" class="text-capitalize" {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="previous_school" class="form-label">Previous School </label>
                                        <input type="text" class="form-control" id="previous_school" name="previous_school" placeholder="Enter previous school name" value="{{ old('previous_school', $student->previous_school) }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="previous_class" class="form-label">Previous Class</label>
                                        <input type="text" name="previous_class" class="form-control"
                                            id="previous_class" placeholder="Enter student's previous class" value="{{ old('previous_class', $student->previous_class) }}">
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="admission_date" class="form-label">Admission Date</label>
                                        <input type="date" name="admission_date" class="form-control"
                                            id="admission_date" placeholder="Enter student's admission date" value="{{ old('admission_date', $student->admission_date) }}">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="form-title mt-2 text-12">Personal Information</h4>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="father_name" class="form-label">Father Name</label>
                                        <input type="text" name="father_name" class="form-control"
                                            id="father_name" placeholder="Enter teacher's father name" value="{{ old('father_name', $student->father_name) }}">
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="mother_name" class="form-label">Mother Name</label>
                                        <input type="text" name="mother_name" class="form-control"
                                            id="mother_name" placeholder="Enter teacher's mother name" value="{{ old('mother_name', $student->mother_name) }}">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="father_nid" class="form-label">Father's NID</label>
                                        <input type="text" name="father_nid" class="form-control"
                                            id="father_nid" placeholder="Enter father's Nid number" value="{{ old('father_nid', $student->father_nid) }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="mother_nid" class="form-label">Mother's NID</label>
                                        <input type="text" name="mother_nid" class="form-control"
                                            id="mother_nid" placeholder="Enter mother's Nid number" value="{{ old('mother_nid', $student->mother_nid) }}">
                                    </div>
                                </div>
                            
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="student_nid" class="form-label">Student NID/Birth </label>
                                        <input type="text" name="student_birth_nid" class="form-control"
                                            id="student_birth_nid" placeholder="Enter student's Nid number" value="{{ old('student_birth_nid', $student->student_birth_nid) }}">
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="date_of_birth" class="form-label">Date of Birth </label>
                                        <input type="date" name="date_of_birth" class="form-control"
                                                id="date_of_birth" placeholder="Enter teacher's date of birth" value="{{ old('date_of_birth', $student->date_of_birth) }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Gender </label>
                                        <select class="form-select" id="gender" name="gender">
                                            @php
                                                $getGender = ['male', 'female', 'other'];
                                            @endphp
                                            @foreach ($getGender as $gender)
                                                <option class="text-capitalize" value="{{ $gender }}" {{ $student->gender == $gender ? 'Selected' : null}}>{{ $gender }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="religion" class="form-label">Religion </label>
                                        <select class="form-select" id="religion" name="religion">
                                            @php
                                                $religions = ['Islam', 'Hinduism', 'Buddhist', 'Christian'];
                                            @endphp
                                            @foreach($religions as $religion)
                                                <option value="{{ $religion }}" {{ $student->religion == $religion ? 'Selected' : null}}>{{ $religion }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone </label>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Enter 11 digit phone number" value="{{ old('contact_number', $student->contact_number) }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <select class="form-select" id="blood_group" name="blood_group">
                                            @php
                                                $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                                            @endphp
                                            @foreach($bloodGroups as $group)
                                                <option value="{{ $group }}" {{ $student->blood_group == $group ? 'Selected' : null}}>{{ $group }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            id="address" placeholder="Enter student's address" value="{{ old('address', $student->address) }}">
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="form-title mt-2 text-12">Account Information</h4>
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email </label>
                                        <input type="email" 
                                            name="email" 
                                            class="form-control"
                                            value="{{ $student->user->email ?? '' }}">
                                        
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 my-2">
                                    <div class="form-group">
                                        <label for="photo" class="form-label">Photo</label>
                                        <input type="file" class="form-control" id="photo" name="photo" value="{{ old('photo', $student->photo) }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Student</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
<script>
    $(document).ready(function() {
        $('#school_category_id').on('change', function() {
            var categoryId = $(this).val();
            var subCatDropdown = $('#school_sub_category_id');
            
            // আগে সাব-ক্যাটাগরি ক্লিয়ার করুন
            subCatDropdown.empty();
            subCatDropdown.append('<option value="">সাব-ক্যাটাগরি সিলেক্ট করুন</option>');

            if(categoryId) {
                $.ajax({
                    url: "{{ route('get.subcategories', ['tenant' => $tenant, 'categoryId' => ':id']) }}".replace(':id', categoryId),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            subCatDropdown.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            }
        });
    });
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