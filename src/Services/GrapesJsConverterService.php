<?php

namespace Streats22\LaraGrape\Services;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Streats22\LaraGrape\Models\Page as GrapePage;

class GrapesJsConverterService
{
    protected BlockService $blockService;
    
    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }
    
    /**
     * Convert GrapesJS JSON data to Laravel Blade components
     */
    public function convertToBladeComponents(array $grapesjsData): array
    {
        $html = $grapesjsData['html'] ?? '';
        $css = $grapesjsData['css'] ?? '';
        
        // Parse the HTML and convert GrapesJS components to Blade components
        $convertedHtml = $this->parseGrapesJsHtml($html);
        
        return [
            'html' => $convertedHtml,
            'css' => $css,
            'components' => $this->extractComponents($html),
            'converted_at' => now()->toISOString(),
        ];
    }
    
    /**
     * Convert Laravel Blade components back to GrapesJS format
     */
    public function convertToGrapesJs(array $bladeData): array
    {
        $html = $bladeData['html'] ?? '';
        $css = $bladeData['css'] ?? '';
        
        // Convert Blade components back to GrapesJS format
        $convertedHtml = $this->parseBladeToGrapesJs($html);
        
        return [
            'html' => $convertedHtml,
            'css' => $css,
            'converted_at' => now()->toISOString(),
        ];
    }
    
    /**
     * Parse GrapesJS HTML and convert to Blade components
     */
    protected function parseGrapesJsHtml(string $html): string
    {
        // Get all available blocks for reference
        $blocks = $this->blockService->getGrapesJsBlocks();
        $blockMap = [];
        
        foreach ($blocks as $block) {
            $blockMap[$block['id']] = $block;
        }
        
        // Convert common GrapesJS patterns to Blade components
        $convertedHtml = $html;
        
        // Convert button blocks
        $convertedHtml = $this->convertButtonBlocks($convertedHtml);
        
        // Convert text blocks
        $convertedHtml = $this->convertTextBlocks($convertedHtml);
        
        // Convert heading blocks
        $convertedHtml = $this->convertHeadingBlocks($convertedHtml);
        
        // Convert spacer blocks
        $convertedHtml = $this->convertSpacerBlocks($convertedHtml);
        
        // Convert container/section blocks
        $convertedHtml = $this->convertContainerBlocks($convertedHtml);
        
        // Convert image blocks
        $convertedHtml = $this->convertImageBlocks($convertedHtml);
        
        return $convertedHtml;
    }
    
    /**
     * Convert button blocks to Blade components
     */
    protected function convertButtonBlocks(string $html): string
    {
        // Pattern: <button class="bg-purple-600 hover:bg-purple-700...">Click Me</button>
        $pattern = '/<button([^>]*class="[^"]*button-block[^"]*"[^>]*)>(.*?)<\/button>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract classes and other attributes
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            
            // Remove button-block class and keep other styling
            $classes = str_replace('button-block', '', $classes);
            $classes = trim($classes);
            
            return "<x-blocks.button class=\"{$classes}\">{$content}</x-blocks.button>";
        }, $html);
    }
    
    /**
     * Convert text blocks to Blade components
     */
    protected function convertTextBlocks(string $html): string
    {
        // Pattern: <div class="text-block..."><p>...</p></div>
        $pattern = '/<div([^>]*class="[^"]*text-block[^"]*"[^>]*)>(.*?)<\/div>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract classes
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            $classes = str_replace('text-block', '', $classes);
            $classes = trim($classes);
            
            return "<x-blocks.text class=\"{$classes}\">{$content}</x-blocks.text>";
        }, $html);
    }
    
    /**
     * Convert heading blocks to Blade components
     */
    protected function convertHeadingBlocks(string $html): string
    {
        // Pattern: <div class="heading-block..."><h2>...</h2></div>
        $pattern = '/<div([^>]*class="[^"]*heading-block[^"]*"[^>]*)>(.*?)<\/div>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract heading text
            preg_match('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/s', $content, $headingMatch);
            $headingText = $headingMatch[1] ?? '';
            
            // Extract classes
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            $classes = str_replace('heading-block', '', $classes);
            $classes = trim($classes);
            
            return "<x-blocks.heading class=\"{$classes}\">{$headingText}</x-blocks.heading>";
        }, $html);
    }
    
    /**
     * Convert spacer blocks to Blade components
     */
    protected function convertSpacerBlocks(string $html): string
    {
        // Pattern: <div class="spacer-block">...</div>
        $pattern = '/<div([^>]*class="[^"]*spacer-block[^"]*"[^>]*)>(.*?)<\/div>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            
            // Extract height from content or attributes
            preg_match('/h-(\d+)/', $matches[2], $heightMatch);
            $height = $heightMatch[1] ?? '16';
            
            return "<x-blocks.spacer height=\"{$height}\" />";
        }, $html);
    }
    
    /**
     * Convert container/section blocks to Blade components
     */
    protected function convertContainerBlocks(string $html): string
    {
        // Pattern: <div class="container-block...">...</div>
        $pattern = '/<div([^>]*class="[^"]*container-block[^"]*"[^>]*)>(.*?)<\/div>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract classes
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            $classes = str_replace('container-block', '', $classes);
            $classes = trim($classes);
            
            return "<x-blocks.container class=\"{$classes}\">{$content}</x-blocks.container>";
        }, $html);
    }
    
    /**
     * Convert image blocks to Blade components
     */
    protected function convertImageBlocks(string $html): string
    {
        // Pattern: <div class="image-block..."><img...></div>
        $pattern = '/<div([^>]*class="[^"]*image-block[^"]*"[^>]*)>(.*?)<\/div>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract image src
            preg_match('/src="([^"]*)"/', $content, $srcMatch);
            $src = $srcMatch[1] ?? '';
            
            // Extract alt text
            preg_match('/alt="([^"]*)"/', $content, $altMatch);
            $alt = $altMatch[1] ?? '';
            
            // Extract classes
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            $classes = str_replace('image-block', '', $classes);
            $classes = trim($classes);
            
            return "<x-blocks.image src=\"{$src}\" alt=\"{$alt}\" class=\"{$classes}\" />";
        }, $html);
    }
    
    /**
     * Parse Blade components back to GrapesJS format
     */
    protected function parseBladeToGrapesJs(string $html): string
    {
        $convertedHtml = $html;
        
        // Convert Blade components back to HTML
        $convertedHtml = $this->convertBladeButtonToHtml($convertedHtml);
        $convertedHtml = $this->convertBladeTextToHtml($convertedHtml);
        $convertedHtml = $this->convertBladeHeadingToHtml($convertedHtml);
        $convertedHtml = $this->convertBladeSpacerToHtml($convertedHtml);
        $convertedHtml = $this->convertBladeContainerToHtml($convertedHtml);
        $convertedHtml = $this->convertBladeImageToHtml($convertedHtml);
        
        return $convertedHtml;
    }
    
    /**
     * Convert Blade button component back to HTML
     */
    protected function convertBladeButtonToHtml(string $html): string
    {
        $pattern = '/<x-blocks\.button([^>]*)>(.*?)<\/x-blocks\.button>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract class attribute
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            
            return "<button class=\"button-block {$classes}\">{$content}</button>";
        }, $html);
    }
    
    /**
     * Convert Blade text component back to HTML
     */
    protected function convertBladeTextToHtml(string $html): string
    {
        $pattern = '/<x-blocks\.text([^>]*)>(.*?)<\/x-blocks\.text>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract class attribute
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            
            return "<div class=\"text-block {$classes}\">{$content}</div>";
        }, $html);
    }
    
    /**
     * Convert Blade heading component back to HTML
     */
    protected function convertBladeHeadingToHtml(string $html): string
    {
        $pattern = '/<x-blocks\.heading([^>]*)>(.*?)<\/x-blocks\.heading>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract class attribute
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            
            return "<div class=\"heading-block {$classes}\"><h2>{$content}</h2></div>";
        }, $html);
    }
    
    /**
     * Convert Blade spacer component back to HTML
     */
    protected function convertBladeSpacerToHtml(string $html): string
    {
        $pattern = '/<x-blocks\.spacer([^>]*)\/>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            
            // Extract height attribute
            preg_match('/height="([^"]*)"/', $attributes, $heightMatch);
            $height = $heightMatch[1] ?? '16';
            
            return "<div class=\"spacer-block\"><div class=\"h-{$height} bg-purple-100 border-2 border-dashed border-purple-300 flex items-center justify-center rounded-lg\"><span class=\"text-purple-600 text-sm font-medium\">Spacer ({$height}px)</span></div></div>";
        }, $html);
    }
    
    /**
     * Convert Blade container component back to HTML
     */
    protected function convertBladeContainerToHtml(string $html): string
    {
        $pattern = '/<x-blocks\.container([^>]*)>(.*?)<\/x-blocks\.container>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            $content = trim($matches[2]);
            
            // Extract class attribute
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            $classes = $classMatch[1] ?? '';
            
            return "<div class=\"container-block {$classes}\">{$content}</div>";
        }, $html);
    }
    
    /**
     * Convert Blade image component back to HTML
     */
    protected function convertBladeImageToHtml(string $html): string
    {
        $pattern = '/<x-blocks\.image([^>]*)\/>/s';
        
        return preg_replace_callback($pattern, function ($matches) {
            $attributes = $matches[1];
            
            // Extract attributes
            preg_match('/src="([^"]*)"/', $attributes, $srcMatch);
            preg_match('/alt="([^"]*)"/', $attributes, $altMatch);
            preg_match('/class="([^"]*)"/', $attributes, $classMatch);
            
            $src = $srcMatch[1] ?? '';
            $alt = $altMatch[1] ?? '';
            $classes = $classMatch[1] ?? '';
            
            return "<div class=\"image-block {$classes}\"><img src=\"{$src}\" alt=\"{$alt}\" class=\"w-full h-auto\"></div>";
        }, $html);
    }
    
    /**
     * Extract components from GrapesJS HTML
     */
    protected function extractComponents(string $html): array
    {
        $components = [];
        
        // Extract button components
        preg_match_all('/<button[^>]*class="[^"]*button-block[^"]*"[^>]*>(.*?)<\/button>/s', $html, $buttonMatches);
        foreach ($buttonMatches[0] as $button) {
            $components[] = [
                'type' => 'button',
                'content' => $button,
            ];
        }
        
        // Extract text components
        preg_match_all('/<div[^>]*class="[^"]*text-block[^"]*"[^>]*>(.*?)<\/div>/s', $html, $textMatches);
        foreach ($textMatches[0] as $text) {
            $components[] = [
                'type' => 'text',
                'content' => $text,
            ];
        }
        
        // Extract heading components
        preg_match_all('/<div[^>]*class="[^"]*heading-block[^"]*"[^>]*>(.*?)<\/div>/s', $html, $headingMatches);
        foreach ($headingMatches[0] as $heading) {
            $components[] = [
                'type' => 'heading',
                'content' => $heading,
            ];
        }
        
        return $components;
    }
    
    /**
     * Process GrapesJS data for saving
     */
    public function processForSaving(array $grapesjsData): array
    {
        // Convert to Blade components for storage
        $converted = $this->convertToBladeComponents($grapesjsData);
        
        return [
            'html' => $converted['html'],
            'css' => $converted['css'],
            'components' => $converted['components'],
            'original_grapesjs' => $grapesjsData, // Keep original for editing
            'converted_at' => $converted['converted_at'],
        ];
    }
    
    /**
     * Process saved data for editing
     */
    public function processForEditing(array $savedData): array
    {
        // If we have original GrapesJS data, use that for editing
        if (isset($savedData['original_grapesjs'])) {
            return $savedData['original_grapesjs'];
        }
        
        // Otherwise, convert Blade components back to GrapesJS format
        return $this->convertToGrapesJs($savedData);
    }
} 