<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutSectionController extends Controller
{
    public function index($tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        $about = AboutSection::where('school_id', $school->id)->first();
        
        return view('school.admin.about.index', compact('about'));
    }

    public function update(Request $request, $tenant)
    {
        $school = auth()->user()->school;

        $about = AboutSection::updateOrCreate(
            ['school_id' => $school->id],
            $request->except(['_token', 'image'])
        );

        if ($request->hasFile('image')) {
            // ১. পুরাতন ইমেজ থাকলে ডিলিট করা
            if ($about->image && File::exists(public_path($about->image))) {
                File::delete(public_path($about->image));
            }

            // ২. নতুন ইমেজের নাম ও পাথ তৈরি (আপনার স্লাইডার লজিক অনুযায়ী)
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = "uploads/schools/{$tenant}/about";

            // ৩. ফোল্ডার না থাকলে তৈরি করা
            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true);
            }

            // ৪. ফাইল মুভ করা এবং ডাটাবেসে পাথ সেভ করা
            $file->move(public_path($path), $filename);
            $about->image = $path . '/' . $filename;
            $about->save();
        }

        return back()->with(['success' => 'About Section updated successfully', 'type' => 'success']);
    }
}