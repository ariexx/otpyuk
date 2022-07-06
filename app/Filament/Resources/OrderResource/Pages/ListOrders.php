<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected static string $navigationTitle = 'List Orders';

    protected function getHeaderWidgets(): array
    {
        return [
            OrderOverview::class,
        ];
    }
}
