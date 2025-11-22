<?php

namespace App\Filament\DarkAdmin\Resources\InventoryLocations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Table;

class InventoryLocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),

                TextColumn::make('name')->label('Location Name')->sortable()->searchable(),

                TextColumn::make('code')->label('Code')->sortable()->searchable(),

                TextColumn::make('address')
                    ->label('Address')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),

                BooleanColumn::make('is_primary')->label('Primary')->sortable(),

                BooleanColumn::make('manages_stock')->label('Manages Stock')->sortable(),

                TextColumn::make('created_at')->label('Created')->dateTime()->sortable(),
                TextColumn::make('updated_at')->label('Updated')->dateTime()->sortable(),
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
