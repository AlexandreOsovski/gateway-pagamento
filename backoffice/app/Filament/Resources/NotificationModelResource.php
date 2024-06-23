<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationModelResource\Pages;
use App\Filament\Resources\NotificationModelResource\RelationManagers;
use App\Models\NotificationModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotificationModelResource extends Resource
{
    protected static ?string $model = NotificationModel::class;
    protected static ?string $label = 'Notificações';
    protected static ?string $navigationIcon = 'fas-bell';

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
            'index' => Pages\ListNotificationModels::route('/'),
            'create' => Pages\CreateNotificationModel::route('/create'),
            'edit' => Pages\EditNotificationModel::route('/{record}/edit'),
        ];
    }
}
