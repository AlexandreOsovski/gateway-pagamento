<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransferUserToUserModelResource\Pages;
use App\Filament\Resources\TransferUserToUserModelResource\RelationManagers;
use App\Models\TransferUserToUserModel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
                TextInput::make('movement_entry_id')->label('UUID de Entrada'),
                TextInput::make('movement_exit_id')->label('UUID de Saida'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),
                TextColumn::make('movement_entry_id')->searchable()->copyable()->copyMessage('Copiado para a área de transferência.')->color('success')->badge()->label('UUID de Entrada'),
                TextColumn::make('movement_exit_id')->searchable()->copyable()->copyMessage('Copiado para a área de transferência.')->color('danger')->badge()->label('UUID de Saida'),
                TextColumn::make('amount')->label('Valor Transacionado')->prefix('R$')->numeric(decimalPlaces: 2),
                TextColumn::make('created_at')->searchable()->label('Criado')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
//            'create' => Pages\CreateTransferUserToUserModel::route('/create'),
//            'edit' => Pages\EditTransferUserToUserModel::route('/{record}/edit'),
        ];
    }
}
