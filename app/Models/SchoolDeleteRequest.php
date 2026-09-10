<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolDeleteRequest extends Model
{
    protected $fillable = [
        'school_id',
        'requested_by',
        'reason',
        'status',
        'reviewed_by',
        'reviewed_at',
        'admin_note',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * যে স্কুলটি ডিলিট করার অনুরোধ করা হয়েছে
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * যিনি ডিলিট রিকোয়েস্ট পাঠিয়েছেন (employee user)
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * যিনি রিভিউ করেছেন (super_admin বা HR)
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Pending রিকোয়েস্টগুলো
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
