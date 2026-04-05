<?php 

namespace App\Http\Controllers\superadmin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    return redirect()->route('super.schools.all')->with('success', 'School Approved & Full Permissions Assigned!');
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

        $school->delete();
        $school->users()->delete(); // Delete associated users

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
        $mainDomain = config('app.main_domain', 'schoolerp.test');
        $request->validate([
            'school_name'     => 'required|string|max:255',
            'slug'            => 'required|alpha_num|unique:schools,slug',
            'admin_name'      => 'required|string|max:255',
            'admin_email'     => 'required|email|unique:users,email',
            'admin_mobile'    => [
                'required',
                'regex:/^01[0-9]{9}$/'
            ],
            'admin_password'  => 'required|min:8',
        ]);

        DB::transaction(function () use ($request) {

            // 1️⃣ Create School
            $school = School::create([
                'name'   => $request->school_name,
                'slug'   => strtolower($request->slug),
                'email'  => $request->admin_email,
                'phone' => $request->admin_mobile,
                'status' => 'approved',
                'is_active' => true,
            ]);

            // 2️⃣ Create School Admin User
            User::create([
                'name'      => $request->admin_name,
                'email'     => $request->admin_email,
                'password'  => Hash::make($request->admin_password),
                'role'      => 'school_admin',
                'school_id' => $school->id, // relation correct
            ]);

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

                // ৫. গুরুত্বপূর্ণ: রোলে পারমিশন সিঙ্ক করা
                $role->syncPermissions($permissions);

                // ৬. ইউজারকে রোল দেওয়া (যদি ইতিমধ্যে না থাকে)
                if (!$adminUser->hasRole('school_admin')) {
                    $adminUser->assignRole($role);
                }

                // ৭. সবচেয়ে গুরুত্বপূর্ণ: Spatie এর ইন্টারনাল ক্যাশ ক্লিয়ার করা
                app()[PermissionRegistrar::class]->forgetCachedPermissions();
            }

        });
        return view('super.schools.create', compact('mainDomain'))
            ->with('success', 'School registered successfully! This school is approved automatically.');
    }
    public function Profile() {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        
        return view('super.profile.profile', compact('profileData'));
    }

    public function ProfileStore(Request $request) {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            
            // ১. আগের ফটো ডিলিট করার আগে চেক করা যে সেটি ডাটাবেসে আছে কি না
            if ($data->photo && file_exists(public_path('upload/super_images/' . $data->photo))) {
                @unlink(public_path('upload/super_images/' . $data->photo));
            }

            // ২. ফাইলের নামে স্পেস থাকলে সেটি রিমুভ করা (এরর এড়াতে)
            $filename = date('YmdHi') . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // ৩. ফোল্ডারটি না থাকলে অটোমেটিক তৈরি করার লজিক
            $destPath = public_path('upload/super_images');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0777, true);
            }

            // ৪. ফাইল মুভ করা
            $file->move($destPath, $filename);
            
            // ৫. ডাটাবেস অবজেক্টে সেভ করা
            $data->photo = $filename; 
        }

        $data->save();
        
        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }
}