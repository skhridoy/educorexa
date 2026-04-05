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
    public function index()
    {
        $subjects = Subject::where('school_id', auth()->user()->school_id)->get();
        return view('school.subject.index', compact('subjects'));
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
        $subjects = Subject::where('school_id', $schoolId)->get();

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
