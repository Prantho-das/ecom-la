<?php

namespace App\Filament\DarkAdmin\Resources\Solutions\Pages;

use App\Filament\DarkAdmin\Resources\Solutions\SolutionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSolutions extends ListRecords
{
    protected static string $resource = SolutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
