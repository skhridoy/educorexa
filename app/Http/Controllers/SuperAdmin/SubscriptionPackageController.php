<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class SubscriptionPackageController extends Controller
{
    public function index()
    {
        $packages = SubscriptionPackage::latest()->get();
        return view('super.subscription_packages.index', compact('packages'));
    }

    public function create()
    {
        return view('super.subscription_packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|in:monthly,yearly',
            'student_limit' => 'nullable|integer|min:0',
            'teacher_limit' => 'nullable|integer|min:0',
            'features_list' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');

        // Parse features_list to features array
        $features = [];
        if (!empty($validated['features_list'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['features_list']));
            $features = array_values(array_filter(array_map('trim', $lines)));
        }
        // Define default basic permissions that every school should have
        $defaultPermissions = [
            'system.settings',
            'notice.manage',
            'academic-year.manage',
            'profile.manage',
            'student.index',
            'student.create',
            'student.edit',
            'student.delete',
            'student.manage', 
        ];

        $validated['features'] = $features;
        $validated['permissions'] = array_unique(array_merge($request->permissions ?? [], $defaultPermissions));
        unset($validated['features_list']);

        SubscriptionPackage::create($validated);

        return redirect()->route('super.subscription-packages.index')
            ->with('success', 'Subscription package created successfully.');
    }

    public function edit(SubscriptionPackage $subscriptionPackage)
    {
        return view('super.subscription_packages.edit', compact('subscriptionPackage'));
    }

    public function update(Request $request, SubscriptionPackage $subscriptionPackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|in:monthly,yearly',
            'student_limit' => 'nullable|integer|min:0',
            'teacher_limit' => 'nullable|integer|min:0',
            'features_list' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');

        // Parse features_list to features array
        $features = [];
        if (!empty($validated['features_list'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['features_list']));
            $features = array_values(array_filter(array_map('trim', $lines)));
        }
        // Define default basic permissions that every school should have
        $defaultPermissions = [
            'system.settings',
            'notice.manage',
            'academic-year.manage',
            'profile.manage',
            'student.index',
            'student.create',
            'student.edit',
            'student.delete',
            'student.manage',
        ];

        $validated['features'] = $features;
        $validated['permissions'] = array_unique(array_merge($request->permissions ?? [], $defaultPermissions));
        unset($validated['features_list']);

        $subscriptionPackage->update($validated);

        return redirect()->route('super.subscription-packages.index')
            ->with('success', 'Subscription package updated successfully.');
    }

    public function destroy(SubscriptionPackage $subscriptionPackage)
    {
        $subscriptionPackage->delete();
        return redirect()->route('super.subscription-packages.index')
            ->with('success', 'Subscription package deleted successfully.');
    }
}
