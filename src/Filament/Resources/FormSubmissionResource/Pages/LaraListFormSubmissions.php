<?php

namespace LaraGrape\Filament\Resources\FormSubmissionResource\Pages;

use LaraGrape\Filament\Resources\LaraFormSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormSubmissions extends ListRecords
{
    protected static string $resource = LaraFormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
