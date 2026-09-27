<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class SubscriptionPackageController extends Controller
{
    public function index()
    {
        $packages = SubscriptionPackage::orderBy('sort_order', 'asc')
            ->orderBy('price', 'asc')
            ->get();
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
            'sort_order' => 'nullable|integer|min:0',
            'is_free' => 'nullable|boolean',
            'service_fee' => 'nullable|numeric|min:0',
            'free_validity_period' => 'nullable|string|in:6_months,1_year',
            'available_billing_periods' => 'nullable|array',
            'available_billing_periods.*' => 'string|in:monthly,quarterly,half_yearly,yearly',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'registration_commission_type' => 'nullable|in:flat,percentage',
            'registration_commission_rate' => 'nullable|numeric|min:0',
            'monthly_commission_type' => 'nullable|in:flat,percentage',
            'monthly_commission_rate' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|in:monthly,yearly',
            'student_limit' => 'nullable|integer|min:0',
            'teacher_limit' => 'nullable|integer|min:0',
            'features_list' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $isFree = $request->has('is_free') || (float) $request->price <= 0.0;
        $validated['is_free'] = $isFree;
        $validated['sort_order'] = (int) ($request->sort_order ?? 0);
        $validated['service_fee'] = $isFree ? (float) ($request->service_fee ?? 0) : 0.00;
        $validated['free_validity_period'] = $request->free_validity_period ?? '1_year';

        if ($isFree) {
            $validated['duration'] = ($validated['free_validity_period'] === '6_months') ? 'monthly' : 'yearly';
            $validated['available_billing_periods'] = [$validated['free_validity_period']];
            $validated['billing_discounts'] = null;
        } else {
            $validated['duration'] = 'monthly'; // Monthly base price
            $validated['available_billing_periods'] = !empty($request->available_billing_periods)
                ? array_values($request->available_billing_periods)
                : ['monthly', 'quarterly', 'half_yearly', 'yearly'];
            // Parse billing discounts: quarterly, half_yearly, yearly
            $discounts = [];
            foreach (['quarterly' => 3, 'half_yearly' => 6, 'yearly' => 12] as $period => $months) {
                $pct = (float) ($request->input("billing_discounts.$period") ?? 0);
                if ($pct > 0 && $pct <= 100) {
                    $discounts[$period] = $pct;
                }
            }
            $validated['billing_discounts'] = !empty($discounts) ? $discounts : null;
        }

        $validated['registration_commission_type'] = $request->registration_commission_type ?? 'flat';
        $validated['registration_commission_rate'] = $request->registration_commission_rate ?? 0;
        $validated['monthly_commission_type'] = $request->monthly_commission_type ?? 'flat';
        $validated['monthly_commission_rate'] = $request->monthly_commission_rate ?? 0;

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
            'sort_order' => 'nullable|integer|min:0',
            'is_free' => 'nullable|boolean',
            'service_fee' => 'nullable|numeric|min:0',
            'free_validity_period' => 'nullable|string|in:6_months,1_year',
            'available_billing_periods' => 'nullable|array',
            'available_billing_periods.*' => 'string|in:monthly,quarterly,half_yearly,yearly',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'registration_commission_type' => 'nullable|in:flat,percentage',
            'registration_commission_rate' => 'nullable|numeric|min:0',
            'monthly_commission_type' => 'nullable|in:flat,percentage',
            'monthly_commission_rate' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|in:monthly,yearly',
            'student_limit' => 'nullable|integer|min:0',
            'teacher_limit' => 'nullable|integer|min:0',
            'features_list' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $isFree = $request->has('is_free') || (float) $request->price <= 0.0;
        $validated['is_free'] = $isFree;
        $validated['sort_order'] = (int) ($request->sort_order ?? 0);
        $validated['service_fee'] = $isFree ? (float) ($request->service_fee ?? 0) : 0.00;
        $validated['free_validity_period'] = $request->free_validity_period ?? '1_year';

        if ($isFree) {
            $validated['duration'] = ($validated['free_validity_period'] === '6_months') ? 'monthly' : 'yearly';
            $validated['available_billing_periods'] = [$validated['free_validity_period']];
            $validated['billing_discounts'] = null;
        } else {
            $validated['duration'] = 'monthly';
            $validated['available_billing_periods'] = !empty($request->available_billing_periods)
                ? array_values($request->available_billing_periods)
                : ['monthly', 'quarterly', 'half_yearly', 'yearly'];
            // Parse billing discounts: quarterly, half_yearly, yearly
            $discounts = [];
            foreach (['quarterly' => 3, 'half_yearly' => 6, 'yearly' => 12] as $period => $months) {
                $pct = (float) ($request->input("billing_discounts.$period") ?? 0);
                if ($pct > 0 && $pct <= 100) {
                    $discounts[$period] = $pct;
                }
            }
            $validated['billing_discounts'] = !empty($discounts) ? $discounts : null;
        }

        $validated['registration_commission_type'] = $request->registration_commission_type ?? 'flat';
        $validated['registration_commission_rate'] = $request->registration_commission_rate ?? 0;
        $validated['monthly_commission_type'] = $request->monthly_commission_type ?? 'flat';
        $validated['monthly_commission_rate'] = $request->monthly_commission_rate ?? 0;

        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');

        // Parse features_list to features array
        $features = [];
        if (!empty($validated['features_list'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['features_list']));
            $features = array_values(array_filter(array_map('trim', $lines)));
        }

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
