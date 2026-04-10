<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'year_id',
        'school_category_id',
        'status',
        'start_date',
        'end_date',
    ];

    public function school(){
        return $this->belongsTo(School::class);
    }
    public function academicYear() {
        return $this->belongsTo(AcademicYear::class, 'year_id');
    }

    public function getExamStateAttribute()
    {
        if ($this->status == 0) {
            return 'inactive';
        }

        $today = Carbon::today();
        $start = Carbon::parse($this->start_date);
        $end   = Carbon::parse($this->end_date);

        if ($today->between($start, $end)) {
            return 'ongoing';
        }

        if ($today->lt($start)) {
            return 'upcoming';
        }

        return 'finished';
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
    public function categories()
    {
        return $this->hasMany(SchoolCategory::class, 'school_category_id');
    }
}
