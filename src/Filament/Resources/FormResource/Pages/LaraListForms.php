<?php

namespace LaraGrape\Filament\Resources\FormResource\Pages;

use LaraGrape\Filament\Resources\LaraFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForms extends ListRecords
{
    protected static string $resource = LaraFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
