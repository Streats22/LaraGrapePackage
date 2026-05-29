<?php

namespace LaraGrape\Filament\Resources\LaraPortfolioProjectResource\Pages;

use LaraGrape\Filament\Resources\LaraPortfolioProjectResource;
use LaraGrape\Services\GrapesJsConverterService;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreatePortfolioProject extends CreateRecord
{
    protected static string $resource = LaraPortfolioProjectResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Create project')
                ->submit('create')
                ->color('primary')
                ->extraAttributes([
                    'onclick' => 'if(window.syncGrapesJsData) window.syncGrapesJsData(); return true;',
                ]),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['grapesjs_data']) && is_array($data['grapesjs_data'])) {
            $converterService = app(GrapesJsConverterService::class);
            $processedData = $converterService->processForSaving($data['grapesjs_data']);
            $data['grapesjs_data'] = $processedData;
            $data['blade_content'] = $converterService->convertToBlade($processedData);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        $record = $this->getRecord();

        return static::getResource()::getUrl('edit', ['record' => $record->getKey()]);
    }
}
