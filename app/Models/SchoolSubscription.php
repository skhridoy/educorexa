<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SchoolSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'subscription_package_id',
        'status',
        'amount',
        'currency',
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

        // Return positive days left if future, 0 or negative if today/past
        return (int) ceil(now()->diffInSeconds($expiry, false) / 86400);
    }

    public function isExpiringSoon(int $days = 15): bool
    {
        if (!$this->isEntitled()) {
            return false;
        }

        $remaining = $this->daysRemaining();
        return $remaining !== null && $remaining <= $days && $remaining >= 0;
    }

    public function canRenew(int $days = 15): bool
    {
        if ($this->hasExpired() || $this->status === 'trialing') {
            return true;
        }

        return $this->isExpiringSoon($days);
    }
}
