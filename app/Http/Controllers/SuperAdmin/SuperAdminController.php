<?php 

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\School;
use App\Models\Employee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\SchoolApprovedMail;
use App\Mail\ProfessionalEmailDetailsMail;
use Illuminate\Support\Facades\Mail;
use App\Models\SchoolSubscription;
use App\Services\MailServerService;
use App\Services\SubscriptionBillingService;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $mainDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? 'educorexa.com';
        $pendingSchools = School::where('status', 'pending')->count();
        $totalSchools = School::count();
        $recentSchools = School::latest()->take(5)->get();
        $schoolsByDivision = School::query()
            ->select('division', DB::raw('COUNT(*) as total'))
            ->whereNotNull('division')
            ->where('division', '!=', '')
            ->groupBy('division')
            ->orderByDesc('total')
            ->get();
        $schoolsByDistrict = School::query()
            ->select('district', 'division', DB::raw('COUNT(*) as total'))
            ->whereNotNull('district')
            ->where('district', '!=', '')
            ->groupBy('district', 'division')
            ->orderByDesc('total')
            ->get();
        $schoolsWithoutLocation = School::where(function ($query) {
            $query->whereNull('division')->orWhere('division', '')
                ->orWhereNull('district')->orWhere('district', '');
        })->count();
        $upcomingEvents = Event::where('event_date', '>=', now())
                               ->where('is_active', true)
                               ->orderBy('event_date', 'asc')
                               ->take(5)
                               ->get();

        // 💰 Package Revenue & Subscription Analytics
        $totalPackageRevenue = (float) SchoolSubscription::where('status', 'active')->whereNotNull('paid_at')->sum('amount');
        $monthlyPackageRevenue = (float) SchoolSubscription::where('status', 'active')
            ->whereNotNull('paid_at')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');
        $pendingSubscriptionsCount = SchoolSubscription::where('status', 'pending')->whereNotNull('payment_reference')->count();
        $pendingSubscriptionsAmount = (float) SchoolSubscription::where('status', 'pending')->whereNotNull('payment_reference')->sum('amount');
        $recentSubscriptionPayments = SchoolSubscription::with(['school', 'package'])
            ->whereNotNull('payment_reference')
            ->latest('updated_at')
            ->take(6)
            ->get();

        return view('super.dashboard', compact(
            'pendingSchools', 'totalSchools', 'recentSchools', 'upcomingEvents',
            'mainDomain', 'schoolsByDivision', 'schoolsByDistrict', 'schoolsWithoutLocation',
            'totalPackageRevenue', 'monthlyPackageRevenue', 'pendingSubscriptionsCount',
            'pendingSubscriptionsAmount', 'recentSubscriptionPayments'
        ));
    }

    // ২. পেন্ডিং স্কুল লিস্ট
    public function pending()
    {
        $mainDomain = config('app.main_domain', 'schoolerp.test');
        $schools = School::where('status', 'pending')->get();
        return view('super.schools.pending', compact('schools', 'mainDomain'));
    }
    public function approve(School $school)
    {
        DB::transaction(function () use ($school) {
            // ১. স্কুল স্ট্যাটাস আপডেট
            $school->update([
                'status' => 'approved',
                'is_active' => true,
                'slug' => $school->slug ?? Str::slug($school->name)
            ]);

            // ২. স্কুলের অ্যাডমিন ইউজারকে খুঁজে বের করা
            $adminUser = User::where('email', $school->email)
                            ->where('school_id', $school->id)
                            ->first();

            if ($adminUser) {
                // ৩. 'School Admin' রোল নিশ্চিত করা
                $role = Role::firstOrCreate(['name' => 'school_admin', 'guard_name' => 'web']);

                // ৪. কনফিগ থেকে পারমিশন ডাটাবেজে নেওয়া
                $permissions = array_keys(config('permissions.permissions'));

                foreach ($permissions as $permissionName) {
                    Permission::firstOrCreate([
                        'name' => $permissionName, 
                        'guard_name' => 'web'
                    ]);
                }

                // ৫. সংশোধন: syncPermissions এর বদলে missing permissions গুলো যোগ করা
                // এতে আগের পারমিশন রিসেট হবে না
                $role->givePermissionTo($permissions); 

                // ৬. ইউজারকে রোল দেওয়া
                if (!$adminUser->hasRole('school_admin')) {
                    $adminUser->assignRole($role);
                }

                // ৭. সবচেয়ে গুরুত্বপূর্ণ: Spatie এর ইন্টারনাল ক্যাশ ক্লিয়ার করা
                app()[PermissionRegistrar::class]->forgetCachedPermissions();
            }

            app(SubscriptionBillingService::class)->startTrial($school);
        });
       try {
            // ডাটাবেস থেকে লেটেস্ট ডাটা নিশ্চিত করতে রিফ্রেশ করুন
            $school->refresh(); 
            
            Mail::to($school->email)->send(new SchoolApprovedMail($school));
            
            // মেইল সেন্ড হয়েছে কি না তা লগে চেক করার জন্য
            \Log::info("Approval Mail sent to: " . $school->email); 

        } catch (\Exception $e) {
            // যদি মেইল না যায়, তবে এই dd() আপনাকে কারণটি বলে দেবে
            dd("মেইল এরর: " . $e->getMessage()); 
            \Log::error("Approval Email failed: " . $e->getMessage());
        }

        return redirect()->route('manage.schools.all')->with('success', 'School Approved & Welcome Email Sent!');
    }
        
    public function allSchools(Request $request)
    {
        $mainDomain = config('app.main_domain', 'schoolerp.test');
        $query = School::query();

        if ($request->filled('division')) {
            $query->where('division', $request->division);
        }
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        $schools = $query->with('subscriptionPackage')->latest()->get();
        $divisions = School::whereNotNull('division')->where('division', '!=', '')
            ->distinct()->orderBy('division')->pluck('division');
        $districts = School::whereNotNull('district')->where('district', '!=', '')
            ->when($request->division, fn ($q) => $q->where('division', $request->division))
            ->distinct()->orderBy('district')->pluck('district');
        $divisionSummary = School::select('division', DB::raw('COUNT(*) as total'))
            ->whereNotNull('division')->where('division', '!=', '')
            ->groupBy('division')->orderByDesc('total')->get();
        $districtSummary = School::select('district', 'division', DB::raw('COUNT(*) as total'))
            ->whereNotNull('district')->where('district', '!=', '')
            ->groupBy('district', 'division')->orderByDesc('total')->take(10)->get();

        return view('super.schools.all', compact(
            'schools', 'mainDomain', 'divisions', 'districts',
            'divisionSummary', 'districtSummary'
        ));
    }

    public function rejectSchool(School $school)
    {
        $school->status = 'rejected';
        $school->is_active = false;
        $school->save();

        return redirect()
            ->route('manage.schools.all')
            ->with('error', 'School rejected & subdomain deactivated!');
    }

    public function rejected()
    {
        $mainDomain = config('app.main_domain', 'schoolerp.test');
        $schools = School::where('status', 'rejected')->get();
        return view('manage.schools.reject', compact('schools', 'mainDomain'));
    }

    public function destroy(School $school)
    {

        $school->users()->delete(); // Delete associated users
        $school->delete();

        return redirect()
            ->route('manage.schools.all')
            ->with('success', 'School deleted successfully!');
    }

    public function createSchool()
    {
        $mainDomain = config('app.main_domain', 'schoolerp.test');
        return view('super.schools.create', compact('mainDomain'));
    }

    public function schoolStore(Request $request)
    {
        $request->validate([
            'school_name'    => 'required|string|max:255',
            'slug'           => 'required|alpha_num|unique:schools,slug',
            'admin_name'     => 'required|string|max:255',
            'admin_email'    => 'required|email|unique:users,email',
            'admin_mobile'   => ['required', 'regex:/^01[0-9]{9}$/'],
            'admin_password' => 'required|min:8',
        ]);

        // ট্রানজাকশনের বাইরে এক্সেস করার জন্য ভেরিয়েবল
        $newSchool = null;

        DB::transaction(function () use ($request, &$newSchool) {

            // 1️⃣ Create School (সরাসরি approved স্ট্যাটাসে)
            $defaultPackage = \App\Models\SubscriptionPackage::where('is_active', true)->orderBy('price', 'asc')->first();

            $appCode = School::generateAppCode();

            $newSchool = School::create([
                'name'      => $request->school_name,
                'slug'      => strtolower($request->slug),
                'app_code' => $appCode,
                'email'     => $request->admin_email,
                'phone'     => $request->admin_mobile,
                'status'    => 'approved',
                'is_active' => true,
                'subscription_package_id' => $defaultPackage ? $defaultPackage->id : null,
            ]);

            if ($defaultPackage) {
                app(SubscriptionBillingService::class)->startTrial($newSchool);
            }

            // 2️⃣ Create School Admin User
            $adminUser = User::create([
                'name'      => $request->admin_name,
                'email'     => $request->admin_email,
                'password'  => Hash::make($request->admin_password),
                'role'      => 'school_admin',
                'school_id' => $newSchool->id,
            ]);

            if ($adminUser) {
                // ৩. 'School Admin' রোল নিশ্চিত করা
                $role = Role::firstOrCreate(['name' => 'school_admin', 'guard_name' => 'web']);

                // ৪. কনফিগ থেকে পারমিশন নেওয়া
                $permissions = array_keys(config('permissions.permissions'));
                
                foreach ($permissions as $permissionName) {
                    Permission::firstOrCreate([
                        'name' => $permissionName, 
                        'guard_name' => 'web'
                    ]);
                }

                // ৫. পারমিশন দেওয়া
                $role->givePermissionTo($permissions);

                // ৬. ইউজারকে রোল দেওয়া
                $adminUser->assignRole($role);

                // ৭. ক্যাশ ক্লিয়ার
                app()[PermissionRegistrar::class]->forgetCachedPermissions();
            }
        });

        // মেইল পাঠানো (সরাসরি Approved Mail পাঠাচ্ছি কারণ এটি সরাসরি এক্টিভ হয়েছে)
        try {
            if ($newSchool) {
                Mail::to($newSchool->email)->send(new SchoolApprovedMail($newSchool));
            }
        } catch (\Exception $e) {
            \Log::error("Direct Registration Mail Error: " . $e->getMessage());
        }

        return redirect()->route('manage.schools.all')->with('success', 'School created and activation email sent!');
    }
