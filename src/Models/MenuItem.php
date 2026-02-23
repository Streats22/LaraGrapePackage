<?php

namespace LaraGrape\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'menu_set_id',
        'parent_id',
        'sort_order',
        'link_type',
        'link_url',
        'page_id',
        'link_text',
        'link_title',
        'open_in_new_tab',
        'is_active',
        'is_visible',
        'icon',
        'css_class',
    ];

    protected $casts = [
        'open_in_new_tab' => 'boolean',
        'is_active' => 'boolean',
        'is_visible' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (empty($item->name)) {
                $item->name = Str::slug($item->display_name);
            }
        });
    }

    public function menuSet()
    {
        return $this->belongsTo(MenuSet::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('is_active', true)
            ->where('is_visible', true)
            ->orderBy('sort_order');
    }

    public function allChildren()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function isChild(): bool
    {
        return ! is_null($this->parent_id);
    }

    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOfMenuSetType($query, string $menuType)
    {
        return $query->whereHas('menuSet', function ($q) use ($menuType) {
            $q->where('menu_type', $menuType);
        });
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getFinalUrl(): string
    {
        return match ($this->link_type) {
            'page' => $this->page ? route('page.show', $this->page->slug) : '#',
            'url', 'custom' => $this->link_url ?: '#',
            default => '#',
        };
    }

    public function getDisplayText(): string
    {
        return $this->link_text ?: ($this->page ? $this->page->title : 'Untitled');
    }

    public static function getMenuTypes(): array
    {
        return [
            'header' => 'Header Menu',
            'footer' => 'Footer Menu',
            'mobile' => 'Mobile Menu',
            'custom' => 'Custom Menu',
        ];
    }

    public static function getLinkTypes(): array
    {
        return [
            'page' => 'Page Link',
            'url' => 'External URL',
            'custom' => 'Custom Link',
            'dropdown' => 'Dropdown Menu',
        ];
    }
}
