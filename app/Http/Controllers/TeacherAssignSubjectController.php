<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\TeacherAssignSubject;
use Illuminate\Http\Request;

class TeacherAssignSubjectController extends Controller
{

    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $teachers = Teacher::where('school_id',$schoolId)->get();
        $classes = Classes::where('school_id',$schoolId)->get();
        $subjects = Subject::where('school_id',$schoolId)->get();
        $sections = Section::where('school_id',$schoolId)->get();

        $assignments = TeacherAssignSubject::with([
            'teacher','class','subject','section'
        ])
        ->where('school_id',$schoolId);

        // Class filter
        if($request->filled('class_id')){
            $assignments->where('class_id',$request->class_id);
        }

        // Section filter
        if($request->filled('section_id')){
            $assignments->where('section_id',$request->section_id);
        }

        $assignments = $assignments
            ->orderBy('id','desc')
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            return view(
                'school.teacher.partials.assign-table',
                compact('assignments')
            )->render();
        }

        return view('school.teacher.assign',compact(
            'teachers',
            'classes',
            'subjects',
            'sections',
            'assignments'
        ));
    }


    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $request->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required'
        ]);

        // prevent duplicate
        $exists = TeacherAssignSubject::where('school_id',$schoolId)
            ->where('teacher_id',$request->teacher_id)
            ->where('class_id',$request->class_id)
            ->where('section_id',$request->section_id)
            ->where('subject_id',$request->subject_id)
            ->exists();

        if($exists){
            return back()->with([
                'success'=>'Already assigned!',
                'type'=>'warning'
            ]);
        }

        TeacherAssignSubject::create([
            'school_id'=>$schoolId,
            'teacher_id'=>$request->teacher_id,
            'class_id'=>$request->class_id,
            'section_id'=>$request->section_id,
            'subject_id'=>$request->subject_id
        ]);

        return back()->with([
            'success'=>'Teacher assigned successfully!',
            'type'=>'success'
        ]);
    }


    public function destroy($tenant,$assignment)
    {
        $schoolId = auth()->user()->school_id;

        $assignment = TeacherAssignSubject::where('id',$assignment)
            ->where('school_id',$schoolId)
            ->firstOrFail();

        $assignment->delete();

        return back()->with([
            'success'=>'Assignment deleted successfully!',
            'type'=>'warning'
        ]);
    }
}