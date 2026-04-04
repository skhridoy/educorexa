<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignClass extends Model
{
    protected $fillable = [
        'school_id',
        'class_id',
        'subject_id',
        'full_mark',
        'pass_mark'
    ];

    // এই রেকর্ডটি কোন ক্লাসের?
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // এই রেকর্ডটি কোন বিষয়ের?
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}