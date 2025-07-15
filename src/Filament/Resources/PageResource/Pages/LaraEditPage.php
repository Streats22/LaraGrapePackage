<?php

namespace LaraGrape\Filament\Resources\PageResource\Pages;

use LaraGrape\Filament\Resources\PageResource;
use LaraGrape\Services\GrapesJsConverterService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class LaraEditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save changes')
                ->submit('save')
                ->color('primary')
                ->extraAttributes([
                    'onclick' => 'if(window.syncGrapesJsData) window.syncGrapesJsData(); return true;'
                ]),
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
            
            // Also save Blade content
            $data['blade_content'] = $converterService->convertToBlade($processedData);
            
            \Log::info('GrapesJS data processed for edit', [
                'original_data' => $grapesjsData,
                'processed_data' => $processedData,
                'html' => $data['grapesjs_html'],
                'css' => $data['grapesjs_css'],
                'blade_content' => $data['blade_content'],
            ]);
        } else {
            \Log::warning('GrapesJS data not found or not array for edit', [
                'grapesjs_data' => $data['grapesjs_data'] ?? 'not set'
            ]);
        }
        
        return $data;
    }
}
