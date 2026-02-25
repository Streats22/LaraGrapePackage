<?php

namespace LaraGrape\Filament\Resources\FormResource\Pages;

use LaraGrape\Filament\Resources\LaraFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    protected static string $resource = LaraFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
