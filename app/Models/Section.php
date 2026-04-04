<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'description'  
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
}
