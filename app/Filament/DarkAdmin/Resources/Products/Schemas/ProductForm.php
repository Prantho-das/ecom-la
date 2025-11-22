<?php

namespace App\Filament\DarkAdmin\Resources\Products\Schemas;

use App\Models\Brand;
use App\Models\Product;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Actions\Action;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('slug')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255),

                    Select::make('brand_id')
                        ->relationship('brand', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->label('Brand'),

                    Textarea::make('short_description')
                        ->rows(3)
                        ->nullable(),

                    RichEditor::make('description')
                        ->nullable(),

                    Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'active' => 'Active',
                            'archived' => 'Archived',
                        ])
                        ->default('draft'),

                    DateTimePicker::make('published_at')
                        ->nullable(),
                ]),

            Section::make('Categories')
                ->schema([
                    Select::make('categories')
                        ->relationship('categories', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->label('Assign Categories'),
                ]),

            Section::make('Meta & Tags')
                ->schema([
                    KeyValue::make('metafields')
                        ->nullable()
                        ->label('Metafields'),

                    TagsInput::make('tags')
                        ->placeholder('Type and press enter')
                        ->nullable(),
                ]),
            Section::make('Options')
                ->description('Create options like Color, Size, Material')
                ->schema([
                    Repeater::make('options')
                        ->relationship()
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->label('Option Name (e.g. Color, Size)'),

                            Repeater::make('values')
                                ->relationship('values')
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->label('Value (e.g. Red, XL)'),
                                ])
                                ->columns(2)
                                ->defaultItems(0)
                                ->label('Values')
                        ])
                        ->defaultItems(0)
                                ]),
            Section::make('Variant Combinations')
                ->description('Automatically generated from selected option values')
                ->schema([

                    Placeholder::make('info')
                        ->content('Generate all combinations after selecting option values.'),

                    Actions::make([
                        Action::make('generate')
                            ->label('Generate Variants')
                            ->action(function (callable $set, $get) {

                                $options = $get('options');
                                if (!$options) return;

                                // collect option values
                                $optionValues = [];
                                foreach ($options as $option) {
                                    if (!empty($option['values'])) {
                                        $optionValues[] = array_column($option['values'], 'name');
                                    }
                                }

                                if (empty($optionValues)) return;

                                // Generate all combinations
                                $combinations = collect(array_shift($optionValues))
                                    ->crossJoin(...$optionValues)
                                    ->map(function ($combo) {
                                        return is_array($combo) ? $combo : [$combo];
                                    })
                                    ->toArray();

                                // Set variants input
                                $set('variants', array_map(function ($combo) {
                                    return [
                                        'title'   => implode(' / ', $combo),
                                        'sku'     => '',
                                        'price'   => 0,
                                        'barcode' => '',
                                        'weight'  => 0,
                                    ];
                                }, $combinations));
                            })
                    ]),

                    Repeater::make('variants')
                        ->relationship('variants')
                        ->schema([
                            TextInput::make('title')
                                ->readOnly(),

                            TextInput::make('sku')
                                ->unique(ignoreRecord: true)
                                ->nullable(),

                            TextInput::make('price')
                                ->numeric()
                                ->required(),

                            TextInput::make('barcode')
                                ->nullable(),

                            TextInput::make('weight')
                                ->numeric()
                                ->nullable(),
                        ])
                        ->columns(5)
                        ->orderable()
                        ->defaultItems(0)
                ]),


        ])->columns(2);
    }
}
