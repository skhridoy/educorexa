<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order',
        'description',
        'price',
        'is_free',
        'service_fee',
        'free_validity_period',
        'available_billing_periods',
        'billing_discounts',
        'registration_commission_type',
        'registration_commission_rate',
        'monthly_commission_type',
        'monthly_commission_rate',
        'duration',
        'student_limit',
        'teacher_limit',
        'features',
        'permissions',
        'custom_domain_included',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'service_fee' => 'decimal:2',
        'available_billing_periods' => 'array',
        'billing_discounts' => 'array',
        'registration_commission_rate' => 'decimal:2',
        'monthly_commission_rate' => 'decimal:2',
        'features' => 'array',
        'permissions' => 'array',
        'custom_domain_included' => 'boolean',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get numeric rank/tier for hierarchy comparisons.
     */
    public function getRank(): int
    {
        if ($this->sort_order > 0) {
            return (int) $this->sort_order;
        }

        if ($this->isFreePackage()) {
            return 1;
        }

        return (int) round(((float) $this->price) * 100) + 10;
    }

    /**
     * Check if package is the highest available active tier.
     */
    public function isHighest(): bool
    {
        $allActive = static::where('is_active', true)->get();
        if ($allActive->isEmpty()) {
            return true;
        }

        $maxRank = $allActive->map(fn($p) => $p->getRank())->max();
        return $this->getRank() >= $maxRank;
    }

    /**
     * Check if this is a Free package.
     */
    public function isFreePackage(): bool
    {
        return (bool) $this->is_free || (float) $this->price <= 0.0;
    }

    /**
     * Get Free validity period in months (6 or 12).
     */
    public function getFreeValidityMonths(): int
    {
        return ($this->free_validity_period === '6_months') ? 6 : 12;
    }

    /**
     * Get the configured discount percentage for a billing period (0 if none).
     */
    public function getDiscountForPeriod(string $period): float
    {
        $discounts = $this->billing_discounts ?? [];
        return (float) ($discounts[$period] ?? 0.0);
    }

    /**
     * Get original (un-discounted) total price for a billing period.
     */
    public function getOriginalPriceForPeriod(string $period): float
    {
        if ($this->isFreePackage()) {
            return (float) ($this->service_fee ?? 0.0);
        }

        $multiplier = match ($period) {
            'monthly' => 1,
            'quarterly' => 3,
            'half_yearly' => 6,
            'yearly' => 12,
            default => 1,
        };

        return (float) ($this->price * $multiplier);
    }

    /**
     * Calculate price for a selected billing period (with discount applied).
     */
    public function calculatePriceForPeriod(string $period): float
    {
        if ($this->isFreePackage()) {
            return (float) ($this->service_fee ?? 0.0);
        }

        $original = $this->getOriginalPriceForPeriod($period);
        $discountPct = $this->getDiscountForPeriod($period);

        if ($discountPct > 0.0) {
            return round($original * (1 - $discountPct / 100), 2);
        }

        return $original;
    }

    /**
     * Map period slug to integer duration in months.
     */
    public static function getDurationMonthsForPeriod(string $period): int
    {
        return match ($period) {
            'monthly' => 1,
            'quarterly' => 3,
            'half_yearly', 'free_6_months' => 6,
            'yearly', 'free_1_year' => 12,
            default => 1,
        };
    }

    /**
     * Get available billing periods list.
     */
    public function getBillingPeriods(): array
    {
        if ($this->isFreePackage()) {
            return [$this->free_validity_period ?: '1_year'];
        }

        $periods = $this->available_billing_periods;
        if (is_array($periods) && !empty($periods)) {
            return $periods;
        }

        return ['monthly', 'quarterly', 'half_yearly', 'yearly'];
    }
}
