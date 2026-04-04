<?php

namespace App\Http\Controllers;

use App\Models\SchoolOverview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SchoolOverviewController extends Controller
{
    public function index($tenant)
    {
        $overviews = SchoolOverview::where('school_id', auth()->user()->school->id)
                                    ->orderBy('order_by', 'asc')
                                    ->get();
        return view('school.admin.overview.index', compact('overviews', 'tenant'));
    }

    public function store(Request $request, $tenant)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'cropped_image' => 'required', // ম্যানুয়াল ক্রপ করা ডাটা বাধ্যতামূলক
        ]);

        $overview = new SchoolOverview();
        $overview->school_id = auth()->user()->school->id;
        $overview->title = $request->title;
        $overview->description = $request->description;
        $overview->features = $request->features;
        $overview->order_by = $request->order_by ?? 0;

        // ইমেজ হ্যান্ডলিং (Base64)
        if ($request->cropped_image) {
            $overview->image = $this->uploadCroppedImage($request->cropped_image, $tenant);
        }

        $overview->save();
        return back()->with('success', 'Overview added successfully with custom crop!');
    }

    public function edit($tenant, $overview)
    {
        $overview = SchoolOverview::where('school_id', auth()->user()->school->id)->findOrFail($overview);
        return view('school.admin.overview.edit', compact('overview', 'tenant'));
    }

    public function update(Request $request, $tenant, $id)
    {
        $overview = SchoolOverview::where('school_id', auth()->user()->school->id)->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $overview->title = $request->title;
        $overview->description = $request->description;
        $overview->features = $request->features;
        $overview->order_by = $request->order_by ?? 0;

        // যদি নতুন ক্রপ করা ইমেজ পাঠানো হয়
        if ($request->cropped_image) {
            // পুরাতন ফাইল ডিলিট
            if ($overview->image && File::exists(public_path($overview->image))) {
                File::delete(public_path($overview->image));
            }
            // নতুন ইমেজ আপলোড
            $overview->image = $this->uploadCroppedImage($request->cropped_image, $tenant);
        }

        $overview->save();
        return redirect()->route('overview.index', $tenant)->with('success', 'Overview Updated successfully!');
    }

    public function destroy($tenant, $id)
    {
        $overview = SchoolOverview::where('school_id', auth()->user()->school->id)->findOrFail($id);
        if ($overview->image && File::exists(public_path($overview->image))) {
            File::delete(public_path($overview->image));
        }
        $overview->delete();
        return back()->with('success', 'Deleted successfully!');
    }

    /**
     * Private helper to handle Base64 Image Upload
     */
    private function uploadCroppedImage($base64Data, $tenant)
    {
        $path = "uploads/schools/{$tenant}/overviews";
        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0755, true);
        }

        $imageInfo = explode(";base64,", $base64Data);
        $imageType = explode("image/", $imageInfo[0])[1];
        $image_base64 = base64_decode($imageInfo[1]);

        $filename = time() . '_' . uniqid() . '.' . $imageType;
        $fullPath = $path . '/' . $filename;

        File::put(public_path($fullPath), $image_base64);
        
        return $fullPath;
    }
}