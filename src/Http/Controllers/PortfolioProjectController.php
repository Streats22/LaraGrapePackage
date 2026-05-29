<?php

namespace LaraGrape\Http\Controllers;

use LaraGrape\Models\PortfolioProject;
use LaraGrape\Models\Page;
use LaraGrape\Services\GrapesJsConverterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Exception;
use Throwable;

class PortfolioProjectController extends Controller
{
    public function __construct(
        protected GrapesJsConverterService $converterService
    ) {}

    public function show(string $slug): View|Response
    {
        $query = PortfolioProject::query()->where('slug', $slug);
        if (! Auth::check()) {
            $query->published();
        }
        $project = $query->firstOrFail();

        $page = Page::make([
            'title' => $project->title,
            'meta_title' => $project->meta_title ?: $project->title,
            'meta_description' => $project->meta_description ?? $project->excerpt,
            'meta_keywords' => null,
            'featured_image' => $project->featured_image,
            'slug' => 'home',
            'blade_content' => null,
            'content' => null,
        ]);

        try {
            $editingData = $this->initialPortfolioEditingData($project, $page);
            $html = view('portfolio.show', [
                'page' => $page,
                'portfolioProject' => $project,
                'editingData' => $editingData,
            ])->render();

            return response($html);
        } catch (Throwable $e) {
            Log::error('Portfolio detail render failed, serving fallback page', [
                'portfolio_project_id' => $project->id,
                'slug' => $slug,
                'error' => $e->getMessage(),
            ]);

            return response()->view('portfolio.fallback-show', [
                'page' => $page,
                'portfolioProject' => $project,
            ]);
        }
    }

    /**
     * GrapesJS initial payload: saved editor state, else rendered builder output, else default article HTML.
     */
    private function initialPortfolioEditingData(PortfolioProject $project, Page $page): array
    {
        if (! empty($project->grapesjs_data)) {
            $editingData = $this->converterService->processForEditing($project->grapesjs_data);
            $html = trim((string) ($editingData['html'] ?? ''));
            if ($html !== '') {
                return $editingData;
            }
        }

        if (! empty($project->blade_content)) {
            try {
                $rendered = Blade::render($project->blade_content, [
                    'page' => $page,
                    'portfolioProject' => $project,
                ]);

                return [
                    'html' => $rendered,
                    'css' => '',
                ];
            } catch (Throwable $e) {
                Log::warning('Portfolio editor: could not render blade_content for GrapesJS', [
                    'portfolio_project_id' => $project->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return [
            'html' => view('portfolio.partials.editor-bootstrap', ['portfolioProject' => $project])->render(),
            'css' => '',
        ];
    }

    /**
     * Save GrapesJS content from the frontend editor (same pipeline as admin Filament save).
     */
    public function saveGrapesJs(Request $request, PortfolioProject $portfolioProject): JsonResponse
    {
        Log::info('Portfolio project frontend GrapesJS save', [
            'portfolio_project_id' => $portfolioProject->id,
            'user' => Auth::id(),
        ]);

        if (! Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $request->validate([
            'html' => 'required|string',
            'css' => 'nullable|string',
        ]);

        try {
            $grapesjsData = [
                'html' => $request->input('html'),
                'css' => $request->input('css', ''),
                'saved_at' => now()->toISOString(),
                'saved_by' => Auth::id(),
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
            Log::error('Failed to save portfolio project GrapesJS (frontend)', [
                'portfolio_project_id' => $portfolioProject->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Failed to save content',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
