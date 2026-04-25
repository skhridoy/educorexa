<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string $title
 * @property string $description
 * @property string|null $image
 * @property string|null $features
 * @property int $order_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $feature_list
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereOrderBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolOverview whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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