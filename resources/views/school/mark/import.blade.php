@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ══════════════════════════════════════════════
           MARK IMPORT PAGE STYLES
        ══════════════════════════════════════════════ */
        .import-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 26px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(15,23,42,0.18);
        }
        .import-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: rgba(99,102,241,0.12);
            border-radius: 50%;
        }
        .import-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -30px;
            width: 140px; height: 140px;
            background: rgba(79,70,229,0.07);
            border-radius: 50%;
        }
        .import-hero-content { position: relative; z-index: 2; }
        .import-hero-title   { font-size:1.6rem; font-weight:800; color:#fff; margin:0 0 4px; letter-spacing:-0.5px; }
        .import-hero-sub     { font-size:0.86rem; color:rgba(255,255,255,0.65); margin:0; }

        .mode-card {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fff;
            height: 100%;
        }
        .mode-card:hover { border-color: #818cf8; box-shadow: 0 4px 16px rgba(79,70,229,0.1); }
        .mode-card.selected {
            border-color: #4f46e5;
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
            box-shadow: 0 4px 20px rgba(79,70,229,0.15);
        }
        .mode-icon {
            width: 40px; height: 40px;
            border-radius: 11px;
            background: linear-gradient(135deg,#4f46e5,#7c3aed);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1rem;
            flex-shrink: 0;
        }
        .mode-card-title { font-size: 13.5px; color: #1e293b; margin-bottom: 2px; }
        .mode-card-sub   { font-size: 11.5px; }

        @media (max-width: 575.98px) {
            .mode-card { padding: 9px 8px; border-radius: 10px; }
            .mode-icon { width: 30px; height: 30px; font-size: 0.8rem; border-radius: 8px; }
            .mode-card-title { font-size: 11px; margin-bottom: 1px; }
            .mode-card-sub { font-size: 9.5px; }
        }

        .dropzone-area {
            border: 2px dashed #818cf8;
            border-radius: 16px;
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
            padding: 38px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            user-select: none;
        }
        .dropzone-area:hover, .dropzone-area.dz-over {
            border-color: #4f46e5;
            background: linear-gradient(135deg, #e0e7ff 0%, #eef2ff 100%);
            box-shadow: 0 8px 25px rgba(79,70,229,0.15);
        }
        .dz-icon {
            width: 58px; height: 58px;
            background: linear-gradient(135deg,#4f46e5,#7c3aed);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: #fff;
            margin: 0 auto 12px;
            box-shadow: 0 6px 16px rgba(79,70,229,0.3);
            transition: transform 0.2s ease;
        }
        .dropzone-area:hover .dz-icon { transform: translateY(-4px); }
        .dz-title { font-weight:700; font-size:15px; color:#3730a3; margin-bottom:3px; }
        .dz-sub   { font-size:12px; color:#64748b; margin:0; }

        .form-section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            margin-bottom: 8px;
        }

        /* ══ ACTION BUTTONS ══ */
        .import-actions-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            margin-top: 20px;
        }
        .btn-tpl-download {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f8fafc;
            color: #4f46e5 !important;
            border: 1.5px solid #c7d2fe;
            border-radius: 9px;
            padding: 8px 18px;
            font-size: 0.80rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.08);
            text-decoration: none;
        }
        .btn-tpl-download:hover {
            background: #eff6ff;
            border-color: #818cf8;
            color: #4338ca !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }
        .btn-tpl-download:active {
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(99, 102, 241, 0.1);
        }
        .btn-action-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            color: #475569 !important;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            padding: 8px 20px;
            font-size: 0.80rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-action-cancel:hover {
            background: #e2e8f0;
            color: #1e293b !important;
            border-color: #cbd5e1;
        }
        .btn-action-import {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #7c3aed 100%);
            color: #ffffff !important;
            border: none;
            border-radius: 9px;
            padding: 8px 26px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.2px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.28);
            text-decoration: none;
        }
        .btn-action-import:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.42);
            background: linear-gradient(135deg, #4338ca 0%, #4f46e5 50%, #6d28d9 100%);
        }
        .btn-action-import:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.2);
        }

        @media (max-width: 576px) {
            .import-hero { padding: 18px 16px; }
            .import-hero-title { font-size: 1.3rem; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Hero Header --}}
        <div class="import-hero mb-4">
            <div class="import-hero-content d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h1 class="import-hero-title">
                        <i class="fa-solid fa-file-arrow-up me-2" style="color:#a5b4fc;"></i>
                        {{ __('Mark Import') }}
                    </h1>
                    <p class="import-hero-sub">{{ __('CSV / Excel ফাইল দিয়ে এক বা একাধিক বিষয়ের মার্ক একসাথে submit করুন') }}</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('marks.index', ['tenant' => auth()->user()?->school?->slug]) }}"
                       class="btn-tpl-download"
                       style="background:rgba(255,255,255,0.14);color:#fff!important;border:1px solid rgba(255,255,255,0.28);border-radius:20px;padding:6px 16px;font-size:0.75rem;backdrop-filter:blur(8px);">
                        <i class="fa-solid fa-arrow-left"></i> {{ __('Marks Entry') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Left: Import Form --}}
            <div class="col-lg-7">
                <div class="form-card">

                    <form action="{{ route('marks.import', ['tenant' => auth()->user()?->school?->slug]) }}"
                          method="POST" enctype="multipart/form-data" id="mark_import_form">
                        @csrf

                        {{-- Step 1: Mode Selection --}}
                        <div class="mb-4">
                            <p class="form-section-label"><i class="fa-solid fa-list-check me-1"></i> Step 1 — Import Mode বেছে নিন</p>
                            <div class="row g-2 g-sm-3">
                                <div class="col-6">
                                    <div class="mode-card selected" id="card_single" onclick="selectMode('single')">
                                        <div class="d-flex align-items-center gap-2 gap-sm-3">
                                            <div class="mode-icon"><i class="fa-solid fa-book"></i></div>
                                            <div style="min-width:0; flex:1;">
                                                <div class="mode-card-title fw-bold">{{ __('Single Subject') }}</div>
                                                <div class="mode-card-sub text-muted">{{ __('Marks for one subject') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mode-card" id="card_multi" onclick="selectMode('multi')">
                                        <div class="d-flex align-items-center gap-2 gap-sm-3">
                                            <div class="mode-icon" style="background:linear-gradient(135deg,#0ea5e9,#6366f1);"><i class="fa-solid fa-table-columns"></i></div>
                                            <div style="min-width:0; flex:1;">
                                                <div class="mode-card-title fw-bold">{{ __('Multi Subject') }}</div>
                                                <div class="mode-card-sub text-muted">{{ __('Multiple subjects together') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="mode" id="mode_input" value="single">
                        </div>

                        {{-- Step 2: Exam & Class --}}
                        <div class="mb-4">
                            <p class="form-section-label"><i class="fa-solid fa-sliders me-1"></i> Step 2 — পরীক্ষা ও শ্রেণি বেছে নিন</p>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold" style="font-size:13px;">{{ __('Exam') }} <span class="text-danger">*</span></label>
                                    <select name="exam_id" id="exam_id" class="form-select form-select-sm" required>
                                        <option value="">{{ __('-- Select Exam --') }}</option>
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('exam_id')<div class="text-danger" style="font-size:12px;">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold" style="font-size:13px;">{{ __('Class') }} <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_id" class="form-select form-select-sm" required>
                                        <option value="">{{ __('-- Select Class --') }}</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')<div class="text-danger" style="font-size:12px;">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Subject (single mode only) --}}
                        <div class="mb-4" id="subject_row">
                            <p class="form-section-label"><i class="fa-solid fa-book-open me-1"></i> Step 3 — বিষয় বেছে নিন (Single Mode)</p>
                            <select name="subject_id" id="subject_id" class="form-select form-select-sm">
                                <option value="">{{ __('Select Class first') }}</option>
                            </select>
                            @error('subject_id')<div class="text-danger" style="font-size:12px;">{{ $message }}</div>@enderror
                            <div class="text-muted mt-1" style="font-size:11.5px;">
                                <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                                Multi mode-এ subject কলাম নাম থেকে auto-detect হয়
                            </div>
                        </div>

                        {{-- Step 4: File Upload --}}
                        <div class="mb-4">
                            <p class="form-section-label"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Step 4 — ফাইল Upload করুন</p>
                            <div class="dropzone-area"
                                 id="mark_dropzone"
                                 onclick="document.getElementById('mark_file_input').click();"
                                 ondragover="event.preventDefault(); this.classList.add('dz-over');"
                                 ondragleave="this.classList.remove('dz-over');"
                                 ondrop="handleMarkDrop(event);">
                                <div class="dz-icon" id="mark_dz_icon">
                                    <i class="fa-solid fa-file-excel"></i>
                                </div>
                                <p class="dz-title" id="mark_dz_label">{{ __('Click or drag .xlsx / .csv file here') }}</p>
                                <p class="dz-sub">{{ __('Supports .xlsx, .xls, .csv — max 5 MB') }}</p>
                                <input type="file" name="file" id="mark_file_input"
                                       accept=".xlsx,.xls,.csv" class="d-none" required
                                       onchange="previewMarkFile(this);">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="import-actions-bar">
                            <button type="button" id="btn_download_tpl"
                                    class="btn-tpl-download"
                                    onclick="downloadTemplate()">
                                <i class="fa-solid fa-cloud-arrow-down"></i>
                                <span>{{ __('Template Download') }}</span>
                            </button>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('marks.index', ['tenant' => auth()->user()?->school?->slug]) }}"
                                   class="btn-action-cancel">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    <span>{{ __('Cancel') }}</span>
                                </a>
                                <button type="submit" id="mark_import_btn" class="btn-action-import">
                                    <i class="fa-solid fa-file-import"></i>
                                    <span>{{ __('Import Marks') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Right: Guide --}}
            <div class="col-lg-5">
                <div class="form-card h-100" style="background:linear-gradient(135deg,#f8fafc,#f1f5f9);">

                    <h6 class="fw-bold mb-3" style="font-size:14px;color:#1e293b;">
                        <i class="fa-solid fa-circle-question me-2 text-primary"></i>{{ __('How to use?') }}
                    </h6>

                    <div class="d-flex flex-column gap-3">
                        <!-- Single mode guide -->
                        <div id="guide_single">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge" style="background:#4f46e5;font-size:10px;">{{ __('Single Subject Mode') }}</span>
                            </div>
                            <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden;">
                                <table class="table table-sm mb-0" style="font-size:12px;">
                                    <thead style="background:#eef2ff;">
                                        <tr>
                                            <th style="padding:7px 8px;color:#4f46e5;">roll</th>
                                            <th style="padding:7px 8px;color:#4f46e5;">student_name</th>
                                            <th style="padding:7px 8px;color:#4f46e5;">cq</th>
                                            <th style="padding:7px 8px;color:#4f46e5;">mcq</th>
                                            <th style="padding:7px 8px;color:#4f46e5;">practical</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td style="padding:6px 8px;">1</td><td>Sumon Roy</td><td>45</td><td>25</td><td>20</td></tr>
                                        <tr style="background:#f8fafc;"><td style="padding:6px 8px;">2</td><td>Rina Begum</td><td>40</td><td>22</td><td>18</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-muted mt-2" style="font-size:11.5px;">
                                <i class="fa-solid fa-lightbulb me-1 text-warning"></i>
                                CQ, MCQ ও Practical নম্বর পূরণ করলেই মোট নম্বর স্বয়ংক্রিয়ভাবে হিসাব হয়ে ডাটাবেসে সেভ হবে।
                            </p>
                        </div>

                        <!-- Multi mode guide -->
                        <div id="guide_multi" style="display:none;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge" style="background:#0ea5e9;font-size:10px;">{{ __('Multi Subject Mode') }}</span>
                            </div>
                            <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:auto;">
                                <table class="table table-sm mb-0" style="font-size:11px;min-width:440px;">
                                    <thead style="background:#e0f2fe;">
                                        <tr>
                                            <th style="padding:7px 6px;color:#0284c7;">roll</th>
                                            <th style="padding:7px 6px;color:#0284c7;">student_name</th>
                                            <th style="padding:7px 6px;color:#0284c7;">Bangla (CQ)</th>
                                            <th style="padding:7px 6px;color:#0284c7;">Bangla (MCQ)</th>
                                            <th style="padding:7px 6px;color:#0284c7;">Bangla (Prac)</th>
                                            <th style="padding:7px 6px;color:#0284c7;">English (CQ)</th>
                                            <th style="padding:7px 6px;color:#0284c7;">English (MCQ)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td style="padding:6px 6px;">1</td><td>Sumon Roy</td><td>45</td><td>25</td><td>20</td><td>50</td><td>30</td></tr>
                                        <tr style="background:#f8fafc;"><td style="padding:6px 6px;">2</td><td>Rina</td><td>40</td><td>22</td><td>18</td><td>45</td><td>28</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-muted mt-2" style="font-size:11.5px;">
                                <i class="fa-solid fa-lightbulb me-1 text-warning"></i>
                                Template download করলে সব বিষয়ের <strong>CQ, MCQ, Practical</strong> আলাদা কলাম তৈরি থাকবে। পূরণকৃত নম্বর স্বয়ংক্রিয়ভাবে হিসাব হয়ে সেভ হবে।
                            </p>
                        </div>

                        <!-- Common tips -->
                        <div class="p-3 rounded-3" style="background:#fff;border:1px solid #e2e8f0;font-size:12px;">
                            <p class="fw-bold mb-2 text-dark" style="font-size:13px;">
                                <i class="fa-solid fa-circle-exclamation me-1 text-amber-500" style="color:#f59e0b;"></i>
                                {{ __('Important Information') }}
                            </p>
                            <ul class="mb-0 ps-3" style="color:#475569;line-height:1.8;">
                                <li>Student-দের <strong>roll</strong> দিয়ে match করা হয়</li>
                                <li>যদি roll না থাকে, <strong>student_id</strong> দিয়ে fallback করা হয়</li>
                                <li>Blank mark থাকলে সেই row skip করা হয় (error না)</li>
                                <li>পূর্বের mark থাকলে <strong>update</strong> হবে, না থাকলে <strong>নতুন</strong> তৈরি হবে</li>
                                <li>সমস্যার বিবরণ import-এর পর নিচে দেখাবে</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Per-row Error Report --}}
        @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="form-card mt-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#ef4444,#dc2626);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-triangle-exclamation text-white" style="font-size:14px;"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-danger">Import সমস্যা রিপোর্ট</h6>
                    <small class="text-muted">{{ count(session('import_errors')) }}টি row/column-এ সমস্যা পাওয়া গেছে</small>
                </div>
            </div>
            <div style="max-height:300px;overflow-y:auto;border:1px solid #fee2e2;border-radius:10px;">
                <table class="table table-sm mb-0" style="font-size:13px;">
                    <thead style="background:#fef2f2;position:sticky;top:0;z-index:1;">
                        <tr>
                            <th style="width:45px;color:#dc2626;padding:8px 12px;">#</th>
                            <th style="color:#dc2626;padding:8px 12px;">সমস্যার বিবরণ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('import_errors') as $i => $err)
                        <tr style="border-bottom:1px solid #fee2e2;">
                            <td style="padding:7px 12px;color:#6b7280;">{{ $i + 1 }}</td>
                            <td style="padding:7px 12px;color:#374151;">{{ $err }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(session('import_success_count'))
            <div class="mt-3 p-2 rounded-3 small d-flex align-items-center gap-2"
                 style="background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;">
                <i class="fa-solid fa-circle-check"></i>
                <span>
                    {{ session('import_success_count') }} জন student-এর mark import হয়েছে।
                    {{ session('import_skip_count', 0) }} টি row skip।
                </span>
            </div>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection

@section('customJs')
<script>
const tenantSlug = '{{ auth()->user()?->school?->slug }}';
const findSubjectUrl = '{{ route("marks.findSubject", ["tenant" => auth()->user()?->school?->slug]) }}';
const templateUrl    = '{{ route("marks.import.template", ["tenant" => auth()->user()?->school?->slug]) }}';

// ── Mode Selection ──
function selectMode(mode) {
    document.getElementById('mode_input').value = mode;

    document.getElementById('card_single').classList.toggle('selected', mode === 'single');
    document.getElementById('card_multi').classList.toggle('selected', mode === 'multi');

    document.getElementById('subject_row').style.display = mode === 'single' ? '' : 'none';
    document.getElementById('guide_single').style.display = mode === 'single' ? '' : 'none';
    document.getElementById('guide_multi').style.display  = mode === 'multi'  ? '' : 'none';
}

// ── Class change: load subjects (single mode) ──
document.getElementById('class_id').addEventListener('change', function () {
    const classId = this.value;
    const select  = document.getElementById('subject_id');

    if (!classId) {
        select.innerHTML = '<option value="">-- আগে শ্রেণি বেছে নিন --</option>';
        return;
    }

    fetch(findSubjectUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ class_id: classId }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.status && data.subjects.length) {
            select.innerHTML = '<option value="">-- বিষয় বেছে নিন --</option>';
            data.subjects.forEach(s => {
                select.innerHTML += `<option value="${s.id}">${s.name}</option>`;
            });
        } else {
            select.innerHTML = '<option value="">এই শ্রেণিতে কোনো বিষয় নেই</option>';
        }
    });
});

