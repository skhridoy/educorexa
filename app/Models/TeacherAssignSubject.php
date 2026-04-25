<?php

namespace App\Models;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int $teacher_id
 * @property int $class_id
 * @property int|null $section_id
 * @property int $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Classes $class
 * @property-read \App\Models\School $school
 * @property-read \App\Models\Section|null $section
 * @property-read Subject $subject
 * @property-read Teacher $teacher
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeacherAssignSubject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeacherAssignSubject extends Model
{
    protected $fillable = [
        'school_id',
        'teacher_id',
        'class_id',
        'section_id',
        'subject_id'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }

}
