<?php

namespace LaraGrape\Filament\Resources\PageResource\Pages;

use LaraGrape\Filament\Resources\LaraPageResource;
use LaraGrape\Filament\Resources\PageResource\Concerns\ProcessesPageEditorData;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use LaraGrape\Support\EditorSettings;

class LaraEditPage extends EditRecord
{
    use ProcessesPageEditorData;

    protected static string $resource = LaraPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save changes')
                ->submit('save')
                ->color('primary')
                ->extraAttributes([
                    'onclick' => 'if(window.syncGrapesJsData) window.syncGrapesJsData(); return true;',
                ]),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (! isset($data['editor_mode']) || $data['editor_mode'] === '') {
            $data['editor_mode'] = EditorSettings::defaultPageEditorMode();
        }

        return $this->hydrateBlockLayoutFromStoredContent($data);
    }

    protected function afterFill(): void
    {
        $state = $this->form->getState();
        $storedHtml = $this->record->grapesjs_data['html']
            ?? $this->record->grapesjs_data['original_grapesjs']['html']
            ?? null;

        if (
            ($state['editor_mode'] ?? '') === EditorSettings::PAGE_MODE_BLOCK
            && empty($state['block_layout'])
            && is_string($storedHtml)
            && trim($storedHtml) !== ''
        ) {
            Notification::make()
                ->title('Block list could not be imported from the visual layout')
                ->body('Add blocks manually in the Block Builder tab, or switch back to Visual mode.')
                ->warning()
                ->send();
        }
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->processPageEditorDataForSave($data);
    }
}
