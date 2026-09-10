<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\School;
use App\Models\SchoolDeleteRequest;
use App\Models\SchoolSubscription;
use App\Models\SubscriptionPackage;
use App\Models\User;
use App\Services\SubscriptionBillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RepresentativeDashboardController extends Controller
{
    /**
     * বর্তমান logged-in user-এর employee record পাওয়া
     */
    private function getEmployee(): ?Employee
    {
        return Employee::where('user_id', Auth::id())->first();
    }

    /**
     * Representative ড্যাশবোর্ড
     * নিজের স্কুল সংখ্যা, মোট কমিশন, সাম্প্রতিক স্কুল দেখাবে
     */
    public function dashboard()
    {
        $user     = Auth::user();
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile পাওয়া যায়নি।');
        }

        // নিজের নিবন্ধিত স্কুলগুলো
        $mySchools        = $employee->registeredSchools()->with('subscriptionPackage')->latest()->take(5)->get();
        $totalMySchools   = $employee->registeredSchools()->count();
        $approvedSchools  = $employee->registeredSchools()->where('status', 'approved')->count();
        $pendingSchools   = $employee->registeredSchools()->where('status', 'pending')->count();

        // কমিশন হিসাব
        $totalCommission  = $employee->calculateTotalCommission();

        // এই মাসের কমিশন হিসাব
        $monthlyCommission = $this->calculateMonthlyCommission($employee);

        // পেন্ডিং ডিলিট রিকোয়েস্ট
        $pendingDeleteRequests = SchoolDeleteRequest::where('requested_by', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('representative.dashboard', compact(
            'user', 'employee', 'mySchools', 'totalMySchools',
            'approvedSchools', 'pendingSchools', 'totalCommission',
            'monthlyCommission', 'pendingDeleteRequests'
        ));
    }

    /**
     * নিজের রেফারেন্সে নিবন্ধিত সব স্কুলের তালিকা
     */
    public function mySchools()
    {
        $user     = Auth::user();
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile পাওয়া যায়নি।');
        }

        $schools = $employee->registeredSchools()
            ->with(['subscriptionPackage', 'subscriptions'])
            ->latest()
            ->get();

        // প্রতিটি স্কুলের pending delete request আছে কিনা চেক
        $pendingDeleteSchoolIds = SchoolDeleteRequest::where('requested_by', $user->id)
            ->where('status', 'pending')
            ->pluck('school_id')
            ->toArray();

        return view('representative.schools.index', compact(
            'user', 'employee', 'schools', 'pendingDeleteSchoolIds'
        ));
    }

    /**
     * স্কুল নিবন্ধন ফর্ম দেখানো
     */
    public function registerSchool()
    {
        $user     = Auth::user();
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile পাওয়া যায়নি।');
        }

        $packages = SubscriptionPackage::where('is_active', true)->orderBy('price', 'asc')->get();

        return view('representative.schools.register', compact('user', 'employee', 'packages'));
    }

    /**
     * স্কুল নিবন্ধন স্টোর
     * বিদ্যমান SchoolRegisterController-এর মতো, কিন্তু representative_id সেট করা হবে
     */
    public function storeSchool(Request $request)
    {
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee profile পাওয়া যায়নি।');
        }

        $request->validate([
            'school_name'     => 'required|string|max:255',
            'division'        => 'required|string|max:100',
            'district'        => 'required|string|max:100',
            'upazila'         => 'required|string|max:100',
            'address'         => 'required|string|max:500',
            'slug'            => 'required|alpha_num|unique:schools,slug',
            'admin_name'      => 'required|string|max:255',
            'admin_email'     => 'required|email|unique:users,email',
            'admin_password'  => 'required|min:8',
            'package_id'      => ['required', Rule::exists('subscription_packages', 'id')->where('is_active', true)],
        ], [
            'school_name.required' => 'স্কুলের নাম দিন।',
            'slug.required'        => 'স্কুলের সাবডোমেইন দিন।',
            'slug.unique'          => 'এই সাবডোমেইন ইতিমধ্যে ব্যবহৃত হচ্ছে।',
            'admin_email.unique'   => 'এই ইমেইল ইতিমধ্যে নিবন্ধিত।',
        ]);

        $newSchool = null;

        DB::transaction(function () use ($request, $employee, &$newSchool) {
            $appCode = School::generateAppCode();

            $newSchool = School::create([
                'name'                   => $request->school_name,
                'slug'                   => strtolower($request->slug),
                'app_code'               => $appCode,
                'email'                  => $request->admin_email,
                'division'               => $request->division,
                'district'               => $request->district,
                'upazila'                => $request->upazila,
                'address'                => implode(', ', [
                    $request->address, $request->upazila,
                    $request->district, $request->division,
                ]),
                'status'                 => 'pending',
                'subscription_package_id' => $request->package_id,
                'representative_id'      => $employee->id, // Representative ID সেট করা হচ্ছে
            ]);

            app(SubscriptionBillingService::class)->createPending(
                $newSchool,
                SubscriptionPackage::findOrFail($request->package_id)
            );

            // School Admin User তৈরি
            $adminUser = User::create([
                'name'      => $request->admin_name,
                'email'     => $request->admin_email,
                'password'  => Hash::make($request->admin_password),
                'role'      => 'school_admin',
                'school_id' => $newSchool->id,
            ]);

            if (method_exists($adminUser, 'assignRole')) {
                $adminUser->assignRole('school_admin');
            }
        });

        // Super Admin কে নোটিফিকেশন পাঠানো
        try {
            $superAdmin = User::where('role', 'super_admin')->first();
            if ($superAdmin) {
                $superAdmin->notify(new \App\Notifications\SuperAdminNotification([
                    'message' => "নতুন স্কুল নিবন্ধন (Representative: {$employee->user->name}): {$newSchool->name}",
                    'icon'    => 'home',
                    'link'    => route('manage.schools.pending'),
                ]));
            }
        } catch (\Exception $e) {
            \Log::error("Representative school registration notification error: " . $e->getMessage());
        }

        return redirect()->route('rep.schools.index')
            ->with('success', 'স্কুল সফলভাবে নিবন্ধন করা হয়েছে! সুপার অ্যাডমিনের অনুমোদনের জন্য অপেক্ষা করুন।');
    }

    /**
     * স্কুল ডিলিট করার রিকোয়েস্ট পাঠানো (সুপার অ্যাডমিন বা HR-এর কাছে)
     */
    public function requestDeleteSchool(Request $request, School $school)
    {
        $user     = Auth::user();
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee profile পাওয়া যায়নি।');
        }

        // শুধু নিজের নিবন্ধিত স্কুলের জন্য রিকোয়েস্ট পাঠাতে পারবেন
        if ($school->representative_id !== $employee->id) {
            return redirect()->back()->with('error', 'আপনি শুধু আপনার নিবন্ধিত স্কুলের জন্য ডিলিট রিকোয়েস্ট পাঠাতে পারবেন।');
        }

        // ইতিমধ্যে পেন্ডিং রিকোয়েস্ট আছে কিনা চেক
        $existingRequest = SchoolDeleteRequest::where('school_id', $school->id)
            ->where('requested_by', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'এই স্কুলের জন্য ইতিমধ্যে একটি পেন্ডিং ডিলিট রিকোয়েস্ট রয়েছে।');
        }

        $request->validate([
            'reason' => 'required|string|min:10|max:1000',
        ], [
            'reason.required' => 'ডিলিট করার কারণ উল্লেখ করুন।',
            'reason.min'      => 'কারণটি কমপক্ষে ১০ অক্ষরের হতে হবে।',
        ]);

        SchoolDeleteRequest::create([
            'school_id'    => $school->id,
            'requested_by' => $user->id,
            'reason'       => $request->reason,
            'status'       => 'pending',
        ]);

        // Super Admin কে নোটিফিকেশন পাঠানো
        try {
            $superAdmin = User::where('role', 'super_admin')->first();
            if ($superAdmin) {
                $superAdmin->notify(new \App\Notifications\SuperAdminNotification([
                    'message' => "স্কুল ডিলিট রিকোয়েস্ট: {$school->name} (Representative: {$employee->user->name})",
                    'icon'    => 'trash',
                    'link'    => route('manage.school.delete-requests.index'),
                ]));
            }
        } catch (\Exception $e) {
            \Log::error("Delete request notification error: " . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'স্কুল ডিলিট রিকোয়েস্ট সুপার অ্যাডমিনের কাছে পাঠানো হয়েছে।');
    }

    /**
     * কমিশন রিপোর্ট পেজ
     */
    public function myCommissions()
    {
        $user     = Auth::user();
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile পাওয়া যায়নি।');
        }

        // নিজের প্রতিটি স্কুল এবং তার subscriptions সহ
        $schoolsWithCommission = $employee->registeredSchools()
            ->with(['subscriptions' => function ($q) {
                $q->whereIn('status', ['active', 'trialing'])->whereNotNull('paid_at');
            }, 'subscriptionPackage'])
            ->latest()
            ->get()
            ->map(function ($school) use ($employee) {
                $schoolCommission = 0;
                foreach ($school->subscriptions as $sub) {
                    if ($employee->commission_type === 'percentage') {
                        $schoolCommission += ($sub->amount * $employee->commission_rate) / 100;
                    } else {
                        $schoolCommission += $employee->commission_rate;
                    }
                }
                $school->earned_commission = $schoolCommission;
                return $school;
            });

        $totalCommission   = $schoolsWithCommission->sum('earned_commission');
        $monthlyCommission = $this->calculateMonthlyCommission($employee);
        $totalSchools      = $employee->registeredSchools()->count();
        $approvedSchools   = $employee->registeredSchools()->where('status', 'approved')->count();

        return view('representative.commissions.index', compact(
            'user', 'employee', 'schoolsWithCommission',
            'totalCommission', 'monthlyCommission',
            'totalSchools', 'approvedSchools'
        ));
    }

    /**
     * এই মাসের কমিশন হিসাব
     */
    private function calculateMonthlyCommission(Employee $employee): float
    {
        $schools = $employee->registeredSchools()->with(['subscriptions' => function ($q) {
            $q->where('status', 'active')
              ->whereNotNull('paid_at')
              ->whereMonth('paid_at', now()->month)
              ->whereYear('paid_at', now()->year);
        }])->get();

        $total = 0;
        foreach ($schools as $school) {
            foreach ($school->subscriptions as $sub) {
                if ($employee->commission_type === 'percentage') {
                    $total += ($sub->amount * $employee->commission_rate) / 100;
                } else {
                    $total += $employee->commission_rate;
                }
            }
        }
        return $total;
    }
}
