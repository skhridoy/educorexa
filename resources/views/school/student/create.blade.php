@extends('layouts.school')

@section('customCss')
<style>
    .form-section-title {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 25px;
        font-weight: 700;
        color: #050c24;
        border-bottom: 2px solid #e8ebf1;
    }
    .form-section-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 50px;
        height: 2px;
        background: #6571ff;
    }
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 12px;
    }
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #444;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.6rem 0.9rem;
        border: 1px solid #dce1e7;
    }
    .form-control:focus, .form-select:focus {
        border-color: #6571ff;
        box-shadow: 0 0 0 0.2rem rgba(101, 113, 255, 0.1);
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance: textfield; }

    @media (max-width: 576px) {
        
        .btn-sm.px-3 {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        .link-icon {
            margin-right: 0 !important;
        }
        .btn-sm span {
            display: none!important;
        }
    }

    /* ফটো প্রিভিউ বক্সের স্টাইল */
    #photo-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px dashed #dce1e7;
        display: none; /* শুরুতে হাইড থাকবে */
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('school.dashboard', ['tenant' => auth()->user()->school->slug]) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student Admission</li>
        </ol>
        <div class="d-flex gap-2">
            <a href="{{ route('students.downloadTemplate', ['tenant' => auth()->user()->school->slug]) }}" class="custom-btn btn btn-outline-primary btn-sm px-3">
                <i class="link-icon" data-feather="download"></i> <span>Download Template</span>
            </a>
            <a href="{{ route('students.importForm', ['tenant' => auth()->user()->school->slug]) }}" class="custom-btn btn btn-primary btn-sm px-3">
                <i class="link-icon" data-feather="upload"></i> <span>Import Students</span>
            </a>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">New Student Registration</h4>
                            <p class="text-muted">Fill out the form below to register a new student.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('students.store', ['tenant' => auth()->user()->school->slug]) }}" enctype="multipart/form-data">
                        @csrf

                        <h5 class="form-section-title">Academic Information</h5>
                        <div class="row mb-4">
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter student's full name" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Class <span class="text-danger">*</span></label>
                                <select class="form-select @error('class_id') is-invalid @enderror" name="class_id" id="class_id" required>
                                    <option value="">Choose Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Section <span class="text-danger">*</span></label>
                                <select class="form-select" name="section_id" id="section_id" required>
                                    <option value="">Choose Section</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="school_category_id" name="school_category_id" required>
                                    <option value="">Choose Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Group/Sub-Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="school_sub_category_id" name="school_sub_category_id" required>
                                    <option value="">Select Group</option>
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Admission Date</label>
                                <input type="date" name="admission_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Previous School Name</label>
                                <input type="text" name="previous_school" class="form-control" placeholder="Optional">
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Previous Class</label>
                                <input type="text" name="previous_class" class="form-control" placeholder="Optional">
                            </div>
                        </div>

                        <h5 class="form-section-title">Personal Information</h5>
                        <div class="row mb-4">
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Father's Name</label>
                                <input type="text" name="father_name" class="form-control" placeholder="Enter father's name">
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Mother's Name</label>
                                <input type="text" name="mother_name" class="form-control" placeholder="Enter mother's name">
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Father's NID</label>
                                <input type="text" name="father_nid" class="form-control" placeholder="NID Number">
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Mother's NID</label>
                                <input type="text" name="mother_nid" class="form-control" placeholder="NID Number">
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label">Student NID/Birth Certificate <span class="text-danger">*</span></label>
                                <input type="text" name="student_birth_nid" class="form-control" placeholder="Enter number" required>
                            </div>
                            <div class="col-lg-5 mb-3">
                                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="dob_day" class="form-select" required>
                                        <option value="">Day</option>
                                        @for ($i = 1; $i <= 31; $i++) <option value="{{ sprintf('%02d', $i) }}">{{ $i }}</option> @endfor
                                    </select>
                                    <select name="dob_month" class="form-select" required>
                                        <option value="">Month</option>
                                        @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $idx => $m)
                                            <option value="{{ sprintf('%02d', $idx + 1) }}">{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    <select name="dob_year" class="form-select" required>
                                        <option value="">Year</option>
                                        @for ($i = date('Y'); $i >= date('Y')-30; $i--) <option value="{{ $i }}">{{ $i }}</option> @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-lg-2 mb-3">
                                <label class="form-label">Religion</label>
                                <select class="form-select" name="religion">
                                    <option value="Islam">Islam</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Buddhist">Buddhist</option>
                                </select>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="01xxxxxxxxx" required maxlength="11">
                                <div id="phone-error" class="text-danger small" style="display:none;">Invalid Bangladeshi phone number</div>
                            </div>
                            <div class="col-lg-2 mb-3">
                                <label class="form-label">Blood Group</label>
                                <select class="form-select" name="blood_group">
                                    <option value="">Select</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                        <option value="{{ $bg }}">{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Permanent Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter full address">
                            </div>
                        </div>

                        <h5 class="form-section-title">Account Credentials</h5>
                        <div class="row mb-4">
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="student@example.com" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 characters" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Student Photo</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                <small class="text-muted">Max size: 2MB (JPG, PNG)</small>
                                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="reset" class="btn btn-light me-2">Reset Form</button>
                            <button type="submit" class="btn btn-primary px-5">Save Student Data</button>
                        </div>
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
            
            subCatDropdown.empty().append('<option value="">Loading...</option>');

            if(categoryId) {
                $.ajax({
                    url: "{{ route('get.subcategories', ['tenant' => auth()->user()->school->slug, 'categoryId' => ':id']) }}".replace(':id', categoryId),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        subCatDropdown.empty().append('<option value="">Select Group</option>');
                        $.each(data, function(key, value) {
                            subCatDropdown.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    },
                    error: function() {
                        subCatDropdown.empty().append('<option value="">No Group Found</option>');
                    }
                });
            }
        });
    });

    $(document).ready(function() {
    // ১. ফটো প্রিভিউ লজিক
    $('#photo-input').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#photo-preview').attr('src', event.target.result).fadeIn();
            }
            reader.readAsDataURL(file);
        }
    });

    // ২. ফোন নাম্বার ভেলিডেশন (বাংলাদেশী ফরমেট)
    $('#phone').on('input', function() {
        var phone = $(this).val();
        var regex = /^01[3-9]\d{8}$/; // বাংলাদেশী ১১ ডিজিট ভেলিডেশন
        
        // শুধু নাম্বার ইনপুট নিতে সাহায্য করবে
        this.value = this.value.replace(/[^0-9]/g, '');

        if (phone.length > 0) {
            if (regex.test(phone)) {
                $(this).removeClass('is-invalid').addClass('is-valid');
                $('#phone-error').hide();
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
                $('#phone-error').show();
            }
        } else {
            $(this).removeClass('is-invalid is-valid');
            $('#phone-error').hide();
        }
    });

    // ফর্ম সাবমিট করার সময় ভুল ফোন নাম্বার থাকলে বাধা দিবে
    $('form').on('submit', function(e) {
        var phone = $('#phone').val();
        var regex = /^01[3-9]\d{8}$/;
        if (!regex.test(phone)) {
            e.preventDefault();
            $('#phone').addClass('is-invalid').focus();
            $('#phone-error').show();
            Swal.fire('Error', 'Please enter a valid 11-digit phone number', 'error');
        }
    });
});
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Successful!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif
</script>
@endsection