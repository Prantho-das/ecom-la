<?php

namespace App\Filament\DarkAdmin\Resources\ServiceCategories;

use App\Filament\DarkAdmin\Resources\ServiceCategories\Pages\CreateServiceCategory;
use App\Filament\DarkAdmin\Resources\ServiceCategories\Pages\EditServiceCategory;
use App\Filament\DarkAdmin\Resources\ServiceCategories\Pages\ListServiceCategories;
use App\Filament\DarkAdmin\Resources\ServiceCategories\Schemas\ServiceCategoryForm;
use App\Filament\DarkAdmin\Resources\ServiceCategories\Tables\ServiceCategoriesTable;
use App\Models\ServiceCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceCategoryResource extends Resource
{
    protected static ?string $model = ServiceCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ServiceCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServiceCategories::route('/'),
            'create' => CreateServiceCategory::route('/create'),
            'edit' => EditServiceCategory::route('/{record}/edit'),
        ];
    }
}
