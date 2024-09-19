<?php

namespace App\Filament\Resources;
use App\Enums\Status;
use App\Filament\Resources\MovementsModelResource\Pages;
use App\Filament\Resources\MovementsModelResource\RelationManagers;
use App\Models\MovementModel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Select;

class MovementsModelResource extends Resource
{
    public static string $defaultCurrency = 'BRL';
    protected static ?string $model = MovementModel::class;
    protected static ?string $label = 'Movementos';
    protected static ?string $slug = 'movements';
    protected static ?string $navigationGroup = 'Financeiro';
    protected static ?string $navigationIcon = 'fas-money-bill-transfer';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id'),
                TextInput::make('uuid'),
                Select::make('client_id')
                    ->label('Cliente')
                    ->relationship('client', 'name')
                    ->required()
                    ->reactive(),
                Forms\Components\ToggleButtons::make('type')
                    ->inline()
                    ->label('Status')
                    ->options(Status::class)
                    ->required(),

                textInput::make('type_movement')->label('Tipo do movimento'),
                textInput::make('amount')->label('Valor')->prefix('R$ '),
                textInput::make('created_at')->label('Criado')->mask('9999/99/99 99:99:99'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->label('ID')->sortable(),
                TextColumn::make('uuid')->badge()->copyable()->copyMessage('Copiado para a área de transferência.')->searchable()->label('UUID'),
                TextColumn::make('client.name')->searchable()->label('Cliente'),
                TextColumn::make('type')->searchable()
                    ->badge()
                    ->icons(['heroicon-s-arrow-up' => 'EXIT', 'heroicon-s-arrow-down' => 'ENTRY'
                    ])
                    ->color(fn (string $state): string => match ($state) {
                        'EXIT' => 'danger',
                        'ENTRY' => 'success',
                    })
                ,
                textColumn::make('amount')->searchable()->label('Valor')->money('BRL'),
                textColumn::make('created_at')->searchable()->label('Criado')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('ver'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Excluir'),
                ])->label('Ações'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovementsModels::route('/'),
//            'create' => Pages\CreateMovementsModel::route('/create'),
//            'edit' => Pages\EditMovementsModel::route('/{record}/edit'),
        ];
    }
}
