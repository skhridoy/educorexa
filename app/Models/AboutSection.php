<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $feature_1_title
 * @property string|null $feature_1_desc
 * @property string|null $feature_2_title
 * @property string|null $feature_2_desc
 * @property string|null $image
 * @property string $button_text
 * @property string|null $button_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereButtonText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereButtonUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereFeature1Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereFeature1Title($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereFeature2Desc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereFeature2Title($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutSection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AboutSection extends Model
{
    protected $fillable = [
        'school_id', 'title', 'description', 
        'feature_1_title', 'feature_1_desc', 
        'feature_2_title', 'feature_2_desc', 
        'image', 'button_text', 'button_url'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
