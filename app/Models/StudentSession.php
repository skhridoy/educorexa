<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $student_id
 * @property int $class_id
 * @property int $academic_year_id
 * @property string $old_student_id
 * @property string $old_roll
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AcademicYear $academicYear
 * @property-read \App\Models\Classes $class
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession whereOldRoll($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession whereOldStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSession whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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