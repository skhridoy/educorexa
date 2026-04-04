<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'school_id', 'title', 'description', 
        'feature_1_title', 'feature_1_desc', 
        'feature_2_title', 'feature_2_desc', 
        'image', 'button_text', 'button_url'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
