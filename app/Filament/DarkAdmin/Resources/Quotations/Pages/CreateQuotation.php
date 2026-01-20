<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Pages;

use App\Filament\DarkAdmin\Resources\Quotations\QuotationResource;
use App\Services\QuotationCalculationService;
use Filament\Resources\Pages\CreateRecord;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    protected function afterCreate(): void
    {
        // Automatically calculate costs after creating
        $service = new QuotationCalculationService;
        $service->recalculateAllItems($this->record);
    }
}
