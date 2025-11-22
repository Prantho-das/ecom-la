<?php

namespace App\Filament\DarkAdmin\Resources\Quotations\Pages;

use App\Filament\DarkAdmin\Resources\Quotations\QuotationResource;
use App\Models\Quotation;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Actions;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    // public static function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             Actions::make([
    //                 Action::make('convertToOrder')
    //                     ->label('Convert to Order')
    //                     ->color('success')
    //                     ->action(fn(Quotation $record) => $record->convertToOrder()),
    //             ])
    //         ]);
    // }
}
