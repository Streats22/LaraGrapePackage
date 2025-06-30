<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Streats22\LaraGrape\Models\SiteSettings;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'LaralGrape', 'type' => 'text', 'group' => 'general', 'label' => 'Site Name', 'description' => 'The name of your website', 'sort_order' => 1],
            ['key' => 'site_tagline', 'value' => 'Laravel + GrapesJS + Filament', 'type' => 'text', 'group' => 'general', 'label' => 'Site Tagline', 'description' => 'A short description of your site', 'sort_order' => 2],
            ['key' => 'site_description', 'value' => 'A powerful web development boilerplate combining Laravel, GrapesJS, and Filament for building modern websites.', 'type' => 'textarea', 'group' => 'general', 'label' => 'Site Description', 'description' => 'Detailed description for SEO', 'sort_order' => 3],
            ['key' => 'contact_email', 'value' => 'contact@example.com', 'type' => 'text', 'group' => 'general', 'label' => 'Contact Email', 'description' => 'Primary contact email', 'sort_order' => 4],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group' => 'general', 'label' => 'Contact Phone', 'description' => 'Primary contact phone', 'sort_order' => 5],
            ['key' => 'address', 'value' => '123 Main Street, City, State 12345', 'type' => 'text', 'group' => 'general', 'label' => 'Address', 'description' => 'Business address', 'sort_order' => 6],
            ['key' => 'timezone', 'value' => 'UTC', 'type' => 'text', 'group' => 'general', 'label' => 'Timezone', 'description' => 'Server timezone', 'sort_order' => 7],

            // Header Settings
            ['key' => 'header_logo_text', 'value' => 'LaralGrape', 'type' => 'text', 'group' => 'header', 'label' => 'Logo Text', 'description' => 'Text to display as logo', 'sort_order' => 1],
            ['key' => 'header_background_color', 'value' => '#ffffff', 'type' => 'color', 'group' => 'header', 'label' => 'Background Color', 'description' => 'Header background color', 'sort_order' => 2],
            ['key' => 'header_text_color', 'value' => '#1f2937', 'type' => 'color', 'group' => 'header', 'label' => 'Text Color', 'description' => 'Header text color', 'sort_order' => 3],
            ['key' => 'header_sticky', 'value' => true, 'type' => 'boolean', 'group' => 'header', 'label' => 'Sticky Header', 'description' => 'Keep header fixed at top', 'sort_order' => 4],
            ['key' => 'header_show_search', 'value' => false, 'type' => 'boolean', 'group' => 'header', 'label' => 'Show Search', 'description' => 'Display search bar in header', 'sort_order' => 5],
            ['key' => 'header_custom_css', 'value' => '/* Custom header styles */', 'type' => 'textarea', 'group' => 'header', 'label' => 'Custom Header CSS', 'description' => 'Custom CSS for header styling', 'sort_order' => 6],

            // Footer Settings
            ['key' => 'footer_logo_text', 'value' => 'LaralGrape', 'type' => 'text', 'group' => 'footer', 'label' => 'Footer Logo Text', 'description' => 'Text to display in footer', 'sort_order' => 1],
            ['key' => 'footer_background_color', 'value' => '#1f2937', 'type' => 'color', 'group' => 'footer', 'label' => 'Background Color', 'description' => 'Footer background color', 'sort_order' => 2],
            ['key' => 'footer_text_color', 'value' => '#ffffff', 'type' => 'color', 'group' => 'footer', 'label' => 'Text Color', 'description' => 'Footer text color', 'sort_order' => 3],
            ['key' => 'footer_content', 'value' => '© 2024 LaralGrape. All rights reserved.', 'type' => 'textarea', 'group' => 'footer', 'label' => 'Footer Content', 'description' => 'Main footer content (supports HTML)', 'sort_order' => 4],
            ['key' => 'footer_show_social', 'value' => true, 'type' => 'boolean', 'group' => 'footer', 'label' => 'Show Social Links', 'description' => 'Display social media links', 'sort_order' => 5],
            ['key' => 'footer_show_newsletter', 'value' => false, 'type' => 'boolean', 'group' => 'footer', 'label' => 'Show Newsletter Signup', 'description' => 'Display newsletter subscription form', 'sort_order' => 6],
            ['key' => 'footer_custom_css', 'value' => '/* Custom footer styles */', 'type' => 'textarea', 'group' => 'footer', 'label' => 'Custom Footer CSS', 'description' => 'Custom CSS for footer styling', 'sort_order' => 7],

            // SEO Settings
            ['key' => 'seo_title', 'value' => 'LaralGrape - Web Development Boilerplate', 'type' => 'text', 'group' => 'seo', 'label' => 'Default Page Title', 'description' => 'Default title for pages without custom title', 'sort_order' => 1],
            ['key' => 'seo_keywords', 'value' => 'laravel, grapesjs, filament, web development', 'type' => 'text', 'group' => 'seo', 'label' => 'Default Keywords', 'description' => 'Comma-separated keywords', 'sort_order' => 2],
            ['key' => 'seo_description', 'value' => 'A powerful web development boilerplate combining Laravel, GrapesJS, and Filament for building modern websites.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Default Meta Description', 'description' => 'Default meta description for pages', 'sort_order' => 3],
            ['key' => 'seo_auto_generate', 'value' => true, 'type' => 'boolean', 'group' => 'seo', 'label' => 'Auto-generate Meta Tags', 'description' => 'Automatically generate meta tags from content', 'sort_order' => 4],
            ['key' => 'seo_show_author', 'value' => false, 'type' => 'boolean', 'group' => 'seo', 'label' => 'Show Author Meta', 'description' => 'Include author meta tags', 'sort_order' => 5],
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text', 'group' => 'seo', 'label' => 'Google Analytics ID', 'description' => 'Google Analytics tracking ID', 'sort_order' => 6],

            // Social Media Settings
            ['key' => 'social_facebook', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Facebook URL', 'description' => 'Facebook page URL', 'sort_order' => 1],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Twitter/X URL', 'description' => 'Twitter/X profile URL', 'sort_order' => 2],
            ['key' => 'social_instagram', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'Instagram URL', 'description' => 'Instagram profile URL', 'sort_order' => 3],
            ['key' => 'social_linkedin', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'LinkedIn URL', 'description' => 'LinkedIn profile/company URL', 'sort_order' => 4],
            ['key' => 'social_youtube', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'YouTube URL', 'description' => 'YouTube channel URL', 'sort_order' => 5],
            ['key' => 'social_github', 'value' => '', 'type' => 'text', 'group' => 'social', 'label' => 'GitHub URL', 'description' => 'GitHub profile URL', 'sort_order' => 6],

            // Advanced Settings
            ['key' => 'enable_cache', 'value' => true, 'type' => 'boolean', 'group' => 'advanced', 'label' => 'Enable Caching', 'description' => 'Enable site-wide caching', 'sort_order' => 1],
            ['key' => 'enable_debug', 'value' => false, 'type' => 'boolean', 'group' => 'advanced', 'label' => 'Enable Debug Mode', 'description' => 'Show debug information', 'sort_order' => 2],
            ['key' => 'custom_css', 'value' => '/* Global custom styles */', 'type' => 'textarea', 'group' => 'advanced', 'label' => 'Global Custom CSS', 'description' => 'CSS that will be applied site-wide', 'sort_order' => 3],
            ['key' => 'custom_js', 'value' => '// Global custom JavaScript', 'type' => 'textarea', 'group' => 'advanced', 'label' => 'Global Custom JavaScript', 'description' => 'JavaScript that will run on all pages', 'sort_order' => 4],
        ];

        foreach ($settings as $setting) {
            SiteSettings::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
