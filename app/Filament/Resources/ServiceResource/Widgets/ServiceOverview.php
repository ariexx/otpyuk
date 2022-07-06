<?php

namespace App\Filament\Resources\ServiceResource\Widgets;

use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ServiceOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Service Active', Service::query()->select('is_active')->where('is_active', 1)->count('is_active')),
            Card::make('Total Service Non-Active', Service::query()->select('is_active')->where('is_active', 0)->count('is_active')),
            // Card::make('Bounce rate', '21%'),
            // Card::make('Average time on page', '3:12'),
        ];
    }
}
