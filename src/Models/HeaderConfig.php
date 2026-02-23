<?php

namespace LaraGrape\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class HeaderConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'menu_type',
        'menu_config',
        'layout',
        'is_sticky',
        'is_transparent',
        'show_search',
        'show_cta_button',
        'cta_text',
        'cta_url',
        'logo_text',
        'logo_image',
        'logo_position',
        'logo_size',
        'background_color',
        'dark_background_color',
        'text_color',
        'dark_text_color',
        'accent_color',
        'dark_accent_color',
        'border_color',
        'dark_border_color',
        'border_width',
        'shadow',
        'font_family',
        'font_weight',
        'font_size',
        'padding_y',
        'padding_x',
        'menu_spacing',
        'mobile_menu_enabled',
        'mobile_menu_style',
        'mobile_breakpoint',
        'dark_mode_enabled',
        'dark_mode_style',
        'custom_css',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'menu_config' => 'array',
        'is_sticky' => 'boolean',
        'is_transparent' => 'boolean',
        'show_search' => 'boolean',
        'show_cta_button' => 'boolean',
        'mobile_menu_enabled' => 'boolean',
        'dark_mode_enabled' => 'boolean',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($config) {
            if (empty($config->name)) {
                $config->name = Str::slug($config->display_name);
            }
        });
    }

    public static function getActive(): ?self
    {
        return static::where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('sort_order')
            ->first();
    }

    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'menu_type', 'menu_type')
            ->where('menu_type', 'header')
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public static function getDarkModeStyles(): array
    {
        return [
            'auto' => 'Auto (Follows System)',
            'manual' => 'Manual (User Toggle)',
            'system' => 'System (OS Preference)',
        ];
    }

    public static function getMenuTypes(): array
    {
        return [
            'normal' => 'Normal Menu',
            'mega' => 'Mega Menu',
            'dropdown' => 'Dropdown Menu',
            'centered' => 'Centered Menu',
            'minimal' => 'Minimal Menu',
        ];
    }

    public static function getLayouts(): array
    {
        return [
            'standard' => 'Standard Layout',
            'centered' => 'Centered Layout',
            'split' => 'Split Layout',
            'minimal' => 'Minimal Layout',
        ];
    }

    public static function getMobileMenuStyles(): array
    {
        return [
            'hamburger' => 'Hamburger Menu',
            'fullscreen' => 'Fullscreen Menu',
            'slide' => 'Slide Menu',
        ];
    }

    public static function getShadows(): array
    {
        return [
            'none' => 'No Shadow',
            'sm' => 'Small Shadow',
            'md' => 'Medium Shadow',
            'lg' => 'Large Shadow',
            'xl' => 'Extra Large Shadow',
        ];
    }

    public static function getBreakpoints(): array
    {
        return [
            'sm' => 'Small (640px)',
            'md' => 'Medium (768px)',
            'lg' => 'Large (1024px)',
            'xl' => 'Extra Large (1280px)',
        ];
    }

    public function generateCss(): string
    {
        $css = ".header-config-{$this->id} {\n";
        $css .= "  background-color: {$this->background_color};\n";
        $css .= "  color: {$this->text_color};\n";
        $css .= "  font-family: '{$this->font_family}', sans-serif;\n";
        $css .= "  font-weight: {$this->font_weight};\n";
        $css .= "  font-size: {$this->font_size}px;\n";
        $css .= "  padding: {$this->padding_y}px {$this->padding_x}px;\n";
        $css .= "  border-bottom: {$this->border_width}px solid {$this->border_color};\n";
        if ($this->is_sticky) {
            $css .= "  position: sticky;\n  top: 0;\n  z-index: 50;\n";
        }
        if ($this->is_transparent) {
            $css .= "  background-color: transparent;\n";
        }
        if (($this->shadow ?? '') !== 'none') {
            $css .= "  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);\n";
        }
        $css .= "}\n\n";

        if ($this->dark_mode_enabled && $this->dark_background_color) {
            $css .= ".dark .header-config-{$this->id} {\n";
            $css .= "  background-color: {$this->dark_background_color};\n";
            $css .= "  color: {$this->dark_text_color};\n";
            $css .= "  border-bottom-color: {$this->dark_border_color};\n}\n\n";
            $css .= ".dark .header-config-{$this->id} .nav-menu a { color: {$this->dark_text_color}; }\n";
            $css .= ".dark .header-config-{$this->id} .nav-menu a:hover { color: {$this->dark_accent_color}; }\n";
            $css .= ".dark .header-config-{$this->id} .cta-button { background-color: {$this->dark_accent_color}; color: white; }\n";
            $css .= ".dark .header-config-{$this->id} .mobile-menu a { color: {$this->dark_text_color}; }\n\n";
        }

        $css .= ".header-config-{$this->id} .nav-menu a { color: {$this->text_color}; }\n";
        $css .= ".header-config-{$this->id} .nav-menu a:hover { color: {$this->accent_color}; }\n";
        $css .= ".header-config-{$this->id} .logo img { height: {$this->logo_size}px; width: auto; }\n";
        $css .= ".header-config-{$this->id} .cta-button { background-color: {$this->accent_color}; color: white; }\n";
        $css .= ".header-config-{$this->id} .mobile-menu a { color: {$this->text_color}; }\n";

        if ($this->custom_css) {
            $css .= "\n/* Custom CSS */\n{$this->custom_css}\n";
        }

        return $css;
    }
}
