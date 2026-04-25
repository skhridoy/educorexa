<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $school_id
 * @property string $title
 * @property string|null $description
 * @property string|null $file
 * @property string $notice_date
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @method static \Database\Factories\NoticeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereNoticeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'file',
        'notice_date',
        'is_active'
    ];

    // Relation: Notice belongs to a School
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
