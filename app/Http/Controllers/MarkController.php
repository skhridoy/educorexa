<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Mark;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Student;
use Exception;

use App\Models\AssignClass;
use App\Models\AcademicYear;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MarksImport;
use App\Exports\MarkTemplateExport;


class MarkController extends Controller
{
    /**
     * নির্দিষ্ট বছরের আইডি বা রোল খুঁজে বের করার জন্য প্রাইভেট ফাংশন
     */
    private function getHistoryData($studentId, $classId, $currentData)
    {
        $history = DB::table('student_sessions')
            ->where('student_id', $studentId)
            ->where('class_id', $classId)
            ->first();

        return [
            'student_id' => $history ? $history->old_student_id : $currentData->student_id,
            'roll'       => $history ? $history->old_roll : $currentData->roll,
        ];
    }

    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $classes = Classes::where('school_id', $schoolId)->get();
        $exams   = Exam::where('school_id', $schoolId)->get();

        $classId   = $request->class_id;
        $examId    = $request->exam_id;
        $subjectId = $request->subject_id;

        $subjects = collect();
        $students = collect();
        $marksWithGrade = [];
        $fullMarks = null;
        $submittedSubjects = collect(); // সাবমিট হওয়া বিষয়গুলোর লিস্ট

        // load subjects assigned to class
        if ($classId) {

            $subjects = AssignClass::where('class_id', $classId)
                ->with('subject')
                ->get()
                ->pluck('subject');
        }

        // যদি exam এবং class উভয় সিলেক্ট করা থাকে, সাবমিট হওয়া বিষয়গুলো লোড করো
        if ($classId && $examId) {
            $submittedSubjectIds = Mark::where([
                'school_id' => $schoolId,
                'class_id'  => $classId,
                'exam_id'   => $examId,
            ])->distinct()->pluck('subject_id');

            $submittedSubjects = Subject::whereIn('id', $submittedSubjectIds)->get()->map(function ($sub) use ($classId, $schoolId, $examId) {
                $totalStudents = Mark::where([
                    'school_id'  => $schoolId,
                    'class_id'   => $classId,
                    'exam_id'    => $examId,
                    'subject_id' => $sub->id,
                ])->count();

                $fullMark = AssignClass::where([
                    'class_id'   => $classId,
                    'subject_id' => $sub->id,
                ])->value('full_mark');

                return [
                    'id'            => $sub->id,
                    'name'          => $sub->name,
                    'code'          => $sub->code ?? 'N/A',
                    'total_entries' => $totalStudents,
                    'full_mark'     => $fullMark,
                ];
            });
        }

        // load students
        if ($classId && $examId && $subjectId) {

            $subject = Subject::findOrFail($subjectId);

            $studentsQuery = Student::where('school_id', $schoolId)
                ->where('class_id', $classId)->orderBy('roll', 'asc');

            // religion subject filter
            if (str_contains($subject->name, 'Islam')) {
                $studentsQuery->where('religion', 'Islam');
            }

            if (str_contains($subject->name, 'Hindu')) {
                $studentsQuery->where('religion', 'Hinduism');
            }

            $students = $studentsQuery->get();

            // full marks
            $fullMarks = AssignClass::where([
                'class_id' => $classId,
                'subject_id' => $subjectId
            ])->value('full_mark');
            $fullMarks = $fullMarks ? (int)$fullMarks : 100;

            // existing marks
            $marks = Mark::where([
                'school_id' => $schoolId,
                'class_id' => $classId,
                'exam_id' => $examId,
                'subject_id' => $subjectId,
            ])->get()->keyBy('student_id');

            foreach ($students as $student) {

                $mark = $marks->get($student->id);

                if ($mark) {

                    $grade = $this->getGradeWithPoint($mark->marks, $fullMarks);

                    $marksWithGrade[$student->id] = [
                        'marks'     => $mark->marks !== null ? (int)$mark->marks : null,
                        'cq'        => $mark->cq !== null ? (int)$mark->cq : null,
                        'mcq'       => $mark->mcq !== null ? (int)$mark->mcq : null,
                        'practical' => $mark->practical !== null ? (int)$mark->practical : null,
                        'status'    => $mark->status ?? 'present',
                        'grade'     => $grade['grade'],
                        'point'     => $grade['point']
                    ];

                } else {

                    $marksWithGrade[$student->id] = [
                        'marks'     => null,
                        'cq'        => null,
                        'mcq'       => null,
                        'practical' => null,
                        'status'    => 'present',
                        'grade'     => null,
                        'point'     => null
                    ];
                }
            }
        }

