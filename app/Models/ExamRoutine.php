<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;
use App\Models\School;
use App\Models\Exam;
use App\Models\AcademicYear;
use App\Models\Subject;

class ExamRoutine extends Model
{
    protected $fillable = [
        'school_id',
        'academic_year_id',
        'exam_id',
        'class_id',
        'subject_id',
        'exam_date',
        'start_time',
        'end_time',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
