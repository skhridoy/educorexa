<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'academic_year_id',
        'class_id',
        'school_category_id', // যুক্ত করা হয়েছে
        'section_id',
        'student_id',
        'roll',
        'name',
        'previous_school',
        'previous_class',
        'fathers_name',
        'mothers_name',
        'father_nid',
        'mother_nid',
        'student_birth_nid',
        'contact_number',
        'password',
        'photo',
        'status',
        'religion',
        'gender',
        'date_of_birth',
        'admission_date',
        'blood_group',
        'address',
        'admin_note',
        'created_by',
        'school_sub_category_id' // যুক্ত করা হয়েছে
    ];

    // 🔹 স্টুডেন্ট কোন ক্যাটেগরির (Primary/High School) আন্ডারে
    public function category()
    {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }

    // 🔹 স্টুডেন্ট কোন গ্রুপের (Science/Arts) আন্ডারে - আপনি অলরেডি group() নামে দিয়েছেন
    public function group()
    {
        return $this->belongsTo(SchoolSubCategory::class, 'school_sub_category_id');
    }

    // 🔹 Admission belongs to School
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // 🔹 Admission belongs to Academic Year
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // 🔹 Admission belongs to Class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function sessions()
    {
        return $this->hasMany(StudentSession::class);
    }
    
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function fees() {
        return $this->hasMany(StudentFee::class);
    }

    public function unpaidFees() {
        return $this->hasMany(StudentFee::class)->where('status', 'unpaid');
    }
}