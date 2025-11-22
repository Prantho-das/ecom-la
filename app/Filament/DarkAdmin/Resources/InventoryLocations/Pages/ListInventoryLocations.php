<?php

namespace App\Filament\DarkAdmin\Resources\InventoryLocations\Pages;

use App\Filament\DarkAdmin\Resources\InventoryLocations\InventoryLocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventoryLocations extends ListRecords
{
    protected static string $resource = InventoryLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
