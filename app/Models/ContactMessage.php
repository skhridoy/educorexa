<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'email',
        'phone',
        'message'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
