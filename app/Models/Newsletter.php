<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = ['school_id', 'email', 'is_active'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}