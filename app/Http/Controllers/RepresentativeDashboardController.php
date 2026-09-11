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
     * নিজের স্কুল সংখ্যা, মোট কমিশন, মাসিক চার্ট, সাম্প্রতিক স্কুল ও ডিলিট রিকোয়েস্ট ট্র্যাকার
     */
    public function dashboard()
    {
        $user     = Auth::user();
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile পাওয়া যায়নি।');
        }

        $mainDomain = config('app.main_domain', 'schoolerp.test');

        // নিজের নিবন্ধিত স্কুলগুলো (সর্বশেষ ৬টি)
        $mySchools = $employee->registeredSchools()
            ->with(['subscriptionPackage', 'subscriptions' => function($q) {
                $q->where('status', 'active')->whereNotNull('paid_at');
            }])
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($school) use ($employee) {
                $comm = $employee->calculateSchoolCommission($school);
                $school->registration_commission = $comm['registration'];
                $school->monthly_commission = $comm['monthly'];
                $school->earned_commission = $comm['total'];
                return $school;
            });

        // পরিসংখ্যান
        $totalMySchools     = $employee->registeredSchools()->count();
        $approvedSchools    = $employee->registeredSchools()->where('status', 'approved')->count();
        $pendingSchools     = $employee->registeredSchools()->where('status', 'pending')->count();
        $rejectedSchools    = $employee->registeredSchools()->where('status', 'rejected')->count();
        $thisMonthSchools   = $employee->registeredSchools()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // সক্রিয় সাবস্ক্রিপশন সংখ্যা
        $activeSubscriptionsCount = DB::table('school_subscriptions')
            ->join('schools', 'schools.id', '=', 'school_subscriptions.school_id')
            ->where('schools.representative_id', $employee->id)
            ->where('school_subscriptions.status', 'active')
            ->count();

        // কমিশন হিসাব (২-ধাপ কমিশন: রেজিস্ট্রেশন + মাসিক রিকারিং)
        $commBreakdown           = $employee->calculateTotalCommissionBreakdown();
        $totalCommission         = $commBreakdown['total'];
        $totalRegCommission      = $commBreakdown['registration'];
        $totalMonthlyCommission  = $commBreakdown['monthly'];
        $monthlyCommission       = $this->calculateMonthlyCommission($employee);

        // পেন্ডিং ও সাম্প্রতিক ডিলিট রিকোয়েস্ট ট্র্যাকিং
        $pendingDeleteRequests = SchoolDeleteRequest::where('requested_by', $user->id)
            ->where('status', 'pending')
            ->count();

        $myDeleteRequests = SchoolDeleteRequest::where('requested_by', $user->id)
            ->with(['school', 'reviewer'])
            ->latest()
            ->take(5)
            ->get();

        // গত ৬ মাসের ট্রেন্ড অ্যানালিটিক্স (চার্টের জন্য)
        $chartData = $this->getSixMonthsTrend($employee);

        // পেন্ডিং ডিলিট থাকা স্কুলের আইডি তালিকা (মডাল ও বাটনের জন্য)
        $pendingDeleteSchoolIds = SchoolDeleteRequest::where('requested_by', $user->id)
            ->where('status', 'pending')
            ->pluck('school_id')
            ->toArray();

        return view('representative.dashboard', compact(
            'user', 'employee', 'mySchools', 'totalMySchools',
            'approvedSchools', 'pendingSchools', 'rejectedSchools',
            'thisMonthSchools', 'activeSubscriptionsCount',
            'totalCommission', 'totalRegCommission', 'totalMonthlyCommission', 'monthlyCommission',
            'pendingDeleteRequests', 'myDeleteRequests', 'chartData',
            'pendingDeleteSchoolIds', 'mainDomain'
        ));
    }

    /**
     * নিজের রেফারেন্সে নিবন্ধিত সব স্কুলের তালিকা (সার্চ ও ফিল্টারসহ)
     */
    public function mySchools(Request $request)
    {
        $user     = Auth::user();
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile পাওয়া যায়নি।');
        }

        $mainDomain = config('app.main_domain', 'schoolerp.test');

        $query = $employee->registeredSchools()->with(['subscriptionPackage', 'subscriptions']);

        // স্ট্যাটাস ফিল্টার
        if ($request->filled('status') && in_array($request->status, ['approved', 'pending', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // সার্চ (নাম, সাবডোমেইন, অ্যাপ কোড, জেলা)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('app_code', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%");
            });
        }

        $schools = $query->latest()->get();

        // স্ট্যাটাস কাউন্ট
        $allCount      = $employee->registeredSchools()->count();
        $approvedCount = $employee->registeredSchools()->where('status', 'approved')->count();
        $pendingCount  = $employee->registeredSchools()->where('status', 'pending')->count();
        $rejectedCount = $employee->registeredSchools()->where('status', 'rejected')->count();

        // প্রতিটি স্কুলের pending delete request আছে কিনা চেক
        $pendingDeleteSchoolIds = SchoolDeleteRequest::where('requested_by', $user->id)
            ->where('status', 'pending')
            ->pluck('school_id')
            ->toArray();

        return view('representative.schools.index', compact(
            'user', 'employee', 'schools', 'pendingDeleteSchoolIds',
            'allCount', 'approvedCount', 'pendingCount', 'rejectedCount', 'mainDomain'
        ));
    }

    /**
     * স্কুল নিবন্ধন (Super Admin এর বিদ্যমান স্কুল তৈরি পেজে রিডাইরেক্ট)
     */
    public function registerSchool()
    {
        return redirect()->route('manage.schools.create');
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
                $comm = $employee->calculateSchoolCommission($school);
                $school->registration_commission = $comm['registration'];
                $school->monthly_commission = $comm['monthly'];
                $school->earned_commission = $comm['total'];
                return $school;
            });

        $commBreakdown          = $employee->calculateTotalCommissionBreakdown();
        $totalCommission        = $commBreakdown['total'];
        $totalRegCommission     = $commBreakdown['registration'];
        $totalMonthlyCommission = $commBreakdown['monthly'];
        $monthlyCommission      = $this->calculateMonthlyCommission($employee);
        $totalSchools           = $employee->registeredSchools()->count();
        $approvedSchools        = $employee->registeredSchools()->where('status', 'approved')->count();

        return view('representative.commissions.index', compact(
            'user', 'employee', 'schoolsWithCommission',
            'totalCommission', 'totalRegCommission', 'totalMonthlyCommission',
            'monthlyCommission', 'totalSchools', 'approvedSchools'
        ));
    }

    /**
     * নির্দিষ্ট মাসের কমিশন হিসাব (রেজিস্ট্রেশন কমিশন + সক্রিয় সাবস্ক্রিপশনের মাসিক কমিশন)
     */
    private function calculateMonthlyCommission(Employee $employee, $targetDate = null): float
    {
        $targetDate = $targetDate ? \Carbon\Carbon::parse($targetDate) : now();

        $schools = $employee->registeredSchools()->with(['subscriptionPackage', 'subscriptions' => function ($q) use ($targetDate) {
            $q->where('status', 'active')
              ->whereNotNull('paid_at')
              ->whereMonth('paid_at', $targetDate->month)
              ->whereYear('paid_at', $targetDate->year);
        }])->get();

        $total = 0;
        foreach ($schools as $school) {
            // ১. রেজিস্ট্রেশন কমিশন (যদি এই নির্দিষ্ট মাসে স্কুলটি নিবন্ধিত বা অনুমোদিত হয়ে থাকে)
            if ($school->created_at->year == $targetDate->year && $school->created_at->month == $targetDate->month) {
                if (in_array($school->status, ['approved', 'active']) || $school->subscriptions()->whereNotNull('paid_at')->exists()) {
                    $total += $employee->calculateRegistrationCommissionForSchool($school);
                }
            }

            // ২. এই মাসের পেইড সাবস্ক্রিপশনগুলোর জন্য মাসিক এক্সট্রা কমিশন
            foreach ($school->subscriptions as $sub) {
                $total += $employee->calculateMonthlyCommissionForSchool($school, (float)$sub->amount);
            }
        }
        return round($total, 2);
    }

    /**
     * বিগত ৬ মাসের ট্রেন্ড ডাটা (নিবন্ধিত স্কুল সংখ্যা ও অর্জিত কমিশন)
     */
    private function getSixMonthsTrend(Employee $employee): array
    {
        $labels = [];
        $schoolsData = [];
        $commissionData = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $labels[] = $monthDate->format('M Y');

            // এই মাসে নিবন্ধিত স্কুল সংখ্যা
            $schoolsCount = $employee->registeredSchools()
                ->whereMonth('created_at', $monthDate->month)
                ->whereYear('created_at', $monthDate->year)
                ->count();
            $schoolsData[] = $schoolsCount;

            // এই মাসে অর্জিত মোট কমিশন (রেজিস্ট্রেশন + মাসিক)
            $commissionData[] = $this->calculateMonthlyCommission($employee, $monthDate);
        }

        return [
            'labels'      => $labels,
            'schools'     => $schoolsData,
            'commissions' => $commissionData,
        ];
    }
}
