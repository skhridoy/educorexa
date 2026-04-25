<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $site_name
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $logo_wide
 * @property string|null $logo_square
 * @property string|null $favicon
 * @property string|null $og_image
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $footer_text
 * @property string|null $facebook_url
 * @property string|null $twitter_url
 * @property string|null $instagram_url
 * @property string|null $linkedin_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFacebookUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFavicon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFooterText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereInstagramUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereLinkedinUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereLogoSquare($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereLogoWide($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereOgImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSiteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereTwitterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SiteSetting extends Model
{
    protected $fillable = [
        'site_name', 'address', 'phone', 'email', 'footer_text',
        'logo_wide', 'logo_square', 'favicon', 'meta_title', 'meta_description', 'meta_keywords', 'og_image'
    ];

}
