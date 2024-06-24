<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeysApiModelResource\Pages;
use App\Filament\Resources\KeysApiModelResource\RelationManagers;
use App\Models\KeysApiModel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeysApiModelResource extends Resource
{
    protected static ?string $model = KeysApiModel::class;
    protected static ?string $label = 'Chaves de API';

    protected static ?string $slug = 'keys-api';
    protected static ?string $navigationIcon = 'fas-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                TextInput::make('title')->label('Nome'),
//                TextInput::make('client.name')->label('Cliente'),
//                TextInput::make('appId')->label('App ID'),
//                TextInput::make('appKey')->label('App Key'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->label('ID'),
                TextColumn::make('title')->searchable()->label('Nome'),
                textColumn::make('client.name')->searchable()->label('Cliente'),
                textColumn::make('appId')->searchable()->label('App ID'),
                textColumn::make('appKey')->searchable()->label('App Key'),
                textColumn::make('created_at')->searchable()->label('Criado'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()->label('Excluir'),
//            Tables\Actions\ViewAction::make()->label('Ver')
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
            'index' => Pages\ListKeysApiModels::route('/'),
//            'create' => Pages\CreateKeysApiModel::route('/create'),
//            'edit' => Pages\EditKeysApiModel::route('/{record}/edit'),
        ];
    }
}
