<?php

namespace Streats22\LaraGrape\Http\Controllers;

use Streats22\LaraGrape\Models\Page;
use Streats22\LaraGrape\Services\GrapesJsConverterService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    protected GrapesJsConverterService $converterService;
    
    public function __construct(GrapesJsConverterService $converterService)
    {
        $this->converterService = $converterService;
    }

    /**
     * Display a page by its slug
     */
    public function show(string $slug): View|Response
    {
        $page = Page::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        // Get the rendered HTML and CSS from GrapesJS data
        $renderedHtml = $this->renderGrapesJsContent($page);
        
        // Prepare GrapesJS data for editing (convert back to original format if needed)
        $editingData = [];
        if (!empty($page->grapesjs_data)) {
            $editingData = $this->converterService->processForEditing($page->grapesjs_data);
        }
        
        return view('pages.show', compact('page', 'renderedHtml', 'editingData'));
    }
    
    /**
     * Display the homepage
     */
    public function home(): View
    {
        $page = Page::where('slug', 'home')
            ->published()
            ->first();
        
        if (!$page) {
            // Create a default homepage if it doesn't exist
            $page = $this->createDefaultHomepage();
        }
        
        $renderedHtml = $this->renderGrapesJsContent($page);
        
        // Prepare GrapesJS data for editing (convert back to original format if needed)
        $editingData = [];
        if (!empty($page->grapesjs_data)) {
            $editingData = $this->converterService->processForEditing($page->grapesjs_data);
        }
        
        return view('pages.show', compact('page', 'renderedHtml', 'editingData'));
    }
    
    /**
     * Save GrapesJS content from frontend editor
     */
    public function saveGrapesJs(Request $request, string $slug): JsonResponse
    {
        // Debug logging
        \Log::info('GrapesJS save request', [
            'slug' => $slug,
            'user' => auth()->id(),
            'request_data' => $request->all()
        ]);
        
        // Check authentication
        if (!auth()->check()) {
            \Log::warning('Unauthorized GrapesJS save attempt', ['slug' => $slug]);
            return response()->json(['error' => 'Authentication required'], 401);
        }
        
        // Find the page
        $page = Page::where('slug', $slug)->first();
        
        if (!$page) {
            \Log::error('Page not found for save', ['slug' => $slug]);
            return response()->json(['error' => 'Page not found'], 404);
        }
        
        // Validate the request
        $request->validate([
            'html' => 'required|string',
            'css' => 'nullable|string',
        ]);
        
        try {
            // Prepare the GrapesJS data
            $grapesjsData = [
                'html' => $request->input('html'),
                'css' => $request->input('css', ''),
                'saved_at' => now()->toISOString(),
                'saved_by' => auth()->id(),
            ];
            
            // Process the data for saving (convert to Blade components)
            $processedData = $this->converterService->processForSaving($grapesjsData);
            
            \Log::info('Saving GrapesJS data', [
                'page_id' => $page->id,
                'grapesjs_data' => $processedData
            ]);
            
            // Update the page
            $page->update([
                'grapesjs_data' => $processedData,
                'updated_at' => now(),
            ]);
            
            \Log::info('GrapesJS data saved successfully', ['page_id' => $page->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Page content saved successfully',
                'saved_at' => now()->toISOString(),
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to save GrapesJS data', [
                'page_id' => $page->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to save page content',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Render GrapesJS content to HTML
     */
    private function renderGrapesJsContent(Page $page): string
    {
        if (empty($page->grapesjs_data)) {
            return $page->content ?? '';
        }
        $data = $page->grapesjs_data;
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        // Prefer original GrapesJS HTML/CSS if available
        $html = $data['original_grapesjs']['html'] ?? ($data['html'] ?? '');
        $css = $data['original_grapesjs']['css'] ?? ($data['css'] ?? '');
        if (!empty($css)) {
            $html = "<style>{$css}</style>" . $html;
        }
        return $html;
    }
    
    /**
     * Create a default homepage
     */
    private function createDefaultHomepage(): Page
    {
        return Page::create([
            'title' => 'Welcome to LaralGrape',
            'slug' => 'home',
            'content' => '<h1>Welcome to LaralGrape</h1><p>This is your new Laravel + GrapesJS + Filament boilerplate!</p>',
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
