<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School|null $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeeHead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeeHead extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'type'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
