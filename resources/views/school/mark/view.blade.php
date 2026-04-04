@extends($layout)
@section('customCSS')
<style>
    .pagination{
    --bs-pagination-border-radius: 50% !important;
    align-items: center;
    justify-content: center;
  }
</style>
@endsection
@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Student Mark List</h6>
            <form method="GET" action="{{ route('marks.view-marks', ['tenant' => auth()->user()->school->slug]) }}" class="row mb-4">
                <div class="col-md-3 mb-3">
                    <label>Academic Year</label>
                    <select name="academic_year_id" class="form-control">
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Class</label>
                    <select name="class_id" class="form-control" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Exam</label>
                    <select name="exam_id" class="form-control" required>
                        <option value="">Select Exam</option>
                        @foreach($examTypes as $exam)
                            <option value="{{ $exam->id }}" {{ $selectedExamId == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }} - {{ $exam->academicYear ? $exam->academicYear->name : 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                

                <div class="col-md-3 my-1">
                    <button class="btn btn-primary form-control mt-3">Show Marks</button>
                </div>
                <div class="col-md-3 my-1">
                    @if($selectedClassId && $selectedExamId)
                    <a href="{{ route('marks.download-sheet', array_merge(['tenant' => auth()->user()->school->slug], request()->all())) }}" 
                    class="btn btn-success form-control mt-3">
                    <i class="link-icon" data-feather="download"></i> Download Sheet
                    </a>
                    @endif
                </div>
            </form>

            @if(isset($paginatedResults) && count($paginatedResults) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>Student ID</th>
                            <th>Roll</th>
                            <th>Student Name</th>
                            @foreach($subjects as $subject)
                                <th>{{ $subject->name }} <br><small>(M | G)</small></th>
                            @endforeach
                            <th class="bg-primary text-white">Total</th>
                            <th class="bg-info text-white">GPA</th>
                            <th class="bg-success text-white">Merit</th>
                            <th>Action</th>
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
                            <tr>
                                <td class="fw-bold">{{ $displayId }}</td>
                                <td>{{ $student->roll }}</td>
                                <td class="text-start">{{ strtoupper($student->name) }}</td>
                                @foreach($subjects as $subject)
                                    @php
                                        $m = $marksData[$student->id][$subject->id]['marks'] ?? null;
                                        $g = $marksData[$student->id][$subject->id]['grade'] ?? '-';
                                    @endphp
                                    <td>
                                        @if($m !== null)
                                            {{ $m }} | <span class="text-muted">{{ $g }}</span>
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td class="fw-bold ">{{ $item['total_marks'] }}</td>
                                <td class="fw-bold text-primary">{{ $marksData[$student->id]['GPA'] ?? '0.00' }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $meritPosition[$student->id] ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('marks.marksheet', ['tenant' => auth()->user()->school->slug, 'student' => $student->id, 'class' => $selectedClassId, 'exam' => $selectedExamId, 'year' => $selectedYearId]) }}" 
                                    class="btn btn-sm btn-primary" 
                                    > 
                                        <i data-feather="download"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

           
            <div class="mt-4 d-flex justify-content-center">
                {{ $paginatedResults->links() }}
            </div>

            @elseif($selectedClassId && $selectedExamId)
                <div class="alert alert-warning text-center">No marks found for this criteria.</div>
            @endif

        </div>
    </div>
</div>
@endsection