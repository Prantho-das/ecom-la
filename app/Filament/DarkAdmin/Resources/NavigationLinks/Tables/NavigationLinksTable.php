<?php

namespace App\Filament\DarkAdmin\Resources\NavigationLinks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NavigationLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('label')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('menu.name')
                    ->badge(),
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
