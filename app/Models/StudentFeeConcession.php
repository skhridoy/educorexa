<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeeConcession extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'fee_head_id',
        'discount_type',
        'discount_amount',
        'discount_percent',
        'custom_amount',
        'note',
        'is_active',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'custom_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeHead()
    {
        return $this->belongsTo(FeeHead::class);
    }

    /**
     * Calculate final fee and discount for a given standard amount
     */
    public function calculateFee(float $standardAmount): array
    {
        $discountAmount = 0.00;
        $discountPercent = 0.00;
        $finalAmount = $standardAmount;

        if ($this->custom_amount !== null && $this->custom_amount >= 0) {
            $finalAmount = (float) $this->custom_amount;
            $discountAmount = max(0, $standardAmount - $finalAmount);
            $discountPercent = $standardAmount > 0 ? round(($discountAmount / $standardAmount) * 100, 2) : 0;
        } elseif ($this->discount_percent > 0) {
            $discountPercent = (float) $this->discount_percent;
            $discountAmount = round($standardAmount * ($discountPercent / 100), 2);
            $finalAmount = max(0, $standardAmount - $discountAmount);
        } elseif ($this->discount_amount > 0) {
            $discountAmount = min($standardAmount, (float) $this->discount_amount);
            $finalAmount = max(0, $standardAmount - $discountAmount);
            $discountPercent = $standardAmount > 0 ? round(($discountAmount / $standardAmount) * 100, 2) : 0;
        }

        return [
            'standard_amount' => $standardAmount,
            'discount_amount' => $discountAmount,
            'discount_percent' => $discountPercent,
            'final_amount' => $finalAmount,
        ];
    }
}
