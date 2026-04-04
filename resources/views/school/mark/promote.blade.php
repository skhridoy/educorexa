@extends($layout)

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <h4 class="card-title mb-0">Student Promotion (শিক্ষার্থী উত্তীর্ণকরণ)</h4>
                    </div>

                    {{-- সাকসেস বা এরর মেসেজ দেখানোর জন্য --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>অভিনন্দন!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>দুঃখিত!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="alert alert-fill-warning mb-4">
                        <i data-feather="alert-triangle" class="icon-md me-2"></i>
                        <strong>সাবধান:</strong> প্রমোশন বাটনে ক্লিক করলে শিক্ষার্থীদের ক্লাস, নতুন আইডি এবং মেধাক্রম অনুযায়ী রোল নম্বর নতুন সেশনের জন্য আপডেট হয়ে যাবে। এবং পূর্বের রেকর্ড <strong>Student Sessions</strong> টেবিলে সংরক্ষিত হবে।
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
</div>
@endsection