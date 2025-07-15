<?php

namespace LaraGrape\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use LaraGrape\Services\GrapesJsConverterService;

class GrapesJsEditor extends Field
{
    protected string $view = 'filament.forms.components.grapesjs-editor';
    
    protected string $height = '100vh';

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure the field is properly configured for JSON data
        $this->dehydrateStateUsing(function ($state) {
            if (is_array($state)) {
                return $state;
            }
            if (is_string($state)) {
                return json_decode($state, true) ?: [];
            }
            return [];
        });
        
        $this->mutateDehydratedStateUsing(function ($state) {
            if (is_array($state)) {
                return $state;
            }
            return [];
        });
        
        // Process the state for editing when the form is filled
        $this->afterStateHydrated(function ($state) {
            // If we have GrapesJS data, convert it back to original format for editing
            if (is_array($state) && isset($state['grapesjs_data']) && is_array($state['grapesjs_data'])) {
                $converterService = app(GrapesJsConverterService::class);
                $processedData = $converterService->processForEditing($state['grapesjs_data']);
                // Return the processed data directly for the editor
                return $processedData;
            }
            return $state;
        });

        // Ensure data is properly processed before saving
        $this->beforeStateDehydrated(function ($state) {
            // If we have GrapesJS data, ensure it's in the correct format
            if (is_array($state) && isset($state['grapesjs_data'])) {
                // If it's already processed data, return as is
                if (isset($state['grapesjs_data']['original_grapesjs'])) {
                    return $state;
                }
                
                // If it's raw GrapesJS data, process it
                if (isset($state['grapesjs_data']['html']) || isset($state['grapesjs_data']['css'])) {
                    $converterService = app(GrapesJsConverterService::class);
                    $processedData = $converterService->processForSaving($state['grapesjs_data']);
                    $state['grapesjs_data'] = $processedData;
                }
            }
            return $state;
        });
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function height(string $height): static
    {
        $this->height = $height;
        return $this;
    }
}
