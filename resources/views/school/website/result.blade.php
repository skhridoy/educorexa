@extends('school.website.layouts.app')

@section('customCSS')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    * { font-family: 'Outfit', sans-serif; }

    /* ═══════════════════════════════════════════
       HERO BANNER
    ═══════════════════════════════════════════ */
    .res-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        padding: 55px 0 90px;
        position: relative; overflow: hidden; color: #fff;
    }
    .res-hero::before {
        content: ''; position: absolute;
        top: -80px; right: -80px;
        width: 280px; height: 280px;
        background: rgba(99,102,241,0.18);
        border-radius: 50%; filter: blur(60px);
    }
    .res-hero::after {
        content: ''; position: absolute;
        bottom: -60px; left: -60px;
        width: 220px; height: 220px;
        background: rgba(168,85,247,0.14);
        border-radius: 50%; filter: blur(50px);
    }
    .res-hero-inner { position: relative; z-index: 2; text-align: center; }
    .res-hero-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 6px 18px; border-radius: 30px;
        font-size: 0.8rem; font-weight: 700;
        color: #c7d2fe; letter-spacing: 0.5px;
        margin-bottom: 16px;
    }
    .res-hero-title {
        font-size: clamp(1.5rem, 4vw, 2.3rem);
        font-weight: 800; color: #fff;
        margin-bottom: 10px; letter-spacing: -0.5px;
    }
    .res-hero-sub {
        font-size: clamp(0.83rem, 2vw, 0.97rem);
        color: rgba(255,255,255,0.7);
        max-width: 540px; margin: 0 auto;
    }

    /* ═══════════════════════════════════════════
       FLOATING SEARCH CARD
    ═══════════════════════════════════════════ */
    .res-card {
        background: #fff;
        border: 1.5px solid #f1f5f9;
        border-radius: 24px;
        padding: 32px 36px;
        margin-top: -52px;
        margin-bottom: 48px;
        box-shadow: 0 24px 60px rgba(15,23,42,0.09);
        position: relative; z-index: 10;
    }

    /* Card header */
    .res-card-head {
        display: flex; align-items: center;
        justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1.5px solid #f1f5f9;
    }
    .res-card-title {
        font-size: 1.05rem; font-weight: 800;
        color: #0f172a; margin: 0;
        display: flex; align-items: center; gap: 10px;
    }
    .res-icon-sq {
        width: 36px; height: 36px; border-radius: 10px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff; display: flex;
        align-items: center; justify-content: center;
        font-size: 0.95rem; flex-shrink: 0;
    }
    .res-helper-tag {
        font-size: 0.74rem; font-weight: 700;
        color: #6366f1; background: #eff6ff;
        border: 1px solid #c7d2fe;
        padding: 4px 12px; border-radius: 20px;
        white-space: nowrap;
    }

    /* Labels */
    .res-label {
        font-size: 0.73rem; font-weight: 700;
        color: #475569; margin-bottom: 6px;
        display: flex; align-items: center; gap: 5px;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .res-label i { color: #6366f1; font-size: 0.7rem; }

    /* Controls */
    .res-control {
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px !important;
        padding: 9px 14px !important;
        font-size: 0.875rem !important;
        font-weight: 600 !important;
        background: #f8fafc !important;
        color: #0f172a !important;
        transition: border-color 0.2s, box-shadow 0.2s;
        height: 44px;
        width: 100%;
    }
    .res-control:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 4px rgba(99,102,241,0.12) !important;
        background: #fff !important;
        outline: none !important;
    }
    .res-control:disabled {
        background: #f1f5f9 !important;
        color: #94a3b8 !important;
        cursor: not-allowed;
        opacity: 0.8;
    }

    /* Loading tag next to exam label */
    #examLoadTag {
        display: none;
        font-size: 0.7rem; color: #6366f1;
        font-weight: 700; animation: pulse 1s infinite;
    }
    @keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:0.4; } }

    /* Divider */
    .res-divider {
        display: flex; align-items: center; gap: 10px;
        margin: 2px 0;
    }
    .res-divider-line { flex: 1; height: 1px; background: #e2e8f0; }
    .res-divider-text {
        font-size: 0.68rem; color: #94a3b8;
        font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; white-space: nowrap;
    }

    /* Search button */
    .btn-res-search {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #fff !important;
        border: none; border-radius: 12px;
        height: 46px; width: 100%;
        font-size: 0.92rem; font-weight: 800;
        cursor: pointer; transition: all 0.22s;
        display: flex; align-items: center;
        justify-content: center; gap: 8px;
        box-shadow: 0 6px 20px rgba(79,70,229,0.3);
    }
    .btn-res-search:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(79,70,229,0.42);
    }
    .btn-res-search:disabled { opacity: 0.7; cursor: not-allowed; }

    /* Info notice */
    .res-info-notice {
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: 14px;
        padding: 28px 20px;
        text-align: center;
        margin-top: 22px;
    }
    .res-info-notice .icon-w {
        width: 52px; height: 52px; border-radius: 14px;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; color: #6366f1;
        margin: 0 auto 12px;
    }

    /* Result area */
    #resultDisplayArea {
        margin-top: 26px; padding-top: 26px;
        border-top: 1.5px solid #f1f5f9;
    }

    /* ═══════════════════════════════════════════
       RESPONSIVE — grid adjustments
    ═══════════════════════════════════════════ */
    @media (max-width: 991.98px) {
        .res-hero  { padding: 44px 0 76px; }
        .res-card  { padding: 24px 22px; margin-top: -42px; }
    }
    @media (max-width: 767.98px) {
        .res-hero  { padding: 36px 0 68px; }
        .res-hero-title { font-size: 1.4rem; }
        .res-card  { padding: 18px 16px; margin-top: -34px; border-radius: 18px; }
        .res-card-title { font-size: 0.93rem; }
        /* On mobile the 2-col grid drops to 1-col — handled by Bootstrap col-12 col-sm-6 */
    }
    @media (max-width: 480px) {
        .res-hero  { padding: 28px 0 62px; }
        .res-hero-title { font-size: 1.25rem; }
        .res-helper-tag { display: none; }
    }
