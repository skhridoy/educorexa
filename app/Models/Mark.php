<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
