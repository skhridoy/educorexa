@extends('layouts.school')
@section('customCSS')
    <style>
        .bg-soft-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .table td {
            vertical-align: middle;
            padding: 10px 15px;
        }
    </style>
@endsection
@section('content')

    <div class="page-content">
        <div class="row">
            <div class="col-md-8">

                <div class="card">
        
                    <div class="card-body">
        
                        <div class="d-flex justify-content-between mb-4">
        
                            <h4>Take Student Attendance</h4>
        
                            <h5>{{ date('d M Y') }}</h5>
        
                        </div>
        
                        {{-- FILTER FORM --}}
        
                        <form method="GET">
        
                            <div class="row">
        
                                <div class="col-md-3">
        
                                    <label class="form-label">Class</label>
        
                                    <select name="class_id" class="form-control">
        
                                        <option value="">Select Class</option>
        
                                        @foreach($assignedClasses->unique('class_id') as $item)
        
                                            <option value="{{$item->class_id}}" {{ request('class_id') == $item->class_id ? 'selected' : '' }}>
        
                                                {{$item->class->name ?? ''}}
        
                                            </option>
        
                                        @endforeach
        
                                    </select>
        
                                </div>
        
                                <div class="col-md-3">
        
                                    <label class="form-label">Section</label>
        
                                    <select name="section_id" class="form-control">
        
                                        <option value="">Select Section</option>
        
                                        @foreach($assignedClasses->unique('section_id') as $item)
        
                                            <option value="{{$item->section_id}}" {{ request('section_id') == $item->section_id ? 'selected' : '' }}>
        
                                                {{$item->section->name ?? ''}}
        
                                            </option>
        
                                        @endforeach
        
                                    </select>
        
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="attendance_date">Attendance Date</label>
                                    <input type="date" name="date" id="attendance_date" 
                                        class="form-control" 
                                        value="{{ request('date') ?? date('Y-m-d') }}">
                                </div>
        
                                <div class="col-md-3 my-1">
        
                                    <button class="btn btn-primary mt-4 form-control">Filter</button>
        
                                </div>
        
                            </div>
        
                        </form>
        
                        @if(isset($attendanceInfo))
                            <div class="alert alert-info mt-4 border-start border-info border-4">
                                <div class="d-flex align-items-center">
                                    <i class="me-3" data-feather="check-circle"></i>
                                    <div>
                                        <h5 class="mb-1">এই ক্লাসের হাজিরা ইতিমধ্যে নেওয়া হয়েছে!</h5>
                                        <p class="mb-0">
                                            <strong>ক্লাস:</strong> {{ $attendanceInfo->class->name ?? '' }} | 
                                            <strong>সেকশন:</strong> {{ $attendanceInfo->section->name ?? '' }} | 
                                            <strong>শিক্ষক:</strong> {{ $attendanceInfo->teacher->name ?? 'Unknown' }} | 
                                            <strong>সময়:</strong> {{ $attendanceInfo->created_at->format('h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
        
                        {{-- STUDENTS TABLE --}}
        
                        @if($students->count() > 0)
        
                            <form id="attendanceForm" action="{{ route('attendances.store', ['tenant' => request()->route('tenant')]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                                <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                                <input type="hidden" name="date" value="{{ request('date') ?? date('Y-m-d') }}">
                                <div class="table-responsive">
        
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Attendance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $student)
                                                <tr>
                                                    <td>{{$student->student_id}}</td>
                                                    <td>{{$student->name}}</td>
                                                    <td>
                                                        @php
                                                            $status = $existingAttendance[$student->id] ?? 'present';
                                                        @endphp
                                                        <label>
                                                            <input type="radio" name="attendance[{{$student->id}}]" value="present" 
                                                                {{ $status == 'present' ? 'checked' : '' }}>
                                                            Pre
                                                        </label>
                                                        <label class="ms-3">
                                                            <input type="radio" name="attendance[{{$student->id}}]" value="absent" 
                                                                {{ $status == 'absent' ? 'checked' : '' }}>
                                                            Abs
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    {{ $students->withQueryString()->links() }}
                                </div>
                                <button type="submit" class="btn btn-success">
                                    Submit Attendance
                                </button>
                            </form>
                        @elseif(request('class_id'))
                            <div class="alert alert-warning mt-3">
                                এই ক্লাসে কোনো শিক্ষার্থী পাওয়া যায়নি।
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Today Completed Ateendance</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Class & Section</th>
                                        <th>Teacher & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($getAttendance as $completed)
                                        <tr>
                                            <td>
                                                <span class="fw-bold text-primary">{{ $completed->class->name ?? '' }}</span><br>
                                                <small class="text-muted">শাখা: {{ $completed->section->name ?? '' }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $completed->teacher->name ?? 'Unknown' }}</small><br>
                                                <small class="badge bg-soft-success text-success">
                                                    {{ $completed->created_at->format('h:i A') }}
                                                </small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">এখনো কোনো হাজিরা নেওয়া হয়নি।</td>
                                        
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       
    </div>
@endsection
@section('customJs')
<script>
    $(document).ready(function () {
        $('#attendanceForm').on('submit', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation(); // এটি নিশ্চিত করবে অন্য কোনো JS ইন্টারফেয়ার করবে না

            let form = $(this);
            let submitBtn = form.find('button[type="submit"]');
            
            submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    // যদি response একটি string হিসেবে আসে (যা মাঝেমধ্যে হয়)
                    let res = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if(res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'সফল!',
                            text: res.message,
                        }).then(() => {
                            location.reload(); // পেজটি রিফ্রেশ করবে যাতে নতুন ডাটা দেখা যায়
                        });
                    }
                },
                error: function (xhr) {
                    submitBtn.prop('disabled', false).text('Submit Attendance');
                    let errorMsg = "সার্ভারে সমস্যা হয়েছে!";
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', errorMsg, 'error');
                }
            });
        });
    });
</script>
@endsection