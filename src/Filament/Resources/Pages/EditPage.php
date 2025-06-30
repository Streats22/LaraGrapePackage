<?php

namespace Streats22\LaraGrape\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Streats22\LaraGrape\Services\GrapesJsConverterService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Debug logging
        \Log::info('EditPage mutateFormDataBeforeSave', [
            'data' => $data,
            'grapesjs_data_exists' => isset($data['grapesjs_data']),
            'grapesjs_data_type' => isset($data['grapesjs_data']) ? gettype($data['grapesjs_data']) : 'not set'
        ]);
        
        // Handle GrapesJS data
        if (isset($data['grapesjs_data']) && is_array($data['grapesjs_data'])) {
            $grapesjsData = $data['grapesjs_data'];
            
            // Get the converter service
            $converterService = app(GrapesJsConverterService::class);
            
            // Process the data for saving (convert to Blade components)
            $processedData = $converterService->processForSaving($grapesjsData);
            
            // Extract HTML and CSS from processed data
            $data['grapesjs_html'] = $processedData['html'] ?? null;
            $data['grapesjs_css'] = $processedData['css'] ?? null;
            
            // Keep the full processed data structure
            $data['grapesjs_data'] = $processedData;
            
            \Log::info('GrapesJS data processed', [
                'html' => $data['grapesjs_html'],
                'css' => $data['grapesjs_css'],
                'full_data' => $data['grapesjs_data']
            ]);
        } else {
            \Log::warning('GrapesJS data not found or not array', [
                'grapesjs_data' => $data['grapesjs_data'] ?? 'not set'
            ]);
        }
        
        return $data;
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // When loading data for editing, convert back to GrapesJS format if needed
        if (isset($data['grapesjs_data']) && is_array($data['grapesjs_data'])) {
            $savedData = $data['grapesjs_data'];
            
            // Get the converter service
            $converterService = app(GrapesJsConverterService::class);
            
            // Process the data for editing (convert back to GrapesJS format)
            $editingData = $converterService->processForEditing($savedData);
            
            // Update the data for the form
            $data['grapesjs_data'] = $editingData;
            
            \Log::info('GrapesJS data prepared for editing', [
                'original_data' => $savedData,
                'editing_data' => $editingData
            ]);
        }
        
        return $data;
    }
}
