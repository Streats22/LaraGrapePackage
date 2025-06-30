<?php

namespace Streats22\LaraGrape\Filament\Resources\TailwindConfigResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTailwindConfig extends EditRecord
{
    protected static string $resource = TailwindConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 