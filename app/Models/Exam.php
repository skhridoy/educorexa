<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int|null $school_category_id  (legacy — use categories() relation)
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
 * @mixin \Eloquent
 */
class Exam extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'year_id',
        'school_category_id', // kept for backward compatibility
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

    /**
     * Many-to-Many: An exam can belong to multiple school categories
     */
    public function categories()
    {
        return $this->belongsToMany(SchoolCategory::class, 'exam_categories', 'exam_id', 'school_category_id')
                    ->withTimestamps();
    }

    /**
     * Legacy single-category accessor (returns first category for backward compat)
     */
    public function category()
    {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }

    /**
     * Check if this exam applies to a given category ID
     */
    public function appliesToCategory(int $categoryId): bool
    {
        // Check pivot table first (new system)
        if ($this->relationLoaded('categories')) {
            return $this->categories->contains('id', $categoryId);
        }
        return $this->categories()->where('school_category_id', $categoryId)->exists();
    }

    public function getExamStateAttribute()
    {
        $today = Carbon::today();
        $start = $this->start_date ? Carbon::parse($this->start_date) : null;
        $end   = $this->end_date ? Carbon::parse($this->end_date) : null;

        // পরীক্ষার সময় শেষ হয়ে গেলে সেটি অটোমেটিক finished হবে
        if ($end && $today->gt($end)) {
            return 'finished';
        }

        if ($this->status == 0) {
            return 'inactive';
        }

        if ($start && $end && $today->between($start, $end)) {
            return 'ongoing';
        }

        if ($start && $today->lt($start)) {
            return 'upcoming';
        }

        return 'finished';
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
