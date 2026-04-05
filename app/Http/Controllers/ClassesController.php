<?php

namespace App\Http\Controllers;
use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id; 
        $classes = Classes::where('school_id', $schoolId)->get();
        return view('school.class.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate([
            'name' => 'required|string|max:255|unique:classes,name,NULL,id,school_id,' . $schoolId,
            'code' => 'required|string|max:50|unique:classes,code,NULL,id,school_id,' . $schoolId,
            'description' => 'nullable|string',
            [
                'name.unique' => 'এই ক্লাস এবং কোডটি আপনার স্কুলে ইতিমধ্যে তৈরি করা আছে!',
            ]
        ]); 

        Classes::create([
            'school_id' => auth()->user()->school_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['success' => 'Class created successfully', 'type' => 'success']);
    }

    public function destroy($tenant, $classes)
    {// Make sure the class belongs to the tenant (school)
        $schoolId = auth()->user()->school_id; 
        $classes = Classes::where('id', $classes)
                                    ->where('school_id', $schoolId)
                                    ->firstOrFail();

        $classes->delete();

        return redirect()->back()->with(['success' => 'Class deleted successfully', 'type' => 'warning']);
    }

    public function edit($tenant, $class)
    {
        $classes = Classes::all();
        $schoolId = auth()->user()->school_id;

        $class = Classes::where('id', $class)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        return view('school.class.edit', compact('class', 'classes'));
    }

    public function update(Request $request, $tenant, $class)
    {
        $schoolId = auth()->user()->school_id;

        $class = Classes::where('id', $class)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        $class->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            
            [
                'name.unique' => 'এই ক্লাসটি আপনার স্কুলে ইতিমধ্যে তৈরি করা আছে!',
            ]
        ]);

        return redirect()->back()->with(['success' => 'Class updated successfully', 'type' => 'success']);
    }

}