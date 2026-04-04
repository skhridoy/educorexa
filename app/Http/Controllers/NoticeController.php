<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    // নোটিশের তালিকা দেখানো
    public function index($tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        $notices = Notice::where('school_id', $school->id)
                        ->orderBy('notice_date', 'desc')
                        ->get();

        return view('school.admin.notice.index', compact('notices'));
    }

    // নতুন নোটিশ সেভ করা
    public function store(Request $request, $tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'notice_date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048', // ২ এমবি লিমিট
        ]);

        $notice = new Notice();
        $notice->school_id = $school->id;
        $notice->title = $request->title;
        $notice->notice_date = $request->notice_date;
        $notice->description = $request->description;

        // ফাইল হ্যান্ডলিং
        if ($request->hasFile('file')) {
            $folderPath = public_path("uploads/schools/{$tenant}/notices");
            
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            $file = $request->file('file');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move($folderPath, $filename);
            
            $notice->file = "uploads/schools/{$tenant}/notices/" . $filename;
        }

        $notice->save();

        return back()->with('success', 'নোটিশটি সফলভাবে তৈরি করা হয়েছে!');
    }

    // নোটিশ ডিলিট করা
    public function destroy($tenant, $id)
    {
        $notice = Notice::findOrFail($id);

        // ফাইল থাকলে ডিলিট করা
        if ($notice->file && File::exists(public_path($notice->file))) {
            File::delete(public_path($notice->file));
        }

        $notice->delete();

        return back()->with('success', 'নোটিশটি মুছে ফেলা হয়েছে!');
    }
}