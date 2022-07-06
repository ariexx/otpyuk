<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\LineChartWidget;

class OrderChart extends LineChartWidget
{
    protected static ?string $heading = 'Monthly Chart Order';
    public ?string $filter = 'today';

    protected function getData(): array
    {
        $data = Trend::model(Order::class)
            ->between(
                start: now()->month(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Order chart',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(75, 192, 192)',
                    'fill' => false,
                    'lineTension' => 0.1,
                ]
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M')),

        ];
    }
}
