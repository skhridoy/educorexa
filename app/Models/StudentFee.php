<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'fee_head_id',
        'amount',
        'month',
        'status',
        'collected_by',
        'payment_method',
        'due_date'
    ];

    /**
     * যে স্টুডেন্টের এই ফি।
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * এই ফি-টি কোন হেডের (যেমন: মাসিক বেতন বা ভর্তি ফি)।
     */
    public function feeHead()
    {
        return $this->belongsTo(FeeHead::class);
    }

    /**
     * কোন স্কুলের আন্ডারে এই ফি।
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * পেমেন্ট স্ট্যাটাস চেক করার জন্য হেল্পার মেথড (অপশনাল)
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isUnpaid()
    {
        return $this->status === 'unpaid';
    }

    public function collector()
    {
        return $this->belongsTo(Teacher::class, 'collected_by');
    }

    public function getCollectorNameAttribute()
    {
        return $this->collector ? $this->collector->name : 'Admin';
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
                    
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
                    
    }
}