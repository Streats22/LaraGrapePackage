<?php

namespace LaraGrape\Console\Commands;

use Illuminate\Console\Command;
use LaraGrape\Services\LayoutService;

class ClearLayoutCacheCommand extends Command
{
    protected $signature = 'layout:clear-cache';

    protected $description = 'Clear all layout-related caches including header, footer, and menu configurations';

    public function handle(): int
    {
        $this->info('Clearing layout caches...');

        $this->call('cache:clear');
        $this->info('✓ Application cache cleared');

        $this->call('view:clear');
        $this->info('✓ View cache cleared');

        $this->call('config:clear');
        $this->info('✓ Config cache cleared');

        app(LayoutService::class)->clearCache();
        $this->info('✓ Layout service cache cleared');

        $this->info('All layout caches cleared successfully!');

        return Command::SUCCESS;
    }
}
