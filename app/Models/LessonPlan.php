<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int $class_id
 * @property int $section_id
 * @property int $subject_id
 * @property int $teacher_id
 * @property string $date
 * @property string $lesson_description
 * @property string|null $homework
 * @property string|null $submission_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classes $class
 * @property-read \App\Models\School $school
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\Subject $subject
 * @property-read \App\Models\Teacher $teacher
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereHomework($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereLessonDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereSubmissionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LessonPlan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LessonPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id', 
        'class_id', 
        'section_id',
        'subject_id', 
        'teacher_id', 
        'date', 
        'lesson_description', 
        'homework',
        'submission_date'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        // এখানে 'user_id' হলো আপনার lesson_plans টেবিলের ফরেন কি
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function class() {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
