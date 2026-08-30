@extends('layouts.school')

@php
    $tenant = auth()->user()?->school?->slug ?? (app()->bound('currentSchool') ? app('currentSchool')->slug : request()->route('tenant'));
@endphp

@section('customCSS')
<style>
    /* Hero Banner */
    .routine-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
        border-radius: 20px;
        padding: 26px 30px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(15,23,42,0.18);
    }
    .routine-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        background: rgba(79,70,229,0.12);
        border-radius: 50%;
    }
    .routine-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: -40px;
        width: 160px; height: 160px;
        background: rgba(99,102,241,0.08);
        border-radius: 50%;
    }
    .routine-hero-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 6px 0;
    }
    .routine-hero-subtitle {
        font-size: 0.88rem;
        color: rgba(255,255,255,0.7);
        margin: 0;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        color: #a5b4fc;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        backdrop-filter: blur(8px);
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 18px;
        padding: 22px 26px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(15,23,42,0.05);
    }
    .filter-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .filter-card .form-select,
    .filter-card .form-control {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 9px 13px;
        font-size: 0.88rem;
        font-weight: 500;
        background: #f8fafc;
        transition: all 0.2s;
    }
    .filter-card .form-select:focus,
    .filter-card .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        background: #fff;
    }

    /* Routine Table Card */
    .routine-box {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(15,23,42,0.05);
        margin-bottom: 24px;
    }
    .routine-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        border-bottom: 2px solid #e2e8f0;
    }
    .routine-table tbody td {
        padding: 10px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .routine-table tbody tr:hover {
        background: #fafcff;
    }

    /* Class pill quick switcher */
    .class-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .class-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .class-pill.active {
        background: #4f46e5;
        color: #ffffff;
        border-color: #4f46e5;
        box-shadow: 0 4px 12px rgba(79,70,229,0.25);
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- ══ HERO BANNER ══ --}}
        <div class="routine-hero mb-4">
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 position-relative" style="z-index: 2;">
                <div>
                    <h1 class="routine-hero-title">
                        <i class="fa-solid fa-calendar-days me-2 text-indigo-400"></i>{{ __('Exam Routine Management') }}
                    </h1>
                    <p class="routine-hero-subtitle">
                        {{ __('Create subject & exam schedules class-wise by selecting academic year, category & class') }}
                    </p>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @if($selectedYear)
                            <span class="hero-badge"><i class="fa-solid fa-calendar-check"></i> সাল: {{ $selectedYear->name }}</span>
                        @endif
                        @if($selectedCategory)
                            <span class="hero-badge" style="color: #fcd34d;"><i class="fa-solid fa-layer-group"></i> ক্যাটেগরি: {{ $selectedCategory->name }}</span>
                        @endif
                        @if($selectedExam)
                            <span class="hero-badge" style="color: #86efac;"><i class="fa-solid fa-file-pen"></i> পরীক্ষা: {{ $selectedExam->name }}</span>
                        @endif
                        @if($selectedClass)
                            <span class="hero-badge" style="color: #67e8f9;"><i class="fa-solid fa-chalkboard-user"></i> শ্রেণি: {{ $selectedClass->name }}</span>
                        @endif
                    </div>
                </div>
                @if($selectedExam && $selectedClass)
                    <div class="d-flex gap-2 align-items-center">
                        <a href="{{ route('exam.bulk_admit_card', ['tenant' => $tenant, 'exam_id' => $selectedExam->id, 'class_id' => $selectedClass->id]) }}" 
                           target="_blank" class="btn btn-sm btn-light fw-bold" style="border-radius: 10px; padding: 8px 16px;">
                            <i class="fa-solid fa-id-card me-1 text-primary"></i> {{ __('View Admit Card') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-check fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-exclamation fs-5 me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ══ FILTER CARD ══ --}}
        <div class="filter-card mb-4">
            <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-sliders text-indigo-600"></i> {{ __('Routine Filter') }}
            </h6>
            <form action="{{ request()->url() }}" method="GET" id="filter-form">
                <div class="row g-3 align-items-end">
                    {{-- Academic Year --}}
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="filter-label"><i class="fa-solid fa-calendar-days me-1 text-primary"></i> {{ __('Academic Year') }} <span class="text-danger">*</span></label>
                        <select name="academic_year_id" class="form-select" id="year-select" required>
                            <option value="">{{ __('-- Select Year --') }}</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="filter-label"><i class="fa-solid fa-layer-group me-1 text-info"></i> {{ __('School Category') }}</label>
                        <select name="school_category_id" class="form-select" id="category-select">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $selectedCategoryId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Exam Name --}}
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="filter-label"><i class="fa-solid fa-file-pen me-1 text-warning"></i> {{ __('Exam Name') }} <span class="text-danger">*</span></label>
                        <select name="exam_id" class="form-select" id="exam-select" required>
                            <option value="">{{ __('-- Select Exam --') }}</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ $selectedExamId == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }} {{ $exam->category ? '('.$exam->category->name.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Class --}}
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="filter-label"><i class="fa-solid fa-chalkboard me-1 text-success"></i> {{ __('Class') }} <span class="text-danger">*</span></label>
                        <select name="class_id" class="form-select" id="class-select" required>
                            <option value="">{{ __('-- Select Class --') }}</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 10px; padding: 10px 24px;">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> {{ __('Filter') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ══ CLASS ROUTINE QUICK SWITCHER & STATUS (If Exam is Selected) ══ --}}
        @if($selectedExam && $classes->count() > 0)
            <div class="card mb-4 border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <span class="fw-bold text-muted" style="font-size: 0.82rem;">
                            <i class="fa-solid fa-list-check me-1 text-primary"></i> 
                            {{ $selectedExam->name }}-এর শ্রেণিভিত্তিক রুটিন স্ট্যাটাস:
                        </span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($classes as $cls)
                            @php
                                $hasRtn = isset($classRoutinesStatus[$cls->id]) && $classRoutinesStatus[$cls->id]->count() > 0;
                                $count = $hasRtn ? $classRoutinesStatus[$cls->id]->count() : 0;
                                $isActiveClass = $selectedClassId == $cls->id;
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['class_id' => $cls->id]) }}" 
                               class="class-pill {{ $isActiveClass ? 'active' : '' }}">
                                <span>{{ $cls->name }}</span>
                                @if($hasRtn)
                                    <span class="badge {{ $isActiveClass ? 'bg-light text-dark' : 'bg-success text-white' }}" style="font-size: 0.7rem; border-radius: 6px;">
                                        {{ $count }} বিষয়
                                    </span>
                                @else
                                    <span class="badge {{ $isActiveClass ? 'bg-light text-muted' : 'bg-secondary bg-opacity-25 text-secondary' }}" style="font-size: 0.7rem; border-radius: 6px;">
                                        নাই
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- ══ ROUTINE ENTRY FORM ══ --}}
        @if($selectedExam && $selectedClass)
            <div class="routine-box">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-3 mb-3 border-bottom">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">
                            <i class="fa-solid fa-calendar-plus text-primary me-2"></i>
                            {{ $selectedClass->name }} — {{ $selectedExam->name }}
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.83rem;">
                            নিচে বিষয় নির্বাচন করে পরীক্ষার তারিখ এবং সময় (ঐচ্ছিক) নির্ধারণ করুন।
                        </p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        {{-- Add Row Button --}}
                        <button type="button" id="add-row-btn" class="btn btn-outline-primary fw-semibold btn-sm" style="border-radius: 8px; padding: 7px 14px;">
                            <i class="fa-solid fa-plus me-1"></i> নতুন বিষয় যোগ করুন
                        </button>

                        {{-- Bulk Delete Button (if routines exist) --}}
                        @if($routines->count() > 0)
                            <form action="{{ route('exam.routine.destroyAll', ['tenant' => $tenant]) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই শ্রেণির সম্পূর্ণ পরীক্ষার রুটিন মুছে ফেলতে চান?');">
                                @csrf
                                <input type="hidden" name="academic_year_id" value="{{ $selectedYearId }}">
                                <input type="hidden" name="school_category_id" value="{{ $selectedCategoryId }}">
                                <input type="hidden" name="exam_id" value="{{ $selectedExam->id }}">
                                <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">
                                <button type="submit" class="btn btn-outline-danger fw-semibold btn-sm" style="border-radius: 8px; padding: 7px 14px;">
                                    <i class="fa-solid fa-trash me-1"></i> সম্পূর্ণ রুটিন মুছুন
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Routine Form --}}
                <form action="{{ route('exam.routine.store', ['tenant' => $tenant]) }}" method="POST" id="routine-form">
                    @csrf
                    <input type="hidden" name="academic_year_id" value="{{ $selectedYearId }}">
                    <input type="hidden" name="school_category_id" value="{{ $selectedCategoryId }}">
                    <input type="hidden" name="exam_id" value="{{ $selectedExam->id }}">
                    <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">

                    <div class="table-responsive">
                        <table class="table routine-table mb-4">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th style="min-width: 220px;">{{ __('Subject') }} <span class="text-danger">*</span></th>
                                    <th style="min-width: 170px;">{{ __('Exam Date') }} <span class="text-danger">*</span></th>
                                    <th style="min-width: 130px;">{{ __('Start Date') }}</th>
                                    <th style="min-width: 130px;">{{ __('End Date') }}</th>
                                    <th style="width: 70px; text-align: center;">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="routine-rows">
                                @if($routines->count() > 0)
                                    @foreach($routines as $index => $routine)
                                        <tr class="routine-row">
                                            <td class="row-num text-muted fw-bold">{{ $index + 1 }}</td>
                                            <td>
                                                <select name="routines[{{ $index }}][subject_id]" class="form-select form-select-sm subject-select" required>
                                                    <option value="">-- বিষয় নির্বাচন করুন --</option>
                                                    @foreach($classSubjects as $subject)
                                                        <option value="{{ $subject->id }}" {{ $routine->subject_id == $subject->id ? 'selected' : '' }}>
                                                            {{ $subject->name }} {{ $subject->subCategory ? '[' . $subject->subCategory->name . ']' : '' }} {{ $subject->code ? '('.$subject->code.')' : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" name="routines[{{ $index }}][exam_date]" class="form-control form-control-sm" value="{{ $routine->exam_date }}" required>
                                            </td>
                                            <td>
                                                <input type="time" name="routines[{{ $index }}][start_time]" class="form-control form-control-sm" value="{{ $routine->start_time }}">
                                            </td>
                                            <td>
                                                <input type="time" name="routines[{{ $index }}][end_time]" class="form-control form-control-sm" value="{{ $routine->end_time }}">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="সারি মুছুন" style="border-radius: 6px; padding: 4px 8px;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    {{-- If no routine exists, pre-fill rows for each class subject --}}
                                    @forelse($classSubjects as $index => $subject)
                                        <tr class="routine-row">
                                            <td class="row-num text-muted fw-bold">{{ $index + 1 }}</td>
                                            <td>
                                                <select name="routines[{{ $index }}][subject_id]" class="form-select form-select-sm subject-select" required>
                                                    <option value="">-- বিষয় নির্বাচন করুন --</option>
                                                     @foreach($classSubjects as $sub)
                                                         <option value="{{ $sub->id }}" {{ $sub->id == $subject->id ? 'selected' : '' }}>
                                                             {{ $sub->name }} {{ $sub->subCategory ? '[' . $sub->subCategory->name . ']' : '' }} {{ $sub->code ? '('.$sub->code.')' : '' }}
                                                         </option>
                                                     @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" name="routines[{{ $index }}][exam_date]" class="form-control form-control-sm" required>
                                            </td>
                                            <td>
                                                <input type="time" name="routines[{{ $index }}][start_time]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="time" name="routines[{{ $index }}][end_time]" class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="সারি মুছুন" style="border-radius: 6px; padding: 4px 8px;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="routine-row">
                                            <td class="row-num text-muted fw-bold">1</td>
                                            <td>
                                                <select name="routines[0][subject_id]" class="form-select form-select-sm subject-select" required>
                                                    <option value="">-- বিষয় নির্বাচন করুন --</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" name="routines[0][exam_date]" class="form-control form-control-sm" required>
                                            </td>
                                            <td>
                                                <input type="time" name="routines[0][start_time]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="time" name="routines[0][end_time]" class="form-control form-control-sm">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="সারি মুছুন" style="border-radius: 6px; padding: 4px 8px;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2">
                        <small class="text-muted"><i class="fa-solid fa-info-circle me-1"></i> সংরক্ষণ করার পর পূর্বের রুটিন স্বয়ংক্রিয়ভাবে আপডেট হয়ে যাবে।</small>
                        <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 10px; padding: 10px 28px;">
                            <i class="fa-solid fa-floppy-disk me-2"></i> {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>
        @else
            {{-- Empty State / Helper --}}
            <div class="card text-center py-5 border-0 shadow-sm" style="border-radius: 18px; background: #ffffff;">
                <div class="card-body py-4">
                    <div style="width: 70px; height: 70px; border-radius: 20px; background: #eef2ff; color: #4f46e5; display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 16px;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">রুটিন সেট আপ করতে ফিল্টার নির্বাচন করুন</h5>
                    <p class="text-muted mx-auto" style="max-width: 480px; font-size: 0.88rem;">
                        উপরের ফিল্টার থেকে শিক্ষাবর্ষ, পরীক্ষার নাম এবং শ্রেণি নির্বাচন করে "রুটিন লোড করুন" বাটনে ক্লিক করুন।
                    </p>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

@section('customJs')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('year-select');
    const categorySelect = document.getElementById('category-select');
    const examSelect = document.getElementById('exam-select');
    const classSelect = document.getElementById('class-select');
    const tbody = document.getElementById('routine-rows');
    const addRowBtn = document.getElementById('add-row-btn');

    let currentClassSubjects = @json($classSubjects ?? []);
    let rowIndex = {{ max($routines->count(), $classSubjects->count(), 1) }};

    // Dynamic Filter Data update on Category/Year change
    function updateFilterDropdowns() {
        const yearId = yearSelect ? yearSelect.value : '';
        const catId = categorySelect ? categorySelect.value : '';

        fetch(`{{ url('exam-routine/filter-data') }}?academic_year_id=${yearId}&school_category_id=${catId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    // Update Exam Dropdown
                    if (examSelect) {
                        const currentExam = examSelect.value;
                        let examOptions = '<option value="">-- পরীক্ষা নির্বাচন করুন --</option>';
                        data.exams.forEach(ex => {
                            examOptions += `<option value="${ex.id}" ${currentExam == ex.id ? 'selected' : ''}>${ex.name}</option>`;
                        });
                        examSelect.innerHTML = examOptions;
                    }

                    // Update Class Dropdown
                    if (classSelect) {
                        const currentClass = classSelect.value;
                        let classOptions = '<option value="">-- শ্রেণি নির্বাচন করুন --</option>';
                        data.classes.forEach(c => {
                            classOptions += `<option value="${c.id}" ${currentClass == c.id ? 'selected' : ''}>${c.name}</option>`;
                        });
                        classSelect.innerHTML = classOptions;
                    }
                }
            })
            .catch(err => console.error('Filter load error:', err));
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', updateFilterDropdowns);
    }
    if (yearSelect) {
        yearSelect.addEventListener('change', updateFilterDropdowns);
    }

    // Load subjects for selected class dynamically if changed inside page
    function loadSubjectsForClass(classId) {
        if (!classId) {
            currentClassSubjects = [];
            return;
        }
        fetch(`{{ url('exam-routine/subjects-by-class') }}/${classId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status && data.subjects) {
                    currentClassSubjects = data.subjects;
                    updateAllSubjectSelects();
                }
            })
            .catch(err => console.error('Subject load error:', err));
    }

    function buildSubjectOptions(selectedId) {
        let opts = '<option value="">-- বিষয় নির্বাচন করুন --</option>';
        currentClassSubjects.forEach(s => {
            const isSel = (selectedId && selectedId == s.id) ? 'selected' : '';
            const subCatBadge = s.sub_category_name ? ` [${s.sub_category_name}]` : '';
            opts += `<option value="${s.id}" ${isSel}>${s.name}${subCatBadge}${s.code ? ' ('+s.code+')' : ''}</option>`;
        });
        return opts;
    }

    function updateAllSubjectSelects() {
        if (!tbody) return;
        document.querySelectorAll('.subject-select').forEach(select => {
            const val = select.value;
            select.innerHTML = buildSubjectOptions(val);
        });
    }

    // Add Row Handler
    if (addRowBtn && tbody) {
        addRowBtn.addEventListener('click', function () {
            const tr = document.createElement('tr');
            tr.className = 'routine-row';
            tr.innerHTML = `
                <td class="row-num text-muted fw-bold">${tbody.children.length + 1}</td>
                <td>
                    <select name="routines[${rowIndex}][subject_id]" class="form-select form-select-sm subject-select" required>
                        ${buildSubjectOptions('')}
                    </select>
                </td>
                <td>
                    <input type="date" name="routines[${rowIndex}][exam_date]" class="form-control form-control-sm" required>
                </td>
                <td>
                    <input type="time" name="routines[${rowIndex}][start_time]" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="time" name="routines[${rowIndex}][end_time]" class="form-control form-control-sm">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="সারি মুছুন" style="border-radius: 6px; padding: 4px 8px;">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            rowIndex++;
            renumberRows();
        });
    }

    // Remove Row Handler
    if (tbody) {
        tbody.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-row');
            if (btn) {
                const row = btn.closest('.routine-row');
                row.remove();
                renumberRows();
            }
        });
    }

    function renumberRows() {
        if (!tbody) return;
        tbody.querySelectorAll('.routine-row').forEach((row, i) => {
            const numCell = row.querySelector('.row-num');
            if (numCell) numCell.textContent = i + 1;
        });
    }
});
</script>
@endsection
