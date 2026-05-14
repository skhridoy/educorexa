<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'ticket_id',
        'subject',
        'message',
        'priority',
        'status',
        'is_read_by_super',
        'is_read_by_school',
        'attachment',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(SupportReply::class, 'ticket_id');
    }
}
