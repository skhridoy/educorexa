@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ═══════════════════════════════════════
           SolaimanLipi — বাংলা ফন্ট লোড
        ═══════════════════════════════════════ */
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('{{ asset('fonts/SolaimanLipi.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        .font-bn {
            font-family: 'SolaimanLipi', 'Noto Serif Bengali', serif !important;
            font-size: 14px !important;
        }
        .bn-label-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            letter-spacing: .3px;
            margin-left: 6px;
            vertical-align: middle;
        }
        .form-section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            margin-bottom: 24px;
            border-bottom: 2px solid #f1f5f9;
        }
        .form-section-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .form-section-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1e293b;
            margin: 0;
        }
        .form-card-wrapper {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(15,23,42,0.06);
            margin-bottom: 30px;
        }
        [data-bs-theme="dark"] .form-card-wrapper,
        body.dark-mode .form-card-wrapper {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        .avatar-preview-ring {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4f46e5;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
        }

        /* Disable Bootstrap default SVG validation background image so custom icon is 100% crisp & clear */
        .form-control.is-valid, 
        .form-control.is-invalid,
        .form-select.is-valid,
        .form-select.is-invalid {
            background-image: none !important;
            padding-right: 40px !important;
        }

        /* Real-Time Input Validation Icon Styling */
        .input-icon-wrapper {
            position: relative;
            width: 100%;
        }
        .validation-status-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            display: none;
            z-index: 10;
            pointer-events: none;
            line-height: 1;
        }
        .validation-status-icon.valid {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #16a34a; /* Vibrant Green */
            font-size: 20px;
            filter: drop-shadow(0 2px 4px rgba(22, 163, 74, 0.25));
        }
        .validation-status-icon.invalid {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ef4444; /* Vibrant Red */
            font-size: 20px;
            filter: drop-shadow(0 2px 4px rgba(239, 68, 68, 0.25));
        }

        /* Premium Header Action Buttons Alignment & Design */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-header-outline {
            background: rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            backdrop-filter: blur(8px);
            font-weight: 600 !important;
            font-size: 13px !important;
            height: 38px !important;
            padding: 0 18px !important;
            border-radius: 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.25s ease !important;
            text-decoration: none !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        }
        .btn-header-outline:hover {
            background: rgba(255, 255, 255, 0.25) !important;
            border-color: rgba(255, 255, 255, 0.6) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(0,0,0,0.2) !important;
            transform: translateY(-1px);
        }
        .btn-header-solid {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            height: 38px !important;
            padding: 0 18px !important;
            border-radius: 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.25s ease !important;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4) !important;
            text-decoration: none !important;
        }
        .btn-header-solid:hover {
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.55) !important;
            transform: translateY(-1px);
        }

        @media (max-width: 576px) {
            .form-card-wrapper {
                padding: 18px !important;
            }
            .header-actions {
                width: 100%;
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 8px !important;
            }
            .btn-header-outline, .btn-header-solid {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="page-header-content d-flex align-items-center gap-3">
                <div class="header-icon-box">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h1 class="page-title fs-4 mb-1">{{ __('New Student Admission') }}</h1>
                    <p class="page-subtitle mb-0 small" style="color: rgba(255,255,255,0.75);">{{ __('Register a new student into your school database') }}</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn-header-outline">
                    <i class="fa-solid fa-arrow-left me-1.5"></i> {{ __('Student List') }}
                </a>
                <a href="{{ route('students.importForm', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn-header-solid">
                    <i class="fa-solid fa-file-excel me-1.5"></i> {{ __('Import Students') }}
                </a>
            </div>
        </div>

        {{-- Validation Errors Summary Alert --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-4 border-0 shadow-sm" style="background:#fef2f2; border-left:5px solid #ef4444 !important;">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="fa-solid fa-circle-exclamation text-danger fs-5"></i>
                    <strong class="text-danger">{{ __('The following errors were found while submitting the form:') }}</strong>
                </div>
                <ul class="mb-0 ps-4 small text-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('students.store', ['tenant' => auth()->user()?->school?->slug]) }}" enctype="multipart/form-data" id="studentCreateForm">
            @csrf

            {{-- 1. Academic Information --}}
            <div class="form-card-wrapper">
                <div class="form-section-header">
                    <div class="form-section-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <h5 class="form-section-title">{{ __('Academic Information') }}</h5>
                </div>

                <div class="row g-3">
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <input type="text" name="name" id="name"
                                   class="form-control pe-5 @error('name') is-invalid @enderror" 
                                   placeholder="Enter student full name" value="{{ old('name') }}" 
                                   oninput="validateName(this);" required>
                            <span class="validation-status-icon" id="name_icon"></span>
                        </div>
                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">বাংলা নাম <span class="bn-label-tag">বাংলা</span></label>
                        <input type="text" name="name_bn" id="name_bn"
                               class="form-control font-bn"
                               placeholder="শিক্ষার্থীর বাংলা নাম লিখুন"
                               value="{{ old('name_bn') }}">
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                        <select class="form-select @error('class_id') is-invalid @enderror" name="class_id" id="class_id" required>
                            <option value="">Choose Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Section <span class="text-danger">*</span></label>
                        <select class="form-select @error('section_id') is-invalid @enderror" name="section_id" id="section_id" required>
                            <option value="">Choose Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                            @endforeach
                        </select>
                        @error('section_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('school_category_id') is-invalid @enderror" id="school_category_id" name="school_category_id" required>
                            <option value="">Choose Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('school_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('school_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Group / Sub-Category</label>
                        <select class="form-select" id="school_sub_category_id" name="school_sub_category_id">
                            <option value="">Select Group</option>
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Admission Date <span class="text-danger">*</span></label>
                        <input type="date" name="admission_date" class="form-control @error('admission_date') is-invalid @enderror" value="{{ old('admission_date', date('Y-m-d')) }}" required>
                        @error('admission_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label fw-semibold">Previous School Name</label>
                        <input type="text" name="previous_school" class="form-control" placeholder="Optional previous school" value="{{ old('previous_school') }}">
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label fw-semibold">পূর্ববর্তী স্কুলের নাম <span class="bn-label-tag">বাংলা</span></label>
                        <input type="text" name="previous_school_bn" class="form-control font-bn" placeholder="পূর্ববর্তী স্কুলের বাংলা নাম (ঐচ্ছিক)" value="{{ old('previous_school_bn') }}">
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label fw-semibold">Previous Class</label>
                        <input type="text" name="previous_class" class="form-control" placeholder="Optional previous class" value="{{ old('previous_class') }}">
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label fw-semibold">পূর্ববর্তী শ্রেণি <span class="bn-label-tag">বাংলা</span></label>
                        <input type="text" name="previous_class_bn" class="form-control font-bn" placeholder="পূর্ববর্তী শ্রেণি বাংলায় (ঐচ্ছিক)" value="{{ old('previous_class_bn') }}">
                    </div>
                </div>
            </div>

            {{-- 2. Personal Information --}}
            <div class="form-card-wrapper">
                <div class="form-section-header">
                    <div class="form-section-icon"><i class="fa-solid fa-user me-1"></i></div>
                    <h5 class="form-section-title">{{ __('Personal & Guardian Details') }}</h5>
                </div>

                <div class="row g-3">
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Father's Name</label>
                        <input type="text" name="father_name" class="form-control" placeholder="Father's full name" value="{{ old('father_name') }}">
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">পিতার নাম <span class="bn-label-tag">বাংলা</span></label>
                        <input type="text" name="fathers_name_bn" class="form-control font-bn" placeholder="পিতার বাংলা নাম লিখুন" value="{{ old('fathers_name_bn') }}">
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Mother's Name</label>
                        <input type="text" name="mother_name" class="form-control" placeholder="Mother's full name" value="{{ old('mother_name') }}">
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">মাতার নাম <span class="bn-label-tag">বাংলা</span></label>
                        <input type="text" name="mothers_name_bn" class="form-control font-bn" placeholder="মাতার বাংলা নাম লিখুন" value="{{ old('mothers_name_bn') }}">
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Student Birth NID / Cert <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <input type="text" name="student_birth_nid" id="student_birth_nid"
                                   class="form-control pe-5 @error('student_birth_nid') is-invalid @enderror" 
                                   placeholder="Exactly 17 digits Birth Reg No" 
                                   maxlength="17"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); validateBirthNid(this);"
                                   value="{{ old('student_birth_nid') }}" required>
                            <span class="validation-status-icon" id="student_birth_nid_icon"></span>
                        </div>
                        <small class="text-muted d-block mt-1" id="birth_nid_hint">
                            <i class="fa-solid fa-info-circle me-1 text-primary"></i>১৭ ডিজিটের জন্ম নিবন্ধন নম্বর (<span id="birth_nid_cnt">0</span>/17)
                        </small>
                        @error('student_birth_nid') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Father's NID</label>
                        <div class="input-icon-wrapper">
                            <input type="text" name="father_nid" id="father_nid"
                                   class="form-control pe-5 @error('father_nid') is-invalid @enderror" 
                                   placeholder="10 or 17 digit NID Number" 
                                   maxlength="17"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); validateParentNid(this);"
                                   value="{{ old('father_nid') }}">
                            <span class="validation-status-icon" id="father_nid_icon"></span>
                        </div>
                        <small class="text-muted d-block mt-1">
                            <i class="fa-solid fa-info-circle me-1 text-primary"></i>১০ অথবা ১৭ ডিজিট (<span id="father_nid_cnt">0</span>)
                        </small>
                        @error('father_nid') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Mother's NID</label>
                        <div class="input-icon-wrapper">
                            <input type="text" name="mother_nid" id="mother_nid"
                                   class="form-control pe-5 @error('mother_nid') is-invalid @enderror" 
                                   placeholder="10 or 17 digit NID Number" 
                                   maxlength="17"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); validateParentNid(this);"
                                   value="{{ old('mother_nid') }}">
                            <span class="validation-status-icon" id="mother_nid_icon"></span>
                        </div>
                        <small class="text-muted d-block mt-1">
                            <i class="fa-solid fa-info-circle me-1 text-primary"></i>১০ অথবা ১৭ ডিজিট (<span id="mother_nid_cnt">0</span>)
                        </small>
                        @error('mother_nid') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="dob_day" class="form-select" required>
                                <option value="">Day</option>
                                @for ($i = 1; $i <= 31; $i++) <option value="{{ sprintf('%02d', $i) }}" {{ old('dob_day') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ $i }}</option> @endfor
                            </select>
                            <select name="dob_month" class="form-select" required>
                                <option value="">Month</option>
                                @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $idx => $m)
                                    <option value="{{ sprintf('%02d', $idx + 1) }}" {{ old('dob_month') == sprintf('%02d', $idx + 1) ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                            <select name="dob_year" class="form-select" required>
                                <option value="">Year</option>
                                @for ($i = date('Y'); $i >= date('Y')-30; $i--) <option value="{{ $i }}" {{ old('dob_year') == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                            <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                            <option value="other" {{ old('gender')=='other'?'selected':'' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Religion <span class="text-danger">*</span></label>
                        <select name="religion" class="form-select" required>
                            <option value="Islam" {{ old('religion','Islam')=='Islam'?'selected':'' }}>Islam</option>
                            <option value="Hinduism" {{ old('religion')=='Hinduism'?'selected':'' }}>Hinduism</option>
                            <option value="Buddhism" {{ old('religion')=='Buddhism'?'selected':'' }}>Buddhism</option>
                            <option value="Christianity" {{ old('religion')=='Christianity'?'selected':'' }}>Christianity</option>
                            <option value="Other" {{ old('religion')=='Other'?'selected':'' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Blood Group</label>
                        <select name="blood_group" class="form-select">
                            <option value="">Select Blood Group</option>
                            @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group')==$bg?'selected':'' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 col-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Present / permanent address">{{ old('address') }}</textarea>
                    </div>

                    <div class="col-lg-6 col-12">
                        <label class="form-label fw-semibold">ঠিকানা <span class="bn-label-tag">বাংলা</span></label>
                        <textarea name="address_bn" class="form-control font-bn" rows="2" placeholder="বর্তমান / স্থায়ী ঠিকানা বাংলায় লিখুন">{{ old('address_bn') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 3. Account Contact & Photo --}}
            <div class="form-card-wrapper">
                <div class="form-section-header">
                    <div class="form-section-icon"><i class="fa-solid fa-address-book"></i></div>
                    <h5 class="form-section-title">Contact Information & Photo</h5>
                </div>

                <div class="row g-3">
                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label fw-semibold">Student Email <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <input type="email" name="email" id="email"
                                   class="form-control pe-5 @error('email') is-invalid @enderror" 
                                   placeholder="student@school.com" value="{{ old('email') }}" 
                                   oninput="validateEmail(this);" required>
                            <span class="validation-status-icon" id="email_icon"></span>
                        </div>
                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label fw-semibold">Contact Phone</label>
                        <div class="input-icon-wrapper">
                            <input type="text" name="phone" id="phone"
                                   class="form-control pe-5 @error('phone') is-invalid @enderror" 
                                   placeholder="017XXXXXXXX (11 digits)" 
                                   maxlength="11"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); validatePhone(this);"
                                   value="{{ old('phone') }}">
                            <span class="validation-status-icon" id="phone_icon"></span>
                        </div>
                        <small class="text-muted d-block mt-1">
                            <i class="fa-solid fa-info-circle me-1 text-primary"></i>১১ ডিজিট ও 01 দিয়ে শুরু হতে হবে (<span id="phone_cnt">0</span>/11)
                        </small>
                        @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-12 col-12">
                        <div class="p-3 rounded-3 mb-2" style="background:#f8fafc; border:1px solid #e2e8f0;">
                            <p class="mb-0 small text-muted">
                                <i class="fa-solid fa-key me-1.5 text-primary"></i>Default Login Password:
                                <span class="badge bg-primary">12345678</span>
                                <span class="ms-1 text-secondary">(Students can log in with this password and change it anytime)</span>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-12 col-12">
                        <label class="form-label fw-semibold">Student Photo</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*" onchange="previewStudentPhoto(this);">
                            <img id="photo-preview-ring" src="#" alt="Preview" class="avatar-preview-ring d-none">
                        </div>
                        @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary-modern rounded-pill px-5">
                        <i class="fa-solid fa-user-plus me-1"></i> Register Student
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function updateValidationUI(inputId, isValid) {
        const input = document.getElementById(inputId);
        const iconSpan = document.getElementById(inputId + '_icon');
        if (!input || !iconSpan) return;

        const val = input.value.trim();
        if (val.length === 0) {
            iconSpan.className = 'validation-status-icon';
            iconSpan.innerHTML = '';
            input.classList.remove('is-valid', 'border-success', 'border-danger');
            return;
        }

        if (isValid) {
            iconSpan.className = 'validation-status-icon valid';
            iconSpan.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
            input.classList.add('is-valid', 'border-success');
            input.classList.remove('is-invalid', 'border-danger');
        } else {
            iconSpan.className = 'validation-status-icon invalid';
            iconSpan.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>';
            input.classList.add('is-invalid', 'border-danger');
            input.classList.remove('is-valid', 'border-success');
        }
    }

    function validateName(input) {
        const isValid = input.value.trim().length >= 2;
        updateValidationUI(input.id, isValid);
    }

    function validateBirthNid(input) {
        const val = input.value.trim();
        const cntSpan = document.getElementById('birth_nid_cnt');
        if (cntSpan) {
            cntSpan.textContent = val.length;
            cntSpan.style.color = val.length === 17 ? '#16a34a' : '#475569';
            cntSpan.style.fontWeight = val.length === 17 ? 'bold' : 'normal';
        }
        const isValid = /^\d{17}$/.test(val);
        updateValidationUI(input.id, isValid);
    }

    function validateParentNid(input) {
        const val = input.value.trim();
        const cntSpan = document.getElementById(input.id + '_cnt');
        if (cntSpan) {
            cntSpan.textContent = val.length;
            cntSpan.style.color = (val.length === 10 || val.length === 17) ? '#16a34a' : '#475569';
            cntSpan.style.fontWeight = (val.length === 10 || val.length === 17) ? 'bold' : 'normal';
        }
        const isValid = /^(\d{10}|\d{17})$/.test(val);
        updateValidationUI(input.id, isValid);
    }

    function validatePhone(input) {
        const val = input.value.trim();
        const cntSpan = document.getElementById('phone_cnt');
        if (cntSpan) {
            cntSpan.textContent = val.length;
            cntSpan.style.color = val.length === 11 ? '#16a34a' : '#475569';
            cntSpan.style.fontWeight = val.length === 11 ? 'bold' : 'normal';
        }
        const isValid = /^01[3-9]\d{8}$/.test(val);
        updateValidationUI(input.id, isValid);
    }

    function validateEmail(input) {
        const val = input.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isValid = emailRegex.test(val);
        updateValidationUI(input.id, isValid);
    }

    function previewStudentPhoto(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photo-preview-ring');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Initial status check for pre-filled/old values
        const birthInput = document.getElementById('student_birth_nid');
        if (birthInput && birthInput.value) validateBirthNid(birthInput);

        const fatherInput = document.getElementById('father_nid');
        if (fatherInput && fatherInput.value) validateParentNid(fatherInput);

        const motherInput = document.getElementById('mother_nid');
        if (motherInput && motherInput.value) validateParentNid(motherInput);

        const phoneInput = document.getElementById('phone');
        if (phoneInput && phoneInput.value) validatePhone(phoneInput);

        const emailInput = document.getElementById('email');
        if (emailInput && emailInput.value) validateEmail(emailInput);

        const nameInput = document.getElementById('name');
        if (nameInput && nameInput.value) validateName(nameInput);

        const form = document.getElementById('studentCreateForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const birthNid = document.getElementById('student_birth_nid')?.value.trim() || '';
                const phone = document.getElementById('phone')?.value.trim() || '';
                const fatherNid = document.getElementById('father_nid')?.value.trim() || '';
                const motherNid = document.getElementById('mother_nid')?.value.trim() || '';

                if (birthNid.length !== 17) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'জন্ম নিবন্ধন নম্বর ভুল!',
                        text: 'শিক্ষার্থীর জন্ম নিবন্ধন নম্বরটি অবশ্যই ১৭ ডিজিটের হতে হবে। (currently ' + birthNid.length + ' digits)',
                        confirmButtonText: 'ঠিক আছে',
                        confirmButtonColor: '#ef4444'
                    });
                    document.getElementById('student_birth_nid').focus();
                    return false;
                }

                if (phone.length > 0) {
                    const phoneRegex = /^01[3-9]\d{8}$/;
                    if (phone.length !== 11 || !phoneRegex.test(phone)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'ফোন নম্বর ফরম্যাট ভুল!',
                            text: 'ফোন নম্বরটি সঠিক নয় (১১ ডিজিট হতে হবে এবং 01 দিয়ে শুরু হতে হবে)।',
                            confirmButtonText: 'ঠিক আছে',
                            confirmButtonColor: '#ef4444'
                        });
                        document.getElementById('phone').focus();
                        return false;
                    }
                }

                if (fatherNid.length > 0 && fatherNid.length !== 10 && fatherNid.length !== 17) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'পিতার NID নম্বর ভুল!',
                        text: 'পিতার এনআইডি (NID) নম্বরটি অবশ্যই ১০ ডিজিট অথবা ১৭ ডিজিট হতে হবে।',
                        confirmButtonText: 'ঠিক আছে',
                        confirmButtonColor: '#ef4444'
                    });
                    document.getElementById('father_nid').focus();
                    return false;
                }

                if (motherNid.length > 0 && motherNid.length !== 10 && motherNid.length !== 17) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'মাতার NID নম্বর ভুল!',
                        text: 'মাতার এনআইডি (NID) নম্বরটি অবশ্যই ১০ ডিজিট অথবা ১৭ ডিজিট হতে হবে।',
                        confirmButtonText: 'ঠিক আছে',
                        confirmButtonColor: '#ef4444'
                    });
                    document.getElementById('mother_nid').focus();
                    return false;
                }
            });
        }
    });

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'তথ্য সঠিক নয়!',
            html: '<div class="text-start small text-danger"><ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>',
            confirmButtonText: 'ঠিক আছে',
            confirmButtonColor: '#ef4444'
        });
    @endif

    $(document).ready(function() {
        $('#school_category_id').on('change', function() {
            var categoryId = $(this).val();
            var tenant = "{{ auth()->user()?->school?->slug }}";
            if (categoryId) {
                $.ajax({
                    url: '/school/' + tenant + '/students/get-sub-categories/' + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#school_sub_category_id').empty().append('<option value="">Select Group</option>');
                        $.each(data, function(key, value) {
                            $('#school_sub_category_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#school_sub_category_id').empty().append('<option value="">Select Group</option>');
            }
        });
    });
</script>
@endsection