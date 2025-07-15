<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use LaraGrape\Models\TailwindConfig;

class TailwindConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default Tailwind configuration
        TailwindConfig::firstOrCreate(
            ['name' => 'Default Purple Theme'],
            [
                'description' => 'Default purple theme for LaraGrape with grape-inspired colors',
                'is_active' => true,
                'primary_50' => '#faf5ff',
                'primary_100' => '#f3e8ff',
                'primary_200' => '#e9d5ff',
                'primary_300' => '#d8b4fe',
                'primary_400' => '#c084fc',
                'primary_500' => '#a855f7',
                'primary_600' => '#9333ea',
                'primary_700' => '#7c3aed',
                'primary_800' => '#6b21a8',
                'primary_900' => '#581c87',
                'primary_950' => '#3b0764',
                'secondary_color' => '#64748b',
                'accent_color' => '#f59e0b',
                'success_color' => '#10b981',
                'warning_color' => '#f59e0b',
                'error_color' => '#ef4444',
                'info_color' => '#3b82f6',
                'font_family_sans' => 'Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif',
                'font_family_serif' => 'ui-serif, Georgia, Cambria, "Times New Roman", Times, serif',
                'font_family_mono' => 'ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace',
                'font_size_base' => '1rem',
                'line_height_base' => '1.5',
                'font_weight_base' => '400',
                'spacing_unit' => '0.25rem',
                'container_padding' => '1rem',
                'border_radius_default' => '0.375rem',
                'border_radius_lg' => '0.5rem',
                'breakpoint_sm' => '640px',
                'breakpoint_md' => '768px',
                'breakpoint_lg' => '1024px',
                'breakpoint_xl' => '1280px',
                'enable_custom_css' => false,
                'custom_css' => null,
                'enable_dark_mode' => false,
                'enable_animations' => true,
                'css_variables_prefix' => '--LaraGrape',
                'purge_css' => true,
                'minify_css' => true,
                'enable_custom_vars' => true,
            ]
        );

        // Create alternative theme
        TailwindConfig::firstOrCreate(
            ['name' => 'Ocean Blue Theme'],
            [
                'description' => 'Ocean blue theme with calming blue tones',
                'is_active' => false,
                'primary_50' => '#f0f9ff',
                'primary_100' => '#e0f2fe',
                'primary_200' => '#bae6fd',
                'primary_300' => '#7dd3fc',
                'primary_400' => '#38bdf8',
                'primary_500' => '#0ea5e9',
                'primary_600' => '#0284c7',
                'primary_700' => '#0369a1',
                'primary_800' => '#075985',
                'primary_900' => '#0c4a6e',
                'primary_950' => '#082f49',
                'secondary_color' => '#64748b',
                'accent_color' => '#f59e0b',
                'success_color' => '#10b981',
                'warning_color' => '#f59e0b',
                'error_color' => '#ef4444',
                'info_color' => '#3b82f6',
                'font_family_sans' => 'Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif',
                'font_family_serif' => 'ui-serif, Georgia, Cambria, "Times New Roman", Times, serif',
                'font_family_mono' => 'ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace',
                'font_size_base' => '1rem',
                'line_height_base' => '1.5',
                'font_weight_base' => '400',
                'spacing_unit' => '0.25rem',
                'container_padding' => '1rem',
                'border_radius_default' => '0.375rem',
                'border_radius_lg' => '0.5rem',
                'breakpoint_sm' => '640px',
                'breakpoint_md' => '768px',
                'breakpoint_lg' => '1024px',
                'breakpoint_xl' => '1280px',
                'enable_custom_css' => false,
                'custom_css' => null,
                'enable_dark_mode' => false,
                'enable_animations' => true,
                'css_variables_prefix' => '--LaraGrape',
                'purge_css' => true,
                'minify_css' => true,
                'enable_custom_vars' => true,
            ]
        );
    }
}
