<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\SchoolCategory;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\School;

use Barryvdh\DomPDF\Facade\Pdf;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $years = AcademicYear::where('school_id', $schoolId)->orderBy('name', 'desc')->get();
        $categories = SchoolCategory::where('school_id', $schoolId)->orderBy('name')->get();

        $query = Exam::with(['academicYear', 'category'])
            ->where('school_id', $schoolId);

        if ($request->filled('year_id')) {
            $query->where('year_id', $request->year_id);
        }
        if ($request->filled('category_id')) {
            $query->where('school_category_id', $request->category_id);
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
        $schoolId = auth()->user()->school_id;

        $request->validate([
            'year_id'            => 'required|exists:academicyears,id',
            'school_category_id' => 'required|exists:school_categories,id', 
            'name'               => 'required|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
        ], [
            'academic_year_id.required' => 'শিক্ষাবর্ষ সিলেক্ট করা বাধ্যতামূলক।',
            'school_category_id.required' => 'স্কুল ক্যাটেগরি সিলেক্ট করুন।',
            'end_date.after_or_equal' => 'শেষ তারিখ অবশ্যই শুরু তারিখের সমান বা পরে হতে হবে।'
        ]);

        try {
            Exam::create([
                'school_id'          => $schoolId,
                'school_category_id' => $request->school_category_id, 
                'year_id'            => $request->year_id,
                'name'               => $request->name,
                'status'             => 0, // ডিফল্ট ইন-অ্যাক্টিভ
                'start_date'         => $request->start_date,
                'end_date'           => $request->end_date,
                'is_published'       => 0,
            ]);

            return back()->with([
                'success' => 'নতুন পরীক্ষা সফলভাবে তৈরি করা হয়েছে!', 
                'type'    => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'success' => 'কিছু একটা সমস্যা হয়েছে। আবার চেষ্টা করুন।', 
                'type'    => 'danger'
            ]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($tenant, $exam)
    {
        $schoolId = auth()->user()->school_id;

        $exam = Exam::where('school_id', $schoolId)
            ->where('id', $exam)
            ->firstOrFail();

        return response()->json($exam);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tenant, $exam)
    {
        $schoolId = auth()->user()->school_id;

        $exam = Exam::where('school_id', $schoolId)
            ->where('id', $exam)
            ->firstOrFail();

        $request->validate([
            'year_id' => 'required',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $exam->update([
            'year_id' => $request->year_id,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with([
            'success' => 'Exam updated successfully!',
            'type' => 'info'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tenant, $exam)
    {
        $schoolId = auth()->user()->school_id;

        $exam = Exam::where('school_id', $schoolId)
            ->where('id', $exam)
            ->firstOrFail();

        $exam->delete();

        return back()->with([
            'success' => 'Exam deleted successfully!',
            'type' => 'warning'
        ]);
    }

    // 📌 Status Toggle
    public function toggleStatus($tenant, $examId)
    {
        $schoolId = auth()->user()->school_id;

        $exam = Exam::where('school_id', $schoolId)
            ->where('id', $examId)
            ->firstOrFail();

        // If turning ON
        if ($exam->status == 0) {

            // 🔥 Same year এর অন্য সব exam inactive
            Exam::where('school_id', $schoolId)
                ->where('year_id', $exam->year_id)
                ->where('id', '!=', $exam->id)
                ->update(['status' => 0]);

            $exam->status = 1;
        } else {
            $exam->status = 0;
        }

        $exam->save();

        $today = now()->toDateString();

        if ($exam->end_date < $today) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot activate finished exam'
            ]);
        }
        return response()->json([
            'success' => true,
            'current_id' => $exam->id,
            'new_status' => $exam->status,
            'year_id' => $exam->year_id
        ]);
    }

    public function generateAdmitIndex(Request $request)
    {
        $school = auth()->user()->school;
        $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->get();
        $exams = Exam::where('school_id', $schoolId)->get();
        $schoolLogo = $school->logo;
        $students = null;
        $selected_exam = null;

        if ($request->filled('class_id') && $request->filled('exam_id')) {
            $students = Student::where('school_id', $schoolId)
                ->where('class_id', $request->class_id)
                ->with(['class', 'section'])
                ->orderBy('roll', 'asc')
                ->get();
                
            $selected_exam = Exam::find($request->exam_id);
        }

        return view('school.exam.bulk_admit', compact('classes', 'exams', 'students', 'selected_exam', 'schoolLogo'));
    }
    
    public function bulkAdmitCard(Request $request, $tenant)
    {
        
        $schoolId = auth()->user()->school_id;
        $students = Student::where('school_id', $schoolId)
            ->where('class_id', $request->class_id)
            ->with(['class', 'section'])
            ->orderBy('roll', 'asc')
            ->get();

        $exam = Exam::findOrFail($request->exam_id);
        $school = auth()->user()->school;
        
        $pdf = Pdf::loadView('school.exam.bulk_admit_card', compact('students', 'exam', 'school'));
        
        // ল্যান্ডস্কেপ মোড সেট করা
        return $pdf->setPaper('a4', 'landscape')->download('bulk-admit-card.pdf');
    }

    public function publishResult(Request $request, $tenant, $id)
    {
        try {
            $exam = Exam::where('id', $id)
                        ->where('school_id', auth()->user()->school_id)
                        // আপনি চাইলে status চেকটি সরিয়ে দিতে পারেন যদি ইন-অ্যাক্টিভ পরীক্ষারও রেজাল্ট পাবলিশ করার প্রয়োজন হয়
                        ->firstOrFail();

            // রেজাল্ট পাবলিশ স্ট্যাটাস টগল
            $exam->is_published = $exam->is_published ? 0 : 1;
            $exam->save();

            return response()->json([
                'success' => true,
                'is_published' => (bool)$exam->is_published, // নিশ্চিত করুন বুলিয়ান ভ্যালু যাচ্ছে
                'message' => $exam->is_published ? 'Result Published Successfully' : 'Result Unpublished Successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
