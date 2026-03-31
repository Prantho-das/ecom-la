<?php

namespace App\Filament\DarkAdmin\Resources\Incoterms\Schemas;

use App\Models\Currency;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IncotermForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Incoterm Details')
                    ->description('Define the incoterm name and code.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->placeholder('e.g. Free On Board')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('code')
                            ->placeholder('e.g. FOB')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->default(true),
                    ]),

                Section::make('Applicable Costs')
                    ->description('Toggle which cost components are included in this incoterm\'s calculation.')
                    ->columns(4)
                    ->schema([
                        Toggle::make('has_export_freight')
                            ->label('Export Freight (Local)')
                            ->helperText('From Exwork to Port')
                            ->default(false),
                        Toggle::make('has_export_clearance')
                            ->label('Export Clearance')
                            ->helperText('Fees & documentation')
                            ->default(false),
                        Toggle::make('has_origin_thc')
                            ->label('Origin THC/FCL/LCL')
                            ->helperText('CBM × Rate/CBM')
                            ->default(false),
                        Toggle::make('has_int_freight')
                            ->label('International Freight')
                            ->helperText('Sea/Air charges')
                            ->default(false),
                        Toggle::make('has_insurance')
                            ->label('Insurance')
                            ->helperText('FOB/CIF risk coverage')
                            ->default(false),
                        Toggle::make('has_import_duties')
                            ->label('Import Duties & Taxes')
                            ->helperText('Customs + VAT in BDT')
                            ->default(false),
                        Toggle::make('has_handling_charges')
                            ->label('Handling Charges')
                            ->helperText('Port handling, demurrage')
                            ->default(false),
                        Toggle::make('has_inland_transport')
                            ->label('Inland Transport')
                            ->helperText('From port to store')
                            ->default(false),
                    ]),

                Section::make('Pricing Configuration Defaults')
                    ->columnSpanFull()
                    ->description('Set default cost configuration values for each currency. These will auto-fill when this incoterm + currency is selected in a quotation.')
                    ->schema([
                        Repeater::make('currency_defaults')
                            ->label('Currency Default Presets')
                            ->addActionLabel('Add Currency Preset')
                            ->columns(3)
                            ->schema([
                                Select::make('currency_code')
                                    ->label('Currency')
                                    ->options(fn () => Currency::where('is_active', true)->pluck('code', 'code'))
                                    ->required()
                                    ->searchable()
                                    ->columnSpanFull(),
                                TextInput::make('export_freight_rate')
                                    ->label('Export freight (local)- (From Exwork to Port)')
                                    ->numeric()
                                    ->step(0.001)
                                    ->default(0)
                                    ->suffix('%'),
                                TextInput::make('export_clearance_rate')
                                    ->label('Export clearance (Fees and docs)')
                                    ->numeric()
                                    ->step(0.001)
                                    ->default(0)
                                    ->suffix('%'),
                                 Split::make([
                                    TextInput::make('origin_thc_rate')
                                        ->label('Rate')
                                        ->grow(),
                                    Placeholder::make('thc_sep')
                                        ->label('')
                                        ->content('/')
                                        ->extraAttributes(['class' => 'self-center pt-8 px-2 text-gray-400 text-xl font-bold']),
                                    TextInput::make('origin_thc_qty')
                                        ->label('Qty')
                                        ->grow(),
                                ])->columnSpan(2),
                                TextInput::make('insurance_rate')
                                    ->label('Insurance (FOB/CIF risk coverage)')
                                    ->numeric()
                                    ->step(0.001)
                                    ->default(0)
                                    ->suffix('%'),
                                 Split::make([
                                    TextInput::make('import_duties_fixed')
                                        ->label('Fixed')
                                        ->grow(),
                                    Placeholder::make('id_sep')
                                        ->label('')
                                        ->content('/')
                                        ->extraAttributes(['class' => 'self-center pt-8 px-2 text-gray-400 text-xl font-bold']),
                                    TextInput::make('import_duties_multiplier')
                                        ->label('Multiplier')
                                        ->grow(),
                                ])->columnSpan(2),
                                TextInput::make('handling_charges_global')
                                    ->label('Handling charges (Port handling, demurrage)')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('inland_transport_global')
                                    ->label('Inland transport (From port to store)')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['currency_code'] ? "Currency: {$state['currency_code']}" : null),
                    ]),
            ]);
    }
}
