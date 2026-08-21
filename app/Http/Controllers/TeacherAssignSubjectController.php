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
    /**
     * Get the active school ID from user or request context.
     */
    private function getSchoolId(?Request $request = null): ?int
    {
        return auth()->user()?->school_id
            ?? (app()->bound('currentSchool') ? app('currentSchool')->id : null)
            ?? ($request ? $request->school_id : null);
    }

    public function index(Request $request)
    {
        $schoolId = $this->getSchoolId($request);

        $teachers = Teacher::where('school_id', $schoolId)->orderBy('name', 'asc')->get();
        $classes = Classes::where('school_id', $schoolId)->orderBy('name', 'asc')->get();
        $subjects = Subject::where('school_id', $schoolId)->orderBy('name', 'asc')->get();
        $sections = Section::where('school_id', $schoolId)->orderBy('name', 'asc')->get();

        $query = TeacherAssignSubject::with([
            'teacher', 'class', 'subject', 'section'
        ])
        ->where('school_id', $schoolId);

        // Class filter
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Section filter
        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        // Teacher filter
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        // Search text
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('teacher', function($tQuery) use ($search) {
                    $tQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('subject', function($sQuery) use ($search) {
                    $sQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('class', function($cQuery) use ($search) {
                    $cQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        $allAssignments = $query->orderBy('class_id', 'asc')->orderBy('id', 'desc')->get();
        $totalAssignmentsCount = $allAssignments->count();

        // Group assignments by class_id
        $groupedAssignments = $allAssignments->groupBy('class_id');

        if ($request->ajax()) {
            return view(
                'school.teacher.partials.assign-table',
                compact('groupedAssignments', 'totalAssignmentsCount')
            )->render();
        }

        $totalAssignments = TeacherAssignSubject::where('school_id', $schoolId)->count();
        $assignedTeachersCount = TeacherAssignSubject::where('school_id', $schoolId)->distinct('teacher_id')->count('teacher_id');

        return view('school.teacher.assign', compact(
            'teachers',
            'classes',
            'subjects',
            'sections',
            'groupedAssignments',
            'totalAssignmentsCount',
            'totalAssignments',
            'assignedTeachersCount'
        ));
    }

    public function store(Request $request)
    {
        $schoolId = $this->getSchoolId($request);

        $request->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required'
        ]);

        // prevent duplicate
        $exists = TeacherAssignSubject::where('school_id', $schoolId)
            ->where('teacher_id', $request->teacher_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('subject_id', $request->subject_id)
            ->exists();

        if ($exists) {
            return back()->with([
                'success' => 'Already assigned!',
                'type' => 'warning'
            ]);
        }

        TeacherAssignSubject::create([
            'school_id' => $schoolId,
            'teacher_id' => $request->teacher_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id
        ]);

        return back()->with([
            'success' => 'Teacher assigned successfully!',
            'type' => 'success'
        ]);
    }

    public function destroy($tenant, $assignment)
    {
        $schoolId = $this->getSchoolId();

        $assignment = TeacherAssignSubject::where('id', $assignment)
            ->where('school_id', $schoolId)
            ->firstOrFail();

        $assignment->delete();

        return back()->with([
            'success' => 'Assignment deleted successfully!',
            'type' => 'warning'
        ]);
    }
}