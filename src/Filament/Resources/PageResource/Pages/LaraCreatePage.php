<?php

namespace LaraGrape\Filament\Resources\PageResource\Pages;

use LaraGrape\Filament\Resources\LaraPageResource;
use LaraGrape\Filament\Resources\PageResource\Concerns\ProcessesPageEditorData;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class LaraCreatePage extends CreateRecord
{
    use ProcessesPageEditorData;

    protected static string $resource = LaraPageResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Create page')
                ->submit('create')
                ->color('primary')
                ->extraAttributes([
                    'onclick' => 'if(window.syncGrapesJsData) window.syncGrapesJsData(); return true;',
                ]),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->processPageEditorDataForSave($data);
    }

    protected function getRedirectUrl(): string
    {
        $record = $this->getRecord();

        return static::getResource()::getUrl('edit', ['record' => $record->getKey()]);
    }
}
