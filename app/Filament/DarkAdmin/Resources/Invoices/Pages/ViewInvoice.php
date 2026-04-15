<?php

namespace App\Filament\DarkAdmin\Resources\Invoices\Pages;

use App\Filament\DarkAdmin\Resources\Invoices\InvoiceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    public function getView(): string
    {
        return 'livewire.filament.dark-admin.resources.invoices.pages.view-invoice';
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions like Edit can be added here
        ];
    }
}
