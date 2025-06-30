<?php

namespace Streats22\LaraGrape\Providers;

use Illuminate\Support\ServiceProvider;

class BoilerplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laralgrape-boilerplate');

        // Publish views
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/laralgrape-boilerplate'),
        ], 'laralgrape-boilerplate-views');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'laralgrape-boilerplate-migrations');
    }

    public function register()
    {
        //
    }
} 