<?php

namespace App\Filament\DarkAdmin\Resources\InventoryLocations\Pages;

use App\Filament\DarkAdmin\Resources\InventoryLocations\InventoryLocationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInventoryLocation extends EditRecord
{
    protected static string $resource = InventoryLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
