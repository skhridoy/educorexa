<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolCategory extends Model
{
   
    protected $fillable = ['school_id', 'name', 'exams_per_year'];

    public function classes() {
        return $this->hasMany(Classes::class);
    }

}
