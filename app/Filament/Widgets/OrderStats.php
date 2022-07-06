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
            Card::make('Total Order', Order::query()->count('id'))
                ->description((Order::ratioOrder() === 0) ? Order::ratioOrder() . ' Decrease' : Order::ratioOrder() . ' Increase')
                ->descriptionIcon((Order::ratioOrder() === 0) ? 'heroicon-s-trending-down' : 'heroicon-s-trending-up')
                ->color((Order::ratioOrder() === 0) ? 'danger' : 'success'),
            Card::make('Total User', User::query()->count('id'))
                ->description((User::ratioUser() === 0) ? User::ratioUser() . ' Decrease' : User::ratioUser() . ' Increase')
                ->descriptionIcon((User::ratioUser() === 0) ? 'heroicon-s-trending-down' : 'heroicon-s-trending-up')
                ->color((User::ratioUser() === 0) ? 'danger' : 'success'),
            Card::make('Total Pendapatan', $totalRevenue)
                ->description('Total pendapatan yang telah diterima')
                ->color('success'),
        ];
    }
}
