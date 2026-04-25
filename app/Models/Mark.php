<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int $academic_year_id
 * @property int $student_id
 * @property int $subject_id
 * @property int $exam_id
 * @property int $class_id
 * @property int $marks
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AcademicYear $academicYear
 * @property-read \App\Models\Classes $classes
 * @property-read \App\Models\Exam $exam
 * @property-read \App\Models\School $school
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\Subject $subject
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereMarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mark whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Mark extends Model
{
    protected $fillable = ['school_id', 'academic_year_id', 'student_id', 'class_id', 'subject_id', 'exam_id', 'marks'];

    public function school() {
        return $this->belongsTo(School::class);
    }
    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }
    public function academicYear(){
        return $this->belongsTo(AcademicYear::class);
    }
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
