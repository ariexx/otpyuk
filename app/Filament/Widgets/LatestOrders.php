<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use App\Models\Order;
use App\Enums\OrderStatusEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    // protected int | string | array $columnSpan = 'full';
    protected function getTableQuery(): Builder
    {
        return Order::select(['id', 'order_id', 'user_id', 'status', 'created_at'])->with('user:id,email')->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {

        return [
            TextColumn::make('order_id')->label('Order Id')->searchable(),
            TextColumn::make('user.email')->label('Email')->searchable(),
            BadgeColumn::make('status')
                ->enum([
                    0 => 'Repeat',
                    1 => 'Processing',
                    2 => 'Completed',
                    3 => 'Canceled',
                    4 => 'Pending',
                ])->colors([
                    0 => 'danger',
                    1 => 'success',
                    2 => 'success',
                    3 => 'danger',
                    4 => 'warning',
                ])->icons([
                    0 => 'heroicon-s-repeat',
                    1 => 'heroicon-s-check',
                    2 => 'heroicon-s-check',
                    3 => 'heroicon-s-close',
                    4 => 'heroicon-s-check',
                ])->label('Status'),
            TextColumn::make('created_at')->label('Date'),
        ];
    }
}
