@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Exact Exam Page Stats Bar */
        .fee-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 20px;
        }
        .fee-stat-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            backdrop-filter: blur(8px);
        }
        .fee-stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
        }
        .fee-stat-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }
        .fee-stat-lbl {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }

        /* Action Buttons (Exact Exam Page Styles) */
        .btn-act {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            font-size: 0.8rem;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-act-view { 
            background: #eff6ff !important; 
            color: #3b82f6 !important; 
            border: 1px solid #bfdbfe !important; 
        }
        .btn-act-view:hover { 
            background: #3b82f6 !important; 
            color: #fff !important; 
            transform: translateY(-1px);
        }
        .btn-act-del { 
            background: #fef2f2 !important; 
            color: #ef4444 !important; 
            border: 1px solid #fecaca !important; 
        }
        .btn-act-del:hover { 
            background: #ef4444 !important; 
            color: #fff !important; 
            transform: translateY(-1px);
        }

        @media (max-width: 991.98px) {
            .fee-stats-bar { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 767.98px) {
            .fee-stats-bar { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .fee-stat-card { padding: 10px 12px; gap: 10px; }
            .fee-stat-icon { width: 36px; height: 36px; font-size: 1.1rem; }
            .fee-stat-val  { font-size: 1.25rem; }
            .fee-stat-lbl  { font-size: 0.7rem; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ═════════════════════════════════════════════════════════════
         HERO HEADER CARD (Matches Exam Page Header Exactly)
    ══════════════════════════════════════════════════════════════ --}}
    <div class="page-header-card">
        <div class="page-header-content">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon">
                        <i class="fa-solid fa-bolt text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ __('Fee Generation (মাসিক ও এককালীন ফি তৈরি)') }}</h4>
                        <p class="page-subtitle mb-0">
                            {{ __('Batch generate fee vouchers & bills for entire classes or specific student categories') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('fee-amounts.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-secondary">
                        <i class="fa-solid fa-sliders"></i> {{ __('Fee Structures') }}
                    </a>
                    <a href="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-primary">
                        <i class="fa-solid fa-hand-holding-dollar"></i> {{ __('Fee Collection') }}
                    </a>
                </div>
            </div>

            {{-- Exact Exam Stats Bar Component --}}
            <div class="fee-stats-bar">
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(59, 130, 246, 0.35);">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $recentGenerations->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('Bill Batches Generated') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(16, 185, 129, 0.35);">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $recentGenerations->sum('total_students') }}</div>
                        <div class="fee-stat-lbl">{{ __('Total Students Billed') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(245, 158, 11, 0.35);">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">৳ {{ number_format($recentGenerations->sum('total_amount'), 0) }}</div>
                        <div class="fee-stat-lbl">{{ __('Total Expected Collection') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         GENERATION FORM CARD
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="form-card">
                <div class="form-card-header d-flex align-items-center justify-content-between">
                    <div class="form-card-title">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6;">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        {{ __('Generate Monthly / Periodical Student Bills') }}
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill" style="font-size: 11.5px;">
                        <i class="fa-solid fa-circle-check me-1"></i> {{ __('Automatic Calculation') }}
                    </span>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('student-fees.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST" id="feeGenerateForm">
                        @csrf
                        <div class="row g-3">
                            {{-- Fee Head Selection --}}
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-bold text-dark small">{{ __('Select Fee Head') }} <span class="text-danger">*</span></label>
                                <select name="fee_head_id" class="form-select form-control-modern" required>
                                    <option value="" disabled selected>{{ __('-- Choose Fee Head --') }}</option>
                                    @foreach($feeHeads as $head)
                                        <option value="{{ $head->id }}">{{ $head->name }} ({{ ucfirst($head->type) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- School Category Filter --}}
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label fw-bold text-dark small">{{ __('Category') }}</label>
                                <select name="school_category_id" id="school_category_id" class="form-select form-control-modern">
                                    <option value="">{{ __('All Categories') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Sub-Category Filter --}}
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label fw-bold text-dark small">{{ __('Sub-Category / Group') }}</label>
                                <select name="school_sub_category_id" id="school_sub_category_id" class="form-select form-control-modern">
                                    <option value="">{{ __('None / All Groups') }}</option>
                                </select>
                            </div>

                            {{-- Class Filter --}}
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label fw-bold text-dark small">{{ __('Class') }}</label>
                                <select name="class_id" id="gen_class_id" class="form-select form-control-modern">
                                    <option value="">{{ __('All Classes') }}</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" data-category-id="{{ $class->school_category_id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Month Selection --}}
                            <div class="col-lg-3 col-md-12">
                                <label class="form-label fw-bold text-dark small">{{ __('Select Month / Period') }} <span class="text-danger">*</span></label>
                                <select name="month" class="form-select form-control-modern" required>
                                    <option value="" disabled selected>{{ __('-- Choose Month --') }}</option>
                                    @php
                                        for ($i = -3; $i < 9; $i++) {
                                            $m = now()->addMonths($i)->format('F-Y');
                                            $selected = ($i === 0) ? 'selected' : '';
                                            echo "<option value='{$m}' {$selected}>{$m}</option>";
                                        }
                                    @endphp
                                </select>
                            </div>

                            <div class="col-12 mt-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="text-muted small d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-circle-info text-primary"></i>
                                    <span>{{ __('নোট: সবার জন্য ফি জেনারেট করতে ক্যাটেগরি ও ক্লাস খালি রাখুন। নির্দিষ্ট কোনো গ্রুপ/ক্লাসের জন্য হলে সেগুলো ফিল্টার করুন।') }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary-gradient px-4 py-2" id="generateSubmitBtn">
                                    <i class="fa-solid fa-bolt me-2"></i> {{ __('Generate Bills Now') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ═════════════════════════════════════════════════════════════
             RECENT GENERATION HISTORY TABLE
        ══════════════════════════════════════════════════════════════ --}}
        <div class="col-12">
            <div class="data-table-card">
                <div class="data-table-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6; width: 34px; height: 34px;">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ __('Recent Bill Generation History') }}</h6>
                            <small class="text-muted">{{ __('Track all generated monthly vouchers and batch status') }}</small>
                        </div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill">
                        {{ $recentGenerations->count() }} {{ __('Batches Created') }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table modern-table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">{{ __('Fee Name') }}</th>
                                <th>{{ __('Billing Period (Month)') }}</th>
                                <th>{{ __('Total Students') }}</th>
                                <th>{{ __('Expected Collection') }}</th>
                                <th class="text-center pe-4" style="width: 120px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentGenerations as $gen)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark fs-14">{{ $gen->feeHead->name }}</div>
                                    <small class="text-muted fs-11">Type: {{ ucfirst($gen->feeHead->type) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill" style="font-size: 11.5px;">
                                        <i class="fa-regular fa-calendar-days me-1"></i> {{ $gen->month }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-13">
                                        {{ $gen->total_students }} <span class="text-muted fw-normal fs-11">{{ __('Students') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-success fs-14">৳ {{ number_format($gen->total_amount, 2) }}</div>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        {{-- View Students Modal Button --}}
                                        <button type="button" class="btn-act btn-act-view view-students-btn"
                                            data-fee-id="{{ $gen->fee_head_id }}" 
                                            data-month="{{ $gen->month }}" title="{{ __('View Student List') }}">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                        
                                        {{-- Delete Button --}}
                                        <form action="{{ route('student-fees.destroy', ['tenant' => auth()->user()->school->slug, 'student_fee' => $gen->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-act btn-act-del" onclick="confirmDelete(this)" title="{{ __('Delete Batch') }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-file-invoice-dollar fs-1 mb-2 opacity-25 text-secondary d-block"></i>
                                    <h6 class="fw-bold">{{ __('No Bill Generations Yet') }}</h6>
                                    <p class="small text-muted mb-0">{{ __('Use the form above to generate bills for students.') }}</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ═════════════════════════════════════════════════════════════
             VIEW STUDENTS MODAL (Modern Styled)
        ══════════════════════════════════════════════════════════════ --}}
        <div class="modal fade" id="studentFeeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <div class="modal-header bg-gradient text-white p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-users-viewfinder text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-white mb-0">{{ __('Bill Details') }}: <span id="modalFeeTitle" class="text-warning"></span></h5>
                                <small class="text-white-50">{{ __('Student bill vouchers generated in this batch') }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-light">
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">{{ __('Filter by Class') }}</label>
                                <select id="modalClassFilter" class="form-select form-control-modern">
                                    <option value="">{{ __('All Classes') }}</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="modalTableLoader" class="text-center py-5 d-none">
                            <div class="spinner-grow text-primary mb-2" role="status"></div>
                            <p class="text-muted fw-semibold">{{ __('Loading student list...') }}</p>
                        </div>

                        <div id="studentListArea" class="bg-white rounded-3 border shadow-sm overflow-hidden" style="border-color: #e2e8f0 !important;">
                            {{-- AJAX Content --}}
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
    $(document).ready(function() {
        // ১. ক্যাটেগরি পাল্টালে সাব-ক্যাটেগরি ও ক্লাস ফিল্টার করা
        $('#school_category_id').on('change', function() {
            let categoryId = $(this).val();
            let subCategorySelect = $('#school_sub_category_id');
            let classSelect = $('#gen_class_id');
            
            subCategorySelect.html('<option value="">Loading...</option>');

            if(categoryId) {
                $.ajax({
                    url: "{{ route('get-sub-categories', ['tenant' => auth()->user()->school->slug, 'categoryId' => ':id'])}}".replace(':id', categoryId),
                    method: 'GET',
                    success: function(data) {
                        subCategorySelect.html('<option value="">{{ __("None / All Groups") }}</option>');
                        $.each(data, function(key, value) {
                            subCategorySelect.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    },
                    error: function() {
                        subCategorySelect.html('<option value="">{{ __("None / All Groups") }}</option>');
                    }
                });

                classSelect.find('option').each(function() {
                    let optCat = $(this).data('category-id');
                    if (!$(this).val() || optCat == categoryId || !optCat) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                classSelect.val('');
            } else {
                subCategorySelect.html('<option value="">{{ __("None / All Groups") }}</option>');
                classSelect.find('option').show();
            }
        });

        // ফর্ম সাবমিট হলে বাটন ডিজেবল করা ও লোডিং দেখানো
        $('#feeGenerateForm').on('submit', function() {
            let btn = $('#generateSubmitBtn');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Generating Bills...');
        });

        // ২. ভিউ এবং মোডাল লজিক
        let currentFeeId = '';
        let currentMonth = '';

        $(document).on('click', '.view-students-btn', function() {
            currentFeeId = $(this).data('fee-id');
            currentMonth = $(this).data('month');
            $('#modalFeeTitle').text(currentMonth);
            
            $('#modalClassFilter').val('');
            $('#studentFeeModal').modal('show');
            loadStudentList(); 
        });

        $('#modalClassFilter').on('change', function() {
            loadStudentList();
        });

        function loadStudentList() {
            let classId = $('#modalClassFilter').val();
            
            $('#modalTableLoader').removeClass('d-none');
            $('#studentListArea').html(''); 

            $.ajax({
                url: "{{ route('student-fees.get-list', ['tenant' => auth()->user()->school->slug]) }}",
                method: "GET",
                data: {
                    fee_head_id: currentFeeId,
                    month: currentMonth,
                    class_id: classId
                },
                success: function(response) {
                    $('#modalTableLoader').addClass('d-none');
                    $('#studentListArea').html(response);
                },
                error: function(xhr) {
                    $('#modalTableLoader').addClass('d-none');
                    console.error(xhr.responseText);
                    $('#studentListArea').html('<p class="text-danger text-center mt-3">{{ __("ডাটা লোড করতে সমস্যা হয়েছে।") }}</p>');
                }
            });
        }
    });

    // ৩. ডিলিট কনফার্মেশন
    function confirmDelete(button) {
        Swal.fire({
            title: '{{ __("আপনি কি নিশ্চিত?") }}',
            text: "{{ __('এটি এই মাসের সকল অবৈতনিক (Unpaid) ফি ডিলিট করে দেবে!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> {{ __("হ্যাঁ, ডিলিট করুন") }}',
            cancelButtonText: '{{ __("বাতিল") }}',
            customClass: {
                confirmButton: 'rounded-pill px-4 py-2',
                cancelButton: 'rounded-pill px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // ৪. সাকসেস/এরর/ওয়ার্নিং মেসেজ
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '{{ __("সফল!") }}',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
    @endif
    
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: '{{ __("দুঃখিত!") }}',
        text: '{{ session('error') }}'
    });
    @endif

    @if(session('warning'))
    Swal.fire({
        icon: 'warning',
        title: '{{ __("সতর্কতা!") }}',
        text: '{{ session('warning') }}'
    });
    @endif

    @if(session('info'))
    Swal.fire({
        icon: 'info',
        title: '{{ __("তথ্য") }}',
        text: '{{ session('info') }}'
    });
    @endif
</script>
@endsection