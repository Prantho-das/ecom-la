<?php

namespace App\Filament\DarkAdmin\Resources\Resellers\Schemas;

use App\Models\Country;
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
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->nullable(),
                TextInput::make('phone')
                    ->tel()
                    ->nullable(),
                TextInput::make('address')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('city')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('state')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('zip_code')
                    ->maxLength(255)
                    ->nullable(),
                Select::make('country_id')
                    ->label('Country')
                    ->options(Country::pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
                TextInput::make('contact_person')
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('contact_email')
                    ->email()
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('contact_phone')
                    ->tel()
                    ->maxLength(255)
                    ->nullable(),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'pending' => 'Pending',
                    ])
                    ->default('pending')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }
}
