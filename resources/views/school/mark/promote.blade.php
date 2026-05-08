@extends($layout)

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .promotion-warning {
            background: linear-gradient(45deg, #fffbeb 0%, #fff7ed 100%);
            border-left: 5px solid #ef4444;
            border-right: 1px solid #fde68a;
            border-top: 1px solid #fde68a;
            border-bottom: 1px solid #fde68a;
            color: #991b1b;
            padding: 1.25rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.08);
            position: relative;
            overflow: hidden;
        }
        .promotion-warning::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 5px;
            background: #ef4444;
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        .warning-icon-box {
            width: 45px;
            height: 45px;
            background: #fef2f2;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            font-size: 1.5rem;
            margin-right: 15px;
            flex-shrink: 0;
            border: 1px solid #fee2e2;
        }
        .warning-text strong {
            color: #b91c1c;
            display: block;
            margin-bottom: 2px;
            font-size: 1.1rem;
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
                    <div class="header-icon-box" style="background: #fefce8; color: #a16207;">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h1 class="page-title">Student Promotion</h1>
                        <p class="page-subtitle">শিক্ষার্থী উত্তীর্ণকরণ প্রক্রিয়া</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-body p-4">
                {{-- সাকসেস বা এরর মেসেজ দেখানোর জন্য --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        <strong><i class="fa-solid fa-circle-check me-2"></i>অভিনন্দন!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                        <strong><i class="fa-solid fa-circle-xmark me-2"></i>দুঃখিত!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="promotion-warning mb-4">
                    <div class="warning-icon-box">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="warning-text">
                        <strong>সাবধান / Caution:</strong> 
                        প্রমোশন বাটনে ক্লিক করলে শিক্ষার্থীদের ক্লাস, নতুন আইডি এবং মেধাক্রম অনুযায়ী রোল নম্বর নতুন সেশনের জন্য আপডেট হয়ে যাবে। এবং পূর্বের রেকর্ড <strong>Student Sessions</strong> টেবিলে সংরক্ষিত হবে।
                    </div>
                </div>
                    
                    <form action="{{ route('students.promote', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- বর্তমান ক্লাস --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">বর্তমান ক্লাস (From Class)</label>
                                <select name="current_class_id" class="form-select @error('current_class_id') is-invalid @enderror" required>
                                    <option value="">ক্লাস নির্বাচন করুন</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('current_class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('current_class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- ফলাফলের ভিত্তি --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">ফলাফলের ভিত্তি (Exam)</label>
                                <select name="exam_id" class="form-select @error('exam_id') is-invalid @enderror" required>
                                    <option value="">পরীক্ষা নির্বাচন করুন</option>
                                    @foreach($examTypes as $exam)
                                        <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                            {{ $exam->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('exam_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- পরবর্তী ক্লাস --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">পরবর্তী ক্লাস (To Class)</label>
                                <select name="next_class_id" class="form-select @error('next_class_id') is-invalid @enderror" required>
                                    <option value="">পরবর্তী ক্লাস নির্বাচন করুন</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('next_class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('next_class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- পরবর্তী সেশন --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">পরবর্তী সেশন (Next Session)</label>
                                <select name="next_academic_year_id" class="form-select @error('next_academic_year_id') is-invalid @enderror" required>
                                    <option value="">শিক্ষাবর্ষ নির্বাচন করুন</option>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year->id }}" {{ old('next_academic_year_id') == $year->id ? 'selected' : '' }}>
                                            {{ $year->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('next_academic_year_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('আপনি কি নিশ্চিত? এই ছাত্রছাত্রীদের বর্তমান বছরের ডাটা সেভ হবে এবং তারা নতুন ক্লাসে উন্নীত হবে।')">
                                <i class="me-1 icon-md" data-feather="check-circle"></i> প্রমোশন নিশ্চিত করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection