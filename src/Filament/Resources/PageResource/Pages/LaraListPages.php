<?php

namespace LaraGrape\Filament\Resources\PageResource\Pages;

use LaraGrape\Filament\Resources\LaraPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class LaraListPages extends ListRecords
{
    protected static string $resource = LaraPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
