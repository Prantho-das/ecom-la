<?php

namespace App\Filament\DarkAdmin\Resources\Countries;

use App\Filament\DarkAdmin\Resources\Countries\Pages\CreateCountry;
use App\Filament\DarkAdmin\Resources\Countries\Pages\EditCountry;
use App\Filament\DarkAdmin\Resources\Countries\Pages\ListCountries;
use App\Filament\DarkAdmin\Resources\Countries\Schemas\CountryForm;
use App\Filament\DarkAdmin\Resources\Countries\Tables\CountriesTable;
use App\Models\Country;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;
class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-flag';

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CountryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CountriesTable::configure($table);
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
            'index' => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'edit' => EditCountry::route('/{record}/edit'),
        ];
    }
}
