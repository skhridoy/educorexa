<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'file',
        'notice_date',
        'is_active'
    ];

    // Relation: Notice belongs to a School
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