// ── File Preview ──
function previewMarkFile(input) {
    const file  = input.files[0];
    const label = document.getElementById('mark_dz_label');
    const icon  = document.getElementById('mark_dz_icon');
    if (!file) return;

    const allowed = ['xlsx', 'xls', 'csv'];
    const ext = file.name.split('.').pop().toLowerCase();

    if (!allowed.includes(ext)) {
        label.textContent = '❌ Invalid format! Please select .xlsx, .xls or .csv';
        label.style.color = '#ef4444';
        return;
    }

    const size = file.size < 1024 * 1024
        ? (file.size / 1024).toFixed(1) + ' KB'
        : (file.size / (1024 * 1024)).toFixed(2) + ' MB';

    label.innerHTML = `<i class="fa-solid fa-file-excel me-2" style="color:#4f46e5;"></i><strong>${file.name}</strong> <span style="color:#64748b;">(${size})</span>`;
    label.style.color = '#3730a3';
    icon.innerHTML = '<i class="fa-solid fa-circle-check" style="color:#fff;font-size:1.4rem;"></i>';
}

function handleMarkDrop(e) {
    e.preventDefault();
    document.getElementById('mark_dropzone').classList.remove('dz-over');
    const dt = e.dataTransfer;
    if (dt.files.length) {
        document.getElementById('mark_file_input').files = dt.files;
        previewMarkFile(document.getElementById('mark_file_input'));
    }
}

