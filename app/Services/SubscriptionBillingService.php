<?php

namespace App\Services;

use App\Models\School;
use App\Models\SchoolSubscription;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Carbon;

class SubscriptionBillingService
{
    public function createPending(School $school, SubscriptionPackage $package): SchoolSubscription
    {
        return $school->subscriptions()->create([
            'subscription_package_id' => $package->id,
            'status' => 'pending',
            'amount' => $package->price,
            'currency' => 'BDT',
        ]);
    }

    public function startTrial(School $school, ?SchoolSubscription $subscription = null): SchoolSubscription
    {
        $subscription ??= $school->subscriptions()->latest()->first();

        if (!$subscription) {
            $package = $school->subscriptionPackage;
            if (!$package) {
                throw new \RuntimeException('A package is required before starting a trial.');
            }
            $subscription = $this->createPending($school, $package);
        }

        $startsAt = now();
        $subscription->update([
            'status' => 'trialing',
            'starts_at' => $startsAt,
            'trial_ends_at' => $startsAt->copy()->addDays(7),
            'ends_at' => null,
        ]);

        return $subscription->fresh();
    }

    public function activeSubscription(School $school): ?SchoolSubscription
    {
        $subscription = $school->subscriptions()
            ->whereIn('status', ['trialing', 'active'])
            ->latest('id')
            ->first();

        if ($subscription && !$subscription->isEntitled()) {
            $subscription->update(['status' => 'expired']);
            return null;
        }

        return $subscription;
    }

    public function markPaid(SchoolSubscription $subscription, string $reference): SchoolSubscription
    {
        $startsAt = now();
        $days = $subscription->package->duration === 'yearly' ? 365 : 30;

        $subscription->update([
            'status' => 'active',
            'starts_at' => $startsAt,
            'ends_at' => $startsAt->copy()->addDays($days),
            'trial_ends_at' => null,
            'paid_at' => $startsAt,
            'payment_reference' => $reference,
        ]);

        $subscription->school->update([
            'subscription_package_id' => $subscription->subscription_package_id,
        ]);

        return $subscription->fresh();
    }
}
