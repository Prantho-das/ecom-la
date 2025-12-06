<?php

namespace App\Filament\DarkAdmin\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, ?string $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('sku')
                            ->unique(ignoreRecord: true)
                            ->nullable()
                            ->maxLength(255)->columnSpan(1),
                        TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->nullable(),

                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Brand')->columnSpan(1),
                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Assign Categories'),
                        Select::make('countries')
                            ->relationship('countries', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Available In Countries'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')->columnSpan(1),
                        DateTimePicker::make('published_at')
                            ->nullable(),
                        Textarea::make('short_description')
                            ->rows(3)
                            ->nullable()->columnSpanFull(),

                        RichEditor::make('description')
                            ->nullable()->columnSpanFull(),

                    ])->columns(3)->columnSpanFull(),

                Section::make('Options')
                ->hidden()
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
                                    ->label('Values'),
                            ])
                            ->defaultItems(0),
                    ])->columnSpan(1),
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
                                    if (! $options) {
                                        return;
                                    }

                                    // collect option values
                                    $optionValues = [];
                                    foreach ($options as $option) {
                                        if (! empty($option['values'])) {
                                            $optionValues[] = array_column($option['values'], 'name');
                                        }
                                    }

                                    if (empty($optionValues)) {
                                        return;
                                    }

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
                                            'title' => implode(' / ', $combo),
                                            'sku' => '',
                                            'price' => 0,
                                            'barcode' => '',
                                            'weight' => 0,
                                        ];
                                    }, $combinations));
                                }),
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
                            ->defaultItems(0),
                    ])->columnSpan(1),
                Section::make('Images')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->disk('public')
                            ->directory('product-thumbnails')
                            ->image(),

                        Repeater::make('images')
                            ->label('Gallery')
                            ->relationship()
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Image')
                                    ->disk('public')
                                    ->directory('product-images')
                                    ->image(),
                            ])
                            ->grid(2)
                            ->defaultItems(0),
                        FileUpload::make('pdf_files')
                            ->label('PDF Files')
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            ->directory('product-pdfs')
                            ->downloadable(),
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

                Section::make('Custom Sections')
                    ->description('Create as many sections as you want. Example: Home, Office, Specifications, Contact, etc.')
                    ->icon('heroicon-o-folder-open')
                    ->collapsible()
                    ->collapsed() // collapsed by default to save space
                    ->schema([
                        Repeater::make('custom_sections')
                            ->label(false) // hide the "custom_sections" label
                            ->schema([

                                // Section Title (e.g., "Home", "Office", "Warranty")
                                TextInput::make('title')
                                    ->label('Section Title')
                                    ->placeholder('e.g., Home, Office, Contact Info')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                // Key-Value pairs inside this section
                                Repeater::make('fields')
                                    ->label('Fields')
                                    ->schema([
                                        TextInput::make('key')
                                            ->label('Key')
                                            ->placeholder('e.g., Location, Phone, Built Year')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('value')
                                            ->label('Value')
                                            ->placeholder('e.g., Dubai, +971...', '2020')
                                            ->required()
                                            ->maxLength(1000)
                                            ->columnSpan(1),

                                    ])
                                    ->columns(2)
                                    ->defaultItems(1)
                                    ->addActionLabel('Add Another Field')
                                    ->collapsible()
                                    ->cloneable()
                                    ->reorderableWithButtons(),
                            ])
                            ->columns(1)
                            ->collapsible()
                            ->cloneable()
                            ->reorderableWithButtons()
                            ->addActionLabel('Add New Section')
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                    ]),

            ])->columns(2);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $sections = Arr::get($data, 'custom_sections', []);

        if (is_string($sections)) {
            $sections = json_decode($sections, true) ?? [];
        }

        if (! is_array($sections)) {
            $sections = [];
        }

        // Ensure proper structure for nested repeater
        $data['custom_sections'] = collect($sections)->map(function ($section) {
            return [
                'title' => $section['title'] ?? 'Untitled Section',
                'fields' => collect($section['fields'] ?? [])->map(function ($field) {
                    return [
                        'key' => $field['key'] ?? '',
                        'value' => $field['value'] ?? '',
                    ];
                })->toArray(),
            ];
        })->toArray();

        return $data;
    }
}
