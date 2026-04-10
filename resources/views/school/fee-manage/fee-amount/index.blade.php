@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row">
        {{-- Fee Setup Form --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title text-primary fw-bold">Set Category-wise Fee Amount</h6>
                    <hr>
                    <form action="{{ route('fee-amounts.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Fee Head</label>
                            <select name="fee_head_id" class="form-select border-primary" required>
                                <option value="" disabled selected>Choose a Fee Head...</option>
                                @foreach($feeHeads as $head)
                                    <option value="{{ $head->id }}">{{ $head->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Category</label>
                                <select id="setup_category_id" name="school_category_id" class="form-select border-info" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sub-Category</label>
                                <select id="setup_sub_category_id" name="school_sub_category_id" class="form-select">
                                    <option value="">None/All</option>
                                </select>
                            </div>
                        </div>

                        <h6 class="mb-3 text-muted fw-bold">Enter Amounts for Classes:</h6>
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-bordered align-middle">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th>Class Name</th>
                                        <th width="150">Amount (৳)</th>
                                    </tr>
                                </thead>
                                <tbody id="class_amount_body">
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">প্রথমে ক্যাটেগরি সিলেক্ট করুন</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 w-100 shadow-sm fw-bold">
                            <i class="fa-solid fa-save me-1"></i> Save Fee Structure
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Existing Setup List --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title fw-bold text-secondary">Current Fee Structures</h6>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Fee Head</th>
                                    <th>Category/Class</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeAmounts as $setup)
                                <tr>
                                    <td><span class="badge bg-soft-primary text-primary">{{ $setup->feeHead->name }}</span></td>
                                    <td>
                                        <small class="d-block fw-bold text-dark">{{ $setup->category->name ?? 'N/A' }} | {{ $setup->subCategory->name ?? '' }}</small>
                                        <small class="text-muted">{{ $setup->class->name ?? 'N/A' }}</small>
                                    </td>
                                    <td class="text-end fw-bold text-primary">৳ {{ number_format($setup->amount, 2) }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Edit Button --}}
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                onclick="editFee('{{ $setup->id }}', '{{ $setup->amount }}', '{{ $setup->feeHead->name }}')">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            {{-- Delete Form --}}
                                            <form action="{{ route('fee-amounts.destroy', ['tenant' => auth()->user()->school->slug, 'fee_amount' => $setup->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No fee setup found yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $feeAmounts->links() }}
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