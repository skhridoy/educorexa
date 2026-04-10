<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeAmount extends Model
{
    protected $fillable = [
        'school_id', 
        'fee_head_id', 
        'class_id', 
        'amount', 
        'school_category_id',
        'school_sub_category_id'
        ];

    public function feeHead() {
        return $this->belongsTo(FeeHead::class);
    }

    public function class() {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // In FeeAmount Model
    public function category() {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }
    public function subCategory() {
        return $this->belongsTo(SchoolSubCategory::class, 'school_sub_category_id');
    }
}