        return view('school.mark.index', compact(
            'classes',
            'exams',
            'subjects',
            'students',
            'marksWithGrade',
            'classId',
            'examId',
            'subjectId',
            'fullMarks',
            'submittedSubjects'
        ));
    }


    /**
     * Store marks
     */
    public function store(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'exam_id' => 'required',
            'marks' => 'required|array',
        ]);

        $academicYear = AcademicYear::where('school_id', $schoolId)
            ->where('is_active', 1)
            ->value('id');

        foreach ($request->marks as $studentId => $markValue) {
            if ($markValue !== null) { // সংশোধিত ভেরিয়েবল নাম
                Mark::updateOrCreate(
                    [
                        'school_id'       => $schoolId,
                        'academic_year_id' => $academicYear,
                        'student_id'      => $studentId,
                        'class_id'        => $request->class_id,
                        'exam_id'         => $request->exam_id,
                        'subject_id'      => $request->subject_id,
                    ],
                    [
                        'marks'  => $markValue,
                        'status' => $request->status ?? 'present'
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Mark Saved Successfully.');
    }


    /**
     * Get subject by class (AJAX)
     */
    public function findSubject(Request $request)
    {

        $classId = $request->class_id;

        $subjects = Subject::whereIn(
            'id',
            AssignClass::where('class_id', $classId)->pluck('subject_id')
        )->get();

        return response()->json([
            'status' => true,
            'subjects' => $subjects
        ]);
    }

    /**
     * Grade calculation
     */
    private function getGradeWithPoint($marks, $fullMarks)
    {
        if ($marks === null || $fullMarks == 0) return ['grade' => null, 'point' => null];

        $percentage = ($marks / $fullMarks) * 100;

        if ($percentage >= 80) return ['grade' => 'A+', 'point' => 5];
        if ($percentage >= 70) return ['grade' => 'A', 'point' => 4];
        if ($percentage >= 60) return ['grade' => 'A-', 'point' => 3.5];
        if ($percentage >= 50) return ['grade' => 'B', 'point' => 3];
        if ($percentage >= 40) return ['grade' => 'C', 'point' => 2];
        if ($percentage >= 33) return ['grade' => 'D', 'point' => 1];

        return ['grade' => 'F', 'point' => 0];
    }

    /**
     * Group subjects by pair (Bangla 1st & 2nd, English 1st & 2nd)
     */
    private function organizeSubjectsWithPairs($subjects)
    {
        $usedSubjectIds = [];
        $bangla1 = null; $bangla2 = null;
        $english1 = null; $english2 = null;

        // ১. আগে স্পষ্টভাবে ২য় পত্র খুঁজুন
        foreach ($subjects as $sub) {
            $name = mb_strtolower(trim($sub->name));

            if (!$bangla2 && (
                (str_contains($name, 'bangla') && (str_contains($name, '2') || str_contains($name, '2nd') || str_contains($name, 'second') || str_contains($name, '২'))) ||
                (str_contains($name, 'বাংলা') && (str_contains($name, '2') || str_contains($name, '২') || str_contains($name, '২য়') || str_contains($name, 'দ্বিতীয়')))
            )) {
                $bangla2 = $sub;
            }

            if (!$english2 && (
                (str_contains($name, 'english') && (str_contains($name, '2') || str_contains($name, '2nd') || str_contains($name, 'second') || str_contains($name, '২'))) ||
                (str_contains($name, 'ইংরেজি') && (str_contains($name, '2') || str_contains($name, '২') || str_contains($name, '২য়') || str_contains($name, 'দ্বিতীয়')))
            )) {
                $english2 = $sub;
            }
        }

        // ২. এবার ১ম পত্র খুঁজুন (যা "Bangla 1st", "Bangla 1st Paper" অথবা শুধুই "Bangla" হতে পারে)
        foreach ($subjects as $sub) {
            if ($bangla2 && $sub->id === $bangla2->id) continue;
            if ($english2 && $sub->id === $english2->id) continue;

            $name = mb_strtolower(trim($sub->name));

            if (!$bangla1 && (str_contains($name, 'bangla') || str_contains($name, 'বাংলা'))) {
                $bangla1 = $sub;
            }

            if (!$english1 && (str_contains($name, 'english') || str_contains($name, 'ইংরেজি'))) {
                $english1 = $sub;
            }
        }

        $groups = [];

        // Bangla Pair
        if ($bangla1 && $bangla2 && $bangla1->id !== $bangla2->id) {
            $groups[] = [
                'type'     => 'pair',
                'name'     => 'Bangla (1st & 2nd Paper)',
                'subjects' => [$bangla1, $bangla2]
            ];
            $usedSubjectIds[$bangla1->id] = true;
            $usedSubjectIds[$bangla2->id] = true;
        }

        // English Pair
        if ($english1 && $english2 && $english1->id !== $english2->id) {
            $groups[] = [
                'type'     => 'pair',
                'name'     => 'English (1st & 2nd Paper)',
                'subjects' => [$english1, $english2]
            ];
            $usedSubjectIds[$english1->id] = true;
            $usedSubjectIds[$english2->id] = true;
        }

        // Standalone Subjects
        foreach ($subjects as $sub) {
            if (!isset($usedSubjectIds[$sub->id])) {
                $groups[] = [
                    'type'     => 'single',
                    'name'     => $sub->name,
                    'subjects' => [$sub]
                ];
            }
        }

        return $groups;
    }

    /**
     * Calculate detailed result and mark breakdown for a student
     */
    private function calculateStudentMarksheetData($student, $subjects, $allMarks, $classId)
    {
        $stRel = mb_strtolower($student->religion ?? '');

        // 1. Filter out religion mismatches
        $validSubjects = $subjects->filter(function ($subject) use ($stRel) {
            $subName = mb_strtolower($subject->name);
            if ((str_contains($subName, 'islam') && $stRel !== 'islam') ||
                (str_contains($subName, 'hindu') && !str_contains($stRel, 'hindu'))) {
                return false;
            }
            return true;
        });

        // 2. Group subjects with pairs
        $subjectGroups = $this->organizeSubjectsWithPairs($validSubjects);

        $totalMarks = 0;
        $failCount = 0;
        $totalPoints = 0;
        $subjectUnitCount = 0;
        $marksData = [];

        foreach ($subjectGroups as $group) {
            $subjectUnitCount++;

            if ($group['type'] === 'pair') {
                $sub1 = $group['subjects'][0];
                $sub2 = $group['subjects'][1];

                $mRec1 = $allMarks->where('student_id', $student->id)->where('subject_id', $sub1->id)->first();
                $mRec2 = $allMarks->where('student_id', $student->id)->where('subject_id', $sub2->id)->first();

                $raw1 = $mRec1 ? $mRec1->marks : 0;
                $raw2 = $mRec2 ? $mRec2->marks : 0;

                $full1 = AssignClass::where(['class_id' => $classId, 'subject_id' => $sub1->id])->value('full_mark') ?? 100;
                $full2 = AssignClass::where(['class_id' => $classId, 'subject_id' => $sub2->id])->value('full_mark') ?? 100;

                $combinedFull = $full1 + $full2;
                $combinedMarks = $raw1 + $raw2;
                $totalMarks += $combinedMarks;

                // Combined Grade & Point (80% A+, 33% pass)
                $gradeInfo = $this->getGradeWithPoint($combinedMarks, $combinedFull);
                if ($gradeInfo['grade'] === 'F') {
                    $failCount++;
                } else {
                    $totalPoints += $gradeInfo['point'];
                }

                $highest1 = $allMarks->where('subject_id', $sub1->id)->max('marks');
                $highest2 = $allMarks->where('subject_id', $sub2->id)->max('marks');

                // 1st Paper
                $marksData[$sub1->id] = [
                    'subject_id'      => $sub1->id,
                    'subject_code'    => $sub1->code ?? 'N/A',
                    'subject_name'    => $sub1->name,
                    'full_mark'       => $full1,
                    'cq'              => $mRec1?->cq,
                    'mcq'             => $mRec1?->mcq,
                    'practical'       => $mRec1?->practical,
                    'marks'           => $raw1,
                    'highest_mark'    => $highest1 ?? '---',
                    'is_paired'       => true,
                    'is_first'        => true,
                    'combined_full'   => $combinedFull,
                    'combined_marks'  => $combinedMarks,
                    'grade'           => $gradeInfo['grade'],
                    'point'           => $gradeInfo['point'],
                    'status'          => $mRec1?->status ?? 'present',
                ];

                // 2nd Paper
                $marksData[$sub2->id] = [
                    'subject_id'      => $sub2->id,
                    'subject_code'    => $sub2->code ?? 'N/A',
                    'subject_name'    => $sub2->name,
                    'full_mark'       => $full2,
                    'cq'              => $mRec2?->cq,
                    'mcq'             => $mRec2?->mcq,
                    'practical'       => $mRec2?->practical,
                    'marks'           => $raw2,
                    'highest_mark'    => $highest2 ?? '---',
                    'is_paired'       => true,
                    'is_first'        => false,
                    'combined_full'   => $combinedFull,
                    'combined_marks'  => $combinedMarks,
                    'grade'           => $gradeInfo['grade'],
                    'point'           => $gradeInfo['point'],
                    'status'          => $mRec2?->status ?? 'present',
                ];

            } else {
                // Standalone Subject
                $sub = $group['subjects'][0];
                $mRec = $allMarks->where('student_id', $student->id)->where('subject_id', $sub->id)->first();
                $raw = $mRec ? $mRec->marks : 0;
                $full = AssignClass::where(['class_id' => $classId, 'subject_id' => $sub->id])->value('full_mark') ?? 100;

                $totalMarks += $raw;
                $gradeInfo = $this->getGradeWithPoint($raw, $full);

                if ($gradeInfo['grade'] === 'F') {
                    $failCount++;
                } else {
                    $totalPoints += $gradeInfo['point'];
                }

                $highest = $allMarks->where('subject_id', $sub->id)->max('marks');

                $marksData[$sub->id] = [
                    'subject_id'      => $sub->id,
                    'subject_code'    => $sub->code ?? 'N/A',
                    'subject_name'    => $sub->name,
                    'full_mark'       => $full,
                    'cq'              => $mRec?->cq,
                    'mcq'             => $mRec?->mcq,
                    'practical'       => $mRec?->practical,
                    'marks'           => $raw,
                    'highest_mark'    => $highest ?? '---',
                    'is_paired'       => false,
                    'is_first'        => true,
                    'combined_full'   => $full,
                    'combined_marks'  => $raw,
                    'grade'           => $gradeInfo['grade'],
                    'point'           => $gradeInfo['point'],
                    'status'          => $mRec?->status ?? 'present',
                ];
            }
        }

        $gpa = ($failCount > 0) ? 0.00 : (($subjectUnitCount > 0) ? round($totalPoints / $subjectUnitCount, 2) : 0.00);

        return [
            'student_id'         => $student->id,
            'total_marks'        => $totalMarks,
            'fail_count'         => $failCount,
            'total_points'       => $totalPoints,
            'subject_unit_count' => $subjectUnitCount,
            'gpa'                => (float)$gpa,
            'gpa_text'           => ($failCount > 0) ? "0.00 (F-$failCount)" : number_format($gpa, 2),
            'marks_data'         => $marksData,
        ];
    }

    public function autoSave(Request $request, $tenant) 
    {
        $schoolId = auth()->user()->school_id;
        
        $academicYear = AcademicYear::where('school_id', $schoolId)
                        ->where('is_active', 1)
                        ->value('id');

        $cq        = ($request->cq !== null && $request->cq !== '') ? (int)$request->cq : null;
        $mcq       = ($request->mcq !== null && $request->mcq !== '') ? (int)$request->mcq : null;
        $practical = ($request->practical !== null && $request->practical !== '') ? (int)$request->practical : null;

        // If CQ, MCQ, or Practical is entered, total = CQ + MCQ + Practical
        if ($cq !== null || $mcq !== null || $practical !== null) {
            $totalMarks = (int)(($cq ?? 0) + ($mcq ?? 0) + ($practical ?? 0));
        } else {
            $totalMarks = ($request->marks !== null && $request->marks !== '') ? (int)$request->marks : null;
        }

        // ডাটা আপডেট বা ক্রিয়েট
        Mark::updateOrCreate(
            [
                'school_id'        => $schoolId,
                'academic_year_id' => $academicYear,
                'student_id'       => $request->student_id,
                'class_id'         => $request->class_id,
                'subject_id'       => $request->subject_id,
                'exam_id'          => $request->exam_id
            ],
            [
                'cq'        => $cq,
                'mcq'       => $mcq,
                'practical' => $practical,
                'marks'     => $totalMarks,
                'status'    => $request->status ?? 'present'
            ]
        );

        $fullMark = $request->full_marks ?? (AssignClass::where(['class_id' => $request->class_id, 'subject_id' => $request->subject_id])->value('full_mark') ?? 100);
        $gradeInfo = $this->getGradeWithPoint($totalMarks, $fullMark);

        return response()->json([
            'status'  => true,
            'message' => 'Saved Successfully',
            'marks'   => $totalMarks,
            'grade'   => $gradeInfo['grade'],
            'point'   => $gradeInfo['point'],
        ]);
    }

    public function statusUpdate(Request $request, $tenant)
    {
        $schoolId = auth()->user()->school_id;

        // একটিভ একাডেমিক ইয়ার খুঁজে বের করা
        $academicYearId = AcademicYear::where('school_id', $schoolId)
                            ->where('is_active', 1)
                            ->value('id');

        // যদি স্ট্যাটাস 'absent' হয়, তবে মার্কস ০ করে দেওয়া ভালো
        $isAbsent = ($request->status === 'absent');
        $cq        = $isAbsent ? 0 : (($request->cq !== null && $request->cq !== '') ? (float)$request->cq : null);
        $mcq       = $isAbsent ? 0 : (($request->mcq !== null && $request->mcq !== '') ? (float)$request->mcq : null);
        $practical = $isAbsent ? 0 : (($request->practical !== null && $request->practical !== '') ? (float)$request->practical : null);
        $marks     = $isAbsent ? 0 : $request->marks;

        Mark::updateOrCreate(
            [
                'school_id'        => $schoolId,
                'academic_year_id' => $academicYearId,
                'student_id'       => $request->student_id,
                'class_id'         => $request->class_id,
                'subject_id'       => $request->subject_id,
                'exam_id'          => $request->exam_id
            ],
            [
                'status'    => $request->status, // 'present' অথবা 'absent'
                'cq'        => $cq,
                'mcq'       => $mcq,
                'practical' => $practical,
                'marks'     => $marks
            ]
        );

        return response()->json([
            'status'  => true, 
            'message' => 'Status Updated Successfully'
        ]);
    }

    public function viewMarks(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $layout = 'layouts.school';

        $classes = Classes::where('school_id', $schoolId)->get();
        $examTypes = Exam::where('school_id', $schoolId)->where('is_published', 1)->get();
        $academicYears = AcademicYear::where('school_id', $schoolId)->orderBy('name', 'desc')->get();

        $selectedClassId   = $request->class_id;
        $selectedExamId    = $request->exam_id;
        $selectedSubjectId = $request->subject_id; // ← নতুন
        $selectedYearId    = $request->academic_year_id
                                ?? AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->value('id');

        $students      = collect();
        $subjects      = collect();
        $marksData     = [];
        $meritPosition = [];
        $meritList     = [];
        $paginatedResults = null;

        // সিঙ্গেল সাবজেক্ট মোডের জন্য
        $selectedSubject  = null;
        $subjectMarks     = collect(); // student_id => mark record
        $fullMark         = null;

        // ক্লাস সিলেক্ট হলে সাবজেক্ট লোড করি
        if ($selectedClassId) {
            $subjectIds = AssignClass::where('class_id', $selectedClassId)
                            ->where('school_id', $schoolId)
                            ->pluck('subject_id');
            $subjects = Subject::whereIn('id', $subjectIds)->get();
        }

        if ($selectedClassId && $selectedExamId && $selectedYearId) {

            $currentYearId = AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->value('id');

            // স্টুডেন্ট লোড
            if ($selectedYearId == $currentYearId) {
                $students = Student::where([
                    'class_id'         => $selectedClassId,
                    'academic_year_id' => $selectedYearId,
                    'school_id'        => $schoolId,
                ])->orderBy('roll')->get();
            } else {
                $studentIdsInSession = DB::table('student_sessions')
                    ->where('class_id', $selectedClassId)
                    ->where('academic_year_id', $selectedYearId)
                    ->pluck('student_id');
                $students = Student::whereIn('id', $studentIdsInSession)->orderBy('roll')->get();
            }

            // ══════════════════════════════════════════════
            // মোড ১: সিঙ্গেল সাবজেক্ট ভিউ + এডিট
            // ══════════════════════════════════════════
            if ($selectedSubjectId) {
                $selectedSubject = Subject::find($selectedSubjectId);

                $fullMark = AssignClass::where([
                    'class_id'   => $selectedClassId,
                    'subject_id' => $selectedSubjectId,
                ])->value('full_mark') ?? 100;

                $subjectMarks = Mark::where([
                    'school_id'        => $schoolId,
                    'class_id'         => $selectedClassId,
                    'exam_id'          => $selectedExamId,
                    'subject_id'       => $selectedSubjectId,
                    'academic_year_id' => $selectedYearId,
                ])->get()->keyBy('student_id');

            } else {
                // ══════════════════════════════════════════
                // মোড ২: সব সাবজেক্ট রিপোর্ট (আগের লজিক)
                // ══════════════════════════════════════════
                $allMarks = Mark::where([
                    'class_id'         => $selectedClassId,
                    'exam_id'          => $selectedExamId,
                    'academic_year_id' => $selectedYearId,
                    'school_id'        => $schoolId,
                ])->get();

                if ($students->isNotEmpty()) {
                    foreach ($students as $student) {
                        $stSummary = $this->calculateStudentMarksheetData($student, $subjects, $allMarks, $selectedClassId);

                        // Individual subject marks for table view
                        foreach ($subjects as $subject) {
                            $mRecord = $allMarks->where('student_id', $student->id)->where('subject_id', $subject->id)->first();
                            $fm = AssignClass::where(['class_id' => $selectedClassId, 'subject_id' => $subject->id])->value('full_mark') ?? 100;
                            $rawMark = $mRecord ? $mRecord->marks : null;
                            $gradeInfo = $this->getGradeWithPoint($rawMark, $fm);
                            $marksData[$student->id][$subject->id] = ['marks' => $rawMark, 'grade' => $gradeInfo['grade']];
                        }

                        $marksData[$student->id]['GPA'] = $stSummary['gpa_text'];

                        $meritList[] = [
                            'student_id'  => $student->id,
                            'fail_count'  => $stSummary['fail_count'],
                            'total_marks' => $stSummary['total_marks'],
                            'gpa'         => $stSummary['gpa'],
                        ];
                    } // end foreach($students)

                    // মেধাক্রম সর্টিং
                    usort($meritList, function ($a, $b) {
                        if ($b['gpa'] != $a['gpa']) return $b['gpa'] <=> $a['gpa'];
                        if ($b['total_marks'] != $a['total_marks']) return $b['total_marks'] <=> $a['total_marks'];
                        return $a['fail_count'] <=> $b['fail_count'];
                    });

                    foreach ($meritList as $index => $item) {
                        $meritPosition[$item['student_id']] = $index + 1;
                    }

                    // পেজিনেশন
                    $currentPage      = LengthAwarePaginator::resolveCurrentPage();
                    $itemCollection   = collect($meritList);
                    $perPage          = 10;
                    $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

                    $paginatedResults = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
                    $paginatedResults->setPath($request->url());
                    $paginatedResults->appends($request->all());

                } // end if($students->isNotEmpty())
            } // end else (mode 2)
        } // end if($selectedClassId && $selectedExamId && $selectedYearId)

        return view('school.mark.view', compact(
            'layout', 'classes', 'examTypes', 'academicYears',
            'selectedClassId', 'selectedYearId', 'selectedExamId', 'selectedSubjectId',
            'students', 'subjects', 'marksData', 'meritPosition', 'paginatedResults',
            'selectedSubject', 'subjectMarks', 'fullMark'
        ));
    }

    public function generateMarksheet($tenant, $studentId, $classId, $examId, Request $request)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
    
        if (!$school) {
            abort(404, 'School not found.');
        }
        
        $schoolId = $school->id;
        
        // ১. বেসিক ডাটা লোড
        $student = Student::where('id', $studentId)->where('school_id', $schoolId)->firstOrFail();
        $exam    = Exam::where('id', $examId)->where('school_id', $schoolId)->where('is_published', 1)->firstOrFail();
        $class   = Classes::where('id', $classId)->where('school_id', $schoolId)->firstOrFail();
        $targetYearId = $exam->year_id;

        $currentYearId    = AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->value('id');
        
        $academicYearName = AcademicYear::where('id', $targetYearId)->value('name');

        // ২. সেশন হিস্ট্রি এবং মেধাক্রমের জন্য আইডি সংগ্রহ (লজিক ফিক্সড)
        if ($targetYearId == $currentYearId) {
            // চলতি শিক্ষাবর্ষ: সরাসরি স্টুডেন্ট টেবিল থেকে ডাটা নিবে
            $displayRoll     = $student->roll;
            $displayCustomId = $student->student_id;

            $allUniqueIds = Student::where([
                'class_id'         => $classId, 
                'academic_year_id' => $targetYearId, 
                'school_id'        => $schoolId
            ])->pluck('id')->toArray();
        } else {
            // পুরনো শিক্ষাবর্ষ: সেশন টেবিল থেকে হিস্ট্রি নিবে
            $history = DB::table('student_sessions')
                        ->where(['student_id' => $studentId, 'academic_year_id' => $targetYearId])
                        ->first();

            $displayRoll     = $history ? $history->old_roll : $student->roll;
            $displayCustomId = $history ? $history->old_student_id : $student->student_id;

            $allUniqueIds = DB::table('student_sessions')
                            ->where(['class_id' => $classId, 'academic_year_id' => $targetYearId])
                            ->pluck('student_id')
                            ->toArray();
        }
        

        // যদি লিস্ট খালি থাকে (নিরাপত্তার জন্য)
        if (empty($allUniqueIds)) {
            $allUniqueIds = [$studentId];
        }

        // ৩. স্টুডেন্ট, সাবজেক্ট এবং মার্কস লোড
        $allStudents = Student::whereIn('id', $allUniqueIds)->get();
        
        $subjectIds = AssignClass::where('class_id', $classId)
                        ->where('school_id', $schoolId)
                        ->pluck('subject_id');
                        
        $subjects   = Subject::whereIn('id', $subjectIds)->get();
        
        $allMarks   = Mark::where([
                        'class_id'         => $classId, 
                        'exam_id'          => $examId, 
                        'academic_year_id' => $targetYearId, 
                        'school_id'        => $schoolId
                    ])->get();

        if ($allMarks->isEmpty()) return back()->with('error', 'এই পরীক্ষার কোনো নম্বর খুঁজে পাওয়া যায়নি।');

        // ৪. রেজাল্ট ও মেধাক্রম প্রসেসিং
        $meritList = [];
        $targetStudentMarks = [];

        foreach ($allStudents as $st) {
            $stSummary = $this->calculateStudentMarksheetData($st, $subjects, $allMarks, $classId);

            $meritList[] = [
                'id'    => $st->id,
                'total' => $stSummary['total_marks'],
                'gpa'   => $stSummary['gpa'],
                'fail'  => $stSummary['fail_count'],
            ];

            if ((int)$st->id === (int)$studentId) {
                $targetStudentMarks = $stSummary['marks_data'];
            }
        }

        // ৫. সর্টিং ও পজিশন বের করা
        usort($meritList, function($a, $b) {
            if ($a['fail'] !== $b['fail']) return $a['fail'] <=> $b['fail'];
            return $b['gpa'] <=> $a['gpa'] ?: $b['total'] <=> $a['total'];
        });

        $meritPosition = 0;
        foreach($meritList as $key => $m) { 
            if ($m['id'] == $studentId) {
                $meritPosition = $key + 1;
                break;
            } 
        }
        
        $targetData = collect($meritList)->where('id', $studentId)->first();
        $numericGpa = $targetData['gpa'] ?? 0;
        $failCount  = $targetData['fail'] ?? 0;
        if ($failCount > 0) {
            $finalGrade = 'F';
        } elseif ($numericGpa >= 5.0) {
            $finalGrade = 'A+';
        } elseif ($numericGpa >= 4.0) {
            $finalGrade = 'A';
        } elseif ($numericGpa >= 3.5) {
            $finalGrade = 'A-';
        } elseif ($numericGpa >= 3.0) {
            $finalGrade = 'B';
        } elseif ($numericGpa >= 2.0) {
            $finalGrade = 'C';
        } elseif ($numericGpa >= 1.0) {
            $finalGrade = 'D';
        } else {
            $finalGrade = 'F';
        }

        $highestTotal = collect($meritList)->max('total');

        // Attendance Report
        $attendances = \App\Models\Attendance::where('student_id', $studentId)
                        ->where('class_id', $classId)
                        ->get();
        $totalWorkingDays = $attendances->count();
        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $attendancePercentage = $totalWorkingDays > 0 ? round(($presentDays / $totalWorkingDays) * 100) : 0;

        // ৬. স্কুল ও PDF ডাটা তৈরি
        $school = DB::table('schools')->find($schoolId);

        $instituteLogo = public_path($school->logo ?? 'no-logo.png');
        $studentPhoto = public_path($student->photo ?? 'no-image.png');

        $data = [
            'student'              => $student,
            'displayRoll'          => $displayRoll,
            'displayCustomId'      => $displayCustomId,
            'class'                => $class,
            'exam'                 => $exam,
            'marksData'            => $targetStudentMarks,
            'totalMarks'           => $targetData['total'],
            'highestTotal'         => $highestTotal,
            'gpa'                  => ($failCount > 0) ? "0.00 (F-{$failCount})" : number_format($numericGpa, 2),
            'numericGpa'           => number_format($numericGpa, 2),
            'finalGrade'           => $finalGrade,
            'meritPosition'        => $meritPosition,
            'schoolName'           => $school->name ?? 'School Name',
            'address'              => $school->address ?? 'Address',
            'emis'                 => $school->emis_code ?? 'N/A',
            'academic_year'        => $academicYearName,
            'instituteLogo'        => $this->compressImageToBase64($instituteLogo, 160),
            'studentPhoto'         => $this->compressImageToBase64($studentPhoto, 120),
            'formattedDOB'         => $student->date_of_birth ? date('Y-m-d', strtotime($student->date_of_birth)) : 'N/A',
            'totalWorkingDays'     => $totalWorkingDays,
            'presentDays'          => $presentDays,
            'absentDays'           => $absentDays,
            'attendancePercentage' => $attendancePercentage
        ];

        $pdf = Pdf::loadView('school.mark.marksheet-pdf', $data);
        return $pdf->download('marksheet-'.$displayCustomId.'.pdf');
    }

    public function generateBulkMarksheet($tenant, $classId, $examId, Request $request)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
        if (!$school) {
            abort(404, 'School not found.');
        }
        $schoolId = $school->id;

        $exam   = Exam::where('id', $examId)->where('school_id', $schoolId)->where('is_published', 1)->firstOrFail();
        $class  = Classes::where('id', $classId)->where('school_id', $schoolId)->firstOrFail();
        $targetYearId = $request->academic_year_id ?? $exam->year_id;

        $currentYearId    = AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->value('id');
        $academicYearName = AcademicYear::where('id', $targetYearId)->value('name');

        if ($targetYearId == $currentYearId) {
            $allStudents = Student::where([
                'class_id'         => $classId, 
                'academic_year_id' => $targetYearId, 
                'school_id'        => $schoolId
            ])->orderBy('roll', 'asc')->get();
        } else {
            $sessionStudentIds = DB::table('student_sessions')
                            ->where(['class_id' => $classId, 'academic_year_id' => $targetYearId])
                            ->pluck('student_id')
                            ->toArray();
            $allStudents = Student::whereIn('id', $sessionStudentIds)->orderBy('roll', 'asc')->get();
        }

        if ($allStudents->isEmpty()) {
            return back()->with('error', 'এই ক্লাসের কোনো শিক্ষার্থী পাওয়া যায়নি।');
        }

        $subjectIds = AssignClass::where('class_id', $classId)
                        ->where('school_id', $schoolId)
                        ->pluck('subject_id');
        $subjects   = Subject::whereIn('id', $subjectIds)->get();

        $allMarks   = Mark::where([
                        'class_id'         => $classId, 
                        'exam_id'          => $examId, 
                        'academic_year_id' => $targetYearId, 
                        'school_id'        => $schoolId
                    ])->get();

        if ($allMarks->isEmpty()) {
            return back()->with('error', 'এই পরীক্ষার কোনো নম্বর খুঁজে পাওয়া যায়নি।');
        }

        // Calculate summaries and merit list
        $studentSummaries = [];
        $meritList = [];

        foreach ($allStudents as $st) {
            $stSummary = $this->calculateStudentMarksheetData($st, $subjects, $allMarks, $classId);
            $studentSummaries[$st->id] = $stSummary;

            $meritList[] = [
                'id'    => $st->id,
                'total' => $stSummary['total_marks'],
                'gpa'   => $stSummary['gpa'],
                'fail'  => $stSummary['fail_count'],
            ];
        }

        // Sorting for merit positions
        usort($meritList, function($a, $b) {
            if ($a['fail'] !== $b['fail']) return $a['fail'] <=> $b['fail'];
            return $b['gpa'] <=> $a['gpa'] ?: $b['total'] <=> $a['total'];
        });

        $meritMap = [];
        foreach ($meritList as $key => $m) {
            $meritMap[$m['id']] = $key + 1;
        }

        $instituteLogo = public_path($school->logo ?? 'no-logo.png');
        $compressedLogo = $this->compressImageToBase64($instituteLogo, 160);

        $sheets = [];
        foreach ($allStudents as $student) {
            if ($targetYearId == $currentYearId) {
                $displayRoll     = $student->roll;
                $displayCustomId = $student->student_id;
            } else {
                $history = DB::table('student_sessions')
                            ->where(['student_id' => $student->id, 'academic_year_id' => $targetYearId])
                            ->first();
                $displayRoll     = $history ? $history->old_roll : $student->roll;
                $displayCustomId = $history ? $history->old_student_id : $student->student_id;
            }

            $stSummary   = $studentSummaries[$student->id] ?? null;
            $targetData  = collect($meritList)->where('id', $student->id)->first();
            $numericGpa  = $targetData['gpa'] ?? 0;
            $failCount   = $targetData['fail'] ?? 0;

            if ($failCount > 0) {
                $finalGrade = 'F';
            } elseif ($numericGpa >= 5.0) {
                $finalGrade = 'A+';
            } elseif ($numericGpa >= 4.0) {
                $finalGrade = 'A';
            } elseif ($numericGpa >= 3.5) {
                $finalGrade = 'A-';
            } elseif ($numericGpa >= 3.0) {
                $finalGrade = 'B';
            } elseif ($numericGpa >= 2.0) {
                $finalGrade = 'C';
            } elseif ($numericGpa >= 1.0) {
                $finalGrade = 'D';
            } else {
                $finalGrade = 'F';
            }

            $sheets[] = [
                'student'         => $student,
                'displayRoll'     => $displayRoll,
                'displayCustomId' => $displayCustomId,
                'marksData'       => $stSummary['marks_data'] ?? [],
                'totalMarks'      => $targetData['total'] ?? 0,
                'numericGpa'      => number_format($numericGpa, 2),
                'finalGrade'      => $finalGrade,
                'meritPosition'   => $meritMap[$student->id] ?? 0,
                'formattedDOB'    => $student->date_of_birth ? date('Y-m-d', strtotime($student->date_of_birth)) : 'N/A',
            ];
        }

        $data = [
            'class'            => $class,
            'exam'             => $exam,
            'schoolName'       => $school->name ?? 'School Name',
            'academic_year'    => $academicYearName,
            'instituteLogo'    => $compressedLogo,
            'sheets'           => $sheets,
        ];

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $pdf = Pdf::loadView('school.mark.bulk-marksheet-pdf', $data);
        $fileName = 'marksheet-class-' . Str::slug($class->name) . '-' . Str::slug($exam->name) . '.pdf';
        return $pdf->download($fileName);
    }

    private function compressImageToBase64($path, $maxWidth = 160)
    {
        if (!file_exists($path) || !is_file($path)) return '';
        try {
            $info = @getimagesize($path);
            if (!$info) return '';
            
            $width  = $info[0];
            $height = $info[1];
            $mime   = $info['mime'];
            
            // Calculate proportional dimensions
            if ($width > $maxWidth) {
                $newWidth  = $maxWidth;
                $newHeight = (int)floor($height * ($maxWidth / $width));
            } else {
                $newWidth  = $width;
                $newHeight = $height;
            }
            
            $image = null;
            if ($mime == 'image/jpeg' || $mime == 'image/jpg') $image = @imagecreatefromjpeg($path);
            elseif ($mime == 'image/png') $image = @imagecreatefrompng($path);
            elseif ($mime == 'image/webp') $image = @imagecreatefromwebp($path);
            
            if ($image) {
                $newImage = imagecreatetruecolor($newWidth, $newHeight);
                
                if ($mime == 'image/png' || $mime == 'image/webp') {
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                    $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                    imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
                }
                
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                
                ob_start();
                if ($mime == 'image/png') {
                    imagepng($newImage, null, 8); // PNG compression 0-9
                    $outMime = 'image/png';
                } elseif ($mime == 'image/webp') {
                    imagewebp($newImage, null, 60);
                    $outMime = 'image/webp';
                } else {
                    imagejpeg($newImage, null, 60); // JPEG quality 60%
                    $outMime = 'image/jpeg';
                }
                $imageData = ob_get_clean();
                
                imagedestroy($image);
                imagedestroy($newImage);
                
                return 'data:' . $outMime . ';base64,' . base64_encode($imageData);
            }
            return '';
        } catch (\Exception $e) {
            return '';
        }
    }

    public function downloadResultSheet(Request $request, $tenant)
    {
        $schoolId = auth()->user()->school_id;
        $classId = $request->class_id;
        $examId = $request->exam_id;
        $yearId = $request->academic_year_id; // রিকোয়েস্ট থেকে বছর নিন

        $class = Classes::findOrFail($classId);
        $exam = Exam::findOrFail($examId);
        
        // স্টুডেন্ট ফিল্টার হবে ওই নির্দিষ্ট বছরের জন্য
        $students = Student::where('class_id', $classId)
                    ->where('academic_year_id', $yearId)
                    ->where('school_id', $schoolId)
                    ->get();

        $allMarks = Mark::where([
            'class_id' => $classId, 
            'exam_id' => $examId, 
            'school_id' => $schoolId,
            'academic_year_id' => $yearId // বছর ফিল্টার
        ])->get();
        
        $subjects = Subject::whereIn('id', AssignClass::where('class_id', $classId)->pluck('subject_id'))->get();
        $results = [];
        foreach ($students as $student) {
            $stSummary = $this->calculateStudentMarksheetData($student, $subjects, $allMarks, $classId);

            $results[] = [
                'roll'        => $student->student_id ?? $student->id,
                'name'        => $student->name,
                'gpa'         => $stSummary['gpa_text'],
                'numeric_gpa' => $stSummary['gpa'],
                'fail_count'  => $stSummary['fail_count'],
                'total_marks' => $stSummary['total_marks']
            ];
        }

        
        usort($results, function($a, $b) {
            // প্রথমে GPA চেক
            if ($b['numeric_gpa'] != $a['numeric_gpa']) {
                return $b['numeric_gpa'] <=> $a['numeric_gpa'];
            }
            // GPA সমান হলে Total Marks চেক
            if ($b['total_marks'] != $a['total_marks']) {
                return $b['total_marks'] <=> $a['total_marks'];
            }
            // সব সমান হলে যার ফেল সংখ্যা কম সে আগে থাকবে
            return $a['fail_count'] <=> $b['fail_count'];
        });

        $pdf = Pdf::loadView('school.mark.result-sheet-pdf', compact('results', 'class', 'exam'));
        return $pdf->download("Result_Sheet_{$class->name}_{$exam->name}.pdf");
    }

    public function downloadExamResultSummary(Request $request, $tenant)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
        if (!$school) {
            abort(404, 'School not found.');
        }
        $schoolId = $school->id;

        $examId = $request->exam_id;
        $yearId = $request->academic_year_id;
        $classId = $request->class_id;

        $exam = Exam::where('id', $examId)->where('school_id', $schoolId)->firstOrFail();
        $targetYearId = $yearId ?? $exam->year_id;
        $currentYearId = AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->value('id');
        $academicYearName = AcademicYear::where('id', $targetYearId)->value('name');

        // Fetch classes to process
        if (!empty($classId)) {
            $classes = Classes::where('id', $classId)->where('school_id', $schoolId)->get();
        } else {
            $classes = Classes::where('school_id', $schoolId)->get();
        }

        $classesData = [];

        foreach ($classes as $class) {
            if ($targetYearId == $currentYearId) {
                $students = Student::where([
                    'class_id'         => $class->id,
                    'academic_year_id' => $targetYearId,
                    'school_id'        => $schoolId
                ])->orderBy('roll', 'asc')->get();
            } else {
                $sessionStudentIds = DB::table('student_sessions')
                    ->where(['class_id' => $class->id, 'academic_year_id' => $targetYearId])
                    ->pluck('student_id')
                    ->toArray();
                $students = Student::whereIn('id', $sessionStudentIds)->orderBy('roll', 'asc')->get();
            }

            if ($students->isEmpty()) {
                continue;
            }

            $subjectIds = AssignClass::where('class_id', $class->id)
                ->where('school_id', $schoolId)
                ->pluck('subject_id');
            $subjects = Subject::whereIn('id', $subjectIds)->get();

            $allMarks = Mark::where([
                'class_id'         => $class->id,
                'exam_id'          => $examId,
                'academic_year_id' => $targetYearId,
                'school_id'        => $schoolId
            ])->get();

            if ($allMarks->isEmpty()) {
                continue;
            }

            $results = [];
            foreach ($students as $student) {
                if ($targetYearId == $currentYearId) {
                    $displayRoll = $student->roll;
                    $displayId   = $student->student_id ?? $student->id;
                } else {
                    $history = DB::table('student_sessions')
                        ->where(['student_id' => $student->id, 'academic_year_id' => $targetYearId])
                        ->first();
                    $displayRoll = $history ? $history->old_roll : $student->roll;
                    $displayId   = $history ? $history->old_student_id : ($student->student_id ?? $student->id);
                }

                $stSummary = $this->calculateStudentMarksheetData($student, $subjects, $allMarks, $class->id);
                $numericGpa = $stSummary['gpa'] ?? 0;
                $failCount  = $stSummary['fail_count'] ?? 0;

                if ($failCount > 0) {
                    $finalGrade = 'F';
                } elseif ($numericGpa >= 5.0) {
                    $finalGrade = 'A+';
                } elseif ($numericGpa >= 4.0) {
                    $finalGrade = 'A';
                } elseif ($numericGpa >= 3.5) {
                    $finalGrade = 'A-';
                } elseif ($numericGpa >= 3.0) {
                    $finalGrade = 'B';
                } elseif ($numericGpa >= 2.0) {
                    $finalGrade = 'C';
                } elseif ($numericGpa >= 1.0) {
                    $finalGrade = 'D';
                } else {
                    $finalGrade = 'F';
                }

                $results[] = [
                    'student_id'  => $student->id,
                    'display_id'  => $displayId,
                    'roll'        => $displayRoll,
                    'name'        => $student->name,
                    'total_marks' => $stSummary['total_marks'],
                    'numeric_gpa' => $numericGpa,
                    'gpa_text'    => $failCount > 0 ? '0.00' : number_format($numericGpa, 2),
                    'grade'       => $finalGrade,
                    'fail_count'  => $failCount,
                ];
            }

            if (empty($results)) {
                continue;
            }

            // Sort by Merit (GPA desc, Total desc, Fail count asc, Roll asc)
            usort($results, function($a, $b) {
                if ($a['fail_count'] !== $b['fail_count']) return $a['fail_count'] <=> $b['fail_count'];
                if ($b['numeric_gpa'] != $a['numeric_gpa']) return $b['numeric_gpa'] <=> $a['numeric_gpa'];
                if ($b['total_marks'] != $a['total_marks']) return $b['total_marks'] <=> $a['total_marks'];
                return (int)$a['roll'] <=> (int)$b['roll'];
            });

            // Assign merit rank
            foreach ($results as $index => &$res) {
                $res['merit'] = $index + 1;
            }
            unset($res);

            // Sort by Roll number ascending (for student convenience)
            usort($results, function($a, $b) {
                return (int)$a['roll'] <=> (int)$b['roll'];
            });

            // Compute class statistics
            $totalCount = count($results);
            $passCount  = collect($results)->where('fail_count', 0)->count();
            $failCountTotal = $totalCount - $passCount;
            $passRate   = $totalCount > 0 ? round(($passCount / $totalCount) * 100, 1) : 0;
            $highestMark = collect($results)->max('total_marks') ?? 0;
            $passedStudents = collect($results)->where('fail_count', 0);
            $avgGpa = $passedStudents->count() > 0 ? number_format($passedStudents->avg('numeric_gpa'), 2) : '0.00';

            // Split into 2 vertical columns for side-by-side display
            $half = (int)ceil($totalCount / 2);
            $leftCol = array_slice($results, 0, $half);
            $rightCol = array_slice($results, $half);

            $classesData[] = [
                'class'         => $class,
                'total_count'   => $totalCount,
                'pass_count'    => $passCount,
                'fail_count'    => $failCountTotal,
                'pass_rate'     => $passRate,
                'highest_mark'  => $highestMark,
                'avg_gpa'       => $avgGpa,
                'left_col'      => $leftCol,
                'right_col'     => $rightCol,
                'max_rows'      => max(count($leftCol), count($rightCol)),
            ];
        }

        if (empty($classesData)) {
            return back()->with('error', 'এই পরীক্ষার কোনো ফলাফল পাওয়া যায়নি।');
        }

        $instituteLogo = public_path($school->logo ?? 'no-logo.png');
        $compressedLogo = $this->compressImageToBase64($instituteLogo, 160);

        $data = [
            'school'           => $school,
            'exam'             => $exam,
            'academic_year'    => $academicYearName,
            'instituteLogo'    => $compressedLogo,
            'classesData'      => $classesData,
        ];

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $pdf = Pdf::loadView('school.mark.result-summary-pdf', $data);
        $fileName = 'Result_Summary_' . Str::slug($exam->name) . '_' . Str::slug($academicYearName ?? date('Y')) . '.pdf';
        return $pdf->download($fileName);
    }

    public function promotionForm()
    {
        $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->get();
        $examTypes = Exam::where('school_id', $schoolId)->get();
        $academicYears = AcademicYear::where('school_id', $schoolId)->get();
        $layout = 'layouts.school';
        return view('school.mark.promote', compact('classes', 'examTypes', 'academicYears', 'layout'));
    }
    private function getStudentIdForYear($studentTableId, $academicYearId)
    {
        // প্রথমে চেক করুন স্টুডেন্ট বর্তমানে ওই বছরে আছে কি না
        $student = Student::where('id', $studentTableId)
                        ->where('academic_year_id', $academicYearId)
                        ->first();
        
        if ($student) {
            return $student->student_id;
        }

        // যদি বর্তমান বছরে না থাকে, তবে সেশন টেবিল থেকে পুরনো আইডি খুঁজুন
        $history = DB::table('student_sessions')
                    ->where('student_id', $studentTableId)
                    ->where('academic_year_id', $academicYearId)
                    ->first();

        return $history ? $history->old_student_id : null;
    }
    public function promoteStudents(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate([
            'current_class_id' => 'required',
            'next_class_id' => 'required',
            'next_academic_year_id' => 'required'
        ]);

        // ১. বর্তমান ক্লাসের স্টুডেন্টদের আইডি অনুযায়ী সিরিয়াল করা (যাতে রোল সিরিয়াল ঠিক থাকে)
        $students = Student::where('class_id', $request->current_class_id)
                    ->where('school_id', $schoolId)
                    ->orderBy('id', 'asc') 
                    ->get();

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'এই ক্লাসে কোনো স্টুডেন্ট পাওয়া যায়নি।');
        }

        try {
            DB::transaction(function () use ($students, $request) {
                $sessionsData = [];

                foreach ($students as $index => $student) {
                    // ২. সেশন টেবিলে বর্তমান (পুরনো) ডাটা ব্যাকআপ রাখা
                    $sessionsData[] = [
                        'student_id'       => $student->id,         // মেইন প্রাইমারি আইডি
                        'class_id'         => $student->class_id,   // পুরনো ক্লাস
                        'academic_year_id' => $student->academic_year_id, // পুরনো বছর
                        'old_student_id'   => $student->student_id, // পুরনো কাস্টম আইডি (যা ফিক্সড থাকবে)
                        'old_roll'         => $student->roll,       // পুরনো রোল
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ];

                    // ৩. শুধুমাত্র ক্লাস, রোল এবং বছর আপডেট করা (Student ID বদলাবে না)
                    $newRoll = $index + 1;

                    $student->update([
                        'class_id'         => $request->next_class_id,
                        'academic_year_id' => $request->next_academic_year_id,
                        'roll'             => $newRoll
                        // এখানে 'student_id' আপডেট করার দরকার নেই, কারণ এটি পারমানেন্ট।
                    ]);
                }

                // ৪. একবারে সব ব্যাকআপ ডাটা ইনসার্ট করা
                DB::table('student_sessions')->insert($sessionsData);
            });

            return redirect()->back()->with('success', 'প্রমোশন সফল হয়েছে। স্টুডেন্ট আইডি অপরিবর্তিত রেখে ক্লাস ও রোল আপডেট করা হয়েছে।');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ত্রুটি: ' . $e->getMessage());
        }
    }

    public function publicResult(Request $request, $tenant)
    {
        $school = DB::table('schools')->where('slug', $tenant)->first();
        if (!$school) {
            return response()->json(['status' => false, 'message' => 'School not found.'], 404);
        }

        $schoolId        = $school->id;
        $customId        = trim($request->student_id ?? '');
        $selectedYearId  = $request->academic_year_id;
        $selectedClassId = $request->class_id;
        $selectedExamId  = $request->exam_id;
        $selectedCatId   = $request->category_id;

        if (!$customId) {
            return response()->json(['status' => false, 'message' => 'অনুগ্রহ করে স্টুডেন্ট আইডি অথবা রোল প্রদান করুন।'], 422);
        }

        // 1. Find Student:
        // A. Direct exact match by Student ID (e.g. STD-261004)
        $student = Student::where('school_id', $schoolId)
            ->where('student_id', $customId)
            ->first();

        // B. If not found by Student ID:
        if (!$student) {
            // If class IS selected, search by roll in that class
            if ($selectedClassId) {
                $stQuery = Student::where('school_id', $schoolId)
                    ->where('class_id', $selectedClassId)
                    ->where(function ($q) use ($customId) {
                        $q->where('roll', $customId)
                          ->orWhere('student_id', $customId);
                    });

                if ($selectedYearId) {
                    $stQuery->where('academic_year_id', $selectedYearId);
                }

                $student = $stQuery->first();

                // Check student_sessions for past years in this class
                if (!$student) {
                    $sessionQuery = DB::table('student_sessions')
                        ->where('school_id', $schoolId)
                        ->where('class_id', $selectedClassId)
                        ->where(function ($q) use ($customId) {
                            $q->where('old_student_id', $customId)
                              ->orWhere('old_roll', $customId);
                        });
                    if ($selectedYearId) {
                        $sessionQuery->where('academic_year_id', $selectedYearId);
                    }
                    $histId = $sessionQuery->value('student_id');

                    if ($histId) {
                        $student = Student::where('id', $histId)->where('school_id', $schoolId)->first();
                    }
                }

                if (!$student) {
                    return response()->json(['status' => false, 'message' => "নির্বাচিত শ্রেণীতে রোল/আইডি '{$customId}' দিয়ে কোনো শিক্ষার্থী পাওয়া যায়নি।"], 404);
                }
            } else {
                // Class is NOT selected and ID didn't match directly
                return response()->json([
                    'status'  => false,
                    'message' => 'রোল নম্বর দিয়ে ফলাফল দেখতে অনুগ্রহ করে নির্দিষ্ট শ্রেণী (Class) নির্বাচন করুন, অথবা পূর্ণাঙ্গ স্টুডেন্ট আইডি (যেমন: STD-261004) লিখুন।'
                ], 422);
            }
        }

        // 2. Resolve target exam, class, year
        if ($selectedExamId) {
            $exam = Exam::where('id', $selectedExamId)
                ->where('school_id', $schoolId)
                ->where('is_published', 1)
                ->first();

            if (!$exam) {
                return response()->json(['status' => false, 'message' => 'নির্বাচিত পরীক্ষার রেজাল্ট এখনো প্রকাশিত হয়নি।'], 404);
            }

            $examId  = $exam->id;
            
            // Check if mark exists for this student to get the exact class/year
            $markRecord = Mark::where('student_id', $student->id)->where('exam_id', $examId)->where('school_id', $schoolId)->first();
            if ($markRecord) {
                $classId = $markRecord->class_id;
                $yearId  = $markRecord->academic_year_id ?: ($selectedYearId ?: $exam->year_id);
            } else {
                $classId = $selectedClassId ?: $student->class_id;
                $yearId  = $selectedYearId ?: $exam->year_id;
            }
        } else {
            // Find published mark matching student, year, class
            $markQuery = Mark::where('student_id', $student->id)->where('school_id', $schoolId);
            if ($selectedYearId) {
                $markQuery->where('academic_year_id', $selectedYearId);
            }
            if ($selectedClassId) {
                $markQuery->where('class_id', $selectedClassId);
            }

            $latestMark = $markQuery->latest()->first();

            if (!$latestMark) {
                return response()->json(['status' => false, 'message' => 'এই শিক্ষার্থীর জন্য কোনো প্রকাশিত ফলাফল পাওয়া যায়নি।'], 404);
            }

            $examId  = $latestMark->exam_id;
            $classId = $latestMark->class_id;
            $yearId  = $latestMark->academic_year_id;
            $exam    = Exam::find($examId);
        }

        // 3. Load students for class & year (to calculate merit position)
        $currentActiveYearId = AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->value('id');

        if ($yearId == $currentActiveYearId) {
            $allStudentsInClass = Student::where('class_id', $classId)
                ->where('school_id', $schoolId)
                ->where('academic_year_id', $yearId)
                ->get();
        } else {
            $studentIdsInSession = DB::table('student_sessions')
                ->where('class_id', $classId)
                ->where('academic_year_id', $yearId)
                ->pluck('student_id');
            $allStudentsInClass = Student::whereIn('id', $studentIdsInSession)->get();
            if ($allStudentsInClass->isEmpty()) {
                $allStudentsInClass = collect([$student]);
            }
        }

        $subjects = Subject::whereIn('id', AssignClass::where('class_id', $classId)->pluck('subject_id'))->get();
        
        $allMarks = Mark::where([
            'class_id'         => $classId,
            'exam_id'          => $examId,
            'academic_year_id' => $yearId,
            'school_id'        => $schoolId
        ])->get();

    // 5. Calculate Merit Position and GPA
    $meritList = [];
    $targetStudentSummary = null;
    $targetStudentMarksData = [];

    foreach ($allStudentsInClass as $st) {
        $stSummary = $this->calculateStudentMarksheetData($st, $subjects, $allMarks, $classId);

        $resultData = [
            'id'       => $st->id,
            'total'    => $stSummary['total_marks'],
            'gpa'      => $stSummary['gpa'],
            'fail'     => $stSummary['fail_count'],
            'gpa_text' => $stSummary['gpa_text']
        ];

        $meritList[] = $resultData;
        if ($st->id == $student->id) {
            $targetStudentSummary = $resultData;
            $targetStudentMarksData = $stSummary['marks_data'];
        }
    }

    // Sort for Merit
    usort($meritList, function($a, $b) {
        if ($a['fail'] !== $b['fail']) return $a['fail'] <=> $b['fail'];
        return $b['gpa'] <=> $a['gpa'] ?: $b['total'] <=> $a['total'];
    });

    $meritRank = 0;
    foreach($meritList as $key => $m) {
        if ($m['id'] == $student->id) {
            $meritRank = $key + 1;
            break;
        }
    }

    // 6. Return Partial View
    $yearName = \App\Models\AcademicYear::where('id', $yearId)->value('name');

    // Build per-subject marks data for this specific student
    $studentSubjectMarks = [];
    foreach ($targetStudentMarksData as $subItem) {
        $studentSubjectMarks[] = [
            'subject'        => $subItem['subject_name'],
            'cq'             => $subItem['cq'] ?? null,
            'mcq'            => $subItem['mcq'] ?? null,
            'practical'      => $subItem['practical'] ?? null,
            'marks'          => $subItem['marks'],
            'full_mark'      => $subItem['full_mark'],
            'grade'          => $subItem['grade'],
            'point'          => $subItem['point'],
            'status'         => $subItem['status'] ?? 'present',
            'is_paired'      => $subItem['is_paired'],
            'is_first'       => $subItem['is_first'],
            'combined_full'  => $subItem['combined_full'],
            'combined_marks' => $subItem['combined_marks'],
        ];
    }

    $html = view('school.website.partials.result_view', [
        'student'             => $student,
        'exam'                => $exam,
        'studentSummary'      => $targetStudentSummary,
        'meritPosition'       => $meritRank,
        'tenant'              => $tenant,
        'yearName'            => $yearName,
        'studentSubjectMarks' => $studentSubjectMarks,
        'classId'             => $classId,
    ])->render();

        return response()->json([
            'status' => true,
            'data'   => $html
        ]);
    }

    // ═══════════════════════════════════════════════
    //  MARK IMPORT — Form, Import, Template Download
    // ═══════════════════════════════════════════════

    public function importForm()
    {
        $schoolId = Auth::user()->school_id;
        $classes  = Classes::where('school_id', $schoolId)->get();
        $exams    = Exam::where('school_id', $schoolId)->get();
        return view('school.mark.import', compact('classes', 'exams'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file'     => 'required|mimes:xlsx,xls,csv',
            'exam_id'  => 'required|integer',
            'class_id' => 'required|integer',
            'mode'     => 'required|in:single,multi',
        ]);

        $schoolId  = Auth::user()->school_id;
        $examId    = (int)$request->exam_id;
        $classId   = (int)$request->class_id;
        $mode      = $request->mode;
        $subjectId = ($mode === 'single' && $request->subject_id) ? (int)$request->subject_id : null;

        if ($mode === 'single' && !$subjectId) {
            return back()->withErrors(['subject_id' => 'Single mode-এ subject বাছাই করা বাধ্যতামূলক।'])->withInput();
        }

        try {
            $importer = new MarksImport($schoolId, $examId, $classId, $subjectId, $mode);
            Excel::import($importer, $request->file('file'));

            $success = $importer->successCount;
            $skipped = $importer->skipCount;
            $errors  = $importer->importErrors;

            if ($success === 0 && count($errors) > 0) {
                return back()
                    ->with('import_errors', $errors)
                    ->with('error', 'কোনো mark import হয়নি। নিচের সমস্যাগুলো সমাধান করুন।');
            }

            if (count($errors) > 0) {
                return back()
                    ->with('import_errors', $errors)
                    ->with('import_success_count', $success)
                    ->with('import_skip_count', $skipped)
                    ->with('warning', "{$success} জন student-এর mark সফলভাবে import হয়েছে। {$skipped} টি row-এ সমস্যা পাওয়া গেছে।");
            }

            return back()->with('success', "{$success} জন student-এর mark সফলভাবে import হয়েছে!");

        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, '(SQL:')) {
                $msg = trim(substr($msg, 0, strpos($msg, '(SQL:')));
            }
            return back()->with('error', 'Import ব্যর্থ হয়েছে: ' . $msg);
        }
    }

    public function downloadMarkTemplate(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'mode'     => 'required|in:single,multi',
        ]);

        $schoolId    = Auth::user()->school_id;
        $classId     = (int)$request->class_id;
        $mode        = $request->mode;
        $subjectId   = $request->subject_id ? (int)$request->subject_id : null;
        $subjectName = 'marks';

        if ($mode === 'single' && $subjectId) {
            $subjectName = Subject::find($subjectId)?->name ?? 'marks';
        }

        $class     = Classes::find($classId);
        $className = $class ? str_replace(' ', '_', $class->name) : 'class';
        $fileName  = "mark_template_{$className}_{$mode}_" . now()->format('Ymd') . '.xlsx';

        return Excel::download(
            new MarkTemplateExport($schoolId, $classId, $mode, $subjectId, $subjectName),
            $fileName
        );
    }
}