<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::firstOrCreate([
            'slug' => 'home',
        ], [
                'title' => 'Home',
            'content' => '<h1>Welcome to the Home Page</h1>',
                'is_published' => true,
                'show_in_menu' => true,
                'sort_order' => 1,
        ]);
        Page::firstOrCreate([
            'slug' => 'about',
        ], [
            'title' => 'About Us',
            'content' => '<h1>About Our Company</h1>',
            'is_published' => true,
                'show_in_menu' => true,
                'sort_order' => 2,
        ]);
        Page::firstOrCreate([
            'slug' => 'contact',
        ], [
            'title' => 'Contact',
            'content' => '<h1>Contact Us</h1>',
            'is_published' => true,
            'show_in_menu' => true,
            'sort_order' => 3,
        ]);
        $this->command->info('Seeded example pages.');
    }
} 