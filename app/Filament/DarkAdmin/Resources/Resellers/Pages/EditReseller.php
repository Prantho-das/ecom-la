<?php

namespace App\Filament\DarkAdmin\Resources\Resellers\Pages;

use App\Filament\DarkAdmin\Resources\Resellers\ResellerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReseller extends EditRecord
{
    protected static string $resource = ResellerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
