<?php

namespace App\Models;
use App\Models\TeacherAssignSubject;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'school_id',
        'teacher_id',
        'name',
        'subject_id',
        'father_name',
        'mother_name',
        'nid',
        'date_of_birth',
        'gender',
        'email',
        'phone',
        'blood_group',
        'joining_date',
        'qualification',
        'photo',
        'address',
        'school_id',
        'facebook',   
        'twitter',   
        'linkedin', 
        'insta',
        'designation'
    ];

    // Relationships, Accessors, Mutators can be added here

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'school_id', 'school_id')
                    ->where('role', 'teacher')
                    ->where('name', $this->name); // Assuming contact_number is used as email for simplicity
    }
    public function assignedSubjects()
    {
        return $this->hasMany(TeacherAssignSubject::class);
    }

}
