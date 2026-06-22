<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blog_category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = self::generateUniqueSlug($category->name);
            }
        });

        static::updating(function ($category) {
            // Only auto-generate slug if name changed AND slug wasn't manually set
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = self::generateUniqueSlug($category->name, $category->id);
            }
        });
    }

    private static function generateUniqueSlug($name, $excludeId = 0)
    {
        $slug = Str::slug($name);
        
        if (empty($slug)) {
            $slug = str_replace(' ', '-', strtolower($name));
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
        }
        
        if (empty($slug)) {
            $slug = 'category-' . uniqid();
        }

        $count = static::where('slug', 'LIKE', "{$slug}%")
            ->where('id', '!=', $excludeId)
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
