<?php

namespace Streats22\LaraGrape\Filament\Resources\CustomBlockResource\Pages;

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
