<?php

namespace LaraGrape\Services;

use LaraGrape\Models\CustomBlock;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BlockService
{
    protected string $blocksPath;
    
    public function __construct()
    {
        $this->blocksPath = resource_path('views/filament/blocks');
    }
    
    /**
     * Get the blocks path
     */
    public function getBlocksPath(): string
    {
        return $this->blocksPath;
    }
    
    /**
     * Get all available blocks organized by category.
     * Recursively scans subdirectories (e.g. components/animated/) so animated blocks are found.
     */
    public function getBlocks(): array
    {
        $blocks = [];
        
        // Get file-based blocks (recursive scan for subdirs like components/animated/)
        if (File::exists($this->blocksPath)) {
            $blocks = $this->scanBlocksRecursively($this->blocksPath);
        }
        
        // Get custom blocks from database
        try {
            $customBlocks = CustomBlock::active()->ordered()->get();
            
            foreach ($customBlocks as $customBlock) {
                $category = $customBlock->category;
                
                if (!isset($blocks[$category])) {
                    $blocks[$category] = [];
                }
                
                $blocks[$category][] = [
                    'id' => 'custom-' . $customBlock->slug,
                    'label' => $customBlock->name,
                    'category' => $category,
                    'content' => $customBlock->getCompleteContent(),
                    'attributes' => $customBlock->attributes ?? [],
                    'description' => $customBlock->description,
                    'icon' => $customBlock->icon,
                    'is_custom' => true,
                    'custom_block_id' => $customBlock->id,
                ];
            }
        } catch (\Exception $e) {
            // Silently ignore database errors during package discovery
            // This can happen when migrations haven't been run yet
        }
        
        return $blocks;
    }
    
    /**
     * Scan blocks recursively to find files in subdirectories (e.g. components/animated/)
     */
    protected function scanBlocksRecursively(string $basePath): array
    {
        $blocks = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (!$file->isFile() || !str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }
            $block = $this->parseBlockFile($file);
            if (!$block) {
                continue;
            }
            $category = $block['category'];
            if (!isset($blocks[$category])) {
                $blocks[$category] = [];
            }
            $blocks[$category][] = $block;
        }

        return $blocks;
    }

    /**
     * Scan a directory for block files (non-recursive, for backward compatibility)
     */
    protected function scanDirectory(string $directory): array
    {
        $blocks = [];
        $files = File::files($directory);

        foreach ($files as $file) {
            if (str_ends_with($file->getBasename(), '.blade.php')) {
                $block = $this->parseBlockFile($file);
                if ($block) {
                    $blocks[] = $block;
                }
            }
        }

        return $blocks;
    }
    
    /**
     * Parse a block file to extract metadata and content
     */
    protected function parseBlockFile(\SplFileInfo $file): ?array
    {
        $content = File::get($file->getPathname());
        $filename = $file->getBasename('.blade.php');
        // Use immediate parent dir as category (e.g. 'animated' for components/animated/block.blade.php)
        $category = basename($file->getPath());
        
        // Extract block metadata from comments
        $metadata = $this->extractMetadata($content);
        
        // Get the HTML content (remove comments and extract the actual HTML)
        $htmlContent = $this->extractHtmlContent($content);
        
        if (empty($htmlContent)) {
            return null;
        }
        
        // Create block ID that includes category for proper view path resolution
        $blockId = $metadata['id'] ?? $filename;
        $fullBlockId = $category . '/' . $blockId; // e.g., 'components/button'
        
        return [
            'id' => $blockId, // Use simple ID for backward compatibility with frontend
            'fullId' => $fullBlockId, // Keep full path for internal use
            'label' => $metadata['label'] ?? Str::title(str_replace(['-', '_'], ' ', $filename)),
            'category' => $category,
            'content' => $htmlContent,
            'attributes' => $metadata['attributes'] ?? [],
            'description' => $metadata['description'] ?? '',
            'icon' => $metadata['icon'] ?? null,
            'is_custom' => false,
        ];
    }
    
    /**
     * Extract metadata from block file comments
     */
    protected function extractMetadata(string $content): array
    {
        $metadata = [];
        
        // Look for metadata in comments like:
        // {{-- @block id="hero" label="Hero Section" description="A hero section with title and CTA" --}}
        if (preg_match('/{{--\s*@block\s+(.*?)\s*--}}/s', $content, $matches)) {
            $blockConfig = $matches[1];
            
            // Parse key-value pairs
            preg_match_all('/(\w+)="([^"]*)"/', $blockConfig, $pairs);
            
            for ($i = 0; $i < count($pairs[1]); $i++) {
                $key = $pairs[1][$i];
                $value = $pairs[2][$i];
                
                // Handle special cases
                if ($key === 'attributes') {
                    $metadata[$key] = json_decode($value, true) ?: [];
                } else {
                    $metadata[$key] = $value;
                }
            }
        }
        
        return $metadata;
    }
    
    /**
     * Extract HTML content from block file
     */
    protected function extractHtmlContent(string $content): string
    {
        // Remove block metadata comments
        $content = preg_replace('/{{--\s*@block\s+.*?\s*--}}/s', '', $content);
        
        // Remove other comments
        $content = preg_replace('/{{--.*?--}}/s', '', $content);
        
        // Remove PHP tags but keep the content
        $content = preg_replace('/<\?php.*?\?>/s', '', $content);
        
        // Clean up whitespace
        $content = trim($content);
        
        return $content;
    }
    
    /**
     * Get blocks formatted for GrapesJS
     */
    public function getGrapesJsBlocks(): array
    {
        $blocks = $this->getBlocks();
        $grapesJsBlocks = [];
        
        foreach ($blocks as $category => $categoryBlocks) {
            foreach ($categoryBlocks as $block) {
                $grapesJsBlocks[] = [
                    'id' => $block['id'],
                    'label' => $block['label'],
                    'category' => $category,
                    'content' => $block['content'],
                    'attributes' => $block['attributes'],
                    'description' => $block['description'],
                    'icon' => $block['icon'] ?? $this->getDefaultIconForCategory($category),
                    'is_custom' => $block['is_custom'] ?? false,
                ];
            }
        }
        
        // // Add form blocks dynamically
        // $forms = \App\Models\Form::where('is_active', true)->get();
        // foreach ($forms as $form) {
        //     $grapesJsBlocks[] = [
        //         'id' => 'form-' . $form->id,
        //         'label' => $form->name,
        //         'category' => 'forms',
        //         'content' => view('components.forms.form-block', ['form' => $form])->render(),
        //         'attributes' => ['draggable' => true, 'droppable' => false],
        //         'description' => $form->description,
        //         'icon' => 'fas fa-wpforms',
        //         'is_custom' => true,
        //     ];
        // }
        
        return $grapesJsBlocks;
    }
    
    /**
     * Get default icon for a category
     */
    protected function getDefaultIconForCategory(string $category): string
    {
        return match ($category) {
            'layouts' => 'fas fa-th-large',
            'content' => 'fas fa-align-left',
            'media' => 'fas fa-image',
            'forms' => 'fas fa-wpforms',
            'components' => 'fas fa-cube',
            'animated' => 'fas fa-magic',
            'advanced' => 'fas fa-rocket',
            'basic' => 'fas fa-cube',
            default => 'fas fa-cube',
        };
    }
    
    /**
     * Get blocks organized by category for GrapesJS
     */
    public function getGrapesJsBlocksByCategory(): array
    {
        $blocks = $this->getBlocks();
        $organized = [];
        
        foreach ($blocks as $category => $categoryBlocks) {
            $organized[$category] = [];
            
            foreach ($categoryBlocks as $block) {
                $organized[$category][] = [
                    'id' => $block['id'],
                    'label' => $block['label'],
                    'content' => $block['content'],
                    'attributes' => $block['attributes'],
                    'description' => $block['description'],
                    'is_custom' => $block['is_custom'] ?? false,
                ];
            }
        }
        
        return $organized;
    }
    
    /**
     * Get custom blocks only
     */
    public function getCustomBlocks(): array
    {
        return CustomBlock::active()->ordered()->get()->map(function ($block) {
            return $block->getGrapesJsConfig();
        })->toArray();
    }
    
    /**
     * Get file-based blocks only
     */
    public function getFileBlocks(): array
    {
        if (!File::exists($this->blocksPath)) {
            return [];
        }
        return $this->scanBlocksRecursively($this->blocksPath);
    }

    /**
     * Render a block preview as HTML (for GrapesJS editor)
     */
    public function renderBlockPreview(string $blockId): ?string
    {
        if (!File::exists($this->blocksPath)) {
            return null;
        }
        // Find the block file by id (searches recursively including animated/, advanced/, basic/)
        $blockFile = $this->findBlockFileById($blockId);
        if (!$blockFile) {
            return null;
        }
        $lastModified = filemtime($blockFile);
        $cacheKey = 'block_preview_' . $blockId . '_' . $lastModified;
        return Cache::rememberForever($cacheKey, function () use ($blockFile) {
            $viewName = $this->bladeViewNameFromPath($blockFile);
            try {
                return view($viewName, ['isEditorPreview' => true])->render();
            } catch (\Throwable $e) {
                return '<div style="color:red;">Block preview error: ' . e($e->getMessage()) . '</div>';
            }
        });
    }

    /**
     * Find the Blade file path for a block by id
     */
    protected function findBlockFileById(string $blockId): ?string
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->blocksPath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
                $content = File::get($file->getPathname());
                $metadata = $this->extractMetadata($content);
                $id = $metadata['id'] ?? $file->getBasename('.blade.php');
                // Check both the simple ID and the filename
                if ($id === $blockId || $file->getBasename('.blade.php') === $blockId) {
                    return $file->getPathname();
                }
            }
        }
        return null;
    }

    /**
     * Convert a Blade file path to a view name
     */
    protected function bladeViewNameFromPath(string $path): string
    {
        $relative = str_replace(resource_path('views') . '/', '', $path);
        return str_replace(['/', '.blade.php'], ['.', ''], $relative);
    }

    /**
     * Get the Blade view name for a block ID (for @include in frontend rendering).
     * Checks app path first, then package path. Returns LaraGrape:: prefixed name for package views.
     */
    public function getViewNameForBlockId(string $blockId): ?string
    {
        $blockFile = $this->findBlockFileById($blockId);
        if ($blockFile) {
            $viewName = $this->bladeViewNameFromPath($blockFile);
            if (\Illuminate\Support\Facades\View::exists($viewName)) {
                return $viewName;
            }
        }

        // Fallback: try package view (LaraGrape::filament.blocks...)
        $packageDir = dirname(__DIR__, 2);
        $packageBlocksPath = $packageDir . '/resources/views/filament/blocks';
        if (File::exists($packageBlocksPath)) {
            $blockFile = $this->findBlockFileInPath($blockId, $packageBlocksPath);
            if ($blockFile) {
                $relative = str_replace($packageDir . '/resources/views/', '', $blockFile);
                $viewName = 'LaraGrape::' . str_replace(['/', '.blade.php'], ['.', ''], $relative);
                if (\Illuminate\Support\Facades\View::exists($viewName)) {
                    return $viewName;
                }
            }
        }

        return null;
    }

    /**
     * Find block file in a specific path (used for package fallback)
     */
    protected function findBlockFileInPath(string $blockId, string $basePath): ?string
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
                $content = File::get($file->getPathname());
                $metadata = $this->extractMetadata($content);
                $id = $metadata['id'] ?? $file->getBasename('.blade.php');
                if ($id === $blockId || $file->getBasename('.blade.php') === $blockId) {
                    return $file->getPathname();
                }
            }
        }
        return null;
    }
}
