<?php

namespace App\Filament\DarkAdmin\Resources\Incoterms;

use App\Filament\DarkAdmin\Resources\Incoterms\Pages\CreateIncoterm;
use App\Filament\DarkAdmin\Resources\Incoterms\Pages\EditIncoterm;
use App\Filament\DarkAdmin\Resources\Incoterms\Pages\ListIncoterms;
use App\Filament\DarkAdmin\Resources\Incoterms\Schemas\IncotermForm;
use App\Filament\DarkAdmin\Resources\Incoterms\Tables\IncotermTable;
use App\Models\Incoterm;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class IncotermResource extends Resource
{
    protected static ?string $model = Incoterm::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static string|\UnitEnum|null $navigationGroup = 'System Settings';

    protected static ?string $navigationLabel = 'Incoterms';

    protected static ?string $pluralModelLabel = 'Incoterms';

    public static function form(Schema $schema): Schema
    {
        return IncotermForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IncotermTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncoterms::route('/'),
            'create' => CreateIncoterm::route('/create'),
            'edit' => EditIncoterm::route('/{record}/edit'),
        ];
    }
}
