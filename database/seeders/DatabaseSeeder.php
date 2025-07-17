<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TailwindConfig;
use App\Models\Page;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // Call the improved TailwindConfigSeeder
        $this->call([
            \Database\Seeders\TailwindConfigSeeder::class,
            \Database\Seeders\PageSeeder::class,
            \Database\Seeders\CustomBlockSeeder::class,
            \Database\Seeders\SiteSettingsSeeder::class,
        ]);

        // Seed default pages
        $page = Page::firstOrCreate(
            ['slug' => 'home'],
            [
                // ...attributes...
            ]
        );

        if (!$page->wasRecentlyCreated) {
            $this->command->info('Page "home" already exists, skipping.');
        } else {
            $this->command->info('Page "home" created.');
        }

        // Log all users for verification
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $this->command->info('User: ' . $user->name . ' | ' . $user->email);
        }
    }
}
