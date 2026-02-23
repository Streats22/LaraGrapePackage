<?php

namespace LaraGrape\Filament\Resources\MenuSetResource\Pages;

use LaraGrape\Filament\Resources\LaraMenuSetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenuSet extends EditRecord
{
    protected static string $resource = LaraMenuSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
