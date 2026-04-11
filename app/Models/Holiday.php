<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasFactory;

    // ডাটাবেজ টেবিলের নাম (যদি মাইগ্রেশনে 'holidays' দিয়ে থাকেন তবে এটি অপশনাল)
    protected $table = 'holidays';

    // যে কলামগুলো মাস-অ্যাসাইনমেন্ট (Mass Assignment) করা যাবে
    protected $fillable = [
        'school_id',
        'title',
        'date',
    ];

    /**
     * তারিখ কলামটিকে কার্বন অবজেক্ট হিসেবে কাস্ট করা
     * যাতে ক্যালেন্ডারে তুলনা করা সহজ হয়
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * রিলেশনশিপ: একটি ছুটি একটি স্কুলের অধীনে থাকে
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}