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
            // Publish all layout Blade views
            $this->publishes([
                $packageDir.'/resources/views/components/layout' => resource_path('views/components/layout'),
            ], 'LaraGrape-layout');
            // Publish all block Blade views directly to the normal location (not vendor)
            $this->publishes([
                $packageDir.'/resources/views/components/blocks' => resource_path('views/components/blocks'),
            ], 'LaraGrape-blocks');
            // Publish Filament blocks (Blade views)
            $this->publishes([
                $packageDir.'/resources/views/filament/blocks/components' => resource_path('views/filament/blocks/components'),
                $packageDir.'/resources/views/filament/blocks/content' => resource_path('views/filament/blocks/content'),
                $packageDir.'/resources/views/filament/blocks/forms' => resource_path('views/filament/blocks/forms'),
                $packageDir.'/resources/views/filament/blocks/layouts' => resource_path('views/filament/blocks/layouts'),
                $packageDir.'/resources/views/filament/blocks/media' => resource_path('views/filament/blocks/media'),
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
            // Publish models
            $this->publishes([
                $packageDir.'/src/Models' => app_path('Models'),
            ], 'LaraGrape-models');
            // Publish controllers
            $this->publishes([
                $packageDir.'/src/Http/Controllers' => app_path('Http/Controllers'),
            ], 'LaraGrape-controllers');
            $this->commands([
                \LaraGrape\Console\Commands\LaraGrapeSetupCommand::class,
            ]);
            // Publish CSS assets (site.css, app.css, filament-grapesjs-editor.css)
            $this->publishes([
                $packageDir.'/resources/css/site.css' => resource_path('css/site.css'),
                $packageDir.'/resources/css/app.css' => resource_path('css/app.css'),
                $packageDir.'/resources/css/filament-grapesjs-editor.css' => resource_path('css/filament-grapesjs-editor.css'),
            ], 'LaraGrape-css');
            // Publish PHP service/command files
            $this->publishes([
                $packageDir.'/src/Console/Commands/RebuildTailwindCommand.php' => app_path('Console/Commands/RebuildTailwindCommand.php'),
                $packageDir.'/src/Services/BlockService.php' => app_path('Services/BlockService.php'),
                $packageDir.'/src/Services/GrapesJsConverterService.php' => app_path('Services/GrapesJsConverterService.php'),
                $packageDir.'/src/Services/SiteSettingsService.php' => app_path('Services/SiteSettingsService.php'),
            ], 'LaraGrape-commands');
            // Publish web.php
            $this->publishes([
                $packageDir.'/routes/web.php' => base_path('routes/web.php'),
            ], 'LaraGrape-web');
            // Publish all Filament form components
            $this->publishes([
                $packageDir.'/resources/views/filament/forms/components' => resource_path('views/filament/forms/components'),
            ], 'LaraGrape-filament-form-components');
            // Publish custom pages views (e.g., pages/show.blade.php)
            $this->publishes([
                $packageDir.'/resources/views/pages' => resource_path('views/pages'),
            ], 'LaraGrape-pages');
            // Publish JS assets (grapesjs-editor.js and future JS)
            $this->publishes([
                $packageDir.'/resources/js/grapesjs-editor.js' => resource_path('js/grapesjs-editor.js'),
            ], 'LaraGrape-js');
            // Publish Filament admin theme CSS
            $this->publishes([
                $packageDir.'/resources/css/filament/admin/theme.css' => resource_path('css/filament/admin/theme.css'),
            ], 'LaraGrape-filament-admin-css');
            // Publish and overwrite vite.config.js
            $this->publishes([
                $packageDir.'/vite.config.js' => base_path('vite.config.js'),
            ], 'LaraGrape-vite-config');
            // Publish utilities CSS
            $this->publishes([
                $packageDir.'/public/css/laralgrape-utilities.css' => public_path('css/laralgrape-utilities.css'),
            ], 'LaraGrape-utilities-css');
        }
    }
}
