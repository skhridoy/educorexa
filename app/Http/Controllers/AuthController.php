<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | School / Tenant Login (Subdomain)
    |--------------------------------------------------------------------------
    */
    public function loginForm()
    {
        $school = app('currentSchool');
        return view('auth.login', compact('school'));
    }

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
            
            // রিডাইরেক্ট করার সময় নিশ্চিত করা যে স্লাগ আছে
            $tenant = $school->slug; 

            if ($user->hasRole('student')) {
                return redirect()->route('student.dashboard', ['tenant' => $tenant]);
            }
            
            if ($user->hasRole('teacher')) {
                return redirect()->route('teacher.dashboard', ['tenant' => $tenant]);
            }

            if ($user->hasRole('parent')) {
                return redirect()->route('parent.dashboard', ['tenant' => $tenant]);
            }

            return redirect()->route('school.dashboard', ['tenant' => $tenant]);
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    /*
    |--------------------------------------------------------------------------
    | Main Domain Login (Super Admin & Employee)
    |--------------------------------------------------------------------------
    */
    public function mainLoginForm()
    {
        return view('auth.main-login'); 
    }

    public function mainLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // ১. সুপার এডমিন চেক
            if ($user->role === 'super_admin') {
                return redirect()->route('super.dashboard');
            }

            // ২. এমপ্লয়ি চেক (Spatie Role Type)
            $role = Role::where('name', $user->role)->first();
            if ($role && $role->role_type === 'employee') {
                return redirect()->route('employee.dashboard');
            }

            // ৩. যদি স্কুলের কোনো ইউজার এখানে লগইন করতে চায়
            Auth::logout();
            return redirect()->back()->withErrors(['email' => 'এই পোর্টালটি শুধুমাত্র সুপার এডমিন এবং এমপ্লয়িদের জন্য।']);
        }

        return redirect()->back()->withErrors(['email' => 'ইমেইল বা পাসওয়ার্ড ভুল।']);
    }

    /*
    |--------------------------------------------------------------------------
    | Logout Logic
    |--------------------------------------------------------------------------
    */
    
    // স্কুলের লগআউট
    public function logout(Request $request, $tenant)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('school.login.form', ['tenant' => $tenant]);
    }

    // মেইন ডোমেইন লগআউট
    public function mainLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login.form');
    }

    // টেস্ট করার জন্য সুপার এডমিন তৈরি
    public function createSuperAdmin()
    {
        User::updateOrCreate(
            ['email' => 'superadmin@schoolerp.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'super_admin'
            ]
        );
        return redirect(route('login.form'))->with('success', 'Super Admin account ready.');
    }
}