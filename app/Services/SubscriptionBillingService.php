<?php

namespace App\Services;

use App\Models\School;
use App\Models\SchoolSubscription;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionBillingService
{
    /**
     * Create or reuse a pending subscription record with calculated amount and billing period.
     */
    public function createPending(
        School $school,
        SubscriptionPackage $package,
        string $billingPeriod = 'monthly',
        ?string $paymentType = null
    ): SchoolSubscription {
        return DB::transaction(function () use ($school, $package, $billingPeriod, $paymentType) {
            // Determine duration months and validity
            if ($package->isFreePackage()) {
                $durationMonths = $package->getFreeValidityMonths();
                $actualPeriod = ($durationMonths === 6) ? 'free_6_months' : 'free_1_year';
                $amount = (float) ($package->service_fee ?? 0.0);
                $type = $paymentType ?: SchoolSubscription::TYPE_SERVICE_FEE;
            } else {
                $validPeriods = $package->getBillingPeriods();
                $actualPeriod = in_array($billingPeriod, $validPeriods, true) ? $billingPeriod : 'monthly';
                $durationMonths = SubscriptionPackage::getDurationMonthsForPeriod($actualPeriod);
                $amount = $package->calculatePriceForPeriod($actualPeriod);

                if (!$paymentType) {
                    if ((int) $school->subscription_package_id === (int) $package->id) {
                        $type = $school->activeSubscription() ? SchoolSubscription::TYPE_EXTENSION : SchoolSubscription::TYPE_RENEWAL;
                    } elseif ($package->getRank() > $school->currentPackageRank()) {
                        $type = SchoolSubscription::TYPE_UPGRADE;
                    } else {
                        $type = SchoolSubscription::TYPE_PURCHASE;
                    }
                } else {
                    $type = $paymentType;
                }
            }

            // Check if there is already an unsubmitted pending subscription for this school
            $existingPending = $school->subscriptions()
                ->where('status', 'pending')
                ->whereNull('payment_reference')
                ->latest('id')
                ->first();

            if ($existingPending) {
                $existingPending->update([
                    'subscription_package_id' => $package->id,
                    'amount' => $amount,
                    'currency' => 'BDT',
                    'billing_period' => $actualPeriod,
                    'duration_months' => $durationMonths,
                    'payment_type' => $type,
                ]);

                return $existingPending->fresh();
            }

            return $school->subscriptions()->create([
                'subscription_package_id' => $package->id,
                'status' => 'pending',
                'amount' => $amount,
                'currency' => 'BDT',
                'billing_period' => $actualPeriod,
                'duration_months' => $durationMonths,
                'payment_type' => $type,
            ]);
        });
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
        return $school->activeSubscription();
    }

    /**
     * Mark a subscription as paid and active with calendar-aware expiry calculation.
     */
    public function markPaid(SchoolSubscription $subscription, string $reference): SchoolSubscription
    {
        return DB::transaction(function () use ($subscription, $reference) {
            $package = $subscription->package;
            $durationMonths = $subscription->getEffectiveDurationMonths();
            $startsAt = now();

            // Check if school currently has an active subscription of the SAME package that hasn't expired yet
            $currentActive = $subscription->school->subscriptions()
                ->where('status', 'active')
                ->where('id', '!=', $subscription->id)
                ->whereNotNull('ends_at')
                ->where('ends_at', '>', now())
                ->latest('ends_at')
                ->first();

            $isSamePackageRenewal = ($currentActive && (int) $currentActive->subscription_package_id === (int) $subscription->subscription_package_id);

            // Requirement 10: Renewal before expiry extends from existing expiry date
            if ($isSamePackageRenewal && $currentActive->ends_at && $currentActive->ends_at->isFuture()) {
                $baseDate = $currentActive->ends_at;
                $endsAt = $baseDate->copy()->addMonthsNoOverflow($durationMonths);
                // Retain original starts_at or start from now
                $effectiveStartsAt = $currentActive->starts_at ?? $startsAt;
            } else {
                // New purchase, upgrade, or renewal of expired subscription starts from activation date
                $effectiveStartsAt = $startsAt;
                $endsAt = $startsAt->copy()->addMonthsNoOverflow($durationMonths);
            }

            // Expire older active subscriptions if any
            $subscription->school->subscriptions()
                ->where('status', 'active')
                ->where('id', '!=', $subscription->id)
                ->update(['status' => 'expired']);

            $amount = $subscription->amount > 0 ? $subscription->amount : ($package?->calculatePriceForPeriod($subscription->billing_period ?? 'monthly') ?? 0);

            $subscription->update([
                'status' => 'active',
                'amount' => $amount,
                'starts_at' => $effectiveStartsAt,
                'ends_at' => $endsAt,
                'trial_ends_at' => null,
                'paid_at' => now(),
                'payment_reference' => $reference,
                'reviewed_by' => auth()->check() ? auth()->id() : $subscription->reviewed_by,
                'reviewed_at' => now(),
            ]);

            // Update school's active package pointer
            $subscription->school->update([
                'subscription_package_id' => $subscription->subscription_package_id,
            ]);

            return $subscription->fresh();
        });
    }

    /**
     * Activate a free (service_fee = 0) package without payment.
     * Creates a subscription record and marks it active immediately for configured validity (6m or 1y).
     */
    public function activateFree(School $school, SubscriptionPackage $package): SchoolSubscription
    {
        return DB::transaction(function () use ($school, $package) {
            $validityMonths = $package->getFreeValidityMonths(); // 6 or 12
            $periodSlug = ($validityMonths === 6) ? 'free_6_months' : 'free_1_year';
            $startsAt = now();
            $endsAt = $startsAt->copy()->addMonthsNoOverflow($validityMonths);

            // Expire any existing active subscriptions
            $school->subscriptions()
                ->whereIn('status', ['active', 'trialing'])
                ->update(['status' => 'expired']);

            $subscription = $school->subscriptions()->create([
                'subscription_package_id' => $package->id,
                'status' => 'active',
                'amount' => 0.00,
                'currency' => 'BDT',
                'billing_period' => $periodSlug,
                'duration_months' => $validityMonths,
                'payment_type' => SchoolSubscription::TYPE_SERVICE_FEE,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'paid_at' => $startsAt,
                'payment_reference' => 'FREE-' . strtoupper(uniqid()),
            ]);

            $school->update([
                'subscription_package_id' => $package->id,
            ]);

            return $subscription->fresh();
        });
    }
}
