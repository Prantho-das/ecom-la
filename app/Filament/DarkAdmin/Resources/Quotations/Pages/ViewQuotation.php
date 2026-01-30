<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Pages;

use App\Filament\DarkAdmin\Resources\Quotations\QuotationResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuotation extends ViewRecord
{
    protected static string $resource = QuotationResource::class;

    protected string $view = 'filament.dark-admin.resources.quotations.pages.view-quotation';

    protected function getHeaderActions(): array
    {
        return [
            // Add actions if needed, like Edit
        ];
    }
}
