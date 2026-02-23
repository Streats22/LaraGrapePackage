<?php

namespace LaraGrape\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class FooterConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'layout',
        'layout_config',
        'show_brand_section',
        'show_quick_links',
        'show_social_links',
        'show_newsletter',
        'show_contact_info',
        'show_copyright',
        'show_powered_by',
        'logo_text',
        'logo_image',
        'logo_position',
        'logo_size',
        'brand_description',
        'quick_links_columns',
        'quick_links_title',
        'quick_links',
        'social_links_title',
        'social_links',
        'newsletter_title',
        'newsletter_description',
        'newsletter_placeholder',
        'newsletter_button_text',
        'contact_title',
        'contact_phone',
        'contact_email',
        'contact_address',
        'copyright_text',
        'powered_by_text',
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
        'section_spacing',
        'grid_columns_desktop',
        'grid_columns_tablet',
        'grid_columns_mobile',
        'dark_mode_enabled',
        'dark_mode_style',
        'custom_css',
        'is_active',
        'is_default',
        'sort_order',
        'brand_position',
        'social_position',
        'menu_position',
        'copyright_position',
        'newsletter_position',
        'contact_position',
    ];

    protected $casts = [
        'layout_config' => 'array',
        'quick_links' => 'array',
        'social_links' => 'array',
        'show_brand_section' => 'boolean',
        'show_quick_links' => 'boolean',
        'show_social_links' => 'boolean',
        'show_newsletter' => 'boolean',
        'show_contact_info' => 'boolean',
        'show_copyright' => 'boolean',
        'show_powered_by' => 'boolean',
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
            ->where('menu_type', 'footer')
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

    public static function getLayouts(): array
    {
        return [
            'standard' => 'Standard Layout',
            'centered' => 'Centered Layout',
            'minimal' => 'Minimal Layout',
            'extended' => 'Extended Layout',
            'split' => 'Split Layout',
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

    public static function getPositionOptions(): array
    {
        return [
            'left' => 'Left',
            'center' => 'Center',
            'right' => 'Right',
            'top' => 'Top',
            'bottom' => 'Bottom',
            'hidden' => 'Hidden',
        ];
    }

    public function getDefaultQuickLinks(): array
    {
        return [
            ['text' => 'About Us', 'url' => '/about'],
            ['text' => 'Services', 'url' => '/services'],
            ['text' => 'Contact', 'url' => '/contact'],
            ['text' => 'Privacy Policy', 'url' => '/privacy'],
            ['text' => 'Terms of Service', 'url' => '/terms'],
        ];
    }

    public function getDefaultSocialLinks(): array
    {
        return [
            ['platform' => 'facebook', 'url' => '#', 'icon' => 'fab fa-facebook'],
            ['platform' => 'twitter', 'url' => '#', 'icon' => 'fab fa-twitter'],
            ['platform' => 'instagram', 'url' => '#', 'icon' => 'fab fa-instagram'],
            ['platform' => 'linkedin', 'url' => '#', 'icon' => 'fab fa-linkedin'],
        ];
    }

    public function generateCss(): string
    {
        $css = ".footer-config-{$this->id} {\n";
        $css .= "  background-color: {$this->background_color};\n";
        $css .= "  color: {$this->text_color};\n";
        $css .= "  font-family: '{$this->font_family}', sans-serif;\n";
        $css .= "  font-weight: {$this->font_weight};\n";
        $css .= "  font-size: {$this->font_size}px;\n";
        $css .= "  padding: {$this->padding_y}px {$this->padding_x}px;\n";
        $css .= "  border-top: {$this->border_width}px solid {$this->border_color};\n";
        if (($this->shadow ?? '') !== 'none') {
            $css .= "  box-shadow: 0 -1px 3px 0 rgba(0, 0, 0, 0.1);\n";
        }
        $css .= "}\n\n";

        if ($this->dark_mode_enabled && $this->dark_background_color) {
            $css .= ".dark .footer-config-{$this->id} {\n";
            $css .= "  background-color: {$this->dark_background_color};\n";
            $css .= "  color: {$this->dark_text_color};\n";
            $css .= "  border-top-color: {$this->dark_border_color};\n}\n\n";
            $css .= ".dark .footer-config-{$this->id} a { color: {$this->dark_text_color}; }\n";
            $css .= ".dark .footer-config-{$this->id} a:hover { color: {$this->dark_accent_color}; }\n";
            $css .= ".dark .footer-config-{$this->id} h3 { color: {$this->dark_text_color}; }\n";
            $css .= ".dark .footer-config-{$this->id} .newsletter-button { background-color: {$this->dark_accent_color}; color: white; }\n\n";
        }

        $css .= ".footer-config-{$this->id} a { color: {$this->text_color}; }\n";
        $css .= ".footer-config-{$this->id} a:hover { color: {$this->accent_color}; }\n";
        $css .= ".footer-config-{$this->id} h3 { color: {$this->text_color}; }\n";
        $css .= ".footer-config-{$this->id} .newsletter-button { background-color: {$this->accent_color}; color: white; }\n";

        if ($this->custom_css) {
            $css .= "\n/* Custom CSS */\n{$this->custom_css}\n";
        }

        return $css;
    }
}
