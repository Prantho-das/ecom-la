<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Pages;

use App\Filament\DarkAdmin\Resources\Quotations\QuotationResource;
use Filament\Resources\Pages\ListRecords;

class ListQuotations extends ListRecords
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('create_new')
                ->label('New Quotation System')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->url(QuotationResource::getUrl('quotation-builder')),
        ];
    }
}
