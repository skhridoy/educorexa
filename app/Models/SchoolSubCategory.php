<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSubCategory extends Model
{
    protected $fillable = ['school_id', 'school_category_id', 'name'];

    public function mainCategory() {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }
}
