<?php

namespace Streats22\LaraGrape\Filament\Resources\TailwindConfigResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTailwindConfigs extends ListRecords
{
    protected static string $resource = TailwindConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 