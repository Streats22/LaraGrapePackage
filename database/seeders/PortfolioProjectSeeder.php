<?php

namespace Database\Seeders;

use App\Models\PortfolioProject;
use Illuminate\Database\Seeder;

class PortfolioProjectSeeder extends Seeder
{
    public function run(): void
    {
        if (! config('laragrape.portfolio_enabled', false)) {
            return;
        }

        $samples = [
            [
                'slug' => 'brand-refresh',
                'title' => 'Brand Refresh',
                'excerpt' => 'Identity, design system, and marketing site for a growing SaaS team.',
                'tags' => ['Branding', 'Web', 'UI'],
                'sort_order' => 1,
            ],
            [
                'slug' => 'commerce-rebuild',
                'title' => 'Commerce Rebuild',
                'excerpt' => 'Headless storefront with Laravel, Livewire, and a GrapesJS-driven CMS.',
                'tags' => ['Laravel', 'E-commerce', 'CMS'],
                'sort_order' => 2,
            ],
            [
                'slug' => 'editorial-platform',
                'title' => 'Editorial Platform',
                'excerpt' => 'Publishing workflow and block-based layouts for a media collective.',
                'tags' => ['Content', 'Filament', 'Design'],
                'sort_order' => 3,
            ],
        ];

        foreach ($samples as $data) {
            PortfolioProject::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'tags' => $data['tags'],
                    'sort_order' => $data['sort_order'],
                    'is_published' => true,
                    'published_at' => now(),
                ]
            );
        }

        $this->command?->info('Seeded example portfolio projects.');
    }
}
