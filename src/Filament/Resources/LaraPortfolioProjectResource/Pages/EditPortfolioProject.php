<?php

namespace LaraGrape\Filament\Resources\LaraPortfolioProjectResource\Pages;

use LaraGrape\Filament\Resources\LaraPortfolioProjectResource;
use LaraGrape\Services\GrapesJsConverterService;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditPortfolioProject extends EditRecord
{
    protected static string $resource = LaraPortfolioProjectResource::class;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['grapesjs_data']) && is_array($data['grapesjs_data'])) {
            $converterService = app(GrapesJsConverterService::class);
            $processedData = $converterService->processForSaving($data['grapesjs_data']);
            $data['grapesjs_data'] = $processedData;
            $data['blade_content'] = $converterService->convertToBlade($processedData);
        }

        return $data;
    }
}
