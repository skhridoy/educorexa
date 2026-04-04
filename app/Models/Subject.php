<?php

namespace App\Models;
use App\Models\TeacherAssignSubject;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['id', 'school_id', 'name', 'code', 'type', 'description'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'assign_classes', 'subject_id', 'class_id');
    }
    
}
