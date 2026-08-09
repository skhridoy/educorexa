@extends('layouts.school')

@section('customCSS')
<style>
.admission-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08);
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}
.admission-card .card-header-main {
    background: linear-gradient(90deg, #6571ff, #6c5dd3);
    color: #fff;
    font-weight: 600;
    font-size: 1.25rem;
    padding: 1rem 1.5rem;
}
.admission-table th {
    background: #f1f3f5;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}
.admission-table td, .admission-table th {
    vertical-align: middle;
    text-align: center;
    padding: 0.75rem;
}
.admission-table img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.btn-primary {
    background: linear-gradient(45deg, #6571ff, #6c5dd3);
    border: none;
    transition: transform 0.2s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.admission-select:checked {
    background-color: #10b981;
    border-color: #10b981;
}

/* Settings Control Card */
.settings-panel {
    background: #ffffff;
    border-radius: 14px;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    padding: 20px 24px;
    margin-bottom: 24px;
}
.status-toggle-label {
    font-weight: 700;
    font-size: 0.95rem;
}
.status-pill-open {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
    padding: 4px 14px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.8rem;
}
.status-pill-closed {
    background: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fca5a5;
    padding: 4px 14px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.8rem;
}
</style>
@endsection

@section('content')
@php
    $currentSchool = app('currentSchool');
    $isAdmissionOpen = $currentSchool->is_admission_open ?? true;
    $closedMsg = $currentSchool->admission_closed_message ?? '';
    $closeDate = $currentSchool->admission_close_date ? \Carbon\Carbon::parse($currentSchool->admission_close_date)->format('Y-m-d\TH:i') : '';
    $selectedYearId = $currentSchool->admission_academic_year_id ?? '';
    $currentYearName = $currentSchool->admissionAcademicYear?->name 
        ?? \App\Models\AcademicYear::where('school_id', $currentSchool->id)->where('is_active', 1)->value('name') 
        ?? date('Y');
@endphp

<div class="container py-4">

    {{-- ══════════════════════════════════════════════
         ADMISSION CONTROL & SETTINGS PANEL
    ══════════════════════════════════════════════ --}}
    <div class="settings-panel">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-3 border-bottom">
            <div>
                <h5 class="mb-1 fw-bold text-dark">
                    <i class="bi bi-gear-fill text-primary me-2"></i>অনলাইন অ্যাডমিশন কন্ট্রোল ও সেটিংস
                </h5>
                <p class="text-muted small mb-0">
                    ভর্তি খোলা/বন্ধ করা, ভর্তির নির্ধারিত শিক্ষাবর্ষ (Session), সময়সীমা ও মেসেজ কাস্টমাইজ করুন।
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="badge bg-indigo-100 text-primary border border-primary-subtle px-3 py-2 fw-bold" style="border-radius:20px; font-size:0.82rem;">
                    <i class="bi bi-calendar-event me-1"></i>ভর্তি সেশন: {{ $currentYearName }}
                </span>
                @if($isAdmissionOpen)
                    <span class="status-pill-open"><i class="bi bi-door-open-fill me-1"></i>ভর্তি খোলা রয়েছে (OPEN)</span>
                @else
                    <span class="status-pill-closed"><i class="bi bi-door-closed-fill me-1"></i>ভর্তি বন্ধ রয়েছে (CLOSED)</span>
                @endif
            </div>
        </div>

        <form action="{{ route('admissions.updateSettings', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
            @csrf
            <div class="row g-3">
                {{-- Row 1: Status, Session, Deadline --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary small">ভর্তি স্ট্যাটাস (Status)</label>
                    <select name="is_admission_open" class="form-select fw-bold">
                        <option value="1" {{ $isAdmissionOpen ? 'selected' : '' }} class="text-success">
                            🟢 Admission Open (খোলা)
                        </option>
                        <option value="0" {{ !$isAdmissionOpen ? 'selected' : '' }} class="text-danger">
                            🔴 Admission Closed (বন্ধ)
                        </option>
                    </select>
                </div>

                <div class="col-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-semibold text-secondary small mb-0">
                            ভর্তির শিক্ষাবর্ষ (Admission Session)
                        </label>
                        <a href="{{ route('academic-year.index', ['tenant' => auth()->user()->school->slug]) }}" class="small text-primary text-decoration-none fw-bold" title="নতুন সেশন তৈরি করুন" target="_blank">
                            <i class="bi bi-plus-circle-fill me-1"></i>নতুন সেশন
                        </a>
                    </div>
                    <select name="admission_academic_year_id" class="form-select fw-bold">
                        <option value="">-- স্বয়ংক্রিয় (রানিং একটিভ সেশন) --</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                                সেশন: {{ $year->name }} @if($year->is_active) (রানিং একটিভ) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-semibold text-secondary small">ভর্তি শেষের তারিখ/সময় (Deadline)</label>
                    <input type="datetime-local" name="admission_close_date" class="form-control" value="{{ $closeDate }}" />
                </div>

                {{-- Row 2: Message & Save --}}
                <div class="col-md-9">
                    <label class="form-label fw-semibold text-secondary small">ভর্তি বন্ধ হলে দেখানোর বার্তা (Notice Message)</label>
                    <input type="text" name="admission_closed_message" class="form-control" value="{{ $closedMsg }}" placeholder="যেমন: অনলাইন ভর্তি কার্যক্রম বর্তমানে বন্ধ রয়েছে।" />
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-save me-1"></i>সেটিংস সেভ করুন
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ══════════════════════════════════════════════
         MAIN ADMISSIONS OVERVIEW CARD
    ══════════════════════════════════════════════ --}}
    <div class="admission-card">
        <div class="card-header-main text-center">
            <i class="bi bi-clipboard-data"></i> Online Admissions Overview &amp; History
        </div>
        <div class="card-body">
            
            <!-- Bulk Actions, Search Filter, and Class Filter Bar -->
            <div class="row mb-4 align-items-center g-3" style="background: #fff; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                
                {{-- Phone / Name Search Filter --}}
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-primary"></i></span>
                        <input type="text" id="phoneSearchInput" class="form-control border-0 bg-light" placeholder="ফোন নম্বর বা নাম দিয়ে খুঁজুন..." style="font-size: 14px;">
                    </div>
                </div>

                {{-- Class Filter --}}
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <label for="classFilter" class="form-label mb-0 fw-semibold text-secondary" style="white-space: nowrap; font-size: 14px;">
                            <i class="bi bi-funnel text-primary"></i> Class:
                        </label>
                        <select id="classFilter" class="form-select border-0 bg-light" style="border-radius: 8px; font-size: 14px;">
                            <option value="">All Classes</option>
                            @php
                                $uniqueClasses = $admissions->pluck('class')->unique('id')->filter();
                            @endphp
                            @foreach($uniqueClasses as $cls)
                                <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="col-md-2">
                    <select id="statusFilter" class="form-select border-0 bg-light" style="border-radius: 8px; font-size: 14px;">
                        <option value="">All Status</option>
                        <option value="pending" selected>Pending</option>
                        <option value="approved">Approved (History)</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                
                {{-- Bulk Action Button --}}
                <div class="col-md-3 text-md-end">
                    <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                        <div class="form-check select-all-wrapper me-2" style="display:none;">
                            <input class="form-check-input" type="checkbox" id="selectAllPending" style="width: 18px; height: 18px; cursor: pointer; border: 2px solid #cbd5e1;">
                            <label class="form-check-label fw-semibold text-secondary" for="selectAllPending" style="font-size: 13px; cursor: pointer; user-select: none;">
                                Select All
                            </label>
                        </div>
                        
                        <button type="button" id="bulkApproveBtn" class="btn text-white fw-bold disabled" style="background: linear-gradient(135deg, #10b981, #059669); border: none; border-radius: 20px; padding: 6px 18px; font-size: 13px; box-shadow: 0 4px 6px rgba(16,185,129,0.2);" data-bs-toggle="modal" data-bs-target="#bulkApproveModal" disabled>
                            <i class="bi bi-check-all me-1"></i> Bulk Approve <span class="badge bg-white text-success rounded-circle ms-1" id="selectedCountBadge">0</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row g-4" id="admissionsContainer">
                @forelse($admissions as $admission)
                <div class="col-md-4 admission-card-item" 
                     data-class-id="{{ $admission->class_id }}" 
                     data-status="{{ $admission->status }}"
                     data-phone="{{ strtolower($admission->contact_number) }}"
                     data-name="{{ strtolower($admission->name) }}">
                    <div class="card h-100 border-0 position-relative" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);">
                        
                        {{-- Select Checkbox for bulk approval --}}
                        @if($admission->status === 'pending')
                        <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                            <input type="checkbox" class="form-check-input admission-select" value="{{ $admission->id }}" data-class-id="{{ $admission->class_id }}" data-student-name="{{ $admission->name }}" data-class-name="{{ $admission->class->name ?? 'N/A' }}" style="width: 20px; height: 20px; cursor: pointer; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        </div>
                        @endif

                        <div class="card-header border-0 d-flex align-items-center" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); padding: 14px 18px;">
                            <img src="{{ $admission->photo ? asset($admission->photo) : asset('images/avatar.png') }}" class="rounded-circle me-3" style="width: 42px; height: 42px; object-fit: cover; border: 2px solid rgba(255,255,255,0.4);">
                            <div>
                                <h6 class="mb-0 text-white fw-bold" style="letter-spacing: 0.5px;">#{{ $admission->admission_number }}</h6>
                                <small class="text-white-50" style="font-size: 0.72rem;">Ref ID: {{ $admission->id }}</small>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 18px; color: #374151;">
                            <p class="mb-1"><strong style="color: #0f172a;">Name:</strong> {{ $admission->name }}</p>
                            <p class="mb-1"><strong style="color: #0f172a;">Year:</strong> {{ $admission->academicYear->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong style="color: #0f172a;">Class:</strong> {{ $admission->class->name ?? 'N/A' }}</p>
                            <p class="mb-2"><strong style="color: #0f172a;">Contact:</strong> {{ $admission->contact_number }}</p>
                            
                            @if($admission->status === 'rejected' && $admission->admin_note)
                                <p class="mb-2 text-danger small"><strong class="text-danger">Note:</strong> {{ $admission->admin_note }}</p>
                            @endif

                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <span class="badge 
                                    @if($admission->status === 'pending') bg-warning text-dark
                                    @elseif($admission->status === 'rejected') bg-danger
                                    @else bg-success @endif
                                    rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                    @if($admission->status === 'approved')
                                        <i class="bi bi-check-circle me-1"></i>Approved (History)
                                    @else
                                        {{ ucfirst($admission->status) }}
                                    @endif
                                </span>
                                <small class="text-muted" style="font-size: 0.72rem;">{{ $admission->created_at ? $admission->created_at->format('d M, Y') : '' }}</small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top d-flex flex-wrap gap-2 justify-content-center align-items-center" style="padding: 12px 16px; border-color: #f1f5f9 !important;">

                            {{-- Approve Button --}}
                            @if($admission->status == 'pending')
                            <button type="button"
                                    class="btn btn-sm text-white border-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#approveModal"
                                    data-admission-id="{{ $admission->id }}"
                                    data-admission-name="{{ $admission->name }}"
                                    data-admission-class="{{ $admission->class->name ?? '' }}"
                                    data-approve-url="{{ route('admissions.approve', ['tenant' => auth()->user()->school->slug, 'admission' => $admission->id]) }}"
                                    style="background-color: #10b981; border-radius: 20px; padding: 4px 14px; font-size: 12px; font-weight:600;">
                                <i class="bi bi-check-circle me-1"></i>Approve
                            </button>
                            @endif

                            {{-- Reject Button --}}
                            @if($admission->status == 'pending')
                            <form id="reject-form-{{ $admission->id }}"
                                  action="{{ route('admissions.reject', ['tenant' => auth()->user()->school->slug, 'admission' => $admission->id]) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="admin_note" id="reject-note-{{ $admission->id }}" value="">
                                <button type="button"
                                        class="btn btn-sm text-white border-0"
                                        onclick="confirmReject({{ $admission->id }})"
                                        style="background-color: #f59e0b; border-radius: 20px; padding: 4px 14px; font-size: 12px; font-weight:600;">
                                    <i class="bi bi-x-circle me-1"></i>Reject
                                </button>
                            </form>
                            @endif

                            {{-- Delete Button --}}
                            <form id="delete-form-{{ $admission->id }}"
                                  action="{{ route('admissions.destroy', ['tenant' => auth()->user()->school->slug, 'admission' => $admission->id]) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="btn btn-sm text-white border-0"
                                        onclick="confirmDelete({{ $admission->id }})"
                                        style="background-color: #ef4444; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight:600;">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </button>
                            </form>

                            {{-- PDF Button --}}
                            <a href="{{ route('admissions.pdf', ['tenant' => auth()->user()->school->slug, 'id' => $admission->id]) }}"
                               class="btn btn-sm text-white border-0"
                               style="background-color: #6366f1; border-radius: 20px; padding: 4px 14px; font-size: 12px; font-weight:600;">
                                <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                            </a>

                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="bi bi-inbox fa-3x mb-2 d-block text-secondary"></i>
                    No admission applications found.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ======== Approve Modal ======== --}}
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #10b981, #059669); padding: 1.25rem 1.5rem;">
                <h5 class="modal-title text-white fw-bold" id="approveModalLabel">
                    <i class="bi bi-person-check-fill me-2"></i>Approve Admission
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 py-2 px-3 mb-4" style="background: #eff6ff; border-radius: 8px; font-size: 13px;">
                        <i class="bi bi-info-circle me-1"></i>
                        শিক্ষার্থী <strong id="modal-student-name"></strong> (<span id="modal-student-class"></span>) কে ভর্তি করতে নিচের তথ্য পূরণ করুন। (অ্যাডমিশন ডাটা হিস্ট্রি হিসেবে সংরক্ষিত থাকবে)
                    </div>

                    {{-- Section --}}
                    <div class="mb-3">
                        <label for="approve_section_id" class="form-label fw-semibold">
                            <i class="bi bi-diagram-3 me-1 text-primary"></i>শাখা (Section) <span class="text-danger">*</span>
                        </label>
                        <select name="section_id" id="approve_section_id" class="form-select" required>
                            <option value="">-- Section নির্বাচন করুন --</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="mb-3">
                        <label for="approve_category_id" class="form-label fw-semibold">
                            <i class="bi bi-tag me-1 text-warning"></i>ক্যাটেগরি (Category)
                        </label>
                        <select name="school_category_id" id="approve_category_id" class="form-select">
                            <option value="">-- Category নির্বাচন করুন (ঐচ্ছিক) --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sub-Category --}}
                    <div class="mb-3">
                        <label for="approve_sub_category_id" class="form-label fw-semibold">
                            <i class="bi bi-tags me-1 text-info"></i>সাব ক্যাটেগরি (Sub-Category)
                        </label>
                        <select name="school_sub_category_id" id="approve_sub_category_id" class="form-select">
                            <option value="">-- Sub-Category নির্বাচন করুন (ঐচ্ছিক) --</option>
                            @foreach($subCategories as $sub)
                                <option value="{{ $sub->id }}" data-category="{{ $sub->school_category_id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>বাতিল
                    </button>
                    <button type="submit" class="btn text-white rounded-pill px-4 fw-semibold" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="bi bi-check-circle me-1"></i>ভর্তি নিশ্চিত করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ======== Bulk Approve Modal ======== --}}
