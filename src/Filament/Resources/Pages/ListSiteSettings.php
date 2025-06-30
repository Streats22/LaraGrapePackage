<?php

namespace Streats22\LaraGrape\Filament\Resources\SiteSettingsResource\Pages;

use Streats22\LaraGrape\Filament\Resources\SiteSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
