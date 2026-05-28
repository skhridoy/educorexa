<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\MainNewsletter;
use App\Models\School;
use Illuminate\Http\Request;
use App\Mail\NewsletterMail;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    // ফ্রন্টএন্ড থেকে সাবস্ক্রিপশন সেভ করা
    public function subscribe(Request $request, $tenant)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $school = School::where('slug', $tenant)->firstOrFail();

        // চেক করা ইমেইলটি অলরেডি আছে কি না
        $exists = Newsletter::where('school_id', $school->id)
                            ->where('email', $request->email)
                            ->exists();

        if ($exists) {
            return back()->with('info', 'You are already subscribed!');
        }

        Newsletter::create([
            'school_id' => $school->id,
            'email' => $request->email
        ]);

        return back()->with('success', 'Thanks for subscribing!');
    }

    // অ্যাডমিন প্যানেলে লিস্ট দেখা
    public function index($tenant)
    {
        $school = auth()->user()->school;
        $subscribers = Newsletter::where('school_id', $school->id)
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(20);

        return view('school.admin.newsletter.index', compact('subscribers', 'tenant'));
    }

    // সাবস্ক্রাইবার ডিলিট করা
    public function destroy($tenant, $id)
    {
        Newsletter::where('id', $id)->delete();
        return back()->with('success', 'Subscriber removed!');
    }

    // ইমেইল পাঠানোর ফর্ম দেখানো
    public function createMail($tenant)
    {
        return view('school.admin.newsletter.send_mail', compact('tenant'));
    }

    // ইমেইল সেন্ড করা
    public function sendMail(Request $request, $tenant)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required'
        ]);

        $school = auth()->user()->school;
        $subscribers = Newsletter::where('school_id', $school->id)->where('is_active', true)->get();

        if ($subscribers->isEmpty()) {
            return back()->with('error', 'No active subscribers found!');
        }

        // লুপ চালিয়ে সবার কাছে মেইল পাঠানো
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewsletterMail($request->subject, $request->message, $school));
        }

        return back()->with('success', 'Emails have been added to the queue and will be sent shortly!');
    }

    public function mainSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $exists =   MainNewsletter::where('email', $request->email)->exists();

        if ($exists) {
            return back()->with('info', 'You are already subscribed!');
        }

        MainNewsletter::create([
            'email' => $request->email
        ]);

        return back()->with('success', 'Thanks for subscribing!');
    }
}