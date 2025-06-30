<?php

namespace Streats22\LaraGrape\Models;

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
        'secondary_color',
        'accent_color',
        'success_color',
        'warning_color',
        'error_color',
        'info_color',
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
    public function generateCssVariables(): string
    {
        $variables = [];
        $prefix = $this->css_variables_prefix ?? '--laralgrape';

        // Primary colors
        $colors = ['50', '100', '200', '300', '400', '500', '600', '700', '800', '900', '950'];
        foreach ($colors as $shade) {
            $color = $this->{"primary_{$shade}"};
            if ($color) {
                $variables[] = "{$prefix}-primary-{$shade}: {$color};";
            }
        }

        // Additional colors
        $additionalColors = [
            'secondary' => $this->secondary_color,
            'accent' => $this->accent_color,
            'success' => $this->success_color,
            'warning' => $this->warning_color,
            'error' => $this->error_color,
            'info' => $this->info_color,
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
} 