<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Service;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\Widgets\ServiceOverview;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Card::make()->columns(3)->schema([

                TextInput::make('provider_id')
                    ->label('Provider Id')
                    ->rules('required', 'string', 'max:5'),
                TextInput::make('service_name')
                    ->label('Service Name')
                    ->rules('required'),
                TextInput::make('provider_price')
                    ->label('Harga Operan')
                    ->rules('required'),
                TextInput::make('price')
                    ->label('Harga Jual')
                    ->rules('required', 'numeric'),
                Select::make('discount')
                    ->label('Diskon')
                    ->options([
                        1 => 'Iya',
                        0 => 'Tidak'
                    ]),
                TextInput::make('discount_percentage')
                    ->label('Persentasi Diskon')
                    ->rules('numeric'),
                Toggle::make('is_active')
                    ->onIcon('heroicon-s-lightning-bolt')
                    ->offIcon('heroicon-o-lightning-bolt')
                    ->inline(false)
            ]));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Id')->sortable(),
                TextColumn::make('service_name')->label('Service Name')->searchable(),
                TextColumn::make('provider_price')->label('Harga Operan')->money('idr', 'idr'),
                TextColumn::make('price')->label('Harga Jual')->money('idr', 'idr'),
                TextColumn::make('discount')->label('Diskon')->enum([
                    1 => 'Iya',
                    0 => 'Tidak'
                ]),
                TextColumn::make('discount_percentage')->label('Persentasi Diskon'),
                TextColumn::make('is_active')->label('Active ?')->enum([
                    1 => 'Ya',
                    0 => 'Tidak'
                ]),
                TextColumn::make('created_at')->label('Created At'),
            ])
            ->filters([
                Filter::make('aktif')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', 'iya')),
                Filter::make('diskon')
                    ->query(fn (Builder $query): Builder => $query->where('discount', 'iya')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\RatesRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ServiceOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
