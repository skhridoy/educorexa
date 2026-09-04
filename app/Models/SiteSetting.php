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
        'logo_wide', 'logo_square', 'favicon', 'meta_title', 'meta_description', 'meta_keywords', 'og_image',
        'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name',
        'inbound_webhook_secret', 'inbound_webhook_enabled'
        , 'imap_enabled', 'imap_host', 'imap_port', 'imap_username', 'imap_password', 'imap_encryption', 'imap_folder',
        'payment_mode', 'bkash_personal_number', 'nagad_personal_number',
        'bkash_merchant_number', 'bkash_merchant_id', 'bkash_api_key', 'bkash_api_secret',
        'nagad_merchant_number', 'nagad_merchant_id', 'nagad_api_key', 'nagad_api_secret',
        'manual_payment_instructions'
    ];

    protected $casts = [
        'inbound_webhook_enabled' => 'boolean',
        'imap_enabled' => 'boolean',
        'imap_password' => 'encrypted',
        'bkash_api_key' => 'encrypted',
        'bkash_api_secret' => 'encrypted',
        'nagad_api_key' => 'encrypted',
        'nagad_api_secret' => 'encrypted',
    ];

}
