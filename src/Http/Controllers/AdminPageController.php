<?php

namespace LaraGrape\Http\Controllers;

use LaraGrape\Models\Page;
use LaraGrape\Services\GrapesJsConverterService;
use LaraGrape\Services\BlockService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AdminPageController extends Controller
{
    protected GrapesJsConverterService $converterService;
    
    public function __construct(GrapesJsConverterService $converterService)
    {
        $this->converterService = $converterService;
    }

    public function saveGrapesJs(Request $request, Page $page): JsonResponse
    {
        // Debug logging
        Log::info('Admin GrapesJS save request', [
            'page_id' => $page->id,
            'user' => auth()->id(),
            'request_data' => $request->all()
        ]);
        
        // Validate the request
        $request->validate([
            'html' => 'required|string',
            'css' => 'nullable|string',
        ]);
        
        try {
            // Prepare the GrapesJS data (same structure as frontend)
            $grapesjsData = [
                'html' => $request->input('html'),
                'css' => $request->input('css', ''),
                'saved_at' => now()->toISOString(),
                'saved_by' => auth()->id(),
            ];
            
            // Process the data for saving (convert to Blade components if needed)
            $processedData = $this->converterService->processForSaving($grapesjsData);
            
            // Ensure original GrapesJS data is preserved for editing
            if (!isset($processedData['original_grapesjs'])) {
                $processedData['original_grapesjs'] = $grapesjsData;
            }
            
            // Convert to Blade content for frontend rendering
            $bladeContent = $this->converterService->convertToBlade($processedData);
            
            Log::info('Saving admin GrapesJS data', [
                'page_id' => $page->id,
                'grapesjs_data' => $processedData,
                'blade_content' => $bladeContent
            ]);
            
            // Update the page with both processed data and Blade content
            $page->update([
                'grapesjs_data' => $processedData,
                'blade_content' => $bladeContent,
                'updated_at' => now(),
            ]);
            
            Log::info('Admin GrapesJS data saved successfully', ['page_id' => $page->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Page builder content saved successfully',
                'saved_at' => now()->toISOString(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to save admin GrapesJS data', [
                'page_id' => $page->id,
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
     * Serve a rendered block preview for GrapesJS/editor
     * GET /admin/block-preview/{blockId}
     */
    public function blockPreview($blockId)
    {
        try {
            Log::info('Block preview request', ['blockId' => $blockId]);
            
            // Handle new block ID format: 'category/blockname' (e.g., 'components/button')
            $viewPath = null;
            
            if (strpos($blockId, '/') !== false) {
                // New format: category/blockname
                $viewPath = 'filament.blocks.' . str_replace('/', '.', $blockId);
            } else {
                // Simple block ID format: try to find the block in all categories
                $possiblePaths = [
                    'filament.blocks.components.' . $blockId, // components subdirectory
                    'filament.blocks.content.' . $blockId, // content subdirectory
                    'filament.blocks.forms.' . $blockId, // forms subdirectory
                    'filament.blocks.layouts.' . $blockId, // layouts subdirectory
                    'filament.blocks.media.' . $blockId, // media subdirectory
                ];
                
                foreach ($possiblePaths as $path) {
                    if (view()->exists($path)) {
                        $viewPath = $path;
                        break;
                    }
                }
            }
            
            if (!$viewPath) {
                Log::warning('Block view not found', [
                    'blockId' => $blockId,
                    'attempted_path' => $viewPath
                ]);
                return response()->json(['error' => 'Block view not found: ' . $blockId], 404);
            }
            
            Log::info('Rendering block preview', ['viewPath' => $viewPath]);
            $html = view($viewPath)->render();
            return response($html);
            
        } catch (\Exception $e) {
            Log::error('Failed to load block preview', [
                'blockId' => $blockId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to load preview: ' . $e->getMessage()], 500);
        }
    }
}
