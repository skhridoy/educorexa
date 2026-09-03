<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\SchoolCategory;
use App\Models\ExamRoutine;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\School;
use App\Models\AssignClass;
use App\Models\CommunicationSetting;
use App\Services\SmsService;
use Barryvdh\DomPDF\Facade\Pdf;

class ExamController extends Controller
{
    /**
     * Get the active school ID safely
     */
    private function getSchoolId(?Request $request = null): ?int
    {
        return auth()->user()?->school_id
            ?? (app()->bound('currentSchool') ? app('currentSchool')->id : null)
            ?? ($request ? $request->school_id : null);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schoolId = $this->getSchoolId($request);

        $years = AcademicYear::where('school_id', $schoolId)->orderBy('name', 'desc')->get();
        $categories = SchoolCategory::where('school_id', $schoolId)->orderBy('name')->get();

        $query = Exam::with(['academicYear', 'categories'])
            ->where('school_id', $schoolId);

        if ($request->filled('year_id')) {
            $query->where('year_id', $request->year_id);
        }
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('school_category_id', $request->category_id);
            });
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $exams = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        // Calculate summary stats
        $allExamsCount    = Exam::where('school_id', $schoolId)->count();
        $activeExamsCount = Exam::where('school_id', $schoolId)->where('status', 1)->count();
        $publishedCount   = Exam::where('school_id', $schoolId)->where('is_published', 1)->count();

        return view('school.exam.index', compact('exams', 'years', 'categories', 'allExamsCount', 'activeExamsCount', 'publishedCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $tenant)
    {
        $schoolId = $this->getSchoolId($request);

        $request->validate([
            'year_id'               => 'required|exists:academicyears,id',
            'school_category_ids'   => 'required|array|min:1',
            'school_category_ids.*' => 'exists:school_categories,id',
            'name'                  => 'required|string|max:255',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',
        ], [
            'year_id.required'             => 'শিক্ষাবর্ষ সিলেক্ট করা বাধ্যতামূলক।',
            'school_category_ids.required' => 'অন্তত একটি স্কুল ক্যাটেগরি সিলেক্ট করুন।',
            'end_date.after_or_equal'      => 'শেষ তারিখ অবশ্যই শুরু তারিখের সমান বা পরে হতে হবে।'
        ]);

        try {
            $categoryIds = $request->school_category_ids;

            // Store first category in legacy column for backward compat
            $exam = Exam::create([
                'school_id'          => $schoolId,
                'school_category_id' => $categoryIds[0],
                'year_id'            => $request->year_id,
                'name'               => $request->name,
                'status'             => 0,
                'start_date'         => $request->start_date,
                'end_date'           => $request->end_date,
                'is_published'       => 0,
            ]);

            // Sync pivot table
            $exam->categories()->sync($categoryIds);

            return back()->with([
                'success' => 'নতুন পরীক্ষা সফলভাবে তৈরি করা হয়েছে!',
                'type'    => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'success' => 'কিছু একটা সমস্যা হয়েছে। আবার চেষ্টা করুন।',
                'type'    => 'danger'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($tenant, $exam)
    {
        $schoolId = $this->getSchoolId();

        $exam = Exam::with('categories')
            ->where('school_id', $schoolId)
            ->where('id', $exam)
            ->firstOrFail();

        // Include selected category IDs for the edit form
        $exam->selected_category_ids = $exam->categories->pluck('id')->toArray();

        return response()->json($exam);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tenant, $exam)
    {
        $schoolId = $this->getSchoolId($request);

        $exam = Exam::where('school_id', $schoolId)
            ->where('id', $exam)
            ->firstOrFail();

        $request->validate([
            'year_id'               => 'required|exists:academicyears,id',
            'school_category_ids'   => 'required|array|min:1',
            'school_category_ids.*' => 'exists:school_categories,id',
            'name'                  => 'required|string|max:255',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',
        ], [
            'year_id.required'             => 'শিক্ষাবর্ষ সিলেক্ট করা বাধ্যতামূলক।',
            'school_category_ids.required' => 'অন্তত একটি স্কুল ক্যাটেগরি সিলেক্ট করুন।',
            'end_date.after_or_equal'      => 'শেষ তারিখ অবশ্যই শুরু তারিখের সমান বা পরে হতে হবে।'
        ]);

        $categoryIds = $request->school_category_ids;

        $exam->update([
            'school_category_id' => $categoryIds[0], // keep legacy column in sync
            'year_id'            => $request->year_id,
            'name'               => $request->name,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
        ]);

        // Sync pivot table
        $exam->categories()->sync($categoryIds);

        return back()->with([
            'success' => 'Exam updated successfully!',
            'type'    => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tenant, $exam)
    {
        $schoolId = $this->getSchoolId();

        $exam = Exam::where('school_id', $schoolId)
            ->where('id', $exam)
            ->firstOrFail();

        $exam->delete();

        return back()->with([
            'success' => 'Exam deleted successfully!',
            'type'    => 'warning'
        ]);
    }

    /**
     * Get exams list for a specific academic year (AJAX helper)
     */
    public function getExamsByYear($tenant, $yearId)
    {
        $schoolId = $this->getSchoolId();
        $exams = Exam::with(['categories'])
            ->where('school_id', $schoolId)
            ->where('year_id', $yearId)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($exams);
    }

    /**
     * Clone / Copy exams from one academic year to another
     */
    public function cloneFromYear(Request $request, $tenant)
    {
        $schoolId = $this->getSchoolId($request);

        $request->validate([
            'from_year_id' => 'required|exists:academicyears,id',
            'to_year_id'   => 'required|exists:academicyears,id|different:from_year_id',
            'exam_ids'     => 'required|array|min:1',
            'exam_ids.*'   => 'exists:exams,id',
        ], [
            'from_year_id.required' => 'উৎস শিক্ষাবর্ষ নির্বাচন করুন।',
            'to_year_id.required'   => 'টার্গেট শিক্ষাবর্ষ নির্বাচন করুন।',
            'to_year_id.different'  => 'উৎস ও টার্গেট শিক্ষাবর্ষ ভিন্ন হতে হবে।',
            'exam_ids.required'     => 'কমপক্ষে একটি পরীক্ষা নির্বাচন করুন।',
        ]);

        $fromYear = AcademicYear::where('school_id', $schoolId)->findOrFail($request->from_year_id);
        $toYear   = AcademicYear::where('school_id', $schoolId)->findOrFail($request->to_year_id);

        $fromYearNum = (int) preg_replace('/[^0-9]/', '', $fromYear->name);
        $toYearNum   = (int) preg_replace('/[^0-9]/', '', $toYear->name);
        $yearDiff    = ($fromYearNum && $toYearNum) ? ($toYearNum - $fromYearNum) : 1;

        $sourceExams = Exam::with('categories')
            ->where('school_id', $schoolId)
            ->where('year_id', $request->from_year_id)
            ->whereIn('id', $request->exam_ids)
            ->get();

        $copiedCount  = 0;
        $skippedCount = 0;

        foreach ($sourceExams as $source) {
            $newName = $source->name;
            if ($fromYearNum && $toYearNum && str_contains($newName, (string)$fromYearNum)) {
                $newName = str_replace((string)$fromYearNum, (string)$toYearNum, $newName);
            }

            // Check if already exists in target year (by name only — not per-category)
            $existingExam = Exam::where('school_id', $schoolId)
                ->where('year_id', $request->to_year_id)
                ->where('name', $newName)
                ->first();

            if ($existingExam) {
                // Sync categories from source to existing
                $existingExam->categories()->syncWithoutDetaching(
                    $source->categories->pluck('id')->toArray()
                );
                $skippedCount++;
                continue;
            }

            // Calculate adjusted dates
            $newStartDate = null;
            $newEndDate   = null;
            if ($source->start_date) {
                try { $newStartDate = \Carbon\Carbon::parse($source->start_date)->addYears($yearDiff)->format('Y-m-d'); }
                catch (\Exception $e) { $newStartDate = $source->start_date; }
            }
            if ($source->end_date) {
                try { $newEndDate = \Carbon\Carbon::parse($source->end_date)->addYears($yearDiff)->format('Y-m-d'); }
                catch (\Exception $e) { $newEndDate = $source->end_date; }
            }

            $sourceCategoryIds = $source->categories->pluck('id')->toArray();

            $newExam = Exam::create([
                'school_id'          => $schoolId,
                'school_category_id' => $source->school_category_id,
                'year_id'            => $request->to_year_id,
                'name'               => $newName,
                'status'             => 0,
                'start_date'         => $newStartDate,
                'end_date'           => $newEndDate,
                'is_published'       => 0,
            ]);

            if (!empty($sourceCategoryIds)) {
                $newExam->categories()->sync($sourceCategoryIds);
            }

            $copiedCount++;
        }

        $message = "{$copiedCount}টি পরীক্ষা সফলভাবে '{$toYear->name}' শিক্ষাবর্ষে কপি করা হয়েছে।";
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount}টি বিদ্যমান পরীক্ষায় ক্যাটেগরি আপডেট হয়েছে)";
        }

        return back()->with([
            'success' => $message,
            'type'    => 'success'
        ]);
    }

    /**
     * 1-Click Bulk Generate Standard Exams for an Academic Year
     */
    public function bulkGenerate(Request $request, $tenant)
    {
        $schoolId = $this->getSchoolId($request);

        $request->validate([
            'year_id'               => 'required|exists:academicyears,id',
            'school_category_ids'   => 'required|array|min:1',
            'school_category_ids.*' => 'exists:school_categories,id',
            'presets'               => 'required|array|min:1',
        ], [
            'year_id.required'             => 'শিক্ষাবর্ষ নির্বাচন করুন।',
            'school_category_ids.required' => 'অন্তত একটি স্কুল ক্যাটেগরি নির্বাচন করুন।',
            'presets.required'             => 'কমপক্ষে একটি পরীক্ষার ধরন নির্বাচন করুন।',
        ]);

        $year        = AcademicYear::where('school_id', $schoolId)->findOrFail($request->year_id);
        $yearNum     = (int) preg_replace('/[^0-9]/', '', $year->name) ?: date('Y');
        $categoryIds = $request->school_category_ids;

        $standardDates = [
            '1st_term'   => ['name' => '১ম সাময়িক পরীক্ষা (1st Term Exam)',          'start' => "{$yearNum}-04-01", 'end' => "{$yearNum}-04-15"],
            'half_yearly'=> ['name' => 'অর্ধ-বার্ষিক পরীক্ষা (Half Yearly Exam)',      'start' => "{$yearNum}-06-15", 'end' => "{$yearNum}-06-30"],
            '2nd_term'   => ['name' => '২য় সাময়িক পরীক্ষা (2nd Term Exam)',           'start' => "{$yearNum}-08-15", 'end' => "{$yearNum}-08-30"],
            'pre_test'   => ['name' => 'প্রাক-নির্বাচনী পরীক্ষা (Pre-Test Exam)',     'start' => "{$yearNum}-10-01", 'end' => "{$yearNum}-10-15"],
            'annual'     => ['name' => 'বার্ষিক পরীক্ষা (Annual Exam)',               'start' => "{$yearNum}-11-20", 'end' => "{$yearNum}-12-05"],
            'test_exam'  => ['name' => 'নির্বাচনী পরীক্ষা (Test Exam)',               'start' => "{$yearNum}-11-01", 'end' => "{$yearNum}-11-15"],
        ];

        $created = 0;
        $skipped = 0;

        foreach ($request->presets as $presetKey) {
            if (!isset($standardDates[$presetKey])) continue;

            $info     = $standardDates[$presetKey];
            $examName = $info['name'];

            // Check if exam with same name already exists for this year
            $existingExam = Exam::where('school_id', $schoolId)
                ->where('year_id', $request->year_id)
                ->where('name', $examName)
                ->first();

            if ($existingExam) {
                // Just add the new categories to the existing exam
                $existingExam->categories()->syncWithoutDetaching($categoryIds);
                $skipped++;
                continue;
            }

            $exam = Exam::create([
                'school_id'          => $schoolId,
                'school_category_id' => $categoryIds[0],
                'year_id'            => $request->year_id,
                'name'               => $examName,
                'status'             => 0,
                'start_date'         => $info['start'],
                'end_date'           => $info['end'],
                'is_published'       => 0,
            ]);

            $exam->categories()->sync($categoryIds);
            $created++;
        }

        $message = "{$created}টি স্ট্যান্ডার্ড পরীক্ষা সফলভাবে তৈরি হয়েছে!";
        if ($skipped > 0) {
            $message .= " ({$skipped}টি বিদ্যমান পরীক্ষায় ক্যাটেগরি আপডেট হয়েছে)";
        }

        return back()->with([
            'success' => $message,
            'type'    => 'success'
        ]);
    }

    // Status Toggle
    public function toggleStatus($tenant, $examId)
    {
        $schoolId = $this->getSchoolId();

        $exam = Exam::where('school_id', $schoolId)
            ->where('id', $examId)
            ->firstOrFail();

        // If turning ON
        if ($exam->status == 0) {
            Exam::where('school_id', $schoolId)
                ->where('year_id', $exam->year_id)
                ->where('id', '!=', $exam->id)
                ->update(['status' => 0]);

            $exam->status = 1;
        } else {
            $exam->status = 0;
        }

        $exam->save();

        return response()->json([
            'success'    => true,
            'current_id' => $exam->id,
            'new_status' => $exam->status,
            'year_id'    => $exam->year_id
        ]);
    }

    public function generateAdmitIndex(Request $request)
    {
        $school   = app()->bound('currentSchool') ? app('currentSchool') : (auth()->user()?->school ?? null);
        $schoolId = $this->getSchoolId($request);
        $classes  = Classes::where('school_id', $schoolId)->get();
        $exams    = Exam::with('categories')->where('school_id', $schoolId)->get();
        $schoolLogo    = $school?->logo;
        $students      = null;
        $selected_exam = null;
        $examRoutines  = collect();
        $assignClasses = collect();

        if ($request->filled('class_id') && $request->filled('exam_id')) {
            $students = Student::where('school_id', $schoolId)
                ->where('class_id', $request->class_id)
                ->with(['class', 'section', 'group', 'category'])
                ->orderBy('roll', 'asc')
                ->get();

            $selected_exam = Exam::with('categories')->find($request->exam_id);

            $examRoutines = ExamRoutine::where('school_id', $schoolId)
                ->where('exam_id', $request->exam_id)
                ->where('class_id', $request->class_id)
                ->with(['subject.subCategory', 'subject.category'])
                ->orderBy('exam_date', 'asc')
                ->get();

            $assignClasses = AssignClass::where('school_id', $schoolId)
                ->where('class_id', $request->class_id)
                ->with('subcategory')
                ->get()
                ->keyBy('subject_id');
        }

        return view('school.exam.bulk_admit', compact('classes', 'exams', 'students', 'selected_exam', 'schoolLogo', 'examRoutines', 'school', 'assignClasses'));
    }

    public function bulkAdmitCard(Request $request, $tenant)
    {
        $schoolId = $this->getSchoolId($request);
        $students = Student::where('school_id', $schoolId)
            ->where('class_id', $request->class_id)
            ->with(['class', 'section', 'group', 'category'])
            ->orderBy('roll', 'asc')
            ->get();

        $exam   = Exam::with('categories')->findOrFail($request->exam_id);
        $school = app()->bound('currentSchool') ? app('currentSchool') : (auth()->user()?->school ?? null);

        $examRoutines = ExamRoutine::where('school_id', $schoolId)
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->with(['subject.subCategory', 'subject.category'])
            ->orderBy('exam_date', 'asc')
            ->get();

        $assignClasses = AssignClass::where('school_id', $schoolId)
            ->where('class_id', $request->class_id)
            ->with('subcategory')
            ->get()
            ->keyBy('subject_id');

        $pdf = Pdf::loadView('school.exam.bulk_admit_card', compact('students', 'exam', 'school', 'examRoutines', 'assignClasses'));

        return $pdf->setPaper('a4', 'portrait')->download('bulk-admit-card.pdf');
    }

    public function publishResult(Request $request, $tenant, $id)
    {
        try {
            $schoolId = $this->getSchoolId($request);
            $exam = Exam::where('id', $id)
                        ->where('school_id', $schoolId)
                        ->firstOrFail();

            $exam->is_published = $exam->is_published ? 0 : 1;
            $exam->save();

            if ($exam->is_published) {
                $setting = CommunicationSetting::where('school_id', $schoolId)
                    ->where('event', 'result_published')->first();
                $school = School::find($schoolId);
                if ($setting?->sms_enabled && $school) {
                    $students = Student::where('school_id', $schoolId)
                        ->where('status', 'active')->whereNotNull('contact_number')->get();
                    foreach ($students as $student) {
                        $message = str_replace(
                            ['[student_name]', '[exam_name]', '[school_name]'],
                            [$student->name, $exam->name, $school->name],
                            $setting->sms_template ?: 'Result for [exam_name] has been published. Please check the portal. - [school_name]'
                        );
                        app(SmsService::class)->send($school, $student->contact_number, $message);
                    }
                }
            }

            return response()->json([
                'success'      => true,
                'is_published' => (bool)$exam->is_published,
                'message'      => $exam->is_published ? 'Result Published Successfully' : 'Result Unpublished Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
