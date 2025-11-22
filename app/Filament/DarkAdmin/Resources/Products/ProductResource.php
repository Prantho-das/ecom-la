<?php

namespace App\Filament\DarkAdmin\Resources\Products;

use App\Filament\DarkAdmin\Resources\Products\Pages\CreateProduct;
use App\Filament\DarkAdmin\Resources\Products\Pages\EditProduct;
use App\Filament\DarkAdmin\Resources\Products\Pages\ListProducts;
use App\Filament\DarkAdmin\Resources\Products\Pages\ManageProductVariants;
use App\Filament\DarkAdmin\Resources\Products\Schemas\ProductForm;
use App\Filament\DarkAdmin\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            // ManageProductVariants::class
        ];
    }

    public function canViewForRecord($record): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
            // 'variants' => ManageProductVariants::route('/{record}/variants'),
        ];
    }
}
