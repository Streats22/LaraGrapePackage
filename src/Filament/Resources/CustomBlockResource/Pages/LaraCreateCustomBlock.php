<?php

namespace LaraGrape\Filament\Resources\CustomBlockResource\Pages;

use LaraGrape\Filament\Resources\LaraCustomBlockResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class LaraCreateCustomBlock extends CreateRecord
{
    protected static string $resource = LaraCustomBlockResource::class;
}
