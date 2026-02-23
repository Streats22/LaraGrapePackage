<?php

namespace LaraGrape\Filament\Resources\HeaderConfigResource\Pages;

use LaraGrape\Filament\Resources\LaraHeaderConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class LaraListHeaderConfigs extends ListRecords
{
    protected static string $resource = LaraHeaderConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
