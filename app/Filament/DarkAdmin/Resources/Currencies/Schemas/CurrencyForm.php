<?php

namespace App\Filament\DarkAdmin\Resources\Currencies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CurrencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Currency Details')
                    ->description('General information about the currency.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->placeholder('e.g. US Dollar')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('code')
                            ->placeholder('e.g. USD')
                            ->required()
                            ->length(3)
                            ->unique(ignoreRecord: true)
                            ->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                        TextInput::make('symbol')
                            ->placeholder('e.g. $')
                            ->maxLength(10),
                    ]),

                Section::make('Exchange Configuration')
                    ->description('Set this currency as the base or define its exchange rate.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_base')
                            ->label('Is Base Currency')
                            ->helperText('Setting this will unset any other base currency. You cannot unset the base currency directly.')
                            ->live()
                            ->required()
                            ->disabled(fn ($record) => $record?->is_base ?? false)
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $set('exchange_rate', 1.0);
                                }
                            }),
                        TextInput::make('exchange_rate')
                            ->numeric()
                            ->required()
                            ->default(1.0)
                            ->hint('Relative to base currency')
                            ->disabled(fn ($get) => $get('is_base')),
                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }
}
