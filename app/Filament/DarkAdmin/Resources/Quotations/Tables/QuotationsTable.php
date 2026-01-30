<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Tables;

use App\Filament\DarkAdmin\Resources\Quotations\QuotationResource;
use App\Models\Quotation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuotationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quotation_date')
                    ->label('Quotation Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('shipping_method')
                    ->label('Shipping')
                    ->colors([
                        'info' => 'sea',
                        'warning' => 'air',
                    ])
                    ->icons([
                        'heroicon-o-truck' => 'sea',
                        'heroicon-o-paper-airplane' => 'air',
                    ])
                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                BadgeColumn::make('pricing_tier')
                    ->label('Pricing Tier')
                    ->colors([
                        'gray' => 'exwork',
                        'primary' => 'fob',
                        'info' => 'cfr',
                        'success' => 'cif',
                        'warning' => 'ddu_dap',
                        'danger' => 'ddp',
                        'secondary' => 'bdt_local',
                    ])
                    ->formatStateUsing(fn (string $state): string => strtoupper(str_replace('_', '/', $state))),

                TextColumn::make('currency')
                    ->label('Currency')
                    ->toggleable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray' => 'draft',
                        'primary' => 'sent',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                        'warning' => 'expired',
                    ]),

                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->money('bdt')
                    ->sortable()
                    ->summarize([
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->money('bdt'),
                    ]),

                TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('expires_at')
                    ->label('Expires')
                    ->date()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('edit_builder')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('info')
                    ->url(fn (Quotation $record) => QuotationResource::getUrl('quotation-builder', ['record' => $record->id])),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
