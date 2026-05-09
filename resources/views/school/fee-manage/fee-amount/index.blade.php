@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .class-fee-input {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 4px 10px;
            font-weight: 600;
            color: var(--text-main);
            transition: all 0.2s;
        }
        .class-fee-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }
        .fee-setup-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .fee-setup-item:last-child { border-bottom: none; }
    </style>
@endsection

@section('content')
<div class="page-content">
    {{-- Modern Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="font-family:'Outfit', sans-serif;">Fee Structures</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('school.dashboard', ['tenant' => auth()->user()->school->slug]) }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Setup Fee Amounts</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        {{-- Fee Setup Form --}}
        <div class="col-md-5">
            <div class="schools-panel h-100">
                <div class="panel-header">
                    <h6 class="panel-title mb-0">Define Category-wise Fees</h6>
                </div>
                <div class="p-4">
                    <form action="{{ route('fee-amounts.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-600">Select Fee Head</label>
                            <select name="fee_head_id" class="form-select" required>
                                <option value="" disabled selected>Choose a Fee Head...</option>
                                @foreach($feeHeads as $head)
                                    <option value="{{ $head->id }}">{{ $head->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Category</label>
                                <select id="setup_category_id" name="school_category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Sub-Category</label>
                                <select id="setup_sub_category_id" name="school_sub_category_id" class="form-select">
                                    <option value="">None/All</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-muted small fw-bold">Class-wise Amounts:</h6>
                        </div>
                        <div class="border rounded bg-light overflow-hidden">
                            <div class="table-responsive" style="max-height: 350px;">
                                <table class="table table-sm table-borderless align-middle mb-0">
                                    <thead class="bg-white border-bottom sticky-top">
                                        <tr>
                                            <th class="ps-3 py-2">Class Name</th>
                                            <th class="pe-3 py-2 text-end" width="140">Amount (৳)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="class_amount_body" class="bg-white">
                                        <tr>
                                            <td colspan="2" class="text-center py-5 text-muted small italic">
                                                <i class="fa-solid fa-layer-group d-block mb-2 opacity-50"></i>
                                                প্রথমে ক্যাটেগরি সিলেক্ট করুন
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 w-100 py-2 fw-bold">
                            <i class="fa-solid fa-save me-2"></i> Save Fee Structure
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Existing Setup List --}}
        <div class="col-md-7">
            <div class="schools-panel h-100">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h6 class="panel-title mb-0">Current Fee Configurations</h6>
                    <div class="search-box">
                        {{-- Optional search can go here --}}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Fee Head</th>
                                <th>Category / Target</th>
                                <th class="text-end">Amount</th>
                                <th class="text-center pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeAmounts as $setup)
                            <tr>
                                <td class="ps-4">
                                    <div class="badge bg-soft-primary text-primary px-2">{{ $setup->feeHead->name }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size:0.85rem;">{{ $setup->category->name ?? 'N/A' }}</div>
                                    @if($setup->subCategory)
                                        <div class="text-muted small">{{ $setup->subCategory->name }}</div>
                                    @endif
                                    <div class="text-indigo small fw-600 mt-1">{{ $setup->class->name ?? 'All Classes' }}</div>
                                </td>
                                <td class="text-end fw-bold text-dark">৳ {{ number_format($setup->amount, 2) }}</td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-icon btn-soft-info" 
                                            onclick="editFee('{{ $setup->id }}', '{{ $setup->amount }}', '{{ $setup->feeHead->name }}')"
                                            title="Quick Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('fee-amounts.destroy', ['tenant' => auth()->user()->school->slug, 'fee_amount' => $setup->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-icon btn-soft-danger" onclick="confirmDelete(this)" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-receipt fa-2x mb-2 opacity-25"></i>
                                    <p class="mb-0">No fee setup found yet.</p>
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
        // ক্যাটেগরি চেঞ্জ লজিক
        $('#setup_category_id').on('change', function() {
            let categoryId = $(this).val();
            let subCategorySelect = $('#setup_sub_category_id');
            
            if (categoryId) {
                // সাব-ক্যাটেগরি লোড
                $.ajax({
                    url: "{{ route('get-sub-categories', ['tenant' => auth()->user()->school->slug, 'categoryId' => ':id']) }}".replace(':id', categoryId),
                    method: 'GET',
                    success: function(data) {
                        subCategorySelect.html('<option value="">None/All</option>');
                        $.each(data, function(key, value) {
                            subCategorySelect.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                        
                        // সাব-ক্যাটেগরি ড্রপডাউন আপডেট হওয়ার পর টেবিল লোড করুন
                        loadClassesForSetup(categoryId);
                    }
                });
            } else {
                subCategorySelect.html('<option value="">None/All</option>');
                $('#class_amount_body').html('<tr><td colspan="2" class="text-center text-muted">প্রথমে ক্যাটেগরি সিলেক্ট করুন</td></tr>');
            }
        });

        // সাব-ক্যাটেগরি বা ফি হেড ম্যানুয়ালি চেঞ্জ করলে টেবিল আপডেট হবে
        $(document).on('change', '#setup_sub_category_id, select[name="fee_head_id"]', function() {
            let categoryId = $('#setup_category_id').val();
            if (categoryId) {
                loadClassesForSetup(categoryId);
            }
        });
    });

    function loadClassesForSetup(categoryId) {
        let feeHeadId = $('select[name="fee_head_id"]').val();
        let subCategoryId = $('#setup_sub_category_id').val(); // এখন সঠিক ভ্যালু পাবে

        if (!feeHeadId) {
            $('#class_amount_body').html('<tr><td colspan="2" class="text-center text-warning">প্রথমে Fee Head সিলেক্ট করুন</td></tr>');
            return;
        }

        $('#class_amount_body').html('<tr><td colspan="2" class="text-center"><div class="spinner-border spinner-border-sm text-primary"></div> লোড হচ্ছে...</td></tr>');
        
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
                            <td>${item.name}</td>
                            <td>
                                <input type="number" name="amounts[${item.id}]" 
                                    value="${amount}" 
                                    class="form-control form-control-sm border-primary" 
                                    placeholder="0.00" step="0.01">
                            </td>
                        </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="2" class="text-center text-danger">কোনো ক্লাস পাওয়া যায়নি।</td></tr>';
                }
                $('#class_amount_body').html(html);
            }
        });
    }

    // Delete Confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: "এটি ডিলিট করলে পুনরায় ফিরে পাওয়া যাবে না!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
            cancelButtonText: 'বাতিল'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }

    // Edit Function via SweetAlert
    function editFee(id, amount, headName) {
        Swal.fire({
            title: headName,
            text: 'নতুন অ্যামাউন্ট লিখুন:',
            input: 'number',
            inputAttributes: {
                step: '0.01'
            },
            inputValue: amount,
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
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
                Swal.fire('Updated!', 'অ্যামাউন্ট আপডেট হয়েছে।', 'success').then(() => {
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