<?php

namespace App\Filament\DarkAdmin\Resources\Resellers;

use App\Filament\DarkAdmin\Resources\Resellers\Pages\CreateReseller;
use App\Filament\DarkAdmin\Resources\Resellers\Pages\EditReseller;
use App\Filament\DarkAdmin\Resources\Resellers\Pages\ListResellers;
use App\Filament\DarkAdmin\Resources\Resellers\Schemas\ResellerForm;
use App\Filament\DarkAdmin\Resources\Resellers\Tables\ResellersTable;
use App\Models\Reseller;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ResellerResource extends Resource
{
    protected static ?string $model = Reseller::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ResellerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResellersTable::configure($table);
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
            'index' => ListResellers::route('/'),
            'create' => CreateReseller::route('/create'),
            'edit' => EditReseller::route('/{record}/edit'),
        ];
    }
}
