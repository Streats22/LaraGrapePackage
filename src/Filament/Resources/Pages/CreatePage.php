<?php

namespace Streats22\LaraGrape\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Debug logging
        \Log::info('CreatePage mutateFormDataBeforeCreate', [
            'data' => $data,
            'grapesjs_data_exists' => isset($data['grapesjs_data']),
            'grapesjs_data_type' => isset($data['grapesjs_data']) ? gettype($data['grapesjs_data']) : 'not set'
        ]);
        
        // Handle GrapesJS data
        if (isset($data['grapesjs_data']) && is_array($data['grapesjs_data'])) {
            $grapesjsData = $data['grapesjs_data'];
            
            // Extract HTML and CSS from GrapesJS data
            $data['grapesjs_html'] = $grapesjsData['html'] ?? null;
            $data['grapesjs_css'] = $grapesjsData['css'] ?? null;
            
            // Keep the full data structure for future use
            $data['grapesjs_data'] = $grapesjsData;
            
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
}
