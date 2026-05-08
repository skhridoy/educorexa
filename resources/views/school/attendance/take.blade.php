@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Header --}}
        <div class="page-header-card">
            <div class="page-header-content">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h1 class="page-title"><i class="fa-solid fa-clipboard-user me-2"></i> Take Attendance</h1>
                        <p class="page-subtitle">Record daily student attendance for your assigned classes.</p>
                    </div>
                    <div class="text-md-end">
                        <div class="badge bg-primary-gradient px-3 py-2 rounded-pill shadow-sm">
                            <i class="fa-solid fa-calendar-day me-1"></i> {{ date('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Filter Section --}}
                <div class="filter-section mb-4">
                    <form method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="filter-label">Class</label>
                                <select name="class_id" class="form-select">
                                    <option value="">Select Class</option>
                                    @foreach($assignedClasses->unique('class_id') as $item)
                                        <option value="{{$item->class_id}}" {{ request('class_id') == $item->class_id ? 'selected' : '' }}>
                                            {{$item->class->name ?? ''}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Section</label>
                                <select name="section_id" class="form-select">
                                    <option value="">Select Section</option>
                                    @foreach($assignedClasses->unique('section_id') as $item)
                                        <option value="{{$item->section_id}}" {{ request('section_id') == $item->section_id ? 'selected' : '' }}>
                                            {{$item->section->name ?? ''}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="filter-label">Attendance Date</label>
                                <input type="date" name="date" class="form-control" value="{{ request('date') ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary-gradient w-100">
                                    <i class="fa-solid fa-filter me-2"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                @if(isset($attendanceInfo))
                    <div class="alert alert-info border-0 shadow-sm rounded-4 mb-4" style="background: rgba(14, 165, 233, 0.1);">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-info rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 45px; height: 45px;">
                                <i class="fa-solid fa-circle-check fs-4"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1 fw-bold" style="color: #0369a1;">Attendance already taken!</h6>
                                <p class="mb-0 small text-muted">
                                    <span class="badge bg-info bg-opacity-25 text-info rounded-pill px-3">{{ $attendanceInfo->class->name ?? '' }} - {{ $attendanceInfo->section->name ?? '' }}</span>
                                    <span class="ms-2">Taken by <strong>{{ $attendanceInfo->teacher->name ?? 'Unknown' }}</strong> at {{ $attendanceInfo->created_at->format('h:i A') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Students Table --}}
                @if($students->count() > 0)
                    <div class="data-table-card">
                        <div class="table-header">
                            <h5 class="table-title"><i class="fa-solid fa-users-line me-2"></i> Student List</h5>
                        </div>
                        <form id="attendanceForm" action="{{ route('attendances.store', ['tenant' => request()->route('tenant')]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                            <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                            <input type="hidden" name="date" value="{{ request('date') ?? date('Y-m-d') }}">
                            
                            <div class="table-responsive">
                                <table class="table data-table mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th width="100">Student ID</th>
                                            <th>Student Name</th>
                                            <th class="text-end">Attendance Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <td><span class="badge bg-light text-dark fw-bold">{{$student->student_id}}</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-bold text-dark">{{$student->name}}</div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    @php $status = $existingAttendance[$student->id] ?? 'present'; @endphp
                                                    <div class="attendance-radio justify-content-end">
                                                        <label class="attendance-option">
                                                            <input type="radio" name="attendance[{{$student->id}}]" value="present" {{ $status == 'present' ? 'checked' : '' }}>
                                                            <span class="attendance-label label-present">Present</span>
                                                        </label>
                                                        <label class="attendance-option">
                                                            <input type="radio" name="attendance[{{$student->id}}]" value="absent" {{ $status == 'absent' ? 'checked' : '' }}>
                                                            <span class="attendance-label label-absent">Absent</span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div>{{ $students->withQueryString()->links() }}</div>
                                <button type="submit" class="btn btn-primary-gradient px-5 shadow">
                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> Save Attendance
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif(request('class_id'))
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                        <i class="fa-solid fa-user-slash fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No students found in this class/section.</h5>
                    </div>
                @endif
            </div>

            {{-- Sidebar Status --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-primary-gradient py-3">
                        <h6 class="mb-0 text-white fw-bold"><i class="fa-solid fa-list-check me-2"></i> Today's Completed</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="completed-list">
                            @forelse($getAttendance as $completed)
                                <div class="completed-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $completed->class->name ?? '' }}</h6>
                                            <small class="text-muted">Section: {{ $completed->section->name ?? '' }}</small>
                                        </div>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1" style="font-size: 10px;">
                                            <i class="fa-regular fa-clock me-1"></i> {{ $completed->created_at->format('h:i A') }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-2">
                                            <i class="fa-solid fa-user-tie text-primary opacity-50"></i>
                                        </div>
                                        <small class="text-muted">{{ $completed->teacher->name ?? 'Unknown' }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 px-3">
                                    <p class="text-muted small mb-0">No attendance recorded yet today.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Info Card --}}
                <div class="card border-0 bg-info bg-opacity-10 rounded-4">
                    <div class="card-body p-4 text-center">
                        <i class="fa-solid fa-circle-info text-info fs-3 mb-3"></i>
                        <p class="small text-dark mb-0">Please ensure all students are accounted for before submitting. Attendance once recorded can be updated by re-submitting.</p>
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
            
            let form = $(this);
            let submitBtn = form.find('button[type="submit"]');
            let originalBtnHtml = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Saving...');

            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    let res = typeof response === 'string' ? JSON.parse(response) : response;
                    if(res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.message,
                            confirmButtonColor: '#4f46e5'
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function (xhr) {
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                    let errorMsg = "Something went wrong!";
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });
    });
</script>
@endsection