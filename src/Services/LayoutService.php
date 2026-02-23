<?php

namespace LaraGrape\Services;

use LaraGrape\Models\FooterConfig;
use LaraGrape\Models\HeaderConfig;
use LaraGrape\Models\MenuSet;
use Illuminate\Support\Facades\Cache;

class LayoutService
{
    protected ?HeaderConfig $activeHeader = null;

    protected ?FooterConfig $activeFooter = null;

    public function __construct()
    {
        $this->loadActiveConfigurations();
    }

    protected function loadActiveConfigurations(): void
    {
        $this->activeHeader = Cache::remember('active_header_config', 3600, function () {
            return HeaderConfig::getActive();
        });

        $this->activeFooter = Cache::remember('active_footer_config', 3600, function () {
            return FooterConfig::getActive();
        });
    }

    public function getActiveHeader(): ?HeaderConfig
    {
        return $this->activeHeader;
    }

    public function getActiveFooter(): ?FooterConfig
    {
        return $this->activeFooter;
    }

    public function getHeaderById(int $id): ?HeaderConfig
    {
        return HeaderConfig::find($id);
    }

    public function getFooterById(int $id): ?FooterConfig
    {
        return FooterConfig::find($id);
    }

    public function getMenuItems(string $menuType): array
    {
        return Cache::remember("menu_items_{$menuType}", 3600, function () use ($menuType) {
            $menuSet = MenuSet::getActive($menuType);

            if (! $menuSet) {
                return [];
            }

            return $menuSet->getMenuStructure();
        });
    }

    public function getAllHeaders(): array
    {
        return Cache::remember('all_header_configs', 3600, function () {
            return HeaderConfig::orderBy('sort_order')->get()->toArray();
        });
    }

    public function getAllFooters(): array
    {
        return Cache::remember('all_footer_configs', 3600, function () {
            return FooterConfig::orderBy('sort_order')->get()->toArray();
        });
    }

    public function generateActiveCss(): string
    {
        $css = [];

        if ($this->activeHeader) {
            $css[] = $this->activeHeader->generateCss();
        }

        if ($this->activeFooter) {
            $css[] = $this->activeFooter->generateCss();
        }

        return implode("\n\n", $css);
    }

    public function generateCssForConfigs(?HeaderConfig $header = null, ?FooterConfig $footer = null): string
    {
        $css = [];

        if ($header) {
            $css[] = $header->generateCss();
        }

        if ($footer) {
            $css[] = $footer->generateCss();
        }

        return implode("\n\n", $css);
    }

    public function clearCache(): void
    {
        Cache::forget('active_header_config');
        Cache::forget('active_footer_config');
        Cache::forget('all_header_configs');
        Cache::forget('all_footer_configs');
        Cache::forget('menu_items_header');
        Cache::forget('menu_items_footer');
        Cache::forget('menu_items_custom');
    }

    public function getHeaderData(): array
    {
        $config = $this->getActiveHeader();

        if (! $config) {
            return [
                'config' => null,
                'background_color' => '#ffffff',
                'text_color' => '#1f2937',
                'accent_color' => '#3b82f6',
                'border_color' => '#e5e7eb',
                'border_width' => 1,
                'font_family' => 'Inter',
                'font_weight' => '500',
                'font_size' => 14,
                'padding_y' => 16,
                'padding_x' => 24,
                'menu_spacing' => 16,
                'logo_text' => 'LaraGrape',
                'logo_image' => null,
                'logo_size' => 32,
                'logo_position' => 'left',
                'is_sticky' => false,
                'is_transparent' => false,
                'show_search' => false,
                'show_cta_button' => false,
                'cta_text' => '',
                'cta_url' => '',
                'mobile_menu_enabled' => true,
                'mobile_menu_style' => 'hamburger',
                'mobile_breakpoint' => 'md',
                'menu_type' => 'normal',
                'layout' => 'standard',
                'shadow' => 'sm',
                'custom_css' => '',
                'dark_mode_enabled' => true,
                'dark_mode_style' => 'auto',
                'dark_background_color' => '#1f2937',
                'dark_text_color' => '#f9fafb',
                'dark_accent_color' => '#60a5fa',
                'dark_border_color' => '#374151',
            ];
        }

        return [
            'config' => $config,
            'background_color' => $config->background_color,
            'text_color' => $config->text_color,
            'accent_color' => $config->accent_color,
            'border_color' => $config->border_color,
            'border_width' => $config->border_width,
            'font_family' => $config->font_family,
            'font_weight' => $config->font_weight,
            'font_size' => $config->font_size,
            'padding_y' => $config->padding_y,
            'padding_x' => $config->padding_x,
            'menu_spacing' => $config->menu_spacing,
            'logo_text' => $config->logo_text,
            'logo_image' => $config->logo_image,
            'logo_size' => $config->logo_size,
            'logo_position' => $config->logo_position,
            'is_sticky' => $config->is_sticky,
            'is_transparent' => $config->is_transparent,
            'show_search' => $config->show_search,
            'show_cta_button' => $config->show_cta_button,
            'cta_text' => $config->cta_text,
            'cta_url' => $config->cta_url,
            'mobile_menu_enabled' => $config->mobile_menu_enabled,
            'mobile_menu_style' => $config->mobile_menu_style,
            'mobile_breakpoint' => $config->mobile_breakpoint,
            'menu_type' => $config->menu_type,
            'layout' => $config->layout,
            'shadow' => $config->shadow,
            'custom_css' => $config->custom_css,
            'dark_mode_enabled' => $config->dark_mode_enabled,
            'dark_mode_style' => $config->dark_mode_style,
            'dark_background_color' => $config->dark_background_color,
            'dark_text_color' => $config->dark_text_color,
            'dark_accent_color' => $config->dark_accent_color,
            'dark_border_color' => $config->dark_border_color,
        ];
    }

