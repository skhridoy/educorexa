<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainContactMsg extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'school_name',
        'message',
        'is_read',
    ];
    
}
