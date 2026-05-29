<?php

namespace LaraGrape\Filament\Resources\LaraPortfolioProjectResource\Pages;

use LaraGrape\Filament\Resources\LaraPortfolioProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPortfolioProjects extends ListRecords
{
    protected static string $resource = LaraPortfolioProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
