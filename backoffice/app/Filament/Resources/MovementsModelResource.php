<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementsModelResource\Pages;
use App\Filament\Resources\MovementsModelResource\RelationManagers;
use App\Models\MovementsModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovementsModelResource extends Resource
{
    protected static ?string $model = MovementsModel::class;
    protected static ?string $label = 'Movementos';
    protected static ?string $navigationIcon = 'fas-money-bill-transfer';
    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'create' => Pages\CreateMovementsModel::route('/create'),
            'edit' => Pages\EditMovementsModel::route('/{record}/edit'),
        ];
    }
}
