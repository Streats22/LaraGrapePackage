<?php

namespace LaraGrape\Filament\Resources\TailwindConfigResource\Pages;

use LaraGrape\Filament\Resources\LaraTailwindConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class LaraListTailwindConfigs extends ListRecords
{
    protected static string $resource = LaraTailwindConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 