// প্রোফাইল ভিউ মেথড (আপডেটেড)
    public function Profile() {
        $user = Auth::user();
        
        // যদি ইউজার সুপার এডমিন না হয়ে এমপ্লয়ি হয়, তবে তার এমপ্লয়ি ডাটা লোড হবে
        $profileData = User::with('employee')->find($user->id);
        
        return view('super.profile.profile', compact('profileData'));
    }

    // প্রোফাইল আপডেট মেথড (আপডেটেড লজিক)
    public function ProfileStore(Request $request)
    {
        $user = Auth::user();
        $data = User::find($user->id);
        
        // ১. ইউজার টেবিল আপডেট (কমন ফর অল)
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        // ২. যদি এমপ্লয়ি হয়, তবে এমপ্লয়ি টেবিলের অতিরিক্ত তথ্য আপডেট
        if ($data->role === 'employee' || $data->employee) {
            $employee = Employee::where('user_id', $data->id)->first();
            if ($employee) {
                // আপনার এমপ্লয়ি টেবিলে যে কলামগুলো আছে সেগুলো এখানে দিন
                $employee->designation = $request->designation;
                $employee->address = $request->address;
                $employee->save();
            }
        }

        // ৩. ইমেজ হ্যান্ডলিং (ক্রপ করা WebP ফরম্যাট)
        if ($request->cropped_image) {
            $image_data = $request->cropped_image;

            list($type, $image_data) = explode(';', $image_data);
            list(, $image_data)      = explode(',', $image_data);
            $image_data = base64_decode($image_data);

            // রোল অনুযায়ী ফোল্ডার পাথ আলাদা করা (অর্গানাইজড রাখার জন্য)
            $folder = $data->role === 'super_admin' ? 'super_admin' : 'employees';
            $imageName = $folder . '_' . time() . '.webp';
            $directory = public_path('uploads/' . $folder . '/');

            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // পুরনো ছবি ডিলিট
            if (!empty($data->photo) && file_exists($directory . $data->photo)) {
                @unlink($directory . $data->photo);
            }

            file_put_contents($directory . $imageName, $image_data);
            $data->photo = $imageName;
        }

        $data->save();

        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function markNotificationsRead() 
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return response()->json(['status' => 'success']);
    }
    public function approveEmployee(Request $request, $employeeId) {
        $employee = Employee::findOrFail($employeeId);
        $user = $employee->user;

        DB::transaction(function () use ($request, $employee, $user) {
            // ১. এমপ্লয়ি স্ট্যাটাস একটিভ করা
            $employee->update(['status' => 'active']);

            // ২. রোল এসাইন করা (Spatie)
            $role = Role::findById($request->role_id); // মডাল থেকে আসা রোল আইডি
            $user->syncRoles([$role->name]);

            // ৩. পারমিশন গ্রুপিং আপডেট
            // রোলের পারমিশনগুলো অটোমেটিক ইউজার পেয়ে যাবে।
        });

        return back()->with('success', 'এমপ্লয়ি অ্যাপ্রুভ করা হয়েছে এবং পারমিশন কার্যকর হয়েছে।');
    }
    public function updateEmployeePermissions(Request $request, User $user)
    {
        // সুপার এডমিন এমপ্লয়িকে নির্দিষ্ট পারমিশন দিবে
        $user->syncPermissions($request->permissions); // $request->permissions একটি অ্যারে হবে

        return back()->with('success', 'Permissions updated for ' . $user->name);
    }

    // --- Professional Email Management ---
    public function emailRequests()
    {
        $requests = School::whereIn('pro_email_status', ['pending', 'approved', 'rejected'])
                         ->orderBy('updated_at', 'desc')
                         ->get();
        return view('super.schools.professional_emails', compact('requests'));
    }

    public function approveEmailRequest(School $school, MailServerService $mailService)
    {
        if ($school->pro_email_status !== 'pending') {
            return back()->with('error', 'এই অনুরোধটি বর্তমানে পেন্ডিং অবস্থায় নেই।');
        }

        // 1. Prepare email address
        $rootDomain = config('services.cpanel.root_domain', 'educorexa.com');
        $domain = $school->slug . '.' . $rootDomain;
        $emailAddress = ($school->pro_email_prefix ?? 'info') . '@' . $domain;
        
        // 2. Generate secure random password
        $password = Str::random(12) . rand(10, 99) . '!'; // Added complexity

        // 3. Call MailServerService to create account
        \Log::info("Attempting to create professional email for school: " . $school->name . " ($emailAddress)");
        $result = $mailService->createEmailAccount($emailAddress, $password);

        if ($result['success']) {
            // 4. Update Database
            $school->update([
                'pro_email_status' => 'approved',
                'pro_email_address' => $emailAddress,
                'pro_email_password' => $password,
            ]);

            // 5. Send Notification Mail
            try {
                Mail::to($school->email)->send(new ProfessionalEmailDetailsMail($school, $emailAddress, $password));
            } catch (\Exception $e) {
                \Log::error("Failed to send pro email credentials to " . $school->email . ": " . $e->getMessage());
                return back()->with('error', 'প্রফেশনাল ইমেইল তৈরি হয়েছে কিন্তু এডমিনকে মেইল পাঠাতে সমস্যা হয়েছে: ' . $e->getMessage());
            }

            return back()->with('success', 'প্রফেশনাল ইমেইল তৈরি হয়েছে এবং স্কুলের এডমিনকে তথ্য পাঠানো হয়েছে। Email: ' . $emailAddress);
        }

        return back()->with('error', 'সার্ভার ত্রুটি: ' . $result['message']);
    }

    public function rejectEmailRequest(School $school)
    {
        $school->update(['pro_email_status' => 'rejected']);
        return back()->with('success', 'Email request rejected.');
    }

    public function deleteEmailRequest(School $school, MailServerService $mailService)
    {
        if ($school->pro_email_status !== 'approved') {
            return back()->with('error', 'Only approved emails can be deleted.');
        }

        // 1. Delete from server
        if ($school->pro_email_address) {
            $result = $mailService->deleteEmailAccount($school->pro_email_address);
            if (!$result['success']) {
                return back()->with('error', 'Mail Server Error: ' . $result['message']);
            }
        }

        // 2. Update Database
        $school->update([
            'pro_email_status' => 'none',
            'pro_email_address' => null,
            'pro_email_password' => null,
            'pro_email_prefix' => null,
        ]);

        return back()->with('success', 'Professional email account deleted and revoked.');
    }

    public function changePackage(Request $request, School $school)
    {
        $request->validate([
            'package_id' => 'required|exists:subscription_packages,id'
        ]);

        $package = \App\Models\SubscriptionPackage::findOrFail($request->package_id);

        app(SubscriptionBillingService::class)->createPending($school, $package);

        return back()->with('success', "Payment request created for {$package->name}. The package will activate after verification.");
    }
}