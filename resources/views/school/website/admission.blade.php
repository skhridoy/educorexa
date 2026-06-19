@extends('school.website.layouts.app')

@section('customCSS')
<style>
    .school-logo {
            height: 50px;
            width: auto;
        }
        .school-name {
            font-size: 1.75rem;
            font-weight: 700;
            white-space: normal; 
            line-height: 1.2;
        }
    /* প্রিভিউ ইমেজ ডিজাইন */
    .preview-container {
        position: relative;
        margin-top: 15px;
    }
    #photoPreview {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid #f0f0f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: none;
    }
    /* কার্ডের টাইটেল ও সাবটাইটেল */
    .admission-card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        border-radius: 15px;
    }
    .section-divider {
        border-left: 3px solid #6571ff;
        padding-left: 15px;
        margin-bottom: 25px;
        font-weight: 700;
        color: #000;
    }
    .form-label {
        font-weight: 500;
        font-size: 0.9rem;
        color: #444;
    }
    .btn-submit {
        background-color: #6571ff;
        border-color: #6571ff;
        padding: 10px 40px;
        font-weight: 600;
    }

    @media (max-width: 991.98px) {
            .school-name {
                font-size: 1.1rem; /* মোবাইলে নাম ছোট দেখাবে */
                max-width: 200px;  /* টেক্সট র‍্যাপ করার জন্য একটি নির্দিষ্ট উইডথ */
            }
        .school-logo {
                height: 40px; /* মোবাইলে লোগো সামান্য ছোট */
            }
        }

        /* আরও ছোট স্ক্রিন (যেমন: iPhone SE বা ছোট ফোন) */
        @media (max-width: 575.98px) {
            .school-name {
                font-size: 0.95rem;
                max-width: 150px;
            }
        }
</style>
@endsection

@section('content')

    {{-- এটিই সেই হিরো হেডার যা নেভবারের নিচে কালার বা ইমেজ দেয় --}}
    <div class="container-xxl bg-primary hero-header">
        <div class="container py-5"> {{-- py-5 যোগ করা হয়েছে যাতে অ্যাডমিশন ফর্ম নিচে নামে --}}
            <div class="row g-5 align-items-center">
                <div class="text-center">
                    <h2 class="display-6 fw-bold text-dark">{{ app('currentSchool')->name ?? 'School Name' }}</h2>
                    <p class="text-muted fs-5">Online Admission Session: {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card admission-card">
                <div class="card-body p-4 p-md-5">
                    <h4 class="mb-1">Student Admission Form</h4>
                    <p class="text-muted mb-4 small">Please fill in the official details for the new student enrollment.</p>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <a href="{{ route('admissions.pdf', ['tenant' => app('currentSchool')->slug, 'id' => session('admission_id')]) }}" class="btn btn-sm btn-outline-primary ms-2" target="_blank">Download PDF</a>
                        </div>
                    @endif

<div class="mb-4">
    <h5 class="mb-2">ডাউনলোড পূর্বের অ্যাডমিশন PDF</h5>
    <div class="input-group">
        <input type="number" id="searchAdmissionId" class="form-control" placeholder="Admission ID" />
        <button type="button" class="btn btn-outline-primary" id="downloadAdmissionBtn">ডাউনলোড</button>
    </div>
</div>

<form action="{{ route('admission.store', ['tenant' => app('currentSchool')->slug]) }}" method="POST" enctype="multipart/form-data">

                    
                        @csrf
                        
                        <div class="row">
                            {{-- কলাম ১: বেসিক ইনফরমেশন --}}
                            <div class="col-md-6 border-end-md">
                                <h6 class="section-divider">Student Information</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label">Student Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter full name">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Applying for Class <span class="text-danger">*</span></label>
                                    <select name="class_id" class="form-select @error('class_id') is-invalid @enderror">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Section <span class="text-danger">*</span></label>
                                    <select name="section_id" class="form-select >
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                                {{ $section->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('section_id') 
                                        <div class="invalid-feedback">{{ $message }}</div> 
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="tel" 
                                        name="contact_number" 
                                        maxlength="11"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                                        class="form-control @error('contact_number') is-invalid @enderror" 
                                        value="{{ old('contact_number') }}" 
                                        placeholder="01XXXXXXXXX" 
                                        required>
                                    
                                    @error('contact_number') 
                                        <div class="invalid-feedback">{{ $message }}</div> 
                                    @enderror
                                    <small class="text-muted">অবশ্যই ১১ ডিজিটের নম্বর দিন (যেমন: 01712345678)</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Student Photo</label>
                                    <input type="file" name="photo" id="photoInput" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                    <div class="preview-container text-center">
                                        <img id="photoPreview" src="#" alt="Preview">
                                    </div>
                                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- কলাম ২: প্যারেন্টস এবং সিকিউরিটি --}}
                            <div class="col-md-6 ps-md-4">
                                <h6 class="section-divider">Guardian & Security</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label">Father's Name <span class="text-danger">*</span></label>
                                    <input type="text" name="fathers_name" class="form-control @error('fathers_name') is-invalid @enderror" value="{{ old('fathers_name') }}" placeholder="Father's name">
                                    @error('fathers_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mother's Name <span class="text-danger">*</span></label>
                                    <input type="text" name="mothers_name" class="form-control @error('mothers_name') is-invalid @enderror" value="{{ old('mothers_name') }}" placeholder="Mother's name">
                                    @error('mothers_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@example.com">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light px-4">Reset Form</button>
                            <button type="submit" class="btn btn-primary btn-submit">Submit Admission</button>
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
    document.querySelector('input[name="contact_number"]').addEventListener('blur', function (e) {
        const pattern = /^(01)[3-9]{1}[0-9]{8}$/;
        const value = e.target.value;
        
        if (value.length > 0 && (!pattern.test(value) || value.length !== 11)) {
            alert("সঠিক বাংলাদেশি মোবাইল নম্বর দিন (১১ ডিজিট হতে হবে)");
            e.target.classList.add('is-invalid');
        } else {
            e.target.classList.remove('is-invalid');
        }
    });
    // আধুনিক ইমেজ প্রিভিউ লজিক
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photoPreview');
                preview.src = e.target.result;
                preview.style.display = 'inline-block';
            }
            reader.readAsDataURL(file);
        }
    });
    // পূর্বের অ্যাডমিশন PDF ডাউনলোড হ্যান্ডলার
    document.getElementById('downloadAdmissionBtn').addEventListener('click', function () {
        const admissionId = document.getElementById('searchAdmissionId').value.trim();
        if (!admissionId) {
            alert('অনুগ্রহ করে অ্যাডমিশন আইডি দিন');
            return;
        }
        // Build URL using Laravel route helper with placeholder
        const baseUrl = "{{ route('admissions.pdf', ['tenant' => app('currentSchool')->slug, 'id' => ':id']) }}";
        const url = baseUrl.replace(':id', admissionId);
        window.open(url, '_blank');
    });
</script>
@endsection