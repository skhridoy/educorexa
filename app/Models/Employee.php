<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $employee_id
 * @property string|null $designation
 * @property string|null $phone_personal
 * @property string|null $address
 * @property string|null $joining_date
 * @property numeric $salary
 * @property string $commission_type (flat|percentage)
 * @property numeric $commission_rate
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class Employee extends Model
{
    protected $fillable = [
        'user_id', 'employee_id', 'designation', 
        'phone_personal', 'address', 'joining_date', 
        'salary', 'status',
        'commission_type', 'commission_rate', // কমিশন ফিল্ড
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * এই representative যে সব স্কুল নিবন্ধন করেছেন
     */
    public function registeredSchools()
    {
        return $this->hasMany(School::class, 'representative_id');
    }

    /**
     * প্রতিটি স্কুলের paid subscription থেকে মোট কমিশন হিসাব করা
     */
    public function calculateTotalCommission(): float
    {
        $schools = $this->registeredSchools()->with(['subscriptions' => function($q) {
            $q->where('status', 'active')->whereNotNull('paid_at');
        }])->get();

        $total = 0;

        foreach ($schools as $school) {
            foreach ($school->subscriptions as $subscription) {
                if ($this->commission_type === 'percentage') {
                    $total += ($subscription->amount * $this->commission_rate) / 100;
                } else {
                    // flat: প্রতি অ্যাক্টিভ সাবস্ক্রিপশনে নির্দিষ্ট পরিমাণ
                    $total += $this->commission_rate;
                }
            }
        }

        return $total;
    }

    /**
     * সংক্ষিপ্ত কমিশন label (display এর জন্য)
     */
    public function getCommissionLabelAttribute(): string
    {
        if ($this->commission_type === 'percentage') {
            return $this->commission_rate . '%';
        }
        return '৳' . number_format($this->commission_rate, 2);
    }
}

