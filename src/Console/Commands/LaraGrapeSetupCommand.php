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
        
        $this->info('Installing Filament admin panel...');
        $this->call('php artisan filament:install', [
            '--panel' => true,
        ]);

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

       
        $this->info('LaraGrape setup complete!');
    }
} 