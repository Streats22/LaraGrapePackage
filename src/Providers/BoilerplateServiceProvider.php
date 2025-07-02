<?php

namespace LaraGrape\Providers;

use Illuminate\Support\ServiceProvider;

class BoilerplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'LaraGrape-boilerplate');

        // Publish views
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/LaraGrape-boilerplate'),
        ], 'LaraGrape-boilerplate-views');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'LaraGrape-boilerplate-migrations');
    }

    public function register()
    {
        //
    }
} 