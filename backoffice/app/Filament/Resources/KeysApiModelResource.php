<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeysApiModelResource\Pages;
use App\Filament\Resources\KeysApiModelResource\RelationManagers;
use App\Models\KeysApiModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeysApiModelResource extends Resource
{
    protected static ?string $model = KeysApiModel::class;
    protected static ?string $label = 'Chaves de API';
    protected static ?string $navigationIcon = 'fas-key';

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
            'index' => Pages\ListKeysApiModels::route('/'),
            'create' => Pages\CreateKeysApiModel::route('/create'),
            'edit' => Pages\EditKeysApiModel::route('/{record}/edit'),
        ];
    }
}
