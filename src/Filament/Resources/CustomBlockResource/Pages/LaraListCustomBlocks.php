<?php

namespace LaraGrape\Filament\Resources\CustomBlockResource\Pages;

use LaraGrape\Filament\Resources\LaraCustomBlockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class LaraListCustomBlocks extends ListRecords
{
    protected static string $resource = LaraCustomBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
