<?php

namespace App\Http\Controllers;
use App\Notifications\SuperAdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\School;
use App\Mail\SchoolPendingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Models\SubscriptionPackage;
use App\Services\SubscriptionBillingService;

class SchoolRegisterController extends Controller
{
    public function create()
    {
        $packages = \App\Models\SubscriptionPackage::where('is_active', true)->orderBy('price', 'asc')->get();
        return view('auth.school-register', compact('packages'));
    }
    public function store(Request $request)
    {
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
        ]);

        // আমরা ডাটাগুলো ট্রানজাকশনের বাইরে এক্সেস করার জন্য ভেরিয়েবলে রাখছি
        $newSchool = null;

        DB::transaction(function () use ($request, &$newSchool) {

            $appCode = School::generateAppCode();

            $newSchool = School::create([
                'name'   => $request->school_name,
                'slug'   => strtolower($request->slug),
                'app_code' => $appCode,
                'email'  => $request->admin_email,
                'division' => $request->division,
                'district' => $request->district,
                'upazila' => $request->upazila,
                'address' => implode(', ', [
                    $request->address,
                    $request->upazila,
                    $request->district,
                    $request->division,
                ]),
                'status' => 'pending',
                'subscription_package_id' => $request->package_id,
            ]);

            app(SubscriptionBillingService::class)->createPending(
                $newSchool,
                SubscriptionPackage::findOrFail($request->package_id)
            );

            // 2️⃣ Create School Admin User
            $user = User::create([
                'name'      => $request->admin_name,
                'email'     => $request->admin_email,
                'password'  => Hash::make($request->admin_password),
                'role'      => 'school_admin',
                'school_id' => $newSchool->id,
            ]);

            if (method_exists($user, 'assignRole')) {
                $user->assignRole('school_admin');
            }

        });

        $superAdmin = User::where('role', 'super_admin')->first();

        if (!$superAdmin) {
            
            // যদি এটি দেখায়, তবে বুঝবেন আপনার ডাটাবেসে 'super_admin' রোলে কেউ নেই।
            dd("Error: সুপার এডমিন ইউজার পাওয়া যায় নাই! আপনার ডাটাবেসের role কলাম চেক করুন।"); 
        }

        try {
            $details = [
                'message' => "New School Registered: {$newSchool->name}",
                'icon'    => 'home',
                'link'    => route('manage.schools.pending'),
            ];
            $superAdmin->notify(new SuperAdminNotification($details));
        } catch (\Exception $e) {
            dd("Error: " . $e->getMessage());
        }

        try {
            // স্কুলকে পেন্ডিং ধন্যবাদ মেইল পাঠানো
            Mail::to($newSchool->email)->send(new SchoolPendingMail($newSchool));
        } catch (\Exception $e) {
            dd("মেইল এরর মেসেজ: " . $e->getMessage());
            \Log::error("Registration Mail Error: " . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'School registered successful! Waiting for approval. You will receive an email once your school is approved.');
    }

    public function divisions()
    {
        try {
            $filePath = public_path('data' . DIRECTORY_SEPARATOR . 'bangladesh-locations.json');
            
            if (!file_exists($filePath)) {
                return response()->json([
                    'message' => 'লোকেশন ডেটা ফাইল পাওয়া যায়নি।',
                ], 502);
            }
            
            $json = file_get_contents($filePath);
            $data = json_decode($json, true);
            
            if (!$data || !isset($data['divisions'])) {
                return response()->json([
                    'message' => 'লোকেশন ডেটা লোড করা যায়নি।',
                ], 502);
            }

            $divisions = collect($data['divisions'])->map(function ($division) {
                return [
                    'name' => $division['name'],
                    'name_bn' => $division['name_bn'] ?? $division['name'],
                ];
            })->values();

            return response()->json($divisions);
        } catch (\Exception $e) {
            \Log::error('Division loading error: ' . $e->getMessage());
            return response()->json([
                'message' => 'লোকেশন ডেটা লোড করা যায়নি।',
            ], 502);
        }
    }

    public function districts(string $division)
    {
        try {
            $filePath = public_path('data' . DIRECTORY_SEPARATOR . 'bangladesh-locations.json');
            
            if (!file_exists($filePath)) {
                return response()->json([
                    'message' => 'ডিস্ট্রিক্ট ডেটা ফাইল পাওয়া যায়নি।',
                ], 502);
            }
            
            $json = file_get_contents($filePath);
            $data = json_decode($json, true);
            
            if (!$data || !isset($data['divisions'])) {
                return response()->json([
                    'message' => 'ডিস্ট্রিক্ট ডেটা লোড করা যায়নি।',
                ], 502);
            }

            $divisionData = collect($data['divisions'])->first(function ($d) use ($division) {
                return $d['name'] === $division || ($d['name_bn'] ?? '') === $division;
            });

            if (!$divisionData || !isset($divisionData['districts'])) {
                return response()->json([]);
            }

            $districts = collect($divisionData['districts'])->map(function ($district) {
                return [
                    'name' => $district['name'],
                    'name_bn' => $district['name_bn'] ?? $district['name'],
                ];
            })->values();

            return response()->json($districts);
        } catch (\Exception $e) {
            \Log::error('District loading error: ' . $e->getMessage());
            return response()->json([
                'message' => 'ডিস্ট্রিক্ট ডেটা লোড করা যায়নি।',
            ], 502);
        }
    }

    public function upazilas(string $district)
    {
        try {
            $filePath = public_path('data' . DIRECTORY_SEPARATOR . 'bangladesh-locations.json');
            
            if (!file_exists($filePath)) {
                return response()->json([
                    'message' => 'উপজেলা ডেটা ফাইল পাওয়া যায়নি।',
                ], 502);
            }
            
            $json = file_get_contents($filePath);
            $data = json_decode($json, true);
            
            if (!$data || !isset($data['divisions'])) {
                return response()->json([
                    'message' => 'উপজেলা ডেটা লোড করা যায়নি।',
                ], 502);
            }

            $upazilas = [];
            foreach ($data['divisions'] as $division) {
                foreach ($division['districts'] as $dist) {
                    if (($dist['name'] === $district || ($dist['name_bn'] ?? '') === $district) && isset($dist['upazilas'])) {
                        $upazilas = collect($dist['upazilas'])->map(function ($upazila) {
                            return [
                                'name' => $upazila['name'],
                                'name_bn' => $upazila['name_bn'] ?? $upazila['name'],
                            ];
                        })->values()->toArray();
                        break 2;
                    }
                }
            }

            return response()->json($upazilas);
        } catch (\Exception $e) {
            \Log::error('Upazila loading error: ' . $e->getMessage());
            return response()->json([
                'message' => 'উপজেলা ডেটা লোড করা যায়নি।',
            ], 502);
        }
    }

    // ১. এডিট পেজ দেখানোর জন্য (GET Method)
    public function edit()
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);
        return view('school.setting.school_info', compact('school'));
    }

    // ২. ডাটা আপডেট করার জন্য (POST/PUT Method)
    public function update(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);

        $request->validate([
            'name'    => 'required|string|max:255',
            'division' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            'logo'    => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            // 'image' রুলটি অনেক সময় ICO বা কিছু বিশেষ PNG-তে ঝামেলা করে, তাই শুধু mimes ব্যবহার করা নিরাপদ
            'favicon' => 'nullable|mimes:png,ico,jpg,jpeg|max:1024', 
        ]);

        $school->name = $request->name;
        $school->email = $request->email;
        $school->phone = $request->phone;
        $school->ein_number = $request->ein_number;
        $school->emis_code = $request->emis_code;
        $school->division = $request->division;
        $school->district = $request->district;
        $school->upazila = $request->upazila;
        if ($request->filled('app_code')) {
            $school->app_code = $request->app_code;
        }
        $school->address = $request->address;

        $tenantSlug = $school->slug;
        $basePath = "uploads/schools/{$tenantSlug}";

        // লোগো হ্যান্ডেলিং
        if ($request->hasFile('logo')) {
            $logoPath = public_path($basePath . '/logo');
            if (!file_exists($logoPath)) mkdir($logoPath, 0755, true);

            if ($school->logo && file_exists(public_path($school->logo))) {
                unlink(public_path($school->logo));
            }

            $logoFile = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move($logoPath, $logoName);
            $school->logo = $basePath . '/logo/' . $logoName;
        }

        // ফেভিকন হ্যান্ডেলিং
        if ($request->hasFile('favicon')) {
            $favPath = public_path($basePath . '/favicon');
            // ফোল্ডার তৈরি নিশ্চিত করা
            if (!file_exists($favPath)) mkdir($favPath, 0755, true);

            if ($school->favicon && file_exists(public_path($school->favicon))) {
                @unlink(public_path($school->favicon));
            }

            $favFile = $request->file('favicon');
            $favName = 'fav_' . time() . '.' . $favFile->getClientOriginalExtension();
            
            // ফাইল মুভ করা
            if ($favFile->move($favPath, $favName)) {
                $school->favicon = $basePath . '/favicon/' . $favName;
            }
        }
        
        $school->save();

        return back()->with('success', 'আপনার স্কুলের তথ্য সফলভাবে আপডেট হয়েছে!');
    }

}
