<?php

namespace App\Filament\DarkAdmin\Resources\NavigationLinks\Pages;

use App\Filament\DarkAdmin\Resources\NavigationLinks\NavigationLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNavigationLink extends EditRecord
{
    protected static string $resource = NavigationLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
