<?php

namespace LaraGrape\Filament\Resources\FooterConfigResource\Pages;

use LaraGrape\Filament\Resources\LaraFooterConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFooterConfigs extends ListRecords
{
    protected static string $resource = LaraFooterConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
