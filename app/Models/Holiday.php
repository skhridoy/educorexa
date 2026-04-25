<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $school_id
 * @property string $title
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School|null $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Holiday whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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