<?php

namespace LaraGrape\Filament\Resources\HeaderConfigResource\Pages;

use LaraGrape\Filament\Resources\LaraHeaderConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class LaraEditHeaderConfig extends EditRecord
{
    protected static string $resource = LaraHeaderConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Header configuration updated')
            ->body('Layout cache has been automatically cleared. Changes should be visible on the frontend.')
            ->success()
            ->send();
    }
}
