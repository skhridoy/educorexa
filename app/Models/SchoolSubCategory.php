<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int $school_category_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SchoolCategory $mainCategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory whereSchoolCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchoolSubCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SchoolSubCategory extends Model
{
    protected $fillable = ['school_id', 'school_category_id', 'name'];

    public function mainCategory() {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }
}
