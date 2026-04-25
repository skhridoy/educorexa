<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int $student_id
 * @property int $class_id
 * @property int|null $section_id
 * @property int $teacher_id
 * @property \Illuminate\Support\Carbon $date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classes|null $class
 * @property-read \App\Models\School|null $school
 * @property-read \App\Models\Section|null $section
 * @property-read \App\Models\Student|null $student
 * @property-read \App\Models\Teacher|null $teacher
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attendance extends Model
{
    protected $casts = [
        'created_at' => 'datetime',
        'date' => 'date',
    ];
    protected $fillable = [
        'school_id',
        'student_id',
        'class_id',
        'section_id',
        'teacher_id',
        'date',
        'status'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function class() {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section() {
        return $this->belongsTo(Section::class, 'section_id');
    }


}
