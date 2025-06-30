<?php

namespace Streats22\LaraGrape\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class SiteSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = "site_setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value): void
    {
        $setting = static::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->save();
        
        Cache::forget("site_setting_{$key}");
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup(string $group): array
    {
        return static::where('group', $group)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('key')
            ->map(function ($setting) {
                return $setting->value;
            })
            ->toArray();
    }

    /**
     * Get header settings
     */
    public static function getHeaderSettings(): array
    {
        return static::getByGroup('header');
    }

    /**
     * Get footer settings
     */
    public static function getFooterSettings(): array
    {
        return static::getByGroup('footer');
    }

    /**
     * Get general site settings
     */
    public static function getGeneralSettings(): array
    {
        return static::getByGroup('general');
    }

    /**
     * Get SEO settings
     */
    public static function getSeoSettings(): array
    {
        return static::getByGroup('seo');
    }

    /**
     * Get social media settings
     */
    public static function getSocialSettings(): array
    {
        return static::getByGroup('social');
    }

    /**
     * Get available groups
     */
    public static function getGroups(): array
    {
        return [
            'general' => 'General',
            'header' => 'Header',
            'footer' => 'Footer',
            'seo' => 'SEO',
            'social' => 'Social Media',
        ];
    }

    /**
     * Get available types
     */
    public static function getTypes(): array
    {
        return [
            'text' => 'Text',
            'textarea' => 'Text Area',
            'json' => 'JSON',
            'boolean' => 'Boolean',
            'color' => 'Color',
            'image' => 'Image',
            'select' => 'Select',
        ];
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("site_setting_{$setting->key}");
        }
    }
}
