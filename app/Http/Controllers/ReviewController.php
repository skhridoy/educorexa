<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create()
    {
        $school = app('currentSchool');
        return view('school.review.create', compact('school'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'designation' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        $user = auth()->user();
        $school = app('currentSchool');

        $testimonialData = [
            'user_id' => $user->id,
            'name' => $user->name,
            'institution_name' => $school ? $school->name : null,
            'designation' => $validated['designation'],
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'image' => $user->photo ?? null,
            'is_active' => false, // Pending approval
        ];

        Testimonial::create($testimonialData);

        return redirect()->back()->with('success', 'আপনার রিভিউ সফলভাবে সাবমিট হয়েছে। এডমিন এপ্রুভ করার পর ওয়েবসাইটে যুক্ত হবে। ধন্যবাদ!');
    }
}
