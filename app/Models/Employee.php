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
        'commission_type', 'commission_rate', // রেজিস্ট্রেশন কমিশন (ডিফল্ট / ব্যাকআপ)
        'monthly_commission_type', 'monthly_commission_rate', // মাসিক এক্সট্রা কমিশন (ডিফল্ট / ব্যাকআপ)
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
     * একটি নির্দিষ্ট স্কুলের জন্য ১. রেজিস্ট্রেশন কমিশন হিসাব করা
     * (প্রথমে প্যাকেজ রেট, না থাকলে এমপ্লয়ির রেট)
     */
    public function calculateRegistrationCommissionForSchool(School $school): float
    {
        $package = $school->subscriptionPackage;
        $price = $package ? (float)$package->price : 0;

        if ($package && (float)$package->registration_commission_rate > 0) {
            if ($package->registration_commission_type === 'percentage') {
                return ($price * (float)$package->registration_commission_rate) / 100;
            }
            return (float)$package->registration_commission_rate;
        }

        // প্যাকেজে নির্দিষ্ট না থাকলে Representative-এর রেট
        if ($this->commission_type === 'percentage') {
            return ($price * (float)$this->commission_rate) / 100;
        }
        return (float)$this->commission_rate;
    }

    /**
     * একটি নির্দিষ্ট স্কুলের জন্য ২. প্রতি মাসের এক্সট্রা কমিশন হিসাব করা
     */
    public function calculateMonthlyCommissionForSchool(School $school, ?float $subscriptionAmount = null): float
    {
        $package = $school->subscriptionPackage;
        $baseAmount = $subscriptionAmount ?? ($package ? (float)$package->price : 0);

        if ($package && (float)$package->monthly_commission_rate > 0) {
            if ($package->monthly_commission_type === 'percentage') {
                return ($baseAmount * (float)$package->monthly_commission_rate) / 100;
            }
            return (float)$package->monthly_commission_rate;
        }

        // প্যাকেজে নির্দিষ্ট না থাকলে Representative-এর মাসিক রেট
        if (($this->monthly_commission_type ?? 'flat') === 'percentage') {
            return ($baseAmount * (float)($this->monthly_commission_rate ?? 0)) / 100;
        }
        return (float)($this->monthly_commission_rate ?? 0);
    }

    /**
     * একটি স্কুলের সর্বমোট অর্জিত কমিশন (রেজিস্ট্রেশন কমিশন + প্রতিটি অ্যাক্টিভ/পরিশোধিত মাসের মাসিক কমিশন)
     */
    public function calculateSchoolCommission(School $school): array
    {
        $registrationComm = 0;
        $monthlyComm = 0;

        // স্কুল approved বা সক্রিয় হলে রেজিস্ট্রেশন কমিশন প্রযোজ্য
        if (in_array($school->status, ['approved', 'active']) || $school->subscriptions()->whereNotNull('paid_at')->exists()) {
            $registrationComm = $this->calculateRegistrationCommissionForSchool($school);
        }

        // প্রতিটি পরিশোধিত সাবস্ক্রিপশন মাসের জন্য মাসিক এক্সট্রা কমিশন
        $paidSubscriptions = $school->subscriptions()
            ->whereIn('status', ['active', 'trialing'])
            ->whereNotNull('paid_at')
            ->get();

        foreach ($paidSubscriptions as $sub) {
            $monthlyComm += $this->calculateMonthlyCommissionForSchool($school, (float)$sub->amount);
        }

        return [
            'registration' => round($registrationComm, 2),
            'monthly'      => round($monthlyComm, 2),
            'total'        => round($registrationComm + $monthlyComm, 2),
        ];
    }

    /**
     * প্রতিটি স্কুলের paid subscription ও রেজিস্ট্রেশন থেকে মোট কমিশন হিসাব করা
     */
    public function calculateTotalCommission(): float
    {
        $schools = $this->registeredSchools()->with(['subscriptions', 'subscriptionPackage'])->get();
        $total = 0;

        foreach ($schools as $school) {
            $breakdown = $this->calculateSchoolCommission($school);
            $total += $breakdown['total'];
        }

        return round($total, 2);
    }

    /**
     * মোট কমিশন ব্রেকডাউন (রেজিস্ট্রেশন + মাসিক)
     */
    public function calculateTotalCommissionBreakdown(): array
    {
        $schools = $this->registeredSchools()->with(['subscriptions', 'subscriptionPackage'])->get();
        $totalReg = 0;
        $totalMonthly = 0;

        foreach ($schools as $school) {
            $breakdown = $this->calculateSchoolCommission($school);
            $totalReg += $breakdown['registration'];
            $totalMonthly += $breakdown['monthly'];
        }

        return [
            'registration' => round($totalReg, 2),
            'monthly'      => round($totalMonthly, 2),
            'total'        => round($totalReg + $totalMonthly, 2),
        ];
    }

    /**
     * সংক্ষিপ্ত কমিশন label (display এর জন্য)
     */
    public function getCommissionLabelAttribute(): string
    {
        $reg = ($this->commission_type === 'percentage') 
            ? $this->commission_rate . '%' 
            : '৳' . number_format($this->commission_rate, 2);

        $mon = (($this->monthly_commission_type ?? 'flat') === 'percentage')
            ? ($this->monthly_commission_rate ?? 0) . '%'
            : '৳' . number_format($this->monthly_commission_rate ?? 0, 2);

        return "Reg: {$reg} | Mon: {$mon}";
    }
}

