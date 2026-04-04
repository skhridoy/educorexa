<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $table = 'academicyears';
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return self::where('id', $value)->firstOrFail();
    }

    // 🔹 Academic Year has many Admissions
    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'year_id');
    }
}

