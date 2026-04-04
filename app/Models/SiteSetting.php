<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name', 'address', 'phone', 'email', 'footer_text',
        'logo_wide', 'logo_square', 'favicon'
    ];

}
