<?php

namespace App\Filament\DarkAdmin\Resources\Invoices\Pages;

use App\Filament\DarkAdmin\Resources\Invoices\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
}
