<?php

namespace App\Http\Controllers;

use App\Models\AssignClass;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AssignClassController extends Controller
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

        $classes = Classes::where('school_id', $schoolId)->get();
        $subjects = Subject::where('school_id', $schoolId)->get();

        $assignmentsQuery = AssignClass::with(['class', 'subject', 'category', 'subcategory'])
                        ->where('school_id', $schoolId);

        // Class Filter
        if ($request->filled('class_id')) {
            $assignmentsQuery->where('class_id', $request->class_id);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $assignmentsQuery->where(function($q) use ($search) {
                $q->whereHas('class', function($cQ) use ($search) {
                    $cQ->where('name', 'like', "%{$search}%");
                })->orWhereHas('subject', function($sQ) use ($search) {
                    $sQ->where('name', 'like', "%{$search}%");
                });
            });
        }

        $allAssignments = $assignmentsQuery->orderBy('class_id', 'asc')->orderBy('id', 'desc')->get();
        $groupedAssignments = $allAssignments->groupBy('class_id');
        $totalAssignmentsCount = $allAssignments->count();

        if ($request->ajax()) {
            return view('school.subject.partials.assign-table',
                compact('groupedAssignments', 'totalAssignmentsCount')
            )->render();
        }

        return view('school.subject.assign',
            compact('classes', 'subjects', 'groupedAssignments', 'totalAssignmentsCount')
        );
    }

    public function store(Request $request)
    {
        $schoolId = $this->getSchoolId($request);

        $subject = Subject::find($request->subject_id);
        $subjectType = $subject?->type ?? 'theory';

        // Base validation rules
        $rules = [
            'class_id' => [
                'required',
                Rule::exists('classes', 'id')->where('school_id', $schoolId),
                Rule::unique('assign_classes')->where(function ($query) use ($schoolId, $request) {
                    return $query->where('school_id', $schoolId)
                                ->where('class_id', $request->class_id)
                                ->where('subject_id', $request->subject_id);
                }),
            ],
            'subject_id' => [
                'required',
                Rule::exists('subjects', 'id')->where('school_id', $schoolId),
            ],
        ];

        // Dynamic mark validation by subject type
        if ($subjectType === 'theory_practical') {
            $rules['theory_full_mark']      = 'required|numeric|min:0';
            $rules['theory_pass_mark']      = 'required|numeric|min:0';
            $rules['practical_full_mark']   = 'required|numeric|min:0';
            $rules['practical_pass_mark']   = 'required|numeric|min:0';
        } elseif ($subjectType === 'practical') {
            $rules['practical_full_mark']   = 'required|numeric|min:0';
            $rules['practical_pass_mark']   = 'required|numeric|min:0';
        } else {
            // theory (default)
            $rules['theory_full_mark']  = 'required|numeric|min:0';
            $rules['theory_pass_mark']  = 'required|numeric|min:0';
        }

        $request->validate($rules);

        // Compute aggregated full_mark / pass_mark
        if ($subjectType === 'theory_practical') {
            $fullMark = $request->theory_full_mark + $request->practical_full_mark;
            $passMark = $request->theory_pass_mark + $request->practical_pass_mark;
        } elseif ($subjectType === 'practical') {
            $fullMark = $request->practical_full_mark;
            $passMark = $request->practical_pass_mark;
        } else {
            $fullMark = $request->theory_full_mark;
            $passMark = $request->theory_pass_mark;
        }

        AssignClass::create([
            'school_id'               => $schoolId,
            'school_category_id'      => $request->school_category_id,
            'school_sub_category_id'  => $request->school_sub_category_id,
            'class_id'                => $request->class_id,
            'subject_id'              => $request->subject_id,
            'full_mark'               => $fullMark,
            'pass_mark'               => $passMark,
            'theory_full_mark'        => $subjectType !== 'practical' ? $request->theory_full_mark : null,
            'theory_pass_mark'        => $subjectType !== 'practical' ? $request->theory_pass_mark : null,
            'practical_full_mark'     => $subjectType !== 'theory'    ? $request->practical_full_mark : null,
            'practical_pass_mark'     => $subjectType !== 'theory'    ? $request->practical_pass_mark : null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subject assigned successfully',
            ], 201);
        }

        return back()->with('success', 'Subject assigned successfully');
    }

    public function destroy($tenant, $assignment)
    {
        $schoolId = $this->getSchoolId();

        $assignment = AssignClass::where('id', $assignment)
            ->where('school_id', $schoolId)
            ->firstOrFail();

        $assignment->delete();

        return back()->with([
            'success' => 'Subject assignment deleted successfully',
            'type' => 'warning'
        ]);
    }

    public function edit($tenant, $assignment)
    {
        $schoolId = $this->getSchoolId();
        $classes = Classes::where('school_id', $schoolId)->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        
        $allAssignments = AssignClass::with(['class', 'subject', 'category', 'subcategory'])
                    ->where('school_id', $schoolId)
                    ->orderBy('class_id', 'asc')
                    ->orderBy('id', 'desc')
                    ->get();

        $groupedAssignments = $allAssignments->groupBy('class_id');
        $totalAssignmentsCount = $allAssignments->count();
                    
        if (request()->ajax()) {
            return view('school.subject.partials.assign-table', compact('groupedAssignments', 'totalAssignmentsCount'))->render();
        }

        $assignment = AssignClass::where('id', $assignment)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        return view('school.subject.assign-edit', compact('assignment', 'classes', 'subjects', 'groupedAssignments', 'totalAssignmentsCount'));
    }

    public function update(Request $request, $tenant, $assignment)
    {
        $schoolId = $this->getSchoolId($request);
        $assignment = AssignClass::where('id', $assignment)->where('school_id', $schoolId)->firstOrFail();

        $subject = Subject::find($request->subject_id);
        $subjectType = $subject?->type ?? 'theory';

        $rules = [
            'class_id' => [
                'required',
                Rule::exists('classes', 'id')->where('school_id', $schoolId),
                Rule::unique('assign_classes')->where(function ($query) use ($schoolId, $request) {
                    return $query->where('school_id', $schoolId)
                                ->where('class_id', $request->class_id)
                                ->where('subject_id', $request->subject_id);
                })->ignore($assignment->id),
            ],
            'subject_id' => [
                'required',
                Rule::exists('subjects', 'id')->where('school_id', $schoolId),
            ],
        ];

        if ($subjectType === 'theory_practical') {
            $rules['theory_full_mark']      = 'required|numeric|min:0';
            $rules['theory_pass_mark']      = 'required|numeric|min:0';
            $rules['practical_full_mark']   = 'required|numeric|min:0';
            $rules['practical_pass_mark']   = 'required|numeric|min:0';
        } elseif ($subjectType === 'practical') {
            $rules['practical_full_mark']   = 'required|numeric|min:0';
            $rules['practical_pass_mark']   = 'required|numeric|min:0';
        } else {
            $rules['theory_full_mark']  = 'required|numeric|min:0';
            $rules['theory_pass_mark']  = 'required|numeric|min:0';
        }

        $request->validate($rules);

        if ($subjectType === 'theory_practical') {
            $fullMark = $request->theory_full_mark + $request->practical_full_mark;
            $passMark = $request->theory_pass_mark + $request->practical_pass_mark;
        } elseif ($subjectType === 'practical') {
            $fullMark = $request->practical_full_mark;
            $passMark = $request->practical_pass_mark;
        } else {
            $fullMark = $request->theory_full_mark;
            $passMark = $request->theory_pass_mark;
        }

        $assignment->update([
            'class_id'                => $request->class_id,
            'subject_id'              => $request->subject_id,
            'full_mark'               => $fullMark,
            'pass_mark'               => $passMark,
            'theory_full_mark'        => $subjectType !== 'practical' ? $request->theory_full_mark : null,
            'theory_pass_mark'        => $subjectType !== 'practical' ? $request->theory_pass_mark : null,
            'practical_full_mark'     => $subjectType !== 'theory'    ? $request->practical_full_mark : null,
            'practical_pass_mark'     => $subjectType !== 'theory'    ? $request->practical_pass_mark : null,
            'school_category_id'      => $request->school_category_id,
            'school_sub_category_id'  => $request->school_sub_category_id,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Assign Subject updated successfully'
            ]);
        }

        return redirect()->back()->with(['success' => 'Assign Subject updated successfully', 'type' => 'success']);
    }
}
