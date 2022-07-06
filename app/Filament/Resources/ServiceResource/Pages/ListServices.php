<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\ServiceResource\Widgets\ServiceOverview;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;
    protected static string $navigationTitle = 'List Services';
    protected function getHeaderWidgets(): array
    {
        return [
            ServiceOverview::class,
        ];
    }
}
