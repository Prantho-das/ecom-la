<?php

namespace App\Filament\DarkAdmin\Resources\NavigationMenus\Pages;

use App\Filament\DarkAdmin\Resources\NavigationMenus\NavigationMenuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageNavigationMenus extends ManageRecords
{
    protected static string $resource = NavigationMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
