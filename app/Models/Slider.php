<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'school_id',
        'title',
        'subtitle',
        'image',
        'order_by',
        'status'
    ];

   
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
