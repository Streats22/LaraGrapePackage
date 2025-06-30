<?php

namespace Streats22\LaraGrape\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class CustomBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'html_content',
        'css_content',
        'js_content',
        'attributes',
        'icon',
        'is_active',
        'sort_order',
        'settings',
    ];

    protected $casts = [
        'attributes' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($block) {
            if (empty($block->slug)) {
                $block->slug = Str::slug($block->name);
            }
        });
        
        static::updating(function ($block) {
            if ($block->isDirty('name') && empty($block->slug)) {
                $block->slug = Str::slug($block->name);
            }
        });
    }

    /**
     * Get blocks by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get active blocks
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get blocks ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get the complete HTML content with CSS and JS
     */
    public function getCompleteContent(): string
    {
        $content = $this->html_content;
        
        if (!empty($this->css_content)) {
            $content = "<style>{$this->css_content}</style>" . $content;
        }
        
        if (!empty($this->js_content)) {
            $content .= "<script>{$this->js_content}</script>";
        }
        
        return $content;
    }

    /**
     * Get GrapesJS block configuration
     */
    public function getGrapesJsConfig(): array
    {
        return [
            'id' => 'custom-' . $this->slug,
            'label' => $this->name,
            'category' => $this->category,
            'content' => $this->getCompleteContent(),
            'attributes' => $this->attributes ?? [],
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }

    /**
     * Get available categories
     */
    public static function getCategories(): array
    {
        return [
            'layouts' => 'Layouts',
            'content' => 'Content',
            'media' => 'Media',
            'forms' => 'Forms',
            'components' => 'Components',
        ];
    }

    /**
     * Get available icons
     */
    public static function getIcons(): array
    {
        return [
            'heroicon-o-rectangle-stack' => 'Rectangle Stack',
            'heroicon-o-squares-2x2' => 'Grid',
            'heroicon-o-document-text' => 'Text',
            'heroicon-o-photo' => 'Image',
            'heroicon-o-video-camera' => 'Video',
            'heroicon-o-envelope' => 'Form',
            'heroicon-o-cube' => 'Component',
            'heroicon-o-star' => 'Star',
            'heroicon-o-heart' => 'Heart',
            'heroicon-o-light-bulb' => 'Light Bulb',
        ];
    }
}
