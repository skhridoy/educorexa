<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property string|null $newsletter_text
 * @property string|null $copyright_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereCopyrightText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereNewsletterText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FooterSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FooterSetting extends Model
{
    protected $fillable = [
        'school_id','facebook', 'twitter', 'instagram', 'linkedin', 
        'newsletter_text', 'copyright_text'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
