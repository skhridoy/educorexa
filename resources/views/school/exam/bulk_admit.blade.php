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

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- Filter Card --}}
        <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-id-card me-2 text-primary"></i>প্রবেশপত্র তৈরি ও ডাউনলোড (Admit Card Generator)
                    </h5>
                    @if(isset($students) && $students->count() > 0)
                        <a href="{{ route('exam.bulk_admit_card', ['tenant' => $tenant, 'class_id' => request('class_id'), 'exam_id' => request('exam_id')]) }}"
                           target="_blank"
                           class="btn btn-success fw-bold"
                           style="border-radius: 10px; padding: 9px 20px;">
                            <i class="fa-solid fa-file-pdf me-2"></i>PDF ডাউনলোড
                        </a>
                    @endif
                </div>

                <form action="{{ request()->url() }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-bold text-muted" style="font-size: 0.8rem;">শ্রেণি (Class)</label>
                            <select name="class_id" class="form-select" required style="border-radius: 10px; padding: 10px;">
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
                            <select name="exam_id" class="form-select" required style="border-radius: 10px; padding: 10px;">
                                <option value="">-- পরীক্ষা নির্বাচন করুন --</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 10px; padding: 10px;">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> খুঁজুন
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Preview Section --}}
        @if(isset($students) && $students->count() > 0)
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-eye me-1 text-primary"></i> এডমিট কার্ড প্রিভিউ (মোট {{ $students->count() }} জন শিক্ষার্থী)
                </h6>
                <small class="text-muted"><i class="fa-solid fa-print me-1"></i>A4 পেজে প্রতি পাতায় ২টি করে প্রবেশপত্র প্রিন্ট হবে</small>
            </div>

            <div class="row">
                @php
                    $totalRoutines = $examRoutines->count();
                    $half = ceil($totalRoutines / 2);
                    $colA = $examRoutines->slice(0, $half);
                    $colB = $examRoutines->slice($half);
                @endphp

                @foreach($students as $student)
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
                                                        $previewQr = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(46)->color(15, 23, 42)->generate("ID: {$student->student_id}\nName: {$student->name}\nRoll: {$student->roll}");
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
                                            <td class="text-muted fw-bold py-0" style="width: 12%;">নাম:</td>
                                            <td class="fw-bold py-0" style="width: 38%; color: #1e3a8a;">{{ strtoupper($student->name) }}</td>
                                            <td class="text-muted fw-bold py-0" style="width: 12%;">শ্রেণি:</td>
                                            <td class="fw-bold py-0" style="width: 38%;">{{ $student->class->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold py-0">আইডি:</td>
                                            <td class="fw-bold py-0">{{ $student->student_id ?? 'N/A' }}</td>
                                            <td class="text-muted fw-bold py-0">রোল:</td>
                                            <td class="fw-bold py-0">{{ $student->roll ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold py-0">শাখা:</td>
                                            <td class="fw-bold py-0">{{ $student->section->name ?? 'N/A' }}</td>
                                            <td class="text-muted fw-bold py-0">সেশন:</td>
                                            <td class="fw-bold py-0">{{ date('Y') }}</td>
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

                                {{-- 4. Signatures --}}
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
                    </div>
                @endforeach
            </div>
        @elseif(request('class_id'))
            <div class="alert alert-info border-0 shadow-sm" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-info me-2"></i> এই শ্রেণির কোনো শিক্ষার্থী পাওয়া যায়নি।
            </div>
        @endif

    </div>
</div>
@endsection