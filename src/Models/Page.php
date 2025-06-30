<?php

namespace Streats22\LaraGrape\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'grapesjs_data',
        'grapesjs_css',
        'grapesjs_html',
        'template',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'show_in_menu',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'grapesjs_data' => 'array',
        'grapesjs_css' => 'string', 
        'grapesjs_html' => 'string',
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
        
        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where(function ($query) {
                        $query->whereNull('published_at')
                              ->orWhere('published_at', '<=', now());
                    });
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true)
                    ->orderBy('sort_order');
    }

    public function getRouteKeyName()
    {
        // Use 'id' for admin routes, 'slug' for public routes
        return request()->is('admin/*') ? 'id' : 'slug';
    }
}
