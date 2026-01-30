<?php

namespace App\Filament\DarkAdmin\Resources\Quotations;

use App\Filament\DarkAdmin\Resources\Quotations\Pages\ListQuotations;
use App\Filament\DarkAdmin\Resources\Quotations\Pages\QuotationBuilder;
use App\Filament\DarkAdmin\Resources\Quotations\Pages\ViewQuotation;
use App\Filament\DarkAdmin\Resources\Quotations\Tables\QuotationsTable;
use App\Models\Quotation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|UnitEnum|null $navigationGroup = 'Shop';

    public static function form(Schema $schema): Schema
    {
        return $schema; // New system uses QuotationBuilder
    }

    public static function table(Table $table): Table
    {
        return QuotationsTable::configure($table);
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
            'index' => ListQuotations::route('/'),
            'quotation-builder' => QuotationBuilder::route('/builder/{record?}'),
            'view' => ViewQuotation::route('/{record}'),
        ];
    }
}
