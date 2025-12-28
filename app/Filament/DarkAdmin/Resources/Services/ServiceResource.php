<?php

namespace App\Filament\DarkAdmin\Resources\Services;

use App\Filament\DarkAdmin\Resources\Services\Pages\CreateService;
use App\Filament\DarkAdmin\Resources\Services\Pages\EditService;
use App\Filament\DarkAdmin\Resources\Services\Pages\ListService;
use App\Filament\DarkAdmin\Resources\Services\Schemas\ServiceForm;
use App\Filament\DarkAdmin\Resources\Services\Tables\ServiceTable;
use App\Models\Service;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListService::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
