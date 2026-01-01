<?php

namespace App\Filament\DarkAdmin\Resources\SolutionCategories\Pages;

use App\Filament\DarkAdmin\Resources\SolutionCategories\SolutionCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSolutionCategories extends ManageRecords
{
    protected static string $resource = SolutionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
