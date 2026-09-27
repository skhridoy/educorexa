<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SchoolSubscription extends Model
{
    use HasFactory;

    // Payment Type Constants
    public const TYPE_SERVICE_FEE         = 'service_fee';
    public const TYPE_PURCHASE            = 'subscription_purchase';
    public const TYPE_RENEWAL             = 'subscription_renewal';
    public const TYPE_EXTENSION           = 'subscription_extension';
    public const TYPE_UPGRADE             = 'upgrade';

    protected $fillable = [
        'school_id',
        'subscription_package_id',
        'status',
        'amount',
        'currency',
        'billing_period',
        'duration_months',
        'payment_type',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'paid_at',
        'payment_reference',
        'payment_method',
        'sender_number',
        'payment_submitted_at',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'duration_months' => 'integer',
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'paid_at' => 'datetime',
        'payment_submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function package()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_package_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isEntitled(): bool
    {
        if (!in_array($this->status, ['trialing', 'active'], true)) {
            return false;
        }

        $expiry = $this->status === 'trialing' ? $this->trial_ends_at : $this->ends_at;

        return !$expiry || $expiry->isFuture();
    }

    public function hasExpired(): bool
    {
        $expiry = $this->status === 'trialing' ? $this->trial_ends_at : $this->ends_at;

        return $expiry instanceof Carbon && $expiry->isPast();
    }

    public function getExpiryDate(): ?Carbon
    {
        return $this->status === 'trialing' ? $this->trial_ends_at : $this->ends_at;
    }

    public function daysRemaining(): ?int
    {
        $expiry = $this->getExpiryDate();
        if (!$expiry) {
            return null;
        }

        // Return positive days left if future, 0 if today, negative if past
        return (int) ceil(now()->diffInSeconds($expiry, false) / 86400);
    }

    /**
     * Get alert window threshold days according to billing period.
     * Monthly = 7 days
     * Quarterly = 14 days
     * Half-Yearly = 30 days (1 month)
     * Yearly = 30 days (1 month)
     * Free (6m) = 14 days
     * Free (1y) = 30 days
     */
    public function getAlertThresholdDays(): int
    {
        $period = $this->billing_period ?: ($this->package?->duration ?? 'monthly');

        return match ($period) {
            'monthly' => 7,
            'quarterly' => 14,
            'half_yearly' => 30,
            'yearly' => 30,
            'free_6_months' => 14,
            'free_1_year' => 30,
            default => 15,
        };
    }

    /**
     * Check if subscription is within the billing-period-aware alert period.
     * Monthly: 7 days
     * Quarterly: 14 days
     * Half-Yearly: 1 month before expiry
     * Yearly: 1 month before expiry
     */
    public function isExpiringSoon(?int $customDays = null): bool
    {
        if (!$this->isEntitled()) {
            return false;
        }

        $expiry = $this->getExpiryDate();
        if (!$expiry) {
            return false;
        }

        $period = $this->billing_period ?: ($this->package?->duration ?? 'monthly');

        // Calendar-aware 1 month for half-yearly, yearly, and free 1-year
        if ($customDays === null && in_array($period, ['half_yearly', 'yearly', 'free_1_year'], true)) {
            $alertStart = $expiry->copy()->subMonthNoOverflow();
            return now()->gte($alertStart) && now()->lte($expiry);
        }

        $thresholdDays = $customDays ?? $this->getAlertThresholdDays();
        $remaining = $this->daysRemaining();

        return $remaining !== null && $remaining <= $thresholdDays && $remaining >= 0;
    }

    public function canRenew(?int $days = null): bool
    {
        if ($this->hasExpired() || $this->status === 'trialing') {
            return true;
        }

        return $this->isExpiringSoon($days);
    }

    public function getEffectiveDurationMonths(): int
    {
        if ($this->duration_months && $this->duration_months > 0) {
            return (int) $this->duration_months;
        }

        if ($this->billing_period) {
            return SubscriptionPackage::getDurationMonthsForPeriod($this->billing_period);
        }

        if ($this->package) {
            if ($this->package->isFreePackage()) {
                return $this->package->getFreeValidityMonths();
            }
            return ($this->package->duration === 'yearly') ? 12 : 1;
        }

        return 1;
    }

    public function getPaymentTypeLabelAttribute(): string
    {
        return match ($this->payment_type) {
            self::TYPE_SERVICE_FEE => 'One-Time Service Fee',
            self::TYPE_PURCHASE => 'Subscription Purchase',
            self::TYPE_RENEWAL => 'Subscription Renewal',
            self::TYPE_EXTENSION => 'Subscription Extension',
            self::TYPE_UPGRADE => 'Upgrade',
            default => 'Subscription Payment',
        };
    }

    public function getBillingPeriodLabelAttribute(): string
    {
        return match ($this->billing_period) {
            'monthly' => 'Monthly (1 Month)',
            'quarterly' => 'Quarterly (3 Months)',
            'half_yearly' => 'Half-Yearly (6 Months)',
            'yearly' => 'Yearly (12 Months)',
            'free_6_months' => '6 Months',
            'free_1_year' => '1 Year',
            default => ucfirst($this->billing_period ?? $this->package?->duration ?? 'monthly'),
        };
    }
}
