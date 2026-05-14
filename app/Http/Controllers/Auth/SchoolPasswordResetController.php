<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\SchoolMailConfig;

class SchoolPasswordResetController extends Controller
{
    use SchoolMailConfig;
    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.school-forgot-password');
    }

    /**
     * Send OTP to the user's email.
     */
    public function sendOtp(Request $request)
    {
        $currentSchool = app('currentSchool');

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // ১. ইমেইল দিয়ে ইউজার খোঁজো (যেকোনো স্কুলে)
        $user = User::where('email', $request->email)->first();

        // ২. ইউজার পাওয়া না গেলে জেনেরিক ম্যাসেজ (security: ইমেইল এক্সিস্টেন্স লিক করা যাবে না)
        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email address.']);
        }

        // সুপ্যার এডমিন বা এমপ্লয়ি হলে
        if (empty($user->school_id) && in_array($user->role, ['super_admin', 'employee', 'admin'])) {
            return back()->withErrors(['email' => 'Admins must reset password from the main portal.']);
        }

        // ৩. ইউজার ভিন্ন স্কুলের হলে — সেই স্কুলের লিঙ্ক দেখাও
        if ($user->school_id != $currentSchool->id) {
            $correctSchool = \App\Models\School::find($user->school_id);
            $correctUrl    = $correctSchool
                ? url("https://{$correctSchool->slug}." . config('app.main_domain') . "/forgot-password")
                : null;

            $errorMsg = 'This email is registered with a different school.';
            if ($correctUrl) {
                $errorMsg .= " Please reset your password from: <a href=\"{$correctUrl}\" target=\"_blank\" class=\"fw-bold text-navy\">{$correctSchool->name}</a>";
            }

            return back()
                ->withInput()
                ->with('school_mismatch', $errorMsg);
        }

        // ৪. সঠিক স্কুলের ইউজার — OTP পাঠাও
        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => $otp,
                'created_at' => Carbon::now(),
            ]
        );
        
        $this->setMailConfig($currentSchool);

        Mail::send('emails.school_otp', ['otp' => $otp, 'school' => $currentSchool], function ($message) use ($request, $currentSchool) {
            $message->to($request->email);
            $message->subject('Your OTP for Password Reset - ' . $currentSchool->name);
        });

        return redirect()
            ->route('school.password.verify.form', ['tenant' => $currentSchool->slug, 'email' => $request->email])
            ->with('status', 'A 6-digit OTP has been sent to your email. Valid for 10 minutes.');
    }

    /**
     * Show the OTP verification form.
     */
    public function showVerifyOtpForm(Request $request)
    {
        return view('auth.school-verify-otp', ['email' => $request->email]);
    }

    /**
     * Verify the OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric'
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->otp,
            ])
            ->first();

        if (!$resetData) {
            return back()->withErrors(['otp' => 'Invalid OTP!']);
        }

        if (Carbon::parse($resetData->created_at)->addMinutes(10)->isPast()) {
            return back()->withErrors(['otp' => 'OTP has expired!']);
        }

        // Redirect to reset form with email and OTP (as token)
        return redirect()->route('school.password.reset', [
            'tenant' => app('currentSchool')->slug,
            'email' => $request->email,
            'token' => $request->otp
        ]);
    }

    /**
     * Show the reset password form.
     */
    public function showResetPasswordForm(Request $request)
    {
        return view('auth.school-reset-password', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->first();

        if (!$resetData) {
            return redirect()->route('school.password.request', ['tenant' => app('currentSchool')->slug])->withErrors(['email' => 'Session expired or invalid token.']);
        }

        $user   = User::where('email', $request->email)->first();
        $school = app('currentSchool');

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        $this->setMailConfig($school);

        // পাসওয়ার্ড সফলভাবে রিসেট হলে কনফার্মেশন ইমেইল পাঠাও
        Mail::send('emails.school_password_reset_success', ['user' => $user, 'school' => $school], function($message) use($user, $school) {
            $message->to($user->email);
            $message->subject('✅ Password Reset Successful - ' . $school->name);
        });

        return redirect()->route('school.login.form', ['tenant' => $school->slug])->with('status', 'Your password has been reset successfully!');
    }
}
