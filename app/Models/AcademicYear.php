<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admission> $admissions
 * @property-read int|null $admissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exam> $exams
 * @property-read int|null $exams_count
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AcademicYear extends Model
{
    protected $table = 'academicyears';
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return self::where('id', $value)->firstOrFail();
    }

    // 🔹 Academic Year has many Admissions
    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'year_id');
    }
}

