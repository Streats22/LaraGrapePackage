<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSettings;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        SiteSettings::firstOrCreate([
            'key' => 'site_name',
        ], [
            'label' => 'Site Name',
            'value' => 'LaraGrape Demo',
            'type' => 'text',
            'group' => 'general',
            'description' => 'The name of the website.',
            'sort_order' => 1,
        ]);
        SiteSettings::firstOrCreate([
            'key' => 'header_logo',
        ], [
            'label' => 'Header Logo',
            'value' => '/images/logo.png',
            'type' => 'image',
            'group' => 'header',
            'description' => 'Logo for the header.',
            'sort_order' => 1,
        ]);
        SiteSettings::firstOrCreate([
            'key' => 'footer_text',
        ], [
            'label' => 'Footer Text',
            'value' => '© 2024 LaraGrape. All rights reserved.',
            'type' => 'text',
            'group' => 'footer',
            'description' => 'Text for the footer.',
            'sort_order' => 1,
        ]);
        SiteSettings::firstOrCreate([
            'key' => 'seo_description',
        ], [
            'label' => 'SEO Description',
            'value' => 'LaraGrape is a modern block builder for Laravel.',
            'type' => 'text',
            'group' => 'seo',
            'description' => 'SEO meta description.',
            'sort_order' => 1,
        ]);
        SiteSettings::firstOrCreate([
            'key' => 'twitter_handle',
        ], [
            'label' => 'Twitter Handle',
            'value' => '@laragrape',
            'type' => 'text',
            'group' => 'social',
            'description' => 'Twitter username.',
            'sort_order' => 1,
        ]);
        SiteSettings::firstOrCreate([
            'key' => 'editor_block_preview_tooltips',
        ], [
            'label' => 'Block preview tooltips',
            'value' => config('laragrape.editor.block_preview_tooltips', true),
            'type' => 'boolean',
            'group' => 'editor',
            'description' => 'Show hover popovers with block description and styled preview in the GrapesJS block panel.',
            'sort_order' => 1,
        ]);
        $this->command->info('Seeded example site settings.');
    }
}
