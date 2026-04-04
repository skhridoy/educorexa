<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSession extends Model
{
    use HasFactory;

    // যদি টেবিল নাম ভিন্ন হয় (যেমন: student_sessions), লারাভেল অটো ধরে নেয়। 
    // তবে নিশ্চিত হওয়ার জন্য লিখে দেওয়া ভালো।
    protected $table = 'student_sessions';

    protected $fillable = [
        'student_id',
        'school_id',
        'class_id',
        'academic_year_id',
        'old_roll',
        'old_student_id',
    ];

    /**
     * স্টুডেন্টের সাথে রিলেশন
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * ক্লাসের সাথে রিলেশন
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * বছরের সাথে রিলেশন
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}