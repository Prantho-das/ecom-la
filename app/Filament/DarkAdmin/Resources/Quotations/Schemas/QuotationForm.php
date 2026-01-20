<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Schemas;

use App\Models\ProductVariant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class QuotationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([

                // LEFT COLUMN - Customer & Configuration
                Section::make('Customer Information')
                    ->description('Enter customer details')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter customer name'),

                        TextInput::make('customer_email')
                            ->label('Customer Email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->placeholder('customer@example.com'),

                        DatePicker::make('expires_at')
                            ->label('Expiration Date')
                            ->native(false)
                            ->placeholder('Select expiration date'),

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'sent' => 'Sent',
                                'accepted' => 'Accepted',
                                'rejected' => 'Rejected',
                                'expired' => 'Expired',
                            ])
                            ->default('draft')
                            ->required(),

                        Textarea::make('notes')
                            ->label('Notes / Special Instructions')
                            ->rows(3)
                            ->placeholder('Add any special notes or instructions'),
                    ])
                    ->collapsible()
                    ->columnSpan(1),

                // MIDDLE COLUMN - Shipping Configuration (Like Excel Sheet)
                Section::make('📋 Shipping Configuration')
                    ->description('Configure shipping method and pricing tier (as per Price Sheet)')
                    ->icon('heroicon-o-truck')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Select::make('shipping_method')
                                    ->label('🚢 Shipping Method')
                                    ->options([
                                        'sea' => '🚢 Sea Shipment',
                                        'air' => '✈️ Air Shipment',
                                    ])
                                    ->default('sea')
                                    ->reactive()
                                    ->required()
                                    ->helperText('Select transportation method')
                                    ->afterStateUpdated(
                                        fn($state, $set) =>
                                        $set('_recalculate', true)
                                    ),

                                Select::make('pricing_tier')
                                    ->label('📦 Pricing Tier (Incoterm)')
                                    ->options([
                                        'exwork' => 'Exwork - Factory Price',
                                        'fob' => 'FOB - Free on Board',
                                        'cfr' => 'CFR - Cost and Freight',
                                        'cif' => 'CIF - Cost, Insurance, Freight',
                                        'ddu_dap' => 'DDU/DAP - Delivered Duty Unpaid',
                                        'ddp' => 'DDP - Delivered Duty Paid',
                                        'bdt_local' => 'BDT - Local Currency (All Inclusive)',
                                    ])
                                    ->default('exwork')
                                    ->reactive()
                                    ->required()
                                    ->helperText('Select pricing tier from Excel sheet')
                                    ->afterStateUpdated(
                                        fn($state, $set) =>
                                        $set('_recalculate', true)
                                    ),

                                Placeholder::make('pricing_info')
                                    ->content(fn($get) => match ($get('pricing_tier')) {
                                        'exwork' => '✓ Base price only',
                                        'fob' => '✓ Base + Export Freight + Clearance + Origin Handling',
                                        'cfr' => '✓ FOB + International Freight',
                                        'cif' => '✓ CFR + Insurance',
                                        'ddu_dap' => '✓ CIF + Handling + Inland Transport',
                                        'ddp' => '✓ DDU + Import Duties',
                                        'bdt_local' => '✓ DDP + Currency Conversion to BDT',
                                        default => 'Select a pricing tier'
                                    })
                                    ->helperText('Cost components included'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('currency')
                                    ->label('💱 Currency')
                                    ->options([
                                        'USD' => 'USD ($)',
                                        'EUR' => 'EUR (€)',
                                        'CNY' => 'CNY (¥)',
                                    ])
                                    ->default('USD')
                                    ->reactive()
                                    ->required(),

                                TextInput::make('conversion_rate')
                                    ->label('Exchange Rate (to BDT)')
                                    ->numeric()
                                    ->default(125)
                                    ->reactive()
                                    ->required()
                                    ->suffix('BDT')
                                    ->helperText('1 USD = ? BDT'),
                            ]),
                    ])
                    ->collapsible()
                    ->columnSpan(1),

                // RIGHT COLUMN - Margins & Taxes
                Section::make('💰 Margins & Taxes')
                    ->description('Configure profit margins and tax rates')
                    ->icon('heroicon-o-calculator')
                    ->schema([
                        TextInput::make('margin_percentage')
                            ->label('Profit Margin (MG %)')
                            ->numeric()
                            ->default(30)
                            ->suffix('%')
                            ->reactive()
                            ->required()
                            ->helperText('Profit margin percentage')
                            ->minValue(0)
                            ->maxValue(100),

                        TextInput::make('tax_percentage')
                            ->label('Tax (%)')
                            ->numeric()
                            ->default(5)
                            ->suffix('%')
                            ->reactive()
                            ->required()
                            ->helperText('Tax percentage')
                            ->minValue(0)
                            ->maxValue(100),

                        TextInput::make('vat_percentage')
                            ->label('VAT (%)')
                            ->numeric()
                            ->default(10)
                            ->suffix('%')
                            ->reactive()
                            ->required()
                            ->helperText('VAT percentage')
                            ->minValue(0)
                            ->maxValue(100),

                        TextInput::make('discount_total')
                            ->label('Discount Amount')
                            ->numeric()
                            ->default(0)
                            ->prefix('৳')
                            ->helperText('Total discount to apply'),

                        Placeholder::make('tax_info')
                            ->content(
                                fn($get) =>
                                'Total Tax: ' . ($get('tax_percentage') + $get('vat_percentage')) . '%'
                            )
                            ->helperText('Combined tax rate'),
                    ])
                    ->collapsible()
                    ->columnSpan(1),

                // FULL WIDTH - Products Section (Like Excel Rows)
                Section::make('📦 Quotation Items')
                    ->description('Add products with specifications (matching Excel Price Sheet structure)')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                // Row 1: Product Selection & Basic Info
                                Grid::make(12)
                                    ->schema([
                                        Select::make('variant_id')
                                            ->label('Select Product')
                                            ->reactive()
                                            ->options(ProductVariant::with('product')->get()->mapWithKeys(function ($variant) {
                                                return [$variant->id => $variant->product->name . ' - ' . $variant->title];
                                            }))
                                            ->searchable()
                                            ->required()
                                            ->afterStateUpdated(function ($state, $set) {
                                                $variant = ProductVariant::find($state);
                                                if ($variant) {
                                                    $set('name', $variant->title);
                                                    $set('sku', $variant->sku);
                                                    $set('unit_product_price', $variant->price ?? 0);
                                                    $set('weight_kg', $variant->weight_kg ?? 0);
                                                    $set('volume_cbm', $variant->volume_cbm ?? 0);
                                                }
                                            })
                                            ->columnSpan(3),

                                        TextInput::make('name')
                                            ->label('Product Name')
                                            ->readOnly()
                                            ->columnSpan(3),

                                        TextInput::make('sku')
                                            ->label('SKU')
                                            ->readOnly()
                                            ->columnSpan(2),

                                        TextInput::make('quantity')
                                            ->label('Qty')
                                            ->numeric()
                                            ->default(1)
                                            ->reactive()
                                            ->required()
                                            ->minValue(1)
                                            ->columnSpan(1),

                                        TextInput::make('unit_product_price')
                                            ->label('Unit Price')
                                            ->numeric()
                                            ->reactive()
                                            ->required()
                                            ->prefix('$')
                                            ->helperText('Base price')
                                            ->columnSpan(2),

                                        TextInput::make('final_unit_price')
                                            ->label('Final Price')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('৳')
                                            ->helperText('With all costs')
                                            ->extraAttributes(['class' => 'font-bold'])
                                            ->columnSpan(1),
                                    ]),

                                // Row 2: Shipping Specifications
                                Grid::make(12)
                                    ->schema([
                                        TextInput::make('weight_kg')
                                            ->label('Weight (KG)')
                                            ->numeric()
                                            ->reactive()
                                            ->helperText('For air shipment')
                                            ->suffix('kg')
                                            ->columnSpan(2),

                                        TextInput::make('volume_cbm')
                                            ->label('Volume (CBM)')
                                            ->numeric()
                                            ->reactive()
                                            ->helperText('For sea shipment')
                                            ->suffix('m³')
                                            ->columnSpan(2),

                                        // Cost Breakdown (Read-only, auto-calculated)
                                        TextInput::make('export_freight')
                                            ->label('Export Freight')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('$')
                                            ->helperText('3% of base')
                                            ->columnSpan(2),

                                        TextInput::make('origin_handling')
                                            ->label('Origin Handling')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('$')
                                            ->helperText('THC/Airport')
                                            ->columnSpan(2),

                                        TextInput::make('international_freight')
                                            ->label('Int. Freight')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('$')
                                            ->helperText('Sea/Air freight')
                                            ->columnSpan(2),

                                        TextInput::make('insurance')
                                            ->label('Insurance')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('$')
                                            ->helperText('1.5% of base')
                                            ->columnSpan(2),
                                    ]),

                                // Row 3: Row Total
                                Grid::make(12)
                                    ->schema([
                                        TextInput::make('cost_factor')
                                            ->label('Total Costs')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('$')
                                            ->helperText('Sum of all costs')
                                            ->columnSpan(3),

                                        TextInput::make('unit_price_with_margin')
                                            ->label('Price + Margin')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('৳')
                                            ->helperText('With margin applied')
                                            ->columnSpan(3),

                                        TextInput::make('row_total')
                                            ->label('Row Total')
                                            ->numeric()
                                            ->readOnly()
                                            ->prefix('৳')
                                            ->extraAttributes(['class' => 'font-bold text-lg'])
                                            ->helperText('Final amount')
                                            ->columnSpan(6),
                                    ]),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('➕ Add Another Product')
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['name'] ?? 'New Item')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columnSpan(3),

                // FULL WIDTH - Summary Totals (Like Excel Bottom)
                Section::make('💵 Quotation Summary')
                    ->description('Final totals and breakdown')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Placeholder::make('items_count')
                                    ->label('Total Items')
                                    ->content(fn($get) => count($get('items') ?? []) . ' item(s)'),

                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('৳')
                                    ->extraAttributes(['class' => 'font-semibold']),

                                TextInput::make('tax_total')
                                    ->label('Tax Total')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('৳'),

                                TextInput::make('grand_total')
                                    ->label('Grand Total')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('৳')
                                    ->extraAttributes(['class' => 'font-bold text-2xl text-green-600']),
                            ]),

                        Grid::make(3)
                            ->schema([
                                Placeholder::make('cost_breakdown')
                                    ->label('Cost Breakdown')
                                    ->content(
                                        fn($get) =>
                                        'Export: ৳' . number_format($get('export_freight_total') ?? 0, 2) . ' | ' .
                                            'Freight: ৳' . number_format($get('international_freight_total') ?? 0, 2) . ' | ' .
                                            'Insurance: ৳' . number_format($get('insurance_total') ?? 0, 2)
                                    ),

                                Placeholder::make('pricing_summary')
                                    ->label('Pricing Info')
                                    ->content(
                                        fn($get) =>
                                        'Tier: ' . strtoupper($get('pricing_tier') ?? 'N/A') . ' | ' .
                                            'Method: ' . strtoupper($get('shipping_method') ?? 'N/A')
                                    ),

                                Placeholder::make('margin_summary')
                                    ->label('Margins Applied')
                                    ->content(
                                        fn($get) =>
                                        'Margin: ' . ($get('margin_percentage') ?? 0) . '% | ' .
                                            'Tax: ' . ($get('tax_percentage') ?? 0) . '% | ' .
                                            'VAT: ' . ($get('vat_percentage') ?? 0) . '%'
                                    ),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->columnSpan(3),

            ]);
    }
}
