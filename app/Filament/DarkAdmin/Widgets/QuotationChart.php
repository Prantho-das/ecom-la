<?php

namespace App\Filament\DarkAdmin\Widgets;

use Filament\Widgets\ChartWidget;

class QuotationChart extends ChartWidget
{
    protected ?string $heading = 'Quotation Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
