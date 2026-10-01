<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttendance extends Model
{
    protected $fillable = [
        'school_id',
        'exam_id',
        'student_id',
        'class_id',
        'section_id',
        'attendance_date',
        'status',
        'scanned_at',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'scanned_at' => 'datetime',
    ];

    public function exam() { return $this->belongsTo(Exam::class); }
    public function student() { return $this->belongsTo(Student::class); }
    public function class() { return $this->belongsTo(Classes::class, 'class_id'); }
    public function section() { return $this->belongsTo(Section::class); }
}
