<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property int $exams_per_year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Classes> $classes
 * @property-read int|null $classes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory whereExamsPerYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SchoolCategory extends Model
{
   
    protected $fillable = ['school_id', 'name', 'exams_per_year'];

    public function classes() {
        return $this->hasMany(Classes::class);
    }

}
