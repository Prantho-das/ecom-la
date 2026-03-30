<?php

namespace App\Filament\DarkAdmin\Resources\Incoterms\Pages;

use App\Filament\DarkAdmin\Resources\Incoterms\IncotermResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIncoterms extends ListRecords
{
    protected static string $resource = IncotermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
