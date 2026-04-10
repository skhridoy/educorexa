<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\SchoolCategory;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index()
    { 
        $schoolId = auth()->user()->school_id; 
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        $classes = Classes::where('school_id', $schoolId)->latest()->paginate(5);
        
        return view('school.class.index', compact('classes', 'categories'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        
        $request->validate([
            'name' => 'required|string|max:255|unique:classes,name,NULL,id,school_id,' . $schoolId,
            'code' => 'required|string|max:50|unique:classes,code,NULL,id,school_id,' . $schoolId,
            'school_category_id' => 'required',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'এই ক্লাসের নামটি আপনার স্কুলে ইতিমধ্যে তৈরি করা আছে!',
            'code.unique' => 'এই কোডটি ইতিমধ্যে ব্যবহার করা হয়েছে!',
        ]); 

        Classes::create([
            'school_id' => $schoolId,
            'name' => $request->name,
            'code' => $request->code,
            'school_category_id' => $request->school_category_id,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['success' => 'Class created successfully', 'type' => 'success']);
    }


    public function update(Request $request, $tenant, $classId)
    {
        $schoolId = auth()->user()->school_id;
        
        // নির্দিষ্ট ক্লাসটি খুঁজে বের করা
        $class = Classes::where('id', $classId)
                        ->where('school_id', $schoolId)
                        ->firstOrFail();

        $request->validate([
            // ইউনিক চেক করার সময় বর্তমান আইডিকে ইগনোর করা হয়েছে
            'name' => 'required|string|max:255|unique:classes,name,' . $classId . ',id,school_id,' . $schoolId,
            'code' => 'required|string|max:50|unique:classes,code,' . $classId . ',id,school_id,' . $schoolId,
            'school_category_id' => 'required',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'এই ক্লাসটি আপনার স্কুলে ইতিমধ্যে আছে!',
        ]);

        $class->update([
            'name' => $request->name,
            'code' => $request->code,
            'school_category_id' => $request->school_category_id,
            'description' => $request->description,
        ]);

        return redirect()->route('classes.index', ['tenant' => $tenant])
                         ->with(['success' => 'Class updated successfully', 'type' => 'success']);
    }

    public function destroy($tenant, $classId)
    {
        $schoolId = auth()->user()->school_id; 
        $class = Classes::where('id', $classId)
                        ->where('school_id', $schoolId)
                        ->firstOrFail();

        $class->delete();

        return redirect()->back()->with(['success' => 'Class deleted successfully', 'type' => 'warning']);
    }
}