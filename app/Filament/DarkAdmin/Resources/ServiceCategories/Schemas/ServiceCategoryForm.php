<?php

namespace App\Filament\DarkAdmin\Resources\ServiceCategories\Schemas;

use App\Models\ServiceCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, $set) =>
                            $operation === 'create' || $operation === 'edit'
                                ? $set('slug', \Str::slug($state))
                                : null)->columnSpan(1),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ServiceCategory::class, 'slug', ignoreRecord: true)
                        ->maxLength(255)->columnSpan(1),

                    Toggle::make('published')
                        ->default(true),
                    Textarea::make('short_description')
                        ->required()
                        ->rows(3)->columnSpan(1),

                    RichEditor::make('full_description')
                    ->columnSpan(1),

                FileUpload::make('image')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('services')
                        ->preserveFilenames(),
                    Repeater::make('links')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')
                                ->url()
                                ->required(),
                        ])
                        ->columns(2)->columnSpanFull()
                        ->collapsible(),
                ])->columns(2)->columnSpanFull(),

            Section::make('Industries & Benefits')
                ->schema([
                    Repeater::make('industries')
                        ->schema([
                            TextInput::make('name')->label('Industry'),
                        ])
                        ->grid(3)
                        ->collapsible(),
                    Repeater::make('benefits')
                        ->label('Benefits List')
                        ->schema([
                            TextInput::make('title')->required(),
                            Textarea::make('description')->required(),
                        ])
                        ->columns(2)
                        ->collapsible(),

                FileUpload::make('feature_image')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('services')
                    ->preserveFilenames(),

                FileUpload::make('benefit_image')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('services')
                    ->preserveFilenames(),
                ])->columns(2)->columnSpanFull(),

            Section::make('Features')
                ->schema([
                    Repeater::make('features')
                        ->label('Features List')
                        ->schema([
                            TextInput::make('title')->required(),
                            Textarea::make('description')->required(),
                        ])
                        ->columns(2)
                        ->collapsible(),
                ]),

            Section::make('Related Services')
                ->schema([
                      Select::make('related_services')
                      ->multiple()
                    ->label('Related Services')
                    ->options(
                        // Load all published services as title => id
                        ServiceCategory::published()->pluck('title', 'id')->toArray()
                    )
                    ->searchable(['title']) // Search by title
                    ->preload()             // Load options immediately (good if <100 services)
                    ->placeholder('Select related services...')
                    ->helperText('These will appear in the "Related Products And Services" section on the public page.')
                    ->columnSpanFull()
                    ->dehydrated(fn($state) => !empty($state)) // Only save if not empty
                    ->default([]), // Ensure it's always an array
            ]),
            ]);
    }




    // public static function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             InfoSection::make('Service Overview')
    //                 ->schema([
    //                     TextEntry::make('title')->size(TextEntry\TextEntrySize::Large),
    //                     TextEntry::make('full_description')->html(),
    //                     ImageEntry::make('image')->height('400px'),
    //                 ])
    //                 ->columns(2),

    //             Tabs::make('Details')
    //                 ->tabs([
    //                     Tabs\Tab::make('Features & Benefits')
    //                         ->schema([
    //                             InfoSection::make('Benefits')
    //                                 ->schema([
    //                                     RepeatableEntry::make('benefits')
    //                                         ->schema([
    //                                             TextEntry::make('title')->weight('bold'),
    //                                             TextEntry::make('description'),
    //                                         ])
    //                                         ->columns(1),
    //                                 ]),

    //                             InfoSection::make('Features')
    //                                 ->schema([
    //                                     RepeatableEntry::make('features')
    //                                         ->schema([
    //                                             TextEntry::make('title')->weight('bold'),
    //                                             TextEntry::make('description'),
    //                                         ])
    //                                         ->columns(1),
    //                                 ]),
    //                         ]),

    //                     Tabs\Tab::make('Documents & Downloads')
    //                         ->schema([
    //                             RepeatableEntry::make('links')
    //                                 ->schema([
    //                                     TextEntry::make('label')
    //                                         ->url(fn($state, $record) => $record->links[array_search($state, array_column($record->links, 'label'))]['url'] ?? null)
    //                                         ->color('primary'),
    //                                 ]),
    //                         ]),

    //                     Tabs\Tab::make('Support')
    //                         ->schema([
    //                             TextEntry::make('links.support')
    //                                 ->label('Support Contact')
    //                                 ->url(fn($record) => $record->links['support'] ?? null)
    //                                 ->default('Not provided'),
    //                         ]),
    //                 ]),
    //         ]);
    // }
}
