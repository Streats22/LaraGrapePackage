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
            $this->publishes([
                __DIR__.'/../../../config/LaraGrape.php' => config_path('LaraGrape.php'),
            ], 'LaraGrape-config');
            $this->publishes([
                __DIR__.'/../../../resources/views' => resource_path('views/vendor/LaraGrape'),
            ], 'LaraGrape-views');
            $this->publishes([
                __DIR__.'/../../../database/migrations' => database_path('migrations'),
            ], 'LaraGrape-migrations');
            $this->publishes([
                __DIR__.'/../../../database/seeders' => database_path('seeders'),
            ], 'LaraGrape-seeders');
            $this->commands([
                \LaraGrape\Console\Commands\LaraGrapeSetupCommand::class,
            ]);
        }
    }
}
