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
        'duration',
        'student_limit',
        'teacher_limit',
        'features',
        'permissions',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'permissions' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];
}
