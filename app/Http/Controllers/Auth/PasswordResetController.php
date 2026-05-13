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

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send the reset link to the user's email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('emails.password_reset', ['token' => $token, 'email' => $request->email], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password - EduCorexa');
        });

        return back()->with('status', 'We have e-mailed your password reset link!');
    }

    /**
     * Show the reset password form.
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required'
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->first();

        if (!$resetData) {
            return back()->withInput()->withErrors(['email' => 'Invalid token or email!']);
        }

        // Check if token is expired (e.g., 60 minutes)
        if (Carbon::parse($resetData->created_at)->addMinutes(60)->isPast()) {
            return back()->withInput()->withErrors(['email' => 'Reset link has expired!']);
        }

        $user = User::where('email', $request->email)->first();

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        // পাসওয়ার্ড সফলভাবে রিসেট হলে কনফার্মেশন ইমেইল পাঠাও
        Mail::send('emails.password_reset_success', ['user' => $user], function($message) use($user) {
            $message->to($user->email);
            $message->subject('✅ Password Reset Successful - EduCorexa');
        });

        return redirect()->route('login.form')->with('status', 'Your password has been reset successfully! You can now login.');
    }
}
