@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Attendance Radio Toggles */
        .attendance-toggle-group {
            display: inline-flex;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            position: relative;
            z-index: 1;
        }
        .attendance-option {
            cursor: pointer;
            position: relative;
            margin: 0;
            flex: 1;
        }
        .attendance-option input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .attendance-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 24px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #64748b;
            min-width: 100px;
            user-select: none;
        }
        
        /* Present State */
        .attendance-option input[value="present"]:checked + .label-present {
            background: #10b981;
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        /* Absent State */
        .attendance-option input[value="absent"]:checked + .label-absent {
            background: #ef4444;
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .attendance-option:hover .attendance-label:not(.active) {
            color: #1e293b;
        }

        /* Student List Styling */
        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #4f46e5;
            border: 2px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            object-fit: cover;
        }
        .student-avatar.initials {
            background: #f1f5f9;
        }
        .student-avatar-container {
            position: relative;
        }
        .student-info-main {
            display: flex;
            flex-direction: column;
        }
        .student-name {
            font-weight: 700;
            color: #1e293b;
            font-size: 1rem;
            margin-bottom: 2px;
            line-height: 1.2;
        }
        .student-id-sub {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 600;
        }

        /* Modern Alert Styling */
        .status-alert {
            background: #ffffff;
            border-radius: 20px;
            padding: 16px 20px;
            border: 1px solid rgba(79, 70, 229, 0.1);
            box-shadow: 0 10px 25px rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }
        .status-alert::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #4f46e5;
        }
        .status-alert-icon {
            width: 42px;
            height: 42px;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .status-alert-title {
            font-weight: 700;
            color: #1e293b;
            font-size: 0.95rem;
            margin-bottom: 2px;
        }
        .status-alert-subtitle {
            font-size: 0.8rem;
            color: #64748b;
        }
        
        .data-table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .data-table tbody tr:hover {
            background-color: rgba(79, 70, 229, 0.02);
            transform: scale(1.002);
        }

        .student-info-main {
                display: flex;
                flex-direction: column;
                text-align: left;
                align-items: flex-start;
            }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .page-header-card { padding: 24px 20px; margin-bottom: 20px; }
            .page-title { font-size: 1.5rem !important; }
            
            .filter-section { padding: 15px; margin-bottom: 20px; }
            
            .data-table-card { background: transparent; border: none; box-shadow: none; }
            .table-header { padding: 15px 5px; background: transparent; border: none; }
            .table-responsive { overflow: visible; }
            
            .data-table thead { display: none; }
            .data-table tbody { display: grid; grid-template-columns: 1fr; gap: 15px; padding: 5px; }
            
            .data-table tbody tr {
                display: flex;
                flex-direction: column;
                background: #ffffff;
                border-radius: 24px;
                padding: 0; /* Remove internal tr padding to manage via td */
                box-shadow: 0 12px 24px rgba(0,0,0,0.03);
                border: 1px solid #f1f5f9 !important;
                position: relative;
                margin-bottom: 0;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                overflow: hidden;
            }
            
            .data-table tbody tr:hover {
                transform: translateY(-8px);
                box-shadow: 0 24px 48px rgba(79, 70, 229, 0.15);
                border-color: #4f46e5 !important;
            }
            
            /* Roll Index on Mobile */
            .data-table tbody td:first-child {
                display: none !important;
            }
            .stat-index { 
                font-size: 0.85rem; 
                font-weight: 800; 
                color: #4f46e5; 
                background: #f1f5f9; 
                padding: 4px 10px; 
                border-radius: 8px;
            }
            
            /* Student Info on Mobile */
            .data-table tbody td:nth-child(2) {
                margin-bottom: 10px;
                padding: 25px 25px 15px 25px !important;
                border-bottom: 1px solid #f8fafc !important;
                width: 100%;
            }
            
            .student-info-main {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            
            /* Attendance Toggle on Mobile */
            .data-table tbody td:last-child {
                padding: 10px 25px 25px 25px !important;
                text-align: center !important;
            }
            
            .attendance-toggle-group {
                width: 100%;
                justify-content: center;
                margin: 0 auto;
            }
            .attendance-label {
                width: 100%;
                padding: 12px 10px;
                font-size: 0.8rem;
            }

            .pagination-modern { width: 100%; justify-content: center; display: flex; margin-bottom: 15px; }
            .btn-primary-gradient.px-5 { width: 100%; }
        }

        @media (max-width: 480px) {
            .attendance-label { padding: 10px 5px; min-width: auto; }
            .student-avatar { width: 42px; height: 42px; font-size: 0.9rem; }
            .student-name { font-size: 0.95rem; }
            .student-info-main {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                text-align: right;
            }
        }
    </style>
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
                        <div class="badge bg-primary-gradient px-4 py-2 rounded-pill shadow-sm fs-6">
                            <i class="fa-solid fa-calendar-day me-2"></i> {{ date('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Filter Section --}}
                <div class="filter-section mb-4 shadow-sm border-0">
                    <form method="GET">
                        <div class="row g-2 g-md-3 align-items-end">
                            <div class="col-6 col-md-3">
                                <label class="filter-label mb-1">Class</label>
                                <select name="class_id" class="form-select border-primary-soft shadow-none">
                                    <option value="">Select Class</option>
                                    @foreach($assignedClasses->unique('class_id') as $item)
                                        <option value="{{$item->class_id}}" {{ request('class_id') == $item->class_id ? 'selected' : '' }}>
                                            {{$item->class->name ?? ''}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="filter-label mb-1">Section</label>
                                <select name="section_id" class="form-select border-primary-soft shadow-none">
                                    <option value="">Select Section</option>
                                    @foreach($assignedClasses->unique('section_id') as $item)
                                        <option value="{{$item->section_id}}" {{ request('section_id') == $item->section_id ? 'selected' : '' }}>
                                            {{$item->section->name ?? ''}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="filter-label mb-1">Date</label>
                                <input type="date" name="date" class="form-control shadow-none" value="{{ request('date') ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-primary-gradient w-100 py-3 shadow-sm mt-2 mt-md-0">
                                    <i class="fa-solid fa-magnifying-glass me-2"></i> Load Students
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                @if(isset($attendanceInfo))
                    <div class="status-alert mb-4 animate-fade-in">
                        <div class="d-flex align-items-center">
                            <div class="status-alert-icon">
                                <i class="fa-solid fa-check-double"></i>
                            </div>
                            <div class="ms-3">
                                <div class="status-alert-title">Attendance already recorded for this session</div>
                                <div class="status-alert-subtitle">
                                    Last updated by <span class="fw-bold text-primary">{{ $attendanceInfo->teacher->name ?? 'System' }}</span> 
                                    at <span class="text-dark fw-medium">{{ $attendanceInfo->created_at->format('h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Students Table --}}
                @if($students->count() > 0)
                    <div class="data-table-card shadow-sm border-0">
                        <div class="table-header d-flex justify-content-between align-items-center p-3">
                            <h6 class="table-title mb-0"><i class="fa-solid fa-user-graduate me-2"></i> {{ $students->total() }} Students Found</h6>
                            <div class="d-none d-md-block text-muted small fw-bold">Select Status</div>
                        </div>
                        
                        <form id="attendanceForm" action="{{ route('attendances.store', ['tenant' => request()->route('tenant')]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                            <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                            <input type="hidden" name="date" value="{{ request('date') ?? date('Y-m-d') }}">
                            
                            <div class="table-responsive">
                                <table class="table data-table mb-0">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="ps-4" width="60">Roll</th>
                                            <th>Student Information</th>
                                            <th class="text-end pe-4">Attendance Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <td class="d-none d-md-table-cell">
                                                    <div class="stat-index text-primary">#{{ $student->roll ?? $loop->iteration }}</div>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="d-md-none">
                                                                <div class="stat-index" style="font-size: 0.75rem; padding: 4px 8px;">#{{ $student->roll ?? $loop->iteration }}</div>
                                                            </div>
                                                            <div class="student-avatar-container">
                                                                @if($student->photo)
                                                                    <img src="{{ asset($student->photo) }}" alt="{{ $student->name }}" class="student-avatar border-primary-soft">
                                                                @else
                                                                    <div class="student-avatar initials">
                                                                        @php 
                                                                            $nameParts = explode(' ', trim($student->name)); 
                                                                            $initials = substr($nameParts[0], 0, 1);
                                                                            if(count($nameParts) > 1) {
                                                                                $initials .= substr(end($nameParts), 0, 1);
                                                                            }
                                                                        @endphp
                                                                        {{ strtoupper($initials) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="student-info-main">
                                                            <div class="student-name fw-bold mb-0">{{$student->name}}</div>
                                                            <div class="student-id-sub text-muted small">{{$student->student_id}}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-4">
                                                    @php $status = $existingAttendance[$student->id] ?? 'present'; @endphp
                                                    <div class="attendance-toggle-group shadow-sm">
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
                            
                            <div class="p-4 bg-light border-top d-flex justify-content-between align-items-center flex-wrap gap-3 rounded-bottom-4">
                                <div class="pagination-modern">
                                    {{ $students->withQueryString()->links() }}
                                </div>
                                <button type="submit" class="btn btn-primary-gradient px-5 py-3 fw-bold shadow-lg">
                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i>Save Records
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif(request('class_id'))
                    <div class="schools-panel py-5 text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-users-slash fs-1 opacity-25"></i>
                        </div>
                        <h5 class="fw-bold text-dark">No students found</h5>
                        <p class="text-muted small">Try checking another section or verify enrollment for this class.</p>
                    </div>
                @endif
            </div>

            {{-- Sidebar Summary --}}
            <div class="col-lg-4">
                <div class="schools-panel mb-4 shadow-sm">
                    <div class="panel-header bg-navy text-white">
                        <h6 class="panel-title mb-0 text-white"><i class="fa-solid fa-history me-2"></i> Recent Sessions</h6>
                    </div>
                    <div class="p-0">
                        <div class="completed-list">
                            @forelse($getAttendance as $completed)
                                <div class="completed-item p-3 border-bottom border-light">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="fw-bold text-dark">{{ $completed->class->name ?? '' }} - {{ $completed->section->name ?? '' }}</div>
                                        <small class="badge bg-soft-success text-success">{{ $completed->created_at->format('h:i A') }}</small>
                                    </div>
                                    <div class="d-flex align-items-center small text-muted">
                                        <i class="fa-solid fa-user-tie me-2 opacity-50"></i> {{ $completed->teacher->name ?? 'System' }}
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <p class="text-muted small mb-0">No attendance records found for today yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Pro Tip Card --}}
                <div class="card border-0 rounded-4 overflow-hidden" style="background: linear-gradient(45deg, #002147, #003366);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-2">
                                <i class="fa-solid fa-lightbulb text-warning"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">Quick Tip</h6>
                        </div>
                        <p class="small mb-0 opacity-75">By default, all students are marked as **Present**. You only need to toggle those who are **Absent** to save time.</p>
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
            
            submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Synchronizing...');

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
                            confirmButtonColor: '#4f46e5',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function (xhr) {
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                    let errorMsg = "Failed to save attendance!";
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