<?php

namespace App\Filament\DarkAdmin\Resources\Resellers\Pages;

use App\Filament\DarkAdmin\Resources\Resellers\ResellerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListResellers extends ListRecords
{
    protected static string $resource = ResellerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
