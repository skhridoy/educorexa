<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int|null $school_category_id
 * @property int $year_id
 * @property string $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_published
 * @property string|null $published_at
 * @property-read \App\Models\AcademicYear $academicYear
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SchoolCategory> $categories
 * @property-read int|null $categories_count
 * @property-read mixed $exam_state
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Mark> $marks
 * @property-read int|null $marks_count
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereSchoolCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereYearId($value)
 * @mixin \Eloquent
 */
class Exam extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'year_id',
        'school_category_id',
        'status',
        'start_date',
        'end_date',
    ];

    public function school(){
        return $this->belongsTo(School::class);
    }
    public function academicYear() {
        return $this->belongsTo(AcademicYear::class, 'year_id');
    }

    public function getExamStateAttribute()
    {
        if ($this->status == 0) {
            return 'inactive';
        }

        $today = Carbon::today();
        $start = Carbon::parse($this->start_date);
        $end   = Carbon::parse($this->end_date);

        if ($today->between($start, $end)) {
            return 'ongoing';
        }

        if ($today->lt($start)) {
            return 'upcoming';
        }

        return 'finished';
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
    public function category()
    {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }

    public function categories()
    {
        return $this->hasMany(SchoolCategory::class, 'school_category_id');
    }
}
