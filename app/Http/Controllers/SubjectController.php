<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Classes;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $query = Subject::where('school_id', $schoolId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $subjects = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $totalSubjectsCount = Subject::where('school_id', $schoolId)->count();

        return view('school.subject.index', compact('subjects', 'totalSubjectsCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,NULL,id,school_id,' . auth()->user()->school_id,
            'type' => 'required|in:theory,practical',
            'description' => 'nullable|string',
            [
                'code.unique' => 'এই কোডটি আপনার বিষয়ে ইতিমধ্যে তৈরি করা আছে!',
            ]
        ]);

        Subject::create([
            'school_id' => auth()->user()->school_id,
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['success' => 'Subject created successfully', 'type' => 'success']);
    }

    public function destroy($tenant, $subjects)
    {// Make sure the subject belongs to the tenant (school)
        $schoolId = auth()->user()->school_id; 
        $subjects = Subject::where('id', $subjects)
                                    ->where('school_id', $schoolId)
                                    ->firstOrFail();

        $subjects->delete();

        return redirect()->back()->with(['success' => 'Subject deleted successfully', 'type' => 'warning']);
    }

    public function edit($tenant, $subject)
    {
        $schoolId = auth()->user()->school_id;
        $subjects = Subject::where('school_id', $schoolId)->orderBy('id', 'desc')->paginate(10)->withQueryString();

        $subject = Subject::where('id', $subject)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        return view('school.subject.edit', compact('subject', 'subjects'));
    }

    public function update(Request $request,$tenant, $subject)
    {
        $schoolId = auth()->user()->school_id;

        $subject = Subject::where('id', $subject)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['success' => 'Subject updated successfully', 'type' => 'success']);
    }

    
}
