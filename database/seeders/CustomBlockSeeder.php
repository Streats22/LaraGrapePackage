<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomBlock;

class CustomBlockSeeder extends Seeder
{
    public function run(): void
    {
        CustomBlock::firstOrCreate([
            'slug' => 'hero-block',
        ], [
            'name' => 'Hero Block',
            'description' => 'A large hero section with a call to action.',
            'category' => 'layouts',
            'html_content' => '<section><h1>Hero Title</h1><p>Hero description</p></section>',
            'css_content' => 'section { padding: 2rem; background: var(--laralgrape-primary-100, #f3e8ff); }',
            'js_content' => '',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        CustomBlock::firstOrCreate([
            'slug' => 'testimonial-block',
        ], [
            'name' => 'Testimonial Block',
            'description' => 'A block for customer testimonials.',
            'category' => 'content',
            'html_content' => '<blockquote>Great service!</blockquote>',
            'css_content' => 'blockquote { font-style: italic; color: var(--laralgrape-secondary, #64748b); }',
            'js_content' => '',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        $this->command->info('Seeded example custom blocks.');
    }
} 