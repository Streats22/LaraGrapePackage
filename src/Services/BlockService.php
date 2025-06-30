<?php

namespace Streats22\LaraGrape\Services;

use Streats22\LaraGrape\Models\CustomBlock;
use Illuminate\Support\Facades\File;
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
     * Get all available blocks organized by category
     */
    public function getBlocks(): array
    {
        $blocks = [];
        
        // Get file-based blocks
        if (File::exists($this->blocksPath)) {
            $directories = File::directories($this->blocksPath);
            
            foreach ($directories as $directory) {
                $category = basename($directory);
                $categoryBlocks = $this->scanDirectory($directory);
                
                if (!empty($categoryBlocks)) {
                    $blocks[$category] = $categoryBlocks;
                }
            }
        }
        
        // Get custom blocks from database
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
        
        return $blocks;
    }
    
    /**
     * Scan a directory for block files
     */
    protected function scanDirectory(string $directory): array
    {
        $blocks = [];
        $files = File::files($directory);
        
        foreach ($files as $file) {
            // Check for .blade.php files
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
        
        // Extract block metadata from comments
        $metadata = $this->extractMetadata($content);
        
        // Get the HTML content (remove comments and extract the actual HTML)
        $htmlContent = $this->extractHtmlContent($content);
        
        if (empty($htmlContent)) {
            return null;
        }
        
        return [
            'id' => $metadata['id'] ?? $filename,
            'label' => $metadata['label'] ?? Str::title(str_replace(['-', '_'], ' ', $filename)),
            'category' => basename($file->getPath()),
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
        // $forms = \Streats22\LaraGrape\Models\Form::where('is_active', true)->get();
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
        $blocks = [];
        
        if (File::exists($this->blocksPath)) {
            $directories = File::directories($this->blocksPath);
            
            foreach ($directories as $directory) {
                $category = basename($directory);
                $categoryBlocks = $this->scanDirectory($directory);
                
                if (!empty($categoryBlocks)) {
                    $blocks[$category] = $categoryBlocks;
                }
            }
        }
        
        return $blocks;
    }
} 