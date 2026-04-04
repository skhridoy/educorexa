<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FeeHead extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'type'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
