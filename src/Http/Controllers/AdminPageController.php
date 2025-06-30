<?php

namespace Streats22\LaraGrape\Http\Controllers;

use Streats22\LaraGrape\Models\Page;
use Streats22\LaraGrape\Services\GrapesJsConverterService;
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
            
            Log::info('Saving admin GrapesJS data', [
                'page_id' => $page->id,
                'grapesjs_data' => $processedData
            ]);
            
            // Update the page with the processed data
            $page->update([
                'grapesjs_data' => $processedData,
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
}
