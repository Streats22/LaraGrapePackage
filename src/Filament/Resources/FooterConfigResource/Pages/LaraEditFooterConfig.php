<?php

namespace LaraGrape\Filament\Resources\FooterConfigResource\Pages;

use LaraGrape\Filament\Resources\LaraFooterConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditFooterConfig extends EditRecord
{
    protected static string $resource = LaraFooterConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Show notification that cache was cleared
        Notification::make()
            ->title('Footer configuration updated')
            ->body('Layout cache has been automatically cleared. Changes should be visible on the frontend.')
            ->success()
            ->send();
    }
}
