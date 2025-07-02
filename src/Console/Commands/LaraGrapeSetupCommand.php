<?php

namespace LaraGrape\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class LaraGrapeSetupCommand extends Command
{
    protected $signature = 'laragrape:setup
        {--migrate : Run migrations after publishing}
        {--seed : Run seeders after publishing}
        {--force : Overwrite existing published files}
        {--publish-config : Only publish config}
        {--publish-views : Only publish views}
        {--publish-migrations : Only publish migrations}
        {--publish-seeders : Only publish seeders}
        {--all : Publish everything, migrate, and seed}';
    protected $description = 'Setup LaraGrape: publish config, views, migrations, and optionally run migrations';

    public function handle()
    {
        $this->info('Publishing LaraGrape config...');
        if ($this->option('publish-config') || $this->option('all')) {
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-config'
            ]);
        }

        $this->info('Publishing LaraGrape views...');
        if ($this->option('publish-views') || $this->option('all')) {
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-views'
            ]);
        }
        
  
        $this->info('Publishing LaraGrape migrations...');
        if ($this->option('publish-migrations') || $this->option('all')) {
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-migrations'
            ]);
        }

        if ($this->option('migrate')) {
            $this->info('Running migrations...');
            $this->call('migrate');
        }

        if ($this->confirm('Do you want to install the Filament admin panel now? (Recommended for first-time setup)', true)) {
            $this->info('Running Filament base install...');
            $this->call('filament:install');
            $this->info('Enabling Filament panels support...');
            $this->call('filament:install', [
                '--panels' => true,
            ]);
        } else {
            $this->warn('You must run "php artisan filament:install" and then "php artisan filament:install --panels" before using the admin panel.');
        }

        if ($this->option('all')) {
            $this->info('Publishing Filament resources...');
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-filament-resources',
                '--force' => $this->option('force'),
            ]);
            // Automatically update namespace and use statements in published resources
            $resourcesPath = base_path('app/Filament/Resources');
            if (is_dir($resourcesPath)) {
                // Top-level files
                foreach (glob($resourcesPath . '/*.php') as $filePath) {
                    $contents = file_get_contents($filePath);
                    $contents = str_replace('namespace LaraGrape\\Filament\\', 'namespace App\\Filament\\', $contents);
                    $contents = str_replace('namespace LaraGrape\\', 'namespace App\\', $contents);
                    $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                    file_put_contents($filePath, $contents);
                }
                // All subdirectories
                $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($resourcesPath));
                foreach ($rii as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php') {
                        $contents = file_get_contents($file->getPathname());
                        $contents = str_replace('namespace LaraGrape\\Filament\\', 'namespace App\\Filament\\', $contents);
                        $contents = str_replace('namespace LaraGrape\\', 'namespace App\\', $contents);
                        $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                        file_put_contents($file->getPathname(), $contents);
                    }
                }
            }
            $this->info('Publishing Filament pages...');
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-filament-pages',
                '--force' => $this->option('force'),
            ]);
            // Automatically update namespace and use statements in published pages
            $pagesPath = base_path('app/Filament/Pages');
            if (is_dir($pagesPath)) {
                $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($pagesPath));
                foreach ($rii as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php') {
                        $contents = file_get_contents($file->getPathname());
                        $contents = str_replace('namespace LaraGrape\\Filament\\', 'namespace App\\Filament\\', $contents);
                        $contents = str_replace('namespace LaraGrape\\', 'namespace App\\', $contents);
                        $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                        file_put_contents($file->getPathname(), $contents);
                    }
                }
            }
            $this->info('Publishing Filament blocks...');
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-filament-blocks',
                '--force' => $this->option('force'),
            ]);
            // Automatically update namespace and use statements in published blocks (if any PHP files)
            $blocksPath = base_path('resources/views/components/blocks');
            if (is_dir($blocksPath)) {
                $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($blocksPath));
                foreach ($rii as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php') {
                        $contents = file_get_contents($file->getPathname());
                        $contents = str_replace('namespace LaraGrape\\Filament\\', 'namespace App\\Filament\\', $contents);
                        $contents = str_replace('namespace LaraGrape\\', 'namespace App\\', $contents);
                        $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                        file_put_contents($file->getPathname(), $contents);
                    }
                }
            }
            $this->info('Publishing frontend layout components...');
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-frontend-layout',
                '--force' => $this->option('force'),
            ]);
            // Automatically update namespace and use statements in published frontend layout (if any PHP files)
            $layoutPath = base_path('resources/views/components/layout');
            if (is_dir($layoutPath)) {
                $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($layoutPath));
                foreach ($rii as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php') {
                        $contents = file_get_contents($file->getPathname());
                        $contents = str_replace('namespace LaraGrape\\Filament\\', 'namespace App\\Filament\\', $contents);
                        $contents = str_replace('namespace LaraGrape\\', 'namespace App\\', $contents);
                        $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                        file_put_contents($file->getPathname(), $contents);
                    }
                }
            }
            $adminPanelProviderPath = base_path('app/Filament/AdminPanelProvider.php');
            if (file_exists($adminPanelProviderPath)) {
                $contents = file_get_contents($adminPanelProviderPath);
                // Replace all LaraGrape\Filament\Resources with App\Filament\Resources
                $contents = str_replace('LaraGrape\\Filament\\Resources\\', 'App\\Filament\\Resources\\', $contents);
                $contents = str_replace('LaraGrape\\Filament\\Pages\\', 'App\\Filament\\Pages\\', $contents);
                // Remove any remaining LaraGrape\ references in ->resources() and ->pages()
                $contents = preg_replace('/,?\s*\\LaraGrape\\[^,\)]+/', '', $contents);
                file_put_contents($adminPanelProviderPath, $contents);
            }
            $this->info('Publishing Filament forms...');
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-filament-forms',
                '--force' => $this->option('force'),
            ]);
            // Automatically update namespace and use statements in published forms
            $formsPath = base_path('app/Filament/Forms');
            if (is_dir($formsPath)) {
                $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($formsPath));
                foreach ($rii as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php') {
                        $contents = file_get_contents($file->getPathname());
                        $contents = str_replace('namespace LaraGrape\\Filament\\', 'namespace App\\Filament\\', $contents);
                        $contents = str_replace('namespace LaraGrape\\', 'namespace App\\', $contents);
                        $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                        file_put_contents($file->getPathname(), $contents);
                    }
                }
            }
            $this->info('Publishing Filament resources...');
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-filament-resources',
                '--force' => $this->option('force'),
            ]);
            // Remove any remaining LaraGrape\ references in all published PHP files (resources, pages, forms, provider)
            $pathsToClean = [
                base_path('app/Filament/Resources'),
                base_path('app/Filament/Pages'),
                base_path('app/Filament/Forms'),
                base_path('app/Filament/AdminPanelProvider.php'),
            ];
            foreach ($pathsToClean as $path) {
                if (is_dir($path)) {
                    $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
                    foreach ($rii as $file) {
                        if ($file->isFile() && $file->getExtension() === 'php') {
                            $contents = file_get_contents($file->getPathname());
                            $contents = str_replace('LaraGrape\\Filament\\Resources\\', 'App\\Filament\\Resources\\', $contents);
                            $contents = str_replace('LaraGrape\\Filament\\Pages\\', 'App\\Filament\\Pages\\', $contents);
                            $contents = str_replace('LaraGrape\\Filament\\', 'App\\Filament\\', $contents);
                            $contents = str_replace('LaraGrape\\', 'App\\', $contents);
                            $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                            // Remove any remaining LaraGrape\ references in ->resources() and ->pages()
                            $contents = preg_replace('/,?\s*\\LaraGrape\\[^,\)]+/', '', $contents);
                            file_put_contents($file->getPathname(), $contents);
                        }
                    }
                } elseif (is_file($path)) {
                    $contents = file_get_contents($path);
                    $contents = str_replace('LaraGrape\\Filament\\Resources\\', 'App\\Filament\\Resources\\', $contents);
                    $contents = str_replace('LaraGrape\\Filament\\Pages\\', 'App\\Filament\\Pages\\', $contents);
                    $contents = str_replace('LaraGrape\\Filament\\', 'App\\Filament\\', $contents);
                    $contents = str_replace('LaraGrape\\', 'App\\', $contents);
                    $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                    $contents = preg_replace('/,?\s*\\LaraGrape\\[^,\)]+/', '', $contents);
                    file_put_contents($path, $contents);
                }
            }
            $this->info('Publishing custom welcome.blade.php...');
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-welcome',
                '--force' => $this->option('force'),
            ]);
        }

        $this->info('LaraGrape setup complete!');
        $this->info('Re-running php artisan laragrape:setup --all to ensure everything is published and up to date...');
        \Artisan::call('laragrape:setup', ['--all' => true, '--force' => true]);
        $this->info('Final publish complete. Your LaraGrape setup is fully up to date.');
    }
} 