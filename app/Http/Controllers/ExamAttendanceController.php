<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamAttendance;
use App\Models\ExamRoutine;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class ExamAttendanceController extends Controller
{
    private function schoolId(): int
    {
        return (int) auth()->user()->school_id;
    }

    public function index($tenant, Request $request)
    {
        $schoolId = $this->schoolId();
        $examId = $request->integer('exam_id');
        $classId = $request->integer('class_id');
        $date = $request->input('date');

        $exams = Exam::with('categories')->where('school_id', $schoolId)->orderByDesc('id')->get();
        $selectedExam = $exams->firstWhere('id', $examId);
        $classesQuery = Classes::where('school_id', $schoolId);
        if ($selectedExam) {
            $categoryIds = $selectedExam->categories->pluck('id')->filter()->values();
            if ($categoryIds->isNotEmpty()) {
                $classesQuery->whereIn('school_category_id', $categoryIds);
            } elseif ($selectedExam->school_category_id) {
                $classesQuery->where('school_category_id', $selectedExam->school_category_id);
            }
        }
        $classes = $classesQuery->orderBy('name')->get();
        $routines = collect();
        if ($examId && $classId) {
            $routines = ExamRoutine::with('subject')
                ->where('school_id', $schoolId)
                ->where('exam_id', $examId)
                ->where('class_id', $classId)
                ->orderBy('exam_date')
                ->orderBy('start_time')
                ->get();
            $date = $date ?: optional($routines->first())->exam_date?->format('Y-m-d');
        }
        $students = collect();
        $records = collect();

        if ($examId && $classId && $date) {
            $students = Student::with(['section'])
                ->where('school_id', $schoolId)
                ->where('class_id', $classId)
                ->where('status', 'active')
                ->orderBy('roll')
                ->get();

            $records = ExamAttendance::where('school_id', $schoolId)
                ->where('exam_id', $examId)
                ->where('class_id', $classId)
                ->whereDate('attendance_date', $date)
                ->get()
                ->keyBy('student_id');
        }

        return view('school.exam.attendance.index', compact(
            'exams', 'classes', 'routines', 'students', 'records', 'examId', 'classId', 'date', 'tenant'
        ));
    }

    public function scan($tenant, Request $request)
    {
        return $this->index($tenant, $request);
    }

    public function record($tenant, Request $request)
    {
        $data = $request->validate([
            'exam_id' => ['required', 'integer'],
            'class_id' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'qr_code_data' => ['required', 'string', 'max:2000'],
        ]);

        $schoolId = $this->schoolId();
        $routine = ExamRoutine::where('school_id', $schoolId)
            ->where('exam_id', $data['exam_id'])
            ->where('class_id', $data['class_id'])
            ->whereDate('exam_date', $data['date'])
            ->first();

        if (!$routine) {
            return response()->json(['success' => false, 'message' => 'No exam is scheduled for the selected date.'], 422);
        }

        $raw = trim($data['qr_code_data']);
        $studentId = null;

        if (preg_match('/ID:\s*([^|\n\r]+)/i', $raw, $matches)) {
            $studentId = trim($matches[1]);
        } elseif (preg_match('/STD-[A-Za-z0-9_-]+/i', $raw, $matches)) {
            $studentId = $matches[0];
        } else {
            $studentId = $raw;
        }

        $student = Student::with(['class', 'section'])
            ->where('school_id', $schoolId)
            ->where('class_id', $data['class_id'])
            ->where(function ($query) use ($studentId) {
                $query->where('student_id', $studentId)->orWhere('id', $studentId);
            })
            ->first();

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found in the selected class.'], 404);
        }

        $exam = Exam::where('school_id', $schoolId)->findOrFail($data['exam_id']);
        $record = ExamAttendance::firstOrCreate(
            [
                'school_id' => $schoolId,
                'exam_id' => $exam->id,
                'student_id' => $student->id,
                'attendance_date' => $data['date'],
            ],
            [
                'class_id' => $student->class_id,
                'section_id' => $student->section_id,
                'status' => 'present',
                'scanned_at' => now(),
            ]
        );

        $present = ExamAttendance::where('school_id', $schoolId)
            ->where('exam_id', $exam->id)
            ->where('class_id', $data['class_id'])
            ->whereDate('attendance_date', $data['date'])
            ->where('status', 'present')->count();

        return response()->json([
            'success' => true,
            'already_marked' => !$record->wasRecentlyCreated,
            'message' => $record->wasRecentlyCreated ? 'Exam attendance recorded.' : 'Attendance already recorded.',
            'present' => $present,
            'student' => [
                'id' => $student->id,
                'student_id' => $student->student_id,
                'name' => $student->name,
                'roll' => $student->roll,
                'section' => $student->section?->name,
                'time' => optional($record->scanned_at)->format('h:i A'),
            ],
        ]);
    }

    public function printSheet($tenant, Request $request)
    {
        $data = $this->sheetData($request);
        $data['isPdf'] = false;

        return view('school.exam.attendance.print', $data);
    }

    public function downloadSheet($tenant, Request $request)
    {
        $data = $this->sheetData($request);
        $fileName = 'exam-attendance-'
            . \Illuminate\Support\Str::slug($data['exam']->name)
            . '-'
            . \Illuminate\Support\Str::slug($data['class']->name)
            . '.pdf';

        $data['isPdf'] = false;

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('school.exam.attendance.print', $data)
            ->setPaper('a4', 'portrait')
            ->setOption(['isRemoteEnabled' => true, 'isPhpEnabled' => true])
            ->download($fileName);
    }

    public function attendanceReport($tenant, Request $request)
    {
        $schoolId = $this->schoolId();
        $schoolInfo = School::findOrFail($schoolId);
        $exam = Exam::where('school_id', $schoolId)->findOrFail($request->integer('exam_id'));
        $date = $request->date('date');

        abort_unless($date, 422, 'Attendance date is required.');

        $classId = $request->integer('class_id') ?: null;
        $studentsQuery = Student::where('school_id', $schoolId)
            ->where('status', 'active');
        if ($classId) {
            $studentsQuery->where('class_id', $classId);
        }

        $students = $studentsQuery
            ->orderBy('class_id')
            ->orderBy('roll')
            ->get();

        $records = ExamAttendance::where('school_id', $schoolId)
            ->where('exam_id', $exam->id)
            ->whereDate('attendance_date', $date)
            ->when($classId, fn ($query) => $query->where('class_id', $classId))
            ->get()
            ->keyBy('student_id');

        $class = $classId
            ? Classes::where('school_id', $schoolId)->find($classId)
            : null;

        return view('school.exam.attendance.report', compact(
            'schoolInfo', 'exam', 'class', 'date', 'students', 'records'
        ));
    }

    private function sheetData(Request $request): array
    {
        $schoolId = $this->schoolId();
        $school = School::findOrFail($schoolId);
        $exam = Exam::where('school_id', $schoolId)->findOrFail($request->integer('exam_id'));
        $class = Classes::where('school_id', $schoolId)->findOrFail($request->integer('class_id'));
        $routines = ExamRoutine::with('subject')
            ->where('school_id', $schoolId)
            ->where('exam_id', $exam->id)
            ->where('class_id', $class->id)
            ->orderBy('exam_date')
            ->orderBy('start_time')
            ->orderBy('id')
            ->get();
        $students = Student::with(['section', 'group'])
            ->where('school_id', $schoolId)
            ->where('class_id', $class->id)
            ->where('status', 'active')
            ->orderBy('roll')
            ->get();
        $records = ExamAttendance::where('school_id', $schoolId)
            ->where('exam_id', $exam->id)
            ->where('class_id', $class->id)
            ->get()
            ->groupBy('student_id');

        return [
            'schoolInfo' => $school,
            'exam' => $exam,
            'class' => $class,
            'routines' => $routines,
            'students' => $students,
            'records' => $records,
        ];
    }
}
