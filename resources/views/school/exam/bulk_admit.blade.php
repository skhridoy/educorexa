@extends('layouts.school')

@php
    $tenant = auth()->user()?->school?->slug ?? (app()->bound('currentSchool') ? app('currentSchool')->slug : request()->route('tenant'));
@endphp

@section('customCSS')
<style>

    .admit-card-preview {
        background: #ffffff;
        border: 1.5px solid #0f172a;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15,23,42,0.08);
    }
    .preview-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 140px;
        opacity: 0.08;
        z-index: 0;
        pointer-events: none;
    }
</style>
@endsection

@php
    $canGenerateAdmitCard = $school ? $school->hasPackagePermission('exam.admit_card') : false;
    $pricingUrl = route('school.pricing', ['tenant' => $tenant]);
@endphp

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- Premium Alert Banner --}}
        @if(!$canGenerateAdmitCard)
            <div class="card border-0 mb-4 shadow-sm" style="border-radius: 16px; background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-left: 4px solid #f59e0b !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; border-radius: 14px; background: linear-gradient(135deg, #d97706, #fbbf24); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">{{ __('প্রিমিয়াম সুবিধা: পরীক্ষার প্রবেশপত্র তৈরি ও PDF ডাউনলোড') }}</h5>
                            <p class="text-muted mb-0 small" style="max-width: 650px;">{{ __('আপনার বর্তমান প্যাকেজে প্রবেশপত্র (Admit Card) তৈরি ও প্রিন্ট করার সুবিধাটি বন্ধ রয়েছে। স্বয়ংক্রিয় রুটিন ও বারকোডযুক্ত প্রবেশপত্র তৈরি করতে অনুগ্রহ করে প্রিমিয়াম প্যাকেজ চালু করুন।') }}</p>
                        </div>
                    </div>
                    <a href="{{ $pricingUrl }}" class="btn btn-warning fw-bold px-4 py-2.5 rounded-pill shadow-sm" style="font-size: 14px;">
                        <i class="fa-solid fa-rocket me-1"></i> {{ __('প্রিমিয়াম প্যাকেজ চালু করুন (Upgrade Plan)') }}
                    </a>
                </div>
            </div>
        @endif

        {{-- Filter Card --}}
        <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-id-card me-2 text-primary"></i>প্রবেশপত্র তৈরি ও ডাউনলোড (Admit Card Generator)
                        @if(!$canGenerateAdmitCard)
                            <span class="badge bg-warning-subtle text-warning fw-bold px-2.5 py-1 rounded-pill ms-2" style="font-size: 11px;">
                                <i class="fa-solid fa-lock me-1"></i>{{ __('Locked') }}
                            </span>
                        @endif
                    </h5>
                    @if(isset($students) && $students->count() > 0)
                        @if($canGenerateAdmitCard)
                            <a href="{{ route('exam.bulk_admit_card', ['tenant' => $tenant, 'class_id' => request('class_id'), 'exam_id' => request('exam_id')]) }}"
                               target="_blank"
                               class="btn btn-success fw-bold"
                               style="border-radius: 10px; padding: 9px 20px;">
                                <i class="fa-solid fa-file-pdf me-2"></i>PDF ডাউনলোড
                            </a>
                        @else
                            <a href="{{ $pricingUrl }}" class="btn btn-warning fw-bold" style="border-radius: 10px; padding: 9px 20px;">
                                <i class="fa-solid fa-crown me-1"></i> প্রিমিয়ামে আপগ্রেড করুন
                            </a>
                        @endif
                    @endif
                </div>

                <form action="{{ request()->url() }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-bold text-muted" style="font-size: 0.8rem;">শ্রেণি (Class)</label>
                            <select name="class_id" class="form-select" required style="border-radius: 10px; padding: 10px;" {{ !$canGenerateAdmitCard ? 'disabled' : '' }}>
                                <option value="">-- শ্রেণি নির্বাচন করুন --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold text-muted" style="font-size: 0.8rem;">পরীক্ষা (Exam)</label>
                            <select name="exam_id" class="form-select" required style="border-radius: 10px; padding: 10px;" {{ !$canGenerateAdmitCard ? 'disabled' : '' }}>
                                <option value="">-- পরীক্ষা নির্বাচন করুন --</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            @if($canGenerateAdmitCard)
                                <button type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 10px; padding: 10px;">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> খুঁজুন
                                </button>
                            @else
                                <a href="{{ $pricingUrl }}" class="btn btn-warning w-100 fw-bold" style="border-radius: 10px; padding: 10px;">
                                    <i class="fa-solid fa-crown me-1"></i> আপগ্রেড
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- নির্দেশনাবলী সেটিংস (প্রবেশপত্রে যেভাবে ছাপা হবে) --}}
        @if($selected_exam)
            <div class="card mb-4 border-0 shadow-sm overflow-hidden" style="border-radius: 18px; background: #ffffff;">
                {{-- Card Header --}}
                <div class="px-4 pt-4 pb-3" style="background: linear-gradient(135deg, #f8faff 0%, #eef2ff 100%); border-bottom: 1px solid #e0e7ff;">
                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #6366f1, #818cf8); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; flex-shrink: 0;">
                                    <i class="fa-solid fa-list-check"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1rem;">প্রবেশপত্রের নির্দেশনাবলী</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.72rem; letter-spacing: 0.3px;">Admit Card Instruction Set</p>
                                </div>
                            </div>
                        </div>
                        <span class="badge fw-semibold px-3 py-2 rounded-pill" style="background: #e0e7ff; color: #4338ca; font-size: 12px; border: 1px solid #c7d2fe;">
                            <i class="fa-solid fa-graduation-cap me-1"></i>{{ $selected_exam->name }}
                        </span>
                    </div>
                    <p class="text-muted mt-2 mb-0" style="font-size: 0.78rem; line-height: 1.6;">
                        <i class="fa-solid fa-circle-info me-1 text-primary" style="font-size: 0.7rem;"></i>
                        প্রতি লাইনে একটি নির্দেশনা লিখুন। নিচে যা লিখবেন, PDF-এ ঠিক সেই ক্রম অনুযায়ী নির্দেশনাবলী ছাপা হবে। খালি রাখলে ডিফল্ট নির্দেশনাবলী ব্যবহৃত হবে।
                    </p>
                </div>

                {{-- Card Body: two-column editor + live preview --}}
                <div class="card-body p-0">
                    <div class="row g-0">

                        {{-- Left: Editor Panel --}}
                        <div class="col-lg-7 p-4 border-end" style="border-color: #e2e8f0 !important;">
                            <form action="{{ route('exam.admit_card_instruction.update', ['tenant' => $tenant]) }}" method="POST" id="instructionForm">
                                @csrf
                                <input type="hidden" name="exam_id" value="{{ $selected_exam->id }}">

                                {{-- Toolbar --}}
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="fw-semibold text-dark mb-0" style="font-size: 0.8rem;">
                                        <i class="fa-solid fa-pen-to-square me-1 text-primary"></i> নির্দেশনা এডিটর
                                    </label>
                                    <span id="lineCounter" class="badge rounded-pill" style="background: #f1f5f9; color: #475569; font-size: 11px; font-weight: 600; border: 1px solid #e2e8f0;">
                                        <i class="fa-solid fa-list-ol me-1"></i><span id="lineCountNum">0</span> লাইন
                                    </span>
                                </div>

                                {{-- Textarea with styled container --}}
                                <div style="border: 1.5px solid #c7d2fe; border-radius: 14px; overflow: hidden; background: #fafbff; box-shadow: inset 0 1px 4px rgba(99,102,241,0.06);">
                                    <div style="padding: 6px 10px 4px; background: #eef2ff; border-bottom: 1px solid #e0e7ff; display: flex; align-items: center; gap: 6px;">
                                        <span style="width: 9px; height: 9px; border-radius: 50%; background: #f87171; display: inline-block;"></span>
                                        <span style="width: 9px; height: 9px; border-radius: 50%; background: #fbbf24; display: inline-block;"></span>
                                        <span style="width: 9px; height: 9px; border-radius: 50%; background: #34d399; display: inline-block;"></span>
                                        <span class="text-muted ms-2" style="font-size: 0.68rem; font-family: monospace;">admit_card_instruction.txt</span>
                                    </div>
                                    <textarea name="admit_card_instruction" id="admitInstructionInput" rows="10"
                                              data-defaults="{{ $defaultInstructionText }}"
                                              placeholder="{{ $defaultInstructionText }}"
                                              style="width: 100%; border: none; outline: none; padding: 14px 16px; font-size: 0.84rem; font-family: 'SolaimanLipi', 'Hind Siliguri', sans-serif; line-height: 1.75; background: transparent; resize: vertical; color: #1e293b;">{{ old('admit_card_instruction', $selected_exam->admit_card_instruction) }}</textarea>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <button type="submit" class="btn fw-bold px-4" style="border-radius: 10px; background: linear-gradient(135deg, #6366f1, #818cf8); color: #fff; border: none; box-shadow: 0 4px 12px rgba(99,102,241,0.3); font-size: 0.85rem;" {{ !$canGenerateAdmitCard ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-floppy-disk me-2"></i>সংরক্ষণ করুন
                                    </button>
                                    <button type="button" class="btn fw-bold px-3" id="loadDefaultInstruction" style="border-radius: 10px; background: #f1f5f9; color: #475569; border: 1.5px solid #e2e8f0; font-size: 0.85rem;">
                                        <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট বসান
                                    </button>
                                    <button type="button" class="btn fw-bold px-3" id="clearInstruction" style="border-radius: 10px; background: #fff1f2; color: #e11d48; border: 1.5px solid #fecdd3; font-size: 0.85rem;">
                                        <i class="fa-solid fa-eraser me-1"></i> মুছুন
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Right: Live Preview Panel --}}
                        <div class="col-lg-5 p-4" style="background: #f8fafc;">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width: 28px; height: 28px; border-radius: 8px; background: linear-gradient(135deg, #10b981, #34d399); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px;">
                                    <i class="fa-solid fa-eye"></i>
                                </div>
                                <span class="fw-semibold text-dark" style="font-size: 0.82rem;">লাইভ প্রিভিউ <span class="badge bg-success-subtle text-success ms-1" style="font-size: 10px; border-radius: 6px;">Live</span></span>
                            </div>

                            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                                <div style="padding: 8px 12px; background: linear-gradient(135deg, #f8faff, #eef2ff); border-bottom: 1px solid #e0e7ff;">
                                    <span style="font-size: 0.7rem; font-weight: 700; color: #4338ca; text-transform: uppercase; letter-spacing: 0.6px;">
                                        <i class="fa-solid fa-list-check me-1"></i> নির্দেশনাবলী (Instructions)
                                    </span>
                                </div>
                                <div style="padding: 10px 14px;">
                                    <ul class="mb-0 ps-3" data-inst-list style="font-size: 0.73rem; line-height: 1.65; list-style-type: disc; color: #1e293b;">
                                        @foreach($instructionLines as $instructionLine)
                                            <li>{{ $instructionLine }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <p class="text-muted mt-2 mb-0" style="font-size: 0.68rem; line-height: 1.5;">
                                <i class="fa-solid fa-wand-magic-sparkles me-1"></i>
                                টেক্সট বক্সে পরিবর্তন করলে এখানে সাথে সাথে দেখা যাবে।
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Preview Section --}}
        @if(isset($students) && $students->count() > 0)
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-eye me-1 text-primary"></i> এডমিট কার্ড প্রিভিউ (মোট {{ $students->count() }} জন শিক্ষার্থী)
                </h6>
                <small class="text-muted"><i class="fa-solid fa-print me-1"></i>A4 পেজে প্রতি পাতায় ২টি করে প্রবেশপত্র প্রিন্ট হবে ও প্রতি কার্ডে নির্দেশনাবলী থাকবে</small>
            </div>

            <div class="row">
                @foreach($students as $student)
                    @php
                        $studentSubCategoryId = $student->school_sub_category_id;
                        $studentReligion = mb_strtolower(trim($student->religion ?? ''));
                        
                        // Filter routines for this specific student:
                        // 1. Group / SubCategory filter
                        // 2. Religion subject filter
                        $studentRoutines = $examRoutines->filter(function($rtn) use ($studentSubCategoryId, $assignClasses, $studentReligion) {
                            $ac = isset($assignClasses) ? $assignClasses->get($rtn->subject_id) : null;
                            $subCatId = $ac ? $ac->school_sub_category_id : $rtn->subject?->school_sub_category_id;

                            // 1. Group / Subcategory check
                            if ($studentSubCategoryId) {
                                if (!empty($subCatId) && $subCatId != $studentSubCategoryId) {
                                    return false;
                                }
                            } else {
                                if (!empty($subCatId)) {
                                    return false;
                                }
                            }

                            // 2. Religion subject check
                            $subName = mb_strtolower(trim($rtn->subject?->name ?? ''));
                            $isIslam = str_contains($subName, 'islam') || str_contains($subName, 'ইসলাম') || str_contains($subName, 'deeniyat') || str_contains($subName, 'দ্বীনিয়াত') || str_contains($subName, 'কোরআন') || str_contains($subName, 'কুরআন');
                            $isHindu = str_contains($subName, 'hindu') || str_contains($subName, 'হিন্দু') || str_contains($subName, 'সনাতন');
                            $isBuddha = str_contains($subName, 'buddh') || str_contains($subName, 'বৌদ্ধ') || str_contains($subName, 'বুদ্ধ');
                            $isChristian = str_contains($subName, 'christ') || str_contains($subName, 'খ্রিস্ট') || str_contains($subName, 'খ্রিষ্ট');

                            if ($isIslam || $isHindu || $isBuddha || $isChristian) {
                                if ($isIslam) {
                                    $matchesIslam = str_contains($studentReligion, 'islam') || str_contains($studentReligion, 'ইসলাম') || str_contains($studentReligion, 'muslim') || str_contains($studentReligion, 'মুসলিম') || empty($studentReligion);
                                    if (!$matchesIslam) {
                                        return false;
                                    }
                                }
                                if ($isHindu) {
                                    $matchesHindu = str_contains($studentReligion, 'hindu') || str_contains($studentReligion, 'হিন্দু') || str_contains($studentReligion, 'সনাতন');
                                    if (!$matchesHindu) {
                                        return false;
                                    }
                                }
                                if ($isBuddha) {
                                    $matchesBuddha = str_contains($studentReligion, 'buddh') || str_contains($studentReligion, 'বৌদ্ধ') || str_contains($studentReligion, 'বুদ্ধ');
                                    if (!$matchesBuddha) {
                                        return false;
                                    }
                                }
                                if ($isChristian) {
                                    $matchesChristian = str_contains($studentReligion, 'christ') || str_contains($studentReligion, 'খ্রিস্ট') || str_contains($studentReligion, 'খ্রিষ্ট');
                                    if (!$matchesChristian) {
                                        return false;
                                    }
                                }
                            }

                            return true;
                        });

                        if ($studentRoutines->isEmpty()) {
                            $studentRoutines = $examRoutines;
                        }

                        $totalRoutines = $studentRoutines->count();
                        $half = ceil($totalRoutines / 2);
                        $colA = $studentRoutines->slice(0, $half);
                        $colB = $studentRoutines->slice($half);
                    @endphp

                    <div class="col-lg-6 mb-4">
                        <div class="admit-card-preview p-3">
                            {{-- Watermark --}}
                            @if($schoolLogo)
                                <img src="{{ asset($schoolLogo) }}" class="preview-watermark">
                            @endif

                            <div style="position: relative; z-index: 1;">
                                {{-- 1. Header (Logo left, Info center, QR right) --}}
                                <table class="table table-borderless mb-2 pb-2 border-bottom" style="background: transparent;">
                                    <tr>
                                        {{-- Logo Left --}}
                                        <td style="width: 55px; vertical-align: middle; padding: 0;">
                                             @if($schoolLogo)
                                                <img src="{{ asset($schoolLogo) }}" style="width: 48px; height: 48px; object-fit: contain;">
                                            @else
                                                <div style="width:48px; height:48px; border:1px solid #cbd5e1; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:9px; color:#94a3b8;">LOGO</div>
                                            @endif
                                        </td>
                                        {{-- Center Info --}}
                                        <td class="text-center" style="vertical-align: middle; padding: 0 8px;">
                                            @php
                                                $sch = $school ?? (app()->bound('currentSchool') ? app('currentSchool') : (auth()->user()?->school ?? null));
                                                $schoolName = $sch?->name ?? 'SCHOOL NAME';
                                                $schoolCode = $sch?->app_code ?? $sch?->emis_code ?? $sch?->ein_number ?? null;
                                            @endphp
                                            <h6 class="fw-bold mb-1 text-uppercase" style="font-size: 0.95rem; color: #0f172a; white-space: nowrap;">{{ $schoolName }}</h6>
                                            @if($schoolCode)
                                                <div class="text-secondary fw-semibold mb-1" style="font-size: 0.72rem;">School Code: {{ $schoolCode }}</div>
                                            @endif
                                            <div class="fw-bold my-1" style="font-size: 0.82rem; color: #1e3a8a;">{{ $selected_exam?->name }} &mdash; {{ date('Y') }}</div>
                                            <div>
                                                <span class="badge bg-dark px-2 py-1" style="font-size: 0.65rem; letter-spacing: 1px;">প্রবেশপত্র / ADMIT CARD</span>
                                            </div>
                                        </td>
                                        {{-- QR Code Right --}}
                                        <td style="width: 55px; vertical-align: middle; text-align: right; padding: 0;">
                                             <div style="display: inline-block; padding: 2px; background: #fff; border: 1px solid #cbd5e1; border-radius: 4px;">
                                                @php
                                                    $previewQr = null;
                                                    try {
                                                        $grp = $student->group->name ?? '';
                                                        $previewQr = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(46)->color(15, 23, 42)->generate("ID: {$student->student_id}\nName: {$student->name}\nRoll: {$student->roll}" . ($grp ? "\nGroup: {$grp}" : ''));
                                                    } catch (\Throwable $e) {
                                                        $previewQr = null;
                                                    }
                                                @endphp
                                                @if($previewQr)
                                                    {!! $previewQr !!}
                                                @else
                                                    <div style="width:46px; height:46px; display:flex; align-items:center; justify-content:center; font-size:8px; color:#94a3b8;">QR</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                {{-- 2. Student Info --}}
                                <div class="bg-light p-2 rounded mb-2 border">
                                    <table class="table table-borderless table-sm mb-0" style="font-size: 0.75rem; background: transparent;">
                                        <tr>
                                            <td class="text-muted fw-bold py-0" style="width: 10%;">নাম:</td>
                                            <td class="fw-bold py-0" style="width: 38%; color: #1e3a8a;">{{ strtoupper($student->name) }}</td>
                                            <td class="text-muted fw-bold py-0" style="width: 10%;">শ্রেণি:</td>
                                            <td class="fw-bold py-0" style="width: 22%;">{{ $student->class->name ?? 'N/A' }}</td>
                                            <td class="text-muted fw-bold py-0" style="width: 8%;">রোল:</td>
                                            <td class="fw-bold py-0" style="width: 12%;">{{ $student->roll ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold py-0">আইডি:</td>
                                            <td class="fw-bold py-0">{{ $student->student_id ?? 'N/A' }}</td>
                                            <td class="text-muted fw-bold py-0">শাখা:</td>
                                            <td class="fw-bold py-0">{{ $student->section->name ?? 'N/A' }}</td>
                                            <td class="text-muted fw-bold py-0">গ্রুপ:</td>
                                            <td class="fw-bold py-0 text-primary">{{ $student->group->name ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>

                                {{-- 3. Routine (2 Columns with Time) --}}
                                <div class="mb-2">
                                    <div class="px-2 py-1 mb-1 rounded bg-secondary bg-opacity-10 fw-bold text-dark text-uppercase text-center" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                        📅 পরীক্ষার সময়সূচি (Exam Routine)
                                    </div>
                                    @if($totalRoutines > 0)
                                        <div class="row g-2">
                                            {{-- Column A --}}
                                            <div class="col-6">
                                                <table class="table table-sm table-bordered mb-0" style="font-size: 0.65rem;">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th style="padding: 2px 4px; text-align: center; width: 28%;">তারিখ</th>
                                                            <th style="padding: 2px 4px; width: 42%;">বিষয়</th>
                                                            <th style="padding: 2px 4px; text-align: center; width: 30%;">সময়</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($colA as $rtn)
                                                            <tr>
                                                                <td style="padding: 2px 4px; font-weight: bold; text-align: center; white-space: nowrap;">{{ \Carbon\Carbon::parse($rtn->exam_date)->format('d-m-Y') }}</td>
                                                                <td style="padding: 2px 4px; font-weight: 600;">{{ $rtn->subject->name ?? 'N/A' }}</td>
                                                                <td style="padding: 2px 4px; text-align: center; white-space: nowrap;">
                                                                    {{ $rtn->start_time ? \Carbon\Carbon::parse($rtn->start_time)->format('h:i A') : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            {{-- Column B --}}
                                            <div class="col-6">
                                                <table class="table table-sm table-bordered mb-0" style="font-size: 0.65rem;">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th style="padding: 2px 4px; text-align: center; width: 28%;">তারিখ</th>
                                                            <th style="padding: 2px 4px; width: 42%;">বিষয়</th>
                                                            <th style="padding: 2px 4px; text-align: center; width: 30%;">সময়</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($colB as $rtn)
                                                            <tr>
                                                                <td style="padding: 2px 4px; font-weight: bold; text-align: center; white-space: nowrap;">{{ \Carbon\Carbon::parse($rtn->exam_date)->format('d-m-Y') }}</td>
                                                                <td style="padding: 2px 4px; font-weight: 600;">{{ $rtn->subject->name ?? 'N/A' }}</td>
                                                                <td style="padding: 2px 4px; text-align: center; white-space: nowrap;">
                                                                    {{ $rtn->start_time ? \Carbon\Carbon::parse($rtn->start_time)->format('h:i A') : '-' }}
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr><td colspan="3" class="text-center text-muted">-</td></tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center text-muted p-2 border rounded bg-light" style="font-size: 0.72rem;">
                                            কোনো রুটিন সেট করা হয়নি।
                                        </div>
                                    @endif
                                </div>

                                {{-- 4. নির্দেশনাবলী (Instructions) — admit card পেজ থেকে ডাইনামিকভাবে সেট করা যায় --}}
                                <div class="mb-2" data-inst-wrapper>
                                    <div class="px-2 py-1 mb-1 rounded bg-secondary bg-opacity-10 fw-bold text-dark text-uppercase text-center" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                        📋 নির্দেশনাবলী (Instructions)
                                    </div>
                                    <ul class="mb-0 ps-3" data-inst-list style="font-size: 0.68rem; line-height: 1.4; list-style-type: disc;">
                                        @foreach($instructionLines as $instructionLine)
                                            <li class="text-dark">{{ $instructionLine }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- 5. Signatures --}}
                                <div class="d-flex justify-content-between pt-5 mt-4">
                                    <div class="text-center" style="width: 140px;">
                                        <div style="border-top: 1.5px dashed #64748b; font-size: 0.72rem;" class="fw-bold text-dark pt-1">
                                            শ্রেণি শিক্ষকের স্বাক্ষর
                                        </div>
                                    </div>
                                    <div class="text-center" style="width: 170px;">
                                        <div style="border-top: 1.5px dashed #64748b; font-size: 0.72rem;" class="fw-bold text-dark pt-1">
                                            অধ্যক্ষ / প্রধান শিক্ষকের স্বাক্ষর
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>{{-- /.col-lg-6 --}}
                @endforeach
            </div>
        @elseif(request('class_id'))
            <div class="alert alert-info border-0 shadow-sm" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-info me-2"></i> এই শ্রেণির কোনো শিক্ষার্থী পাওয়া যায়নি।
            </div>
        @endif

    </div>
</div>

<script>
    (function () {
        var input = document.getElementById('admitInstructionInput');
        if (!input) { return; }

        var lists = document.querySelectorAll('[data-inst-list]');
        var lineCountEl = document.getElementById('lineCountNum');

        function toLines(value) {
            return (value || '')
                .split(/\r\n|\r|\n/)
                .map(function (line) { return line.trim(); })
                .filter(function (line) { return line !== ''; });
        }

        function render() {
            var lines = toLines(input.value);

            // Update line count badge
            if (lineCountEl) { lineCountEl.textContent = lines.length; }

            // টেক্সট এরিয়া খালি হলে সার্ভার ডিফল্ট নির্দেশনাবলী ছাপায়
            if (lines.length === 0) {
                lines = toLines(input.getAttribute('data-defaults'));
            }

            lists.forEach(function (list) {
                list.innerHTML = '';
                lines.forEach(function (line) {
                    var li = document.createElement('li');
                    li.className = 'text-dark';
                    li.textContent = line;
                    list.appendChild(li);
                });
            });
        }

        // Initial render
        render();
        input.addEventListener('input', render);

        var defaultsBtn = document.getElementById('loadDefaultInstruction');
        if (defaultsBtn) {
            defaultsBtn.addEventListener('click', function () {
                input.value = input.getAttribute('data-defaults') || '';
                render();
            });
        }

        var clearBtn = document.getElementById('clearInstruction');
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                input.value = '';
                render();
            });
        }
    })();
</script>
@endsection