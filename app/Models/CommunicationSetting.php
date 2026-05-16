<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'event',
        'email_enabled',
        'sms_enabled',
        'whatsapp_enabled',
        'email_template',
        'sms_template',
        'whatsapp_template',
    ];

    protected $casts = [
        'email_enabled' => 'boolean',
        'sms_enabled' => 'boolean',
        'whatsapp_enabled' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
