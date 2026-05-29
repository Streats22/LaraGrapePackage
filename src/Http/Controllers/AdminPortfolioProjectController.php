<?php

namespace LaraGrape\Http\Controllers;

use LaraGrape\Models\PortfolioProject;
use LaraGrape\Services\GrapesJsConverterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminPortfolioProjectController extends Controller
{
    public function __construct(
        protected GrapesJsConverterService $converterService
    ) {}

    public function saveGrapesJs(Request $request, PortfolioProject $portfolioProject): JsonResponse
    {
        $request->validate([
            'html' => 'required|string',
            'css' => 'nullable|string',
        ]);

        try {
            $grapesjsData = [
                'html' => $request->input('html'),
                'css' => $request->input('css', ''),
                'saved_at' => now()->toISOString(),
                'saved_by' => auth()->id(),
            ];

            $processedData = $this->converterService->processForSaving($grapesjsData);

            if (! isset($processedData['original_grapesjs'])) {
                $processedData['original_grapesjs'] = $grapesjsData;
            }

            $bladeContent = $this->converterService->convertToBlade($processedData);

            $portfolioProject->update([
                'grapesjs_data' => $processedData,
                'blade_content' => $bladeContent,
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Portfolio project layout saved successfully',
                'saved_at' => now()->toISOString(),
            ]);
        } catch (Exception $e) {
            Log::error('Failed to save portfolio project GrapesJS', [
                'portfolio_project_id' => $portfolioProject->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Failed to save content',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