<div class="modal fade" id="bulkApproveModal" tabindex="-1" aria-labelledby="bulkApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #10b981, #059669); padding: 1.25rem 1.5rem;">
                <h5 class="modal-title text-white fw-bold" id="bulkApproveModalLabel">
                    <i class="bi bi-people-fill me-2"></i>Bulk Approve Admissions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admissions.bulk-approve', ['tenant' => auth()->user()->school->slug]) }}" method="POST" id="bulkApproveForm">
                @csrf
                <div id="bulk-admission-ids-container"></div>

                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 py-2 px-3 mb-4" style="background: #eff6ff; border-radius: 8px; font-size: 13px;">
                        <i class="bi bi-info-circle me-1"></i>
                        আপনি মোট <strong id="bulk-selected-count">0</strong> জন শিক্ষার্থীকে একসাথে ভর্তি করতে যাচ্ছেন। (অ্যাডমিশন ডাটা হিস্ট্রি হিসেবে থাকবে)
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">
                            <i class="bi bi-person-lines-fill me-1 text-primary"></i> নির্বাচিত শিক্ষার্থী সমূহ:
                        </label>
                        <div id="bulk-selected-students-list" class="p-2 border bg-light" style="max-height: 120px; overflow-y: auto; border-radius: 8px; font-size: 13px;"></div>
                    </div>

                    <div class="mb-3">
                        <label for="bulk_section_id" class="form-label fw-semibold">
                            <i class="bi bi-diagram-3 me-1 text-primary"></i>শাখা (Section) <span class="text-danger">*</span>
                        </label>
                        <select name="section_id" id="bulk_section_id" class="form-select" required>
                            <option value="">-- Section নির্বাচন করুন --</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bulk_category_id" class="form-label fw-semibold">
                            <i class="bi bi-tag me-1 text-warning"></i>ক্যাটেগরি (Category)
                        </label>
                        <select name="school_category_id" id="bulk_category_id" class="form-select">
                            <option value="">-- Category নির্বাচন করুন (ঐচ্ছিক) --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bulk_sub_category_id" class="form-label fw-semibold">
                            <i class="bi bi-tags me-1 text-info"></i>সাব ক্যাটেগরি (Sub-Category)
                        </label>
                        <select name="school_sub_category_id" id="bulk_sub_category_id" class="form-select">
                            <option value="">-- Sub-Category নির্বাচন করুন (ঐচ্ছিক) --</option>
                            @foreach($subCategories as $sub)
                                <option value="{{ $sub->id }}" data-category="{{ $sub->school_category_id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>বাতিল
                    </button>
                    <button type="submit" class="btn text-white rounded-pill px-4 fw-semibold" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="bi bi-check-all me-1"></i>সব ভর্তি নিশ্চিত করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('customJs')
