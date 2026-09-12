<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeRegistrationMail;
use Spatie\Permission\Models\Role;

class RepresentativeController extends Controller
{
    /**
     * Show the public representative registration form.
     */
    public function showForm()
    {
        return view('frontend.page.representative_register');
    }

    /**
     * Handle the representative registration form submission.
     * Creates a User + Employee record and sends welcome email.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'required|string|max:20',
            'district'              => 'required|string|max:100',
            'address'               => 'nullable|string|max:500',
            'experience'            => 'nullable|string|max:50',
            'why_join'              => 'nullable|string|max:1000',
            'password'              => 'required|string|min:8|confirmed',
            'agree'                 => 'accepted',
        ], [
            'name.required'              => 'আপনার পূর্ণ নাম দিন।',
            'email.required'             => 'ইমেইল ঠিকানা দিন।',
            'email.unique'               => 'এই ইমেইল ঠিকানা ইতিমধ্যে নিবন্ধিত।',
            'phone.required'             => 'মোবাইল নম্বর দিন।',
            'district.required'          => 'জেলার নাম দিন।',
            'password.required'          => 'পাসওয়ার্ড দিন।',
            'password.min'               => 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।',
            'password.confirmed'         => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
            'agree.accepted'             => 'শর্তাবলীতে সম্মতি দিন।',
        ]);

        try {
            DB::beginTransaction();

            // 1. Representative রোল নির্ধারণ করা (পারমিশন রোলের কনফিগারেশন অনুযায়ী স্বয়ংক্রিয়ভাবে পাবে)
            $role = Role::firstOrCreate(
                ['name' => 'Representative', 'guard_name' => 'web'],
                ['role_type' => 'employee']
            );

            // 2. Use user-provided password
            $plainPassword = $request->password;

            // 3. Create user account
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($plainPassword),
                'role'      => $role->name,
                'phone'     => $request->phone,
                'school_id' => null,
            ]);

            if (method_exists($user, 'assignRole')) {
                $user->assignRole($role->name);
            }

            // 4. Generate unique Employee ID
            $lastEmp   = Employee::latest('id')->first();
            $nextId    = $lastEmp ? ($lastEmp->id + 1) : 1;
            $employeeId = 'REP-' . date('Y') . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            // 5. Build full address with district + experience
            $experienceLabels = [
                'fresher'    => 'ফ্রেশার',
                '1_year'     => '১ বছরের কম অভিজ্ঞতা',
                '2_3_year'   => '১-৩ বছরের অভিজ্ঞতা',
                '3_plus'     => '৩+ বছরের অভিজ্ঞতা',
            ];
            $expLabel   = $experienceLabels[$request->experience] ?? 'উল্লেখ নেই';
            $fullAddress = 'জেলা: ' . $request->district;
            if ($request->address) {
                $fullAddress .= ' | ঠিকানা: ' . $request->address;
            }
            if ($request->why_join) {
                $fullAddress .= ' | কারণ: ' . $request->why_join;
            }

            // 6. Create Employee profile
            Employee::create([
                'user_id'        => $user->id,
                'employee_id'    => $employeeId,
                'designation'    => 'Sales Representative',
                'phone_personal' => $request->phone,
                'address'        => $fullAddress,
                'joining_date'   => now()->toDateString(),
                'salary'         => 0, // Commission-based, set by admin later
                'status'         => 'active',
            ]);

            DB::commit();

            // 7. Send welcome email with credentials
            $details = [
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $plainPassword,
                'url'      => route('login.form'),
            ];

            try {
                Mail::to($request->email)->send(new EmployeeRegistrationMail($details));
                $successMsg = 'রেজিস্ট্রেশন সফল হয়েছে! আপনার ইমেইলে স্বাগত বার্তা পাঠানো হয়েছে। এখন লগইন করুন।';
            } catch (\Exception $mailEx) {
                $successMsg = 'রেজিস্ট্রেশন সফল হয়েছে! কিন্তু ইমেইল পাঠাতে সমস্যা হয়েছে। অনুগ্রহ করে আমাদের সাথে যোগাযোগ করুন।';
            }

            // Super Admin-দের নোটিফিকেশন পাঠানো
            try {
                $superAdmins = User::whereHas('roles', function($q) {
                    $q->where('name', 'super_admin');
                })->orWhere('role', 'super_admin')->get();

                foreach ($superAdmins as $admin) {
                    $admin->notify(new \App\Notifications\SuperAdminNotification([
                        'message' => "নতুন রিপ্রেজেন্টেটিভ রেজিস্টার করেছেন: {$request->name} (জেলা: {$request->district})",
                        'icon'    => 'user-check',
                        'link'    => route('super.employees.index'),
                    ]));
                }
            } catch (\Exception $notifEx) {
                \Log::error("Super admin notification error: " . $notifEx->getMessage());
            }

            return redirect()->route('representative.register.form')
                             ->with('success', $successMsg);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'রেজিস্ট্রেশন ব্যর্থ হয়েছে: ' . $e->getMessage());
        }
    }
}
