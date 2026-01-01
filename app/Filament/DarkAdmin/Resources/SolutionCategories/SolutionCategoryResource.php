<?php

namespace App\Filament\DarkAdmin\Resources\SolutionCategories;

use App\Filament\DarkAdmin\Resources\SolutionCategories\Pages\ManageSolutionCategories;
use App\Models\SolutionCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SolutionCategoryResource extends Resource
{
    protected static ?string $model = SolutionCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('short_description')
                    ->columnSpanFull(),
                Toggle::make('published')
                    ->required(),
                TextInput::make('parent_id')
                    ->numeric(),
                FileUpload::make('image')
                    ->image(),
                FileUpload::make('benefit_image')
                    ->image(),
                FileUpload::make('feature_image')
                    ->image(),
                TextInput::make('links'),
                TextInput::make('industries'),
                TextInput::make('features'),
                TextInput::make('benefits'),
                TextInput::make('related_services'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                IconColumn::make('published')
                    ->boolean(),
                TextColumn::make('parent_id')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('image'),
                ImageColumn::make('benefit_image'),
                ImageColumn::make('feature_image'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSolutionCategories::route('/'),
        ];
    }
}
