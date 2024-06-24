<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientModelResource\Pages;
use App\Filament\Resources\ClientModelResource\RelationManagers;
use App\Models\ClientModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientModelResource extends Resource
{
    protected static ?string $model = ClientModel::class;

    protected static ?string $label = 'Clientes';
    protected static ?string $slug = 'clients';
    protected static ?string $navigationIcon = 'fas-user-friends';

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
                TextColumn::make('id')->searchable()->label('ID')->sortable(),
                TextColumn::make('name')->searchable()->label('Nome'),
                TextColumn::make('email')->searchable()->label('E-mail'),
                TextColumn::make('document_number')->searchable()->label('Documento'),
                TextColumn::make('status')->searchable()->label('Status'),
                TextColumn::make('created_at')->searchable()->label('Criado')->dateTime(),
                TextColumn::make('updated_at')->searchable()->label('Alterado')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Excluir'),
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
            'index' => Pages\ListClientModels::route('/'),
//            'create' => Pages\CreateClientModel::route('/create'),
//            'edit' => Pages\EditClientModel::route('/{record}/edit'),
        ];
    }
}
