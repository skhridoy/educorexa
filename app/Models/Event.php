<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'location',
        'color',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
    ];
}
