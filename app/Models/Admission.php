<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
    'school_id',
    'academic_year_id',
    'class_id',
    'admission_number',
    'name',
    'email',
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
    'admin_note',
];

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


}
