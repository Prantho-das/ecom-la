<?php

namespace App\Filament\DarkAdmin\Resources\Incoterms\Pages;

use App\Filament\DarkAdmin\Resources\Incoterms\IncotermResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIncoterm extends EditRecord
{
    protected static string $resource = IncotermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
