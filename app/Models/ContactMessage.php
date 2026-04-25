<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School|null $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactMessage extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'email',
        'phone',
        'message'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
