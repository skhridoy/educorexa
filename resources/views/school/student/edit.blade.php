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
        .form-card-wrapper {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(15,23,42,0.06);
            margin-bottom: 24px;
        }
        [data-bs-theme="dark"] .form-card-wrapper,
        body.dark-mode .form-card-wrapper {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        .form-section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 14px;
            margin-bottom: 22px;
            border-bottom: 2px solid #f1f5f9;
        }
        .form-section-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .form-section-title { font-weight: 700; font-size: 1rem; color: #1e293b; margin: 0; }
        .form-section-subtitle { font-size: 12px; color: #94a3b8; margin: 0; }
        .edu-input {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 9px 38px 9px 14px !important;
            font-size: 13.5px;
            color: #1e293b;
            background: #fafbfc;
            transition: all .2s;
        }
        .edu-input:focus {
            outline: none;
            border-color: #4f46e5 !important;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.10) !important;
        }
        .form-control.is-valid, .form-control.is-invalid,
        .form-select.is-valid, .form-select.is-invalid {
            background-image: none !important;
            padding-right: 40px !important;
        }
        .edu-input.is-valid  { border-color: #10b981 !important; }
        .edu-input.is-invalid{ border-color: #ef4444 !important; }
        .form-label {
            font-size: 12px; font-weight: 600; color: #475569;
            margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px;
        }
        .input-icon-wrapper { position: relative; }
        .field-icon {
            position: absolute; right: 11px; top: 50%;
            transform: translateY(-50%); font-size: 14px;
            display: none; pointer-events: none;
        }
        .field-icon.valid   { color: #10b981; display: block; }
        .field-icon.invalid { color: #ef4444; display: block; }
        .avatar-preview-ring {
            width: 90px; height: 90px; border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4f46e5;
            box-shadow: 0 4px 14px rgba(79,70,229,0.25);
        }
        .edit-hero {
            background: linear-gradient(135deg,#4f46e5 0%,#7c3aed 50%,#a855f7 100%);
            border-radius: 20px; padding: 28px 32px; margin-bottom: 24px;
            position: relative; overflow: hidden;
        }
        .edit-hero::before {
            content:''; position:absolute; top:-50px; right:-50px;
            width:200px; height:200px; background:rgba(255,255,255,0.07); border-radius:50%;
        }
        .edit-hero::after {
            content:''; position:absolute; bottom:-60px; left:-30px;
            width:160px; height:160px; background:rgba(255,255,255,0.04); border-radius:50%;
        }
        .btn-save {
            background: linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
            color: #fff; border: none; border-radius: 12px;
            padding: 10px 32px; font-size: 14px; font-weight: 700; letter-spacing: .3px;
            box-shadow: 0 4px 16px rgba(79,70,229,0.35);
            transition: all .25s cubic-bezier(.4,0,.2,1); cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(79,70,229,0.45); color: #fff; }
        .btn-cancel {
            background: #f1f5f9; color: #475569;
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            padding: 10px 24px; font-size: 14px; font-weight: 600;
            transition: all .2s; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        }
        .btn-cancel:hover { background: #e2e8f0; color: #1e293b; }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- â•â• HERO HEADER â•â• --}}
    <div class="edit-hero">
        <div class="d-flex align-items-center gap-4" style="position:relative;z-index:1;">
            <div style="flex-shrink:0;">
                <img id="heroAvatarPreview"
                     src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"
                     alt="{{ $student->name }}"
                     style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,0.5);box-shadow:0 0 0 4px rgba(255,255,255,0.15);">
            </div>
            <div>
                <h4 class="text-white fw-bold mb-1" style="text-shadow:0 1px 4px rgba(0,0,0,0.2);">{{ $student->name }}</h4>
                <div class="d-flex flex-wrap gap-2 mt-1">
                    <span style="background:rgba(255,255,255,0.18);backdrop-filter:blur(8px);color:#fff;font-size:11px;font-weight:700;padding:3px 12px;border-radius:50px;border:1px solid rgba(255,255,255,0.25);">
                        <i class="fa-solid fa-id-badge me-1 opacity-75"></i>{{ $student->student_id }}
                    </span>
                    <span style="background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);color:#e0d9ff;font-size:11px;font-weight:600;padding:3px 12px;border-radius:50px;border:1px solid rgba(255,255,255,0.2);">
                        <i class="fa-solid fa-graduation-cap me-1 opacity-75"></i>{{ $student->class?->name ?? 'N/A' }} — {{ $student->section?->name ?? '' }}
                    </span>
                    <span style="background:{{ $student->status == 'active' ? 'rgba(16,185,129,0.3)' : 'rgba(245,158,11,0.3)' }};color:{{ $student->status == 'active' ? '#d1fae5' : '#fef3c7' }};font-size:11px;font-weight:700;padding:3px 12px;border-radius:50px;border:1px solid {{ $student->status == 'active' ? 'rgba(16,185,129,0.4)' : 'rgba(245,158,11,0.4)' }};">
                        <i class="fa-solid fa-circle me-1" style="font-size:7px;vertical-align:middle;"></i>{{ ucfirst($student->status ?? 'active') }}
                    </span>
                </div>
            </div>
            <div class="ms-auto d-none d-md-block">
                <a href="{{ route('students.index', ['tenant' => $tenant]) }}"
                   style="background:rgba(255,255,255,0.18);backdrop-filter:blur(8px);color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:10px;padding:8px 20px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .2s;"
                   onmouseover="this.style.background='rgba(255,255,255,0.28)'" onmouseout="this.style.background='rgba(255,255,255,0.18)'">
                    <i class="fa-solid fa-arrow-left"></i> {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </div>

    {{-- ════ FORM ════ --}}
    <form method="POST" action="{{ route('students.update', ['tenant' => auth()->user()?->school?->slug, 'student' => $student->id]) }}" enctype="multipart/form-data" id="studentEditForm">
        @csrf
        @method('PUT')

        {{-- 1. Academic Information --}}
        <div class="form-card-wrapper">
            <div class="form-section-header">
                <div class="form-section-icon" style="background:rgba(79,70,229,0.1);color:#4f46e5;">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="form-section-title">{{ __('Academic Information') }}</div>
                    <div class="form-section-subtitle">{{ __('Class, section, category and admission details') }}</div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="name">Student Name</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="name" id="name"
                               class="form-control edu-input @error('name') is-invalid @enderror"
                               placeholder="Enter student's full name"
                               value="{{ old('name', $student->name) }}" required>
                        <i class="fa-solid fa-check field-icon @error('name') invalid @else {{ old('name', $student->name) ? 'valid' : '' }} @enderror"></i>
                        @error('name') <div class="invalid-feedback" style="font-size:11px;">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="name_bn">বাংলা নাম <span class="bn-label-tag">বাংলা</span></label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="name_bn" id="name_bn"
                               class="form-control edu-input font-bn"
                               placeholder="শিক্ষার্থীর বাংলা নাম লিখুন"
                               value="{{ old('name_bn', $student->name_bn) }}">
                        <i class="fa-solid fa-check field-icon {{ old('name_bn', $student->name_bn) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="roll">Roll Number</label>
                    <div class="input-icon-wrapper">
                        <input type="number" name="roll" id="roll" min="1"
                               class="form-control edu-input @error('roll') is-invalid @enderror"
                               value="{{ old('roll', $student->roll) }}" required>
                        <i class="fa-solid fa-hashtag field-icon @error('roll') invalid @else {{ old('roll', $student->roll) ? 'valid' : '' }} @enderror"></i>
                        @error('roll') <div class="invalid-feedback" style="font-size:11px;">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="class_id">Class</label>
                    <select class="form-select edu-input" id="class_id" name="class_id" required>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="school_category_id">Category</label>
                    <select class="form-select edu-input" id="school_category_id" name="school_category_id">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('school_category_id', $student->school_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="school_sub_category_id">Group</label>
                    <select class="form-select edu-input" id="school_sub_category_id" name="school_sub_category_id">
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            @if($group->school_category_id == $student->school_category_id)
                                <option value="{{ $group->id }}" {{ old('school_sub_category_id', $student->school_sub_category_id) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="section_id">Section</label>
                    <select class="form-select edu-input" id="section_id" name="section_id" required>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="previous_school">Previous School</label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control edu-input" id="previous_school" name="previous_school"
                               placeholder="Previous school name"
                               value="{{ old('previous_school', $student->previous_school) }}">
                        <i class="fa-solid fa-check field-icon {{ old('previous_school', $student->previous_school) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="previous_school_bn">পূর্ববর্তী স্কুল <span class="bn-label-tag">বাংলা</span></label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control edu-input font-bn" id="previous_school_bn" name="previous_school_bn"
                               placeholder="পূর্ববর্তী স্কুলের বাংলা নাম"
                               value="{{ old('previous_school_bn', $student->previous_school_bn) }}">
                        <i class="fa-solid fa-check field-icon {{ old('previous_school_bn', $student->previous_school_bn) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="previous_class">Previous Class</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="previous_class" class="form-control edu-input" id="previous_class"
                               placeholder="Previous class name"
                               value="{{ old('previous_class', $student->previous_class) }}">
                        <i class="fa-solid fa-check field-icon {{ old('previous_class', $student->previous_class) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="previous_class_bn">পূর্ববর্তী শ্রেণি <span class="bn-label-tag">বাংলা</span></label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control edu-input font-bn" id="previous_class_bn" name="previous_class_bn"
                               placeholder="পূর্ববর্তী শ্রেণি বাংলায়"
                               value="{{ old('previous_class_bn', $student->previous_class_bn) }}">
                        <i class="fa-solid fa-check field-icon {{ old('previous_class_bn', $student->previous_class_bn) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="admission_date">Admission Date</label>
                    <div class="input-icon-wrapper">
                        <input type="date" name="admission_date" class="form-control edu-input" id="admission_date"
                               value="{{ old('admission_date', $student->admission_date) }}">
                        <i class="fa-solid fa-check field-icon {{ old('admission_date', $student->admission_date) ? 'valid' : '' }}"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Personal & Guardian --}}
        <div class="form-card-wrapper">
            <div class="form-section-header">
                <div class="form-section-icon" style="background:rgba(14,165,233,0.1);color:#0ea5e9;">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <div class="form-section-title">{{ __('Personal & Guardian Information') }}</div>
                    <div class="form-section-subtitle">{{ __('Parent details, date of birth, gender and religion') }}</div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="fathers_name">Father's Name</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="fathers_name" class="form-control edu-input" id="fathers_name"
                               placeholder="Father's full name"
                               value="{{ old('fathers_name', $student->fathers_name) }}">
                        <i class="fa-solid fa-check field-icon {{ old('fathers_name', $student->fathers_name) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="fathers_name_bn">পিতার নাম <span class="bn-label-tag">বাংলা</span></label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="fathers_name_bn" class="form-control edu-input font-bn" id="fathers_name_bn"
                               placeholder="পিতার বাংলা নাম"
                               value="{{ old('fathers_name_bn', $student->fathers_name_bn) }}">
                        <i class="fa-solid fa-check field-icon {{ old('fathers_name_bn', $student->fathers_name_bn) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="mothers_name">Mother's Name</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="mothers_name" class="form-control edu-input" id="mothers_name"
                               placeholder="Mother's full name"
                               value="{{ old('mothers_name', $student->mothers_name) }}">
                        <i class="fa-solid fa-check field-icon {{ old('mothers_name', $student->mothers_name) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="mothers_name_bn">মাতার নাম <span class="bn-label-tag">বাংলা</span></label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="mothers_name_bn" class="form-control edu-input font-bn" id="mothers_name_bn"
                               placeholder="মাতার বাংলা নাম"
                               value="{{ old('mothers_name_bn', $student->mothers_name_bn) }}">
                        <i class="fa-solid fa-check field-icon {{ old('mothers_name_bn', $student->mothers_name_bn) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="father_nid">Father's NID</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="father_nid" class="form-control edu-input" id="father_nid"
                               placeholder="10 or 17 digit NID"
                               value="{{ old('father_nid', $student->father_nid) }}" maxlength="17">
                        <i class="fa-solid fa-check field-icon" id="father_nid_icon"></i>
                    </div>
                    <div class="text-danger" id="father_nid_error" style="font-size:11px;display:none;"></div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="mother_nid">Mother's NID</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="mother_nid" class="form-control edu-input" id="mother_nid"
                               placeholder="10 or 17 digit NID"
                               value="{{ old('mother_nid', $student->mother_nid) }}" maxlength="17">
                        <i class="fa-solid fa-check field-icon" id="mother_nid_icon"></i>
                    </div>
                    <div class="text-danger" id="mother_nid_error" style="font-size:11px;display:none;"></div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="student_birth_nid">Birth Registration No.</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="student_birth_nid" class="form-control edu-input" id="student_birth_nid"
                               placeholder="17 digit registration number"
                               value="{{ old('student_birth_nid', $student->student_birth_nid) }}" maxlength="17">
                        <i class="fa-solid fa-check field-icon" id="birth_nid_icon"></i>
                    </div>
                    <div class="text-danger" id="birth_nid_error" style="font-size:11px;display:none;"></div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="date_of_birth">Date of Birth</label>
                    <div class="input-icon-wrapper">
                        <input type="date" name="date_of_birth" class="form-control edu-input" id="date_of_birth"
                               value="{{ old('date_of_birth', $student->date_of_birth) }}">
                        <i class="fa-solid fa-check field-icon {{ old('date_of_birth', $student->date_of_birth) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="gender">Gender</label>
                    <select class="form-select edu-input" id="gender" name="gender">
                        @foreach(['male','female','other'] as $g)
                            <option value="{{ $g }}" {{ $student->gender == $g ? 'selected' : '' }}>{{ ucfirst($g) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="religion">Religion</label>
                    <select class="form-select edu-input" id="religion" name="religion">
                        @foreach(['Islam','Hinduism','Buddhist','Christian'] as $r)
                            <option value="{{ $r }}" {{ $student->religion == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="blood_group">Blood Group</label>
                    <select class="form-select edu-input" id="blood_group" name="blood_group">
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                            <option value="{{ $bg }}" {{ $student->blood_group == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- 3. Contact & Address --}}
        <div class="form-card-wrapper">
            <div class="form-section-header">
                <div class="form-section-icon" style="background:rgba(16,185,129,0.1);color:#10b981;">
                    <i class="fa-solid fa-address-book"></i>
                </div>
                <div>
                    <div class="form-section-title">{{ __('Contact & Address') }}</div>
                    <div class="form-section-subtitle">{{ __('Phone number and present address') }}</div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="contact_number">{{ __('Contact Number') }}</label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control edu-input" id="contact_number" name="contact_number"
                               placeholder="11 digit phone (01XXXXXXXXX)"
                               value="{{ old('contact_number', $student->contact_number) }}" maxlength="11">
                        <i class="fa-solid fa-check field-icon" id="phone_icon"></i>
                    </div>
                    <div class="text-danger" id="phone_error" style="font-size:11px;display:none;"></div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="form-label" for="address">{{ __('Present / Permanent Address') }}</label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="address" class="form-control edu-input" id="address"
                               placeholder="Enter full address"
                               value="{{ old('address', $student->address) }}">
                        <i class="fa-solid fa-check field-icon {{ old('address', $student->address) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="form-label" for="address_bn">ঠিকানা <span class="bn-label-tag">বাংলা</span></label>
                    <div class="input-icon-wrapper">
                        <input type="text" name="address_bn" class="form-control edu-input font-bn" id="address_bn"
                               placeholder="বর্তমান / স্থায়ী ঠিকানা বাংলায়"
                               value="{{ old('address_bn', $student->address_bn) }}">
                        <i class="fa-solid fa-check field-icon {{ old('address_bn', $student->address_bn) ? 'valid' : '' }}"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Account & Photo --}}
        <div class="form-card-wrapper">
            <div class="form-section-header">
                <div class="form-section-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <i class="fa-solid fa-circle-user"></i>
                </div>
                <div>
                    <div class="form-section-title">{{ __('Account & Photo') }}</div>
                    <div class="form-section-subtitle">{{ __('Account credentials and profile photo') }}</div>
                </div>
            </div>
            <div class="row g-3 align-items-center">
                <div class="col-lg-4 col-md-6">
                    <label class="form-label" for="email">{{ __('Email Address') }}</label>
                    <div class="input-icon-wrapper">
                        <input type="email" name="email" class="form-control edu-input" id="email"
                               placeholder="student@example.com"
                               value="{{ old('email', $student->user?->email) }}">
                        <i class="fa-solid fa-check field-icon {{ old('email', $student->user?->email) ? 'valid' : '' }}"></i>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="form-label" for="photo">{{ __('Upload Photo') }}</label>
                    <input type="file" class="form-control edu-input" id="photo" name="photo" accept="image/*" style="padding:7px 14px !important;">
                    <div class="mt-1" style="font-size:11px;color:#94a3b8;">
                        <i class="fa-solid fa-circle-info me-1"></i>JPG, PNG — max 2MB. Leave empty to keep current.
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 text-center">
                    <label class="form-label d-block">{{ __('Current Photo') }}</label>
                    <img id="photoPreview"
                         src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"
                         alt="Student Photo" class="avatar-preview-ring">
                </div>
            </div>
        </div>

        {{-- Submit Row --}}
        <div class="d-flex align-items-center justify-content-between gap-3 pb-4">
            <a href="{{ route('students.index', ['tenant' => $tenant]) }}" class="btn-cancel">
                <i class="fa-solid fa-xmark" style="font-size:12px;"></i> {{ __('Cancel') }}
            </a>
            <button type="submit" class="btn-save">
                <span style="width:24px;height:24px;background:rgba(255,255,255,0.2);border-radius:7px;display:inline-flex;align-items:center;justify-content:center;">
                    <i class="fa-regular fa-floppy-disk" style="font-size:12px;"></i>
                </span>
                {{ __('Update Student') }}
            </button>
        </div>
    </form>
</div>
@endsection

@section('customJs')
<script>
$(document).ready(function() {

    /* Category â†’ Group AJAX */
    $('#school_category_id').on('change', function() {
        var categoryId = $(this).val();
        var subCatDropdown = $('#school_sub_category_id');
        subCatDropdown.empty().append('<option value="">Select Group</option>');
        if (categoryId) {
            $.ajax({
                url: "{{ route('get.subcategories', ['tenant' => $tenant, 'categoryId' => ':id']) }}".replace(':id', categoryId),
                type: "GET", dataType: "json",
                success: function(data) {
                    $.each(data, function(k, v) {
                        subCatDropdown.append('<option value="' + v.id + '">' + v.name + '</option>');
                    });
                }
            });
        }
    });

    /* Photo preview syncs to hero & card */
    $('#photo').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#photoPreview, #heroAvatarPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    /* NID: 10 or 17 digits */
    function validateNID(input, iconId, errorId) {
        const val = input.val().trim();
        const icon = $('#' + iconId), err = $('#' + errorId);
        if (!val) { input.removeClass('is-valid is-invalid'); icon.removeClass('valid invalid').hide(); err.hide(); return; }
        const ok = /^\d{10}$|^\d{17}$/.test(val);
        if (ok) {
            input.removeClass('is-invalid').addClass('is-valid');
            icon.removeClass('invalid fa-xmark').addClass('valid fa-check').show(); err.hide();
        } else {
            input.removeClass('is-valid').addClass('is-invalid');
            icon.removeClass('valid fa-check').addClass('invalid fa-xmark').show();
            err.text('NID must be exactly 10 or 17 digits').show();
        }
    }

    /* Birth NID: exactly 17 digits */
    function validateBirthNID(input, iconId, errorId) {
        const val = input.val().trim();
        const icon = $('#' + iconId), err = $('#' + errorId);
        if (!val) { input.removeClass('is-valid is-invalid'); icon.removeClass('valid invalid').hide(); err.hide(); return; }
        const ok = /^\d{17}$/.test(val);
        if (ok) {
            input.removeClass('is-invalid').addClass('is-valid');
            icon.removeClass('invalid fa-xmark').addClass('valid fa-check').show(); err.hide();
        } else {
            input.removeClass('is-valid').addClass('is-invalid');
            icon.removeClass('valid fa-check').addClass('invalid fa-xmark').show();
            err.text('Birth registration must be exactly 17 digits').show();
        }
    }

    /* Phone: 11 digits, starts with 01[3-9] */
    function validatePhone(input, iconId, errorId) {
        const val = input.val().trim();
        const icon = $('#' + iconId), err = $('#' + errorId);
        if (val.length > 11) input.val(val.slice(0,11));
        if (!val) { input.removeClass('is-valid is-invalid'); icon.removeClass('valid invalid').hide(); err.hide(); return; }
        const ok = /^01[3-9]\d{8}$/.test(val);
        if (ok) {
            input.removeClass('is-invalid').addClass('is-valid');
            icon.removeClass('invalid fa-xmark').addClass('valid fa-check').show(); err.hide();
        } else if (val.length === 11) {
            input.removeClass('is-valid').addClass('is-invalid');
            icon.removeClass('valid fa-check').addClass('invalid fa-xmark').show();
            err.text('Invalid BD phone number (e.g. 01712345678)').show();
        } else {
            input.removeClass('is-valid is-invalid'); icon.removeClass('valid invalid').hide(); err.hide();
        }
    }

    $('#father_nid').on('input', function() { validateNID($(this), 'father_nid_icon', 'father_nid_error'); });
    $('#mother_nid').on('input', function() { validateNID($(this), 'mother_nid_icon', 'mother_nid_error'); });
    $('#student_birth_nid').on('input', function() { validateBirthNID($(this), 'birth_nid_icon', 'birth_nid_error'); });
    $('#contact_number').on('input', function() { validatePhone($(this), 'phone_icon', 'phone_error'); });

    /* Run on page load for existing values */
    if ($('#father_nid').val())        validateNID($('#father_nid'), 'father_nid_icon', 'father_nid_error');
    if ($('#mother_nid').val())        validateNID($('#mother_nid'), 'mother_nid_icon', 'mother_nid_error');
    if ($('#student_birth_nid').val()) validateBirthNID($('#student_birth_nid'), 'birth_nid_icon', 'birth_nid_error');
    if ($('#contact_number').val())    validatePhone($('#contact_number'), 'phone_icon', 'phone_error');

    @if(session('success'))
    Swal.fire({
        icon: '{{ session('type', 'success') }}',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif
});
</script>
@endsection
