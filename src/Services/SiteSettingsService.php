<?php

namespace Streats22\LaraGrape\Services;

use Streats22\LaraGrape\Models\SiteSettings;
use Illuminate\Support\Facades\Cache;

class SiteSettingsService
{
    protected array $settings = [];
    protected bool $loaded = false;

    public function __construct()
    {
        $this->loadSettings();
    }

    /**
     * Load all settings from database
     */
    protected function loadSettings(): void
    {
        if ($this->loaded) {
            return;
        }

        $this->settings = Cache::remember('site_settings_all', 3600, function () {
            return SiteSettings::orderBy('group')
                ->orderBy('sort_order')
                ->get()
                ->keyBy('key')
                ->map(function ($setting) {
                    return $setting->value;
                })
                ->toArray();
        });

        $this->loaded = true;
    }

    /**
     * Get a setting value
     */
    public function get(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Get all settings
     */
    public function all(): array
    {
        return $this->settings;
    }

    /**
     * Get header settings
     */
    public function getHeaderSettings(): array
    {
        return [
            'logo_text' => $this->get('header_logo_text', 'LaralGrape'),
            'logo_image' => $this->get('header_logo_image'),
            'background_color' => $this->get('header_background_color', '#ffffff'),
            'text_color' => $this->get('header_text_color', '#1f2937'),
            'sticky' => $this->get('header_sticky', true),
            'show_search' => $this->get('header_show_search', false),
            'custom_css' => $this->get('header_custom_css', ''),
        ];
    }

    /**
     * Get footer settings
     */
    public function getFooterSettings(): array
    {
        return [
            'logo_text' => $this->get('footer_logo_text', 'LaralGrape'),
            'logo_image' => $this->get('footer_logo_image'),
            'background_color' => $this->get('footer_background_color', '#1f2937'),
            'text_color' => $this->get('footer_text_color', '#ffffff'),
            'content' => $this->get('footer_content', '© 2024 LaralGrape. All rights reserved.'),
            'show_social' => $this->get('footer_show_social', true),
            'show_newsletter' => $this->get('footer_show_newsletter', false),
            'custom_css' => $this->get('footer_custom_css', ''),
        ];
    }

    /**
     * Get social media settings
     */
    public function getSocialSettings(): array
    {
        return [
            'facebook' => $this->get('social_facebook'),
            'twitter' => $this->get('social_twitter'),
            'instagram' => $this->get('social_instagram'),
            'linkedin' => $this->get('social_linkedin'),
            'youtube' => $this->get('social_youtube'),
            'github' => $this->get('social_github'),
        ];
    }

    /**
     * Get SEO settings
     */
    public function getSeoSettings(): array
    {
        return [
            'title' => $this->get('seo_title', 'LaralGrape - Web Development Boilerplate'),
            'keywords' => $this->get('seo_keywords', 'laravel, grapesjs, filament, web development'),
            'description' => $this->get('seo_description', 'A powerful web development boilerplate combining Laravel, GrapesJS, and Filament for building modern websites.'),
            'auto_generate' => $this->get('seo_auto_generate', true),
            'show_author' => $this->get('seo_show_author', false),
            'google_analytics_id' => $this->get('google_analytics_id'),
        ];
    }

    /**
     * Get general site settings
     */
    public function getGeneralSettings(): array
    {
        return [
            'site_name' => $this->get('site_name', 'LaralGrape'),
            'site_tagline' => $this->get('site_tagline', 'Laravel + GrapesJS + Filament'),
            'site_description' => $this->get('site_description', 'A powerful web development boilerplate combining Laravel, GrapesJS, and Filament for building modern websites.'),
            'contact_email' => $this->get('contact_email', 'contact@example.com'),
            'contact_phone' => $this->get('contact_phone', '+1 (555) 123-4567'),
            'address' => $this->get('address', '123 Main Street, City, State 12345'),
            'timezone' => $this->get('timezone', 'UTC'),
        ];
    }

    /**
     * Get advanced settings
     */
    public function getAdvancedSettings(): array
    {
        return [
            'enable_cache' => $this->get('enable_cache', true),
            'enable_debug' => $this->get('enable_debug', false),
            'custom_css' => $this->get('custom_css', ''),
            'custom_js' => $this->get('custom_js', ''),
        ];
    }

    /**
     * Generate header CSS
     */
    public function generateHeaderCss(): string
    {
        $header = $this->getHeaderSettings();
        $css = '';

        if ($header['background_color']) {
            $css .= ".site-header { background-color: {$header['background_color']}; }\n";
        }

        if ($header['text_color']) {
            $css .= ".site-header { color: {$header['text_color']}; }\n";
        }

        if ($header['sticky']) {
            $css .= ".site-header { position: sticky; top: 0; z-index: 50; }\n";
        }

        if ($header['custom_css']) {
            $css .= $header['custom_css'] . "\n";
        }

        return $css;
    }

    /**
     * Generate footer CSS
     */
    public function generateFooterCss(): string
    {
        $footer = $this->getFooterSettings();
        $css = '';

        if ($footer['background_color']) {
            $css .= ".site-footer { background-color: {$footer['background_color']}; }\n";
        }

        if ($footer['text_color']) {
            $css .= ".site-footer { color: {$footer['text_color']}; }\n";
        }

        if ($footer['custom_css']) {
            $css .= $footer['custom_css'] . "\n";
        }

        return $css;
    }

    /**
     * Generate global CSS
     */
    public function generateGlobalCss(): string
    {
        $advanced = $this->getAdvancedSettings();
        return $advanced['custom_css'] ?? '';
    }

    /**
     * Get all CSS for the site
     */
    public function getAllCss(): string
    {
        return $this->generateHeaderCss() . 
               $this->generateFooterCss() . 
               $this->generateGlobalCss();
    }

    /**
     * Clear settings cache
     */
    public function clearCache(): void
    {
        Cache::forget('site_settings_all');
        $this->loaded = false;
        $this->loadSettings();
    }
} 