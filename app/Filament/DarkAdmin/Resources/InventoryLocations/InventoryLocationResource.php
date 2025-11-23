<?php

namespace App\Filament\DarkAdmin\Resources\InventoryLocations;

use App\Filament\DarkAdmin\Resources\InventoryLocations\Pages\CreateInventoryLocation;
use App\Filament\DarkAdmin\Resources\InventoryLocations\Pages\EditInventoryLocation;
use App\Filament\DarkAdmin\Resources\InventoryLocations\Pages\ListInventoryLocations;
use App\Filament\DarkAdmin\Resources\InventoryLocations\Schemas\InventoryLocationForm;
use App\Filament\DarkAdmin\Resources\InventoryLocations\Tables\InventoryLocationsTable;
use App\Models\InventoryLocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;
class InventoryLocationResource extends Resource
{
    protected static ?string $model = InventoryLocation::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return InventoryLocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryLocationsTable::configure($table);
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
            'index' => ListInventoryLocations::route('/'),
            'create' => CreateInventoryLocation::route('/create'),
            'edit' => EditInventoryLocation::route('/{record}/edit'),
        ];
    }
}
