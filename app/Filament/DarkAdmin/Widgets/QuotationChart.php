<?php

namespace App\Filament\DarkAdmin\Widgets;

use App\Models\Quotation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class QuotationChart extends ChartWidget
{
    protected ?string $heading = 'Quotations per Month';

    protected function getData(): array
    {
        $data = Quotation::query()
            ->selectRaw('count(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $counts = [];
        $months = [];

        for ($m = 1; $m <= 12; $m++) {
            $months[] = Carbon::create(null, $m, 1)->format('M');
            $counts[] = $data[$m] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Quotations',
                    'data' => $counts,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
