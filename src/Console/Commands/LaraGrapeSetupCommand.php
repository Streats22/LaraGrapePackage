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
        // 1. Filament install (if confirmed)
        if (!$this->option('all')) {
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
        }

        // Publish models
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-models',
            '--force' => true,
        ]);

        // 2. Publish all resources (always, in correct order)
        $force = $this->option('all') ? true : $this->option('force');
        $publishTags = [
            'LaraGrape-config',
            'LaraGrape-views',
            'LaraGrape-migrations',
            'LaraGrape-filament-resources',
            'LaraGrape-filament-pages',
            'LaraGrape-filament-blocks',
            'LaraGrape-frontend-layout',
            'LaraGrape-filament-forms',
            'LaraGrape-controllers',
            'laragrape-seeders',
        ];
        foreach ($publishTags as $tag) {
            $this->info("Publishing $tag...");
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => $tag,
                '--force' => $force,
            ]);
        }
        // Publish CSS assets (site.css, app.css, filament-grapesjs-editor.css)
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-css',
            '--force' => true,
        ]);
        
        // Publish utilities CSS file for GrapesJS
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-utilities-css',
            '--force' => true,
        ]);
        // Publish PHP service/command files
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-commands',
            '--force' => true,
        ]);
        // Publish web.php (always force)
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-web',
            '--force' => true,
        ]);
        // Always force overwrite for welcome (must be last to ensure it wins)
        $this->info('Publishing LaraGrape-welcome (always forced, latest version)...');
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-welcome',
            '--force' => true,
        ]);
        // Direct copy fallback for welcome.blade.php
        $packageWelcome = __DIR__ . '/../../../resources/views/welcome.blade.php';
        $appWelcome = base_path('resources/views/welcome.blade.php');
        if (file_exists($packageWelcome)) {
            copy($packageWelcome, $appWelcome);
            $this->info('welcome.blade.php was directly copied to ensure it is overwritten.');
        }

        // 3. Post-process all published files (namespace/use/class renaming, file renaming)
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
                    if (file_exists($filePath)) {
                        $contents = file_get_contents($filePath);
                        $contents = str_replace('namespace LaraGrape\\Filament\\', 'namespace App\\Filament\\', $contents);
                        $contents = str_replace('namespace LaraGrape\\', 'namespace App\\', $contents);
                        $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                        file_put_contents($filePath, $contents);
                    }
                }
                // All subdirectories
                $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($resourcesPath));
                foreach ($rii as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php' && file_exists($file->getPathname())) {
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
                    if ($file->isFile() && $file->getExtension() === 'php' && file_exists($file->getPathname())) {
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
                    if ($file->isFile() && $file->getExtension() === 'php' && file_exists($file->getPathname())) {
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
                    if ($file->isFile() && $file->getExtension() === 'php' && file_exists($file->getPathname())) {
                        $contents = file_get_contents($file->getPathname());
                        $contents = str_replace('namespace LaraGrape\\Filament\\', 'namespace App\\Filament\\', $contents);
                        $contents = str_replace('namespace LaraGrape\\', 'namespace App\\', $contents);
                        $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                        file_put_contents($file->getPathname(), $contents);
                    }
                }
            }
            // Enhance AdminPanelProvider overwriting (already there, but add force)
            $adminPanelProviderPath = base_path('app/Providers/Filament/AdminPanelProvider.php');
            if (file_exists($adminPanelProviderPath) || $force) {
                $this->info('Overwriting AdminPanelProvider with LaraGrape version...');
                $packageAdminPanelProvider = __DIR__ . '/../../Providers/Filament/AdminPanelProvider.php';
                if (file_exists($packageAdminPanelProvider)) {
                    $contents = file_get_contents($packageAdminPanelProvider);
                    // Update namespace to App
                    $contents = str_replace('namespace LaraGrape\\Providers\\Filament;', 'namespace App\\Providers\\Filament;', $contents);
                    // Update resource discovery paths
                    $contents = str_replace(
                        '->discoverResources(in: app_path(\'Filament/Resources\'), for: \'LaraGrape\\\\Filament\\\\Resources\')',
                        '->discoverResources(in: app_path(\'Filament/Resources\'), for: \'App\\\\Filament\\\\Resources\')',
                        $contents
                    );
                    $contents = str_replace(
                        '->discoverPages(in: app_path(\'Filament/Pages\'), for: \'LaraGrape\\\\Filament\\\\Pages\')',
                        '->discoverPages(in: app_path(\'Filament/Pages\'), for: \'App\\\\Filament\\\\Pages\')',
                        $contents
                    );
                    $contents = str_replace(
                        '->discoverWidgets(in: app_path(\'Filament/Widgets\'), for: \'App\\\\Filament\\\\Widgets\')',
                        '->discoverWidgets(in: app_path(\'Filament/Widgets\'), for: \'App\\\\Filament\\\\Widgets\')',
                        $contents
                    );
                    file_put_contents($adminPanelProviderPath, $contents);
                    $this->info('AdminPanelProvider overwritten and namespaces updated.');
                }
            } else {
                $this->warn('AdminPanelProvider not found at expected path: ' . $adminPanelProviderPath);
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
                    if ($file->isFile() && $file->getExtension() === 'php' && file_exists($file->getPathname())) {
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
                        if ($file->isFile() && $file->getExtension() === 'php' && file_exists($file->getPathname())) {
                            $contents = file_get_contents($file->getPathname());
                            $contents = str_replace('LaraGrape\\Filament\\Resources\\', 'App\\Filament\\Resources\\', $contents);
                            $contents = str_replace('LaraGrape\\Filament\\Pages\\', 'App\\Filament\\Pages\\', $contents);
                            $contents = str_replace('LaraGrape\\Filament\\', 'App\\Filament\\', $contents);
                            $contents = str_replace('LaraGrape\\', 'App\\', $contents);
                            $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                            // Remove any remaining LaraGrape\ references in ->resources() and ->pages()
                            $contents = preg_replace('/,?\s*\\\\LaraGrape\\\\[^,\)]+/', '', $contents);
                            file_put_contents($file->getPathname(), $contents);
                        }
                    }
                } elseif (is_file($path) && file_exists($path)) {
                    $contents = file_get_contents($path);
                    $contents = str_replace('LaraGrape\\Filament\\Resources\\', 'App\\Filament\\Resources\\', $contents);
                    $contents = str_replace('LaraGrape\\Filament\\Pages\\', 'App\\Filament\\Pages\\', $contents);
                    $contents = str_replace('LaraGrape\\Filament\\', 'App\\Filament\\', $contents);
                    $contents = str_replace('LaraGrape\\', 'App\\', $contents);
                    $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
                    $contents = preg_replace('/,?\s*\\\\LaraGrape\\\\[^,\)]+/', '', $contents);
                    file_put_contents($path, $contents);
                }
            }
            $this->info('Publishing custom welcome.blade.php...');
            $this->call('vendor:publish', [
                '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                '--tag' => 'LaraGrape-welcome',
                '--force' => $this->option('force'),
            ]);
            // Remove 'Lara' prefix from class names, references, and filenames in all published PHP files
            $allPublishedDirs = [
                base_path('app/Filament/Resources'),
                base_path('app/Filament/Pages'),
                base_path('app/Filament/Forms'),
            ];
            $allPublishedFiles = [];
            foreach ($allPublishedDirs as $dir) {
                if (is_dir($dir)) {
                    $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
                    foreach ($rii as $file) {
                        if ($file->isFile() && $file->getExtension() === 'php' && file_exists($file->getPathname())) {
                            $allPublishedFiles[] = $file->getPathname();
                        }
                    }
                }
            }
            
            // Clean up any duplicate Lara* files that might have been created
            foreach ($allPublishedDirs as $dir) {
                if (is_dir($dir)) {
                    $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
                    foreach ($rii as $file) {
                        if ($file->isFile() && $file->getExtension() === 'php' && strpos($file->getFilename(), 'Lara') === 0 && file_exists($file->getPathname())) {
                            $this->info('Removing duplicate file: ' . $file->getFilename());
                            unlink($file->getPathname());
                        }
                    }
                }
            }
            // Add AdminPanelProvider if it exists
            $adminPanelProviderPath = base_path('app/Providers/Filament/AdminPanelProvider.php');
            if (file_exists($adminPanelProviderPath)) {
                $allPublishedFiles[] = $adminPanelProviderPath;
            }
            foreach ($allPublishedFiles as $filePath) {
                if (file_exists($filePath)) {
                    $contents = file_get_contents($filePath);
                    // Remove 'Lara' prefix from class names
                    $contents = preg_replace('/class Lara([A-Z][A-Za-z0-9_]*)/', 'class $1', $contents, -1, $classCount);
                    if ($classCount > 0) {
                        $this->info("Updated class name in $filePath");
                    }
                    // Remove 'Lara' prefix from references to these classes
                    $contents = preg_replace('/Lara([A-Z][A-Za-z0-9_]*)/', '$1', $contents, -1, $refCount);
                    if ($refCount > 0) {
                        $this->info("Updated class references in $filePath");
                    }
                    file_put_contents($filePath, $contents);
                    // Optionally, rename the file itself if it starts with 'Lara'
                    $dir = dirname($filePath);
                    $base = basename($filePath);
                    if (strpos($base, 'Lara') === 0) {
                        $newBase = substr($base, 4); // Remove 'Lara'
                        $newPath = $dir . '/' . $newBase;
                        if (!file_exists($newPath) && file_exists($filePath)) {
                            rename($filePath, $newPath);
                            $this->info("Renamed file $base to $newBase");
                        } else {
                            $this->warn("Skipping rename for $base: Target exists or source missing");
                        }
                    }
                }
            }

            // 3b. Ensure every resource page file has the correct use statement for its resource
            $resourceDirs = glob(base_path('app/Filament/Resources/*Resource'));
            foreach ($resourceDirs as $resourceDir) {
                $resourceName = basename($resourceDir); // e.g., TailwindConfigResource
                $pagesDir = $resourceDir . '/Pages';
                if (is_dir($pagesDir)) {
                    foreach (glob($pagesDir . '/*.php') as $pageFile) {
                        if (file_exists($pageFile)) {
                            $contents = file_get_contents($pageFile);
                            // Only add if the file references the resource and doesn't already have the use statement
                            if (
                                strpos($contents, "protected static string \$resource = {$resourceName}::class;") !== false &&
                                strpos($contents, "use App\\Filament\\Resources\\{$resourceName};") === false
                            ) {
                                // Insert use statement after namespace
                                $contents = preg_replace(
                                    '/(namespace [^;]+;)/',
                                    "$1\nuse App\\Filament\\Resources\\{$resourceName};",
                                    $contents,
                                    1
                                );
                                file_put_contents($pageFile, $contents);
                                $this->info("Inserted use statement for {$resourceName} in " . basename($pageFile));
                            }
                        }
                    }
                }
            }

            // Post-process model namespaces, but skip User.php
            $modelsPath = base_path('app/Models');
            if (is_dir($modelsPath)) {
                foreach (glob($modelsPath . '/*.php') as $modelFile) {
                    if (file_exists($modelFile)) {
                        $contents = file_get_contents($modelFile);
                        $contents = str_replace('namespace LaraGrape\\Models;', 'namespace App\\Models;', $contents);
                        file_put_contents($modelFile, $contents);
                        $this->info("Updated model namespace in " . basename($modelFile));
                    }
                }
            }
            
            // Post-process controller namespaces
            $controllersPath = base_path('app/Http/Controllers');
            if (is_dir($controllersPath)) {
                foreach (glob($controllersPath . '/*.php') as $controllerFile) {
                    if (file_exists($controllerFile)) {
                        $contents = file_get_contents($controllerFile);
                        $contents = str_replace('namespace LaraGrape\\Http\\Controllers;', 'namespace App\\Http\\Controllers;', $contents);
                        $contents = str_replace('use LaraGrape\\Models\\', 'use App\\Models\\', $contents);
                        $contents = str_replace('use LaraGrape\\Services\\', 'use App\\Services\\', $contents);
                        file_put_contents($controllerFile, $contents);
                        $this->info("Updated controller namespace and use statements in " . basename($controllerFile));
                    }
                }
            }
        }

        // Post-process service namespaces (ensure App\Services) and use statements (ensure App\Models)
        $servicesPath = base_path('app/Services');
        if (is_dir($servicesPath)) {
            foreach (glob($servicesPath . '/*.php') as $serviceFile) {
                if (file_exists($serviceFile)) {
                    $contents = file_get_contents($serviceFile);
                    $contents = str_replace('namespace LaraGrape\\Services;', 'namespace App\\Services;', $contents);
                    $contents = str_replace('use LaraGrape\\Models\\', 'use App\\Models\\', $contents);
                    file_put_contents($serviceFile, $contents);
                    $this->info("Updated service namespace and use statements in " . basename($serviceFile));
                }
            }
        }

        // 4. Run migrations if requested
        if ($this->option('migrate')) {
            $this->info('Running migrations...');
            $this->call('migrate');
        }

        // Add publishing and post-processing for seeders
        $this->info('Publishing seeders...');
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'laragrape-seeders',
            '--force' => $force,
        ]);

        // Post-process seeders for namespaces
        $seedersPath = database_path('seeders');
        if (is_dir($seedersPath)) {
            foreach (glob($seedersPath . '/*.php') as $file) {
                if (file_exists($file)) {
                    $contents = file_get_contents($file);
                    $contents = str_replace('namespace LaraGrape\\Database\\Seeders;', 'namespace Database\\Seeders;', $contents);
                    $contents = str_replace('use LaraGrape\\Models\\', 'use App\\Models\\', $contents);
                    // Remove 'Lara' prefix from seeder class names
                    $contents = preg_replace('/class Lara([A-Z][A-Za-z0-9_]*Seeder)/', 'class $1Seeder', $contents);
                    file_put_contents($file, $contents);
                }
            }
        }

        // Run seeders if requested
        if ($this->option('seed') || $this->option('all')) {
            $this->info('Running seeders...');
            try {
                $this->call('db:seed', ['--force' => true]);
            } catch (\Exception $e) {
                $this->error('Seeder failed: ' . $e->getMessage());
            }
        }

        $this->info('Final publish complete. Your LaraGrape setup is fully up to date.');

        // Automatically re-run the setup with --all if not already set, to ensure all steps are completed
        if (!$this->option('all')) {
            $this->info('Re-running laragrape:setup with --all to ensure all files are published and post-processed...');
            $this->call('laragrape:setup', [
                '--all' => true,
            ]);
        }

        // Publish Filament form components (grapesjs-editor, etc.)
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-filament-form-components',
            '--force' => true,
        ]);
        // Publish custom pages views (e.g., pages/show.blade.php)
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-pages',
            '--force' => true,
        ]);

        // Publish JS assets (grapesjs-editor.js and future JS)
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-js',
            '--force' => true,
        ]);

        // Publish Filament admin theme CSS
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-filament-admin-css',
            '--force' => true,
        ]);

        // Publish and overwrite vite.config.js
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-vite-config',
            '--force' => true,
        ]);

        // Publish utilities CSS
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-utilities-css',
            '--force' => true,
        ]);

        // Publish all layout Blade views
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-layout',
            '--force' => true,
        ]);
        // Publish all block-related Blade views directly to their normal locations (not vendor)
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-filament-blocks',
            '--force' => true,
        ]);
        // Publish all Filament form components
        $this->call('vendor:publish', [
            '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
            '--tag' => 'LaraGrape-filament-form-components',
            '--force' => true,
        ]);

        // Always directly copy app.js to ensure it is overwritten
        $packageAppJs = __DIR__ . '/../../../resources/js/app.js';
        $appAppJs = base_path('resources/js/app.js');
        if (file_exists($packageAppJs)) {
            copy($packageAppJs, $appAppJs);
            $this->info('app.js was directly copied to ensure it is overwritten.');
        }

        // Ensure alpinejs is installed in the consuming app
        $this->info('Ensuring alpinejs is installed via npm...');
        exec('npm install alpinejs', $output, $resultCode);
        if ($resultCode === 0) {
            $this->info('alpinejs installed successfully.');
        } else {
            $this->warn('Failed to install alpinejs. Please run "npm install alpinejs" manually.');
        }
    }
} 