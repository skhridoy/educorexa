<?php

namespace App\Http\Controllers;

use App\Models\SchoolCategory;
use Illuminate\Http\Request;

class SchoolCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        return view('school.categories.index', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate(['name' => 'required', 'exams_per_year' => 'required|numeric']);

        SchoolCategory::create([
            'school_id' => $schoolId,
            'name' => $request->name,
            'exams_per_year' => $request->exams_per_year,
        ]);

        return back()->with(['success' => 'Category Created Successfully!', 'error' => 'This Category Already Exists!']);
    }

    
    public function edit($tenant, $category)
    {
        $schoolId = auth()->user()->school_id;
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        $category = SchoolCategory::where('id', $category)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();
        
        return view('school.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tenant, $category)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate(['name' => 'required', 'exams_per_year' => 'required|numeric']);
        $category = SchoolCategory::where('id', $category)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();
        $category->update([
            'name' => $request->name,
            'exams_per_year' => $request->exams_per_year,
        ]);

        return back()->with(['success' => 'Category Updated Successfully!', 'type' => 'warning']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tenant, $category)
    {
        $schoolId = auth()->user()->school_id;
        $category = SchoolCategory::where('id', $category)
                                        ->where('school_id', $schoolId)
                                        ->firstOrFail();
        $category->delete();
        return back()->with(['success' => 'Category Deleted Successfully!', 'type' => 'warning']);
    }
}
