<?php

namespace LaraGrape\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class LaraGrapeUpdateCommand extends Command
{
    protected $signature = 'laragrape:update
        {--force : Overwrite existing files without asking}
        {--config : Update configuration files only}
        {--views : Update view files only}
        {--migrations : Update migration files only}
        {--filament : Update Filament resources and components only}
        {--assets : Update CSS/JS assets only}
        {--controllers : Update controllers only}
        {--services : Update services only}
        {--routes : Update routes only}
        {--all : Update everything}';
    
    protected $description = 'Update LaraGrape components selectively';

    private $componentGroups = [
        'config' => [
            'name' => 'Configuration Files',
            'description' => 'Laravel configuration files',
            'tags' => ['LaraGrape-config'],
            'paths' => ['config/']
        ],
        'views' => [
            'name' => 'View Files',
            'description' => 'Blade templates and components',
            'tags' => [
                'LaraGrape-views',
                'LaraGrape-frontend-layout',
                'LaraGrape-filament-blocks',
                'LaraGrape-layout',
                'LaraGrape-pages'
            ],
            'paths' => ['resources/views/']
        ],
        'migrations' => [
            'name' => 'Database Migrations',
            'description' => 'Database migration files',
            'tags' => ['LaraGrape-migrations'],
            'paths' => ['database/migrations/']
        ],
        'filament' => [
            'name' => 'Filament Admin Panel',
            'description' => 'Filament resources, pages, and components',
            'tags' => [
                'LaraGrape-filament-resources',
                'LaraGrape-filament-pages',
                'LaraGrape-filament-forms',
                'LaraGrape-filament-form-components',
                'LaraGrape-filament-admin-css',
                'laragrape-filament-customblock',
                'laragrape-filament-page',
                'laragrape-customblock-resource',
                'laragrape-page-resource',
                'laragrape-sitesettings-resource',
                'laragrape-tailwindconfig-resource',
                'laragrape-filament-components'
            ],
            'paths' => ['app/Filament/', 'resources/views/filament/']
        ],
        'assets' => [
            'name' => 'Frontend Assets',
            'description' => 'CSS, JavaScript, and other frontend files',
            'tags' => [
                'LaraGrape-css',
                'LaraGrape-utilities-css',
                'LaraGrape-js',
                'LaraGrape-vite-config'
            ],
            'paths' => ['resources/css/', 'resources/js/', 'public/css/']
        ],
        'controllers' => [
            'name' => 'Controllers',
            'description' => 'HTTP controllers',
            'tags' => ['LaraGrape-controllers', 'laragrape-admin-controller'],
            'paths' => ['app/Http/Controllers/']
        ],
        'services' => [
            'name' => 'Services',
            'description' => 'Service classes and business logic',
            'tags' => ['LaraGrape-commands'],
            'paths' => ['app/Services/']
        ],
        'routes' => [
            'name' => 'Routes',
            'description' => 'Web routes and route definitions',
            'tags' => ['LaraGrape-web'],
            'paths' => ['routes/']
        ],
        'models' => [
            'name' => 'Models',
            'description' => 'Eloquent model classes',
            'tags' => ['LaraGrape-models'],
            'paths' => ['app/Models/']
        ],
        'seeders' => [
            'name' => 'Database Seeders',
            'description' => 'Database seeder classes',
            'tags' => ['laragrape-seeders'],
            'paths' => ['database/seeders/']
        ],
        'console' => [
            'name' => 'Console Commands',
            'description' => 'Artisan console commands and kernel',
            'tags' => ['LaraGrape-console-kernel'],
            'paths' => ['app/Console/']
        ]
    ];

    public function handle()
    {
        $this->info('🔄 Starting LaraGrape update...');
        
        // Determine which components to update
        $componentsToUpdate = $this->determineComponentsToUpdate();
        
        if (empty($componentsToUpdate)) {
            $this->info('❌ No components selected for update. Exiting.');
            return;
        }
        
        $this->info('📋 Components to update:');
        foreach ($componentsToUpdate as $component) {
            $this->info("   • {$this->componentGroups[$component]['name']}");
        }
        
        // Confirm before proceeding
        if (!$this->option('force') && !$this->confirm('Do you want to proceed with updating these components?', true)) {
            $this->info('❌ Update cancelled.');
            return;
        }
        
        // Update selected components
        $this->updateComponents($componentsToUpdate);
        
        $this->info('🎉 LaraGrape update completed!');
        $this->info('');
        $this->info('📋 Summary:');
        $this->info('   ✅ Selected components updated');
        $this->info('   ✅ Namespaces updated to App namespace');
        $this->info('');
        $this->info('🚀 Next steps:');
        $this->info('   1. Run "php artisan migrate" if database structure changed');
        $this->info('   2. Run "npm run dev" to compile updated frontend assets');
        $this->info('   3. Clear cache with "php artisan cache:clear" if needed');
    }
    
