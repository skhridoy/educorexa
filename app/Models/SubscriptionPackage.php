<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'registration_commission_type',
        'registration_commission_rate',
        'monthly_commission_type',
        'monthly_commission_rate',
        'duration',
        'student_limit',
        'teacher_limit',
        'features',
        'permissions',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'registration_commission_rate' => 'decimal:2',
        'monthly_commission_rate' => 'decimal:2',
        'features' => 'array',
        'permissions' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];
}
