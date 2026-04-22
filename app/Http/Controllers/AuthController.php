<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    // 🔹 School Admin / Teacher / Student Login Page
    public function loginForm()
    {
        $school = app('currentSchool');
        return view('auth.login', compact('school'));
    }

    // 🔹 Unified Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $school = app('currentSchool');

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'school_id' => $school->id
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $tenant = $school->slug;

            // 🔹 রোল অনুযায়ী রিডাইরেক্ট লজিক
            if ($user->role === 'student') {
                return redirect()->route('student.dashboard', ['tenant' => $tenant]);
            } 
            
            if ($user->role === 'teacher') {
                return redirect()->route('teacher.dashboard', ['tenant' => $tenant]);
            }

            if ($user->role === 'parent') {
                return redirect()->route('parent.dashboard', ['tenant' => $tenant]);
            }

            // ডিফল্টভাবে (যেমন অ্যাডমিন হলে) মেইন ড্যাশবোর্ডে যাবে
            return redirect()->route('school.dashboard', ['tenant' => $tenant]);
        }

        return redirect()->route('school.login', ['tenant' => $request->route('tenant')])
            ->withErrors(['email' => 'Invalid credentials']);
    }

    // 🔹 Super Admin Login Page
    public function superLoginForm()
    {
        return view('auth.super-login');
    }

    // 🔹 Super Admin Login Submit
    public function superLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'super_admin'
        ])) {
            return redirect(route('super.dashboard'));
        }

        return redirect()->route('super.login.form')->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request, $tenant)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('school.login.form', [
            'tenant' => $tenant
        ]);
    }
    public function superLogout(Request $request)
    {
        Auth::logout();
        return redirect(route('super.login.form'));
    }

    // Super Admin create account (for testing)

    public function createSuperAdmin()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@schoolerp.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin'
        ]);
        return redirect(route('super.login.form'))->with('success', 'Super Admin account created. You can now login.');
    }

    public function employeeLoginForm()
{
    // site_settings থেকে ডাটা নিয়ে আসা
    $site = \DB::table('site_settings')->first();
    return view('auth.employee-login', compact('site'));
}

    // 🔹 Employee Login Submit
    public function employeeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // প্রথমে লগইন করার চেষ্টা করি
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // চেক করছি ইউজারের রোলটি 'employee' টাইপ কি না
            $role = \Spatie\Permission\Models\Role::where('name', $user->role)->first();

            if ($role && $role->role_type === 'employee') {
                return redirect()->route('employee.dashboard');
            }

            // যদি ইউজার এমপ্লয়ি না হয়, তবে লগআউট করে এরর দেওয়া
            Auth::logout();
            return redirect()->back()->withErrors(['email' => 'This portal is only for employees.']);
        }

        return redirect()->back()->withErrors(['email' => 'Invalid email or password.']);
    }
}
