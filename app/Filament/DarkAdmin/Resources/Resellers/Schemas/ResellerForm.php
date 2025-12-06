<?php

namespace App\Filament\DarkAdmin\Resources\Resellers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ResellerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('email')->email(),
                TextInput::make('phone'),
                TextInput::make('address'),
                TextInput::make('city'),
                TextInput::make('state'),
                TextInput::make('zip_code'),
                Select::make('country_id')
                    ->relationship('country', 'name')
                    ->required(),
                TextInput::make('contact_person'),
                TextInput::make('contact_email')->email(),
                TextInput::make('contact_phone'),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active')
                    ->required(),
                Textarea::make('notes')->columnSpan('full'),
            ]);
    }
}
