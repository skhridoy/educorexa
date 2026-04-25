<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TeacherAssignSubject;

/**
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $school_category_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admission> $admissions
 * @property-read int|null $admissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AssignClass> $assignments
 * @property-read int|null $assignments_count
 * @property-read \App\Models\SchoolCategory|null $category
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subject> $subjects
 * @property-read int|null $subjects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, TeacherAssignSubject> $teacherAssignments
 * @property-read int|null $teacher_assignments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes whereSchoolCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Classes extends Model
{
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'code',
        'description',
        'school_category_id'
    ];

    // 🔹 Class belongs to School
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // 🔹 Class has many Admissions
    public function admissions()
    {
        return $this->hasMany(Admission::class, 'class_id');
    }

    // 🔹 Class has many Students
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function subjects()
    {
        // hasManyThrough ব্যবহার করলে আপনি সরাসরি সাবজেক্ট লিস্ট পাবেন
        // Classes -> AssignClass -> Subject
        return $this->hasManyThrough(
            Subject::class, 
            AssignClass::class, 
            'class_id',   // AssignClass টেবিলের ফরেন কি
            'id',         // Subject টেবিলের লোকাল কি
            'id',         // Classes টেবিলের লোকাল কি
            'subject_id'  // AssignClass টেবিলের ফরেন কি
        );
    }

    // ২. এটি আপনার ম্যাপিং টেবিলের সাথে সরাসরি সম্পর্ক (যা আপনি অলরেডি লিখেছেন)
    public function assignments()
    {
        return $this->hasMany(AssignClass::class, 'class_id');
    }

    // ৩. টিচার এসাইনমেন্টের জন্য ফরেন কি উল্লেখ করে দিন (নিরাপদ থাকার জন্য)
    public function teacherAssignments()
    {
        return $this->hasMany(TeacherAssignSubject::class, 'class_id');
    }

    public function category() {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }
}
