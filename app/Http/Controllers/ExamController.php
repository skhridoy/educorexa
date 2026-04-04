<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\AcademicYear;
use App\Models\Classes;
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

        $years = AcademicYear::where('school_id', $schoolId)->get();

        $exams = Exam::with('academicYear')
            ->where('school_id', $schoolId)
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('school.exam.index', compact('exams', 'years'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $tenant)
    {
        $schoolId = auth()->user()->school_id;

        $request->validate([
            'year_id' => 'required',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Exam::create([
            'school_id' => $schoolId,
            'year_id' => $request->year_id,
            'name' => $request->name,
            'status' => 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with([
            'success' => 'Exam created successfully!',
            'type' => 'success'
        ]);
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
                        ->where('status', 1) // শুধুমাত্র active exam এর জন্য
                        ->firstOrFail();

            // স্ট্যাটাস টগল (০ থাকলে ১, ১ থাকলে ০)
            $exam->is_published = !$exam->is_published;
            $exam->save();

            return response()->json([
                'success' => true,
                'new_status' => $exam->is_published,
                'message' => $exam->is_published ? 'Result Published Successfully' : 'Result Unpublished'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
