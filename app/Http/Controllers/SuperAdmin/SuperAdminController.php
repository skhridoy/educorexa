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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\SchoolApprovedMail;
use Illuminate\Support\Facades\Mail;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $mainDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? 'educorexa.com';
        $pendingSchools = School::where('status', 'pending')->count();
        $totalSchools = School::count();
        $recentSchools = School::latest()->take(5)->get();
        return view('super.dashboard', compact('pendingSchools', 'totalSchools', 'recentSchools', 'mainDomain'));
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

        return redirect()->route('super.schools.all')->with('success', 'School Approved & Welcome Email Sent!');
    }
        
    public function allSchools()
    {
        $mainDomain = config('app.main_domain', 'schoolerp.test');
        $schools = School::all();
        return view('super.schools.all', compact('schools', 'mainDomain'));
    }

    public function rejectSchool(School $school)
    {
        $school->status = 'rejected';
        $school->is_active = false;
        $school->save();

        return redirect()
            ->route('super.schools.all')
            ->with('error', 'School rejected & subdomain deactivated!');
    }

    public function rejected()
    {
        $mainDomain = config('app.main_domain', 'schoolerp.test');
        $schools = School::where('status', 'rejected')->get();
        return view('super.schools.reject', compact('schools', 'mainDomain'));
    }

    public function destroy(School $school)
    {

        $school->users()->delete(); // Delete associated users
        $school->delete();

        return redirect()
            ->route('super.schools.all')
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
            $newSchool = School::create([
                'name'      => $request->school_name,
                'slug'      => strtolower($request->slug),
                'email'     => $request->admin_email,
                'phone'     => $request->admin_mobile,
                'status'    => 'approved',
                'is_active' => true,
            ]);

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

        return redirect()->route('super.schools.all')->with('success', 'School created and activation email sent!');
    }
    public function Profile() {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        
        return view('super.profile.profile', compact('profileData'));
    }

    public function ProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        
        // টেক্সট ফিল্ড আপডেট
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        // যদি ক্রপ করা ইমেজ ডাটা থাকে (Base64)
        if ($request->cropped_image) {
            $image_data = $request->cropped_image;

            // Base64 স্ট্র্রিং থেকে ডাটা আলাদা করা
            // ডাটা ফরম্যাট থাকে: data:image/webp;base64,UklGRmY...
            list($type, $image_data) = explode(';', $image_data);
            list(, $image_data)      = explode(',', $image_data);
            $image_data = base64_decode($image_data);

            // ইউনিক ফাইলের নাম তৈরি (WebP ফরম্যাটে)
            $imageName = 'super_admin_' . time() . '.webp';
            $directory = public_path('uploads/super_admin/');

            // ডিরেক্টরি না থাকলে তৈরি করুন
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // পুরনো ছবি ডিলিট করা (যদি থাকে এবং ডিফল্ট ইমেজ না হয়)
            if (!empty($data->photo) && file_exists($directory . $data->photo)) {
                @unlink($directory . $data->photo);
            }

            // ফাইলটি সার্ভারে সেভ করা
            file_put_contents($directory . $imageName, $image_data);

            // ডাটাবেসে সেভ করার জন্য নাম সেট করা
            $data->photo = $imageName;
        }

        $data->save();

        // সাকসেস মেসেজসহ ব্যাক করা
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
}