    public function getFooterData(): array
    {
        $config = $this->getActiveFooter();

        if (! $config) {
            return [
                'config' => null,
                'background_color' => '#1f2937',
                'text_color' => '#f9fafb',
                'accent_color' => '#3b82f6',
                'border_color' => '#374151',
                'border_width' => 1,
                'font_family' => 'Inter',
                'font_weight' => '400',
                'font_size' => 14,
                'padding_y' => 64,
                'padding_x' => 24,
                'section_spacing' => 32,
                'grid_columns_desktop' => 4,
                'grid_columns_tablet' => 2,
                'grid_columns_mobile' => 1,
                'logo_text' => 'LaraGrape',
                'logo_image' => null,
                'logo_size' => 32,
                'logo_position' => 'left',
                'layout' => 'standard',
                'show_brand_section' => true,
                'show_quick_links' => true,
                'show_social_links' => true,
                'show_newsletter' => false,
                'show_contact_info' => true,
                'show_copyright' => true,
                'brand_description' => 'Creating beautiful and functional websites.',
                'quick_links_title' => 'Quick Links',
                'quick_links' => [],
                'social_links_title' => 'Follow Us',
                'social_links' => [],
                'newsletter_title' => 'Subscribe to our newsletter',
                'newsletter_description' => 'Stay updated.',
                'newsletter_placeholder' => 'Enter your email',
                'newsletter_button_text' => 'Subscribe',
                'contact_title' => 'Contact Info',
                'contact_phone' => null,
                'contact_email' => null,
                'contact_address' => null,
                'copyright_text' => '© 2025 All rights reserved.',
                'show_powered_by' => true,
                'powered_by_text' => 'Powered by LaraGrape',
                'shadow' => 'sm',
                'custom_css' => '',
                'brand_position' => 'left',
                'social_position' => 'right',
                'menu_position' => 'center',
                'copyright_position' => 'bottom',
                'newsletter_position' => 'center',
                'contact_position' => 'right',
                'dark_mode_enabled' => true,
                'dark_mode_style' => 'auto',
                'dark_background_color' => '#111827',
                'dark_text_color' => '#f3f4f6',
                'dark_accent_color' => '#60a5fa',
                'dark_border_color' => '#1f2937',
            ];
        }

        return [
            'config' => $config,
            'background_color' => $config->background_color,
            'text_color' => $config->text_color,
            'accent_color' => $config->accent_color,
            'border_color' => $config->border_color,
            'border_width' => $config->border_width,
            'font_family' => $config->font_family,
            'font_weight' => $config->font_weight,
            'font_size' => $config->font_size,
            'padding_y' => $config->padding_y,
            'padding_x' => $config->padding_x,
            'section_spacing' => $config->section_spacing,
            'grid_columns_desktop' => $config->grid_columns_desktop,
            'grid_columns_tablet' => $config->grid_columns_tablet,
            'grid_columns_mobile' => $config->grid_columns_mobile,
            'logo_text' => $config->logo_text,
            'logo_image' => $config->logo_image,
            'logo_size' => $config->logo_size,
            'logo_position' => $config->logo_position,
            'layout' => $config->layout,
            'show_brand_section' => $config->show_brand_section,
            'show_quick_links' => $config->show_quick_links,
            'show_social_links' => $config->show_social_links,
            'show_newsletter' => $config->show_newsletter,
            'show_contact_info' => $config->show_contact_info,
            'show_copyright' => $config->show_copyright,
            'brand_description' => $config->brand_description,
            'brand_position' => $config->brand_position ?? 'left',
            'social_position' => $config->social_position ?? 'right',
            'menu_position' => $config->menu_position ?? 'center',
            'copyright_position' => $config->copyright_position ?? 'bottom',
            'newsletter_position' => $config->newsletter_position ?? 'center',
            'contact_position' => $config->contact_position ?? 'right',
            'quick_links_title' => $config->quick_links_title,
            'quick_links' => $config->quick_links ?? [],
            'social_links_title' => $config->social_links_title,
            'social_links' => $config->social_links ?? [],
            'newsletter_title' => $config->newsletter_title,
            'newsletter_description' => $config->newsletter_description,
            'newsletter_placeholder' => $config->newsletter_placeholder,
            'newsletter_button_text' => $config->newsletter_button_text,
            'contact_title' => $config->contact_title,
            'contact_phone' => $config->contact_phone,
            'contact_email' => $config->contact_email,
            'contact_address' => $config->contact_address,
            'copyright_text' => $config->copyright_text,
            'show_powered_by' => $config->show_powered_by,
            'powered_by_text' => $config->powered_by_text,
            'shadow' => $config->shadow,
            'custom_css' => $config->custom_css,
            'dark_mode_enabled' => $config->dark_mode_enabled,
            'dark_mode_style' => $config->dark_mode_style,
            'dark_background_color' => $config->dark_background_color,
            'dark_text_color' => $config->dark_text_color,
            'dark_accent_color' => $config->dark_accent_color,
            'dark_border_color' => $config->dark_border_color,
        ];
    }
}
