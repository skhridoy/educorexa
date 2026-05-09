@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .gen-stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid var(--border-color);
            transition: transform 0.2s;
        }
        .gen-stat-card:hover { transform: translateY(-3px); }
        .gen-stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    {{-- Modern Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1" style="font-family:'Outfit', sans-serif;">Fee Generation</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('school.dashboard', ['tenant' => auth()->user()->school->slug]) }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Generate Bills</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-12">
            <div class="schools-panel">
                <div class="panel-header">
                    <h6 class="panel-title mb-0">Generate Monthly / One-time Fees</h6>
                </div>
                <div class="p-4">
                    <form action="{{ route('student-fees.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-end">
                            {{-- Fee Head Selection --}}
                            <div class="col-md-3">
                                <label class="form-label fw-600">Select Fee Head</label>
                                <select name="fee_head_id" class="form-select" required>
                                    <option value="" disabled selected>-- Choose Fee --</option>
                                    @foreach($feeHeads as $head)
                                        <option value="{{ $head->id }}">{{ $head->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- School Category Filter --}}
                            <div class="col-md-2">
                                <label class="form-label fw-600">Category</label>
                                <select name="school_category_id" id="school_category_id" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Sub-Category Filter --}}
                            <div class="col-md-2">
                                <label class="form-label fw-600">Sub-Category</label>
                                <select name="school_sub_category_id" id="school_sub_category_id" class="form-select">
                                    <option value="">None/All</option>
                                </select>
                            </div>

                            {{-- Month Selection --}}
                            <div class="col-md-2">
                                <label class="form-label fw-600">Select Month</label>
                                <select name="month" class="form-select" required>
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
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                    <i class="fa-solid fa-bolt me-2"></i> Generate Bills Now
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 p-2 bg-light rounded-3 small text-muted">
                            <i class="fa-solid fa-circle-info me-1 text-primary"></i> 
                            নোট: টিউশন ফি সবার জন্য হলে ক্যাটেগরি খালি রাখুন। পরীক্ষার ফি হলে ক্যাটেগরি সিলেক্ট করুন।
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- History Table --}}
        <div class="col-md-12 mt-2">
            <div class="schools-panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h6 class="panel-title mb-0">Recent Bill Generation History</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Fee Name</th>
                                <th>Month</th>
                                <th>Total Students</th>
                                <th>Expected Collection</th>
                                <th class="text-center pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentGenerations as $gen)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $gen->feeHead->name }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-soft-info text-info px-3">{{ $gen->month }}</span>
                                </td>
                                <td>
                                    <div class="fw-600">{{ $gen->total_students }} <span class="text-muted fw-normal small">Students</span></div>
                                </td>
                                <td>
                                    <div class="fw-bold text-success">৳ {{ number_format($gen->total_amount, 2) }}</div>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn-icon-custom btn-action-view view-students-btn"
                                            data-fee-id="{{ $gen->fee_head_id }}" 
                                            data-month="{{ $gen->month }}" title="View List">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                        
                                        <form action="{{ route('student-fees.destroy', ['tenant' => auth()->user()->school->slug, 'student_fee' => $gen->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-icon-custom btn-action-delete" onclick="confirmDelete(this)" title="Delete Generation">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    No generation history found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modern Modal --}}
        <div class="modal fade" id="studentFeeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                    <div class="modal-header bg-dark p-4">
                        <h5 class="modal-title text-white fw-bold" style="font-family:'Outfit', sans-serif;">
                            <i class="fa-solid fa-users-viewfinder me-2"></i> Bill Detail: <span id="modalFeeTitle" class="text-warning"></span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Filter by Class</label>
                                <select id="modalClassFilter" class="form-select">
                                    <option value="">All Classes</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="modalTableLoader" class="text-center py-5 d-none">
                            <div class="spinner-grow text-primary mb-2" role="status"></div>
                            <p class="text-muted">Loading student list...</p>
                        </div>

                        <div id="studentListArea">
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