@extends('layouts.school')
@section('title', 'Edit Notice — ' . $notice->title)

@section('customCSS')
<style>
    .edit-hero {
        background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #059669 100%);
        border-radius: 18px;
        padding: 22px 28px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .edit-hero::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 160px; height: 160px;
        background: rgba(16,185,129,0.12);
        border-radius: 50%;
    }
    .edit-hero-title { font-size: 1.3rem; font-weight: 800; color: #fff; margin: 0 0 3px; letter-spacing: -0.4px; }
    .edit-hero-sub   { font-size: 0.82rem; color: rgba(255,255,255,0.65); margin: 0; }
    .edit-hero-back {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.12); color: #fff !important;
        border: 1px solid rgba(255,255,255,0.25); border-radius: 20px;
        padding: 6px 14px; font-size: 0.76rem; font-weight: 600;
        text-decoration: none; transition: all 0.2s ease;
    }
    .edit-hero-back:hover { background: rgba(255,255,255,0.22); }

    .edit-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(15,23,42,0.06);
        overflow: hidden;
    }
    .edit-card-header {
        background: linear-gradient(135deg, #059669, #10b981);
        padding: 16px 22px;
        display: flex; align-items: center; gap: 12px;
    }
    .edit-card-header-icon {
        width: 38px; height: 38px;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.05rem;
    }
    .edit-card-header-title { color: #fff; font-size: 0.94rem; font-weight: 700; margin: 0; }
    .edit-card-header-sub   { color: rgba(255,255,255,0.72); font-size: 0.73rem; margin: 0; }
    .edit-card-body { padding: 24px; }

    .edit-card-body .form-label { font-size: 0.76rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
    .edit-card-body .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 0.86rem;
        padding: 9px 13px;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .edit-card-body .form-control:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
        background: #fff;
    }
    .current-file-box {
        display: flex; align-items: center; justify-content: space-between;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 9px; padding: 10px 13px; margin-bottom: 8px;
    }
    .current-file-box-label { font-size: 0.78rem; color: #15803d; display: flex; align-items: center; gap: 6px; }
    .notice-file-drop {
        border: 2px dashed #a7f3d0; border-radius: 10px;
        padding: 16px; text-align: center;
        background: #f0fdf4; cursor: pointer;
        transition: all 0.2s ease; position: relative;
    }
    .notice-file-drop:hover { border-color: #10b981; background: #dcfce7; }
    .notice-file-drop input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .notice-file-icon { font-size: 1.3rem; color: #059669; margin-bottom: 4px; }
    .notice-file-text { font-size: 0.76rem; color: #16a34a; font-weight: 600; margin: 0; }
    .notice-file-sub  { font-size: 0.66rem; color: #94a3b8; margin: 0; }

    .active-check-toggle .form-check-input { width: 38px; height: 21px; cursor: pointer; }
    .active-check-toggle .form-check-input:checked { background-color: #10b981; border-color: #10b981; }

    .btn-edit-save {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff !important; border: none; border-radius: 9px;
        padding: 10px 26px; font-size: 0.86rem; font-weight: 700;
        cursor: pointer; box-shadow: 0 3px 10px rgba(16,185,129,0.28);
        transition: all 0.25s ease;
    }
    .btn-edit-save:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16,185,129,0.4); }
    .btn-edit-cancel {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f1f5f9; color: #475569 !important;
        border: 1px solid #e2e8f0; border-radius: 9px;
        padding: 10px 20px; font-size: 0.86rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s ease; text-decoration: none;
    }
    .btn-edit-cancel:hover { background: #e2e8f0; color: #1e293b !important; }

    body.dark-mode .edit-card, [data-bs-theme="dark"] .edit-card { background: #0c1427 !important; border-color: #1a253b !important; }
    body.dark-mode .edit-card-body .form-control, [data-bs-theme="dark"] .edit-card-body .form-control { background: #060c18 !important; border-color: #1a253b !important; color: #f1f5f9 !important; }
</style>
@endsection

@section('content')
<div class="page-content">
<div class="container-fluid px-3 px-md-4">

    {{-- Hero --}}
    <div class="edit-hero mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="edit-hero-title"><i class="fa-solid fa-pen-to-square me-2"></i>নোটিশ সম্পাদনা</h1>
                <p class="edit-hero-sub">নোটিশের তথ্য পরিবর্তন করুন এবং সংরক্ষণ করুন</p>
            </div>
            <a href="{{ route('notices.index', ['tenant' => $school->slug]) }}" class="edit-hero-back">
                <i class="fa-solid fa-arrow-left"></i> সকল নোটিশ
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <div class="edit-card">
                <div class="edit-card-header">
                    <div class="edit-card-header-icon"><i class="fa-solid fa-file-pen"></i></div>
                    <div>
                        <p class="edit-card-header-title">নোটিশ আপডেট ফর্ম</p>
                        <p class="edit-card-header-sub">{{ \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y') }} তারিখের নোটিশ</p>
                    </div>
                </div>
                <div class="edit-card-body">
                    <form action="{{ route('notices.update', ['tenant' => $school->slug, 'notice' => $notice->id]) }}"
                          method="POST" enctype="multipart/form-data" id="editNoticeForm">
                        @csrf @method('PUT')

                        <div class="row g-3 mb-3">
                            <div class="col-sm-8">
                                <label for="title" class="form-label">নোটিশের শিরোনাম <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title', $notice->title) }}"
                                       placeholder="নোটিশের শিরোনাম লিখুন" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="notice_date" class="form-label">তারিখ <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="notice_date" name="notice_date"
                                       value="{{ old('notice_date', $notice->notice_date) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">বিস্তারিত বিবরণ</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                      placeholder="নোটিশের বিবরণ লিখুন…">{{ old('description', $notice->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">সংযুক্ত ফাইল</label>
                            @if($notice->file)
                            <div class="current-file-box">
                                <span class="current-file-box-label">
                                    <i class="fa-solid fa-file-circle-check"></i> বর্তমান ফাইল সংযুক্ত আছে
                                </span>
                                <a href="{{ asset($notice->file) }}" target="_blank"
                                   class="btn btn-sm btn-outline-success rounded-pill py-0 px-2" style="font-size:0.74rem;">
                                    <i class="fa-solid fa-eye me-1"></i> দেখুন
                                </a>
                            </div>
                            @endif
                            <div class="notice-file-drop" id="fileDrop">
                                <input type="file" name="file" id="fileInput" accept=".pdf,.jpg,.jpeg,.png"
                                       onchange="updateFileName(this)">
                                <div class="notice-file-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                                <p class="notice-file-text" id="fileLabel">
                                    {{ $notice->file ? 'নতুন ফাইল দিয়ে প্রতিস্থাপন করতে ক্লিক করুন' : 'ক্লিক করুন বা ড্র্যাগ করুন' }}
                                </p>
                                <p class="notice-file-sub">PDF, JPG, PNG — সর্বোচ্চ ২ MB</p>
                            </div>
                            @error('file') <div class="text-danger mt-1" style="font-size:0.78rem;">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4 active-check-toggle d-flex align-items-center gap-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                   value="1" {{ $notice->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active" style="font-size:0.84rem; color:#475569;">
                                ওয়েবসাইটে সক্রিয় রাখুন (শিক্ষার্থীরা দেখতে পাবে)
                            </label>
                        </div>

                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <a href="{{ route('notices.index', ['tenant' => $school->slug]) }}" class="btn-edit-cancel">
                                <i class="fa-solid fa-xmark"></i> বাতিল
                            </a>
                            <button type="submit" class="btn-edit-save" id="editSaveBtn">
                                <i class="fa-solid fa-floppy-disk"></i> আপডেট সংরক্ষণ করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('customJs')
<script>
    function updateFileName(input) {
        const label = document.getElementById('fileLabel');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
            label.style.color = '#059669';
        } else {
            label.textContent = 'ক্লিক করুন বা ড্র্যাগ করুন';
            label.style.color = '';
        }
    }

    document.getElementById('editNoticeForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('editSaveBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> সংরক্ষণ হচ্ছে…';
        btn.style.opacity = '0.8';
        btn.disabled = true;
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'সফল!',
            text: '{{ session('success') }}',
            confirmButtonText: 'ঠিক আছে',
            confirmButtonColor: '#059669',
        });
    @endif
</script>
@endsection
