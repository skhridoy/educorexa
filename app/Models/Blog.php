<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'blog_category_id',
        'category',
        'author',
        'content',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = self::generateUniqueSlug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if (empty($blog->slug) || $blog->isDirty('title')) {
                $blog->slug = self::generateUniqueSlug($blog->title, $blog->id);
            }
        });
    }

    private static function generateUniqueSlug($title, $excludeId = 0)
    {
        $slug = Str::slug($title);
        
        // If slug is empty (e.g. for non-latin characters and Str::slug returning empty under some PHP setups), 
        // fallback to generating a slug with raw words or random characters
        if (empty($slug)) {
            $slug = str_replace(' ', '-', strtolower($title));
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
        }
        
        if (empty($slug)) {
            $slug = 'blog-' . uniqid();
        }

        $count = static::where('slug', 'LIKE', "{$slug}%")
            ->where('id', '!=', $excludeId)
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
