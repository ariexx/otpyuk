<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStats extends BaseWidget
{
    protected function getCards(): array
    {
        $totalRevenue = rupiah(Order::query()->withSum('service', 'price')->get()->sum('service_sum_price'));
        // $random = [
        //     rand(00, 99),
        //     rand(00, 99),
        //     rand(00, 99),
        //     rand(00, 99),
        //     rand(00, 99),
        //     rand(00, 99),
        //     rand(00, 99),

        // ];

        return [
            Card::make('Total Order Per Month', Order::getOrderPerMonth())
                ->description(Order::ratioOrder() . ' Increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total User Per Month', User::getUserPerMonth())
                ->description(User::ratioUser() . ' Increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total Revenue', $totalRevenue)
                ->description('Total pendapatan yang telah diterima')
                ->color('success'),
        ];
    }
}
