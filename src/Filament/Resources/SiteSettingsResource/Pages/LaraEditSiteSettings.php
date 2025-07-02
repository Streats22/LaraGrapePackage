<?php

namespace LaraGrape\Filament\Resources\SiteSettingsResource\Pages;

use LaraGrape\Filament\Resources\LaraSiteSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class LaraEditSiteSettings extends EditRecord
{
    protected static string $resource = LaraSiteSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
