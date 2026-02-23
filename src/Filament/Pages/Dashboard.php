<?php

namespace LaraGrape\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Widgets\Widget;

class Dashboard extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'LaraGrape Admin';
    protected static ?string $slug = 'dashboard';
    protected static string|\UnitEnum|null $navigationGroup = 'Admin';

    public function getColumns(): int|array
    {
        return 2;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.pages.dashboard', [
            'resources' => [
                [
                    'label' => 'Pages',
                    'icon' => 'heroicon-o-document-text',
                    'route' => 'filament.admin.resources.pages.index',
                ],
                [
                    'label' => 'Custom Blocks',
                    'icon' => 'heroicon-o-cube',
                    'route' => 'filament.admin.resources.custom-blocks.index',
                ],
                [
                    'label' => 'Tailwind Config',
                    'icon' => 'heroicon-o-paint-brush',
                    'route' => 'filament.admin.resources.tailwind-configs.index',
                ],
                [
                    'label' => 'Site Settings',
                    'icon' => 'heroicon-o-cog-6-tooth',
                    'route' => 'filament.admin.resources.site-settings.index',
                ],
            ],
        ]);
    }
} 