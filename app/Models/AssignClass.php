<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int $class_id
 * @property int $subject_id
 * @property string|null $full_mark
 * @property string|null $pass_mark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classes $class
 * @property-read \App\Models\Subject $subject
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass whereFullMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass wherePassMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignClass whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AssignClass extends Model
{
    protected $fillable = [
        'school_id',
        'class_id',
        'subject_id',
        'full_mark',
        'pass_mark'
    ];

    // এই রেকর্ডটি কোন ক্লাসের?
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // এই রেকর্ডটি কোন বিষয়ের?
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}