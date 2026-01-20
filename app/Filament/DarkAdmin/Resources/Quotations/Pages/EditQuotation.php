<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Pages;

use App\Filament\DarkAdmin\Resources\Quotations\QuotationResource;
use App\Services\QuotationCalculationService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('recalculate')
                ->label('Recalculate Costs')
                ->icon('heroicon-o-calculator')
                ->color('primary')
                ->action(function () {
                    $service = new QuotationCalculationService;
                    $service->recalculateAllItems($this->record);

                    $this->refreshFormData([
                        'subtotal',
                        'grand_total',
                        'export_freight_total',
                        'items',
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->title('Costs Recalculated')
                        ->success()
                        ->send();
                }),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Automatically recalculate costs after saving
        $service = new QuotationCalculationService;
        $service->recalculateAllItems($this->record);
    }
}
