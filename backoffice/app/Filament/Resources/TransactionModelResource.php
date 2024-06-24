<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionModelResource\Pages;
use App\Filament\Resources\TransactionModelResource\RelationManagers;
use App\Models\TransactionModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionModelResource extends Resource
{
    protected static ?string $model = TransactionModel::class;
    protected static ?string $label = 'Transações';
    protected static ?string $slug = 'transactions';
    protected static ?string $navigationIcon = 'tabler-transaction-dollar';
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
            'index' => Pages\ListTransactionModels::route('/'),
            'create' => Pages\CreateTransactionModel::route('/create'),
            'edit' => Pages\EditTransactionModel::route('/{record}/edit'),
        ];
    }
}
