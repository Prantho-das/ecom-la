<?php

namespace App\Filament\DarkAdmin\Resources\Solutions\Pages;

use App\Filament\DarkAdmin\Resources\Solutions\SolutionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSolution extends EditRecord
{
    protected static string $resource = SolutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
