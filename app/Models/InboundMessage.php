<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InboundMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id', 'mailbox_type', 'recipient_email', 'message_id',
        'sender_name', 'sender_email', 'subject', 'body_text', 'body_html',
        'headers', 'received_at', 'is_read', 'status',
    ];

    protected $casts = [
        'headers' => 'array',
        'received_at' => 'datetime',
        'is_read' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
