<?php

namespace App\Models;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;

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
