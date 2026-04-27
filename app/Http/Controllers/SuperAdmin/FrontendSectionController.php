<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FrontendSection;
use Illuminate\Http\Request;

class FrontendSectionController extends Controller
{
    // সেকশন লিস্ট পেজ
    public function index()
    {
        $sections = FrontendSection::orderBy('order', 'asc')->get();
        return view('frontend.manage.sections.index', compact('sections'));
    }

    // AJAX স্ট্যাটাস আপডেট (Toggle Switch)
    public function updateStatus(Request $request)
    {
        // Spatie Permission থাকলে: if (!auth()->user()->can('frontend.manage'))
        if (auth()->user()->role !== 'super_admin') {
            return response()->json(['status' => 'error', 'message' => 'অনুমতি নেই!'], 403);
        }

        $section = FrontendSection::find($request->id);
        if ($section) {
            $section->status = $request->status;
            $section->save();

            return response()->json([
                'status' => 'success',
                'message' => $section->title . ' এখন ' . ($section->status ? 'Active' : 'Deactive')
            ]);
        }
        return response()->json(['status' => 'error', 'message' => 'সেকশন পাওয়া যায়নি!'], 404);
    }

    // এডিট পেজ (ডাইনামিকালি কী (key) অনুযায়ী ভিউ লোড করবে)
    public function edit($id)
    {
        $section = FrontendSection::findOrFail($id);
        $content = json_decode($section->content, true) ?? []; // NULL হলে খালি অ্যারে দিবে

        // আপনার স্ট্রাকচার অনুযায়ী পাথ: frontend.manage.sections.edit
        $viewPath = "frontend.manage.sections.edit." . $section->key;

        if (view()->exists($viewPath)) {
            return view($viewPath, compact('section', 'content'));
        }

        return view("frontend.manage.sections.edit.default", compact('section', 'content'));
    }

    // আপডেট ফাংশন (সব সেকশনের জন্য কাজ করবে)
    public function update(Request $request, $id)
    {
        $section = FrontendSection::findOrFail($id);
        
        // ডাটা সংগ্রহ (অপ্রয়োজনীয় ইনপুট বাদে)
        $data = $request->except(['_token', '_method', 'image']);
        
        // আগের কন্টেন্ট থেকে ইমেজ পাথ নিয়ে রাখা
        $oldContent = json_decode($section->content, true);
        $data['image'] = $oldContent['image'] ?? 'frontend/img/hero.png';

        // যদি নতুন ক্রপ করা ইমেজ থাকে
        if ($request->filled('image')) {
            $imgData = $request->image; // base64 data

            // ইমেজ ফরম্যাট থেকে ডাটা আলাদা করা
            list($type, $imgData) = explode(';', $imgData);
            list(, $imgData)      = explode(',', $imgData);
            $imgData = base64_decode($imgData);

            // ফাইল নেম এবং পাথ সেট করা
            $imageName = 'hero_' . time() . '.png';
            $path = public_path('uploads/frontend/' . $imageName);

            // ফোল্ডার না থাকলে তৈরি করা
            if (!file_exists(public_path('uploads/frontend'))) {
                mkdir(public_path('uploads/frontend'), 0777, true);
            }

            // ফাইল সেভ করা
            file_put_contents($path, $imgData);
            
            // পুরাতন ফাইল ডিলিট করা (যদি ডিফল্ট ইমেজ না হয়)
            if (isset($oldContent['image']) && file_exists(public_path($oldContent['image'])) && !str_contains($oldContent['image'], 'default')) {
                unlink(public_path($oldContent['image']));
            }

            $data['image'] = 'uploads/frontend/' . $imageName;
        }

        $section->update([
            'title'   => $request->title ?? $section->title,
            'content' => json_encode($data)
        ]);

        return redirect()->route('manage.frontend.index')->with('success', 'Hero section updated with image!');
    }

    
}