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

        // load subjects assigned to class
        if ($classId) {

            $subjects = AssignClass::where('class_id', $classId)
                ->with('subject')
                ->get()
                ->pluck('subject');
        }

        // load students
        if ($classId && $examId && $subjectId) {

            $subject = Subject::findOrFail($subjectId);

            $studentsQuery = Student::where('school_id', $schoolId)
                ->where('class_id', $classId)->orderBy('roll', 'asc');

            // religion subject filter
            // religion filter
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
                        'marks' => $mark->marks,
                        'grade' => $grade['grade'],
                        'point' => $grade['point']
                    ];

                } else {

                    $marksWithGrade[$student->id] = [
                        'marks' => null,
                        'grade' => null,
                        'point' => null
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
            'fullMarks'
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

    public function autoSave(Request $request, $tenant) 
    {
        $schoolId = auth()->user()->school_id;
        
        $academicYear = AcademicYear::where('school_id', $schoolId)
                        ->where('is_active', 1)
                        ->value('id');

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
                'marks'  => $request->marks,
                'status' => $request->status 
            ]
        );

        return response()->json(['status' => true, 'message' => 'Saved Successfully']);
    }
    public function statusUpdate(Request $request, $tenant)
    {
        $schoolId = auth()->user()->school_id;

        // একটিভ একাডেমিক ইয়ার খুঁজে বের করা
        $academicYearId = AcademicYear::where('school_id', $schoolId)
                            ->where('is_active', 1)
                            ->value('id');

        // যদি স্ট্যাটাস 'absent' হয়, তবে মার্কস ০ করে দেওয়া ভালো
        $marks = ($request->status == 'absent') ? 0 : $request->marks;

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
                'status' => $request->status, // 'present' অথবা 'absent'
                'marks'  => $marks
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

        $selectedClassId = $request->class_id;
        $selectedExamId = $request->exam_id;
        // ডিফল্টভাবে সক্রিয় বছর নেওয়া
        $selectedYearId = $request->academic_year_id ?? AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->value('id');

        $students = collect();
        $subjects = collect();
        $marksData = [];
        $meritPosition = [];
        $meritList = [];
        $paginatedResults = null;

        if ($selectedClassId && $selectedExamId && $selectedYearId) {
            
            // ১. সাবজেক্ট লোড করার সময় অবশ্যই বছরের ফিল্টার থাকতে হবে (যদি AssignClass এ বছর থাকে)
            // অন্যথায় সরাসরি ওই ক্লাসের জন্য অ্যাসাইন করা সাবজেক্টগুলো নিন
            $subjectIds = AssignClass::where('class_id', $selectedClassId)
                            ->where('school_id', $schoolId)
                            // যদি আপনার AssignClass টেবিলে academic_year_id থাকে তবে নিচের লাইনটি আনকমেন্ট করুন
                            // ->where('academic_year_id', $selectedYearId) 
                            ->pluck('subject_id');
            
            $subjects = Subject::whereIn('id', $subjectIds)->get();

            // ২. স্টুডেন্ট রিট্রিভ লজিক
            $currentYearId = AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->value('id');

            if ($selectedYearId == $currentYearId) {
                // বর্তমান বছরের স্টুডেন্ট
                $students = Student::where([
                    'class_id' => $selectedClassId,
                    'academic_year_id' => $selectedYearId,
                    'school_id' => $schoolId
                ])->get();
            } else {
                // পুরনো বছরের স্টুডেন্ট (সেশন টেবিল থেকে)
                $studentIdsInSession = DB::table('student_sessions')
                    ->where('class_id', $selectedClassId)
                    ->where('academic_year_id', $selectedYearId)
                    ->pluck('student_id');

                $students = Student::whereIn('id', $studentIdsInSession)->get();
            }

            // ৩. মার্কস কুয়েরি
            $allMarks = Mark::where([
                'class_id' => $selectedClassId,
                'exam_id' => $selectedExamId,
                'academic_year_id' => $selectedYearId, 
                'school_id' => $schoolId
            ])->get();

            // যদি স্টুডেন্ট বা মার্কস না থাকে, তবে লুপ চালানোর প্রয়োজন নেই
            if ($students->isNotEmpty()) {
                foreach ($students as $student) {
                    $currentStudentTotal = 0;
                    $failCount = 0;
                    $totalPoints = 0;
                    $applicableSubjectCount = 0;

                    foreach ($subjects as $subject) {
                        // ধর্মীয় ফিল্টার লজিক এখানে থাকবে (আপনার আগের কোড অনুযায়ী)
                        $subjectName = strtolower($subject->name);
                        $studentReligion = strtolower($student->religion ?? '');
                        $religions = ['islam', 'hindu', 'christian', 'buddhist', 'religion', 'studies'];
                        $isReligionSubject = false;

                        foreach ($religions as $rel) {
                            if (str_contains($subjectName, $rel)) {
                                $isReligionSubject = true;
                                break;
                            }
                        }

                        if ($isReligionSubject && !empty($studentReligion)) {
                            $matchFound = false;
                            if (str_contains($subjectName, 'islam') && $studentReligion == 'islam') $matchFound = true;
                            if (str_contains($subjectName, 'hindu') && str_contains($studentReligion, 'hindu')) $matchFound = true;

                            if (!$matchFound && (str_contains($subjectName, 'islam') || str_contains($subjectName, 'hindu'))) {
                                $marksData[$student->id][$subject->id] = ['marks' => null, 'grade' => 'N/A'];
                                continue;
                            }
                        }

                        $markRecord = $allMarks->where('student_id', $student->id)
                                            ->where('subject_id', $subject->id)
                                            ->first();
                        
                        // AssignClass থেকে ফুল মার্ক নেওয়া (এখানেও বছরের বিষয় থাকতে পারে)
                        $fullMark = AssignClass::where([
                            'class_id' => $selectedClassId, 
                            'subject_id' => $subject->id
                        ])->value('full_mark') ?? 100;
                        
                        $rawMark = $markRecord ? $markRecord->marks : null;
                        $gradeInfo = $this->getGradeWithPoint($rawMark, $fullMark);

                        $marksData[$student->id][$subject->id] = [
                            'marks' => $rawMark, 
                            'grade' => $gradeInfo['grade']
                        ];
                        
                        $applicableSubjectCount++;

                        if ($rawMark !== null) {
                            $currentStudentTotal += $rawMark;
                            if ($gradeInfo['grade'] == 'F') $failCount++;
                            else $totalPoints += $gradeInfo['point'];
                        } else {
                            $failCount++;
                        }
                    }

                    // GPA ক্যালকুলেশন
                    $currentGpa = ($failCount > 0) ? 0.00 : (($applicableSubjectCount > 0) ? (float)number_format($totalPoints / $applicableSubjectCount, 2) : 0);
                    $marksData[$student->id]['GPA'] = ($failCount > 0) ? "0.00 (F-$failCount)" : number_format($currentGpa, 2);

                    $meritList[] = [
                        'student_id' => $student->id,
                        'fail_count' => $failCount,
                        'total_marks' => $currentStudentTotal,
                        'gpa' => $currentGpa
                    ];
                }

                // ৪. মেধাক্রম সর্টিং
                usort($meritList, function($a, $b) {
                    if ($b['gpa'] != $a['gpa']) return $b['gpa'] <=> $a['gpa'];
                    if ($b['total_marks'] != $a['total_marks']) return $b['total_marks'] <=> $a['total_marks'];
                    return $a['fail_count'] <=> $b['fail_count'];
                });

                foreach ($meritList as $index => $item) {
                    $meritPosition[$item['student_id']] = $index + 1;
                }

                // ৫. পেজিনেশন
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $itemCollection = collect($meritList);
                $perPage = 10;
                $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
                
                $paginatedResults = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
                $paginatedResults->setPath($request->url());
                $paginatedResults->appends($request->all());
            }
        }

        return view('school.mark.view', compact(
            'layout', 'classes', 'examTypes', 'academicYears', 'selectedClassId', 'selectedYearId',
            'selectedExamId', 'students', 'subjects', 'marksData', 'meritPosition', 'paginatedResults'
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
        if (empty($allUniqueIds)) { $allUniqueIds = [$studentId]; }

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
            $totalMarks = 0; $failCount = 0; $totalPoints = 0; $applicableCount = 0;

            foreach ($subjects as $subject) {
                $subjectName = strtolower($subject->name);
                $stReligion  = strtolower($st->religion ?? '');
                
                // ধর্মভিত্তিক সাবজেক্ট ফিল্টার
                if ((str_contains($subjectName, 'islam') && $stReligion !== 'islam') || 
                    (str_contains($subjectName, 'hindu') && !str_contains($stReligion, 'hindu'))) continue;

                $applicableCount++;
                $markRecord = $allMarks->where('student_id', $st->id)->where('subject_id', $subject->id)->first();
                $rawMark    = $markRecord ? $markRecord->marks : 0;
                
                $fullMark   = AssignClass::where(['class_id' => $classId, 'subject_id' => $subject->id])->value('full_mark') ?? 100;
                $gradeInfo  = $this->getGradeWithPoint($rawMark, $fullMark);

                $totalMarks += $rawMark;
                if ($gradeInfo['grade'] == 'F') $failCount++; else $totalPoints += $gradeInfo['point'];

                // শুধুমাত্র টার্গেট স্টুডেন্টের মার্কস ডিটেইলস স্টোর করা
                if ((int)$st->id === (int)$studentId) {
                    $targetStudentMarks[$subject->id] = [
                        'subject_name' => $subject->name,
                        'subject_code' => $subject->code ?? 'N/A',
                        'full_mark'    => $fullMark,
                        'marks'        => $rawMark,
                        'grade'        => $gradeInfo['grade'],
                        'point'        => $gradeInfo['point'],
                        'highest_mark' => $allMarks->where('subject_id', $subject->id)->max('marks')
                    ];
                }
            }
            $gpa = ($failCount > 0) ? 0 : ($applicableCount > 0 ? $totalPoints / $applicableCount : 0);
            $meritList[] = ['id' => $st->id, 'total' => $totalMarks, 'gpa' => (float)$gpa, 'fail' => $failCount];
        }

        // ৫. সর্টিং ও পজিশন বের করা
        usort($meritList, function($a, $b) {
            if ($a['fail'] !== $b['fail']) return $a['fail'] <=> $b['fail'];
            return $b['gpa'] <=> $a['gpa'] ?: $b['total'] <=> $a['total'];
        });

        $meritPosition = 0;
        foreach($meritList as $key => $m) { 
            if($m['id'] == $studentId) { $meritPosition = $key + 1; break; } 
        }
        
        $targetData = collect($meritList)->where('id', $studentId)->first();

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
            'student'         => $student,
            'displayRoll'     => $displayRoll,
            'displayCustomId' => $displayCustomId,
            'class'           => $class,
            'exam'            => $exam,
            'marksData'       => $targetStudentMarks,
            'totalMarks'      => $targetData['total'],
            'gpa'             => number_format($targetData['gpa'], 2),
            'meritPosition'   => $meritPosition,
            'schoolName'      => $school->name ?? 'School Name',
            'address'         => $school->address ?? 'Address',
            'emis'            => $school->emis_code ?? 'N/A',
            'academic_year'   => $academicYearName,
            'instituteLogo'   => $this->compressImageToBase64($instituteLogo, 250),
            'studentPhoto'    => $this->compressImageToBase64($studentPhoto, 150),
            'formattedDOB'    => $student->dob ? date('d-m-Y', strtotime($student->dob)) : 'N/A',
            'totalWorkingDays'=> $totalWorkingDays,
            'presentDays'     => $presentDays,
            'absentDays'      => $absentDays,
            'attendancePercentage' => $attendancePercentage
        ];

        $pdf = Pdf::loadView('school.mark.marksheet-pdf', $data);
        return $pdf->download('marksheet-'.$displayCustomId.'.pdf');
    }

    private function compressImageToBase64($path, $maxWidth = 150)
    {
        if (!file_exists($path) || !is_file($path)) return '';
        try {
            $info = getimagesize($path);
            if (!$info) return '';
            
            $width = $info[0];
            $height = $info[1];
            $mime = $info['mime'];
            
            if ($width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = floor($height * ($maxWidth / $width));
                
                $image = null;
                if ($mime == 'image/jpeg') $image = @imagecreatefromjpeg($path);
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
                    if ($mime == 'image/jpeg') imagejpeg($newImage, null, 75);
                    elseif ($mime == 'image/png') imagepng($newImage, null, 6);
                    elseif ($mime == 'image/webp') imagewebp($newImage, null, 75);
                    $imageData = ob_get_clean();
                    
                    imagedestroy($image);
                    imagedestroy($newImage);
                    
                    return 'data:' . $mime . ';base64,' . base64_encode($imageData);
                }
            }
            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
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
            $failCount = 0;
            $totalPoints = 0;
            $totalMarks = 0;
            $applicableSubjectCount = 0;

            foreach ($subjects as $subject) {
                $subjectName = strtolower($subject->name);
                $studentReligion = strtolower($student->religion ?? '');

               
                $religions = ['islam', 'hindu', 'christian', 'buddhist', 'religion', 'studies'];
                $isReligionSubject = false;
                foreach ($religions as $rel) {
                    if (str_contains($subjectName, $rel)) {
                        $isReligionSubject = true;
                        break;
                    }
                }

                if ($isReligionSubject && !empty($studentReligion)) {
                    $match = false;
                    if (str_contains($subjectName, 'islam') && $studentReligion == 'islam') $match = true;
                    if (str_contains($subjectName, 'hindu') && str_contains($studentReligion, 'hindu')) $match = true;

                    if (!$match && (str_contains($subjectName, 'islam') || str_contains($subjectName, 'hindu'))) {
                        continue; 
                    }
                }

                
                $applicableSubjectCount++; 
                
                $markRecord = $allMarks->where('student_id', $student->id)->where('subject_id', $subject->id)->first();
                $rawMark = $markRecord ? $markRecord->marks : null;
                $fullMark = AssignClass::where(['class_id' => $classId, 'subject_id' => $subject->id])->value('full_mark') ?? 100;
                $gradeInfo = $this->getGradeWithPoint($rawMark, $fullMark);

                if ($rawMark !== null) {
                    $totalMarks += $rawMark;
                    if ($gradeInfo['grade'] == 'F') {
                        $failCount++;
                    } else {
                        $totalPoints += $gradeInfo['point'];
                    }
                } else {
                    $failCount++; 
                }
            }

            // ৩. ডাইনামিক GPA ক্যালকুলেশন (সর্টিং এর জন্য numeric value রাখা হয়েছে)
            $numericGpa = 0.00;
            if ($failCount > 0) {
                $gpaDisplay = "0.00 (F-$failCount)";
                $numericGpa = 0.00;
            } else {
                $calculatedGpa = ($applicableSubjectCount > 0) ? ($totalPoints / $applicableSubjectCount) : 0;
                $gpaDisplay = number_format($calculatedGpa, 2);
                $numericGpa = (float)$gpaDisplay;
            }
            
            $results[] = [
                'roll' => $student->student_id ?? $student->id,
                'name' => $student->name,
                'gpa' => $gpaDisplay,
                'numeric_gpa' => $numericGpa, // সর্টিং লজিকের জন্য
                'fail_count' => $failCount,
                'total_marks' => $totalMarks
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
    // 1. School/Tenant Validation
    $school = DB::table('schools')->where('slug', $tenant)->first();
    if (!$school) {
        return response()->json(['status' => false, 'message' => 'School not found.'], 404);
    }

    $schoolId = $school->id;
    $customId = $request->student_id; // e.g., STD-261001

    // 2. Find Student (Check current table and session history)
    $student = Student::where('student_id', $customId)
                      ->where('school_id', $schoolId)
                      ->first();

    if (!$student) {
        return response()->json(['status' => false, 'message' => 'Student ID not found.'], 404);
    }

    // 3. Get the published exam for this student's current or previous year
    // We fetch the latest published marks for this student
    $latestMark = Mark::where('student_id', $student->id)
                      ->where('school_id', $schoolId)
                      ->latest()
                      ->first();

    if (!$latestMark) {
        return response()->json(['status' => false, 'message' => 'No published results found for this Student ID.'], 404);
    }

    $examId = $latestMark->exam_id;
    $classId = $latestMark->class_id;
    $yearId = $latestMark->academic_year_id;

    // 4. Load Data for Calculation (Similar to your PDF logic)
    $exam = Exam::find($examId);
    $allStudentsInClass = Student::where('class_id', $classId)
                                 ->where('school_id', $schoolId)
                                 ->where('academic_year_id', $yearId)
                                 ->get();

    $subjects = Subject::whereIn('id', AssignClass::where('class_id', $classId)->pluck('subject_id'))->get();
    
    $allMarks = Mark::where([
        'class_id' => $classId,
        'exam_id' => $examId,
        'academic_year_id' => $yearId,
        'school_id' => $schoolId
    ])->get();

    // 5. Calculate Merit Position and GPA
    $meritList = [];
    $targetStudentSummary = null;

    foreach ($allStudentsInClass as $st) {
        $totalMarks = 0; $failCount = 0; $totalPoints = 0; $applicableCount = 0;

        foreach ($subjects as $subject) {
            // Religion Filter Logic
            $subName = strtolower($subject->name);
            $stRel = strtolower($st->religion ?? '');
            if ((str_contains($subName, 'islam') && $stRel !== 'islam') || 
                (str_contains($subName, 'hindu') && !str_contains($stRel, 'hindu'))) continue;

            $applicableCount++;
            $mRecord = $allMarks->where('student_id', $st->id)->where('subject_id', $subject->id)->first();
            $rawM = $mRecord ? $mRecord->marks : 0;
            
            $fullM = AssignClass::where(['class_id' => $classId, 'subject_id' => $subject->id])->value('full_mark') ?? 100;
            $grade = $this->getGradeWithPoint($rawM, $fullM);

            $totalMarks += $rawM;
            if ($grade['grade'] == 'F') $failCount++; else $totalPoints += $grade['point'];
        }

        $gpa = ($failCount > 0) ? 0 : ($applicableCount > 0 ? $totalPoints / $applicableCount : 0);
        
        $resultData = [
            'id' => $st->id,
            'total' => $totalMarks,
            'gpa' => (float)$gpa,
            'fail' => $failCount,
            'gpa_text' => ($failCount > 0) ? "0.00 (F-$failCount)" : number_format($gpa, 2)
        ];

        $meritList[] = $resultData;
        if ($st->id == $student->id) {
            $targetStudentSummary = $resultData;
        }
    }

    // Sort for Merit
    usort($meritList, function($a, $b) {
        if ($a['fail'] !== $b['fail']) return $a['fail'] <=> $b['fail'];
        return $b['gpa'] <=> $a['gpa'] ?: $b['total'] <=> $a['total'];
    });

    $meritRank = 0;
    foreach($meritList as $key => $m) {
        if($m['id'] == $student->id) { $meritRank = $key + 1; break; }
    }

    // 6. Return Partial View
    $html = view('school.website.partials.result_view', [
        'student' => $student,
        'exam' => $exam,
        'studentSummary' => $targetStudentSummary, // Renamed from 'summary'
        'meritPosition' => $meritRank,             // Renamed from 'merit'
        'tenant' => $tenant
    ])->render();

    return response()->json([
        'status' => true,
        'data' => $html
    ]);
}
}