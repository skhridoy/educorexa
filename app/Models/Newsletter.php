<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string $email
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Newsletter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Newsletter extends Model
{
    protected $fillable = ['school_id', 'email', 'is_active'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}