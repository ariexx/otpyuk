<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Service;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Filament\Resources\ServiceResource\RelationManagers\RatesRelationManager;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Card::make()->columns(3)->schema([
                Forms\Components\TextInput::make('service_name')
                    ->label('Service Name')
                    ->rules('required'),
                Forms\Components\TextInput::make('provider_price')
                    ->label('Harga Operan')
                    ->rules('required'),
                Forms\Components\TextInput::make('price')
                    ->label('Harga Jual')
                    ->rules('required', 'numeric'),
                Forms\Components\Select::make('discount')
                    ->label('Diskon')
                    ->options([
                        'iya' => 'Iya',
                        'tidak' => 'Tidak'
                    ]),
                Forms\Components\TextInput::make('discount_percentage')
                    ->label('Persentasi Diskon')
                    ->rules('required', 'numeric'),
                Forms\Components\Select::make('is_active')
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
                Tables\Columns\TextColumn::make('id')->label('Id')->sortable(),
                Tables\Columns\TextColumn::make('service_name')->label('Service Name')->searchable(),
                Tables\Columns\TextColumn::make('provider_price')->label('Harga Operan'),
                Tables\Columns\TextColumn::make('price')->label('Harga Jual'),
                Tables\Columns\TextColumn::make('discount')->label('Diskon'),
                Tables\Columns\TextColumn::make('discount_percentage')->label('Persentasi Diskon'),
                Tables\Columns\TextColumn::make('is_active')->label('Active ?'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At'),
            ])
            ->filters([
                Tables\Filters\Filter::make('aktif')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', 'iya')),
                Tables\Filters\Filter::make('diskon')
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
