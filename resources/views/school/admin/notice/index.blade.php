@extends('layouts.school')
@section('title', 'Notice Management')

@section('customCSS')
<style>
    /* ══════════════════════════════
       NOTICE PAGE — PREMIUM DESIGN
    ══════════════════════════════ */

    /* Hero */
    .notice-hero {
        background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #4f46e5 100%);
        border-radius: 18px;
        padding: 28px 30px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .notice-hero::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        background: rgba(99,102,241,0.15);
        border-radius: 50%;
    }
    .notice-hero::after {
        content: '';
        position: absolute;
        bottom: -60px; left: 30%;
        width: 160px; height: 160px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .notice-hero-title { font-size: 1.5rem; font-weight: 800; color: #fff; margin: 0 0 4px; letter-spacing: -0.4px; }
    .notice-hero-sub   { font-size: 0.84rem; color: rgba(255,255,255,0.65); margin: 0; }
    .notice-hero-badge { display: inline-flex; align-items: center; gap: 5px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.18); color: #a5b4fc; font-size: 0.70rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; margin-top: 8px; }
    .notice-hero-stat { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 12px 18px; text-align: center; backdrop-filter: blur(6px); }
    .notice-hero-stat-num { font-size: 1.6rem; font-weight: 800; color: #fff; line-height: 1; margin-bottom: 3px; }
    .notice-hero-stat-label { font-size: 0.70rem; color: rgba(255,255,255,0.65); font-weight: 600; }

    /* Form Card */
    .notice-form-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(15,23,42,0.06);
        overflow: hidden;
    }
    .notice-form-header {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .notice-form-header-icon {
        width: 36px; height: 36px;
        background: rgba(255,255,255,0.18);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1rem;
    }
    .notice-form-header-title { color: #fff; font-size: 0.92rem; font-weight: 700; margin: 0; }
    .notice-form-header-sub   { color: rgba(255,255,255,0.72); font-size: 0.72rem; margin: 0; }
    .notice-form-body { padding: 20px; }
    .notice-form-body .form-label { font-size: 0.76rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 5px; }
    .notice-form-body .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 0.84rem;
        padding: 8px 12px;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .notice-form-body .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        background: #fff;
    }
    .btn-notice-submit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: linear-gradient(135deg, #4f46e5, #6366f1, #7c3aed);
        color: #fff !important;
        border: none;
        border-radius: 9px;
        padding: 9px 22px;
        font-size: 0.84rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(79,70,229,0.28);
        transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
        width: 100%;
        justify-content: center;
    }
    .btn-notice-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(79,70,229,0.40);
        background: linear-gradient(135deg, #4338ca, #4f46e5, #6d28d9);
    }
    .notice-file-drop {
        border: 2px dashed #c7d2fe;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        background: #f5f3ff;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .notice-file-drop:hover { border-color: #818cf8; background: #ede9fe; }
    .notice-file-drop input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .notice-file-icon { font-size: 1.4rem; color: #7c3aed; margin-bottom: 5px; }
    .notice-file-text { font-size: 0.76rem; color: #6d28d9; font-weight: 600; margin: 0; }
    .notice-file-sub  { font-size: 0.66rem; color: #94a3b8; margin: 0; }
    .active-check-toggle .form-check-input { width: 36px; height: 20px; cursor: pointer; }
    .active-check-toggle .form-check-input:checked { background-color: #10b981; border-color: #10b981; }

    /* Notice List Card */
    .notice-list-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(15,23,42,0.06);
        overflow: hidden;
    }
    .notice-list-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        background: #fafbff;
    }
    .notice-list-title { font-size: 0.92rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px; }
    .notice-count-badge { background: linear-gradient(135deg,#4f46e5,#7c3aed); color: #fff; font-size: 0.66rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; }

    /* Notice Row Cards */
    .notice-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 18px;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.18s ease;
        position: relative;
    }
    .notice-item:last-child { border-bottom: none; }
    .notice-item:hover { background: #fafbff; }
    .notice-item-date-badge {
        flex: 0 0 44px;
        width: 44px;
        height: 50px;
        border-radius: 10px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(79,70,229,0.22);
        flex-shrink: 0;
    }
    .notice-item-date-day  { font-size: 1.05rem; font-weight: 800; color: #fff; line-height: 1; }
    .notice-item-date-mon  { font-size: 0.56rem; font-weight: 700; color: rgba(255,255,255,0.78); text-transform: uppercase; letter-spacing: 0.06em; }
    .notice-item-body { flex: 1; min-width: 0; }
    .notice-item-title { font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .notice-item-desc  { font-size: 0.74rem; color: #64748b; margin: 0 0 7px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .notice-item-tags  { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
    .notice-tag        { display: inline-flex; align-items: center; gap: 3px; font-size: 0.64rem; font-weight: 600; padding: 2px 7px; border-radius: 20px; }
    .notice-tag.file-tag { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .notice-tag.active-tag { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .notice-tag.inactive-tag { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .notice-item-actions { display: flex; align-items: center; gap: 5px; flex-shrink: 0; }
    .notice-action-btn {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.78rem;
        border: 1px solid;
        cursor: pointer;
        transition: all 0.18s ease;
        text-decoration: none;
        background: transparent;
    }
    .notice-action-btn.edit   { color: #d97706; border-color: #fde68a; background: #fffbeb; }
    .notice-action-btn.edit:hover { background: #fef3c7; border-color: #f59e0b; transform: translateY(-1px); }
    .notice-action-btn.delete { color: #dc2626; border-color: #fecaca; background: #fff5f5; }
    .notice-action-btn.delete:hover { background: #fee2e2; border-color: #ef4444; transform: translateY(-1px); }
    .notice-action-btn.email  { color: #4f46e5; border-color: #c7d2fe; background: #eef2ff; }
    .notice-action-btn.email:hover { background: #e0e7ff; border-color: #818cf8; transform: translateY(-1px); }
    .notice-action-btn.whatsapp { color: #16a34a; border-color: #bbf7d0; background: #f0fdf4; }
    .notice-action-btn.whatsapp:hover { background: #dcfce7; border-color: #4ade80; transform: translateY(-1px); }

    /* Empty State */
    .notice-empty {
        text-align: center;
        padding: 50px 20px;
    }
    .notice-empty-icon {
        width: 64px; height: 64px;
        border-radius: 16px;
        background: linear-gradient(135deg, #f5f3ff, #ede9fe);
        color: #7c3aed;
        font-size: 1.7rem;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
    }
    .notice-empty-title { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 6px; }
    .notice-empty-sub   { font-size: 0.82rem; color: #94a3b8; }

    /* Dark mode */
    body.dark-mode .notice-form-card, [data-bs-theme="dark"] .notice-form-card,
    body.dark-mode .notice-list-card, [data-bs-theme="dark"] .notice-list-card { background: #0c1427 !important; border-color: #1a253b !important; }
    body.dark-mode .notice-form-body .form-control, [data-bs-theme="dark"] .notice-form-body .form-control { background: #060c18 !important; border-color: #1a253b !important; color: #f1f5f9 !important; }
    body.dark-mode .notice-item:hover, [data-bs-theme="dark"] .notice-item:hover { background: #0f1e38 !important; }
    body.dark-mode .notice-list-header, [data-bs-theme="dark"] .notice-list-header { background: #060c18 !important; border-color: #1a253b !important; }
    body.dark-mode .notice-item-title, [data-bs-theme="dark"] .notice-item-title { color: #f1f5f9 !important; }
</style>
@endsection

@section('content')
<div class="page-content">
<div class="container-fluid px-3 px-md-4">

    {{-- ══ HERO ══ --}}
    @php
        $totalNotices  = $notices->total();
        $activeNotices = $notices->getCollection()->where('is_active', true)->count();
    @endphp
    <div class="notice-hero mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="notice-hero-title"><i class="fa-solid fa-bullhorn me-2"></i>Notice Management</h1>
                <p class="notice-hero-sub">স্কুলের সকল নোটিশ তৈরি, পরিচালনা ও বিতরণ করুন</p>
                <div class="notice-hero-badge"><i class="fa-solid fa-bolt"></i> Email ও WhatsApp-এ সরাসরি পাঠান</div>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <div class="notice-hero-stat">
                    <div class="notice-hero-stat-num">{{ $totalNotices }}</div>
                    <div class="notice-hero-stat-label">মোট নোটিশ</div>
                </div>
                <div class="notice-hero-stat">
                    <div class="notice-hero-stat-num">{{ $activeNotices }}</div>
                    <div class="notice-hero-stat-label">সক্রিয়</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- ══ LEFT: CREATE FORM ══ --}}
        <div class="col-lg-4">
            <div class="notice-form-card" style="position: sticky; top: 80px;">
                <div class="notice-form-header">
                    <div class="notice-form-header-icon"><i class="fa-solid fa-plus"></i></div>
                    <div>
                        <p class="notice-form-header-title">নতুন নোটিশ তৈরি করুন</p>
                        <p class="notice-form-header-sub">নোটিশ সব শিক্ষার্থীকে দেখানো হবে</p>
                    </div>
                </div>
                <div class="notice-form-body">
                    <form action="{{ route('notices.store', ['tenant' => $school->slug ?? auth()->user()?->school?->slug]) }}"
                          method="POST" enctype="multipart/form-data" id="noticeCreateForm">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">নোটিশের শিরোনাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" placeholder="যেমন: বার্ষিক পরীক্ষার রুটিন" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notice_date" class="form-label">তারিখ <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="notice_date" name="notice_date"
                                   value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">বিস্তারিত</label>
                            <textarea class="form-control" id="description" name="description"
                                      rows="3" placeholder="নোটিশের বিস্তারিত বিবরণ লিখুন…"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">সংযুক্ত ফাইল (PDF/Image)</label>
                            <div class="notice-file-drop" id="fileDrop">
                                <input type="file" name="file" id="fileInput" accept=".pdf,.jpg,.jpeg,.png"
                                       onchange="updateFileName(this)">
                                <div class="notice-file-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                                <p class="notice-file-text" id="fileLabel">ক্লিক করুন বা ফাইল টেনে আনুন</p>
                                <p class="notice-file-sub">PDF, JPG, PNG — সর্বোচ্চ ২ MB</p>
                            </div>
                            @error('file') <div class="text-danger mt-1" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4 active-check-toggle d-flex align-items-center gap-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label fw-semibold" for="is_active" style="font-size:0.82rem; color:#475569;">ওয়েবসাইটে সক্রিয় রাখুন</label>
                        </div>

                        <button type="submit" class="btn-notice-submit" id="noticeSubmitBtn">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>নোটিশ প্রকাশ করুন</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ RIGHT: NOTICE LIST ══ --}}
        <div class="col-lg-8">
            <div class="notice-list-card">
                <div class="notice-list-header">
                    <h6 class="notice-list-title">
                        <i class="fa-solid fa-list-ul" style="color:#4f46e5;"></i>
                        সকল নোটিশ
                        <span class="notice-count-badge">{{ $totalNotices }}</span>
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:0.72rem; color:#94a3b8;">{{ $notices->currentPage() }}/{{ $notices->lastPage() }} পেজ</span>
                    </div>
                </div>

                @forelse($notices as $notice)
                <div class="notice-item">
                    {{-- Date badge --}}
                    <div class="notice-item-date-badge">
                        <span class="notice-item-date-day">{{ \Carbon\Carbon::parse($notice->notice_date)->format('d') }}</span>
                        <span class="notice-item-date-mon">{{ \Carbon\Carbon::parse($notice->notice_date)->format('M') }}</span>
                    </div>

                    {{-- Body --}}
                    <div class="notice-item-body">
                        <div class="notice-item-title">{{ $notice->title }}</div>
                        @if($notice->description)
                        <p class="notice-item-desc">{{ $notice->description }}</p>
                        @endif
                        <div class="notice-item-tags">
                            @if($notice->is_active)
                                <span class="notice-tag active-tag"><i class="fa-solid fa-circle-check"></i> সক্রিয়</span>
                            @else
                                <span class="notice-tag inactive-tag"><i class="fa-solid fa-circle-xmark"></i> নিষ্ক্রিয়</span>
                            @endif
                            @if($notice->file)
                                <a href="{{ asset($notice->file) }}" target="_blank" class="notice-tag file-tag">
                                    <i class="fa-solid fa-file-arrow-down"></i> ফাইল দেখুন
                                </a>
                            @endif
                            <span style="font-size:0.62rem; color:#94a3b8; margin-left:2px;">
                                <i class="fa-regular fa-clock me-1"></i>{{ $notice->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="notice-item-actions">
                        {{-- Email send --}}
                        <form action="{{ route('notices.send', ['tenant' => auth()->user()->school->slug, 'id' => $notice->id]) }}" method="POST" class="send-form">
                            @csrf
                            <input type="hidden" name="method_type" value="email">
                            <button type="button" onclick="confirmSend(this, 'Email')" class="notice-action-btn email" title="Email পাঠান">
                                <i class="fa-solid fa-envelope"></i>
                            </button>
                        </form>

                        {{-- WhatsApp send --}}
                        <form action="{{ route('notices.send', ['tenant' => auth()->user()->school->slug, 'id' => $notice->id]) }}" method="POST" class="send-form">
                            @csrf
                            <input type="hidden" name="method_type" value="whatsapp">
                            <button type="button" onclick="confirmSend(this, 'WhatsApp')" class="notice-action-btn whatsapp" title="WhatsApp পাঠান">
                                <i class="fa-brands fa-whatsapp"></i>
                            </button>
                        </form>

                        {{-- SMS send --}}
                        <form action="{{ route('notices.send', ['tenant' => auth()->user()->school->slug, 'id' => $notice->id]) }}" method="POST" class="send-form">
                            @csrf
                            <input type="hidden" name="method_type" value="sms">
                            <button type="button" onclick="confirmSend(this, 'SMS')" class="notice-action-btn sms" title="SMS পাঠান">
                                <i class="fa-solid fa-comment-sms"></i>
                            </button>
                        </form>

                        {{-- Edit --}}
                        <a href="{{ route('notices.edit', ['tenant' => auth()->user()->school->slug, 'notice' => $notice->id]) }}"
                           class="notice-action-btn edit" title="সম্পাদনা">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('notices.destroy', ['tenant' => auth()->user()->school->slug, 'notice' => $notice->id]) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete(this)" class="notice-action-btn delete" title="মুছে ফেলুন">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="notice-empty">
                    <div class="notice-empty-icon"><i class="fa-solid fa-bullhorn"></i></div>
                    <p class="notice-empty-title">কোনো নোটিশ নেই</p>
                    <p class="notice-empty-sub">বাম পাশের ফর্ম ব্যবহার করে নতুন নোটিশ তৈরি করুন।</p>
                </div>
                @endforelse

                {{-- Pagination --}}
                @if($notices->hasPages())
                <div class="px-4 py-3 border-top" style="background:#fafbff;">
                    {{ $notices->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
</div>
@endsection

@section('customJs')
<script>
    /* File name preview */
    function updateFileName(input) {
        const label = document.getElementById('fileLabel');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
            label.style.color = '#4f46e5';
        } else {
            label.textContent = 'ক্লিক করুন বা ফাইল টেনে আনুন';
            label.style.color = '';
        }
    }

    /* File drop dragover highlight */
    const dropZone = document.getElementById('fileDrop');
    if (dropZone) {
        dropZone.addEventListener('dragover', () => dropZone.style.borderColor = '#4f46e5');
        dropZone.addEventListener('dragleave', () => dropZone.style.borderColor = '');
        dropZone.addEventListener('drop', () => dropZone.style.borderColor = '');
    }

    /* Submit button loading */
    document.getElementById('noticeCreateForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('noticeSubmitBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> প্রকাশ হচ্ছে…';
        btn.style.opacity = '0.8';
        btn.disabled = true;
    });

    /* Confirm Delete */
    function confirmDelete(button) {
        Swal.fire({
            title: 'নোটিশ মুছবেন?',
            text: 'এই নোটিশটি স্থায়ীভাবে মুছে যাবে এবং পুনরুদ্ধার করা যাবে না।',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> হ্যাঁ, মুছুন',
            cancelButtonText: 'না, থাক',
            borderRadius: '16px',
        }).then((result) => {
            if (result.isConfirmed) button.closest('form').submit();
        });
    }

    /* Confirm Send */
    function confirmSend(button, type) {
        const isEmail = type === 'Email';
        Swal.fire({
            title: type + ' পাঠাবেন?',
            text: 'সকল শিক্ষার্থীর কাছে এই নোটিশটি ' + type + '-এ পাঠানো হবে।',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isEmail ? '#4f46e5' : '#16a34a',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa-solid fa-paper-plane me-1"></i> পাঠান',
            cancelButtonText: 'না, থাক',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: type + ' পাঠানো হচ্ছে…',
                    html: 'অনুগ্রহ করে অপেক্ষা করুন।',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
                button.closest('form').submit();
            }
        });
    }

    /* Session Flash */
    @if(session('success'))
        Swal.close();
        Swal.fire({
            icon: '{{ session('type', 'success') }}',
            title: 'সফল!',
            text: '{{ session('success') }}',
            confirmButtonText: 'ঠিক আছে',
            confirmButtonColor: '#4f46e5',
        });
    @endif
</script>
@endsection