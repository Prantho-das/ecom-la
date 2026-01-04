<?php

namespace App\Filament\DarkAdmin\Resources\Solutions\Schemas;

use Filament\Schemas\Schema;
use App\Models\Solution;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SolutionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero Section')
                    ->collapsible()
                    ->schema([
                        TextInput::make('hero_title')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('hero_subtitle')
                            ->required()
                            ->rows(3),

                        FileUpload::make('hero_background_image')
                            ->image()->disk('public')
                            ->directory('hero')
                            ->required(),
                        Select::make('Solution Categories')
                            ->relationship('categories', 'title')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Assign Categories'),
                    ])->columnSpanFull(),


                // ==================== 3 FEATURE CARDS ====================
                Section::make('Feature Cards (Managing data security...)')
                    ->collapsible()
                    ->schema([
                        TextInput::make('features_heading')
                            ->required(),
                        Repeater::make('feature_cards_section')
                            ->schema([
                                FileUpload::make('image')->disk('public')
                                    ->image()
                                    ->directory('features')
                                    ->required(),

                                TextInput::make('title')
                                    ->required(),

                                Textarea::make('description')
                                    ->required()
                                    ->rows(4),
                            ])
                            ->columns(1)
                            ->defaultItems(3)
                            ->maxItems(6) // Fixed to 3 cards
                            ->reorderable(false)
                            ->collapsible(),
                    ])->columnSpanFull(),
                Section::make('Trends Section (What\'s changing in logistics infrastructure)')
                    ->collapsible()
                    ->schema([
                        TextInput::make('trends_section.title')
                            ->label('Section Title')
                            ->required(),



                        TextInput::make('trends_section.video_title')
                            ->label('Video Link')
                            ->required(),

                        Repeater::make('trends_section.items')
                            ->label('Trend Items')
                            ->schema([
                                TextInput::make('icon')
                                    ->placeholder('e.g., clock, server, share-2')
                                    ->required(),

                                TextInput::make('title')
                                    ->required(),

                                Textarea::make('description')
                                    ->rows(3)
                                    ->required(),
                            ])
                            ->columns(1)
                            ->defaultItems(3)
                            ->collapsible(),
                    ]),

                // ==================== CTA SECTION ====================
                Section::make('CTA Section (Rethink the roadmap for AI adoption)')
                    ->collapsible()
                    ->schema([
                        TextInput::make('cta_section.title')
                            ->required(),

                        Textarea::make('cta_section.description')
                            ->rows(4)
                            ->required(),

                        TextInput::make('cta_section.button_text')
                            ->default('Learn more')
                            ->required(),

                        FileUpload::make('cta_section.image')->disk('public')
                            ->image()
                            ->directory('cta')
                            ->required(),
                    ]),

                // ==================== FAQs SECTION ====================
                Section::make('FAQs')
                    ->collapsible()
                    ->schema([
                        Repeater::make('sections.0.data.items')
                            ->label('FAQ Items')
                            ->schema([
                                TextInput::make('question')
                                    ->required(),

                                Textarea::make('answer')
                                    ->rows(4)
                                    ->required(),
                            ])
                            ->columns(1)
                            ->addActionLabel('Add New FAQ')
                            ->collapsible()
                            ->reorderable(),
                    ])
                    ->description('Manage all FAQs. The title "FAQs" is fixed.'),
            ]);
    }
}
