<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $totalRevenue = rupiah(Order::query()->withSum('service', 'price')->get()->sum('service_sum_price'));
        return [
            Card::make('Total Order', Order::select('id')->count('id')),
            Card::make('Total Revenue', $totalRevenue),
        ];
    }
}
