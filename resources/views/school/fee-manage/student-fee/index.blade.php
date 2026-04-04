@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Generate Monthly/One-time Fees</h4>
                    
                    <form action="{{ route('student-fees.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Select Fee Head</label>
                                <select name="fee_head_id" class="form-control" required>
                                    <option value="" disabled selected>-- Choose Fee --</option>
                                    @foreach($feeHeads as $head)
                                        <option value="{{ $head->id }}">{{ $head->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold">Select Month</label>
                                <select name="month" class="form-control" required>
                                    <option value="" disabled selected>-- Choose Month --</option>
                                    @php
                                        for ($i = -3; $i < 9; $i++) {
                                            $m = now()->addMonths($i)->format('F-Y');
                                            echo "<option value='{$m}'>{$m}</option>";
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="fa-solid fa-bolt me-1"></i> Generate Bills Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- History Table --}}
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Recent Generations History</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fee Name</th>
                                    <th>Month</th>
                                    <th>Total Students</th>
                                    <th>Total Expected Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentGenerations as $gen)
                                <tr>
                                    <td>{{ $gen->feeHead->name }}</td>
                                    <td><span class="badge bg-info">{{ $gen->month }}</span></td>
                                    <td>{{ $gen->total_students }}</td>
                                    <td>৳ {{ number_format($gen->total_amount, 2) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary badge view-students-btn" 
                                            data-fee-id="{{ $gen->fee_head_id }}" 
                                            data-month="{{ $gen->month }}">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                        <form class="m-0" action="{{ route('student-fees.destroy', ['tenant' => auth()->user()->school->slug, 'student_fee' => $gen->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger badge" onclick="confirmDelete(this)">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
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
        let currentFeeId = '';
        let currentMonth = '';

        // ভিউ বাটনে ক্লিক ইভেন্ট
        $('.view-students-btn').on('click', function() {
            currentFeeId = $(this).data('fee-id');
            currentMonth = $(this).data('month');
            $('#modalFeeTitle').text(currentMonth);
            
            $('#studentFeeModal').modal('show');
            loadStudentList(); // ডাটা লোড ফাংশন
        });

        // ফিল্টার পরিবর্তন করলে
        $('#modalClassFilter').on('change', function() {
            loadStudentList();
        });

        function loadStudentList() {
    let classId = $('#modalClassFilter').val();
    
    $('#modalTableLoader').removeClass('d-none');
    $('#studentListArea').html(''); // আগের ডাটা ক্লিয়ার করা

    $.ajax({
        url: "{{ route('student-fees.get-list', ['tenant' => auth()->user()->school->slug]) }}",
        method: "GET",
        data: {
            fee_head_id: currentFeeId, // বাটন ক্লিক থেকে পাওয়া আইডি
            month: currentMonth,        // বাটন ক্লিক থেকে পাওয়া মাস
            class_id: classId
        },
        success: function(response) {
            $('#modalTableLoader').addClass('d-none');
            $('#studentListArea').html(response);
        },
        error: function(xhr) {
            $('#modalTableLoader').addClass('d-none');
            // কনসোলে এরর দেখা যাবে (F12 চেপে চেক করুন)
            console.error(xhr.responseText);
            $('#studentListArea').html('<p class="text-danger text-center mt-3">ডাটা লোড করতে সমস্যা হয়েছে। সার্ভার এরর চেক করুন।</p>');
        }
    });
}
    });
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the fee head and may affect related settings!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif
    
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}'
    });
    @endif
</script>
@endsection