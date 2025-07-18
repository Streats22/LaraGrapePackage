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
                
                // Register the component dynamically
                Blade::component($componentName, function ($attributes = [], $slot = null) use ($block) {
                    // Get the block content
                    $content = $block['content'] ?? '';
                    
                    // If it's a Blade template, render it
                    if (str_contains($content, '{{') || str_contains($content, '@')) {
                        // Create a temporary view with the content
                        $viewName = 'temp-block-' . uniqid();
                        view()->addNamespace('temp', storage_path('temp'));
                        
                        // Store the content temporarily
                        $tempPath = storage_path('temp/' . $viewName . '.blade.php');
                        file_put_contents($tempPath, $content);
                        
                        try {
                            $rendered = view('temp::' . $viewName, [
                                'attributes' => $attributes,
                                'slot' => $slot,
                                'isEditorPreview' => false
                            ])->render();
                            
                            // Clean up
                            unlink($tempPath);
                            
                            return $rendered;
                        } catch (\Exception $e) {
                            // Clean up on error
                            if (file_exists($tempPath)) {
                                unlink($tempPath);
                            }
                            
                            // Return fallback content
                            return '<div class="block-error" style="color: red; border: 1px solid red; padding: 10px;">Block rendering error: ' . $e->getMessage() . '</div>';
                        }
                    } else {
                        // For static HTML, just return the content
                        return $content;
                    }
                });
            }
        } catch (\Exception $e) {
            // Silently ignore errors during package discovery
            // This can happen when the database is not available or migrations haven't been run
        }
    }
} 