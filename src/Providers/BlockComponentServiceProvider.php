<?php

namespace LaraGrape\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use LaraGrape\Services\BlockService;

class BlockComponentServiceProvider extends ServiceProvider
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
        $this->registerBlockComponents();
    }

    /**
     * Register dynamic block components
     */
    protected function registerBlockComponents(): void
    {
        try {
            $blockService = app(BlockService::class);
            $blocks = $blockService->getGrapesJsBlocks();

            foreach ($blocks as $block) {
                $componentName = 'blocks.' . $block['id'];
                
                // For now, skip dynamic component registration during package discovery
                // This will be handled when the application is fully booted
                continue;
            }
        } catch (\Exception $e) {
            // Silently ignore errors during package discovery
            // This can happen when the database is not available or migrations haven't been run
        }
    }
} 