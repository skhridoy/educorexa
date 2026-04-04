<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'school_id','facebook', 'twitter', 'instagram', 'linkedin', 
        'newsletter_text', 'copyright_text'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
