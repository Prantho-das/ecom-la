<?php

namespace App\Filament\DarkAdmin\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServiceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            ImageColumn::make('image')
                ->circular(),

            TextColumn::make('title')
                ->searchable()
                ->sortable(),

            TextColumn::make('short_description')
                ->limit(50)
                ->tooltip(fn($record) => $record->short_description),

            ToggleColumn::make('published'),

            TextColumn::make('created_at')
                ->dateTime()
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
