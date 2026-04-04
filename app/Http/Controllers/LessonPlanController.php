<?php

namespace App\Http\Controllers;

use App\Models\LessonPlan;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Section;
use App\Models\TeacherAssignSubject;
use Illuminate\Http\Request;

class LessonPlanController extends Controller
{
    /**
     * ডায়েরি লিস্ট এবং এন্ট্রি ফরম দেখানো
     */
    public function index($tenant)
    {
        $schoolId = auth()->user()->school_id;
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return back()->with(['error' => 'Teacher profile not found!', 'type' => 'error']);
        }

        $teacherId = $teacher->id;
        
        // টিচারের নিজের করা আজকের এন্ট্রিগুলো
        $diaries = LessonPlan::where('school_id', $schoolId)
                    ->where('teacher_id', $teacherId) // টিচার আইডি ব্যবহার করা হয়েছে
                    ->where('date', date('Y-m-d'))
                    ->with(['class', 'subject'])
                    ->latest()
                    ->get();

        // শুধুমাত্র এসাইন করা ক্লাসগুলো
        $classes = Classes::where('school_id', $schoolId)
                    ->whereIn('id', function($query) use ($teacherId) {
                        $query->select('class_id')
                              ->from('teacher_assign_subjects')
                              ->where('teacher_id', $teacherId);
                    })
                    ->get();

        $sections = Section::where('school_id', $schoolId)
                        ->whereIn('id', function($query) use ($teacherId) {
                        $query->select('section_id')
                              ->from('teacher_assign_subjects')
                              ->where('teacher_id', $teacherId);
                    })
                    ->get();
        return view('school.lesson-plan.index', compact('diaries', 'classes', 'sections'));
    }

    /**
     * নতুন ডায়েরি সেভ করা
     */
public function store(Request $request, $tenant)
{
    $request->validate([
        'class_id'           => 'required',
        'section_id'         => 'required', // নিশ্চিত করুন ব্লেড ফর্মে এই ইনপুটটি আছে
        'subject_id'         => 'required',
        'date'               => 'required|date',
        'lesson_description' => 'required',
    ]);

    $teacher = auth()->user()->teacher;

    if (!$teacher) {
        return back()->with(['success' => 'Teacher profile not found!', 'type' => 'error']);
    }

    try {
        LessonPlan::create([
            'school_id'          => auth()->user()->school_id,
            'class_id'           => $request->class_id,
            'section_id'         => $request->section_id,
            'subject_id'         => $request->subject_id,
            'teacher_id'         => $teacher->id,
            'date'               => $request->date,
            'submission_date'    => $request->submission_date, // সাবমিশন ডেটা সেভ করা হচ্ছে
            'lesson_description' => $request->lesson_description,
            'homework'           => $request->homework,
        ]);

        // dd() ফেলে দিন, নাহলে পেজ রিফ্রেশ হবে না
        return back()->with(['success' => 'Daily diary saved successfully!', 'type' => 'success']);

    } catch (\Exception $e) {
        // এরর মেসেজটি সেশনে পাঠিয়ে দেওয়া যাতে বোঝা যায় সমস্যা কোথায়
        return back()->with(['success' => 'Database Error: ' . $e->getMessage(), 'type' => 'error']);
    }
}

    /**
     * AJAX: সাবজেক্ট লোড করা
     */
    public function getSubjects($tenant, $class_id)
    {
        $teacher = auth()->user()->teacher;

        if ($teacher) {
            $assignedSubjectIds = TeacherAssignSubject::where('teacher_id', $teacher->id)
                                    ->where('class_id', $class_id)
                                    ->pluck('subject_id');

            $subjects = Subject::whereIn('id', $assignedSubjectIds)->get(['id', 'name']);
            return response()->json($subjects);
        }

        return response()->json([]);
    }

    public function edit($tenant, $lessonPlan)
    {
         $schoolId = auth()->user()->school_id;

        $lessonPlan = LessonPlan::where('school_id', $schoolId)
            ->where('id', $lessonPlan)
            ->firstOrFail();

        return response()->json($lessonPlan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tenant, $lessonPlan)
    {
        $schoolId = auth()->user()->school_id;

        $lessonPlan = LessonPlan::where('school_id', $schoolId)
            ->where('id', $lessonPlan)
            ->firstOrFail();

        $request->validate([
            'class_id'           => 'required',
            'section_id'         => 'required',
            'subject_id'         => 'required',
            'date'               => 'required|date',
            'lesson_description' => 'required',
        ]);

        $lessonPlan->update([
            'class_id'           => $request->class_id,
            'section_id'         => $request->section_id,
            'subject_id'         => $request->subject_id,
            'date'               => $request->date,
            'submission_date'    => $request->submission_date,
            'lesson_description' => $request->lesson_description,
            'homework'           => $request->homework,
        ]);

        return back()->with([
            'success' => 'Lesson plan updated successfully!',
            'type' => 'info'
        ]);
    }

    /**
     * ডায়েরি ডিলিট করা
     */
    public function destroy($tenant, $id)
    {
        $diary = LessonPlan::findOrFail($id);
        $diary->delete();

        return back()->with([
            'success' => 'Diary entry deleted successfully!',
            'type'    => 'success'
        ]);
    }

    public function studentView($tenant)
    {
        // ১. ইউজারের সাথে স্টুডেন্ট রিলেশনটি লোড করা (Eager Loading ব্যবহার করা ভালো)
        $user = auth()->user();
        $student = $user->student; 

        // ২. চেক করা স্টুডেন্ট প্রোফাইল এবং প্রয়োজনীয় ডাটা আছে কি না
        if (!$student || !$student->class_id || !$student->section_id) {
            return back()->with([
                'success' => 'আপনার স্টুডেন্ট প্রোফাইল বা ক্লাস/সেকশন তথ্য পাওয়া যায়নি।', 
                'type' => 'error'
            ]);
        }

        // ৩. আজকের ডায়েরি কুয়েরি
        // school_id ফিল্টার করার চেয়ে সরাসরি স্টুডেন্টের ক্লাস ও সেকশন দিয়ে ধরা বেশি নিখুঁত
        $diaries = LessonPlan::where('class_id', $student->class_id)
                    ->where('section_id', $student->section_id)
                    ->whereDate('date', now()) // Carbon ব্যবহার করে আজকের তারিখ
                    ->with(['subject', 'user']) // সাধারণত টিচারের ডাটা 'user' টেবিলে থাকে, আপনার মডেল অনুযায়ী চেক করুন
                    ->latest()
                    ->get();
        
        return view('school.lesson-plan.student_view', compact('diaries', 'student'));
    }
}