    private function determineComponentsToUpdate(): array
    {
        $components = [];
        
        // Check for specific options
        foreach (array_keys($this->componentGroups) as $component) {
            if ($this->option($component)) {
                $components[] = $component;
            }
        }
        
        // If --all is specified, include all components
        if ($this->option('all')) {
            return array_keys($this->componentGroups);
        }
        
        // If no specific options, show interactive menu
        if (empty($components)) {
            $components = $this->showInteractiveMenu();
        }
        
        return $components;
    }
    
    private function showInteractiveMenu(): array
    {
        $this->info('📝 Select components to update:');
        $this->info('');
        
        $choices = [];
        foreach ($this->componentGroups as $key => $group) {
            $choices[$key] = "{$group['name']} - {$group['description']}";
        }
        
        $selected = $this->choice(
            'Which components would you like to update? (Use space to select, enter to confirm)',
            $choices,
            null,
            null,
            true
        );
        
        return $selected;
    }
    
    private function updateComponents(array $components): void
    {
        $force = $this->option('force');
        
        foreach ($components as $component) {
            $group = $this->componentGroups[$component];
            
            $this->info("📤 Updating {$group['name']}...");
            
            // Publish all tags for this component group
            foreach ($group['tags'] as $tag) {
                try {
                    $this->call('vendor:publish', [
                        '--provider' => 'LaraGrape\\Providers\\LaraGrapeServiceProvider',
                        '--tag' => $tag,
                        '--force' => $force,
                    ]);
                    $this->info("   ✅ Published $tag");
                } catch (\Exception $e) {
                    $this->warn("   ⚠️  Failed to publish $tag: " . $e->getMessage());
                }
            }
            
            // Post-process files for this component group
            $this->postProcessComponent($component, $group);
            
            $this->info("✅ {$group['name']} updated successfully.");
        }
    }
    
    private function postProcessComponent(string $component, array $group): void
    {
        $this->info("   🔧 Post-processing {$group['name']}...");
        
        switch ($component) {
            case 'filament':
                $this->postProcessFilament();
                break;
            case 'controllers':
                $this->postProcessControllers();
                break;
            case 'services':
                $this->postProcessServices();
                break;
            case 'models':
                $this->postProcessModels();
                break;
            case 'seeders':
                $this->postProcessSeeders();
                break;
            case 'console':
                $this->postProcessConsole();
                break;
            case 'routes':
                $this->postProcessRoutes();
                break;
        }
    }
    
