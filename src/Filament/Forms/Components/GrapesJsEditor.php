<?php

namespace Streats22\LaraGrape\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class GrapesJsEditor extends Field
{
    protected string $view = 'filament.forms.components.grapesjs-editor';
    
    protected string $height = '700px';

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
