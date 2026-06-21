<?php

namespace App\Filament\DarkAdmin\Resources\Users\Pages;

use App\Filament\DarkAdmin\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['role'] = 'customer';
                    return $data;
                })
                ->after(function ($record, array $data) {
                    if (isset($data['roles'])) {
                        $record->syncRoles($data['roles']);
                    }
                }),
        ];
    }
}
