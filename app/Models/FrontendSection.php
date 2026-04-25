<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $key
 * @property string $title
 * @property int $status
 * @property array<array-key, mixed>|null $content
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FrontendSection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FrontendSection extends Model
{
    protected $fillable = ['key', 'title', 'status', 'content', 'order'];
    protected $casts = [
        'content' => 'array', // content ফিল্ডকে JSON থেকে অ্যারে হিসেবে কাস্ট করা হবে
    ];

}
