<?php

namespace LaraGrape\Filament\Resources\CustomBlockResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class LaraListCustomBlocks extends ListRecords
{
    protected static string $resource = CustomBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
