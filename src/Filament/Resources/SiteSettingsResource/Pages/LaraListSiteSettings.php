<?php

namespace LaraGrape\Filament\Resources\SiteSettingsResource\Pages;

use LaraGrape\Filament\Resources\LaraSiteSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class LaraListSiteSettings extends ListRecords
{
    protected static string $resource = LaraSiteSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
