<?php

namespace App\Filament\DarkAdmin\Resources\Invoices;

use App\Filament\DarkAdmin\Resources\Invoices\Pages\InvoiceBuilder;
use App\Filament\DarkAdmin\Resources\Invoices\Pages\ListInvoices;
use App\Filament\DarkAdmin\Resources\Invoices\Pages\ViewInvoice;
use App\Filament\DarkAdmin\Resources\Invoices\Tables\InvoicesTable;
use App\Models\Invoice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-plus';

    protected static ?string $navigationLabel = 'Generate Invoice';

    protected static ?string $slug = 'generate-invoice';

    protected static string|\UnitEnum|null $navigationGroup = 'Sales & CRM';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema; // Handled by InvoiceBuilder
    }

    public static function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
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
            'index' => ListInvoices::route('/'),
            'create' => InvoiceBuilder::route('/generate/{record?}'),
            'view' => ViewInvoice::route('/{record}'),
            'edit' => InvoiceBuilder::route('/{record}/edit'),
        ];
    }
}
