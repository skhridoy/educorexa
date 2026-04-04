<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_active',
        'email',
        'phone',
        'favicon',
        'logo'
    ];

    // ✅ Relation: school has many students
    public function student()
    {
        return $this->hasMany(User::class)
                    ->where('role', 'student');
    }

    // Relation: school has many teachers
    public function teacher()
    {
        return $this->hasMany(User::class)
                    ->where('role', 'teacher');
    }

    // Relation: school has many admins (optional)
    public function admin()
    {
        // এটি নিশ্চিত করবে যে আপনি একটি মাত্র অবজেক্ট পাচ্ছেন, কালেকশন নয়
        return $this->hasOne(User::class, 'school_id')->where('role', 'school_admin');
    }

    // 🔹 School has many Classes
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    // 🔹 School has many Academic Years
    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }

    // 🔹 School has many Admissions
    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    // 🔹 School has many Students
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // 🔹 School has many Users (admin, teacher, student)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function footerSetting()
    {
        return $this->hasOne(FooterSetting::class, 'school_id');
    }
}
