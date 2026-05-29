@extends('layouts.school')

@section('customCSS')
<style>
/* Modern card and table styling */
.admission-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08);
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}
.admission-card .card-header {
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
/* Premium style for checkbox */
.admission-select:checked {
    background-color: #10b981;
    border-color: #10b981;
}
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="admission-card">
        <div class="card-header text-center my-3">
            <i class="bi bi-clipboard-data"></i> Online Admissions Overview
        </div>
        <div class="card-body">
            
            <!-- Bulk Actions and Filters Bar -->
            <div class="row mb-4 align-items-center g-3" style="background: #fff; padding: 15px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2">
                        <label for="classFilter" class="form-label mb-0 fw-semibold text-secondary" style="white-space: nowrap; font-size: 14px;">
                            <i class="bi bi-funnel text-primary"></i> Class Filter:
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
                
                <div class="col-md-8 text-md-end">
                    <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-3">
                        <div class="form-check select-all-wrapper" style="display:none;">
                            <input class="form-check-input" type="checkbox" id="selectAllPending" style="width: 18px; height: 18px; cursor: pointer; border: 2px solid #cbd5e1;">
                            <label class="form-check-label fw-semibold text-secondary" for="selectAllPending" style="font-size: 14px; cursor: pointer; user-select: none;">
                                Select All Class Students
                            </label>
                        </div>
                        
                        <button type="button" id="bulkApproveBtn" class="btn text-white fw-bold disabled" style="background: linear-gradient(135deg, #10b981, #059669); border: none; border-radius: 20px; padding: 6px 20px; font-size: 13px; box-shadow: 0 4px 6px rgba(16,185,129,0.2); transition: all 0.2s;" data-bs-toggle="modal" data-bs-target="#bulkApproveModal" disabled>
                            <i class="bi bi-check-all me-1"></i> Bulk Approve <span class="badge bg-white text-success rounded-circle ms-1" id="selectedCountBadge">0</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @foreach($admissions as $admission)
                <div class="col-md-4 admission-card-item" data-class-id="{{ $admission->class_id }}" data-status="{{ $admission->status }}">
                    <div class="card h-100 border-0 position-relative" style="background-color: #f3f4f6; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        
                        {{-- Select Checkbox for bulk approval --}}
                        @if($admission->status === 'pending')
                        <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                            <input type="checkbox" class="form-check-input admission-select" value="{{ $admission->id }}" data-class-id="{{ $admission->class_id }}" data-student-name="{{ $admission->name }}" data-class-name="{{ $admission->class->name ?? 'N/A' }}" style="width: 20px; height: 20px; cursor: pointer; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        </div>
                        @endif

                        <div class="card-header border-0 d-flex align-items-center" style="background: linear-gradient(135deg, #5b73e8, #7451d6); padding: 15px 20px;">
                            <img src="{{ $admission->photo ? asset($admission->photo) : asset('images/avatar.png') }}" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
                            <h5 class="mb-0 text-white fw-bold" style="letter-spacing: 0.5px; padding-right: 25px;">#{{ $admission->admission_number }}</h5>
                        </div>
                        <div class="card-body" style="padding: 20px; color: #374151;">
                            <p class="mb-2"><strong style="color: #111827;">Name:</strong> {{ $admission->name }}</p>
                            <p class="mb-2"><strong style="color: #111827;">Year:</strong> {{ $admission->academicYear->name ?? 'N/A' }}</p>
                            <p class="mb-2"><strong style="color: #111827;">Class:</strong> {{ $admission->class->name ?? 'N/A' }}</p>
                            <p class="mb-2"><strong style="color: #111827;">Contact:</strong> {{ $admission->contact_number }}</p>
                            @if($admission->status === 'rejected' && $admission->admin_note)
                                <p class="mb-2"><strong style="color: #ef4444;">Rejection Note:</strong> {{ $admission->admin_note }}</p>
                            @endif
                            <span class="badge 
                                @if($admission->status === 'pending') bg-warning text-dark
                                @elseif($admission->status === 'rejected') bg-danger
                                @else bg-success @endif
                                rounded-pill px-3 py-2">
                                {{ ucfirst($admission->status) }}
                            </span>
                        </div>
                        <div class="card-footer bg-transparent border-top d-flex flex-wrap gap-2 justify-content-center align-items-center" style="padding: 15px 20px; border-color: #e5e7eb !important;">

                            {{-- Approve Button → Modal খুলবে --}}
                            @if($admission->status == 'pending')
                            <button type="button"
                                    class="btn btn-sm text-white border-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#approveModal"
                                    data-admission-id="{{ $admission->id }}"
                                    data-admission-name="{{ $admission->name }}"
                                    data-admission-class="{{ $admission->class->name ?? '' }}"
                                    data-approve-url="{{ route('admissions.approve', ['tenant' => auth()->user()->school->slug, 'admission' => $admission->id]) }}"
                                    style="background-color: #10b981; border-radius: 20px; padding: 5px 15px; font-size: 12px; font-weight:600; box-shadow: 0 2px 4px rgba(16,185,129,0.3);">
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
                                        style="background-color: #f59e0b; border-radius: 20px; padding: 5px 15px; font-size: 12px; font-weight:600; box-shadow: 0 2px 4px rgba(245,158,11,0.3);">
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
                                        style="background-color: #ef4444; border-radius: 20px; padding: 5px 15px; font-size: 12px; font-weight:600; box-shadow: 0 2px 4px rgba(239,68,68,0.3);">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </button>
                            </form>

                            {{-- PDF Button --}}
                            <a href="{{ route('admissions.pdf', ['tenant' => auth()->user()->school->slug, 'id' => $admission->id]) }}"
                               class="btn btn-sm text-white border-0"
                               style="background-color: #6366f1; border-radius: 20px; padding: 5px 15px; font-size: 12px; font-weight:600; box-shadow: 0 2px 4px rgba(99,102,241,0.3);">
                                <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                            </a>

                        </div>
                    </div>
                </div>
                @endforeach
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
                        শিক্ষার্থী <strong id="modal-student-name"></strong> (<span id="modal-student-class"></span>) কে ভর্তি করতে নিচের তথ্য পূরণ করুন।
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
{{-- ======== End Modal ======== --}}

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
                <!-- Hidden inputs for selected admission IDs -->
                <div id="bulk-admission-ids-container"></div>

                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 py-2 px-3 mb-4" style="background: #eff6ff; border-radius: 8px; font-size: 13px;">
                        <i class="bi bi-info-circle me-1"></i>
                        আপনি মোট <strong id="bulk-selected-count">0</strong> জন শিক্ষার্থীকে একসাথে ভর্তি করতে যাচ্ছেন।
                    </div>

                    {{-- Selected Students Names List --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">
                            <i class="bi bi-person-lines-fill me-1 text-primary"></i> নির্বাচিত শিক্ষার্থী সমূহ:
                        </label>
                        <div id="bulk-selected-students-list" class="p-2 border bg-light" style="max-height: 120px; overflow-y: auto; border-radius: 8px; font-size: 13px;">
                            <!-- Dynamically populated -->
                        </div>
                    </div>

                    {{-- Section --}}
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

                    {{-- Category --}}
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

                    {{-- Sub-Category --}}
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
{{-- ======== End Bulk Modal ======== --}}

@endsection

@section('customJs')
<script>
    // Class Filtering and Checkbox logic
    const classFilter = document.getElementById('classFilter');
    const cards = document.querySelectorAll('.admission-card-item');
    const selectAllPending = document.getElementById('selectAllPending');
    const selectAllWrapper = document.querySelector('.select-all-wrapper');
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const selectedCountBadge = document.getElementById('selectedCountBadge');

    // Enable/Disable bulk approve and update UI
    function updateBulkUI() {
        const checkedBoxes = document.querySelectorAll('.admission-select:checked');
        const count = checkedBoxes.length;
        
        selectedCountBadge.textContent = count;
        
        if (count > 0) {
            bulkApproveBtn.classList.remove('disabled');
            bulkApproveBtn.removeAttribute('disabled');
        } else {
            bulkApproveBtn.classList.add('disabled');
            bulkApproveBtn.setAttribute('disabled', 'true');
        }
    }

    if (classFilter) {
        classFilter.addEventListener('change', function () {
            const selectedClass = this.value;
            let visiblePendingCount = 0;

            cards.forEach(card => {
                const cardClassId = card.getAttribute('data-class-id');
                const cardStatus = card.getAttribute('data-status');

                // Filter by Class and make sure we only filter pending ones
                if (!selectedClass || cardClassId === selectedClass) {
                    card.style.display = '';
                    if (cardStatus === 'pending') visiblePendingCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show Select All checkbox only if we have visible pending cards
            if (visiblePendingCount > 0) {
                selectAllWrapper.style.display = 'block';
            } else {
                selectAllWrapper.style.display = 'none';
            }

            // Uncheck "Select All" on filter change
            selectAllPending.checked = false;
        });

        // Trigger change initially to set state
        classFilter.dispatchEvent(new Event('change'));
    }

    // Select All functionality
    if (selectAllPending) {
        selectAllPending.addEventListener('change', function () {
            const checkedState = this.checked;
            const selectedClass = classFilter.value;

            document.querySelectorAll('.admission-select').forEach(checkbox => {
                const card = checkbox.closest('.admission-card-item');
                // Check if card is visible / matches current filter
                if (card && card.style.display !== 'none') {
                    checkbox.checked = checkedState;
                }
            });
            updateBulkUI();
        });
    }

    // Individual checkbox change
    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('admission-select')) {
            updateBulkUI();
            
            // Uncheck Select All if one individual checkbox is unchecked
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
            countLabel.textContent = checkedBoxes.length;

            let classIds = new Set();

            checkedBoxes.forEach(checkbox => {
                const admissionId = checkbox.value;
                const name = checkbox.getAttribute('data-student-name');
                const className = checkbox.getAttribute('data-class-name');
                const classId = checkbox.getAttribute('data-class-id');
                
                classIds.add(classId);

                // Add hidden input
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'admission_ids[]';
                hiddenInput.value = admissionId;
                container.appendChild(hiddenInput);

                // Add to list
                const item = document.createElement('div');
                item.className = 'd-flex justify-content-between border-bottom py-1 align-items-center';
                item.innerHTML = `<span><strong>${name}</strong></span> <span class="badge bg-secondary">${className}</span>`;
                listContainer.appendChild(item);
            });

            // Warn if selecting multiple classes
            if (classIds.size > 1) {
                Swal.fire({
                    title: 'ভিন্ন ভিন্ন ক্লাস নির্বাচিত!',
                    text: 'আপনি ভিন্ন ভিন্ন ক্লাসের শিক্ষার্থী নির্বাচন করেছেন। সব ঠিক থাকলে এগিয়ে যান।',
                    icon: 'info',
                    confirmButtonText: 'ঠিক আছে'
                });
            }

            // Reset bulk modal dropdowns
            document.getElementById('bulk_section_id').value = '';
            document.getElementById('bulk_category_id').value = '';
            filterBulkSubCategories('');
        });
    }

    // Bulk Category change event
    document.getElementById('bulk_category_id').addEventListener('change', function () {
        filterBulkSubCategories(this.value);
    });

    function filterBulkSubCategories(categoryId) {
        const subSelect = document.getElementById('bulk_sub_category_id');
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

    // Approve Modal — admission id ও URL set করা
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

            // Reset dropdowns
            document.getElementById('approve_section_id').value = '';
            document.getElementById('approve_category_id').value = '';
            filterSubCategories('');
        });
    }

    // Category পরিবর্তন হলে Sub-Category filter করা
    document.getElementById('approve_category_id').addEventListener('change', function () {
        filterSubCategories(this.value);
    });

    function filterSubCategories(categoryId) {
        const subSelect = document.getElementById('approve_sub_category_id');
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

    // ডিলিট কনফার্মেশন
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

    // রিজেক্ট কনফার্মেশন (optional note সহ)
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