</style>
@endsection

@section('content')
<div style="background:#f8fafc; min-height:100vh;">

    {{-- ══ HERO ══ --}}
    <div class="res-hero">
        <div class="container">
            <div class="res-hero-inner">
                <div class="res-hero-badge">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                    Examination Result Portal
                </div>
                <h1 class="res-hero-title">পরীক্ষার ফলাফল দেখুন</h1>
                <p class="res-hero-sub">
                    ক্যাটেগরি ও পরীক্ষার নাম বেছে আইডি বা রোল দিয়ে ফলাফল খুঁজুন।<br>
                    বিগত সেশনের রেজাল্টও দেখা যাবে।
                </p>
            </div>
        </div>
    </div>

    {{-- ══ SEARCH CARD ══ --}}
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">

                <div class="res-card">

                    {{-- Card header --}}
                    <div class="res-card-head">
                        <h4 class="res-card-title">
                            <span class="res-icon-sq">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            ফলাফল অনুসন্ধান প্যানেল
                        </h4>
                        <span class="res-helper-tag">
                            <i class="fa-solid fa-clock-rotate-left me-1"></i>
                            বিগত সেশন সমর্থিত
                        </span>
                    </div>

                    {{-- Form --}}
                    <form id="resultSearchForm" novalidate>
                        @csrf

                        {{-- 2-column GRID --}}
                        <div class="row g-3 mb-3">

                            {{-- 1. শিক্ষাবর্ষ --}}
                            <div class="col-6">
                                <label class="res-label">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    শিক্ষাবর্ষ
                                </label>
                                <select name="academic_year_id" id="res_year" class="res-control">
                                    <option value="">সকল সেশন</option>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 2. ক্যাটেগরি --}}
                            <div class="col-6">
                                <label class="res-label">
                                    <i class="fa-solid fa-layer-group"></i>
                                    ক্যাটেগরি <span class="text-danger">*</span>
                                </label>
                                <select name="category_id" id="res_category" class="res-control" required>
                                    <option value="">-- বেছে নিন --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 3. শ্রেণী (Class) --}}
                            <div class="col-6">
                                <label class="res-label">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                    শ্রেণী <small class="text-muted" style="font-size:10px;">(রোলের জন্য আবশ্যক)</small>
                                    <span id="classLoadTag" style="display:none;">
                                        <i class="fa-solid fa-spinner fa-spin"></i>
                                    </span>
                                </label>
                                <select name="class_id" id="res_class" class="res-control" disabled>
                                    <option value="">-- আগে ক্যাটেগরি দিন --</option>
                                </select>
                            </div>

                            {{-- 4. পরীক্ষার নাম (dynamic) --}}
                            <div class="col-6">
                                <label class="res-label">
                                    <i class="fa-solid fa-file-pen"></i>
                                    পরীক্ষার নাম <span class="text-danger">*</span>
                                    <span id="examLoadTag" style="display:none;">
                                        <i class="fa-solid fa-spinner fa-spin"></i>
                                    </span>
                                </label>
                                <select name="exam_id" id="res_exam" class="res-control" required disabled>
                                    <option value="">-- আগে ক্যাটেগরি দিন --</option>
                                </select>
                            </div>

                            {{-- 5. আইডি / রোল --}}
                            <div class="col-12">
                                <label class="res-label">
                                    <i class="fa-solid fa-id-card"></i>
                                    আইডি / রোল <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="student_id"
                                       id="res_student_id"
                                       class="res-control"
                                       placeholder="রোল নম্বর (যেমন: 1) অথবা স্টুডেন্ট আইডি (যেমন: STD-261004)"
                                       required />
                                <div class="mt-1 text-muted" style="font-size:11.5px;">
                                    <i class="fa-solid fa-circle-info text-primary me-1"></i>
                                    <strong>রোল</strong> দিয়ে দেখতে উপরের <strong>শ্রেণী</strong> বেছে নিন। শ্রেণী ছাড়া দেখতে শুধু পূর্ণাঙ্গ <strong>স্টুডেন্ট আইডি</strong> লিখুন।
                                </div>
                            </div>

                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit" id="submitBtn" class="btn-res-search">
                            <span class="btn-text">
                                <i class="fa-solid fa-magnifying-glass me-1"></i>
                                ফলাফল দেখুন
                            </span>
                            <span class="spinner-border spinner-border-sm d-none" id="btnSpinner"></span>
                        </button>

                    </form>


                    {{-- Dynamic Result --}}
                    <div id="resultDisplayArea" class="d-none">
                        <div id="resultContainer"></div>
                    </div>

                    {{-- Info notice (initial) --}}
                    <div class="res-info-notice" id="infoNotice">
                        <div class="icon-w">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <p class="fw-bold mb-1" style="color:#1e293b; font-size:0.9rem;">
                            কীভাবে ফলাফল দেখবেন?
                        </p>
                        <p class="text-muted mb-0" style="font-size:0.8rem; line-height:1.65;">
                            ক্যাটেগরি সিলেক্ট করুন → শ্রেণী ও পরীক্ষার নাম বেছে নিন →
                            আইডি বা রোল লিখুন → ফলাফল দেখুন বাটনে চাপুন।
                        </p>
                    </div>

                </div><!-- /.res-card -->
            </div>
        </div>
    </div>

