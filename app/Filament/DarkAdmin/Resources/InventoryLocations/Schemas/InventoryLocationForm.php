<?php

namespace App\Filament\DarkAdmin\Resources\InventoryLocations\Schemas;

use Filament\Schemas\Schema;

class InventoryLocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),


            \Filament\Forms\Components\TextInput::make('name')
                ->label('Location Name')
                ->required()
                ->maxLength(255),

            \Filament\Forms\Components\TextInput::make('code')
                ->label('Code')
                ->required()
                ->maxLength(50)
                ->unique(ignoreRecord: true),

            \Filament\Forms\Components\Textarea::make('address')
                ->label('Address (JSON)')
                ->rows(3)
                ->json()
                ->nullable(),

            \Filament\Forms\Components\Toggle::make('is_primary')
                ->label('Is Primary Location')
                ->default(false),

            \Filament\Forms\Components\Toggle::make('manages_stock')
                ->label('Manages Stock')
                ->default(true),
            ]);
    }
}
