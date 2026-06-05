<?php

namespace LaraGrape\Http\Controllers;

use LaraGrape\Models\Page;
use LaraGrape\Services\BlockLayoutService;
use LaraGrape\Services\GrapesJsConverterService;
use LaraGrape\Support\EditorSettings;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected GrapesJsConverterService $converterService,
        protected BlockLayoutService $blockLayoutService,
    ) {}

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
        $user = $request->user();

        Log::info('GrapesJS save request', [
            'slug' => $slug,
            'user' => $user?->getAuthIdentifier(),
            'request_data' => $request->all(),
        ]);

        if ($user === null) {
            Log::warning('Unauthorized GrapesJS save attempt', ['slug' => $slug]);

            return response()->json(['error' => 'Authentication required'], 401);
        }

        if (! EditorSettings::allowsFrontendEditor()) {
            return response()->json(['error' => 'Frontend editor is disabled for this site'], 403);
        }

        // Find the page
        $page = Page::where('slug', $slug)->first();
        
        if (!$page) {
            Log::error('Page not found for save', ['slug' => $slug]);
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
                'saved_by' => $user->getAuthIdentifier(),
            ];
            
            // Process the data for saving (convert to Blade components)
            $processedData = $this->converterService->processForSaving($grapesjsData);

            // Convert to Blade content (string)
            $bladeContent = $this->converterService->convertToBlade($processedData);
            
            Log::info('Saving GrapesJS data', [
                'page_id' => $page->id,
                'grapesjs_data' => $processedData,
                'blade_content' => $bladeContent,
            ]);
            
            // Update the page
            $page->update([
                'grapesjs_data' => $processedData,
                'blade_content' => $bladeContent,
                'updated_at' => now(),
            ]);
            
            Log::info('GrapesJS data saved successfully', ['page_id' => $page->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Page content saved successfully',
                'saved_at' => now()->toISOString(),
            ]);
            
        } catch (Exception $e) {
            Log::error('Failed to save GrapesJS data', [
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
        $bladeContent = $page->blade_content;
        if (empty($bladeContent) && ! empty($page->block_layout) && is_array($page->block_layout)) {
            try {
                $bladeContent = $this->blockLayoutService
                    ->processBlockLayoutForSave($page->block_layout)['blade_content'] ?? '';
            } catch (Exception) {
                $bladeContent = '';
            }
        }

        if (! empty($bladeContent)) {
            try {
                return Blade::render($bladeContent, ['page' => $page]);
            } catch (Exception $e) {
                Log::warning('Failed to render page blade_content', [
                    'page_id' => $page->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

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
        if (! empty($css)) {
            $html = "<style>{$css}</style>".$html;
        }

        return $html;
    }
    
    /**
     * Create a default homepage
     */
    private function createDefaultHomepage(): Page
    {
        return Page::create([
            'title' => 'Welcome to LaraGrape',
            'slug' => 'home',
            'content' => '<h1>Welcome to LaraGrape</h1><p>This is your Laravel + GrapesJS + Filament boilerplate. Edit this page in the admin panel.</p>',
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
