<?php

namespace LaraGrape\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TailwindConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'primary_50',
        'primary_100',
        'primary_200',
        'primary_300',
        'primary_400',
        'primary_500',
        'primary_600',
        'primary_700',
        'primary_800',
        'primary_900',
        'primary_950',
        // Dark mode color fields
        'dark_primary_50',
        'dark_primary_100',
        'dark_primary_200',
        'dark_primary_300',
        'dark_primary_400',
        'dark_primary_500',
        'dark_primary_600',
        'dark_primary_700',
        'dark_primary_800',
        'dark_primary_900',
        'dark_primary_950',
        'dark_secondary_color',
        'dark_accent_color',
        'dark_success_color',
        'dark_warning_color',
        'dark_error_color',
        'dark_info_color',
        'dark_link_color',
        'secondary_color',
        'accent_color',
        'success_color',
        'warning_color',
        'error_color',
        'info_color',
        'link_color',
        'font_family_sans',
        'font_family_serif',
        'font_family_mono',
        'font_size_base',
        'line_height_base',
        'font_weight_base',
        'spacing_unit',
        'container_padding',
        'border_radius_default',
        'border_radius_lg',
        'breakpoint_sm',
        'breakpoint_md',
        'breakpoint_lg',
        'breakpoint_xl',
        'enable_custom_css',
        'custom_css',
        'enable_dark_mode',
        'enable_animations',
        'css_variables_prefix',
        'purge_css',
        'minify_css',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'enable_custom_css' => 'boolean',
        'enable_dark_mode' => 'boolean',
        'enable_animations' => 'boolean',
        'purge_css' => 'boolean',
        'minify_css' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // When a config is saved as active, deactivate others
        static::saving(function ($config) {
            if ($config->is_active) {
                static::where('id', '!=', $config->id)
                    ->update(['is_active' => false]);
            }
        });
    }

    /**
     * Get the active configuration
     */
    public static function getActive(): ?self
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Generate CSS variables from configuration
     */
    public function generateCssVariables(bool $dark = false): string
    {
        $variables = [];
        $prefix = $this->css_variables_prefix ?? '--laralgrape';

        // Primary colors
        $colors = ['50', '100', '200', '300', '400', '500', '600', '700', '800', '900', '950'];
        foreach ($colors as $shade) {
            $color = $dark ? $this->{"dark_primary_{$shade}"} : $this->{"primary_{$shade}"};
            if ($color) {
                $variables[] = "{$prefix}-primary-{$shade}: {$color};";
            }
        }

        // Additional colors
        $additionalColors = [
            'secondary' => $dark ? $this->dark_secondary_color : $this->secondary_color,
            'accent' => $dark ? $this->dark_accent_color : $this->accent_color,
            'success' => $dark ? $this->dark_success_color : $this->success_color,
            'warning' => $dark ? $this->dark_warning_color : $this->warning_color,
            'error' => $dark ? $this->dark_error_color : $this->error_color,
            'info' => $dark ? $this->dark_info_color : $this->info_color,
            'link' => $dark ? $this->dark_link_color : $this->link_color,
        ];
        foreach ($additionalColors as $name => $color) {
            if ($color) {
                $variables[] = "{$prefix}-{$name}: {$color};";
            }
        }

        // Typography
        if ($this->font_family_sans) {
            $variables[] = "{$prefix}-font-sans: {$this->font_family_sans};";
        }
        if ($this->font_family_serif) {
            $variables[] = "{$prefix}-font-serif: {$this->font_family_serif};";
        }
        if ($this->font_family_mono) {
            $variables[] = "{$prefix}-font-mono: {$this->font_family_mono};";
        }

        // Spacing and layout
        if ($this->spacing_unit) {
            $variables[] = "{$prefix}-spacing-unit: {$this->spacing_unit};";
        }
        if ($this->container_padding) {
            $variables[] = "{$prefix}-container-padding: {$this->container_padding};";
        }
        if ($this->border_radius_default) {
            $variables[] = "{$prefix}-border-radius: {$this->border_radius_default};";
        }
        if ($this->border_radius_lg) {
            $variables[] = "{$prefix}-border-radius-lg: {$this->border_radius_lg};";
        }

        return implode("\n    ", $variables);
    }

    /**
     * Generate complete CSS output
     */
    public function generateCss(): string
    {
        $css = ":root {\n    " . $this->generateCssVariables() . "\n}\n\n";
        if ($this->enable_dark_mode) {
            $darkVars = $this->generateCssVariables(true);
            if (trim($darkVars)) {
                $css .= ".dark {\n    $darkVars\n}\n\n";
            }
        }
        if ($this->enable_custom_css && $this->custom_css) {
            $css .= "/* Custom CSS */\n" . $this->custom_css . "\n\n";
        }
        return $css;
    }

    /**
     * Generate Tailwind config object
     */
    public function generateTailwindConfig(): array
    {
        $config = [
            'theme' => [
                'extend' => [
                    'colors' => [
                        'primary' => [
                            '50' => "var(--{$this->css_variables_prefix}-primary-50)",
                            '100' => "var(--{$this->css_variables_prefix}-primary-100)",
                            '200' => "var(--{$this->css_variables_prefix}-primary-200)",
                            '300' => "var(--{$this->css_variables_prefix}-primary-300)",
                            '400' => "var(--{$this->css_variables_prefix}-primary-400)",
                            '500' => "var(--{$this->css_variables_prefix}-primary-500)",
                            '600' => "var(--{$this->css_variables_prefix}-primary-600)",
                            '700' => "var(--{$this->css_variables_prefix}-primary-700)",
                            '800' => "var(--{$this->css_variables_prefix}-primary-800)",
                            '900' => "var(--{$this->css_variables_prefix}-primary-900)",
                            '950' => "var(--{$this->css_variables_prefix}-primary-950)",
                        ],
                    ],
                    'fontFamily' => [
                        'sans' => ["var(--{$this->css_variables_prefix}-font-sans)"],
                        'serif' => ["var(--{$this->css_variables_prefix}-font-serif)"],
                        'mono' => ["var(--{$this->css_variables_prefix}-font-mono)"],
                    ],
                    'borderRadius' => [
                        'DEFAULT' => "var(--{$this->css_variables_prefix}-border-radius)",
                        'lg' => "var(--{$this->css_variables_prefix}-border-radius-lg)",
                    ],
                ],
            ],
        ];

        if ($this->enable_animations) {
            $config['theme']['extend']['animation'] = [
                'fade-in' => 'fadeIn 0.5s ease-in-out',
                'slide-up' => 'slideUp 0.3s ease-out',
                'bounce-in' => 'bounceIn 0.6s ease-out',
            ];
        }

        return $config;
    }

    /**
     * Generate utility classes for all themeable properties using CSS variables.
     * Example: .bg-primary-500 { background-color: var(--laralgrape-primary-500); }
     */
    public function generateUtilityClassesCss(): string
    {
        $prefix = $this->css_variables_prefix ?? '--laralgrape';
        $shades = ['50', '100', '200', '300', '400', '500', '600', '700', '800', '900', '950'];
        $utilityCss = [];

        // Background, text, and border color utilities for primary shades
        foreach ($shades as $shade) {
            $var = $prefix . "-primary-{$shade}";
            $utilityCss[] = ".bg-primary-{$shade} { background-color: var({$var}) !important; }";
            $utilityCss[] = ".text-primary-{$shade} { color: var({$var}) !important; }";
            $utilityCss[] = ".border-primary-{$shade} { border-color: var({$var}) !important; }";
        }

        // Additional color variables
        $additional = ['secondary', 'accent', 'success', 'warning', 'error', 'info', 'link'];
        foreach ($additional as $name) {
            $var = $prefix . "-{$name}";
            $utilityCss[] = ".bg-{$name} { background-color: var({$var}) !important; }";
            $utilityCss[] = ".text-{$name} { color: var({$var}) !important; }";
            $utilityCss[] = ".border-{$name} { border-color: var({$var}) !important; }";
        }

        // Border radius utilities
        if ($this->border_radius_default) {
            $utilityCss[] = ".rounded { border-radius: var({$prefix}-border-radius) !important; }";
        }
        if ($this->border_radius_lg) {
            $utilityCss[] = ".rounded-lg { border-radius: var({$prefix}-border-radius-lg) !important; }";
        }

        // Font family utilities
        $utilityCss[] = ".font-sans { font-family: var({$prefix}-font-sans) !important; }";
        $utilityCss[] = ".font-serif { font-family: var({$prefix}-font-serif) !important; }";
        $utilityCss[] = ".font-mono { font-family: var({$prefix}-font-mono) !important; }";

        return implode("\n", $utilityCss) . "\n";
    }

    /**
     * Generate dynamic themeable CSS for site.css
     */
    public function generateSiteThemeCss(): string
    {
        $prefix = $this->css_variables_prefix ?? '--laralgrape';
        $css = <<<CSS
/* Dynamic themeable rules for site.css */
:root {
    /* Example: focus outline color */
    --site-focus-outline: var({$prefix}-primary-500);
    --site-link: var({$prefix}-link);
}

a, a:link {
    color: var(--site-link, #3b82f6);
    text-decoration: underline;
}
a:hover, a:focus {
    color: var(--site-link, #2563eb);
    text-decoration: underline;
}

button:focus,
a:focus,
input:focus,
textarea:focus {
    outline: 2px solid var({$prefix}-primary-500);
    outline-offset: 2px;
}
CSS;
        if ($this->enable_dark_mode) {
            $darkVars = $this->generateCssVariables(true);
            if (trim($darkVars)) {
                $css .= "\n.dark {\n    $darkVars\n}\n";
            }
        }
        return $css;
    }

    /**
     * Generate dynamic themeable CSS for admin/theme.css
     */
    public function generateAdminThemeCss(): string
    {
        $prefix = $this->css_variables_prefix ?? '--laralgrape';
        $css = <<<CSS
/* Dynamic themeable rules for admin/theme.css */
.fi-sidebar {
    background: linear-gradient(135deg, var({$prefix}-primary-600), var({$prefix}-primary-700));
}
.fi-btn-primary {
    background: linear-gradient(135deg, var({$prefix}-primary-500), var({$prefix}-primary-600));
}
.fi-btn-primary:hover {
    background: linear-gradient(135deg, var({$prefix}-primary-600), var({$prefix}-primary-700));
}
.fi-tabs-tab.is-active {
    background: var({$prefix}-primary-500);
    color: white;
    box-shadow: 0 4px 12px rgba(168, 85, 247, 0.3);
}
CSS;
        if ($this->enable_dark_mode) {
            $darkVars = $this->generateCssVariables(true);
            if (trim($darkVars)) {
                $css .= "\n.dark {\n    $darkVars\n}\n";
            }
        }
        return $css;
    }
}
