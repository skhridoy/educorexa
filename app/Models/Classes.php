<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TeacherAssignSubject;

class Classes extends Model
{
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'code',
        'description'
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
}
