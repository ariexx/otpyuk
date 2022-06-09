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
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Filament\Resources\ServiceResource\RelationManagers\RatesRelationManager;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Card::make()->columns(3)->schema([
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
                        'iya' => 'Iya',
                        'tidak' => 'Tidak'
                    ]),
                TextInput::make('discount_percentage')
                    ->label('Persentasi Diskon')
                    ->rules('required', 'numeric'),
                Select::make('is_active')
                    ->label('Active ?')
                    ->options([
                        'iya' => 'Iya',
                        'tidak' => 'Tidak'
                    ]),
            ]));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Id')->sortable(),
                TextColumn::make('service_name')->label('Service Name')->searchable(),
                TextColumn::make('provider_price')->label('Harga Operan'),
                TextColumn::make('price')->label('Harga Jual'),
                TextColumn::make('discount')->label('Diskon'),
                TextColumn::make('discount_percentage')->label('Persentasi Diskon'),
                TextColumn::make('is_active')->label('Active ?'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
