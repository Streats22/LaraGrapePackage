<?php

namespace LaraGrape\Filament\Resources\CustomBlockResource\Pages;

use LaraGrape\Filament\Resources\CustomBlockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomBlock extends EditRecord
{
    protected static string $resource = CustomBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
