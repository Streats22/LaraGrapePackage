<?php

namespace LaraGrape\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class MenuSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'menu_type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($menuSet) {
            if (empty($menuSet->name)) {
                $menuSet->name = Str::slug($menuSet->display_name);
            }
        });

        static::saving(function ($menuSet) {
            if ($menuSet->is_active && in_array($menuSet->menu_type, ['header', 'footer'])) {
                static::where('menu_type', $menuSet->menu_type)
                    ->where('id', '!=', $menuSet->id)
                    ->update(['is_active' => false]);
            }
        });
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class)
            ->where('is_active', true)
            ->where('is_visible', true)
            ->orderBy('sort_order');
    }

    public function allMenuItems()
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public static function getActive(string $menuType): ?self
    {
        return static::where('menu_type', $menuType)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();
    }

    public static function getMenuTypes(): array
    {
        return [
            'header' => 'Header Navigation',
            'footer' => 'Footer Links',
            'mobile' => 'Mobile Menu',
            'custom' => 'Custom Menu',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('menu_type', $type);
    }

    public function getMenuStructure(): array
    {
        $items = $this->menuItems()->with(['page', 'children.page'])->get();

        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->getDisplayText(),
                'url' => $item->getFinalUrl(),
                'title' => $item->link_title,
                'open_in_new_tab' => $item->open_in_new_tab,
                'icon' => $item->icon,
                'css_class' => $item->css_class,
                'has_children' => $item->hasChildren(),
                'children' => $item->children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'text' => $child->getDisplayText(),
                        'url' => $child->getFinalUrl(),
                        'title' => $child->link_title,
                        'open_in_new_tab' => $child->open_in_new_tab,
                        'icon' => $child->icon,
                        'css_class' => $child->css_class,
                    ];
                })->toArray(),
            ];
        })->toArray();
    }
}
