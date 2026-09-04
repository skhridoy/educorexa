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
        $package = $subscription->package;
        $days = ($package && $package->duration === 'yearly') ? 365 : 30;

        // Check if school currently has an active subscription that hasn't expired yet
        $currentActive = $subscription->school->subscriptions()
            ->where('status', 'active')
            ->where('id', '!=', $subscription->id)
            ->whereNotNull('ends_at')
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();

        $startsAt = now();
        $baseDate = ($currentActive && $currentActive->ends_at && $currentActive->ends_at->isFuture())
            ? $currentActive->ends_at
            : $startsAt;

        $endsAt = $baseDate->copy()->addDays($days);

        // Expire older active subscriptions if any
        if ($currentActive) {
            $subscription->school->subscriptions()
                ->where('status', 'active')
                ->where('id', '!=', $subscription->id)
                ->update(['status' => 'expired']);
        }

        $amount = $subscription->amount > 0 ? $subscription->amount : ($package?->price ?? 0);

        $subscription->update([
            'status' => 'active',
            'amount' => $amount,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'trial_ends_at' => null,
            'paid_at' => $startsAt,
            'payment_reference' => $reference,
            'reviewed_by' => auth()->check() ? auth()->id() : $subscription->reviewed_by,
            'reviewed_at' => now(),
        ]);

        $subscription->school->update([
            'subscription_package_id' => $subscription->subscription_package_id,
        ]);

        return $subscription->fresh();
    }
}
