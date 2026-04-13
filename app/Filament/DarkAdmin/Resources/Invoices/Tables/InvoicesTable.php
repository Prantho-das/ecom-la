<?php

namespace App\Filament\DarkAdmin\Resources\Invoices\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Models\Invoice;
use App\Filament\DarkAdmin\Resources\Invoices\InvoiceResource;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('invoice_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('grand_total')
                    ->label('Total')
                    ->money('bdt')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'paid',
                        'warning' => 'pending',
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\Action::make('edit_builder')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('info')
                    ->url(fn (Invoice $record) => InvoiceResource::getUrl('edit', ['record' => $record->id])),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
