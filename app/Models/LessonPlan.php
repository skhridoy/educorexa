<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
