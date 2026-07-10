<?php

namespace App\Filament\DarkAdmin\Resources\Incoterms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IncotermTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                IconColumn::make('has_export_freight')->label('EF')->boolean()->alignCenter(),
                IconColumn::make('has_export_clearance')->label('EC')->boolean()->alignCenter(),
                IconColumn::make('has_origin_thc')->label('THC')->boolean()->alignCenter(),
                IconColumn::make('has_int_freight')->label('IF')->boolean()->alignCenter(),
                IconColumn::make('has_insurance')->label('INS')->boolean()->alignCenter(),
                IconColumn::make('has_import_duties')->label('ID')->boolean()->alignCenter(),
                IconColumn::make('has_handling_charges')->label('HC')->boolean()->alignCenter(),
                IconColumn::make('has_inland_transport')->label('IT')->boolean()->alignCenter(),
                IconColumn::make('has_custom_cost_factor')->label('CF')->boolean()->alignCenter(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->alignCenter(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id')
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