    private function postProcessFilament(): void
    {
        // Update namespaces in Filament resources
        $resourcesPath = base_path('app/Filament/Resources');
        if (is_dir($resourcesPath)) {
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
        
        // Update namespaces in Filament pages
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
        
        // Update namespaces in Filament forms
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
        
        // Remove 'Lara' prefix from class names and references
        $this->removeLaraPrefixFromFilament();
    }
    
    private function postProcessControllers(): void
    {
        $controllersPath = base_path('app/Http/Controllers');
        if (is_dir($controllersPath)) {
            foreach (glob($controllersPath . '/*.php') as $controllerFile) {
                if (file_exists($controllerFile)) {
                    $contents = file_get_contents($controllerFile);
                    $contents = str_replace('namespace LaraGrape\\Http\\Controllers;', 'namespace App\\Http\\Controllers;', $contents);
                    $contents = str_replace('use LaraGrape\\Models\\', 'use App\\Models\\', $contents);
                    $contents = str_replace('use LaraGrape\\Services\\', 'use App\\Services\\', $contents);
                    $contents = preg_replace('/class Lara([A-Z][A-Za-z0-9_]*)/', 'class $1', $contents);
                    file_put_contents($controllerFile, $contents);
                }
            }
        }
    }
    
    private function postProcessServices(): void
    {
        $servicesPath = base_path('app/Services');
        if (is_dir($servicesPath)) {
            foreach (glob($servicesPath . '/*.php') as $serviceFile) {
                if (file_exists($serviceFile)) {
                    $contents = file_get_contents($serviceFile);
                    $contents = str_replace('namespace LaraGrape\\Services;', 'namespace App\\Services;', $contents);
                    $contents = str_replace('use LaraGrape\\Models\\', 'use App\\Models\\', $contents);
                    file_put_contents($serviceFile, $contents);
                }
            }
        }
    }
    
    private function postProcessModels(): void
    {
        $modelsPath = base_path('app/Models');
        if (is_dir($modelsPath)) {
            foreach (glob($modelsPath . '/*.php') as $modelFile) {
                if (file_exists($modelFile)) {
                    $contents = file_get_contents($modelFile);
                    $contents = str_replace('namespace LaraGrape\\Models;', 'namespace App\\Models;', $contents);
                    file_put_contents($modelFile, $contents);
                }
            }
        }
    }
    
    private function postProcessSeeders(): void
    {
        $seedersPath = database_path('seeders');
        if (is_dir($seedersPath)) {
            foreach (glob($seedersPath . '/*.php') as $file) {
                if (file_exists($file)) {
                    $contents = file_get_contents($file);
                    $contents = str_replace('namespace LaraGrape\\Database\\Seeders;', 'namespace Database\\Seeders;', $contents);
                    $contents = str_replace('use LaraGrape\\Models\\', 'use App\\Models\\', $contents);
                    $contents = preg_replace('/class Lara([A-Z][A-Za-z0-9_]*Seeder)/', 'class $1Seeder', $contents);
                    file_put_contents($file, $contents);
                }
            }
        }
    }
    
    private function postProcessConsole(): void
    {
        $consolePath = base_path('app/Console');
        if (is_dir($consolePath)) {
            // Update Kernel.php
            $kernelFile = $consolePath . '/Kernel.php';
            if (file_exists($kernelFile)) {
                $contents = file_get_contents($kernelFile);
                $contents = str_replace('namespace LaraGrape\\Console;', 'namespace App\\Console;', $contents);
                $contents = str_replace('use LaraGrape\\Console\\Commands\\', 'use App\\Console\\Commands\\', $contents);
                file_put_contents($kernelFile, $contents);
            }
            
            // Update Commands
            $commandsPath = $consolePath . '/Commands';
            if (is_dir($commandsPath)) {
                foreach (glob($commandsPath . '/*.php') as $commandFile) {
                    if (file_exists($commandFile)) {
                        $contents = file_get_contents($commandFile);
                        $contents = str_replace('namespace LaraGrape\\Console\\Commands;', 'namespace App\\Console\\Commands;', $contents);
                        $contents = str_replace('use LaraGrape\\Models\\', 'use App\\Models\\', $contents);
                        file_put_contents($commandFile, $contents);
                    }
                }
            }
        }
    }
    
    private function postProcessRoutes(): void
    {
        $webPath = base_path('routes/web.php');
        if (file_exists($webPath)) {
            $contents = file_get_contents($webPath);
            $contents = str_replace('LaraGrape\\Http\\Controllers\\', 'App\\Http\\Controllers\\', $contents);
            file_put_contents($webPath, $contents);
        }
    }
    
    private function removeLaraPrefixFromFilament(): void
    {
        $pathsToClean = [
            base_path('app/Filament/Resources'),
            base_path('app/Filament/Pages'),
            base_path('app/Filament/Forms'),
        ];
        
        foreach ($pathsToClean as $path) {
            if (is_dir($path)) {
                $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
                foreach ($rii as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php' && file_exists($file->getPathname())) {
                        $contents = file_get_contents($file->getPathname());
                        
                        // Remove 'Lara' prefix from class names
                        $contents = preg_replace('/class Lara([A-Z][A-Za-z0-9_]*)/', 'class $1', $contents);
                        
                        // Remove 'Lara' prefix from references
                        $contents = preg_replace('/Lara([A-Z][A-Za-z0-9_]*)/', '$1', $contents);
                        
                        file_put_contents($file->getPathname(), $contents);
                        
                        // Rename file if it starts with 'Lara'
                        $dir = dirname($file->getPathname());
                        $base = basename($file->getPathname());
                        if (strpos($base, 'Lara') === 0) {
                            $newBase = substr($base, 4); // Remove 'Lara'
                            $newPath = $dir . '/' . $newBase;
                            if (!file_exists($newPath) && file_exists($file->getPathname())) {
                                rename($file->getPathname(), $newPath);
                            }
                        }
                    }
                }
            }
        }
        
        // Update resource files to use correct page class names
        $resourceFiles = [
            base_path('app/Filament/Resources/CustomBlockResource.php'),
            base_path('app/Filament/Resources/PageResource.php'),
            base_path('app/Filament/Resources/SiteSettingsResource.php'),
            base_path('app/Filament/Resources/TailwindConfigResource.php'),
        ];
        
        foreach ($resourceFiles as $resourceFile) {
            if (file_exists($resourceFile)) {
                $contents = file_get_contents($resourceFile);
                $contents = str_replace('Pages\\LaraListCustomBlocks::', 'Pages\\ListCustomBlocks::', $contents);
                $contents = str_replace('Pages\\LaraCreateCustomBlock::', 'Pages\\CreateCustomBlock::', $contents);
                $contents = str_replace('Pages\\LaraEditCustomBlock::', 'Pages\\EditCustomBlock::', $contents);
                $contents = str_replace('Pages\\LaraListPages::', 'Pages\\ListPages::', $contents);
                $contents = str_replace('Pages\\LaraCreatePage::', 'Pages\\CreatePage::', $contents);
                $contents = str_replace('Pages\\LaraEditPage::', 'Pages\\EditPage::', $contents);
                $contents = str_replace('Pages\\LaraListSiteSettings::', 'Pages\\ListSiteSettings::', $contents);
                $contents = str_replace('Pages\\LaraCreateSiteSettings::', 'Pages\\CreateSiteSettings::', $contents);
                $contents = str_replace('Pages\\LaraEditSiteSettings::', 'Pages\\EditSiteSettings::', $contents);
                $contents = str_replace('Pages\\LaraListTailwindConfigs::', 'Pages\\ListTailwindConfigs::', $contents);
                $contents = str_replace('Pages\\LaraCreateTailwindConfig::', 'Pages\\CreateTailwindConfig::', $contents);
                $contents = str_replace('Pages\\LaraEditTailwindConfig::', 'Pages\\EditTailwindConfig::', $contents);
                file_put_contents($resourceFile, $contents);
            }
        }
    }
} 