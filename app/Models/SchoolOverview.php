<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolOverview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'title',
        'description',
        'image',
        'features',
        'order_by',
    ];

    /**
     * Get the school that owns the overview.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Optional: Helper to get features as an array if stored as comma-separated string
     */
    public function getFeatureListAttribute()
    {
        return $this->features ? explode(',', $this->features) : [];
    }
}