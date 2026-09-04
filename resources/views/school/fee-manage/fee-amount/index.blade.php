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

        /* Filter Card Toolbar */
        .fee-filter-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: var(--card-shadow);
        }
        [data-bs-theme="dark"] .fee-filter-card,
        body.dark-mode .fee-filter-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
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
        .btn-act-edit { 
            background: #eff6ff !important; 
            color: #3b82f6 !important; 
            border: 1px solid #bfdbfe !important; 
        }
        .btn-act-edit:hover { 
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

        /* Class-wise fee table input */
        .class-fee-input {
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 700;
            color: #1e293b;
            text-align: right;
            transition: all 0.2s;
        }
        .class-fee-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            outline: none;
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
                        <i class="fa-solid fa-coins text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ __('Fee Structures (ফি স্ট্রাকচার ও রেট নির্ধারণ)') }}</h4>
                        <p class="page-subtitle mb-0">
                            {{ __('Define class-wise and category-wise amount for each fee category') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('fee-heads.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-secondary">
                        <i class="fa-solid fa-tags"></i> {{ __('Manage Fee Heads') }}
                    </a>
                    <a href="{{ route('student-fees.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn-header-primary">
                        <i class="fa-solid fa-bolt"></i> {{ __('Generate Bills') }}
                    </a>
                </div>
            </div>

            {{-- Exact Exam Stats Bar Component --}}
            <div class="fee-stats-bar">
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(59, 130, 246, 0.35);">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $feeAmounts->total() }}</div>
                        <div class="fee-stat-lbl">{{ __('Total Fee Rates') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(16, 185, 129, 0.35);">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $feeHeads->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('Available Fee Heads') }}</div>
                    </div>
                </div>
                <div class="fee-stat-card">
                    <div class="fee-stat-icon" style="background: rgba(245, 158, 11, 0.35);">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="fee-stat-val">{{ $categories->count() }}</div>
                        <div class="fee-stat-lbl">{{ __('School Categories') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         MAIN CONTENT ROW
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row g-4">
        {{-- ── Left: Fee Setup Form ── --}}
        <div class="col-lg-5">
            <div class="form-card sticky-top" style="top: 80px; z-index: 10;">
                <div class="form-card-header">
                    <div class="form-card-title">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6;">
                            <i class="fa-solid fa-plus-circle"></i>
                        </div>
                        {{ __('Setup Category & Class Rates') }}
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                        {{ __('Fee Rates') }}
                    </span>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('fee-amounts.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">{{ __('Select Fee Head') }} <span class="text-danger">*</span></label>
                            <select name="fee_head_id" class="form-select form-control-modern" required>
                                <option value="" disabled selected>{{ __('Choose a Fee Head...') }}</option>
                                @foreach($feeHeads as $head)
                                    <option value="{{ $head->id }}">{{ $head->name }} ({{ ucfirst($head->type) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">{{ __('Category') }} <span class="text-danger">*</span></label>
                                <select id="setup_category_id" name="school_category_id" class="form-select form-control-modern" required>
                                    <option value="">{{ __('Select Category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">{{ __('Sub-Category') }}</label>
                                <select id="setup_sub_category_id" name="school_sub_category_id" class="form-select form-control-modern">
                                    <option value="">{{ __('None / All Groups') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <label class="form-label fw-bold text-dark small mb-0">{{ __('Class-wise Amounts (টাকা)') }}:</label>
                        </div>
                        <div class="border rounded-3 overflow-hidden bg-white shadow-sm mb-4" style="border-color: #e2e8f0 !important;">
                            <div class="table-responsive" style="max-height: 320px;">
                                <table class="table table-sm modern-table align-middle mb-0">
                                    <thead class="bg-light sticky-top" style="z-index: 5;">
                                        <tr>
                                            <th class="ps-3 py-2 text-uppercase fs-11 text-muted">{{ __('Class Name') }}</th>
                                            <th class="pe-3 py-2 text-end text-uppercase fs-11 text-muted" width="150">{{ __('Amount (৳)') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="class_amount_body">
                                        <tr>
                                            <td colspan="2" class="text-center py-5 text-muted small">
                                                <i class="fa-solid fa-layer-group d-block mb-2 fs-4 opacity-50 text-primary"></i>
                                                {{ __('প্রথমে ক্যাটেগরি সিলেক্ট করুন') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold">
                            <i class="fa-solid fa-floppy-disk me-2"></i> {{ __('Save Fee Structure') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Right: Existing Configurations List ── --}}
        <div class="col-lg-7">
            <div class="data-table-card">
                <div class="data-table-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6; width: 34px; height: 34px;">
                            <i class="fa-solid fa-table-list"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ __('Current Fee Configurations') }}</h6>
                            <small class="text-muted">{{ __('All configured rates by head, class & category') }}</small>
                        </div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill">
                        {{ $feeAmounts->total() }} {{ __('Rates Defined') }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table modern-table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">{{ __('Fee Head') }}</th>
                                <th>{{ __('Category / Target') }}</th>
                                <th class="text-end">{{ __('Amount') }}</th>
                                <th class="text-center pe-4" style="width: 110px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeAmounts as $setup)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                        {{ $setup->feeHead->name }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-13">{{ $setup->category->name ?? 'N/A' }}</div>
                                    @if($setup->subCategory)
                                        <div class="text-muted fs-11">{{ $setup->subCategory->name }}</div>
                                    @endif
                                    <span class="badge bg-slate-subtle text-dark border px-2 py-0 mt-1" style="font-size: 10.5px;">
                                        <i class="fa-solid fa-graduation-cap me-1 text-primary"></i>{{ $setup->class->name ?? 'All Classes' }}
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-dark fs-14">
                                    ৳ {{ number_format($setup->amount, 2) }}
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        {{-- Edit Button (Exam style) --}}
                                        <button type="button" class="btn-act btn-act-edit" 
                                                onclick="editFee('{{ $setup->id }}', '{{ $setup->amount }}', '{{ addslashes($setup->feeHead->name) }}')"
                                                title="{{ __('Quick Edit Amount') }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- Delete Button (Exam style) --}}
                                        <form action="{{ route('fee-amounts.destroy', ['tenant' => auth()->user()->school->slug, 'fee_amount' => $setup->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-act btn-act-del" onclick="confirmDelete(this)" title="{{ __('Delete Rate') }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-receipt fs-1 mb-2 opacity-25 text-secondary d-block"></i>
                                    <h6 class="fw-bold">{{ __('No Fee Structure Configured') }}</h6>
                                    <p class="small text-muted mb-0">{{ __('Use the form on the left to set class-wise fee amounts.') }}</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($feeAmounts->hasPages())
                <div class="p-3 border-top d-flex justify-content-center">
                    {{ $feeAmounts->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    $(document).ready(function() {
        // Category change logic
        $('#setup_category_id').on('change', function() {
            let categoryId = $(this).val();
            let subCategorySelect = $('#setup_sub_category_id');
            
            if (categoryId) {
                $.ajax({
                    url: "{{ route('get-sub-categories', ['tenant' => auth()->user()->school->slug, 'categoryId' => ':id']) }}".replace(':id', categoryId),
                    method: 'GET',
                    success: function(data) {
                        subCategorySelect.html('<option value="">{{ __("None / All Groups") }}</option>');
                        $.each(data, function(key, value) {
                            subCategorySelect.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                        loadClassesForSetup(categoryId);
                    }
                });
            } else {
                subCategorySelect.html('<option value="">{{ __("None / All Groups") }}</option>');
                $('#class_amount_body').html('<tr><td colspan="2" class="text-center text-muted py-4">{{ __("প্রথমে ক্যাটেগরি সিলেক্ট করুন") }}</td></tr>');
            }
        });

        // Trigger reload on sub-category or fee head change
        $(document).on('change', '#setup_sub_category_id, select[name="fee_head_id"]', function() {
            let categoryId = $('#setup_category_id').val();
            if (categoryId) {
                loadClassesForSetup(categoryId);
            }
        });
    });

    function loadClassesForSetup(categoryId) {
        let feeHeadId = $('select[name="fee_head_id"]').val();
        let subCategoryId = $('#setup_sub_category_id').val();

        if (!feeHeadId) {
            $('#class_amount_body').html('<tr><td colspan="2" class="text-center text-warning py-4">{{ __("প্রথমে Fee Head সিলেক্ট করুন") }}</td></tr>');
            return;
        }

        $('#class_amount_body').html('<tr><td colspan="2" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div> লোড হচ্ছে...</td></tr>');
        
        $.ajax({
            url: "{{ route('get-classes-by-category', ['tenant' => auth()->user()->school->slug]) }}",
            method: 'GET',
            data: { 
                category_id: categoryId,
                fee_head_id: feeHeadId,
                sub_category_id: subCategoryId
            },
            success: function(response) {
                let html = '';
                let classes = response.classes;
                let existingAmounts = response.existingAmounts; 

                if(classes.length > 0) {
                    $.each(classes, function(key, item) {
                        let amount = (existingAmounts && existingAmounts[item.id] !== undefined) ? existingAmounts[item.id] : '';
                        
                        html += `<tr>
                            <td class="ps-3 py-2 fw-semibold text-dark">${item.name}</td>
                            <td class="pe-3 py-2">
                                <input type="number" name="amounts[${item.id}]" 
                                    value="${amount}" 
                                    class="class-fee-input form-control form-control-sm" 
                                    placeholder="0.00" step="0.01">
                            </td>
                        </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="2" class="text-center text-danger py-4">{{ __("কোনো ক্লাস পাওয়া যায়নি।") }}</td></tr>';
                }
                $('#class_amount_body').html(html);
            }
        });
    }

    // Delete Confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: '{{ __("আপনি কি নিশ্চিত?") }}',
            text: '{{ __("এটি ডিলিট করলে পুনরায় ফিরে পাওয়া যাবে না!") }}',
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

    // Edit Function via SweetAlert
    function editFee(id, amount, headName) {
        Swal.fire({
            title: headName,
            text: '{{ __("নতুন অ্যামাউন্ট লিখুন:") }}',
            input: 'number',
            inputAttributes: {
                step: '0.01'
            },
            inputValue: amount,
            showCancelButton: true,
            confirmButtonText: '{{ __("Update Rate") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#64748b',
            showLoaderOnConfirm: true,
            customClass: {
                confirmButton: 'rounded-pill px-4 py-2',
                cancelButton: 'rounded-pill px-4 py-2'
            },
            preConfirm: (newAmount) => {
                let tenantSlug = "{{ auth()->user()->school->slug }}";
                return $.ajax({
                    url: `/${tenantSlug}/fee-amounts/${id}`,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: 'PUT',
                        amount: newAmount
                    },
                    error: function() {
                        Swal.showValidationMessage(`Update failed!`);
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("Updated!") }}',
                    text: '{{ __("অ্যামাউন্ট আপডেট হয়েছে।") }}',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }
        });
    }

    // Notifications
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', timer: 1500, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session('error') }}' });
    @endif
</script>
@endsection