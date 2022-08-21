<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Card::make()->columns(3)->schema([
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->rules('required', 'email'),
                Forms\Components\TextInput::make('password')->label('Password')->password()->rules('required')->hiddenOn(Pages\EditUser::class),
                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->options([
                        'Admin' => 'Admin',
                        'Reseller' => 'Reseller',
                        'Normal' => 'Normal',
                    ])
                    ->rules('required'),
                Forms\Components\TextInput::make('balance')->label('Balance')->rules('required', 'numeric')->numeric(),
            ]));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Id')->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(['email']),
                Tables\Columns\TextColumn::make('role')->label('Role'),
                Tables\Columns\TextColumn::make('balance')->label('Balance'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At'),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('Admin Only')
                    ->query(fn (Builder $query): Builder => $query->where('role', 'Admin')),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
