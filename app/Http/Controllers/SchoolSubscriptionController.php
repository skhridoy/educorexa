<?php

namespace App\Http\Controllers;

use App\Models\SchoolSubscription;
use App\Models\SubscriptionPackage;
use App\Models\SiteSetting;
use App\Services\SubscriptionBillingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolSubscriptionController extends Controller
{
    public function create()
    {
        $school = app('currentSchool');
        $subscription = $school->subscriptions()
            ->where('status', 'pending')
            ->latest('id')
            ->first();

        if (!$subscription) {
            $package = $school->subscriptionPackage;
            abort_unless($package, 404, 'No subscription package selected.');
            $subscription = app(SubscriptionBillingService::class)->createPending($school, $package);
        }

        $subscription->load('package');
        $package = $subscription->package;
        abort_unless($package && $package->is_active, 404, 'Package is inactive or not found.');

        $setting = SiteSetting::first();
        $paymentMode = $setting?->payment_mode ?? 'personal';

        // Calculation of dates and renewal context
        $currentActive = $school->activeSubscription();
        $isRenewal = ($currentActive && (int) $currentActive->subscription_package_id === (int) $package->id);
        $baseDate = ($isRenewal && $currentActive->ends_at && $currentActive->ends_at->isFuture())
            ? $currentActive->ends_at
            : now();

        $actionType = match (true) {
            $package->isFreePackage() => 'One-Time Service Fee',
            $isRenewal && $currentActive->ends_at && $currentActive->ends_at->isFuture() => 'Subscription Extension',
            $isRenewal => 'Subscription Renewal',
            $package->getRank() > $school->currentPackageRank() => 'Package Upgrade',
            default => 'Subscription Purchase',
        };

        return view('school.admin.subscription-payment', [
            'school' => $school,
            'subscription' => $subscription,
            'package' => $package,
            'paymentMode' => $paymentMode,
            'paymentNumbers' => [
                'bKash' => $paymentMode === 'merchant' ? $setting?->bkash_merchant_number : $setting?->bkash_personal_number,
                'Nagad' => $paymentMode === 'merchant' ? $setting?->nagad_merchant_number : $setting?->nagad_personal_number,
            ],
            'baseDate' => $baseDate,
            'actionType' => $actionType,
        ]);
    }

    public function store(Request $request)
    {
        $school = app('currentSchool');
        $validated = $request->validate([
            'subscription_id' => [
                'required',
                Rule::exists('school_subscriptions', 'id')->where('school_id', $school->id)->where('status', 'pending'),
            ],
            'billing_period' => ['nullable', 'string', 'in:monthly,quarterly,half_yearly,yearly,free_6_months,free_1_year'],
            'payment_method' => ['required', Rule::in(['bkash', 'nagad'])],
            'sender_number' => ['required', 'regex:/^01[3-9]\d{8}$/'],
            'payment_reference' => ['required', 'string', 'max:100', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:school_subscriptions,payment_reference'],
            'payment_submitted_at' => ['required', 'date', 'before_or_equal:now'],
        ]);

        $subscription = $school->subscriptions()
            ->whereKey($validated['subscription_id'])
            ->where('status', 'pending')
            ->firstOrFail();

        $package = $subscription->package;
        abort_unless($package && $package->is_active, 403, 'Selected package is not active.');

        // Strict Server-Side Recalculation (Never trust browser amount)
        if ($package->isFreePackage()) {
            $period = $package->free_validity_period ?: '1_year';
            $durationMonths = $package->getFreeValidityMonths();
            $amount = (float) ($package->service_fee ?? 0.0);
            $paymentType = SchoolSubscription::TYPE_SERVICE_FEE;
        } else {
            $period = $validated['billing_period'] ?? ($subscription->billing_period ?: 'monthly');
            $validPeriods = $package->getBillingPeriods();
            if (!in_array($period, $validPeriods, true)) {
                $period = 'monthly';
            }
            $durationMonths = SubscriptionPackage::getDurationMonthsForPeriod($period);
            $amount = $package->calculatePriceForPeriod($period);

            if ((int) $school->subscription_package_id === (int) $package->id) {
                $currentActive = $school->activeSubscription();
                $paymentType = ($currentActive && $currentActive->ends_at && $currentActive->ends_at->isFuture())
                    ? SchoolSubscription::TYPE_EXTENSION
                    : SchoolSubscription::TYPE_RENEWAL;
            } elseif ($package->getRank() > $school->currentPackageRank()) {
                $paymentType = SchoolSubscription::TYPE_UPGRADE;
            } else {
                $paymentType = SchoolSubscription::TYPE_PURCHASE;
            }
        }

        $subscription->update([
            'amount' => $amount,
            'billing_period' => $period,
            'duration_months' => $durationMonths,
            'payment_type' => $paymentType,
            'payment_method' => $validated['payment_method'],
            'sender_number' => $validated['sender_number'],
            'payment_reference' => strtoupper($validated['payment_reference']),
            'payment_submitted_at' => $validated['payment_submitted_at'],
        ]);

        // Send notification to Super Admins
        try {
            $superAdmins = \App\Models\User::whereHas('roles', function ($q) {
                $q->where('name', 'super_admin');
            })->orWhere('role', 'super_admin')->get();

            $periodLabel = $package->isFreePackage() ? ($durationMonths . ' Months') : ucfirst($period);
            foreach ($superAdmins as $admin) {
                $admin->notify(new \App\Notifications\SuperAdminNotification([
                    'message' => "নতুন সাবস্ক্রিপশন পেমেন্ট: {$school->name} (৳ " . number_format($subscription->amount) . " [{$periodLabel}] via " . strtoupper($validated['payment_method']) . ")",
                    'icon'    => 'credit-card',
                    'link'    => route('super.subscription-payments.index'),
                ]));
            }
        } catch (\Exception $notifEx) {
            \Log::error("Payment notification error: " . $notifEx->getMessage());
        }

        return redirect()->route('school.pricing', ['tenant' => $school->slug])
            ->with('success', 'Payment details submitted. The Super Admin will verify your transaction.');
    }
}
