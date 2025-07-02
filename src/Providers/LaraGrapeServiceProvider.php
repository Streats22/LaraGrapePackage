<?php

namespace LaraGrape\Providers;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class LaraGrapeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // GrapesJS is now loaded directly in the Blade view
        // No need to register additional assets here

        if ($this->app->runningInConsole()) {
            $packageDir = dirname(__DIR__, 2);
            $this->publishes([
                $packageDir.'/config/LaraGrape.php' => config_path('LaraGrape.php'),
            ], 'LaraGrape-config');
            $this->publishes([
                $packageDir.'/resources/views' => resource_path('views/vendor/LaraGrape'),
            ], 'LaraGrape-views');
            $this->publishes([
                $packageDir.'/database/migrations' => database_path('migrations'),
            ], 'LaraGrape-migrations');
            $this->publishes([
                $packageDir.'/database/seeders' => database_path('seeders'),
            ], 'LaraGrape-seeders');
            // Publish Filament resources
            $this->publishes([
                $packageDir.'/src/Filament/Resources' => app_path('Filament/Resources'),
            ], 'LaraGrape-filament-resources');
            // Publish Filament pages
            $this->publishes([
                $packageDir.'/src/Filament/Pages' => app_path('Filament/Pages'),
            ], 'LaraGrape-filament-pages');
            // Publish frontend layout components
            $this->publishes([
                $packageDir.'/resources/views/components/layout' => resource_path('views/components/layout'),
            ], 'LaraGrape-frontend-layout');
            // Publish Filament blocks (Blade views)
            $this->publishes([
                $packageDir.'/resources/views/components/blocks' => resource_path('views/components/blocks'),
            ], 'LaraGrape-filament-blocks');
            // Publish AdminPanelProvider stub
            $this->publishes([
                $packageDir.'/src/Providers/Filament/AdminPanelProvider.php' => app_path('Filament/AdminPanelProvider.php'),
            ], 'LaraGrape-admin-panel-provider');
            // Publish Filament forms (custom form components)
            $this->publishes([
                $packageDir.'/src/Filament/Forms' => app_path('Filament/Forms'),
            ], 'LaraGrape-filament-forms');
            // Publish and overwrite the default welcome.blade.php
            $this->publishes([
                $packageDir.'/resources/views/welcome.blade.php' => base_path('resources/views/welcome.blade.php'),
            ], 'LaraGrape-welcome');
            $this->commands([
                \LaraGrape\Console\Commands\LaraGrapeSetupCommand::class,
            ]);
        }
    }
}
