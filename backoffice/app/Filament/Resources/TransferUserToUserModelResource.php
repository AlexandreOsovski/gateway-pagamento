<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransferUserToUserModelResource\Pages;
use App\Filament\Resources\TransferUserToUserModelResource\RelationManagers;
use App\Models\TransferUserToUserModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransferUserToUserModelResource extends Resource
{
    protected static ?string $model = TransferUserToUserModel::class;
    protected static ?string $label = 'Transferências internas';
    protected static ?string $slug = 'transfer-user-to-user';
    protected static ?string $navigationIcon = 'uni-user-arrows';
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
            'index' => Pages\ListTransferUserToUserModels::route('/'),
            'create' => Pages\CreateTransferUserToUserModel::route('/create'),
            'edit' => Pages\EditTransferUserToUserModel::route('/{record}/edit'),
        ];
    }
}
