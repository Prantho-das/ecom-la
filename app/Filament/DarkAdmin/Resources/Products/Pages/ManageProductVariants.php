<?php

namespace App\Filament\DarkAdmin\Resources\Products\Pages;

use App\Filament\DarkAdmin\Resources\Products\ProductResource;
use App\Models\ProductVariant;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ManageProductVariants extends Page
{
    protected static string $resource = ProductResource::class;

    protected string $view = 'volt-livewire::filament.dark-admin.resources.products.pages.manage-product-variants';
    protected $record;

    public function mount($record): void
    {
        $this->record = \App\Models\Product::findOrFail($record);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading($this->record->name . ' – Variant Matrix')
            ->query(ProductVariant::where('product_id', $this->record->id))
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('sku')->searchable(),
                TextColumn::make('price')->money('usd'),
                TextColumn::make('stock')->getStateUsing(fn($record) => $record->stock ?? '—'),
                IconColumn::make('track_inventory')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->modalHeading('Edit Variant'),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public function canViewForRecord($record): bool
    {
        return true;
    }
}