</div>
@endsection

@push('customJs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function () {
    const EXAMS_URL   = "{{ route('frontend.exams_by_category',   ['tenant' => $school->slug]) }}";
    const CLASSES_URL = "{{ route('frontend.classes_by_category', ['tenant' => $school->slug]) }}";
    const RESULT_URL  = "{{ route('frontend.search_result',       ['tenant' => $school->slug]) }}";
    const CSRF_TOKEN  = "{{ csrf_token() }}";

    const yearSel     = document.getElementById('res_year');
    const catSel      = document.getElementById('res_category');
    const classSel    = document.getElementById('res_class');
    const examSel     = document.getElementById('res_exam');
    const studentInp  = document.getElementById('res_student_id');
    const submitBtn   = document.getElementById('submitBtn');
    const btnSpinner  = document.getElementById('btnSpinner');
    const btnText     = submitBtn.querySelector('.btn-text');
    const examTag     = document.getElementById('examLoadTag');
    const classTag    = document.getElementById('classLoadTag');
    const infoNotice  = document.getElementById('infoNotice');
    const displayArea = document.getElementById('resultDisplayArea');
    const container   = document.getElementById('resultContainer');

    /* ── Load classes dynamically ── */
    function loadClasses() {
        const catId = catSel.value;
        if (!catId) {
            classSel.innerHTML = '<option value="">-- আগে ক্যাটেগরি দিন --</option>';
            classSel.disabled  = true;
            return;
        }

        classSel.disabled  = true;
        classSel.innerHTML = '<option value="">লোড হচ্ছে…</option>';
        if (classTag) classTag.style.display = 'inline-flex';

        fetch(CLASSES_URL + '?category_id=' + encodeURIComponent(catId))
            .then(r => r.json())
            .then(data => {
                if (classTag) classTag.style.display = 'none';
                if (data.status && data.classes.length > 0) {
                    classSel.innerHTML = '<option value="">-- শ্রেণী নির্বাচন করুন --</option>';
                    data.classes.forEach(c => {
                        classSel.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                    });
                    classSel.disabled = false;
                } else {
                    classSel.innerHTML = '<option value="">এই ক্যাটেগরিতে শ্রেণী নেই</option>';
                    classSel.disabled  = true;
                }
            })
            .catch(() => {
                if (classTag) classTag.style.display = 'none';
                classSel.innerHTML = '<option value="">লোড করতে সমস্যা হয়েছে</option>';
                classSel.disabled  = true;
            });
    }

    /* ── Load exams dynamically ── */
    function loadExams() {
        const catId  = catSel.value;
        const yearId = yearSel.value;

        if (!catId) {
            examSel.innerHTML = '<option value="">-- আগে ক্যাটেগরি দিন --</option>';
            examSel.disabled  = true;
            return;
        }

        examSel.disabled  = true;
        examSel.innerHTML = '<option value="">লোড হচ্ছে…</option>';
        if (examTag) examTag.style.display = 'inline-flex';

        const params = new URLSearchParams({ category_id: catId });
        if (yearId) params.append('academic_year_id', yearId);

        fetch(EXAMS_URL + '?' + params.toString())
            .then(r => r.json())
            .then(data => {
                if (examTag) examTag.style.display = 'none';
                if (data.status && data.exams.length > 0) {
                    examSel.innerHTML = '<option value="">-- পরীক্ষা বেছে নিন --</option>';
                    data.exams.forEach(e => {
                        examSel.innerHTML += `<option value="${e.id}">${e.name}</option>`;
                    });
                    examSel.disabled = false;
                } else {
                    examSel.innerHTML = '<option value="">এই ক্যাটেগরিতে কোনো পরীক্ষা নেই</option>';
                    examSel.disabled  = true;
                }
            })
            .catch(() => {
                if (examTag) examTag.style.display = 'none';
                examSel.innerHTML = '<option value="">লোড করতে সমস্যা হয়েছে</option>';
                examSel.disabled  = true;
            });
    }

    catSel.addEventListener('change', function () {
        loadClasses();
        loadExams();
    });

    yearSel.addEventListener('change', function () {
        if (catSel.value) loadExams();
    });

    /* ── Form submit ── */
    document.getElementById('resultSearchForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const catId     = catSel.value;
        const classId   = classSel.value;
        const examId    = examSel.value;
        const studentId = studentInp.value.trim();
        const yearId    = yearSel.value;

        if (!catId) {
            Swal.fire({ icon:'warning', title:'ক্যাটেগরি নির্বাচন করুন',
                text:'অনুগ্রহ করে একটি ক্যাটেগরি বেছে নিন।',
                confirmButtonColor:'#4f46e5' });
            return;
        }
        if (!examId) {
            Swal.fire({ icon:'warning', title:'পরীক্ষা নির্বাচন করুন',
                text:'অনুগ্রহ করে পরীক্ষার নাম বেছে নিন।',
                confirmButtonColor:'#4f46e5' });
            return;
        }
        if (!studentId) {
            Swal.fire({ icon:'warning', title:'আইডি / রোল দিন',
                text:'অনুগ্রহ করে শিক্ষার্থীর আইডি বা রোল নম্বর দিন।',
                confirmButtonColor:'#4f46e5' });
            studentInp.focus();
            return;
        }

        /* Disable during fetch */
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
        infoNotice.classList.add('d-none');
        displayArea.classList.add('d-none');

        fetch(RESULT_URL, {
            method : 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body   : JSON.stringify({
                student_id      : studentId,
                exam_id         : examId,
                academic_year_id: yearId || null,
                category_id     : catId,
                class_id        : classId || null,
            })
        })
        .then(r => r.json().then(data => ({ ok: r.ok, data })))
        .then(({ ok, data }) => {
            if (data.status) {
                container.innerHTML = data.data;
                displayArea.classList.remove('d-none');
                setTimeout(() => displayArea.scrollIntoView({ behavior:'smooth', block:'start' }), 100);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ফলাফল পাওয়া যায়নি',
                    text : data.message || 'প্রদত্ত তথ্য দিয়ে কোনো ফলাফল খুঁজে পাওয়া যায়নি।',
                    confirmButtonColor: '#4f46e5',
                });
                infoNotice.classList.remove('d-none');
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'সংযোগ সমস্যা',
                text : 'ফলাফল লোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।',
                confirmButtonColor: '#4f46e5',
            });
            infoNotice.classList.remove('d-none');
        })
        .finally(() => {
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
        });
    });
})();
</script>
@endpush
