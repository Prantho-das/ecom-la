<?php

namespace App\Filament\DarkAdmin\Resources\Incoterms\Schemas;

use App\Models\Currency;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
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
                        Toggle::make('has_custom_cost_factor')
                            ->label('Cost Factor')
                            ->helperText('Custom cost factor')
                            ->default(false),
                    ]),

                Section::make('Pricing Configuration Defaults')
                    ->columnSpanFull()
                    ->description('Set default cost configuration values for each currency. These will auto-fill when this incoterm + currency is selected in a quotation.')
                    ->schema([
                        Repeater::make('currency_defaults')
                            ->label('Currency Default Presets')
                            ->addActionLabel('Add Currency Preset')
                            ->columns(4)
                            ->schema([
                                Select::make('currency_code')
                                    ->label('Currency')
                                    ->options(fn () => Currency::where('is_active', true)->pluck('code', 'code'))
                                    ->required()
                                    ->searchable()
                                    ->columnSpanFull(),

                                // Group 1: General Business Rates
                                TextInput::make('margin')
                                    ->label('MG %')
                                    ->numeric()
                                    ->step(0.01)
                                    ->default(0)
                                    ->suffix('%'),
                                TextInput::make('tax')
                                    ->label('TAX %')
                                    ->numeric()
                                    ->step(0.01)
                                    ->default(0)
                                    ->suffix('%'),
                                TextInput::make('vat')
                                    ->label('VAT %')
                                    ->numeric()
                                    ->step(0.01)
                                    ->default(0)
                                    ->suffix('%'),
                                TextInput::make('discount')
                                    ->label('Disc %')
                                    ->numeric()
                                    ->step(0.01)
                                    ->default(0)
                                    ->suffix('%'),

                                // Group 2: Single-value Costs
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
                                TextInput::make('handling_charges_global')
                                    ->label('Handling charges (Port handling, demurrage)')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('inland_transport_global')
                                    ->label('Inland transport (From port to store)')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('custom_cost_factor_rate')
                                    ->label('Cost Factor')
                                    ->numeric()
                                    ->default(0),

                                // Group 3: Compound Costs Row 1 (2 + 2 = 4)
                                Fieldset::make('Origin THC/FCL/LCL')
                                    ->schema([
                                        TextInput::make('origin_thc_rate')
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->step(0.001)
                                            ->default(0)
                                            ->suffix('/'),
                                        TextInput::make('origin_thc_qty')
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->step(0.001)
                                            ->default(0),
                                    ])->columns(2)->columnSpan(2),
                                Fieldset::make('International Freight (CBM / KG)')
                                    ->schema([
                                        TextInput::make('int_freight_cbm')
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->step(0.001)
                                            ->default(0)
                                            ->suffix('/'),
                                        TextInput::make('int_freight_kg')
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->step(0.001)
                                            ->default(0),
                                    ])->columns(2)->columnSpan(2),

                                // Group 4: Compound Costs Row 2
                                Fieldset::make('Import Duties (Fixed / Multiplier)')
                                    ->schema([
                                        TextInput::make('import_duties_fixed')
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->step(0.001)
                                            ->default(0)
                                            ->suffix('/'),
                                        TextInput::make('import_duties_multiplier')
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->step(0.001)
                                            ->default(0),
                                    ])->columns(2)->columnSpan(2),
                                TextInput::make('insurance_rate')
                                    ->label('Insurance (FOB/CIF risk coverage)')
                                    ->numeric()
                                    ->step(0.001)
                                    ->default(0)
                                    ->suffix('%')
                                    ->columnSpan(2),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['currency_code'] ? "Currency: {$state['currency_code']}" : null),
                    ]),
            ]);
    }
}
