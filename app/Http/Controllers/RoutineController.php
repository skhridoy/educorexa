<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\AssignClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutineController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->get();
        $sections = Section::where('school_id', $schoolId)->get();
        
        $routines = Routine::where('school_id', $schoolId)
            ->with(['class', 'section', 'subject', 'teacher'])
            ->orderBy(DB::raw("FIELD(day, 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')"))
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        return view('school.routine.index', compact('routines', 'classes', 'sections'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->get();
        $teachers = User::where('school_id', $schoolId)->where('role', 'teacher')->get();
        $academicYears = AcademicYear::where('school_id', $schoolId)->get();

        $assignedSubjects = DB::table('teacher_assign_subjects')
            ->where('school_id', $schoolId)
            ->pluck('subject_id')
            ->toArray();
        
        return view('school.routine.create', compact('classes', 'teachers', 'academicYears', 'assignedSubjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Routine::create([
            'school_id' => auth()->user()->school_id,
            'academic_year_id' => $request->academic_year_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'room_number' => $request->room_number,
        ]);

        return redirect()->route('routine.index', ['tenant' => auth()->user()->school->slug])
            ->with('success', 'Routine added successfully.');
    }

    public function edit($tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $routine = Routine::where('school_id', $schoolId)->findOrFail($id);
        $classes = Classes::where('school_id', $schoolId)->get();
        $sections = Section::where('school_id', $schoolId)->get();
        $subjects = Subject::whereHas('classes', function($q) use ($routine) {
            $q->where('classes.id', $routine->class_id);
        })->get();
        $teachers = User::where('school_id', $schoolId)->where('role', 'teacher')->get();
        $academicYears = AcademicYear::where('school_id', $schoolId)->get();

        return view('school.routine.edit', compact('routine', 'classes', 'sections', 'subjects', 'teachers', 'academicYears'));
    }

    public function update(Request $request, $tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $routine = Routine::where('school_id', $schoolId)->findOrFail($id);

        $request->validate([
            'academic_year_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $routine->update($request->all());

        return redirect()->route('routine.index', ['tenant' => auth()->user()->school->slug])
            ->with('success', 'Routine updated successfully.');
    }

    public function destroy($tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $routine = Routine::where('school_id', $schoolId)->findOrFail($id);
        $routine->delete();

        return back()->with('success', 'Routine deleted successfully.');
    }

    public function getSubjects($tenant, $classId)
    {
        $schoolId = auth()->user()->school_id;

        $subjects = DB::table('assign_classes')
                ->where('assign_classes.class_id', $classId)
                ->where('assign_classes.school_id', $schoolId)
                ->join('subjects', 'assign_classes.subject_id', '=', 'subjects.id')
                ->select('subjects.id', 'subjects.name')
                ->get();

        return response()->json($subjects);
    }
}
