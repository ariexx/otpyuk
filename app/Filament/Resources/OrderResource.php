<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Order')->schema([
                    TextInput::make('order_id')
                        ->label('Order ID')
                        ->rules('required'),
                    TextInput::make('phone_number')
                        ->label('Phone Number')
                        ->rules('required'),
                    TextInput::make('sms_message')
                        ->label('SMS Message')
                        ->rules('required'),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            '1' => 'Processing',
                            '2' => 'Completed',
                            '3' => 'Canceled',
                            '4' => 'Pending',
                            '0' => 'Repeated'
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')->label('Email')->searchable(['user_id', 'phone_number', 'provider_order_id', 'order_id']),
                TextColumn::make('operator.operator_name')->label('Operator Id'),
                TextColumn::make('provider_order_id')->label('Provider Order Id'),
                TextColumn::make('order_id')->label('Order Id'),
                TextColumn::make('phone_number')->label('Nomor HP'),
                TextColumn::make('sms_message')->label('SMS'),
                TextColumn::make('service.price')->label('Harga')->money('idr', 'idr'),
                TextColumn::make('status')->label('Status')->enum([
                    '1' => 'Processing',
                    '2' => 'Completed',
                    '3' => 'Canceled',
                    '4' => 'Pending',
                    '0' => 'Repeated'
                ]),
                TextColumn::make('created_at')->label('Dibuat Pada'),
                TextColumn::make('start_at')->label('Dimulai Pada'),
                TextColumn::make('expires_at')->label('Berakhir Pada'),
            ])
            ->filters([
                Filter::make('Completed')->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('status', '2')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            OrderOverview::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