<script>
    // Filtering Logic (Class, Status, Phone/Name Search)
    const classFilter = document.getElementById('classFilter');
    const statusFilter = document.getElementById('statusFilter');
    const phoneSearchInput = document.getElementById('phoneSearchInput');
    const selectAllWrapper = document.querySelector('.select-all-wrapper');
    const selectAllPending = document.getElementById('selectAllPending');

    function applyFilters() {
        const selectedClass = classFilter ? classFilter.value : '';
        const selectedStatus = statusFilter ? statusFilter.value : '';
        const searchQuery = phoneSearchInput ? phoneSearchInput.value.trim().toLowerCase() : '';

        document.querySelectorAll('.admission-card-item').forEach(card => {
            const cardClassId = card.getAttribute('data-class-id');
            const cardStatus = card.getAttribute('data-status');
            const cardPhone = card.getAttribute('data-phone') || '';
            const cardName = card.getAttribute('data-name') || '';

            const matchClass = !selectedClass || cardClassId === selectedClass;
            const matchStatus = !selectedStatus || cardStatus === selectedStatus;
            const matchSearch = !searchQuery || cardPhone.includes(searchQuery) || cardName.includes(searchQuery);

            if (matchClass && matchStatus && matchSearch) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide select-all checkbox
        if (selectAllWrapper) {
            if (selectedClass && selectedStatus === 'pending') {
                selectAllWrapper.style.display = 'inline-block';
            } else {
                selectAllWrapper.style.display = 'none';
            }
        }
        if (selectAllPending) selectAllPending.checked = false;
        updateBulkUI();
    }

    if (classFilter) classFilter.addEventListener('change', applyFilters);
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    if (phoneSearchInput) phoneSearchInput.addEventListener('input', applyFilters);

    // Initial filter apply
    applyFilters();

    function updateBulkUI() {
        const checkedBoxes = document.querySelectorAll('.admission-select:checked');
        const bulkBtn = document.getElementById('bulkApproveBtn');
        const badge = document.getElementById('selectedCountBadge');

        if (badge) badge.textContent = checkedBoxes.length;

        if (bulkBtn) {
            if (checkedBoxes.length > 0) {
                bulkBtn.classList.remove('disabled');
                bulkBtn.removeAttribute('disabled');
            } else {
                bulkBtn.classList.add('disabled');
                bulkBtn.setAttribute('disabled', 'disabled');
            }
        }
    }

    // Select All functionality
    if (selectAllPending) {
        selectAllPending.addEventListener('change', function () {
            const checkedState = this.checked;
            document.querySelectorAll('.admission-select').forEach(checkbox => {
                const card = checkbox.closest('.admission-card-item');
                if (card && card.style.display !== 'none') {
                    checkbox.checked = checkedState;
                }
            });
            updateBulkUI();
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('admission-select')) {
            updateBulkUI();
            if (!e.target.checked && selectAllPending) {
                selectAllPending.checked = false;
            }
        }
    });

    // Populate Bulk Approve Modal
    const bulkApproveModal = document.getElementById('bulkApproveModal');
    if (bulkApproveModal) {
        bulkApproveModal.addEventListener('show.bs.modal', function () {
            const checkedBoxes = document.querySelectorAll('.admission-select:checked');
            const container = document.getElementById('bulk-admission-ids-container');
            const listContainer = document.getElementById('bulk-selected-students-list');
            const countLabel = document.getElementById('bulk-selected-count');

            container.innerHTML = '';
            listContainer.innerHTML = '';
            if (countLabel) countLabel.textContent = checkedBoxes.length;

            checkedBoxes.forEach(checkbox => {
                const admissionId = checkbox.value;
                const name = checkbox.getAttribute('data-student-name');
                const className = checkbox.getAttribute('data-class-name');
                
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'admission_ids[]';
                hiddenInput.value = admissionId;
                container.appendChild(hiddenInput);

                const item = document.createElement('div');
                item.className = 'd-flex justify-content-between border-bottom py-1 align-items-center';
                item.innerHTML = `<span><strong>${name}</strong></span> <span class="badge bg-secondary">${className}</span>`;
                listContainer.appendChild(item);
            });

            document.getElementById('bulk_section_id').value = '';
            document.getElementById('bulk_category_id').value = '';
            filterBulkSubCategories('');
        });
    }

    document.getElementById('bulk_category_id')?.addEventListener('change', function () {
        filterBulkSubCategories(this.value);
    });

    function filterBulkSubCategories(categoryId) {
        const subSelect = document.getElementById('bulk_sub_category_id');
        if (!subSelect) return;
        const options   = subSelect.querySelectorAll('option[data-category]');
        subSelect.value = '';
        options.forEach(opt => {
            if (!categoryId || opt.getAttribute('data-category') == categoryId) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });
    }

    // Approve Modal handler
    const approveModal = document.getElementById('approveModal');
    if (approveModal) {
        approveModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            const url     = btn.getAttribute('data-approve-url');
            const name    = btn.getAttribute('data-admission-name');
            const cls     = btn.getAttribute('data-admission-class');

            document.getElementById('approveForm').setAttribute('action', url);
            document.getElementById('modal-student-name').textContent = name;
            document.getElementById('modal-student-class').textContent = cls;

            document.getElementById('approve_section_id').value = '';
            document.getElementById('approve_category_id').value = '';
            filterSubCategories('');
        });
    }

    document.getElementById('approve_category_id')?.addEventListener('change', function () {
        filterSubCategories(this.value);
    });

    function filterSubCategories(categoryId) {
        const subSelect = document.getElementById('approve_sub_category_id');
        if (!subSelect) return;
        const options   = subSelect.querySelectorAll('option[data-category]');
        subSelect.value = '';
        options.forEach(opt => {
            if (!categoryId || opt.getAttribute('data-category') == categoryId) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This admission record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function confirmReject(id) {
        Swal.fire({
            title: 'Reject Admission?',
            text: 'You may add a rejection note (optional):',
            input: 'textarea',
            inputPlaceholder: 'Enter rejection reason (optional)...',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Reject!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reject-note-' + id).value = result.value || '';
                document.getElementById('reject-form-' + id).submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false,
    });
    @endif
</script>
@endsection