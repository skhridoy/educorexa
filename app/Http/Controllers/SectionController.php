<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::where('school_id', auth()->user()->school_id)->get();
        return view('school.section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
                
                Rule::unique('sections')->where(function ($query) use ($schoolId) {
                    return $query->where('school_id', $schoolId);
                }),
            ],
            'description' => 'nullable|string',
        ],[
            
            'name.unique' => 'এই সেকশনটি আপনার স্কুলে ইতিমধ্যে তৈরি করা আছে!',
        ]);

        Section::create([
            'school_id'   => $schoolId,
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['success' => 'Section created successfully', 'type' => 'success']);
    }

    public function destroy($tenant, $sections)
    {// Make sure the section belongs to the tenant (school)
        $schoolId = auth()->user()->school_id; 
        $sections = Section::where('id', $sections)
                                    ->where('school_id', $schoolId)
                                    ->firstOrFail();

        $sections->delete();

        return redirect()->back()->with(['success' => 'Section deleted successfully', 'type' => 'warning']);
    }

    public function edit($tenant, $section)
    {
        $sections = Section::all();
        $schoolId = auth()->user()->school_id;

        $section = Section::where('id', $section)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        return view('school.section.edit', compact('section', 'sections'));
    }

    public function update(Request $request,$tenant, $section)
    {
        $schoolId = auth()->user()->school_id;

        $section = Section::where('id', $section)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        $section->update([
            'name' => $request->name,
            'description' => $request->description,

            [
                'name.unique' => 'এই সেকশনটি আপনার স্কুলে ইতিমধ্যে তৈরি করা আছে!',
            ]
        ]);

        return redirect()->back()->with(['success' => 'Section updated successfully', 'type' => 'success']);
    }
}
