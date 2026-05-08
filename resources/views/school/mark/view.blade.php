@extends($layout)

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-list-check me-2"></i> Student Mark List</h1>
                <p style="margin: 0; opacity: 0.85;">View and analyze academic results across exams and classes</p>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="filter-section">
            <form method="GET" action="{{ route('marks.view-marks', ['tenant' => auth()->user()->school->slug]) }}">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="filter-label">Academic Year</label>
                        <select name="academic_year_id" class="form-select border-0 bg-light" style="border-radius: 10px; padding: 12px;">
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="filter-label">Class</label>
                        <select name="class_id" class="form-select border-0 bg-light" required style="border-radius: 10px; padding: 12px;">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="filter-label">Exam</label>
                        <select name="exam_id" class="form-select border-0 bg-light" required style="border-radius: 10px; padding: 12px;">
                            <option value="">Select Exam</option>
                            @foreach($examTypes as $exam)
                                <option value="{{ $exam->id }}" {{ $selectedExamId == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }} - {{ $exam->academicYear ? $exam->academicYear->name : 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-2" style="border-radius: 10px;">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> Show Marks
                            </button>
                            @if($selectedClassId && $selectedExamId)
                                <a href="{{ route('marks.download-sheet', array_merge(['tenant' => auth()->user()->school->slug], request()->all())) }}" 
                                   class="btn btn-outline-success py-2" style="border-radius: 10px;" title="Download CSV">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(isset($paginatedResults) && count($paginatedResults) > 0)
            <div class="data-table-card">
                <div class="table-header">
                    <h5 class="table-title"><i class="fa-solid fa-table me-2"></i> Result Sheet</h5>
                    <div class="text-muted small">Total Records: {{ $paginatedResults->total() }}</div>
                </div>

                <div class="table-responsive">
                    <table class="table data-table mb-0 text-center">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Roll</th>
                                <th class="text-start">Student Name</th>
                                @foreach($subjects as $subject)
                                    <th>{{ $subject->name }} <br><small class="opacity-50">(M | G)</small></th>
                                @endforeach
                                <th class="bg-light">Total</th>
                                <th class="bg-light">GPA</th>
                                <th class="bg-light">Merit</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedResults as $item)
                                @php 
                                    $studentId = $item['student_id'];
                                    $student = $students->where('id', $studentId)->first(); 
                                    $history = DB::table('student_sessions')
                                                ->where('student_id', $studentId)
                                                ->where('academic_year_id', $selectedYearId)
                                                ->first();
                                    $displayId = $history ? $history->old_student_id : ($student ? $student->student_id : 'N/A');
                                @endphp
                                
                                @if($student)
                                <tr class="align-middle">
                                    <td class="fw-bold text-muted">{{ $displayId }}</td>
                                    <td class="fw-bold">{{ $student->roll }}</td>
                                    <td class="text-start fw-bold text-dark">{{ strtoupper($student->name) }}</td>
                                    @foreach($subjects as $subject)
                                        @php
                                            $m = $marksData[$student->id][$subject->id]['marks'] ?? null;
                                            $g = $marksData[$student->id][$subject->id]['grade'] ?? '-';
                                        @endphp
                                        <td class="mark-cell">
                                            @if($m !== null)
                                                {{ $m }} <span class="grade-text">| {{ $g }}</span>
                                            @else
                                                <span class="text-danger small">N/A</span>
                                            @endif
                                        </td>
                                    @endforeach

                                    <td class="bg-light"><span class="total-badge">{{ $item['total_marks'] }}</span></td>
                                    <td class="bg-light"><span class="gpa-badge">{{ $marksData[$student->id]['GPA'] ?? '0.00' }}</span></td>
                                    <td class="bg-light">
                                        <span class="merit-badge">
                                            {{ $meritPosition[$student->id] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('marks.marksheet', ['tenant' => auth()->user()->school->slug, 'student' => $student->id, 'class' => $selectedClassId, 'exam' => $selectedExamId, 'year' => $selectedYearId]) }}" 
                                           class="btn btn-action btn-sm btn-outline-primary" title="Download Marksheet"> 
                                            <i class="fa-solid fa-file-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $paginatedResults->links() }}
            </div>

        @elseif($selectedClassId && $selectedExamId)
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-circle-exclamation fa-3x text-warning mb-3"></i>
                    <h5 class="text-muted">No marks found for the selected criteria.</h5>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection