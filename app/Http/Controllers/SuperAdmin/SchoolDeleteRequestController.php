<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolDeleteRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SchoolDeleteRequestController extends Controller
{
    /**
     * সব পেন্ডিং ডিলিট রিকোয়েস্ট দেখানো
     */
    public function index()
    {
        $pendingRequests = SchoolDeleteRequest::with(['school', 'requester.employee'])
            ->pending()
            ->latest()
            ->get();

        $allRequests = SchoolDeleteRequest::with(['school', 'requester.employee', 'reviewer'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->take(20)
            ->get();

        return view('super.schools.delete_requests', compact('pendingRequests', 'allRequests'));
    }

    /**
     * ডিলিট রিকোয়েস্ট অনুমোদন করা — স্কুলটি ডিলিট হবে
     */
    public function approve(Request $request, $id)
    {
        $deleteRequest = SchoolDeleteRequest::with('school')->findOrFail($id);

        if ($deleteRequest->status !== 'pending') {
            return back()->with('error', 'এই রিকোয়েস্টটি ইতিমধ্যে প্রসেস করা হয়েছে।');
        }

        $school = $deleteRequest->school;

        if (!$school) {
            // স্কুল ইতিমধ্যে ডিলিট হয়ে গেছে, রিকোয়েস্ট আপডেট করুন
            $deleteRequest->update([
                'status'      => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'admin_note'  => $request->admin_note ?? 'স্কুল ইতিমধ্যে ডিলিট হয়েছে।',
            ]);
            return back()->with('success', 'রিকোয়েস্ট অনুমোদিত হয়েছে (স্কুল পূর্বেই ডিলিট)।');
        }

        DB::transaction(function () use ($deleteRequest, $school, $request) {
            // ডিলিট রিকোয়েস্ট আপডেট
            $deleteRequest->update([
                'status'      => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'admin_note'  => $request->admin_note ?? null,
            ]);

            // স্কুলের সাথে সম্পর্কিত ব্যবহারকারীদের ডিলিট
            $school->users()->delete();

            // স্কুল ডিলিট
            $school->delete();
        });

        // Representative-কে নোটিফিকেশন পাঠানোর চেষ্টা
        try {
            $requester = $deleteRequest->requester;
            if ($requester) {
                $requester->notify(new \App\Notifications\SuperAdminNotification([
                    'message' => "আপনার স্কুল ডিলিট রিকোয়েস্ট অনুমোদিত হয়েছে: {$school->name}",
                    'icon'    => 'check-circle',
                    'link'    => route('rep.schools.index'),
                ]));
            }
        } catch (\Exception $e) {
            \Log::error("Delete request approval notification error: " . $e->getMessage());
        }

        return back()->with('success', 'স্কুল সফলভাবে ডিলিট করা হয়েছে এবং Representative-কে জানানো হয়েছে।');
    }

    /**
     * ডিলিট রিকোয়েস্ট রিজেক্ট করা
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string|min:5|max:500',
        ], [
            'admin_note.required' => 'প্রত্যাখ্যানের কারণ উল্লেখ করুন।',
        ]);

        $deleteRequest = SchoolDeleteRequest::with('school')->findOrFail($id);

        if ($deleteRequest->status !== 'pending') {
            return back()->with('error', 'এই রিকোয়েস্টটি ইতিমধ্যে প্রসেস করা হয়েছে।');
        }

        $deleteRequest->update([
            'status'      => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_note'  => $request->admin_note,
        ]);

        // Representative-কে নোটিফিকেশন পাঠানোর চেষ্টা
        try {
            $requester = $deleteRequest->requester;
            if ($requester) {
                $requester->notify(new \App\Notifications\SuperAdminNotification([
                    'message' => "আপনার স্কুল ডিলিট রিকোয়েস্ট প্রত্যাখ্যাত হয়েছে: {$deleteRequest->school?->name}",
                    'icon'    => 'x-circle',
                    'link'    => route('rep.schools.index'),
                ]));
            }
        } catch (\Exception $e) {
            \Log::error("Delete request rejection notification error: " . $e->getMessage());
        }

        return back()->with('success', 'ডিলিট রিকোয়েস্ট প্রত্যাখ্যাত হয়েছে এবং Representative-কে জানানো হয়েছে।');
    }
}
