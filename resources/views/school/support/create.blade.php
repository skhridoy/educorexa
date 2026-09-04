@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Preset Chips */
        .preset-chip {
            background: #f1f5f9;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.72rem;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .preset-chip:hover {
            background: #e0e7ff;
            border-color: #818cf8;
            color: #4338ca;
        }

        /* Upload Drop Zone */
        .upload-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            padding: 28px 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s;
        }
        .upload-dropzone:hover {
            border-color: #6366f1;
            background: #eef2ff;
        }
        .upload-dropzone.has-file {
            border-color: #10b981;
            background: #f0fdf4;
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ═════════════════════════════════════════════════════════════
         HERO HEADER CARD
    ══════════════════════════════════════════════════════════════ --}}
    <div class="page-header-card">
        <div class="page-header-content">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon">
                        <i class="fa-solid fa-ticket text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ __('Open New Support Ticket') }}</h4>
                        <p class="page-subtitle mb-0">
                            {{ __('Submit your issue and our technical team will respond within 24 hours') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('school.support.index', ['tenant' => $tenant]) }}" class="btn-header-secondary">
                        <i class="fa-solid fa-arrow-left"></i> {{ __('Back to Tickets') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         TICKET FORM ROW
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row g-4 justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-title">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6;">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        {{ __('New Support Request') }}
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                        <i class="fa-solid fa-shield-halved me-1"></i> {{ __('Secure Ticket') }}
                    </span>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('school.support.store', ['tenant' => $tenant]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Quick Subject Chips --}}
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold d-block mb-1">{{ __('Quick Issue Topics') }}</label>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="preset-chip" onclick="setSubject('Cannot login to admin panel')">🔑 Login Issue</span>
                                <span class="preset-chip" onclick="setSubject('Fee collection not working')">💳 Fee Problem</span>
                                <span class="preset-chip" onclick="setSubject('Report / PDF not generating')">📄 Report Error</span>
                                <span class="preset-chip" onclick="setSubject('Student data import issue')">📤 Import Error</span>
                                <span class="preset-chip" onclick="setSubject('Feature request / suggestion')">💡 Feature Request</span>
                            </div>
                        </div>

                        {{-- Subject & Priority --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label for="subject" class="form-label fw-bold text-dark small">{{ __('Subject / Issue Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="subject" id="subject" class="form-control form-control-modern" 
                                       placeholder="{{ __('Briefly describe the issue...') }}" 
                                       value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="priority" class="form-label fw-bold text-dark small">{{ __('Priority Level') }} <span class="text-danger">*</span></label>
                                <select name="priority" id="priority" class="form-select form-control-modern" required>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low</option>
                                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🔴 High (Urgent)</option>
                                </select>
                                @error('priority')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Message --}}
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold text-dark small">{{ __('Detailed Description') }} <span class="text-danger">*</span></label>
                            <textarea name="message" id="message" class="form-control form-control-modern" rows="7" 
                                      placeholder="{{ __('Describe your issue in detail. Include steps to reproduce, expected vs. actual behavior, etc.') }}"
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- File Attachment --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">{{ __('Attachment (Optional)') }}</label>
                            <div class="upload-dropzone" id="dropzone" onclick="document.getElementById('attachment').click()">
                                <input type="file" name="attachment" id="attachment" class="d-none" onchange="updateFileName(this)">
                                <i class="fa-solid fa-cloud-arrow-up fs-2 text-primary mb-2 d-block"></i>
                                <p class="fw-bold text-dark mb-1">{{ __('Click to upload or drag & drop') }}</p>
                                <p class="text-muted small mb-0">{{ __('PDF, PNG, JPG or DOCX (Max 5MB)') }}</p>
                                <div id="file-name-preview" class="mt-2 fw-bold text-success fs-13"></div>
                            </div>
                        </div>

                        {{-- Helper Info --}}
                        <div class="d-flex align-items-center gap-2 mb-4 p-3 rounded-3" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                            <i class="fa-solid fa-circle-info text-success fs-5"></i>
                            <p class="mb-0 small text-dark">{{ __('Our team typically responds within') }} <strong class="text-success">24 working hours</strong>. {{ __('You will receive updates in this support thread.') }}</p>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('school.support.index', ['tenant' => $tenant]) }}" class="btn btn-light fw-semibold px-4 rounded-3">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-2">
                                <i class="fa-solid fa-paper-plane me-2"></i> {{ __('Submit Support Ticket') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Side Info Cards --}}
        <div class="col-lg-4">
            <div class="data-table-card mb-4">
                <div class="data-table-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #f0fdf4; color: #16a34a; width: 34px; height: 34px;">
                            <i class="fa-solid fa-circle-question"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">{{ __('Tips for Fast Support') }}</h6>
                    </div>
                </div>
                <div class="p-4">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-1 text-primary" style="font-size: 11px;"></i>
                            </div>
                            <p class="mb-0 fs-13 text-muted">{{ __('Use a clear and descriptive subject title') }}</p>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-2 text-primary" style="font-size: 11px;"></i>
                            </div>
                            <p class="mb-0 fs-13 text-muted">{{ __('Attach a screenshot to help us understand faster') }}</p>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-3 text-primary" style="font-size: 11px;"></i>
                            </div>
                            <p class="mb-0 fs-13 text-muted">{{ __('Set priority to High only for critical issues') }}</p>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-4 text-primary" style="font-size: 11px;"></i>
                            </div>
                            <p class="mb-0 fs-13 text-muted">{{ __('Include steps to reproduce the problem') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-table-card">
                <div class="data-table-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #fef3c7; color: #d97706; width: 34px; height: 34px;">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">{{ __('Response Time') }}</h6>
                    </div>
                </div>
                <div class="p-4">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="fs-13 fw-semibold text-danger">🔴 {{ __('High') }}</span>
                            <span class="fs-12 fw-bold text-dark">{{ __('2–6 hours') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="fs-13 fw-semibold text-warning">🟡 {{ __('Medium') }}</span>
                            <span class="fs-12 fw-bold text-dark">{{ __('12–24 hours') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <span class="fs-13 fw-semibold text-success">🟢 {{ __('Low') }}</span>
                            <span class="fs-12 fw-bold text-dark">{{ __('1–3 working days') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function setSubject(text) {
        document.getElementById('subject').value = text;
        document.getElementById('subject').focus();
    }

    function updateFileName(input) {
        const preview = document.getElementById('file-name-preview');
        const dropzone = document.getElementById('dropzone');
        if (input.files && input.files[0]) {
            preview.innerHTML = `<i class="fa-solid fa-file-check me-1"></i> ${input.files[0].name}`;
            dropzone.classList.add('has-file');
        } else {
            preview.innerHTML = '';
            dropzone.classList.remove('has-file');
        }
    }

    @if(session('error'))
    Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session("error") }}' });
    @endif
</script>
@endsection
