<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamRoutine;
use App\Models\SchoolCategory;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamRoutineController extends Controller
{
    private function getSchoolId(?Request $request = null): ?int
    {
        if (app()->bound('currentSchool')) {
            return app('currentSchool')->id;
        }
        return auth()->user()?->school_id ?? auth()->user()?->school?->id;
    }

    /**
     * Show the redesigned Exam Routine management page.
     */
    public function index(Request $request)
    {
        $schoolId = $this->getSchoolId($request);
        $years = AcademicYear::where('school_id', $schoolId)->orderByDesc('name')->get();
        $categories = SchoolCategory::where('school_id', $schoolId)->orderBy('name')->get();

        $selectedYearId = $request->input('academic_year_id');
        $selectedCategoryId = $request->input('school_category_id');
        $selectedExamId = $request->input('exam_id');
        $selectedClassId = $request->input('class_id');

        // Classes query (filtered by category if provided)
        $classesQuery = Classes::where('school_id', $schoolId);
        if ($selectedCategoryId) {
            $classesQuery->where('school_category_id', $selectedCategoryId);
        }
        $classes = $classesQuery->orderBy('name')->get();

        // Exams query (filtered by year and category if provided)
        $examsQuery = Exam::where('school_id', $schoolId);
        if ($selectedYearId) {
            $examsQuery->where('year_id', $selectedYearId);
        }
        if ($selectedCategoryId) {
            $examsQuery->whereHas('categories', function ($q) use ($selectedCategoryId) {
                $q->where('school_category_id', $selectedCategoryId);
            });
        }
        $exams = $examsQuery->orderBy('name')->get();

        $selectedYear = $selectedYearId ? AcademicYear::find($selectedYearId) : null;
        $selectedCategory = $selectedCategoryId ? SchoolCategory::find($selectedCategoryId) : null;
        $selectedExam = $selectedExamId ? Exam::with('categories')->find($selectedExamId) : null;
        $selectedClass = $selectedClassId ? Classes::with('subjects')->find($selectedClassId) : null;

        $routines = collect();
        $classSubjects = collect();
        $classRoutinesStatus = collect();

        if ($selectedExamId && $selectedClassId) {
            // Load existing routine records for this specific exam and class
            $routines = ExamRoutine::where('school_id', $schoolId)
                ->where('exam_id', $selectedExamId)
                ->where('class_id', $selectedClassId)
                ->with(['subject.subCategory', 'subject.category'])
                ->orderBy('exam_date')
                ->get();

            // Load subjects assigned to this class with subCategory (group) info
            if ($selectedClass) {
                $classSubjects = $selectedClass->subjects()->with(['subCategory', 'category'])->get();
                if ($classSubjects->isEmpty()) {
                    // Fallback to all school subjects if not specifically mapped
                    $classSubjects = Subject::where('school_id', $schoolId)->with(['subCategory', 'category'])->orderBy('name')->get();
                }
            }
        }

        // Summary of all routines for the selected exam across all classes (if exam is selected)
        if ($selectedExamId) {
            $classRoutinesStatus = ExamRoutine::where('school_id', $schoolId)
                ->where('exam_id', $selectedExamId)
                ->with('class')
                ->get()
                ->groupBy('class_id');
        }

        return view('school.exam.exam_routine', compact(
            'years',
            'categories',
            'exams',
            'classes',
            'routines',
            'selectedYearId',
            'selectedCategoryId',
            'selectedExamId',
            'selectedClassId',
            'selectedYear',
            'selectedCategory',
            'selectedExam',
            'selectedClass',
            'classSubjects',
            'classRoutinesStatus'
        ));
    }

    /**
     * AJAX endpoint: Get subjects assigned to a specific class with group info.
     */
    public function subjectsByClass(Request $request, $classId)
    {
        $schoolId = $this->getSchoolId($request);
        $class = Classes::with('subjects.subCategory')->where('school_id', $schoolId)->findOrFail($classId);

        $subjects = $class->subjects;
        if ($subjects->isEmpty()) {
            $subjects = Subject::where('school_id', $schoolId)->with('subCategory')->orderBy('name')->get();
        }

        $formattedSubjects = $subjects->map(function($sub) {
            return [
                'id' => $sub->id,
                'name' => $sub->name,
                'code' => $sub->code,
                'sub_category_name' => $sub->subCategory?->name ?? null,
            ];
        });

        return response()->json([
            'status' => true,
            'subjects' => $formattedSubjects
        ]);
    }

    /**
     * AJAX endpoint: Get exams and classes dynamically filtered by Category and Academic Year.
     */
    public function getFilterData(Request $request)
    {
        $schoolId = $this->getSchoolId($request);
        $categoryId = $request->query('school_category_id');
        $yearId = $request->query('academic_year_id');

        $classesQuery = Classes::where('school_id', $schoolId);
        if ($categoryId) {
            $classesQuery->where('school_category_id', $categoryId);
        }
        $classes = $classesQuery->orderBy('name')->get(['id', 'name']);

        $examsQuery = Exam::where('school_id', $schoolId);
        if ($yearId) {
            $examsQuery->where('year_id', $yearId);
        }
        if ($categoryId) {
            $examsQuery->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('school_category_id', $categoryId);
            });
        }
        $exams = $examsQuery->orderBy('name')->get(['id', 'name']);

        return response()->json([
            'status' => true,
            'classes' => $classes,
            'exams' => $exams,
        ]);
    }

    /**
     * Store or update routine entries for an Exam & Class (Bulk Store).
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academicyears,id',
            'exam_id'          => 'required|exists:exams,id',
            'class_id'         => 'required|exists:classes,id',
            'routines'         => 'nullable|array',
            'routines.*.subject_id' => 'nullable|exists:subjects,id',
            'routines.*.exam_date'  => 'nullable|date',
            'routines.*.start_time' => 'nullable',
            'routines.*.end_time'   => 'nullable',
        ], [
            'academic_year_id.required' => 'শিক্ষাবর্ষ নির্বাচন করুন।',
            'exam_id.required'          => 'পরীক্ষা নির্বাচন করুন।',
            'class_id.required'         => 'শ্রেণি নির্বাচন করুন।',
        ]);

        $schoolId = $this->getSchoolId($request);

        // Delete existing routine for this exam & class to replace cleanly
        ExamRoutine::where('school_id', $schoolId)
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->delete();

        $savedCount = 0;
        if ($request->filled('routines') && is_array($request->routines)) {
            foreach ($request->routines as $row) {
                if (empty($row['subject_id']) || empty($row['exam_date'])) {
                    continue;
                }

                ExamRoutine::create([
                    'school_id'        => $schoolId,
                    'academic_year_id' => $request->academic_year_id,
                    'exam_id'          => $request->exam_id,
                    'class_id'         => $request->class_id,
                    'subject_id'       => $row['subject_id'],
                    'exam_date'        => $row['exam_date'],
                    'start_time'       => !empty($row['start_time']) ? $row['start_time'] : null,
                    'end_time'         => !empty($row['end_time']) ? $row['end_time'] : null,
                ]);
                $savedCount++;
            }
        }

        $message = $savedCount > 0 
            ? "{$savedCount}টি বিষয়ের পরীক্ষার রুটিন সফলভাবে সংরক্ষণ করা হয়েছে!" 
            : "পরীক্ষার রুটিন সফলভাবে আপডেট করা হয়েছে!";

        return redirect()->route('exam.routine.index', [
            'tenant'             => auth()->user()?->school?->slug ?? request()->route('tenant'),
            'academic_year_id'   => $request->academic_year_id,
            'school_category_id' => $request->school_category_id,
            'exam_id'            => $request->exam_id,
            'class_id'           => $request->class_id,
        ])->with('success', $message);
    }

    /**
     * Delete all routines for a specific Exam & Class.
     */
    public function destroyAll(Request $request)
    {
        $request->validate([
            'exam_id'  => 'required|exists:exams,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        $schoolId = $this->getSchoolId($request);

        $deleted = ExamRoutine::where('school_id', $schoolId)
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->delete();

        return redirect()->route('exam.routine.index', [
            'tenant'             => auth()->user()?->school?->slug ?? request()->route('tenant'),
            'academic_year_id'   => $request->academic_year_id,
            'school_category_id' => $request->school_category_id,
            'exam_id'            => $request->exam_id,
            'class_id'           => $request->class_id,
        ])->with('success', 'এই শ্রেণির সম্পূর্ণ পরীক্ষার রুটিন মুছে ফেলা হয়েছে!');
    }

    /**
     * Delete a single routine row.
     */
    public function destroy(Request $request, $id = null)
    {
        $schoolId = $this->getSchoolId($request);

        if ($id) {
            $routine = ExamRoutine::where('school_id', $schoolId)->findOrFail($id);
            $routine->delete();
            return back()->with('success', 'বিষয়টি রুটিন থেকে মুছে ফেলা হয়েছে!');
        }

        if ($request->filled('exam_id') && $request->filled('class_id')) {
            ExamRoutine::where('school_id', $schoolId)
                ->where('exam_id', $request->exam_id)
                ->where('class_id', $request->class_id)
                ->delete();
            return back()->with('success', 'সম্পূর্ণ রুটিন মুছে ফেলা হয়েছে!');
        }

        return back()->with('error', 'কোনো রুটিন চিহ্নিত করা যায়নি।');
    }
}

