<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Schemas;

use App\Models\ProductVariant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuotationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([



                Section::make('Customer Info')
                ->schema([
                    TextInput::make('customer_name')->required(),
                    TextInput::make('customer_email')->required()->email(),
                    DatePicker::make('expires_at'),
                    Textarea::make('notes')->columnSpanFull(),
                ]),

            Section::make('Quotation Items')
                ->schema([
                    Repeater::make('items')
                        ->relationship('items')
                        ->schema([

                            Select::make('variant_id')
                                ->label('Product Variant')
                                ->reactive()
                                ->options(ProductVariant::all()->pluck('title', 'id'))
                                ->searchable()
                                ->afterStateUpdated(function ($state, $set) {
                                    $v = ProductVariant::find($state);
                                    if ($v) {
                                        $set('name', $v->title);
                                        $set('sku', $v->sku);
                                        $set('price', $v->price);
                                        $set('row_total', $v->price);
                                    }
                                }),

                            TextInput::make('name')->readOnly(),
                            TextInput::make('sku')->readOnly(),

                            TextInput::make('quantity')
                                ->numeric()
                                ->default(1)
                                ->reactive()
                                ->afterStateUpdated(fn ($state, $set, $get) =>
                                    $set('row_total', $get('price') * $state)
                                ),

                            TextInput::make('price')
                                ->numeric()
                                ->reactive()
                                ->afterStateUpdated(fn ($state, $set, $get) =>
                                    $set('row_total', $state * $get('quantity'))
                                ),

                            TextInput::make('row_total')->numeric()->readOnly(),
                        ])
                        ->columns(6)
                    ]),
                ]);
               
    }
}
