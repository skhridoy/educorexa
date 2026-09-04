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
}
