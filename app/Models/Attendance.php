<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
