<?php

namespace App\Http\Controllers;

use App\Models\MainContactMsg;
use Illuminate\Http\Request;

class MainContactMsgController extends Controller
{
    public function index()
    {
        $messages = MainContactMsg::latest()->paginate(20);
        return view('super.contact_messages.index', compact('messages'));
    }
    public function store(Request $request)
    {
        // ১. বট/স্প্যাম ট্র্যাপ (Honeypot): লুকানো ফিল্ড পূরণ করা থাকলে নিরবে ফিরিয়ে দেয়া হবে
        if (!empty($request->b_field)) {
            return back()->with('success', 'আপনার মেসেজটি সফলভাবে পাঠানো হয়েছে। আমরা দ্রুত আপনার সাথে যোগাযোগ করব।');
        }

        // ২. আইপি ভিত্তিক স্প্যাম রোধ (১০ মিনিটে সর্বোচ্চ ৫টি রিকোয়েস্ট)
        $clientIp = $request->ip();
        $recentCount = MainContactMsg::where('ip_address', $clientIp)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->count();

        if ($recentCount >= 5) {
            return back()
                ->withInput()
                ->with('error', 'অতিরিক্ত রিকোয়েস্ট পাঠানো হয়েছে। অনুগ্রহ করে কিছুক্ষণ পর আবার চেষ্টা করুন।');
        }

        // ৩. ভ্যালিডেশন (সঠিক বাংলাদেশি মোবাইল নম্বর ও ফিল্ড রিকোয়ার্ড)
        $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => [
                'required',
                'string',
                'regex:/^(?:\+?8801|8801|01)[3-9]\d{8}$/'
            ],
            'school_name'    => 'nullable|string|max:255',
            'message'        => 'nullable|string|max:2000',
            'captcha_answer' => 'required|numeric',
            'captcha_token'  => 'required|string',
        ], [
            'name.required'           => 'অনুগ্রহ করে আপনার নাম দিন।',
            'phone.required'          => 'অনুগ্রহ করে আপনার মোবাইল নম্বর দিন।',
            'phone.regex'             => 'অনুগ্রহ করে সঠিক ১১ ডিজিটের বাংলাদেশি মোবাইল নম্বর দিন (যেমন: 017XXXXXXXX)।',
            'captcha_answer.required' => 'হিউম্যান ভেরিফিকেশন প্রশ্নের উত্তর দিন।',
            'captcha_answer.numeric'  => 'ভেরিফিকেশনের উত্তরটি সংখ্যায় দিন।',
        ]);

        // ৪. হিউম্যান ভেরিফিকেশন (ক্যাপচা উত্তর ও টোকেন যাচাই)
        try {
            $decrypted = decrypt($request->captcha_token);
            $parts = explode('|', $decrypted);
            $expectedSum = (int) ($parts[0] ?? -1);
            $timestamp   = (int) ($parts[1] ?? 0);

            // ২০ মিনিটের বেশি পুরাতন হলে এক্সপায়ার
            if (time() - $timestamp > 1200) {
                return back()
                    ->withInput()
                    ->with('error', 'ভেরিফিকেশনের সময় শেষ হয়ে গেছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
            }

            if ((int)$request->captcha_answer !== $expectedSum) {
                return back()
                    ->withInput()
                    ->with('error', 'হিউম্যান ভেরিফিকেশন উত্তরটি ভুল হয়েছে! সঠিক যোগফল দিন।');
            }
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'অকার্যকর ভেরিফিকেশন। অনুগ্রহ করে পেজ রিফ্রেশ করে আবার চেষ্টা করুন।');
        }

        // ৫. মোবাইল নম্বর ফরম্যাট ঠিক করা (যেমন: 01XXXXXXXXX)
        $phoneInput = preg_replace('/[^\d]/', '', $request->phone);
        if (str_starts_with($phoneInput, '8801')) {
            $phoneInput = substr($phoneInput, 2);
        }

        // ৬. আইপি অ্যাড্রেস সহ ডাটাবেজে সংরক্ষণ
        MainContactMsg::create([
            'name'        => $request->name,
            'phone'       => $phoneInput,
            'school_name' => $request->school_name,
            'message'     => $request->message,
            'ip_address'  => $clientIp,
        ]);

        return back()->with('success', 'আপনার মেসেজটি সফলভাবে পাঠানো হয়েছে। আমরা দ্রুত আপনার সাথে যোগাযোগ করব।');
    }

    public function show($id)
    {
        $message = MainContactMsg::findOrFail($id);
        $message->update(['is_read' => true]);
        return view('super.contact_messages.show', compact('message'));
    }
    public function destroy($id)
    {
        MainContactMsg::findOrFail($id)->delete();
        return redirect()->route('manage.contact.index')->with('success', 'Message deleted successfully!');
    }
}
