<?php

namespace App\Filament\DarkAdmin\Resources\Invoices\Pages;

use App\Filament\DarkAdmin\Resources\Invoices\InvoiceResource;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
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
            Action::make('edit_costs')
                ->label('Edit Cost & Discount')
                ->icon('heroicon-m-pencil-square')
                ->form([
                    TextInput::make('cost_factor')
                        ->numeric()
                        ->default(fn ($record) => $record->cost_factor)
                        ->required(),
                    TextInput::make('global_discount')
                        ->numeric()
                        ->default(fn ($record) => $record->global_discount)
                        ->required(),
                ])
                ->action(function (array $data, $record): void {
                    $record->cost_factor = $data['cost_factor'];
                    $record->global_discount = $data['global_discount'];
                    $record->save();

                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Invoice Updated')
                        ->body('Cost factor and global discount have been updated.')
                        ->send();
                }),
        ];
    }
}
