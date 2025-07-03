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
                // Remove any LaraGrape\ references in ->resources(), ->pages(), ->widgets()
                $contents = preg_replace('/(->resources\(\[)([^\]]*)\]/s', function ($matches) {
                    $lines = explode("\n", $matches[2]);
                    $lines = array_filter($lines, function($line) {
                        return strpos($line, 'LaraGrape\\') === false;
                    });
                    return $matches[1] . implode("\n", $lines) . "]";
                }, $contents);
                $contents = preg_replace('/(->pages\(\[)([^\]]*)\]/s', function ($matches) {
                    $lines = explode("\n", $matches[2]);
                    $lines = array_filter($lines, function($line) {
                        return strpos($line, 'LaraGrape\\') === false;
                    });
                    return $matches[1] . implode("\n", $lines) . "]";
                }, $contents);
                $contents = preg_replace('/(->widgets\(\[)([^\]]*)\]/s', function ($matches) {
                    $lines = explode("\n", $matches[2]);
                    $lines = array_filter($lines, function($line) {
                        return strpos($line, 'LaraGrape\\') === false;
                    });
                    return $matches[1] . implode("\n", $lines) . "]";
                }, $contents);
                // Also update any namespace/use statements
                $contents = str_replace('LaraGrape\\Filament\\Resources\\', 'App\\Filament\\Resources\\', $contents);
                $contents = str_replace('LaraGrape\\Filament\\Pages\\', 'App\\Filament\\Pages\\', $contents);
                $contents = str_replace('LaraGrape\\Filament\\', 'App\\Filament\\', $contents);
                $contents = str_replace('LaraGrape\\', 'App\\', $contents);
                $contents = str_replace('use LaraGrape\\', 'use App\\', $contents);
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
                            $contents = preg_replace('/,?\s*\\\\LaraGrape\\\\[^,\)]+/', '', $contents);
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
                        if ($file->isFile() && $file->getExtension() === 'php') {
                            $allPublishedFiles[] = $file->getPathname();
                        }
                    }
                }
            }
            // Add AdminPanelProvider if it exists
            $adminPanelProviderPath = base_path('app/Filament/AdminPanelProvider.php');
            if (file_exists($adminPanelProviderPath)) {
                $allPublishedFiles[] = $adminPanelProviderPath;
            }
            foreach ($allPublishedFiles as $filePath) {
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
                    if (!file_exists($newPath)) {
                        rename($filePath, $newPath);
                        $this->info("Renamed file $base to $newBase");
                    } else {
                        $this->warn("File $newBase already exists, skipping rename for $base");
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

            // Post-process model namespaces, but skip User.php
            $modelsPath = base_path('app/Models');
            if (is_dir($modelsPath)) {
                foreach (glob($modelsPath . '/*.php') as $modelFile) {
                    $contents = file_get_contents($modelFile);
                    $contents = str_replace('namespace LaraGrape\\Models;', 'namespace App\\Models;', $contents);
                    file_put_contents($modelFile, $contents);
                    $this->info("Updated model namespace in " . basename($modelFile));
                }
            }
        }

        // Post-process service namespaces (ensure App\Services) and use statements (ensure App\Models)
        $servicesPath = base_path('app/Services');
        if (is_dir($servicesPath)) {
            foreach (glob($servicesPath . '/*.php') as $serviceFile) {
                $contents = file_get_contents($serviceFile);
                $contents = str_replace('namespace LaraGrape\\Services;', 'namespace App\\Services;', $contents);
                $contents = str_replace('use LaraGrape\\Models\\', 'use App\\Models\\', $contents);
                file_put_contents($serviceFile, $contents);
                $this->info("Updated service namespace and use statements in " . basename($serviceFile));
            }
        }

        // 4. Run migrations if requested
        if ($this->option('migrate')) {
            $this->info('Running migrations...');
            $this->call('migrate');
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
    }
} 