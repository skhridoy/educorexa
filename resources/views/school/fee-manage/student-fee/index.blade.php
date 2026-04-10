@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-primary"><i class="fa-solid fa-file-invoice-dollar me-2"></i>Generate Monthly/One-time Fees</h4>
                    
                    <form action="{{ route('student-fees.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-end">
                            {{-- Fee Head Selection --}}
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold">Select Fee Head</label>
                                <select name="fee_head_id" class="form-select border-primary" required>
                                    <option value="" disabled selected>-- Choose Fee --</option>
                                    @foreach($feeHeads as $head)
                                        <option value="{{ $head->id }}">{{ $head->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- School Category Filter (নতুন যুক্ত হয়েছে) --}}
                            <div class="col-md-2">
                                <label class="form-label font-weight-bold">Category</label>
                                <select name="school_category_id" id="school_category_id" class="form-select border-info">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Sub-Category Filter (নতুন যুক্ত হয়েছে - যেমন বিজ্ঞান/মানবিক) --}}
                            <div class="col-md-2">
                                <label class="form-label font-weight-bold">Sub-Category</label>
                                <select name="school_sub_category_id" id="school_sub_category_id" class="form-select">
                                    <option value="">None/All</option>
                                    {{-- Ajax দিয়ে এখানে ডাটা আসবে --}}
                                </select>
                            </div>

                            {{-- Month Selection --}}
                            <div class="col-md-2">
                                <label class="form-label font-weight-bold">Select Month</label>
                                <select name="month" class="form-select border-primary" required>
                                    <option value="" disabled selected>-- Choose Month --</option>
                                    @php
                                        for ($i = -3; $i < 9; $i++) {
                                            $m = now()->addMonths($i)->format('F-Y');
                                            echo "<option value='{$m}'>{$m}</option>";
                                        }
                                    @endphp
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
                                    <i class="fa-solid fa-bolt me-1"></i> Generate Bills Now
                                </button>
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block">নোট: টিউশন ফি সবার জন্য হলে ক্যাটেগরি খালি রাখুন। পরীক্ষার ফি হলে ক্যাটেগরি সিলেক্ট করুন।</small>
                    </form>
                </div>
            </div>
        </div>

        {{-- History Table --}}
        <div class="col-md-12 mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title"><i class="fa-solid fa-clock-rotate-left me-2"></i>Recent Generations History</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Fee Name</th>
                                    <th>Month</th>
                                    <th>Total Students</th>
                                    <th>Total Expected Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentGenerations as $gen)
                                <tr>
                                    <td class="fw-bold">{{ $gen->feeHead->name }}</td>
                                    <td><span class="badge bg-soft-info text-info p-2">{{ $gen->month }}</span></td>
                                    <td>{{ $gen->total_students }}</td>
                                    <td class="text-success fw-bold">৳ {{ number_format($gen->total_amount, 2) }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary view-students-btn" 
                                            data-fee-id="{{ $gen->fee_head_id }}" 
                                            data-month="{{ $gen->month }}">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                        
                                        <form class="m-0" action="{{ route('student-fees.destroy', ['tenant' => auth()->user()->school->slug, 'student_fee' => $gen->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(this)">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ajax fee list -->
        <div class="modal fade" id="studentFeeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">শিক্ষার্থীর ফি তালিকা (<span id="modalFeeTitle"></span>)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Filter by Class</label>
                                <select id="modalClassFilter" class="form-select border-primary">
                                    <option value="">All Classes</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="modalTableLoader" class="text-center d-none">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p>ডাটা লোড হচ্ছে...</p>
                        </div>

                        <div id="studentListArea" class="table-responsive">
                            <p class="text-muted text-center">ভিউ বাটনে ক্লিক করুন।</p>
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
        // ১. ক্যাটেগরি পাল্টালে সাব-ক্যাটেগরি লোড করা
        $('#school_category_id').on('change', function() {
            let categoryId = $(this).val();
            let subCategorySelect = $('#school_sub_category_id');
            
            subCategorySelect.html('<option value="">Loading...</option>');

            if(categoryId) {
                $.ajax({
                    url: "{{ route('get-sub-categories', ['tenant' => auth()->user()->school->slug, 'categoryId' => ':id'])}}".replace(':id', categoryId),
                    method: 'GET',
                    success: function(data) {
                        subCategorySelect.html('<option value="">None/All</option>');
                        $.each(data, function(key, value) {
                            subCategorySelect.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                subCategorySelect.html('<option value="">None/All</option>');
            }
        });

        // ২. ভিউ এবং মোডাল লজিক
        let currentFeeId = '';
        let currentMonth = '';

        $('.view-students-btn').on('click', function() {
            currentFeeId = $(this).data('fee-id');
            currentMonth = $(this).data('month');
            $('#modalFeeTitle').text(currentMonth);
            
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
                    $('#studentListArea').html('<p class="text-danger text-center mt-3">ডাটা লোড করতে সমস্যা হয়েছে।</p>');
                }
            });
        }
    }); // ডক্যুমেন্ট রেডি এখানে শেষ

    // ৩. ডিলিট কনফার্মেশন (এটি ডক্যুমেন্ট রেডির বাইরে রাখা ভালো)
    function confirmDelete(button) {
        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: "এটি এই মাসের সকল অবৈতনিক (Unpaid) ফি ডিলিট করে দেবে!",
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

    // ৪. সাকসেস/এরর মেসেজ
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'সফল!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif
    
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'দুঃখিত!',
        text: '{{ session('error') }}'
    });
    @endif
</script>
@endsection