// ── Download Template ──
function downloadTemplate() {
    const classId   = document.getElementById('class_id').value;
    const mode      = document.getElementById('mode_input').value;
    const subjectId = document.getElementById('subject_id').value;

    if (!classId) {
        Swal.fire({ icon: 'warning', title: 'শ্রেণি বাছুন', text: 'Template download করার আগে শ্রেণি বেছে নিন।' });
        return;
    }
    if (mode === 'single' && !subjectId) {
        Swal.fire({ icon: 'warning', title: 'বিষয় বাছুন', text: 'Single mode-এ template download করার আগে বিষয় বেছে নিন।' });
        return;
    }

    let url = `${templateUrl}?class_id=${classId}&mode=${mode}`;
    if (mode === 'single' && subjectId) url += `&subject_id=${subjectId}`;
    window.location.href = url;
}

// ── Toasts ──
@if(session('success'))
    Swal.fire({ icon: 'success', title: 'সফল!', text: '{{ session('success') }}' });
@endif

@if(session('warning'))
    Swal.fire({
        icon: 'warning',
        title: 'আংশিক সফল',
        text: '{{ session('warning') }}',
        footer: 'নিচের টেবিলে সমস্যার বিবরণ দেখুন।',
    });
@endif

@if(session('error') && !session('import_errors'))
    Swal.fire({ icon: 'error', title: 'ব্যর্থ!', text: '{{ session('error') }}' });
@endif
</script>
@endsection
