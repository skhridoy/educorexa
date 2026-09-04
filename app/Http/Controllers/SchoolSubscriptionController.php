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

        $setting = SiteSetting::first();
        $paymentMode = $setting?->payment_mode ?? 'personal';

        return view('school.admin.subscription-payment', [
            'school' => $school,
            'subscription' => $subscription->load('package'),
            'paymentMode' => $paymentMode,
            'paymentNumbers' => [
                'bKash' => $paymentMode === 'merchant' ? $setting?->bkash_merchant_number : $setting?->bkash_personal_number,
                'Nagad' => $paymentMode === 'merchant' ? $setting?->nagad_merchant_number : $setting?->nagad_personal_number,
            ],
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
            'payment_method' => ['required', Rule::in(['bkash', 'nagad'])],
            'sender_number' => ['required', 'regex:/^01[3-9]\d{8}$/'],
            'payment_reference' => ['required', 'string', 'max:100', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:school_subscriptions,payment_reference'],
            'payment_submitted_at' => ['required', 'date', 'before_or_equal:now'],
        ]);

        $subscription = $school->subscriptions()
            ->whereKey($validated['subscription_id'])
            ->where('status', 'pending')
            ->firstOrFail();

        $subscription->update([
            'payment_method' => $validated['payment_method'],
            'sender_number' => $validated['sender_number'],
            'payment_reference' => strtoupper($validated['payment_reference']),
            'payment_submitted_at' => $validated['payment_submitted_at'],
        ]);

        return redirect()->route('school.pricing', ['tenant' => $school->slug])
            ->with('success', 'Payment details submitted. The Super Admin will verify your transaction.');
    }
}
