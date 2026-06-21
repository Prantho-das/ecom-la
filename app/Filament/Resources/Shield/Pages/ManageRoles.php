<?php

namespace App\Filament\Resources\Shield\Pages;

use App\Filament\Resources\Shield\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRoles extends ManageRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['guard_name'] = 'web';
                    return $data;
                })
                ->after(function ($record, array $data) {
                    if (isset($data['permissions'])) {
                        $record->syncPermissions($data['permissions']);
                    }
                }),
        ];
    }
}
