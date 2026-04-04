<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Section::create([
            'school_id' => auth()->user()->school_id,
            'name' => $request->name,
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
        ]);

        return redirect()->back()->with(['success' => 'Section updated successfully', 'type' => 'success']);
    }
}
