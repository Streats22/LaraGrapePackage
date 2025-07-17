<?php

namespace LaraGrape\Filament\Resources\TailwindConfigResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use LaraGrape\Models\TailwindConfig;

class LaraEditTailwindConfig extends EditRecord
{
    protected static string $resource = TailwindConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('reloadFromActive')
                ->label('Reload from Active Tailwind Config')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $activeConfig = TailwindConfig::where('is_active', true)->first();
                    if ($activeConfig) {
                        $this->form->fill($activeConfig->toArray());
                        \Filament\Notifications\Notification::make()
                            ->title('Settings reloaded from active Tailwind config!')
                            ->success()
                            ->send();
                    } else {
                        \Filament\Notifications\Notification::make()
                            ->title('No active Tailwind config found.')
                            ->danger()
                            ->send();
                    }
                }),
            Actions\Action::make('rebuildTailwind')
                ->label('Rebuild Tailwind CSS')
                ->action('rebuildTailwind')
                ->requiresConfirmation()
                ->color('primary'),
        ];
    }

    public function getActions(): array
    {
        return [
            Actions\Action::make('reloadFromActive')
                ->label('Reload from Active Tailwind Config')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $activeConfig = TailwindConfig::where('is_active', true)->first();
                    if ($activeConfig) {
                        $this->form->fill($activeConfig->toArray());
                        \Filament\Notifications\Notification::make()
                            ->title('Settings reloaded from active Tailwind config!')
                            ->success()
                            ->send();
                    } else {
                        \Filament\Notifications\Notification::make()
                            ->title('No active Tailwind config found.')
                            ->danger()
                            ->send();
                    }
                }),
            Action::make('rebuildTailwind')
                ->label('Rebuild Tailwind CSS')
                ->action('rebuildTailwind')
                ->requiresConfirmation()
                ->color('primary'),
        ];
    }

    public function rebuildTailwind()
    {
        $exitCode = Artisan::call('tailwind:rebuild');
        if ($exitCode === 0) {
            Notification::make()
                ->title('Tailwind CSS rebuilt!')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Tailwind build failed')
                ->danger()
                ->body(Artisan::output())
                ->send();
        }
    }
}
