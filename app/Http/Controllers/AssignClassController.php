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
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $classes = Classes::where('school_id', $schoolId)->get();
        $subjects = Subject::where('school_id', $schoolId)->get();

        $assignments = AssignClass::with(['class','subject'])
                        ->where('school_id', $schoolId);

        // 🔥 Class Filter
        if ($request->filled('class_id')) {
            $assignments->where('class_id', $request->class_id);
        }

        $assignments = $assignments->orderBy('id', 'desc')
                        ->paginate(5)
                        ->withQueryString(); // important for pagination

        if ($request->ajax()) {
            return view('school.subject.partials.assign-table',
                compact('assignments')
            )->render();
        }

        return view('school.subject.assign',
            compact('classes', 'subjects', 'assignments')
        );
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $request->validate([
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
            'full_mark'  => 'required|numeric',
            'pass_mark'  => 'required|numeric'
        ]);

        AssignClass::create([
            'school_id'  => $schoolId,
            'school_category_id' => $request->school_category_id,
            'school_sub_category_id' => $request->school_sub_category_id,
            'class_id'   => $request->class_id,
            'subject_id' => $request->subject_id,
            'full_mark'  => $request->full_mark,
            'pass_mark'  => $request->pass_mark,
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
        $schoolId = auth()->user()->school_id;

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
        $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        
        $assignments = AssignClass::with(['class','subject'])
                    ->where('school_id', $schoolId)
                    ->orderBy('id', 'desc')
                    ->paginate(5)
                    ->withQueryString();
                    
        if (request()->ajax()) {
            return view('school.subject.partials.assign-table', compact('assignments'))->render();
        }

        $assignment = AssignClass::where('id', $assignment)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        return view('school.subject.assign-edit', compact('assignment', 'classes', 'subjects', 'assignments'));
    }

    public function update(Request $request, $tenant, $assignment)
    {
        $schoolId = auth()->user()->school_id;
        $assignment = AssignClass::where('id', $assignment)->where('school_id', $schoolId)->firstOrFail();

        $request->validate([
            'class_id' => [
                'required',
                Rule::exists('classes', 'id')->where('school_id', $schoolId),
                Rule::unique('assign_classes')->where(function ($query) use ($schoolId, $request) {
                    return $query->where('school_id', $schoolId)
                                ->where('class_id', $request->class_id)
                                ->where('subject_id', $request->subject_id);
                })->ignore($assignment->id), // নিজের আইডি ইগনোর করবে
            ],
            'subject_id' => [
                'required',
                Rule::exists('subjects', 'id')->where('school_id', $schoolId),
            ],
            'full_mark'  => 'required|numeric',
            'pass_mark'  => 'required|numeric',
            
        ]);
        $assignment->update([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'full_mark' => $request->full_mark,
            'pass_mark' => $request->pass_mark,
            'school_category_id' => $request->school_category_id,
            'school_sub_category_id' => $request->school_sub_category_id,
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
