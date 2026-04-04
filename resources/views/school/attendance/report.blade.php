@extends('layouts.school')

@section('customCSS')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
{{-- Select2 CSS যদি আপনার লেআউটে না থাকে --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .mini-calendar { font-size: 9px; min-height: 200px; }
    .fc-toolbar { display: none !important; } 
    .fc-daygrid-day-number { font-size: 11px; padding: 2px !important; text-decoration: none !important; color: #333; }
    .fc-col-header-cell-cushion { font-size: 10px; text-transform: uppercase; text-decoration: none !important; }
    .fc-daygrid-body, .fc-scrollgrid-sync-table { width: 100% !important; }
    
    /* Select2 Bootstrap 5 compatibility */
    .select2-container .select2-selection--single { height: 38px !important; border: 1px solid #dee2e6 !important; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 38px !important; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px !important; }

    @media print {
        body { visibility: hidden; }
        .attendance-print-area, .attendance-print-area * { visibility: visible; }
        .attendance-print-area { position: absolute; left: 0; top: 0; width: 100%; }
        
        /* এক সারিতে ৩টি করে ক্যালেন্ডার রাখতে */
        .col-md-4 { width: 33.33% !important; float: left; padding: 5px; }
        .card { page-break-inside: avoid; border: 1px solid #000 !important; }
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="card-title">Search Student Attendance Report</h6>
            <form action="{{ route('student.attendance.report', ['tenant' => auth()->user()->school->slug]) }}" method="GET" class="row g-3">
                
                {{-- Class Filter --}}
                <div class="col-md-3">
                    <label class="form-label">Select Class</label>
                    <select name="class_id" id="class_id" class="form-select select2" required>
                        <option value="">-- Choose Class --</option>
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" {{ request('class_id') == $cls->id ? 'selected' : '' }}>
                                {{ $cls->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Student Filter (Searchable) --}}
                <div class="col-md-4">
                    <label class="form-label">Select Student / Search ID</label>
                    <select name="student_id" id="student_id" class="form-select select2" required>
                        <option value="">-- First Select Class --</option>
                        @if($student)
                            <option value="{{ $student->id }}" selected>
                                {{ $student->name }} (ID: {{ $student->student_id }})
                            </option>
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Year</label>
                    <select name="year" class="form-select">
                        @for($i = date('Y'); $i >= date('Y')-5; $i--)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2 w-100">Generate</button>
                    @if($student)
                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()"><i data-feather="printer" class="icon-sm"></i></button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($student)
    <div class="attendance-print-area">
        <div class="text-center mb-4">
            <h3 class="text-uppercase fw-bold">{{ auth()->user()->school->name }}</h3>
            <h4>Full Year Attendance Report - {{ $year }}</h4>
            <h5 class="text-muted">Student: {{ $student->name }} | Roll: {{ $student->roll }} | ID: {{ $student->student_id }}</h5>
        </div>

        <div class="row">
            @foreach(range(1, 12) as $month)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-2 bg-light text-center">
                            <strong class="text-uppercase">{{ date("F", mktime(0, 0, 0, $month, 1)) }}</strong>
                        </div>
                        <div class="card-body p-1">
                            <div id="calendar-{{ $month }}" class="mini-calendar"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else
        <div class="alert alert-info text-center">Please select a class and student then click "Generate Report".</div>
    @endif
</div>
@endsection

@section('customJS')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // ১. Select2 ইনিশিয়ালাইজ করা
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        // ২. ক্লাস ড্রপডাউন পরিবর্তন হলে এই ফাংশনটি চলবে
        $('#class_id').on('change', function() {
            var classId = $('#class_id').val();
            var tenant = "{{ $tenant }}"; // কন্ট্রোলার থেকে আসা টেন্যান্ট স্লাগ

            var url = "{{ route('students.get_by_class', ['tenant' => ':tenant', 'class_id' => ':classId']) }}";
            url = url.replace(':tenant', tenant).replace(':classId', classId);

            $.ajax({
                url: url,
                type: "GET",
                    dataType: "json",
                    beforeSend: function() {
                        // লোডিং অবস্থায় ড্রপডাউন মেসেজ
                        studentSelect.html('<option value="">Loading students...</option>');
                    },
                    success: function(data) {
                        // ড্রপডাউন খালি করে নতুন ডাটা বসানো
                        studentSelect.empty();
                        studentSelect.append('<option value="">-- Select Student --</option>');
                        
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                // Student ID থাকলে সেটা দেখাবে, না থাকলে Database ID
                                let rollOrId = value.student_id ? value.student_id : value.id;
                                studentSelect.append('<option value="' + value.id + '">' + value.name + ' (ID: ' + rollOrId + ')</option>');
                            });
                        } else {
                            studentSelect.append('<option value="">No students found in this class</option>');
                        }
                        
                        // Select2 আপডেট করার জন্য trigger করা বাধ্যতামূলক
                        studentSelect.trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", xhr.responseText);
                        alert("Error: " + xhr.status + ". শিক্ষার্থী লোড হতে সমস্যা হচ্ছে। কনসোল চেক করুন।");
                    }
                });
            } else {
                // ক্লাস সিলেক্ট না থাকলে স্টুডেন্ট ড্রপডাউন রিসেট করা
                studentSelect.empty().append('<option value="">-- First Select Class --</option>');
                studentSelect.trigger('change');
            }
        });
    });
</script>
@endsection