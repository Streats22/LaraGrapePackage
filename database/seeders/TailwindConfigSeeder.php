<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TailwindConfig;

class TailwindConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure at least one TailwindConfig exists and is active
        $active = TailwindConfig::where('is_active', true)->first();
        if (!$active) {
            $default = TailwindConfig::create([
                'name' => 'Default Purple Theme',
                'description' => 'Default purple theme for LaralGrape with grape-inspired colors',
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
                'custom_css' => '',
                'enable_dark_mode' => true,
                'dark_primary_50' => '#18181b', // main background
                'dark_primary_100' => '#232336', // card background
                'dark_primary_200' => '#27272a', // input background
                'dark_primary_300' => '#313244', // border/section background
                'dark_primary_400' => '#3f3f46', // subtle border
                'dark_primary_500' => '#a855f7', // accent purple
                'dark_primary_600' => '#7c3aed', // accent purple dark
                'dark_primary_700' => '#6d28d9', // accent purple darker
                'dark_primary_800' => '#581c87', // accent purple darkest
                'dark_primary_900' => '#3b0764', // almost black
                'dark_primary_950' => '#18181b', // fallback background
                'dark_secondary_color' => '#334155', // sidebar/nav
                'dark_accent_color' => '#f59e0b', // accent (yellow/orange)
                'dark_success_color' => '#22d3ee', // cyan for success
                'dark_warning_color' => '#fbbf24', // yellow for warning
                'dark_error_color' => '#ef4444', // red for error
                'dark_info_color' => '#60a5fa', // blue for info
                'dark_link_color' => '#8b5cf6', // purple for links
                'enable_animations' => true,
                'css_variables_prefix' => '--laralgrape',
                'purge_css' => true,
                'minify_css' => true,
            ]);
            $this->command->info('Default Tailwind config created and set as active.');
        } else {
            $this->command->info('Active Tailwind config already exists: ' . $active->name);
        }
        // Backfill missing dark mode values for existing configs
        $defaults = [
            'dark_primary_50' => '#18181b',
            'dark_primary_100' => '#232336',
            'dark_primary_200' => '#27272a',
            'dark_primary_300' => '#313244',
            'dark_primary_400' => '#3f3f46',
            'dark_primary_500' => '#a855f7',
            'dark_primary_600' => '#7c3aed',
            'dark_primary_700' => '#6d28d9',
            'dark_primary_800' => '#581c87',
            'dark_primary_900' => '#3b0764',
            'dark_primary_950' => '#18181b',
            'dark_secondary_color' => '#334155',
            'dark_accent_color' => '#f59e0b',
            'dark_success_color' => '#22d3ee',
            'dark_warning_color' => '#fbbf24',
            'dark_error_color' => '#ef4444',
            'dark_info_color' => '#60a5fa',
            'dark_link_color' => '#8b5cf6',
        ];
        foreach (TailwindConfig::all() as $config) {
            $updated = false;
            foreach ($defaults as $key => $value) {
                if (empty($config->$key)) {
                    $config->$key = $value;
                    $updated = true;
                }
            }
            if ($updated) {
                $config->save();
                $this->command->info('Backfilled dark mode values for: ' . $config->name);
            }
        }
        // Output the active config for test
        $active = TailwindConfig::where('is_active', true)->first();
        $this->command->info('Active TailwindConfig: ' . $active->name . ' | Primary 500: ' . $active->primary_500 . ' | Secondary: ' . $active->secondary_color);
    }
}
