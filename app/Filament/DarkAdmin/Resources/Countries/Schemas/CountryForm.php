<?php

namespace App\Filament\DarkAdmin\Resources\Countries\Schemas;

use App\Models\Continent;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->required()
                    ->maxLength(2)
                    ->minLength(2),
                Select::make('continent_id')
                    ->options(Continent::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }
}
