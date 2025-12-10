<?php

namespace App\Filament\DarkAdmin\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               ImageColumn::make('thumbnail')
    ->disk('public')
    ->default('images/product-placeholder.png')
    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('sku')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('brand.name')
                    ->badge(),

                TextColumn::make('variants_count')
                    ->counts('variants')
                    ->label('Variants'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Published'),

                IconColumn::make('has_pdf_files')
                    ->label('PDFs')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('pdf_files')
                    ->label('PDF Files')
                    ->listWithLineBreaks()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
