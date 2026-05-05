<?php

namespace App\Models;
use App\Models\TeacherAssignSubject;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property string|null $code
 * @property string|null $type
 * @property string|null $description
 * @property int|null $school_category_id
 * @property int|null $school_sub_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Classes> $classes
 * @property-read int|null $classes_count
 * @property-read \App\Models\School $school
 * @property-read \App\Models\SchoolCategory|null $category
 * @property-read \App\Models\SchoolSubCategory|null $subCategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereSchoolCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereSchoolSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subject extends Model
{
    protected $fillable = ['id', 'school_id', 'name', 'code', 'type', 'description', 'school_category_id', 'school_sub_category_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'assign_classes', 'subject_id', 'class_id');
    }
    
    public function category()
    {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }
    
    public function subCategory()
    {
        return $this->belongsTo(SchoolSubCategory::class, 'school_sub_category_id');
    }
    
}
