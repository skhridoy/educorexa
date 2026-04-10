<?php

namespace App\Http\Controllers;

use App\Models\SchoolSubCategory;
use App\Models\SchoolCategory;
use Illuminate\Http\Request;

class SchoolSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        $subCategories = SchoolSubCategory::with('mainCategory')
                            ->where('school_id', $schoolId)
                            ->get();

        return view('school.categories.sub_categories.index', compact('categories', 'subCategories'));
    }

    public function store(Request $request)
    {
        
        $schoolId = auth()->user()->school_id;
        $request->validate([
            'school_category_id' => 'required',
            'name' => 'required'
        ]);

        SchoolSubCategory::create([
            'school_id' => $schoolId,
            'school_category_id' => $request->school_category_id,
            'name' => $request->name,
        ]);

        return back()->with(['success' => 'Sub-Category Created Successfully!', 'error' => 'This Sub-Category Already Exists!']);
    }

    public function edit(SchoolSubCategory $schoolSubCategory)
    {
            $schoolId = auth()->user()->school_id;
            $categories = SchoolCategory::where('school_id', $schoolId)->get();
            return view('school.sub_categories.edit', compact('schoolSubCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolSubCategory $schoolSubCategory)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate([
            'school_category_id' => 'required',
            'name' => 'required'
        ]);

        $schoolSubCategory->update([
            'school_category_id' => $request->school_category_id,
            'name' => $request->name,
        ]);

        return back()->with(['success' => 'Sub-Category Updated Successfully!', 'error' => 'This Sub-Category Already Exists!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolSubCategory $schoolSubCategory)
    {
        $schoolSubCategory->delete();
        return back()->with('success', 'Sub-Category Deleted!');
    }
}
